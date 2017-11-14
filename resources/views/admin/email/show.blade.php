@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Lista e-mailova
    @parent
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>E-mailovi</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    Admin Panel
                </a>
            </li>
            <li><a href="#"> E-mailovi</a></li>
            <li class="active">Lista e-mailova</li>
        </ol>
    </section>

    <!-- Main content -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">Upit</div>
                    <div class="panel-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.email.answer', $email->id) }}" id="edit_profile">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Naslov</label>

                                <div class="col-md-6">
                                    <input id="subject" type="text" class="form-control" name="subject" value="{{ $email->subject }}" disabled>

                                    @if ($errors->has('subject'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('subject') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('sender_name') ? ' has-error' : '' }}">
                                <label for="surname" class="col-md-4 control-label">Ime pošiljatelja</label>

                                <div class="col-md-6">
                                    <input id="sender_name" type="text" class="form-control" name="sender_name" value="{{ $email->sender_name }}" disabled>

                                    @if ($errors->has('sender_name'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('sender_name') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('sender_email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-mail pošiljatelja</label>

                                <div class="col-md-6">
                                    <input id="sender_email" type="email" class="form-control" name="sender_email" value="{{ $email->sender_email }}" disabled>

                                    @if ($errors->has('sender_email'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('sender_email') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                <label for="company" class="col-md-4 control-label">Upit</label>

                                <div class="col-md-6">
                                    <textarea id="message" class="form-control" name="message" disabled>{{ $email->message }}</textarea>

                                    @if ($errors->has('message'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('message') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="company" class="col-md-4 control-label">Upit poslan</label>

                                <div class="col-md-6">
                                    <?php \Carbon\Carbon::setLocale('hr'); ?>
                                    <input id="created_at" type="email" class="form-control" name="created_at" value="{{ $email->created_at->format('d.m.Y. H:i:s') . " (" . $email->created_at->diffForHumans() . ")" }}" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="company" class="col-md-4 control-label">Status</label>

                                <div class="col-md-6">
                                    <input id="status" type="email" class="form-control" name="created_at" value="{{ $email->status }}" disabled>
                                </div>
                            </div>

                            <br>


                            @if($email->status === 'Nije odgovoreno')
                                <textarea id="answer" class="form-control" name="answer"></textarea>

                                <br>

                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary" id="submit">Pošalji odgovor</button>
                                    </div>
                                </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

@stop
