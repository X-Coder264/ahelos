@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Korisnički profil
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/vendors/x-editable/css/bootstrap-editable.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/user_profile.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>Korisnički profil</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    Admin Panel
                </a>
            </li>
            <li>
                <a href="#">Korisnici</a>
            </li>
            <li class="active">Korisnički profil</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav  nav-tabs ">
                    <li class="active">
                        <a href="#tab1" data-toggle="tab">
                            <i class="livicon" data-name="user" data-size="16" data-c="#000" data-hc="#000" data-loop="true"></i>
                            Korisnički profil</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab">
                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                            Promjeni lozinku</a>
                    </li>

                </ul>
                <div  class="tab-content mar-top">
                    <div id="tab1" class="tab-pane fade active in">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            Profil korisnika - {{$user->name }} {{ $user->surname }}
                                        </h3>

                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover" id="users">

                                                        <tr>
                                                            <td>Ime</td>
                                                            <td>
                                                                <p class="user_name_max">{{ $user->name }}</p>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>Prezime</td>
                                                            <td>
                                                                <p class="user_name_max">{{ $user->surname }}</p>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>Email</td>
                                                            <td>
                                                                {{ $user->email }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mjesto</td>
                                                            <td>
                                                                {{ $user->place }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Adresa</td>
                                                            <td>
                                                                {{ $user->address }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Poštanski broj</td>
                                                            <td>
                                                                {{ $user->post }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Status</td>
                                                            <td>

                                                                @if($user->trashed())
                                                                    Deaktiviran
                                                                @else
                                                                    Aktiviran
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Registriran</td>
                                                            <td>
                                                                <?php
                                                                \Carbon\Carbon::setLocale('hr');
                                                                ?>
                                                                {{ $user->created_at->format('d.m.Y. H:i:s') }} ({{ $user->created_at->diffForHumans() }})
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="content paddingleft_right15">
                            <div class="row">
                                <div class="panel panel-primary ">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                            Narudžbe korisnika <strong>{{$user->name }} {{ $user->surname }}</strong>
                                        </h4>
                                    </div>
                                    <br />
                                    <div class="panel-body">
                                        <table class="table table-bordered table-hover" id="table">
                                            <thead>
                                            <tr class="filters">
                                                <th>ID narudžbe</th>
                                                <th>Status</th>
                                                <th>Stvoreno</th>
                                                <th>Zadnja izmjena</th>
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
                    </div>
                    <div id="tab2" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-12 pd-top">
                                <form class="form-horizontal" id="change-password" method="POST" action="{{ route('admin.passwordreset', $user->id) }}">
                                    {{csrf_field()}}
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="password" class="col-md-3 control-label">
                                                Lozinka
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="password" name="password" id="password" placeholder="Lozinka" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password-confirm" class="col-md-3 control-label">
                                                Ponovi lozinku
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#000" data-hc="#000"></i>
                                                            </span>
                                                    <input type="password" name="password_confirmation" id="password-confirm" placeholder="Ponovi lozinku" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-primary" id="change-password">Izmjeni lozinku
                                            </button>
                                            &nbsp
                                            <input type="reset" class="btn btn-default hidden-xs" value="Resetiraj"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/js/sweetalert2.min.js') }}" ></script>

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
                ajax: '{!! route('admin.users.order.data', ['user' => $user->id]) !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ]
            });
            table.on( 'draw', function () {
                $('.livicon').each(function(){
                    $(this).updateLivicon();
                });
            } );
        });

    </script>

    <script  src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("form#change-password").submit(function( event ) {
                event.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $("#change-password").attr('action'),
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
                    },
                    success: function(data) {
                        if(data.status === "success") {
                            swal({
                                type: 'success',
                                title: 'Uspjeh!',
                                text: 'Lozinka je uspješno promjenjena!'
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
                            swal("Lozinka nije promjenjena! Popravite sljedeće pogreške:", failStart, "error");
                        }
                    }
                });
            });
        });
    </script>
@stop
