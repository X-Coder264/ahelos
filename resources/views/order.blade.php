@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="/assets/css/sweetalert2.min.css">
@endsection

@section('navigation')
<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <ul class="nav navbar-nav">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>&nbsp;&nbsp;Lista narudžbi</a></li>
        <li class="active"><a href="{{ url('/new-order') }}"><i class="glyphicon glyphicon-plus" aria-hidden="true"></i>&nbsp;&nbsp;Nova narudžba</a></li>
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
        <div class="col-md-12">
            <form method="POST" action="/new-order/store" id="new_order">
                {{ csrf_field() }}
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">&nbsp;
                        <span class="panel-title pull-left">Nova narudžba</span>
                        <div class="btn-group pull-right">
                            <span class="btn btn-default btn-md" id="addBtn">Dodaj polje</span>
                        </div>
                    </div>
                    <div class="panel-body flip-scroll">
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
                        <table class="table table-bordered table-hover flip-content">
                            <thead>
                                <tr>
                                    <th style="width:40%;">Printer</th>
                                    <th style="width:40%;">Toner/tinta</th>
                                    <th style="width:10%;">Količina</th>
                                    <th style="width:10%;">Opcije</th>
                                </tr>
                            </thead>
                            <tbody id="products">
                                <tr>
                                    <td>
                                        <select class="printer_select form-control" id="printer0" name="order[0][printer_id]">
                                            <option selected="selected" disabled>Odaberi printer</option>
                                            @foreach($user->printers as $printer)
                                            <option value="{{ $printer->id }}">{{ $printer->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="colors_select form-control" id="inks0" name="order[0][ink_id]">
                                            <option selected="selected" disabled>Prvo odaberite printer</option>
                                        </select>
                                    </td>
                                    <td><input type="number" name="order[0][quantity]" id="quantity" class="form-control" min="1" value="1" required></td>
                                    <td><span class="btn btn-danger btn-md center-block" id="removeBtn">Izbriši</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">&nbsp;
                        <div class="form-group">
                            <label for="comment">Napomena:</label>
                            <textarea style="resize:vertical;" name="remark" class="form-control" rows="4" id="remark"></textarea>
                        </div>
                        <a class="btn btn-danger" href="{{ url('/home') }}">Odustani</a>
                        <input type="submit" id="submit" class="btn btn-success pull-right" value="Predaj narudžbu">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="/assets/js/sweetalert2.min.js"></script>
<script>
    x = 1;
    $(document).ready(function(){

        $("#addBtn").click(function(){
            $("#products").append('<tr><td><select class="printer_select form-control" id="printer' + x + '" name="order[' + x + '][printer_id]"><option selected="selected" disabled>Odaberi printer </option>@foreach($user->printers as $printer) <option value="{{ $printer->id }}">{{ $printer->name }}</option> @endforeach ' + '</select></td><td><select class="colors_select form-control" id="inks' + x + '"name="order[' + x + '][ink_id]"> <option selected="selected" disabled>Odaberi prvo printer</option></select></td><td><input type="number" name="order[' + x++ + '][quantity]" id="quantity" class="form-control" min="1" value="1" required></td><td><span class="btn btn-danger btn-md center-block" id="removeBtn">Izbriši</span></td></tr>');
        });
        $("#products").on('click','#removeBtn',function(){
            $(this).parent().parent().remove();
        });

        $("form#new_order").submit(function( event ) {
            event.preventDefault();
            $("#submit").html('<span class="icon-refresh spinning"></span> Spremanje...');
            $("#submit").prop('disabled', true);
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $("#new_order").attr('action'),
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                error: function(){
                    console.log("error");
                    console.log(token);
                    console.log(formData);
                    $("#submit").html('Provjeri i spremi izmjene');
                    $("#submit").prop('disabled', false);
                },
                success: function(data) {
                    console.log("success");
                    console.log(formData);
                    if(data.status === "success") {
                        swal({
                            type: 'success',
                            title: 'Uspjeh!',
                            text: 'Narudžba je uspješno poslana!',
                            onClose: function(element)
                            {
                                location.reload(true);
                            }
                        });
                    }
                    else
                    {
                        var failStart = "";
                        $.each(data.errors, function(index, value) {
                            $.each(value,function(i){
                                failStart += value[i]+"\n";
                            });

                        });
                        swal("Narudžba nije poslana! Popravite sljedeće pogreške:", failStart, "error");
                    }
                    $("#submit").html('Provjeri i spremi izmjene');
                    $("#submit").prop('disabled', false);
                }
            });
        });

    });
    $( "#products" ).on("change", "select.printer_select", function(e) {
        var id = $(this).val();

        var element_id = e.target.id.match(/\d+/);

        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/getAllInkForPrinter/' + id,
            success: function(data) {
                if(data == 0)
                    $( "#inks" + element_id).empty().append("<option value='0'>Ovaj printer nema unešen toner/tintu.</option>");
                else
                    $( "#inks" + element_id).empty().append("<option selected='selected' disabled>Odaberi boju</option>" + data);
            }
        });
    });
</script>
@endsection