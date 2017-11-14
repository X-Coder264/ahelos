@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Dodaj korisnika
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/wizard.css') }}" rel="stylesheet">
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Dodaj novog korisnika</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Admin Panel
                </a>
            </li>
            <li><a href="#"> Korisnici</a></li>
            <li class="active">Dodaj novog korisnika</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            Dodaj novog korisnika
                        </h3>
                                <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
                    </div>
                    <div class="panel-body">
                        <!--main content-->
                        <form id="commentForm" action="{{ route('admin.users.create') }}"
                              method="POST" class="form-horizontal">
                            <!-- CSRF Token -->
                            {{ csrf_field() }}

                            <div id="rootwizard">
                                <ul>
                                    <li><a href="#tab1" data-toggle="tab">Korisnički profil</a></li>
                                    <li><a href="#tab2" data-toggle="tab">Adresa</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane" id="tab1">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                                            <label for="name" class="col-sm-2 control-label">Ime *</label>
                                            <div class="col-sm-10">
                                                <input id="name" name="name" type="text"
                                                       placeholder="Ime" class="form-control required" value="{!! old('name') !!}" required>

                                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('surname', 'has-error') }}">
                                            <label for="surname" class="col-sm-2 control-label">Prezime *</label>
                                            <div class="col-sm-10">
                                                <input id="surname" name="surname" type="text" placeholder="Prezime"
                                                       class="form-control required" value="{!! old('surname') !!}" required>

                                                {!! $errors->first('surname', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                            <label for="email" class="col-sm-2 control-label">E-mail *</label>
                                            <div class="col-sm-10">
                                                <input id="email" name="email" placeholder="E-mail" type="text"
                                                       class="form-control required email" value="{!! old('email') !!}" required>
                                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                            <label for="password" class="col-sm-2 control-label">Lozinka *</label>
                                            <div class="col-sm-10">
                                                <input id="password" name="password" type="password" placeholder="Lozinka"
                                                       class="form-control required" value="{!! old('password') !!}" required>
                                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                                            <label for="password_confirm" class="col-sm-2 control-label">Ponovi lozinku *</label>
                                            <div class="col-sm-10">
                                                <input id="password_confirm" name="password_confirm" type="password"
                                                       placeholder="Ponovi lozinku" class="form-control required"
                                                       value="{!! old('password_confirm') !!}" required>
                                                {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2" disabled="disabled">

                                        <div class="form-group">
                                            <label for="company" class="col-sm-2 control-label">Tvrtka</label>
                                            <div class="col-sm-10">
                                                <input id="company" name="company" type="text" class="form-control" placeholder="Tvrtka"
                                                       value="{!! old('company') !!}" required>
                                            </div>
                                            <span class="help-block">{{ $errors->first('company', ':message') }}</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="company_id" class="col-sm-2 control-label">OIB tvrtke</label>
                                            <div class="col-sm-10">
                                                <input id="company_id" name="company_id" type="text" class="form-control" placeholder="OIB tvrtke"
                                                       value="{!! old('company_id') !!}" required>
                                            </div>
                                            <span class="help-block">{{ $errors->first('company_id', ':message') }}</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="phone" class="col-sm-2 control-label">Telefon</label>
                                            <div class="col-sm-10">
                                                <input id="phone" name="state" type="text" class="form-control" placeholder="Telefon"
                                                       value="{!! old('phone') !!}"/>
                                            </div>
                                            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="place" class="col-sm-2 control-label">Mjesto</label>
                                            <div class="col-sm-10">
                                                <input id="place" name="place" type="text" class="form-control" placeholder="Mjesto"
                                                       value="{!! old('place') !!}"/>
                                            </div>
                                            <span class="help-block">{{ $errors->first('place', ':message') }}</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="address" class="col-sm-2 control-label">Adresa</label>
                                            <div class="col-sm-10">
                                                <input id="address" name="address" type="text" class="form-control" placeholder="Adresa"
                                                       value="{!! old('address') !!}"/>
                                            </div>
                                            <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="post" class="col-sm-2 control-label">Poštanski broj</label>
                                            <div class="col-sm-10">
                                                <input id="post" name="post" type="text" class="form-control" placeholder="Poštanski broj"
                                                       value="{!! old('post') !!}" required>
                                            </div>
                                            <span class="help-block">{{ $errors->first('post', ':message') }}</span>
                                        </div>
                                    </div>
                                    <ul class="pager wizard">
                                        <li class="previous"><a href="#">Nazad</a></li>
                                        <li class="next"><a href="#">Naprijed</a></li>
                                        <li class="next finish" style="display:none;"><a href="javascript:;">Kraj</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--row end-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/adduser.js') }}"></script>
@stop
