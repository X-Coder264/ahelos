@extends('layouts.app')

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