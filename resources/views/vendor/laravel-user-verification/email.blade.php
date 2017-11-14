<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<?php
$style = [
    /* Layout ------------------------------ */

        'body' => 'margin: 0; padding: 0; width: 100%; background-color: #222327;',
        'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #222327;',

    /* Masthead ----------------------- */

        'email-masthead' => 'padding: 25px 0; text-align: center; border-bottom: 2px solid #DB5E47;',
        'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #DB5E47; text-transform: uppercase; text-decoration: none; text-shadow: 0 1px 0 white;',

        'email-body' => 'width: 100%; margin: 0; padding: 0; border-bottom: 2px solid #DB5E47; background-color: #222327;;',
        'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
        'email-body_cell' => 'padding: 35px;',

        'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
        'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;',

    /* Body ------------------------------ */

        'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
        'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',

    /* Type ------------------------------ */

        'anchor' => 'color: #DB5E47;',
        'anchor-footer' => 'color: #DB5E47; text-decoration: none;',
        'header-1' => 'margin-top: 0; color: #fff; font-size: 19px; font-weight: bold; text-align: left;',
        'paragraph' => 'margin-top: 0; color: #aaa; font-size: 16px; line-height: 1.5em;',
        'paragraph-sub' => 'margin-top: 0; color: #888; font-size: 12px; line-height: 1.5em;',
        'paragraph-sub-footer' => 'margin-top: 0; color: #fff; font-size: 12px; line-height: 1.5em;',
        'paragraph-center' => 'text-align: center;',

    /* Buttons ------------------------------ */

        'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #3869D4; border-radius: 3px; color: #fff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',
        'button--orange' => 'background-color: #DB5E47;',
];
$actionUrl=route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email);
?>
<?php $fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>
<body style="{{ $style['body'] }}">
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="{{ $style['email-wrapper'] }}" align="center">
            <table width="100%" cellpadding="0" cellspacing="0">
                <!-- Logo -->
                <tr>
                    <td style="{{ $style['email-masthead'] }}">
                        <a style="{{ $fontFamily }} {{ $style['email-masthead_name'] }}" href="{{ url('/') }}" target="_blank">
                            <img src="{{ url('/assets/images/logo.png') }}" alt="Ahelos d.o.o." width="300px" height="120px">
                        </a>
                    </td>
                </tr>
                <!-- Email Body -->
                <tr>
                    <td style="{{ $style['email-body'] }}" width="100%">
                        <table style="{{ $style['email-body_inner'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="{{ $fontFamily }} {{ $style['email-body_cell'] }}">
                                    <!-- Greeting -->
                                    <h1 style="{{ $style['header-1'] }}">Pozdrav {{ $user->name }} {{ $user->surname }},</h1>
                                    <!-- Intro -->
                                    <p style="{{ $style['paragraph'] }}">Zahvaljujemo se na Vašoj registraciji.
                                    </p>
                                    <p style="{{ $style['paragraph'] }}">Korisnički podaci:</p>
                                    <p style="{{ $style['paragraph'] }}">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ime i prezime: {{ $user->name }} {{ $user->surname }}<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-mail: {{ $user->email }}<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Naziv tvrtke: {{ $user->company }}<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OIB tvrtke: {{ $user->company_id }}<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Poštanski broj: {{ $user->post }}<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mjesto: {{ $user->place }}<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Adresa: {{ $user->address }}<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kontakt broj: {{ $user->phone }}
                                    </p>
                                    <hr>
                                    <p style="{{ $style['paragraph'] }}">Kliknite na gumb "Aktivacija korisničkog računa" kako bi aktivirali Vaš korisnički račun.</p>
                                    <!-- Action Button -->
                                    <table style="{{ $style['body_action'] }}" align="center" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center">
                                                <a href="{{ $actionUrl }}"
                                                   style="{{ $fontFamily }} {{ $style['button'] }} {{ $style['button--orange'] }}"
                                                   class="button"
                                                   target="_blank">
                                                    Aktivacija korisničkog računa
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- Outro -->
                                    <p style="{{ $style['paragraph'] }}">
                                        Molimo da provjerite valjanost unesenih informacija.<br>U slučaju pogrešnog unosa molimo da se u što kraćem roku obratite administratoru kako bi se Vaši korisnički podaci korigirali.
                                    </p>
                                    <!-- Salutation -->
                                    <p style="{{ $style['paragraph'] }}">
                                        Lijep pozdrav,<br>Vaš Ahelos tim<br>
                                    </p>
                                    <p style="{{ $style['paragraph'] }}">
                                        Ahelos d.o.o.<br>Zagrebačka 74<br>49243 Oroslavje<br>OIB: 06486394783<br><a style="{{ $style['anchor-footer'] }}" target="_blank" href="http://www.ahelos.hr">www.ahelos.hr</a>
                                    </p>
                                    <!-- Sub Copy -->
                                    <table style="{{ $style['body_sub'] }}">
                                        <tr>
                                            <td style="{{ $fontFamily }}">
                                                <p style="{{ $style['paragraph-sub'] }}">
                                                    Ako imate problem prilikom otvaranja poveznice klikom na gumb "Aktivacija korisničkog računa",
                                                    kopirajte i zalijepite sljedeću poveznicu unutar adresne trake Vašeg internet preglednika:
                                                </p>
                                                <p style="{{ $style['paragraph-sub'] }}">
                                                    <a style="{{ $style['anchor'] }}" href="{{ $actionUrl }}" target="_blank">
                                                        {{ $actionUrl }}
                                                    </a>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Footer -->
                <tr>
                    <td>
                        <table style="{{ $style['email-footer'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="{{ $fontFamily }} {{ $style['email-footer_cell'] }}">
                                    <p style="{{ $style['paragraph-sub-footer'] }}">
                                        &copy; {{ date('Y') }}
                                        <a style="{{ $style['anchor-footer'] }}" href="{{ url('/') }}" target="_blank">{{ config('app.name') }} d.o.o.</a>
                                        Sva prava pridržana.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>