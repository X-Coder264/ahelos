<?php

namespace Ahelos\Http\Controllers\Auth;

use Ahelos\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ReCaptcha\ReCaptcha;
use Illuminate\Support\Facades\Validator;
use Ahelos\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;
use Jrean\UserVerification\Exceptions\TokenMismatchException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    use VerifiesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getVerification', 'getVerificationError']]);
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'company' => 'required|max:255',
            'company_id' => 'required|max:255',
            'post' => 'required|max:255',
            'place' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|max:100|confirmed',
            'g-recaptcha-response'  => 'required'
        ];

        $messages = [
            'name.required' => "Ime je obavezno polje.",
            'name.max' => "Ime smije sadržavati maksimalno 255 znakova.",
            'surname.required' => "Prezime je obavezno polje.",
            'surname.max' => "Prezime smije sadržavati maksimalno 255 znakova.",
            'company.required' => "Naziv tvrtke je obavezno polje.",
            'company.max' => "Naziv tvrtke smije sadržavati maksimalno 255 znakova.",
            'company_id.required' => "OIB tvrtke je obavezno polje.",
            'company_id.max' => "OIB tvrtke smije sadržavati maksimalno 255 znakova.",
            'post.required' => "Poštanski broj je obavezno polje.",
            'post.max' => "Poštanski broj smije sadržavati maksimalno 255 znakova.",
            'place.required' => "Mjesto je obavezno polje.",
            'place.max' => "Mjesto smije sadržavati maksimalno 255 znakova.",
            'address.required' => "Adresa je obavezno polje.",
            'address.max' => "Adresa smije sadržavati maksimalno 255 znakova.",
            'phone.required' => "Kontakt broj je obavezno polje.",
            'phone.max' => "Kontakt broj smije sadržavati maksimalno 255 znakova.",
            'email.required' => "E-mail je obavezno polje.",
            'email.email' => "E-mail mora sadržavati strukturu oblika primjer@mail.com.",
            'email.max' => "E-mail smije sadržavati maksimalno 255 znakova.",
            'email.unique' => "E-mail adresa već postoji u sustavu.",
            'password.required' => "Lozinka je obavezno polje.",
            'password.min' => "Lozinka mora sadržavati minimalno 6 znakova.",
            'password.max' => "Lozinka smije sadržavati maksimalno 100 znakova.",
            'password.confirmed' => "Lozinke se ne podudaraju.",
            'g-recaptcha-response.required' => "Google Captcha je obavezna."
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'company' => $data['company'],
            'company_id' => $data['company_id'],
            'post' => $data['post'],
            'place' => $data['place'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'], ['rounds' => 15]),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  Request $request
     * @return Response|RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if ($this->captchaCheck($request) === false) {
            return redirect()->back()
                ->withErrors('Google Captcha je neispravna.')
                ->withInput();
        }

        event(new Registered($user = $this->create($request->all())));

        if ($user->id === 1) {
            $user->admin = true;
            $user->save();
        }

        UserVerification::generate($user);
        UserVerification::send($user, 'Aktivacija korisničkog računa', 'noreply@ahelos.hr', 'Ahelos');

        return redirect($this->redirectPath())->with('warning', 'Poslana je aktivacijska poveznica na ' . $user->email . '. Kliknite na dobivenu poveznicu kako biste aktivirali Vaš korisnički račun.');
    }

    /**
     * Handle the user verification.
     *
     * @param Request $request
     * @param  string $token
     * @return Response
     */
    public function getVerification(Request $request, $token)
    {
        $this->validateRequest($request);

        try {
            UserVerification::process($request->input('email'), $token, $this->userTable());
        } catch (UserNotFoundException $e) {
            return redirect($this->redirectIfVerificationFails());
        } catch (UserIsVerifiedException $e) {
            return redirect($this->redirectIfVerified());
        } catch (TokenMismatchException $e) {
            return redirect($this->redirectIfVerificationFails());
        }

        return redirect($this->redirectAfterVerification())->with('success', 'Vaš korisnički račun uspješno je aktiviran. Prijavite se u sustav.');
    }
}
