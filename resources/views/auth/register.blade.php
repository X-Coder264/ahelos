@extends('layouts.app')

@section('scripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('navigation')
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <ul class="nav navbar-nav">
            <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home" aria-hidden="true"></i>&nbsp;&nbsp;Ahelos početna stranica</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ url('/login') }}"><i class="glyphicon glyphicon-log-in" aria-hidden="true"></i>&nbsp;&nbsp;Prijava</a></li>
            <li class="active"><a href="{{ url('/register') }}"><i class="glyphicon glyphicon-registration-mark" aria-hidden="true"></i>&nbsp;&nbsp;Registracija</a></li>
        </ul>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registracija</div>
                <div class="panel-body">
                    <div class="alert alert-info" role="alert">Obavezno ispuniti sva polja unutar forme!</div>
                    <form class="form-horizontal" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Ime</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                            <label for="surname" class="col-md-4 control-label">Prezime</label>
                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required>
                                @if ($errors->has('surname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('surname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-mail</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="company" class="col-md-4 control-label">Naziv tvrtke</label>
                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}" required>
                                @if ($errors->has('company'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('company') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                            <label for="company_id" class="col-md-4 control-label">OIB tvrtke</label>
                            <div class="col-md-6">
                                <input id="company_id" type="text" class="form-control" name="company_id" value="{{ old('company_id') }}" required>
                                @if ($errors->has('company_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('company_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }}">
                            <label for="post" class="col-md-4 control-label">Poštanski broj</label>
                            <div class="col-md-6">
                                <input id="post" type="text" class="form-control" name="post" value="{{ old('post') }}" required>
                                @if ($errors->has('post'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('post') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('place') ? ' has-error' : '' }}">
                            <label for="place" class="col-md-4 control-label">Mjesto</label>
                            <div class="col-md-6">
                                <input id="place" type="text" class="form-control" name="place" value="{{ old('place') }}" required>
                                @if ($errors->has('place'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('place') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Adresa</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                                @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Kontakt broj</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8 col-md-offset-4"><p class="text-info">Lozinka mora sadržavati minimalno 6 znakova</p></div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Lozinka</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Ponovite lozinku</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="g-recaptcha" data-theme="dark" data-sitekey="6LeQBQkUAAAAAALuIQVKFde-LJDXCwKir_01UiGR"></div>
                                @if ($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                                <br>
                                <button style="width: 100%" type="submit" class="btn btn-primary">
                                    Registracija
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection