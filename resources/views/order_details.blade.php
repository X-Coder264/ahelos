@extends('layouts.app')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span>Vaša narudžba # {{ $order->id }}</span>
                    <span class="pull-right"><a class="btn-link" href="{{ url('/home') }}">Povratak nazad</a></span>
                </div>
                <div class="panel-body flip-scroll">
                    <table class="table table-bordered table-hover flip-content" id="table">
                        <thead>
                            <tr class="filters">
                                <th>Printer</th>
                                <th>Tinta/Toner</th>
                                <th>Količina</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
                @if($order->remark != '')
                    <div class="panel-footer">&nbsp;
                        <div class="form-group">
                            <label for="comment">Napomena:</label>
                            <textarea style="resize:vertical;" name="remark" class="form-control" rows="4" id="comment" disabled>{{ $order->remark }}</textarea>
                        </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/livicon.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
<script>
    $(function() {
        var table = $('#table').DataTable({
            "language": {
                "lengthMenu": "Prikaz _MENU_ artikala po stranici",
                "zeroRecords": "Ništa nije pronađeno.",
                "info": "Stranica _PAGE_ od _PAGES_",
                "infoEmpty": "Nema dostupnih podataka",
                "infoFiltered": "(filtrirano od ukupno _MAX_ zapisa)",
                "search": "Traži",
                "processing": "Obrada podataka...",
                "paginate": {
                    "previous": "Prethodna",
                    "next": "Sljedeća"
                }
            },
            processing: true,
            serverSide: true,
            ajax: '{{ route('user.order.get_data', $order->id) }}',
            columns: [
                { data: 'ink.printer.name', name:'ink.printer.name'},
                { data: 'ink.name', name:'ink.name'},
                { data: 'quantity', name:'quantity'}
            ]
        });
        table.on( 'draw', function () {
            $('.livicon').each(function(){
                $(this).updateLivicon();
            });
        } );
    });
</script>
@endsection