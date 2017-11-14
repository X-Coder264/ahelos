@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Ahelos Admin Panel
    @parent
@stop

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <h1>Dobrodošli u Admin Panel</h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="livicon" data-name="home" data-size="16" data-color="#333" data-hovercolor="#333"></i>
                    Admin Panel
                </a>
            </li>
        </ol>
    </section>
    <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <span>Sve narudžbe</span>
                        </div>

                        <div class="panel-body flip-scroll">
                            <table class="table table-bordered table-hover flip-content" id="table">
                                <thead>
                                <tr class="filters">
                                    <th>ID narudžbe</th>
                                    <th>Ime korisnika</th>
                                    <th>Prezime korisnika</th>
                                    <th>Tvrtka</th>
                                    <th>Status</th>
                                    <th>Stvorena</th>
                                    <th>Opcije</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>

@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                "language": {
                    "lengthMenu": "Prikaz _MENU_ narudžbi po stranici",
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
                ajax: '{!! route('admin.orders.show') !!}',
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'user.name', name:'user.name'},
                    { data: 'user.surname', name:'user.surname'},
                    { data: 'user.company', name:'user.company'},
                    { data: 'status', name:'status'},
                    { data: 'created_at', name:'created_at', searchable: false},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                "order": [[ 5, "desc" ]],
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Sve narudžbe"] ],
                "rowCallback": function ( row, data ) {
                    if ( data.read_by_admin == 0 ){ $('td', row).css('background-color', '#DB5E47');}
                }
            });

            table.on( 'draw', function () {
                $('.livicon').each(function(){
                    $(this).updateLivicon();
                });
            } );
        });

    </script>

@endsection