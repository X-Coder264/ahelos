@extends('layouts.app')

@section('navigation')
<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <ul class="nav navbar-nav">
        <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home" aria-hidden="true"></i>&nbsp;&nbsp;Ahelos početna stranica</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="{{ url('/login') }}"><i class="glyphicon glyphicon-log-in" aria-hidden="true"></i>&nbsp;&nbsp;Prijava</a></li>
        <li><a href="{{ url('/register') }}"><i class="glyphicon glyphicon-registration-mark" aria-hidden="true"></i>&nbsp;&nbsp;Registracija</a></li>
    </ul>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Prijava</div>
                <br>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <img src="/assets/images/logo.png" alt="Ahelos" width="230" height="92">
                            </div>
                        </div>
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                        @endif
                        @if (session('warning-resend'))
                        <div class="alert alert-warning">
                            {{ session('warning-resend') }}
                        </div>
                        @endif
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
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Zapamti moju prijavu
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button style="width: 100%" type="submit" class="btn btn-primary">
                                    Prijava
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <a class="btn-link" href="{{ url('/password/reset') }}">Zaboravili ste lozinku?</a><br>
                                <a class="btn-link" href="{{ url('/email-verification-resend') }}">Ponovno slanje aktivacijske poveznice</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
