@extends('layout')

@section('title', 'Agregar Guia de Remision Manual')
@section('breadcrumb', 'Agregar Guia de Remision Manual')
@section('breadcrumb2', 'Agregar Guia de Remision Manual')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $("#pro").keypress(function(e) {
            if (e.which == 13) {
                setTimeout(function() {
                    e.target.value += ' | ';
                }, 4);
                e.preventDefault();
            }
        });
    });
</script>
@section('content')
@section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado'))
@section('ruta_retorno', 'guia_remision')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>

<form action="">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <div class="row">
                        <div class="col-sm-4 text-left" align="left">
                            <address class="col-sm-4" align="left">
                                <img src="{{asset('img/logos/')}}//{{$empresa->foto}}" alt="" width="300px">
                            </address>
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4 ">
                            <div class="form-control ruc" style="height: 125px">
                                <center>
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>
                                    {{-- <h5>{{$codigo_guia}} <input type="text" name="almacen" value="{{$almacen}}" hidden="hidden"> </h5> --}}
                                </center>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6" >
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Cliente:</label>
                                <div class="col-sm-10">
                                    <select class="select2_demo_client" name="cliente" id="cliente" required=""></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Almacen:</label>
                                <div class="col-sm-10">
                                    <select class="select2_demo_almacen" name="almacen" id="almacen" required="">
                                        @foreach($almacen as $almacenes)
                                            <option value="{{$almacenes->id}}">{{$almacenes->abreviatura}} - {{$almacenes->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2">Motivo Traslado:</label>
                                <div class="col-sm-10">
                                    <select name="motivo_traslado"  class="form-control m-b">
                                        @foreach($motivo_traslado as $motivo_traslad)
                                            <option id="{{$motivo_traslad->id}}">{{$motivo_traslad->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2">F. Emision</label>  
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="fecha_emision" id="" readonly value="{{date("Y/m/d")}}">
                                </div>
                                <label class="col-sm-2">F. Emision</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="fecha_entrega" id="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2">Tipo de Transporte:</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="tipo_transporte" autocomplete="off" onchange="test(this)" id="select_id">
                                        <option value="0">Sin Transporte</option>
                                        <option value="1">Transporte Público</option>
                                        <option value="2">Transaporte Privado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" id="transporte_publico" hidden="hidden">
                            <div class="row">
                              <label class="col-sm-2">Vehiculo Público:</label>
                                <div class="col-sm-10">
                                      <select class="form-control m-b" name="vehiculo_publico" autocomplete="off" id="vehiculo_publico">
                                        <option value="">Ningún Vehículo</option>
                                        @foreach($transporte_publico as $transporte_publicos)
                                        <option value="{{$transporte_publicos->id}}">{{$transporte_publicos->nombre}} /{{$transporte_publicos->ruc}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="transporte_privado" hidden="hidden">
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-1">Vehiculo Privado:</label>
                                <div class="col-sm-5">
                                    <select class="form-control m-b" name="vehiculo" autocomplete="off" id="vehiculo_privado">
                                        <option value="">Ningún Vehículo</option>
                                        @foreach($vehiculo as $vehiculos)
                                        <option value="{{$vehiculos->id}}">{{$vehiculos->placa}} /{{$vehiculos->marca}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-1">Conductor:</label>
                                <div class="col-sm-5">
                                    <select class="form-control m-b" name="conductor" autocomplete="off" id="conductor">
                                        <option value="">Ningún Conductor</option>
                                        <option disabled="disabled">------------------------------</option>
                                        @foreach($personal as $ersonals)
                                        <option value="{{$ersonals->id}}">{{$ersonals->nombres}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <label class="col-sm-1">Observaciones:</label>
                                <div class="col-sm-11">
                                    <textarea name="observacion" class="form-control">Guía Electrónica Emitida para el Cliente  </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="table-responsive">
                            <table cellspacing="0" class="table table-striped ">
                                <thead>
                                    <tr>
                                        <th style="">
                                            {{-- <input class='check_all' type='checkbox' onclick="select_all()" /> --}}
                                            <button class="btn btn-primary" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </th>
                                        <th style="font-size: 13px;">Articulo</th>
                                        <th style="font-size: 13px; width:10%">Cantidad</th>
                                        <th style="font-size: 13px; width:16%">N° Series</th>
                                        <th style="font-size: 13px; width:11%">Peso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <button class="btn btn-danger" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <select class="select2_demo_productos" name="" id="">
                                                @foreach($productos as $index => $producto)
                                                    <option value="{{$producto->id}}">
                                                        {{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="cantidad[]" id="cantidad" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="serie[]" id="n_serie" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="serie[]" id="n_serie" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 12px;
    }
    .select2-container--default .select2-selection--single {
        border: none;
    }
    span.select2.select2-container.select2-container--default{
        width: 100%!important;
        background-color: #FFFFFF;
        background-image: none;
        border-radius: 1px;
        display: block;
        padding: 3px 12px;
        border: 1px solid #e5e6e7;
    }
</style>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2_demo_almacen').select2();
        $('.select2_demo_productos').select2();
    });
    
    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        ajax: {
            minimumInputLength: 1,
            url: "{{ route('pa.clients') }}",
            dataType: 'json',
            type: "POST",
            delay: 10,
            data: function (params) {
                var tipo_coti = 1;
                return {
                    _token: "{{ csrf_token() }}",
                    search: params.term, // search term
                    tipo_coti: tipo_coti    
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.nombre + ' | ' +  item.numero_documento,
                        };
                    })
                };
            },
            cache: true
        }
    });
    
</script>
@endsection