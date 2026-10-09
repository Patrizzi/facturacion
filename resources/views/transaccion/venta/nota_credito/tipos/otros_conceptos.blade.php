{{-- NO TIENE EVENTO EN EL CONTROLADOR --}}
@extends('layout')

@section('title', 'Nota Credito Descuento Global')
@section('breadcrumb', 'Nota Credito Descuento Global')
@section('breadcrumb2', 'Nota Credito Descuento Global')
@section('href_accion', route('nota-credito.index'))
@section('value_accion', 'atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" style="margin-top: -5px;">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">R.U.C : {{$empresa->ruc}}</h3>
                                <h2>NOTA DE CRÉDITO</h2>
                                <h5> {{$facturacion->codigo_fac}}</h5>
                            </center>
                        </div>
                    </div>
                </div><br>
                <form action="{{route('nota-credito.store_factura',$facturacion->id)}}"  enctype="multipart/form-data" method="post" >
                    @csrf
                    <input type="hidden" name="tipo" value="{{$tipo}}">
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <h3> Datos Generales</h3>
                                <div align="left">
                                    <strong>Cliente:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->cliente->nombre}}
                                    @else{{$facturacion->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->cliente->numero_documento}}
                                    @else{{$facturacion->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                    <strong>Dirección:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->cliente->direccion}}
                                    @else{{$facturacion->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->forma_pago->nombre }}
                                    @else{{$facturacion->cotizacion->forma_pago->nombre }}
                                    @endif  <br>
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->moneda->nombre }}
                                    @else{{$facturacion->cotizacion->moneda->nombre }}
                                    @endif <br>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control" >
                                <h3>Condiciones Generales</h3>
                                <div align="left">
                                    <strong>Orden de Compra:</strong>
                                    {{$facturacion->orden_compra}} <br>
                                    <strong>Guía de Remisión:</strong>
                                    {{$facturacion->guia_remision}} <br>
                                    <strong>Fecha Emisión:</strong>
                                    {{$fecha_emision}} <br>
                                    <input type="hidden" name="fecha_emision" id="fecha_emision" value="{{$fecha_emision}}">
                                    <strong>Fecha de Vencimiento:</strong>
                                    {{$fecha_emision}} <br>

                                    <strong>Tipo de nota de crédito:</strong>
                                    <input required="required" class="form-control" type="text" id="motivo" name="motivo" value="{{$tipo_nota_credito}}" readonly style="display: none">
                                    Descuento Global <br>

                                    <strong>Motivo o Sustento:</strong>
                                    <input required="required" class="form-control" type="text" id="sustento" name="sustento" value="{{$sustento}}" readonly style="display: none">
                                    {{$sustento}} <br>

                                    <strong>Número de la Nueva Factura Electrónica:</strong>
                                    <input required="required" class="form-control" type="text" id="nueva_factura" name="nueva_factura" value="{{$nueva_factura}}" readonly style="display: none">
                                    {{$nueva_factura}} <br>

                                    <strong>Descuento Global:</strong>
                                    <input required="required" class="form-control" type="text" id="descuento_global" name="descuento_global" value="{{$descuento_global}}" readonly style="display: none">
                                    {{$descuento_global}} <br>


                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" align="center">
                            <div class="form-control" style="border: none;height: auto" >
                                <div align="left">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Código Producto</th>
                                    <th style="width:30px">Cantidad</th>
                                    <th style="width:30px">Cantidad Nueva</th>
                                    <th>Descripción</th>
                                    <th>Precio unitario</th>
                                    <th >Nuevo Precio</th>
                                    <th >Nuevo Descuento</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <span hidden="hidden">{{$u=0}} </span>
                                <tr>
                                    <tr>
                                        <td >{{$u++}}</td>
                                        <td>- - -</td>{{--Codigo producto--}}
                                        <td>0</td> {{--Cantidad--}}
                                        <td><input required="required" class="form-control" type="text" id="input_cantidad_0" name="input_cantidad_0" value="1" readonly></td> {{--Cantidad Nueva--}}
                                        <td><input required="required" class="form-control" type="text" id="input_descripcion_0" name="input_descripcion_0" value="{{$sustento}}" readonly></td> {{--Descripcion--}}
                                        <td>{{$descuento_global}}</td> {{--Precio Unitario--}}
                                        <td><input required="required" class="form-control" type="text" id="input_precio_0" name="input_precio_0" value="{{$descuento_global}}" readonly></td> {{--Nuevo Precio--}}
                                        <td><input required="required" class="form-control" type="text" id="input_descuento_0" name="input_descuento_0" value="0" readonly></td> {{--Nuevo Descuento--}}
                                        <td>{{$descuento_global}}</td> {{--Total--}}

                                    </tr>

                                </tr>
                                <tr>
                                    <td colspan="13" align="right">
                                        <button type="submit" class="btn btn-w-m btn-primary">Guardar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br><br><br><br>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Mainly scripts -->
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


<script>
    var estado=1;
</script>
@endsection
