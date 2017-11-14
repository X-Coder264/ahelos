<?php

namespace Ahelos\Http\Controllers\Auth;

use Ahelos\User;
use Ahelos\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request|Request $request
     * @return RedirectResponse|Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        $user = User::where('email', $credentials['email'])->first(['verified', 'verification_token']);

        if ($user !== null && ! $user->isVerified()) {
            return back()->with('warning-resend', 'Vaš korisnički račun nije aktiviran. Aktivacijska poveznica Vam je bila poslana na ' . $credentials['email'] . '. Molimo aktivirajte Vaš korisnički račun pomoću dobivene aktivacijske poveznice. Ukoliko niste zaprimili aktivacijsku poveznicu kliknite na opciju "Ponovno slanje aktivacijske poveznice".');
        }

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|email', 'password' => 'required',
        ], [
            'email.required' => "E-mail je obavezno polje.",
            'email.email' => "E-mail mora sadržavati strukturu oblika primjer@mail.com.",
            'password.required' => "Lozinka je obavezno polje.",
        ]);
    }
}
