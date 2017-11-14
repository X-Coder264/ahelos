@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Lista e-mailova
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/tables.css') }}" rel="stylesheet" type="text/css" />
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
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Tablica e-mailova
                    </h4>
                </div>
                <br>
                <div class="panel-body">
                    <table class="table table-bordered " id="table">
                        <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>Naslov</th>
                            <th>Ime pošiljatelja</th>
                            <th>E-mail pošiljatelja</th>
                            <th>Status</th>
                            <th>Datum i vrijeme slanja upita</th>
                            <th>Opcije</th>
                        </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>    <!-- row-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

    <script>
        $(function() {
            var table = $('#table').DataTable({
                "language": {
                    "lengthMenu": "Prikaz _MENU_ korisnika po stranici",
                    "zeroRecords": "Ništa nije pronađeno.",
                    "info": "Stranica _PAGE_ od _PAGES_",
                    "infoEmpty": "Nema dostupnih podataka",
                    "infoFiltered": "(filtrirano od ukupno _MAX_ zapisa)",
                    "search": "Traži",
                    "paginate": {
                        "previous": "Prethodna",
                        "next": "Sljedeća"
                    }
                },
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.emails.show') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'subject', name: 'subject' },
                    { data: 'sender_name', name: 'sender_name' },
                    { data: 'sender_email', name: 'sender_email' },
                    { data: 'status', name:'status'},
                    { data: 'created_at', name:'created_at'},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                "rowCallback": function ( row, data ) {
                    if ( data.status == "Neodgovoreno" ){ $('td', row).css('background-color', '#DB5E47');}
                }
            });
            table.on( 'draw', function () {
                $('.livicon').each(function(){
                    $(this).updateLivicon();
                });
            } );
        });

    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
@stop
