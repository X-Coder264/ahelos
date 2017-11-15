@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="/assets/css/sweetalert.css">
@endsection

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
                <li class="active"><a href="{{ url('/settings') }}"><i class="glyphicon glyphicon-cog" aria-hidden="true"></i>&nbsp;&nbsp;Postavke</a></li>
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
            <div class="panel panel-default">
                <div class="panel-heading">Promijenite lozinku</div>
                <div class="panel-body">
                    <form class="form-horizontal" id="edit-password" method="POST" action="{{ url('/settings/profile/change-password/' . \Auth::user()->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="old_password" class="col-md-4 control-label">Trenutna lozinka</label>
                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control" name="old_password" required>
                                @if ($errors->has('old_password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Nova lozinka</label>
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
                        <br>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button style="width: 100%" type="submit" class="btn btn-success">Promijeni lozinku</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="/assets/js/sweetalert.min.js"></script>
<script>
    jQuery(document).ready(function($){
        $("form#edit-password").submit(function( event ) {
            event.preventDefault();
            $("#submit").html('<span class="icon-refresh spinning"></span> Spremanje...');
            $("#submit").prop('disabled', true);
            var formData = new FormData(this);
            var token = $('#edit-password > input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: $("#edit-password").attr('action'),
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': token},
                data: formData,
                error: function(){
                    console.log("error");
                    console.log(token);
                    console.log(formData);
                    $("#submit").html('Promijeni lozinku');
                    $("#submit").prop('disabled', false);
                },
                success: function(data) {
                    console.log("success");
                    console.log(data);
                    //console.log(formData);
                    if(data.status === "success") {
                        swal("Dovršeno!", "Vaša lozinka uspješno je promijenjena!", "success");
                    }
                    else
                    {
                        var failStart = "";
                        $.each(data.errors, function(index, value) {
                            $.each(value,function(i){
                                failStart += value[i]+"\n";
                            });

                        });
                        //console.log(failStart);
                        swal("Došlo je do pogreške prilikom izmjene lozinke! Popravite sljedeće pogreške:", failStart, "error");
                    }
                    $("#submit").html('Promijeni lozinku');
                    $("#submit").prop('disabled', false);
                }
            });
        });
        $(document).on("click", '.confirm' ,function(){
            location.reload(true);
        });
    });
</script>
@endsection

