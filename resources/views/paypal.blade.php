@extends('layouts.app')


@section('navigation')
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <ul class="nav navbar-nav">
            <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>&nbsp;&nbsp;Lista narudžbi</a></li>
            <li><a href="{{ url('/new-order') }}"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i>&nbsp;&nbsp;Nova narudžba</a></li>
            <li><a href="{{ url('/add-printer') }}"><i class="glyphicon glyphicon-print" aria-hidden="true"></i>&nbsp;&nbsp;Dodaj printer</a></li>
            @if(Auth::user()->admin)
                <li><a href="{{ url('/admin') }}"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>&nbsp;&nbsp;Admin Panel</a></li>
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} {{Auth::user()->surname}}<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home" aria-hidden="true"></i>&nbsp;&nbsp;Ahelos početna stranica</a></li>
                    <li><a href="{{ url('/profile') }}"><i class="glyphicon glyphicon-user" aria-hidden="true"></i>&nbsp;&nbsp;Profil</a></li>
                    <li><a href="{{ url('/settings') }}"><i class="glyphicon glyphicon-cog" aria-hidden="true"></i>&nbsp;&nbsp;Postavke</a></li>
                    <li class="active"><a href="{{ route('donate-with-paypal') }}"><i class="glyphicon glyphicon-usd" aria-hidden="true"></i>&nbsp;&nbsp;Donacije</a></li>
                    <li><a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="glyphicon glyphicon-log-out" aria-hidden="true"></i>&nbsp;&nbsp;Odjava</a><form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form></li>
                </ul>
            </li>
        </ul>
    </div>
@endsection

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-8 col-md-offset-2">

                @if(session('success'))

                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>

                @endif

                @if(session('error'))

                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>

                @endif

                <div class="panel panel-default">

                    <div class="panel-heading">Donacije (PayPal)</div>

                    <div class="panel-body">

                        <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{ route('donate') }}" >

                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">

                                <label for="amount" class="col-md-4 control-label">Iznos (EUR)</label>

                                <div class="col-md-6">

                                    <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}" autofocus>

                                    @if($errors->has('amount'))

                                        <span class="help-block">

                                        <strong>{{ $errors->first('amount') }}</strong>

                                    </span>

                                    @endif

                                </div>

                            </div>



                            <div class="form-group">

                                <div class="col-md-6 col-md-offset-4">

                                    <button type="submit" class="btn btn-primary">

                                        Doniraj (PayPal)

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