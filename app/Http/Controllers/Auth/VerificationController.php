<?php

namespace Ahelos\Http\Controllers\Auth;

use Ahelos\User;
use Ahelos\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Jrean\UserVerification\Facades\UserVerification;

class VerificationController extends Controller
{

    use RedirectsUsers;

    /**
     * Where to redirect users after verification resend.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return Response
     */
    public function getResendForm()
    {
        return view('auth.verification.email');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'email' => 'required|email|max:255|exists:users,email',
        ];

        $messages = [
            'email.required' => "E-mail je obavezno polje.",
            'email.email' => "E-mail mora sadržavati strukturu oblika primjer@mail.com.",
            'email.max' => "E-mail smije sadržavati maksimalno 255 znakova.",
            'email.exists' => "Korisnik nije pronađen.",
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function resend(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = User::where('email', $request->input('email'))->first();

        if ($user->isVerified()) {
            return redirect('/login')->with('success', 'Vaš korisnički račun je već aktiviran. Prijavite se u sustav');
        }
        
        UserVerification::generate($user);
        UserVerification::send($user, 'Aktivacija korisničkog računa', 'noreply@ahelos.hr', 'Ahelos');

        return redirect($this->redirectPath())->with('warning', 'Poslana je aktivacijska poveznica na ' . $user['email'] . '. Kliknite na dobivenu poveznicu kako biste aktivirali Vaš korisnički račun.');
    }
}
