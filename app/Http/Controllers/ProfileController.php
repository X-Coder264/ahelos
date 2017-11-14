<?php

namespace Ahelos\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ahelos\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);

        return view('profile', compact('user'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function changePassword(Request $request)
    {
        $input = $request->except(['_method', '_token']);

        $userData = [
            'old_password' => $input['old_password'],
            'password' => $input['password'],
            'password_confirmation' => $input['password_confirmation']
        ];

        $rules = [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ];

        $messages = [
            'old_password.required' => 'Morate unijeti trenutnu lozinku.',
            'password.required' => 'Morate unijeti novu lozinku.',
            'password.confirmed' => 'Vaše lozinke se ne podudaraju.',
            'password.min' => 'Vaša lozinka mora imati minimalno 6 znakova.'
        ];

        $validator = Validator::make($userData, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->getMessageBag()->toArray()]);
        } else {
            if (!Hash::check($input['old_password'], Auth::user()->password)) {
                return response()->json(['status' => 'error', 'errors' => [ 'password' => [0 => 'Netočan unos trenutne lozinke.']]]);
            } elseif ($input['old_password'] === $input['password']) {
                return response()->json(['status' => 'error', 'errors' => [ 'password' => [0 => "Vaša nova lozinka ne može biti jednaka trenutnoj."]]]);
            }

            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($input['password'], ['rounds' => 15]);
            $user->save();
            return response()->json(['status' => 'success']);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $input = $request->except(['_method', '_token', 'email', 'name', 'surname', 'company', 'company_id']);
        
            $userData = [
                'post' => $input['post'],
                'place' => $input['place'],
                'address' => $input['address'],
                'phone' => $input['phone'],
            ];

            $rules = [
                'post' => 'required|max:255',
                'place' => 'required|max:255',
                'address' => 'required|max:255',
                'phone' => 'required|max:255',
            ];

            $messages = [
                'post.required' => 'Morate unijeti poštanski broj',
                'post.max' => 'Unijeli ste previše znakova za poštanski broj',
                'address.required' => 'Morate unijeti adresu',
                'address.max' => 'Unijeli ste previše znakova za adresu',
                'phone.required' => 'Morate unijeti kontakt broj',
                'phone.max' => 'Unijeli ste previše znakova za kontakt broj',
            ];


        $validator = Validator::make($userData, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->getMessageBag()->toArray()]);
        } else {
            $user = User::find($id);

            $user->update($input);
            
            return response()->json(['status' => 'success']);
        }
    }
}
