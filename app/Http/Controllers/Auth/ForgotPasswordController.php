<?php

namespace Ahelos\Http\Controllers\Auth;

use Ahelos\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Ahelos\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Send a reset link to the given user.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => "E-mail je obavezno polje.",
            'email.email' => "E-mail mora sadržavati strukturu oblika primjer@mail.com.",
            'email.exists' => "Korisnik nije pronađen."
        ]);

        $user = User::where('email', $request->input('email'))->first(['verified', 'verification_token']);

        if ($user !== null && ! $user->isVerified()) {
            return back()->with('warning-resend', 'Vaš korisnički račun nije aktiviran. Aktivacijska poveznica poslana je na ' . $request->input('email') . '. Molimo aktivirajte Vaš korisnički račun pomoću dobivene aktivacijske poveznice. Ukoliko niste zaprimili aktivacijsku poveznicu kliknite na opciju "Ponovno slanje aktivacijse poveznice".');
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response === Password::RESET_LINK_SENT) {
            return back()->with('status', trans($response));
        }

        // If an error was returned by the password broker, we will get this message
        // translated so we can notify a user of the problem. We'll redirect back
        // to where the users came from so they can attempt this process again.
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }
}
