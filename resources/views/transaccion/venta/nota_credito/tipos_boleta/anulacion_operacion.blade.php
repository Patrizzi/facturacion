@extends('layout')

@section('title', 'Nota Credito Anulacion Operacion')
@section('breadcrumb', 'Nota Credito Anulacion Operacion')
@section('breadcrumb2', 'Nota Credito Anulacion Operacion')
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
                                <h2>NOTA DE CREDITO</h2>
                                <h5> {{$boleta->codigo_boleta}}</h5>
                            </center>
                        </div>
                    </div>
                </div><br>
                <form action="{{route('facturacion_electronica.nota_credito_bol',$boleta->id)}}"  enctype="multipart/form-data" method="post" >
                    @csrf
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <h3> Datos Generales</h3>
                                <div align="left">
                                    <strong>Cliente:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->cliente->nombre}}
                                    @else{{$boleta->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>R.U.C:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->cliente->numero_documento}}
                                    @else{{$boleta->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                    <strong>Direccion:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->cliente->direccion}}
                                    @else{{$boleta->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->forma_pago->nombre }}
                                    @else{{$boleta->cotizacion->forma_pago->nombre }}
                                    @endif  <br>
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->moneda->nombre }}
                                    @else{{$boleta->cotizacion->moneda->nombre }}
                                    @endif <br>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control" >
                                <h3>Condiciones Generales</h3>
                                <div align="left">
                                    <strong>Orden de Compra:</strong>
                                    {{$boleta->orden_compra}} <br>
                                    <strong>Guia de Remision:</strong>
                                    {{$boleta->guia_remision}} <br>
                                    <strong>Fecha Emision:</strong>
                                    {{$boleta->fecha_emision}} <br>
                                    <strong>Fecha de Vencimiento:</strong>
                                    {{$boleta->fecha_vencimiento }} <br>

                                    <strong>Tipo de nota de credito:</strong>
                                    <input required="required" class="form-control" type="text" id="motivo" name="motivo" value="{{$tipo_nota_credito}}" readonly style="display: none">
                                    Anulacion de la operacion <br>

                                    <strong>Motivo o Sustento:</strong>
                                    <input required="required" class="form-control" type="text" id="sustento" name="sustento" value="{{$sustento}}" readonly style="display: none">
                                    {{$sustento}} <br>
                                
                                    <strong>Número de la Nueva Boleta Electrónica:</strong>
                                    <input required="required" class="form-control" type="text" id="nueva_boleta" name="nueva_boleta" value="{{$nueva_boleta}}" readonly style="display: none">
                                    {{$nueva_boleta}} <br>
                                
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
                                    <th>Codigo Producto</th>
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
                                    @foreach($boleta_registro as $e => $boleta_registros)
                                    <tr>
                                        <td >{{$u++}}</td>
                                        @if(isset($boleta_registros->producto_id))
                                            <td>{{$boleta_registros->producto->codigo_producto}}</td>
                                        @elseif(isset($boleta_registros->servicio_id))
                                            <td>{{$boleta_registros->servicio->codigo_servicio}}</td>
                                        @endif
                                        <td>{{$boleta_registros->cantidad}}</td> {{--Cantidad--}}
                                        <td><input required="required" class="form-control" type="text" id="input_cantidad_{{$e}}" name="input_cantidad_{{$e}}" value="{{$boleta_registros->cantidad}}" readonly></td> {{--Cantidad Nueva--}}
                                        <td>
                                            @if(isset($boleta_registros->producto_id))
                                                <input required="required" class="form-control" type="text" id="input_descripcion_{{$e}}" name="input_descripcion_{{$e}}" value="{{$boleta_registros->producto->nombre}}" readonly>
                                            @elseif(isset($boleta_registros->servicio_id))
                                                <input required="required" class="form-control" type="text" id="input_descripcion_{{$e}}" name="input_descripcion_{{$e}}" value="{{$boleta_registros->servicio->nombre}}" readonly>
                                            @endif
                                        </td>
                                        <td>{{$boleta_registros->precio}}</td> {{--Precio Unitario--}}
                                        <td><input required="required" class="form-control" type="text" id="input_precio_{{$e}}" name="input_precio_{{$e}}" value="{{$boleta_registros->precio}}" readonly></td> {{--Nuevo Precio--}}
                                        <td><input required="required" class="form-control" type="text" id="input_descuento_{{$e}}" name="input_descuento_{{$e}}" value="0" readonly></td> {{--Nuevo Descuento--}}
                                        <td>{{$boleta_registros->precio_unitario_comi* $boleta_registros->cantidad }}</td> {{--Total--}}
                                        <td style="display: none">
                                            {{$sub_total=($boleta_registros->boleta_i->op_gravada)+($boleta_registros->boleta_i->op_inafecta)+($boleta_registros->boleta_i->op_exonerada)}}
                                            {{$sub_total_gravado=($boleta_registros->boleta_i->op_gravada)}}
                                            {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                            {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td colspan="13" align="right">
                                        <button type="submit" class="btn btn-w-m btn-primary">Enviar</button>
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
