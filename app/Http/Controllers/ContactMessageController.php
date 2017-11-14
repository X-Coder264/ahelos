<?php

namespace Ahelos\Http\Controllers;

use Ahelos\Mail\ContactMessageAnswer;
use Ahelos\Mail\ContactMessageReceived;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Ahelos\ContactMessage;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use ReCaptcha\ReCaptcha;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ContactMessageController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        return view('admin.email.index');
    }

    /**
     * @param ContactMessage $email
     * @return Response
     */
    public function show(ContactMessage $email)
    {
        if ($email->status) {
            $email->status = "Odgovoreno";
        } else {
            $email->status = "Nije odgovoreno";
        }
        return view('admin.email.show', compact('email'));
    }

    public function getAllEmails()
    {
        $emails = ContactMessage::all();

        return DataTables::of($emails)
            ->editColumn('created_at', function(ContactMessage $email) {
                Carbon::setLocale('hr');
                return $email->created_at->format('d.m.Y. H:i:s') . " (" . $email->created_at->diffForHumans() . ")";
            })->editColumn('updated_at', function(ContactMessage $email) {
                Carbon::setLocale('hr');
                return $email->updated_at->format('d.m.Y. H:i:s') . " (" . $email->updated_at->diffForHumans() . ")";
            })
            ->editColumn('status', function(ContactMessage $email) {
                if ($email->status === 0) {
                    return "Neodgovoreno";
                } else {
                    return "Odgovoreno";
                }
            })
            ->addColumn('actions', function(ContactMessage $email) {
                if ($email->status === 0) {
                    $actions = '<a href='. route('admin.email.answer', ['email' => $email]) .'><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428bca" title="Pregledaj narudžbu"></i></a>';
                } else {
                    $actions = "";
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function captchaCheck(Request $request): bool
    {
        $response = $request->input('g-recaptcha-response');
        $remoteIp = $_SERVER['REMOTE_ADDR'];
        $secret = env('RE_CAP_SECRET');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteIp);
        if ($resp->isSuccess()) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param Request $request
     * @return $this|JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'sender_name' => 'required|max:255|min:3',
            'sender_email' => 'required|email',
            'subject' => 'required|max:255|min:3',
            'message' => 'required|min:5',
            'g-recaptcha-response'  => 'required'
        ];

        $messages = [
            'sender_name.required' => 'Vaše ime je obavezno.',
            'sender_name.min' => 'Vaše ime mora sadržavati barem 3 slova.',
            'sender_name.max' => 'Vaše ime smije sadržavati najviše 255 slova.',
            'sender_email.required' => 'Vaša e-mail adresa je obavezna.',
            'sender_email.email' => 'Morate unijeti ispravnu e-mail adresu.',
            'subject.required' => 'Naslov poruke je obavezan.',
            'subject.min' => 'Naslov poruke mora sadržavati barem 3 slova.',
            'subject.max' => 'Naslov poruke smije sadržavati najviše 255 slova.',
            'message.required' => 'Poruka je obavezna.',
            'message.min' => 'Vaša poruka mora sadržavati barem 5 slova.',
            'g-recaptcha-response.required' => 'Google Recaptcha je obavezna.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->getMessageBag()->toArray()]);
        }

        if ($this->captchaCheck($request) === false) {
            return redirect()->back()
                ->withErrors(['Wrong Captcha'])
                ->withInput();
        }

        $message = ContactMessage::create($request->except(["_token", "g-recaptcha-response"]));

        Mail::to('info@ahelos.hr')->send(new ContactMessageReceived($message));

        return response()->json(['status' => 'success']);
    }

    /**
     * @param Request $request
     * @param ContactMessage $email
     * @return RedirectResponse
     */
    public function sendAnswer(Request $request, ContactMessage $email)
    {
        if ($request->has('answer') && $request->input('answer') != "") {
            Mail::to($email->sender_email)->send(new ContactMessageAnswer($request->input('answer')));
            $email->status = true;
            $email->save();
            Cache::forget('unanswered_contact_messages_count');
            return back()->with('success', 'Uspješno odgovoreno.');
        }
    }
}
