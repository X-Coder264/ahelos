@extends('layouts.app')

@section('navigation')
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <ul class="nav navbar-nav">
            <li><a href="{{ url('/') }}"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Povratak na Ahelos početnu stranicu</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ url('/login') }}">Prijava</a></li>
            <li><a href="{{ url('/register') }}">Registracija</a></li>
        </ul>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Resetirajte lozinku</div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session('warning-resend'))
                    <div class="alert alert-warning">
                        {{ session('warning-resend') }}
                    </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}
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
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Pošalji link za promjenu lozinke
                                </button>
                            </div>
                        </div>
                        @if (session('warning-resend'))
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a class="btn btn-link" href="{{ url('/email-verification-resend') }}">Ponovno slanje aktivacijske poveznice</a>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
