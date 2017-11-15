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
                <li><a href="{{ route('donate-with-paypal') }}"><i class="glyphicon glyphicon-usd" aria-hidden="true"></i>&nbsp;&nbsp;Donacije</a></li>
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
            <div class="panel panel-default">
                <div class="panel-heading">Tinte/toneri za printer {{ $printer->name }}</div>
                <div class="panel-body flip-scroll">
                @if(count($printer->inks))
                    <table class="table table-bordered table-hover flip-content">
                        <tbody>
                        @foreach($printer->inks as $ink)
                            <tr>
                                <td>
                                    <span>{{ $ink->name }}</span>
                                    <span class="pull-right">
                                        <form class="form-horizontal" method="POST" action="{{ url('/add-printer/printer/' . $printer->id .'/delete-ink/' . $ink->id) }}">
                                        {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger pull-right">Izbriši</button>
                                        </form>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <span class="text-info">Trenutno nemate dodanih tonera/tinti.</span>
                @endif
                </div>
                <div class="panel-footer">
                    <p class="text-info">Molimo unesite oznaku tonera/tinte te boju koju označava</p>
                    <form method="POST" action="{{ url('/add-printer/printer/' . $printer->id . '/add-ink')  }}">
                        {{ csrf_field() }}
                        <input type="text" placeholder="npr. 512BK - Crna" class="form-control" name="ink"><br>
                        <a class="btn btn-danger" href="{{ url('/add-printer') }}"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Povratak</a>
                        <button type="submit" class="btn btn-success pull-right">Potvrdi unos</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection