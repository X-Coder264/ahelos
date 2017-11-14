@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Uredi korisnika
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/css/awesome-bootstrap-checkbox.css') }}" rel="stylesheet"/>
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Uredi korisnika</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Admin Panel
                </a>
            </li>
            <li>Korisnici</li>
            <li class="active">Uredi korisnika</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
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
                    <div class="panel-heading">
                        <h3 class="panel-title"> <i class="livicon" data-name="users" data-size="16" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            Uredi korisnika <strong>{{ $user->name }} {{ $user->surname }}</strong>
                        </h3>
                    <span class="pull-right clickable">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                    </div>
                    <div class="panel-body">
                        <!--main content-->
                        <div class="row">

                            <div class="col-md-12">
                                <form id="wizard-validation" action="{{ route('admin.users.update', $user) }}"
                                      method="POST" class="form-horizontal">
                                    {{ method_field('PATCH') }}
                                    {{ csrf_field() }}

                                                <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                                    <label for="name" class="col-sm-2 control-label">Ime *</label>
                                                    <div class="col-sm-10">
                                                        <input id="name" name="name" type="text"
                                                               placeholder="Ime" class="form-control required"
                                                               value="{!! old('name', $user->name) !!}" required>
                                                    </div>
                                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('surname', 'has-error') }}">
                                                    <label for="surname" class="col-sm-2 control-label">Prezime *</label>
                                                    <div class="col-sm-10">
                                                        <input id="surname" name="surname" type="text" placeholder="Prezime"
                                                               class="form-control required"
                                                               value="{!! old('surname', $user->surname) !!}" required>
                                                    </div>
                                                    {!! $errors->first('surname', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                                    <label for="email" class="col-sm-2 control-label">E-mail *</label>
                                                    <div class="col-sm-10">
                                                        <input id="email" name="email" placeholder="E-mail" type="text"
                                                               class="form-control required email"
                                                               value="{!! old('email', $user->email) !!}" required>
                                                    </div>
                                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('phone', 'has-error') }}">
                                                    <label for="phone" class="col-sm-2 control-label">Telefon</label>
                                                    <div class="col-sm-10">
                                                        <input id="phone" name="phone" type="text" class="form-control" placeholder="Telefon"
                                                               value="{!! old('post', $user->phone) !!}" required>
                                                    </div>
                                                    {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('company', 'has-error') }}">
                                                    <label for="company" class="col-sm-2 control-label">Tvrtka</label>
                                                    <div class="col-sm-10">
                                                        <input id="company" name="company" type="text" class="form-control" placeholder="Tvrtka"
                                                               value="{!! old('company', $user->company) !!}" required>
                                                    </div>
                                                    {!! $errors->first('company', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('company_id', 'has-error') }}">
                                                    <label for="company_id" class="col-sm-2 control-label">OIB tvrtke</label>
                                                    <div class="col-sm-10">
                                                        <input id="company_id" name="company_id" type="text" class="form-control" placeholder="OIB tvrtke"
                                                               value="{!! old('company_id', $user->company_id) !!}" required>
                                                    </div>
                                                    {!! $errors->first('company_id', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('place', 'has-error') }}">
                                                    <label for="place" class="col-sm-2 control-label">Mjesto</label>
                                                    <div class="col-sm-10">
                                                        <input id="place" name="place" type="text" class="form-control" placeholder="Mjesto"
                                                               value="{!! old('place', $user->place) !!}" required>
                                                    </div>
                                                    {!! $errors->first('place', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('address', 'has-error') }}">
                                                    <label for="address" class="col-sm-2 control-label">Adresa</label>
                                                    <div class="col-sm-10">
                                                        <input id="address" name="address" type="text" class="form-control" placeholder="Adresa"
                                                               value="{!! old('address', $user->address) !!}" required>
                                                    </div>
                                                    {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
                                                </div>

                                                <div class="form-group {{ $errors->first('post', 'has-error') }}">
                                                    <label for="post" class="col-sm-2 control-label">Poštanski broj</label>
                                                    <div class="col-sm-10">
                                                        <input id="post" name="post" type="text" class="form-control" placeholder="Poštanski broj"
                                                               value="{!! old('post', $user->post) !!}" required>
                                                    </div>
                                                    {!! $errors->first('post', '<span class="help-block">:message</span>') !!}
                                                </div>

                                    @if(Auth::user()->id !== $user->id)
                                    <div class="form-group checkbox checkbox-primary">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <input id="admin" name="admin" type="checkbox" class="form-control" @if($user->admin) checked @endif>
                                            <label for="admin">Administrator</label>
                                        </div>
                                    </div>
                                    <br>
                                    @endif
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Spremi promjene
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--main content end-->
                    </div>
                </div>
            </div>
        </div>
        <!--row end-->
        @if(count($user->printers))
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"> <i class="livicon" data-name="users" data-size="16" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            Uredi printere korisnika <strong>{{ $user->name}} {{ $user->surname}}</strong>
                        </h3>
                    <span class="pull-right clickable">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                    </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Printer</th>
                                        <th>Opcije</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->printers as $printer)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/printer/rename/' . $printer->id) }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                    <div class="col-md-8">
                                                        <input class="form-control" value="{{$printer->name}}" name="printer">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-warning btn-md pull-right">Preimenuj</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>
                                                @if($printer->trashed())
                                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/printer/restore/' . $printer->id) }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('PATCH') }}
                                                        <button type="submit" class="btn btn-success btn-md pull-right">Aktiviraj</button>
                                                    </form>
                                                    @else
                                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/profile/printer/delete/' . $printer->id) }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-danger btn-md pull-right">Deaktiviraj</button>
                                                    </form>
                                                    @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
        </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"> <i class="livicon" data-name="printer" data-size="16" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                                Dodaj printer korisniku <strong>{{ $user->name}} {{ $user->surname}}</strong>
                            </h3></div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/settings/printer/store/' . $user->id) }}" id="store_printer">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="printer" class="col-md-4 control-label">Printer (proizvođač i model)</label>

                                    <div class="col-md-6">
                                        <input id="printer" type="text" class="form-control" name="name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block" id="submit">
                                            Dodaj printer
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"> <i class="livicon" data-name="printer" data-size="16" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                                <strong>Ovaj korisnik nema niti jedan printer.</strong>
                            </h3></div>
                                        <div class="panel-body">
                                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/settings/printer/store/' . $user->id) }}" id="store_printer">
                                                {{ csrf_field() }}

                                                <div class="form-group{{ $errors->has('printer') ? ' has-error' : '' }}">
                                                    <label for="printer" class="col-md-4 control-label">Printer (proizvođač i model)</label>

                                                    <div class="col-md-6">
                                                        <input id="printer" type="text" class="form-control" name="name" required>

                                                        @if ($errors->has('printer'))
                                                            <span class="help-block">
                                        <strong>{{ $errors->first('printer') }}</strong>
                                    </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary btn-block" id="submit">
                                                            Dodaj printer
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                        </div>
                    </div>
            </div>
            @endif
    </section>
@stop
