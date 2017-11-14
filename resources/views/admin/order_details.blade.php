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
    <link href="{{ asset('assets/css/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>Narudžba #{{$order->id}}</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    Admin Panel
                </a>
            </li>
            <li>
                <a href="#">Narudžbe</a>
            </li>
            <li class="active">Narudžba #{{$order->id}}</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action ="{{route('admin.user.order.update', $order->id)}}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span>Narudžba #{{$order->id}}</span>
                    </div>

                    <div class="panel-body">
                        <div class="panel-footer">
                            @foreach ($user->toArray() as $key => $value)
                                {{$value}} <br>
                            @endforeach
                            <br>
                        </div>
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
                        <table class="table table-bordered" id="table_orders">
                            <thead>
                            <tr class="filters">
                                <th>Printer</th>
                                <th>Toner/Tinta</th>
                                <th>Količina</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $i = 0; ?>
                            @foreach($printers_order as $printer_order)
                               <tr>
                                   <td style="width:45%;"><select class="printer_select form-control" id="printer{{$i}}" name="printers_id[]">
                                           @foreach($printers as $printer)
                                               @if($printer_order->ink->printer->id === $printer->id)
                                                   <option value="{{$printer_order->ink->printer->id}}" selected>{{$printer_order->ink->printer->name}}</option>
                                                   @else
                                                   <option value="{{$printer->id}}">{{$printer->name}}</option>
                                                   @endif
                                               @endforeach
                                       </select></td>
                                   <td style="width:45%;"><select class="colors_select form-control" id="inks{{$i++}}" name="inks[]">
                                           <option value="{{$printer_order->ink->id}}">{{$printer_order->ink->name}}</option>
                                       </select></td>
                                   <td style="width:10%;"><input type="number" class="form-control" name="quantity[]" value="{{$printer_order->quantity}}"></td>
                               </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="panel-footer">&nbsp;
                            @if($order->remark != '')
                                <div class="panel-footer">&nbsp;
                                    <div class="form-group">
                                        <label for="comment">Napomena:</label>
                                        <textarea style="resize:vertical;" name="remark" class="form-control" rows="4" id="comment" disabled>{{ $order->remark }}</textarea>
                                    </div>
                                    @endif
                            <div class="col-sm-4 col-sm-offset-4">
                                <select name="status" class="form-control">
                                    <option value="Obrada u tijeku" @if($order->status === 'Obrada u tijeku') selected @endif>Obrada u tijeku</option>
                                    <option value="Odobreno" @if($order->status === 'Odobreno') selected @endif>Odobreno</option>
                                    <option value="Poništeno" @if($order->status === 'Poništeno') selected @endif>Poništeno</option>
                                </select>
                            </div>
                            <hr>
                            <div class="clear">
                                <input type="button" class="btn btn-danger" value="Povratak">
                                <input type="submit" class="btn btn-primary pull-right" value="Spremi promjene">
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>
@stop

@section('footer_scripts')
    <script>
        $( "#table_orders" ).on("change", "select.printer_select", function(e) {
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
                        $( "#inks" + element_id).empty().append("<option value='0'>Ovaj printer nema niti jednu tintu ili toner.</option>");
                    else
                        $( "#inks" + element_id).empty().append(data);
                }
            });
        });
    </script>
@endsection
