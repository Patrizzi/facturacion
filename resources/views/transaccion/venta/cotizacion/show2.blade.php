@extends('layout')
@section('title', 'Cotización')
@section('breadcrumb', 'Cotización')
@section('breadcrumb2', 'Cotización')
@section('href_accion', route('cotizacion.index'))
@section('value_accion', 'Inicio')

@section('button2', 'Nueva Cotización')
@section('onclick',"event.preventDefault();document.getElementById('nueva_cot').submit();")
@section('content')

<form action="{{ route($nueva_cot)}}"enctype="multipart/form-data" method="post" id="nueva_cot">
    @csrf
    <input type="text"  hidden="hidden" name="almacen"  value="{{$cotizacion->almacen_id}}">
    <input  hidden="hidden" type="submit"  >
</form>
@if($errors->any())
    <div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
        <a class="alert-link" href="#">
            @foreach ($errors->all() as $error)
            <li class="error" style="color: red">{{ $error }}</li>
            @endforeach
        </a>
    </div>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title" style="padding-right: 3.1%">
            <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up text-muted"></i>
                </a>
                <a class="" href="{{ route('ventas.cotizacion') }}">
                    <i class="fa fa-times text-muted"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content" style="padding-right: 3.1%;padding-left: 3.1%; padding-bottom: 10px;">
            <div class="row tooltip-demo">
                <div class="col-sm-6" >
                    @if($cotizacion->estado == '1')
                        @if($cotizacion->tipo=='factura')
                            <a class="btn btn-default procesado" style="color: inherit !important; transition: 1s"  href="{{route('facturacion.show',$factura->id)}}" >Ver Factura</a>
                        @elseif($cotizacion->tipo=='boleta')
                            <a class="btn btn-default procesado" style="color: inherit !important; transition: 1s"  href="{{route('boleta.show',$boleta->id)}}" >Ver Boleta</a>
                        @else
                            <a class="btn btn-default procesado" style="color: inherit !important; transition: 1s"  href="{{route('nota_venta.show',$nota_venta->id)}}" >Ver Nota de Venta</a>
                        @endif
                    @else
                    {{-- SIN PROCESAR --}}
                        @if($cotizacion->tipo=='factura')
                            <form action="{{route('cotizacion.facturar' , $cotizacion->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="almacen" value="{{$almacen}}" />
                                <button type="submit" class="btn btn-info" href="">Facturar</button>
                            </form>
                            <input type="hidden" name="tipo_coti" id="tipo_coti" value="1">
                        @elseif($cotizacion->tipo=='boleta')
                            <form action="{{route('cotizacion.boletear', $cotizacion->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="almacen" value="{{$almacen}}" />
                                <button type="submit" class="btn btn-info" href="">Boletear</button>
                            </form>
                            <input type="hidden" name="tipo_coti" id="tipo_coti" value="0">
                        @else
                            <form action="{{route('cotizacion.nota_venta', $cotizacion->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="almacen" value="{{$almacen}}" />
                                <button type="submit" class="btn btn-info" href="">Generar Nota de V.</button>
                            </form>
                            <input type="hidden" name="tipo_coti" id="tipo_coti" value="3">
                        @endif
                    @endif
                </div>
                <div class="col-sm-6" align="right">
                    <a href="{{route('cotizacion.free_print', $cotizacion->id)}}" class="btn btn-secondary" target="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Impresion Libre"><i class="fa fa-share-alt"></i></a>
                    <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_cotizacion' ,$cotizacion->id)}}">
                        <input type="text" name="name" maxlength="50" hidden="" value="Cotizacion_{{$cotizacion->tipo}}"  >
                        <input type="text" hidden="" name="firma" value="0">
                        <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
                    </form>
                    {{-- <button id="btn_ticket" class="btn btn-info"><i class="fa fa-ticket fa-lg"></i></button> --}}
                    <input type="text" value="{{$cotizacion->id}}" name="id" id="id" hidden="">
                    <a class="btn btn-success" href="{{route('cotizacion.print',$cotizacion->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
                    @if(Auth::user()->email_creado == 1)
                        <form action="{{ route('email.cotizacion', $cotizacion->id )}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn"  >
                            @csrf
                            <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo">
                                <i class="fa fa-envelope fa-lg" ></i>
                            </button>
                        </form>
                    @endif
                    <div id="auto" onclick="divAuto()">
                        <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
                    </div>
                    {{-- BOTON PARA EDITAR / ESTADOS PARA 0 NO FACTURADO/BOLETEADO --}}
                    @if($cotizacion->estado_vigente == 0 && $cotizacion->estado == 0)
                        <button class="btn btn-warning btn-editar" id="edit" onclick="click_editar()"><i class="fa fa-pencil"></i></button>
                        <button class="btn-no-editar no_mostrar btn btn-warning" onclick="click_cancelar_editar()"><i class="fa fa-times"></i></button>
                    @endif
                    {{-- FIN DE BOTON EDITAR --}}
                    <div id="div-mostrar" style="height: 0px; overflow: hidden;">
                    <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                            @csrf
                            <input type="tel" name="numero"  value="{{$cotizacion->cliente->celular}}"   />
                            <input type="text" name="mensaje" id="texto_orden" hidden="" />
                            <input type="text" hidden="" name="url" value="{{route('pdf_cotizacion' ,$cotizacion->id)}}?archivo=">
                            <input type="text" name="name_sin_cambio" hidden="" value="Cotizacion_{{$cotizacion->tipo}}" />
                            <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: -26px;">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row" style="align-items: center; justify-content: center">
                    {{-- Cabecera logo y informacion --}}
                    @include('layout_cabecera_ventas')
                    <div class="col-sm-4">
                        <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">COTIZACIÓN ELECTRÓNICA</h2>
                            <h5>{{$cotizacion->cod_cotizacion}} </h5>
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-no mostrar">
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <h3>Contacto Cliente</h3>
                                <div align="left">
                                    <strong>Señor(es):</strong> &nbsp;{{$cotizacion->cliente->nombre}}<br>
                                    <strong>{{$cotizacion->cliente->documento_identificacion}} :</strong> &nbsp;{{$cotizacion->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <strong>Dirección:</strong>&nbsp; {{$cotizacion->cliente->direccion}}<br>
                                    <strong>N° Contacto:</strong>&nbsp;{{$cotizacion->cliente->celular}}
                                    @if(isset($cotizacion->cliente->telefono ))
                                        / {{$cotizacion->cliente->telefono}}<br>
                                    @endif
                                    {{-- DATOS DE RENOVACIÓN --}}
                                    @if($renovacion && $fecha_vencimiento)
                                        <strong>F. Vencimiento:</strong>&nbsp;{{ $fecha_vencimiento->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Días restantes:</strong>&nbsp;{{ $dias_restantes_texto }}<br>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control" >
                                <h3>Condiciones Generales</h3>
                                <div align="left">
                                    <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion->forma_pago->nombre }}&nbsp;&nbsp;&#09;&nbsp;&nbsp;&#09;&Tab;&Tab;&#8287;<strong>Fecha:</strong> &nbsp;{{$cotizacion->updated_at}}<br>
                                    <strong>Validez :</strong> &nbsp;{{$cotizacion->validez}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#09;&Tab;&Tab;&#8287;
                                    <strong>Garantía:</strong> &nbsp;{{$cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <strong>Comisionista:</strong> &nbsp;

                                    @if(isset($cotizacion->comisionista->cod_vendedor))
                                    {{$cotizacion->comisionista->cod_vendedor}} - {{$cotizacion->comisionista->personal->personal_l->nombres}} - {{$cotizacion->comisionista->comision}}% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <input type="hidden" name="" id="comisionista" value="{{$cotizacion->comisionista->comision}}">
                                    @else
                                    Sin Comisionista - 0
                                    <input type="hidden" name="" id="comisionista" value="0">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-12" align="center">
                            <div class="form-control" style="border: none;height: auto" >
                                <div align="left">
                                    <strong>Observaciones:</strong> &nbsp;{{$cotizacion->observacion }}<br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <input type="hidden" name="almacen" id="almacen_id" class="form-control " value="{{$cotizacion->almacen_id}}" readonly="readonly">
                <input type="hidden" id="moneda" class="form-control " value="{{$cotizacion->moneda->nombre}}" readonly="readonly">
                <input type="hidden" id="moneda_id" class="form-control " value="{{$cotizacion->moneda_id}}" readonly="readonly">
                <div class="table-no mostrar">
                    <table class="table" cellspacing="0" >
                        <thead>
                            <tr>
                                <th>ITEM</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Dscto.</th>
                                <th>P.Unitario Desc.</th>
                                <th>Comisión</th>
                                <th>P.Unitario Com.</th>
                                <th>Total<span hidden="hidden">{{$simbologia=$cotizacion->moneda->simbolo}}</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cotizacion_registro as $cotizacion_registros)
                                <tr>
                                    <td>{{$i++}} </td>
                                    @if(isset($cotizacion_registros->producto_id))
                                        <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                                        <td>{{$cotizacion_registros->producto->nombre}}  <br>{{$cotizacion_registros->descripcion_item}}</span></td>
                                    @else
                                        <td>{{$cotizacion_registros->servicio->codigo_servicio}}</td>
                                        <td>{{$cotizacion_registros->servicio->nombre}}  <br>{{$cotizacion_registros->descripcion_item}}</span></td>
                                    @endif

                                    <td>{{$cotizacion_registros->cantidad}}</td>
                                    <td>{{$cotizacion_registros->descuento}}%</td>
                                    <td>{{number_format($cotizacion_registros->precio_unitario_desc,2)}}</td>
                                    <td>{{$cotizacion_registros->comision}}%</td>
                                    <td>{{number_format($cotizacion_registros->precio_unitario_comi,2)}}</td>
                                    <td style="text-align: right">{{number_format($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi,2)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <footer style="padding-top: 120px">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 align="left">
                                    <?php  use Luecano\NumeroALetras\NumeroALetras;
                                        $v=new NumeroALetras() ;
                                        $letra=($v->toInvoice($end, 2));
                                    // $letra=($v->convertirEurosEnLetras($end));
                                    // $letra_final = ucfirst(strstr($letra, 'soles',true));
                                    // $end_final_point=strstr($end2, '.', false);
                                    // $end_final=str_replace('.', '',$end_final_point);
                                    // ?>
                                    Son : {{ucfirst(mb_strtolower($letra,'UTF-8'))}} {{$cotizacion->moneda->nombre }}
                                </h3>
                            </div>
                            <div class="col-sm-4 form-control ">
                                    <span style="display: block;float: left"> Subtotal:</span>
                                    <span style="display: block;float: right;"> {{$simbologia=$cotizacion->moneda->simbolo}} {{number_format($sub_total, 2)}}</span>
                                    <br>
                                    <span style="display: block;float: left"> Op. Gravada: </span>
                                    <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion->op_gravada,2)}}</span><br>
                                    <span style="display: block;float: left"> Op. Inafecta: </span>
                                    <span style="display: block;float: right">{{$simbologia}} {{ number_format($cotizacion->op_inafecta,2)}}</span><br>
                                    <span style="display: block;float: left"> Op. Exonerada: </span>
                                    <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion->op_exonerada,2)}} </span><br>
                                    <span style="display: block;float: left"> I.G.V.: </span>
                                    <span style="display: block;float: right">{{$cotizacion->moneda->simbolo}} {{number_format(round($igv_p, 2),2)}}</span><br>
                                    <span style="display: block;float: left"> Importe Total: </span>
                                    <span style="display: block;float: right">{{$cotizacion->moneda->simbolo}} {{number_format($end,2)}}</span>
                            </div>
                        </div>
                    </footer>
                </div>
                <span hidden> {{$h = 1}} {{ $sume = 0}}</span>
                <div class="div-editar no_mostrar">
                    @if($cotizacion->estado_vigente == 0 && $cotizacion->estado == 0)
                        <form action="{{route('cotizacion.update', $cotizacion->id)}}" method="post"  enctype="multipart/form-data" id="coti_update">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6" align="center">
                                    <div class="form-control ">
                                        <div class="row input_small">
                                            <div class="col-sm-4">
                                                <strong>Señor(es)</strong>
                                            </div>
                                            <div class="col-sm-8">
                                            <input type="hidden" name="" id="cliente_id" value="{{$cotizacion->cliente->id}}">
                                                <select class="select2_demo_client" name="cliente" id="cliente" required="" >
                                                    <option selected value="{{$cotizacion->cliente->id}}">{{$cotizacion->cliente->nombre}} - {{$cotizacion->cliente->numero_documento}}</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>Forma de Pago:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="forma_pago" required="required">
                                                    @foreach($forma_pagos as $forma_pago)
                                                        <option value="{{$forma_pago->id}}" @if($cotizacion->forma_pago_id == $forma_pago->id) selected @endif>{{$forma_pago->nombre}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>Garantia:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="garantia">
                                                    @foreach($garantia as $garantias)
                                                        <option value="{{$garantias->descripcion}}" @if($cotizacion->garantia == $garantias->descripcion) selected @endif>{{$garantias->descripcion}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" align="center" style="padding-bottom: 15px">
                                    <div class="form-control ">
                                        <div class="row input_small">
                                            <div class="col-sm-4">
                                                <strong>Validez:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <select  class="form-control" name="validez" required="required">
                                                    @foreach($validez as $validezz)
                                                        <option value="{{$validezz->descripcion}}" @if($cotizacion->validez == $validezz->descripcion) selected @endif>{{$validezz->descripcion}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>Tipo de Moneda:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                <input class="form-control" readonly type="text" name="" id="" value="{{$cotizacion->moneda->nombre }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>Comisionista:</strong>
                                            </div>
                                            <div class="col-sm-8">
                                                @if(isset($cotizacion->comisionista->cod_vendedor))
                                                    <input class="form-control" readonly type="text" id="" value="{{$cotizacion->comisionista->cod_vendedor}} - {{$cotizacion->comisionista->personal->personal_l->nombres}} - {{$cotizacion->comisionista->comision}}%">
                                                @else
                                                    <input class="form-control" readonly type="text" id="" value="Sin Comisionista - 0">
                                                @endif
                                            </div>

                                            <!-- Sección de Renovación -->
                                            <div class="col-sm-4" style="margin-top: 15px; display: flex; align-items: center; justify-content: flex-start; padding-right: 15px; padding-left: 55px;">
                                                <div class="switch-container">
                                                    <strong>Renovación:</strong>
                                                    <label class="switch">
                                                        <input type="checkbox" id="estado_renovacion" name="estado_renovacion" value="1"
                                                            {{ $cotizacion->estado_renovacion == 1 ? 'checked' : '' }}>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-8" style="margin-top: 15px;">
                                                <div id="renovacion_container" style="display: {{ $cotizacion->estado_renovacion == 1 ? 'block' : 'none' }};">
                                                    <div class="row" style="margin: 0;">
                                                        <div class="col-sm-6" style="padding-right: 5px; padding-left: 0;">
                                                            <select class="form-control form-control-sm" name="select_fecha" id="select_fecha" autocomplete="off">
                                                                <option value="">Frecuencia</option>
                                                                <option value="Mensual" {{ $cotizacion->frecuencia_renovacion == 'Mensual' ? 'selected' : '' }}>Mensual</option>
                                                                <option value="Anual" {{ $cotizacion->frecuencia_renovacion == 'Anual' ? 'selected' : '' }}>Anual</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6" style="padding-left: 5px; padding-right: 0;" id="extra_selects"></div>
                                                    </div>
                                                    <!-- Inputs ocultos para guardar los valores -->
                                                    <input type="hidden" name="dia_mensual" id="dia_mensual_hidden" value="{{ $cotizacion->dia_mensual ?? '' }}">
                                                    <input type="hidden" name="dia_anual" id="dia_anual_hidden" value="{{ $cotizacion->dia_anual ?? '' }}">
                                                    <input type="hidden" name="mes_anual" id="mes_anual_hidden" value="{{ $cotizacion->mes_anual ?? '' }}">
                                                    <input type="hidden" name="anio_anual" id="anio_anual_hidden" value="{{ $cotizacion->anio_anual ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br style="padding-bottom: 5px">
                                <div class="col-sm-12">
                                    <div class="form-control">
                                        <strong>Observaciones</strong>
                                        <textarea class="form-control" name="observacion" id="">{{$cotizacion->observacion }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <table cellspacing="0" class="table table-responsive" id="inp_s">
                                <thead>
                                    <tr>
                                        <th><button class="addmore btn btn-success" type="button"><i class="fa fa-plus"></i></button></th>
                                        <th>Item</th>
                                        <th>Stock</th>
                                        <th>Cantidad</th>
                                        <th>Precio </th>
                                        <th>Descuento</th>
                                        <th>Precio U Desc</th>
                                        <th>Precio U Com</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="tables">
                                    @foreach($cotizacion_registro as $cotizacion_registros)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="elem_delete[]" value="{{$cotizacion_registros->id}}">
                                                <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="existente">
                                                <button type="button" class="btn btn-danger borrar e "><i class="fa fa-trash"></i></button>
                                            </td>
                                            <td>
                                                <select class="monto0 select2_demo_3 select_change limp_select" required="" id="articulo{{$h}}"  autocomplete="off" onchange="ajax({{$h}})" >
                                                    @if(isset($cotizacion_registros->producto->id))
                                                        <option value="{{$cotizacion_registros->producto->id}} | {{$cotizacion_registros->producto->codigo_producto}} | {{$cotizacion_registros->producto->codigo_original}} | {{$cotizacion_registros->producto->nombre}}">{{$cotizacion_registros->producto->id}} | {{$cotizacion_registros->producto->codigo_producto}} | {{$cotizacion_registros->producto->codigo_original}} | {{$cotizacion_registros->producto->nombre}}</option>
                                                    @else
                                                        <option value="{{$cotizacion_registros->servicio->id}} | {{$cotizacion_registros->servicio->codigo_servicio}} | {{$cotizacion_registros->servicio->codigo_original}} | {{$cotizacion_registros->servicio->nombre}}">{{$cotizacion_registros->servicio->id}} | {{$cotizacion_registros->servicio->codigo_servicio}} | {{$cotizacion_registros->servicio->codigo_original}} | {{$cotizacion_registros->servicio->nombre}}</option>
                                                    @endif
                                                </select>
                                                <textarea type='text' id='descripcion{{$h}}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control limp_txt" autocomplete="off" style="margin-top: 5px;" >{{$cotizacion_registros->descripcion_item}}</textarea>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control limp" name="stock" id="stock{{$h}}" value="@if($cotizacion_registros->stock != null) {{$cotizacion_registros->stock}} @else 100 @endif" readonly>
                                            </td>
                                            <td>
                                                <input type="number"  name="cantidad[]" id="cantidad{{$h}}" class="form-control limp" onkeyup="multi({{$h}})"  value="{{$cotizacion_registros->cantidad}}" max="{{$cotizacion_registros->stock}}">
                                            </td>
                                            <td>
                                                <input type="text"  name="precio[]" id="precio{{$h}}" class="form-control limp" value="{{$cotizacion_registros->precio}}" readonly>
                                            </td>
                                            <td>
                                                @if(isset($cotizacion_registros->producto->descuento2))
                                                    <div style="position: relative;">
                                                        <input class="text_des limp" type='text' id='descuento{{$h}}' name='descuento[]' readonly="readonly" value="{{$cotizacion_registros->producto->descuento2}}" required autocomplete="off"/>
                                                    </div>
                                                    <div  class="div_check">
                                                        @if($cotizacion_registros->descuento > 0)
                                                            <input class="check" type='checkbox' id='check{{$h}}' name='check[]' onclick="multi({{$h}})" style="" autocomplete="off" checked/>
                                                            <input type='hidden' id='check_descuento{{$h}}' name='check_descuento[]' class="form-control limp"  required value="{{$cotizacion_registros->producto->descuento2}}">
                                                        @else
                                                            <input class="check" type='checkbox' id='check{{$h}}' name='check[]' onclick="multi({{$h}})" style="" autocomplete="off" />
                                                            <input type='hidden' id='check_descuento{{$h}}' name='check_descuento[]' class="form-control limp"  required value="0">
                                                        @endif
                                                    </div>

                                                    <input style="width: 76px" hidden="" type='text' id='tipo_afec{{$h}}' name='tipo_afec[]' readonly="readonly" class="monto0 form-control limp" onkeyup="multi({{$h}})" required  autocomplete="off" value="{{strtok($cotizacion_registros->producto->tipo_afec_i_producto->informacion," ")}}"  />
                                                    <input class="celda" name="articulo[]" id="input_prod{{$h}}" value="{{$cotizacion_registros->producto->id}} | {{$cotizacion_registros->producto->codigo_producto}} | {{$cotizacion_registros->producto->codigo_original}} | {{$cotizacion_registros->producto->nombre}}" class="limp" hidden>
                                                @else
                                                    <div style="position: relative;">
                                                        <input class="text_des limp" type='text' id='descuento{{$h}}' name='descuento[]' readonly="readonly" value="{{$cotizacion_registros->servicio->descuento}}" required autocomplete="off"/>

                                                    </div>
                                                    <div  class="div_check">
                                                        @if($cotizacion_registros->descuento > 0)
                                                            <input class="check" type='checkbox' id='check{{$h}}' name='check[]' onclick="multi({{$h}})" style="" autocomplete="off" checked />
                                                            <input type='hidden' id='check_descuento{{$h}}' name='check_descuento[]' class="form-control limp"  required value="{{$cotizacion_registros->descuento}}">
                                                        @else
                                                            <input class="check" type='checkbox' id='check{{$h}}' name='check[]' onclick="multi({{$h}})" style="" autocomplete="off" />
                                                            <input type='hidden' id='check_descuento{{$h}}' name='check_descuento[]' class="form-control limp"  required value="0">
                                                        @endif
                                                    </div>

                                                    <input style="width: 76px" hidden="" type='text' id='tipo_afec{{$h}}' name='tipo_afec[]' readonly="readonly" class="monto0 form-control limp" onkeyup="multi({{$h}})" required  autocomplete="off" value="{{strtok($cotizacion_registros->servicio->tipo_afec_i_serv->informacion," ")}}"  />
                                                    <input  class="celda" name="articulo[]" id="input_prod{{$h}}" value="{{$cotizacion_registros->servicio->id}} | {{$cotizacion_registros->servicio->codigo_servicio}} | {{$cotizacion_registros->servicio->codigo_original}} | {{$cotizacion_registros->servicio->nombre}}" class="limp" hidden>
                                                @endif
                                                <input type='hidden' id='promedio_original{{$h}}' name='promedio_original[]' class="form-control limp" required value="{{$cotizacion_registros->promedio_original}}">
                                            </td>
                                            <td>
                                                <input type="text" readonly name="precio_unitario_descuento[]" id="precio_unitario_descuento{{$h}}" class="form-control limp" value="{{$cotizacion_registros->precio_unitario_desc}}">
                                            </td>
                                            <td>

                                                @if(isset($cotizacion->comisionista->cod_vendedor))
                                                    <input style="width: 76px" type='hidden' name="comision[]" id='comision{{$h}}'  readonly="readonly" class="form-control"  required  autocomplete="off" value="{{$cotizacion->comisionista->comision}}" />
                                                @else
                                                    <input style="width: 76px" type='hidden' name="comision[]" id='comision{{$h}}'  readonly="readonly" class="form-control"  required  autocomplete="off" value="0" />
                                                @endif
                                                <input type="text" readonly name="precio_unitario_comision[]" id="precio_unitario_comision{{$h}}" class="form-control limp" value="{{$cotizacion_registros->precio_unitario_comi}}">
                                            </td>
                                            <td>
                                                <input type="text" name="total_inp" id="total{{$h}}" readonly class="form-control limp" value="{{($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)}}">
                                                <input type='text' id='afectacion{{$h}}'  style="width: 76px"  name='afectacion' disabled="disabled" class="afectacion form-control limp" hidden="" required  autocomplete="off" value="{{$cotizacion_registros->precio_unitario_comi}}" />
                                                {{-- <input style="width: 76px" type='text' id='precio_unitario_igv{{$h}}' name='precio_unitario_igv[]' readonly="readonly" class="form-control" required autocomplete="off" /> --}}
                                            </td>
                                        </tr>
                                        <span hidden>{{$h++}}</span>
                                        <span hidden>{{ $sume = ($cotizacion_registros->precio_unitario_comi * $cotizacion_registros->cantidad)+$sume}}</span>
                                    @endforeach
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <td colspan="3" rowspan="3">
                                            <h3 align="left" class="h3-total" id="left_h3">
                                                <?php
                                                    $v=new NumeroALetras() ;
                                                    $letra=($v->toInvoice($end, 2));
                                                // $end_final_point=strstr($end2, '.', false);
                                                // $end_final=str_replace('.', '',$end_final_point);
                                                ?>
                                                Son : {{ucfirst(mb_strtolower($letra,'UTF-8'))}} {{$cotizacion->moneda->nombre }}
                                            </h3>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Subtotal:</td>
                                        <td colspan="2">
                                            <input id='subtotal_gravado'  disabled="disabled"  hidden="" class="form-control limp_txt" required value="{{$sub_total}}"/>
                                            <input type="text" id="sub_total" name="sub_total" disabled class="form-control limp_txt" value="{{$sub_total}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Igv:</td>
                                        <td colspan="2">
                                            <input type="text" id="igv_input" name="igv_input" disabled class="form-control limp_txt" value="{{number_format(round($igv_p, 2),2)}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total:</td>
                                        <td colspan="2">
                                            <input type="text" id="total_final" name="total_final" disabled class="form-control limp_txt" value="{{number_format(round($end, 2),2)}}">
                                        </td>
                                    </tr>
                                </tfooter>
                            </table>
                            <br>
                            <div class="col-sm-12" align="right">
                                <button  data-style="zoom-out" class="guardar ladda-button btn btn-primary btn-outline" type="submit" >Guardar</button>
                                <button class="btn btn-primary  demo3 float-right" style="margin-left: 10px;" type="button"  >Guardar y Finalizar</button>
                                <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden="" data-style="zoom-out" >
                                </button>
                            </div>
                        </form>
                        @else
                    @endif
                </div>
                <!-- /table-responsive -->
                <br>
                <!-- Fin Totales de Productos -->
                @include('layout_bancos')
                <br>
                @include('layout_firma_pie_hoja')
            </div>
        </div>
    </div>
</div>
<style>
    .row {
        justify-content: center;
    }
    .input_small > div {
        margin-top: 2px ;
        margin-bottom: 2px ;
    }
    .input_small > div > input {
        padding: 5px 10px;
    }
    .input_small > div > select{
        padding: 5px 10px;
    }
    #auto{
        cursor: pointer;
        box-shadow: 0px 0px 1px #000;
        display: inline-block;
    }
    /* #auto:hover{
        opacity: .8;
    } */
    #div-mostrar{
        margin: auto;
        height: 0px;
        transition: height .4s;
        color:white;
        text-align: right;
    }
    /* #auto:hover{
        opacity: .8;
    } */
    /* #div-mostrar{
        height: 50px;
    } */
    .form-control{border-radius: 10px; padding: 10px }
    /* .ibox-tools a{color: white !important} */
    .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] { -moz-appearance:textfield; }
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
    .check{-webkit-appearance: none;height: 34px;background-color: #ffffff00;-moz-appearance: none;border: none;appearance: none;width: 90px;border-radius: 10px;}
    .div_check{position: relative;top: -33px;left: 0px;background-color: #ffffff00;  top: -35;}
    .check:checked {background: #0375bd6b;}
    .text_des{border-radius: 10px;border: 1px solid #e5e6e7;width: 80px;padding: 6px 12px;}
    .limp{
        width: 90px;
    }
    .limp_txt{
        width: 100%;
    }
    .mostrar{
        display: ;
    }
    .no_mostrar{
        display: none;
    }
    .select2-hidden-accessible{
        width: 0px;
        margin: 0px;
        width: auto;
    }
    .select2-selection.select2-selection--single{
        text-align: left;
    }

    //Estilos nuevos para la seccion de renovacion
    .renovacion {
        padding: 0;
        margin-bottom: 15px;
        margin-top: 8px;
    }

    .switch-container {
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
        margin: 0;
        flex-shrink: 0;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .3s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    input:checked + .slider {
        background-color: #1ab394;
    }

    input:focus + .slider {
        box-shadow: 0 0 2px #1ab394;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .switch-label {
        font-size: 13px;
        color: #676a6c;
        font-weight: 500;
        cursor: pointer;
        user-select: none;
        margin: 0;
        line-height: 24px;
        white-space: nowrap;
    }

    #renovacion_container {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .renovacion select:focus {
        outline: none;
        box-shadow: none;
        border-color: #e5e6e7;
    }

    .renovacion hr {
        display: none;
    }

    .form-control-sm {
        height: 34px;
        padding: 0.375rem 0.75rem;
        font-size: 13px;
        line-height: 1.5;
        border-radius: 1px;
    }

    #renovacion_container select {
        font-size: 13px;
        height: 34px;
        padding: 0.375rem 0.75rem;
        line-height: 1.5;
        border: 1px solid #e5e6e7;
        width: 100%;
    }

    #extra_selects select {
        font-size: 13px;
        height: 34px;
        padding: 0.375rem 0.75rem;
        line-height: 1.5;
        margin-bottom: 0;
        border: 1px solid #e5e6e7;
        width: 100%;
    }

    .calendar-container {
        background: #fff;
        border-radius: 4px;
        padding: 8px;
        border: 1px solid #e5e6e7;
        margin-top: 6px;
        max-width: 260px;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        padding-bottom: 6px;
        border-bottom: 1px solid #e5e6e7;
    }

    .calendar-header h6 {
        font-size: 12px;
        font-weight: 600;
        color: #333;
        margin: 0;
        flex: 1;
        text-align: center;
    }

    .calendar-nav-btn {
        background: #fff;
        border: 1px solid #e5e6e7;
        border-radius: 3px;
        width: 26px;
        height: 26px;
        padding: 0;
        color: #676a6c;
        transition: all 0.2s;
        cursor: pointer;
    }

    .calendar-nav-btn:hover:not(:disabled) {
        background: #1ab394;
        color: white;
        border-color: #1ab394;
    }

    .calendar-nav-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .calendar-nav-btn i {
        font-size: 11px;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
    }

    .calendar-day-header {
        text-align: center;
        font-weight: 600;
        font-size: 10px;
        padding: 5px 0;
        color: #676a6c;
        background: #f8f9fa;
        border-radius: 2px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 2px;
        cursor: pointer;
        font-size: 10px;
        border: 1px solid transparent;
        transition: all 0.2s;
        color: #333;
        min-height: 24px;
        max-height: 26px;
    }

    .calendar-day.selectable {
        cursor: pointer;
        background: #fff;
    }

    .calendar-day.selectable:hover {
        background: #e8f4f8;
        border-color: #1c84c6;
    }

    .calendar-day.disabled {
        color: #ccc;
        cursor: not-allowed;
        background: #f9f9f9;
    }

    .calendar-day.selected {
        background: #1c84c6 !important;
        color: white !important;
        font-weight: 600;
        border-color: #1c84c6;
    }

    .calendar-day.fecha-emision {
        background: #1ab394 !important;
        color: white !important;
        font-weight: 600;
        border-color: #1ab394 !important;
    }

    .calendar-day.fecha-emision:hover {
        background: #18a689 !important;
        border-color: #18a689 !important;
    }

    .calendar-day.fecha-emision.selected {
        background: #1c84c6 !important;
        color: white !important;
        box-shadow: 0 0 0 2px #1ab394;
        border-color: #1c84c6 !important;
    }

    .renovacion .row {
        margin-bottom: 6px;
    }
</style>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- Jquery Validate -->
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js')}}"></script>
<!-- Sweet alert -->
<link href="{{ asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
{{-- //TICKET --}}
{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
<script>
    $('.demo3').click(function () {
        if(document.forms['coti_update'].reportValidity()){
            swal({
                title: "¿Estas seguro que deseas Finalizar?",
                text: "Una vez Finalizado, no podras editar esta Cotizacion",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3686ff",
                confirmButtonText: "Si, Finalizar",
                cancelButtonText: "Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        swal("Edicion de Cotizacion Cerrado", "No se va a poder editar de nuevo", "success");
                        $(".finalizar").click();
                        $(".guardar").attr('disabled', true);
                    } else {
                        swal("Cancelado", "Cancelando el Finalizar", "error");
                    }
                });
        }else{
            console.log('campos incompletos')
        }
    });
        $(document).ready(function () {
    });
    $(document).ready(function (){
        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 8000 });
    });

    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    function mostrarMensaje(mensaje){
       $("#divmsg").empty(); //limpiar div
       $("#divmsg").append(mensaje);
       $("#divmsg").show(200);
    }
    // {{-- Darle valor a cada Boton si es Finalizar o solo Guardar --}}
    $(".guardar").on('submit ', function () {
        $(".demo3").attr('disabled', true);
        var data = `<input value="1" type='hidden' name='submit' class="form-control" required/>  <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
        $('#inp_s').append(data);

    });
    $(".finalizar").on('click', function () {
        var data = `<input value="2" type='hidden' name='submit' class="form-control" required/>   <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
        $('#inp_s').append(data);
        // $(".guardar").remove();
    });
    function click_editar(){
        // MOSTRAR LOS INPUTS
        $('.div-editar').removeClass('no_mostrar');
        $('.div-editar').addClass('mostrar');
        // OCULTAR TABLA
        $('.table-no').addClass('no_mostrar');
        // BOTONES
        $('.btn-no-editar').removeClass('no_mostrar');
        $('.btn-editar').addClass('no_mostrar');
    }
    function click_cancelar_editar(){
        // OCULTAR INPUTS
        $('.div-editar').removeClass('mostrar');
        $('.div-editar').addClass('no_mostrar');
        // MOSTRAR TABLA
        $('.table-no').removeClass('no_mostrar');
        $('.table-no').addClass('mostrar');

        $('.btn-editar').removeClass('no_mostrar');
        $('.btn-no-editar').addClass('no_mostrar');
    }

    $(document).ready(function() {
        $('#btn_ticket').click(function(){
            var id_fac =  $(`[id='id']`).val();
           $.ajax({
               type: "post",
                url: "{{ route('ticket_ajax_coti') }}",
                 data: {
                    '_token': $('input[name=_token]').val(),
                    'id' : id_fac
                    },
               success: function(response){
                   if(response==1){
                       // alert('Imprimiendo Ticket');
                   }else{
                       alert('Error');
                   }
               }
           });
        });
    });
</script>

<script type="text/javascript">
    //*Condicional para el tipo de factura
    var tipo_coti = $('#tipo_coti').val();
    var cliente_default = $('#cliente_id').val();
    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        ajax: {
            minimumInputLength: 1,
            url: "{{ route('pa.clients') }}",
            dataType: 'json',
            type: "POST",
            delay: 10,
            data: function (params) {
                return {
                    _token: "{{ csrf_token() }}",
                    search: params.term, // search term
                    tipo_coti: tipo_coti,
                    select_default: cliente_default
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

    var clic = 1;
    function divAuto(){
       if(clic==1){
       document.getElementById("div-mostrar").style.height = "50px";
       clic = clic + 1;
       } else{
        document.getElementById("div-mostrar").style.height = "0px";
        clic = 1;
       }
    }

    function ajax_l(){
        var numeros = $('[id="total_final"]').val();
        var moneda = $('[id="moneda"]').val();
        $.ajax({
            type: "post",
            url: "{{route('pa.numberletters')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'numeros': numeros,
                'moneda': moneda
            },
            success: function(msg){
                console.log(msg);
                $('.h3-total').html(msg);
            }
        });
    }

    //AUMENTO DE INPUTS
    var i = {{$h}};
    $(".addmore").on('click', function () {
        var data = `
        <tr>
            <td>
                <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="nuevo">
                <button class="btn btn-danger e  borrar"><i class="fa fa-trash"></i></button>
            </td>
            <td>
                <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})"  autocomplete="off" required></select>
                </select>
                <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control limp_txt" autocomplete="off" style="margin-top: 5px;" ></textarea>
                <input style="width: 76px" hidden="" type='text' id='tipo_afec${i}' name='tipo_afec[]' readonly="readonly" class="monto0 form-control" onkeyup="multi(${i})" required  autocomplete="off"  />
                <input class="celda" name="articulo[]" id="input_prod${i}" hidden >
            </td>
            <td>
                <input type="text" class="form-control limp" name="stock" id="stock${i}" readonly>
            </td>
            <td>
                <input type="text"  name="cantidad[]" id="cantidad${i}" class="form-control limp" onkeyup="multi(${i})" >
            </td>
            <td>
                <input type="text"  name="precio[]" id="precio${i}" class="form-control limp" readonly>
            </td>
            <td>
                <div style="position: relative;">
                    <input class="text_des limp" type='text' id='descuento${i}' name='descuento[]' readonly="readonly" required autocomplete="off"/>
                </div>
                <div  class="div_check">
                    <input class="check" type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
                </div>
                <input type='hidden' id='check_descuento${i}' name='check_descuento[]' class="form-control limp"  required>
                <input type='hidden' id='promedio_original${i}' name='promedio_original[]' class="form-control limp" required >
            </td>
            <td>
                <input type="text" readonly name="precio_unitario_descuento[]" id="precio_unitario_descuento${i}" class="form-control limp">
            </td>
            <td>
                <input style="width: 76px" type='hidden' name="comision[]" id='comision${i}'  readonly="readonly" class="form-control limp"  required  autocomplete="off" />
                <input type="text" readonly name="precio_unitario_comision[]" id="precio_unitario_comision${i}" class="form-control limp" >
            </td>
            <td>
                <input type="text" name="total_inp" id="total${i}" readonly class="form-control limp" >
                <input type='text' id='afectacion${i}'    name='afectacion' disabled="disabled" class="afectacion form-control" hidden="" required  autocomplete="off"/>
            </td>
        </tr>
        `;
        $('.tables').append(data);

        i++;
        articlesSelect2();
        $(".borrar").prop("disabled", false);
        $(".addmore").prop("disabled", false);

        const section = document.getElementById("left_h3");
        console.log(section);
        section.scrollIntoView({block: "end", behavior: "smooth"});

    });
    $(document).ready(function() {
        articlesSelect2();
    });
    function articlesSelect2() {
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Articulo",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.articles') }}",
                dataType: 'json',
                type: "POST",
                // delay: 1500,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term // search term
                    };
                },
                processResults: function (data) {
                    //validador de articulos multiples
                    let data_length = data.length;
                    let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                    let articles_selected_count_ajax = articles_selected_ajax.length;
                    for(var z=0;z<articles_selected_count_ajax;z++){
                        var selected_ajax=document.getElementsByClassName("select2_demo_3 select_change")[z].value;
                        for(var y=0;y<data_length;y++){
                            if(selected_ajax == data[y].id+ " | " + data[y].codigo + " | " + data[y].codigo_original + " | " + data[y].nombre){
                                if(data[y].tipo == 'producto'){
                                    data[y].disabled=true;
                                }else{
                                    data[y].disabled=false;
                                }
                            }
                        }
                    }
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id:  item.id + " | " + item.codigo + " | " + item.codigo_original + " | " + item.nombre,
                                text: item.id + " | " + item.codigo + " | " + item.codigo_original + " | " + item.nombre,
                                disabled: item.disabled
                            };
                        })
                    };
                },
                cache: true,
                passive: true
            }
        });
    }

    function ajax (a){
        console.log(a);
        var articulo = document.getElementById(`articulo${a}`).value;
        console.log(articulo);
        document.getElementById(`input_prod${a}`).value = articulo;

        var almacen = $('[id="almacen_id"]').val();
        var moneda = $('[id="moneda_id"]').val();
        $.ajax({
            type: "post",
            url: "{{ route('pa.description') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'articulo': articulo,
                'almacen': almacen,
                'moneda': moneda
            },
            success: function (msg) {
                $(`#descripcion${a}`).val(msg.description);
                $(`#tipo_afec${a}`).val(msg.afectacion);
                $(`#precio${a}`).val(msg.price);
                $(`#cantidad${a}`).val(1);
                $(`#precio_unitario_descuento${a}`).val(msg.price);
                $(`#promedio_original${a}`).val(msg.average);
                $(`#stock${a}`).val(msg.amount);
                $(`#descuento${a}`).val(msg.discount);
                $(`#check_descuento${a}`).val(0);
                $(`#cantidad${a}`).attr('max', msg.amount );
                // $(`#cantidad`).attr('max', msg.amount );
                var separador=" ";
                var comision = document.querySelector(`#comisionista`).value;
                document.getElementById(`comision${a}`).value = comision;
                multi(a);
                $(`.addmore`).prop("disabled", false);
            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });
    }
    //Funcion de comision
    function comision(){
        var comision=document.getElementById(`comisionista`).value;
        if(comision != 0){

            var campos_num = document.getElementsByClassName("total").length;

            document.getElementById(`comision0`).value = comision_v;

            if(campos_num!=1){
                for(var i=2;i<=campos_num;i++){
                    document.getElementById(`comision${i}`).value = comision_v;
                }
            }
            multi(0);
            if(campos_num!=1){
                for(var i=2;i<=campos_num;i++){
                    multi(i);
                }
            }
        }
    }
    function multi(a){
        // var total = 1;
        // var totales = 0;
        // $(`.monto${a}`).each(function(){
        //     if (!isNaN(parseFloat($(this).val()))) {
        //         change= true;
        //         total *= parseFloat($(this).val());
        //     }
        // });
        // total = (change)? total:0;
        // variables
        var checkBox = document.getElementById(`check${a}`);
        var cantidad = document.querySelector(`#cantidad${a}`).value;
        var promedio_original=document.querySelector(`#promedio_original${a}`).value;
        var descuento = document.querySelector(`#descuento${a}`).value;
        var afec = document.querySelector(`#tipo_afec${a}`).value;
        var precio = document.querySelector(`#precio${a}`).value
        var comision = document.getElementById(`comisionista`).value;
        var multiplier = 100;
        var igv = {{$igv->renta}};
        if(checkBox.checked == true && descuento > 0){
            var precio_uni = precio-(promedio_original*(descuento/multiplier));
            var precio_uni_dec = Math.round(precio_uni * multiplier) / multiplier;
            document.getElementById(`check_descuento${a}`).value = descuento;
            document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;
            var comision_mul = precio_uni_dec + (precio_uni_dec*(comision/100));
            var comision_final = Math.round(comision_mul * multiplier) / multiplier;
            document.getElementById(`precio_unitario_comision${a}`).value = comision_final;

            var final = comision_final*cantidad;
            var final_decimal = Math.round(final * multiplier) / multiplier;
            var igv_final = final_decimal * (igv/multiplier);
            var igv_dec = Math.round(igv_final * multiplier ) / multiplier;
            var final_igv_round = parseFloat(final) + parseFloat(igv_dec);
            if(afec.toString() == "Gravado"){
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = final_decimal;
                // document.getElementById(`precio_unitario_igv${a}`).value = Math.round(final_igv_round * multiplier) / multiplier;
            }else{
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = 0;
                // document.getElementById(`precio_unitario_igv${a}`).value = final_decimal;
            }
        }else{
            document.getElementById(`check_descuento${a}`).value = 0;
            var precio_comi = parseFloat(precio) + (parseFloat(precio) * parseFloat(comision)/ multiplier);
            var end = Math.round(precio_comi * multiplier) / multiplier;
            var final2=cantidad*end;
            var final_decimal = Math.round(final2 * multiplier) / multiplier;
            document.getElementById(`precio_unitario_descuento${a}`).value = precio;
            document.getElementById(`precio_unitario_comision${a}`).value = end;
            var igv_prc = final_decimal * (igv/multiplier);
            var igv_decimal = Math.round(igv_prc * multiplier) / multiplier;
            var final_igv_round = parseFloat(final_decimal) + parseFloat(igv_decimal);
            if(afec.toString() == "Gravado"){
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = final_decimal;
                // document.getElementById(`precio_unitario_igv${a}`).value = Math.round(final_igv_round * multiplier) / multiplier;
            }else{
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = 0;
                // document.getElementById(`precio_unitario_igv${a}`).value = final_decimal;
            }
        }
        var for_tot = $('[name="total_inp"]');
        var tot = 0;
        for_tot.each(function(){
            tot += parseFloat($(this).val());
        });
        var total_ipt = Math.round(tot * multiplier) / multiplier;
        $('#sub_total').val(total_ipt);
        //solo gravado
        var to_grava = $('[name="afectacion"]');
        var t_grava = 0;
        to_grava.each(function(){
            t_grava += parseFloat($(this).val());
        });
        var tot_gra_dec = Math.round(t_grava * multiplier) / multiplier;
        // console.log(t_grava);
        $('#subtotal_gravado').val(tot_gra_dec);
        var igv = {{$igv->renta}};
        var igv_val = tot_gra_dec * (igv / multiplier);

        var igv_dec_val = Math.round(igv_val * multiplier) / multiplier;
        var end = igv_dec_val + parseFloat(total_ipt);
        var end2 = Math.round(end * multiplier) / multiplier;
        document.getElementById("igv_input").value = igv_dec_val;
        document.getElementById("total_final").value = end2;
        // console.log(tot);
        ajax_l();
    }
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        $(".addmore").prop("disabled", false);
        if (e>1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        }else{
            $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
            $(".limp").val("");
            $(".limp_txt").val("");
            $(".select2_demo_3").val(null).trigger("change");
        }
        var multiplier = 100;
        var igv = {{$igv->renta}};
        var for_tot = $('[name="total_inp"]');
        var tot = 0;
        for_tot.each(function(){
            tot += parseFloat($(this).val());
        });
        var total_ipt = Math.round(tot * multiplier) / multiplier;
        $('#sub_total').val(total_ipt);
        //solo gravado
        var to_grava = $('[name="afectacion"]');
        var t_grava = 0;
        to_grava.each(function(){
            t_grava += parseFloat($(this).val());
        });
        var tot_gra_dec = Math.round(t_grava * multiplier) / multiplier;
        // console.log(t_grava);
        $('#subtotal_gravado').val(tot_gra_dec);
        var igv = {{$igv->renta}};
        var igv_val = tot_gra_dec * (igv / multiplier);

        var igv_dec_val = Math.round(igv_val * multiplier) / multiplier;
        var end = igv_dec_val + parseFloat(total_ipt);
        var end2 = Math.round(end * multiplier) / multiplier;
        document.getElementById("igv_input").value = igv_dec_val;
        document.getElementById("total_final").value = end2;
        // console.log(tot);
        ajax_l();
    });
</script>

{{-- script para manejar las renovaciones --}}
<script>
// ==================== VARIABLES GLOBALES ====================
let calendarioMesActual = new Date();
let calendarioAnualMesActual = new Date();
let fechaEmisionGlobal = new Date();
let diaSeleccionadoAnual = null;
let mesSeleccionadoAnual = null;

// ==================== CALENDARIO MENSUAL CORREGIDO ====================
function generarCalendarioMensual(mesOffset = 0) {
    const extraSelects = document.getElementById("extra_selects");

    @if($renovacion && $fecha_vencimiento)
        const fechaVencimientoText = "{{ $fecha_vencimiento->format('d-m-Y') }}";
        let fechaReferencia;

        if (fechaVencimientoText) {
            const separador = fechaVencimientoText.includes('/') ? '/' : '-';
            const partes = fechaVencimientoText.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaReferencia = new Date(anio, mes, dia);
            } else {
                fechaReferencia = new Date();
            }
        } else {
            fechaReferencia = new Date();
        }
    @else
        // Si no hay vencimiento, usar fecha de emisión
        const fechaEmisionText = "{{ $cotizacion->fecha_emision }}";
        let fechaReferencia;

        if (fechaEmisionText) {
            const separador = fechaEmisionText.includes('/') ? '/' : '-';
            const partes = fechaEmisionText.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaReferencia = new Date(anio, mes, dia);
            } else {
                fechaReferencia = new Date();
            }
        } else {
            fechaReferencia = new Date();
        }
    @endif

    if (isNaN(fechaReferencia.getTime())) {
        fechaReferencia = new Date();
    }

    fechaEmisionGlobal = fechaReferencia;

    if (mesOffset === 0) {
        // Iniciar el calendario en el mes de la fecha de referencia (vencimiento)
        calendarioMesActual = new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), 1);
    }

    const mesVista = calendarioMesActual.getMonth();
    const anioVista = calendarioMesActual.getFullYear();

    // Fecha máxima: 30 días después de la fecha de referencia (vencimiento)
    const fechaMaxima = new Date(fechaReferencia);
    fechaMaxima.setDate(fechaMaxima.getDate() + 30);

    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    // Calcular si se puede retroceder (solo meses que contengan la fecha de referencia o posteriores)
    const primerDiaMesAnterior = new Date(anioVista, mesVista - 1, 1);
    const puedeRetroceder = primerDiaMesAnterior >= new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), 1);

    // Calcular si se puede avanzar (hasta 30 días después de la fecha de referencia)
    const puedeAvanzar = new Date(anioVista, mesVista + 1, 1) <= fechaMaxima;

    let html = `
        <div class="calendar-container">
            <div class="calendar-header">
                <button type="button" class="btn btn-xs calendar-nav-btn" id="prevMonth" ${!puedeRetroceder ? 'disabled' : ''}>
                    <i class="fa fa-chevron-left"></i>
                </button>
                <h6>${meses[mesVista]} ${anioVista}</h6>
                <button type="button" class="btn btn-xs calendar-nav-btn" id="nextMonth" ${!puedeAvanzar ? 'disabled' : ''}>
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
            <div class="calendar-grid">
                <div class="calendar-day-header">Lu</div>
                <div class="calendar-day-header">Ma</div>
                <div class="calendar-day-header">Mi</div>
                <div class="calendar-day-header">Ju</div>
                <div class="calendar-day-header">Vi</div>
                <div class="calendar-day-header">Sa</div>
                <div class="calendar-day-header">Do</div>
    `;

    const ultimoDia = new Date(anioVista, mesVista + 1, 0);
    const diasEnMes = ultimoDia.getDate();
    const primerDiaSemana = new Date(anioVista, mesVista, 1).getDay();

    const ajusteDia = primerDiaSemana === 0 ? 6 : primerDiaSemana - 1;

    const ultimoDiaMesAnterior = new Date(anioVista, mesVista, 0);
    const diasMesAnterior = ultimoDiaMesAnterior.getDate();

    // Días del mes anterior (SIEMPRE deshabilitados en el show)
    for (let i = ajusteDia - 1; i >= 0; i--) {
        const dia = diasMesAnterior - i;
        html += `<div class="calendar-day disabled" style="color: #d1dade;">${dia}</div>`;
    }

    const diaReferencia = fechaReferencia.getDate();
    const mesReferencia = fechaReferencia.getMonth();
    const anioReferencia = fechaReferencia.getFullYear();

    // Días del mes actual
    for (let dia = 1; dia <= diasEnMes; dia++) {
        const fechaDia = new Date(anioVista, mesVista, dia);

        // Normalizar fechas a medianoche para comparación correcta
        const fechaDiaNormalizada = new Date(fechaDia.getFullYear(), fechaDia.getMonth(), fechaDia.getDate());
        const fechaReferenciaNormalizada = new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), fechaReferencia.getDate());

        const esFechaReferencia = dia === diaReferencia && mesVista === mesReferencia && anioVista === anioReferencia;
        const esAnteriorReferencia = fechaDiaNormalizada < fechaReferenciaNormalizada;
        const esPosteriorMaximo = fechaDia > fechaMaxima;
        const esDeshabilitado = esAnteriorReferencia || esPosteriorMaximo;

        let clases = 'calendar-day';
        if (esDeshabilitado) {
            clases += ' disabled';
        } else {
            clases += ' selectable';
            if (esFechaReferencia) clases += ' fecha-emision';
        }

        html += `<div class="${clases}"
                    data-dia="${dia}"
                    data-mes="${mesVista + 1}"
                    data-anio="${anioVista}">${dia}</div>`;
    }

    // Días vacíos al final
    const celdasUsadas = ajusteDia + diasEnMes;
    const filasNecesarias = Math.ceil(celdasUsadas / 7);
    const totalCeldas = filasNecesarias * 7;
    const diasVaciosFinal = totalCeldas - celdasUsadas;

    for (let i = 1; i <= diasVaciosFinal; i++) {
        html += `<div class="calendar-day disabled" style="color: #d1dade;">${i}</div>`;
    }

    html += `</div></div>`;
    extraSelects.innerHTML = html;

    // Eventos de navegación
    const prevBtn = document.getElementById('prevMonth');
    const nextBtn = document.getElementById('nextMonth');

    if (prevBtn && !prevBtn.disabled) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            calendarioMesActual.setMonth(calendarioMesActual.getMonth() - 1);
            generarCalendarioMensual(-1);
        });
    }

    if (nextBtn && !nextBtn.disabled) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            calendarioMesActual.setMonth(calendarioMesActual.getMonth() + 1);
            generarCalendarioMensual(1);
        });
    }

    // Eventos de selección de día
    document.querySelectorAll('.calendar-day.selectable').forEach(function(elemento) {
        elemento.addEventListener('click', function() {
            document.querySelectorAll('.calendar-day').forEach(el => {
                el.classList.remove('selected');
            });

            this.classList.add('selected');

            // ✅ ÚNICO CAMBIO: Guardar día del mes (1-31) directamente
            const diaSeleccionado = parseInt(this.getAttribute('data-dia'));
            document.getElementById('dia_mensual_hidden').value = diaSeleccionado;
        });
    });

    // Restaurar selección guardada
    const diaGuardado = document.getElementById('dia_mensual_hidden').value;
    if (diaGuardado && diaGuardado !== "") {
        const fechaSeleccionada = new Date(fechaEmisionGlobal);
        fechaSeleccionada.setDate(fechaSeleccionada.getDate() + parseInt(diaGuardado));

        const diaSelec = fechaSeleccionada.getDate();
        const mesSelec = fechaSeleccionada.getMonth();
        const anioSelec = fechaSeleccionada.getFullYear();

        if (mesSelec === mesVista && anioSelec === anioVista) {
            document.querySelectorAll('.calendar-day.selectable').forEach(el => {
                if (parseInt(el.getAttribute('data-dia')) === diaSelec) {
                    el.classList.add('selected');
                }
            });
        }
    }
}

// ==================== CALENDARIO ANUAL CORREGIDO ====================
function generarCalendarioAnual(mesOffset = 0) {
    const extraSelects = document.getElementById("extra_selects");

    // EN EL SHOW, USAR LA FECHA DE VENCIMIENTO COMO REFERENCIA
    @if($renovacion && $fecha_vencimiento)
        const fechaVencimientoText = "{{ $fecha_vencimiento->format('d-m-Y') }}";
        let fechaReferencia;

        if (fechaVencimientoText) {
            const separador = fechaVencimientoText.includes('/') ? '/' : '-';
            const partes = fechaVencimientoText.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaReferencia = new Date(anio, mes, dia);
            } else {
                fechaReferencia = new Date();
            }
        } else {
            fechaReferencia = new Date();
        }
    @else
        // Si no hay vencimiento, usar fecha de emisión
        const fechaEmisionText = "{{ $cotizacion->fecha_emision }}";
        let fechaReferencia;

        if (fechaEmisionText) {
            const separador = fechaEmisionText.includes('/') ? '/' : '-';
            const partes = fechaEmisionText.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaReferencia = new Date(anio, mes, dia);
            } else {
                fechaReferencia = new Date();
            }
        } else {
            fechaReferencia = new Date();
        }
    @endif

    if (isNaN(fechaReferencia.getTime())) {
        fechaReferencia = new Date();
    }

    if (mesOffset === 0) {
        calendarioAnualMesActual = new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), 1);
    }

    const mesVista = calendarioAnualMesActual.getMonth();
    const anioVista = calendarioAnualMesActual.getFullYear();

    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    // Calcular si se puede retroceder (solo meses que contengan la fecha de referencia o posteriores)
    const primerDiaMesAnterior = new Date(anioVista, mesVista - 1, 1);
    const puedeRetroceder = primerDiaMesAnterior >= new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), 1);

    let html = `
        <div class="calendar-container">
            <div class="calendar-header">
                <button type="button" class="btn btn-xs calendar-nav-btn" id="prevMonthAnual" ${!puedeRetroceder ? 'disabled' : ''}>
                    <i class="fa fa-chevron-left"></i>
                </button>
                <h6>${meses[mesVista]} ${anioVista}</h6>
                <button type="button" class="btn btn-xs calendar-nav-btn" id="nextMonthAnual">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
            <div class="calendar-grid">
                <div class="calendar-day-header">Lu</div>
                <div class="calendar-day-header">Ma</div>
                <div class="calendar-day-header">Mi</div>
                <div class="calendar-day-header">Ju</div>
                <div class="calendar-day-header">Vi</div>
                <div class="calendar-day-header">Sa</div>
                <div class="calendar-day-header">Do</div>
    `;

    const ultimoDia = new Date(anioVista, mesVista + 1, 0);
    const diasEnMes = ultimoDia.getDate();
    const primerDiaSemana = new Date(anioVista, mesVista, 1).getDay();

    const ajusteDia = primerDiaSemana === 0 ? 6 : primerDiaSemana - 1;

    const ultimoDiaMesAnterior = new Date(anioVista, mesVista, 0);
    const diasMesAnterior = ultimoDiaMesAnterior.getDate();

    // Días del mes anterior (SIEMPRE deshabilitados)
    for (let i = ajusteDia - 1; i >= 0; i--) {
        const dia = diasMesAnterior - i;
        html += `<div class="calendar-day disabled" style="color: #d1dade;">${dia}</div>`;
    }

    const diaReferencia = fechaReferencia.getDate();
    const mesReferencia = fechaReferencia.getMonth();
    const anioReferencia = fechaReferencia.getFullYear();

    // Días del mes actual
    for (let dia = 1; dia <= diasEnMes; dia++) {
        const fechaDia = new Date(anioVista, mesVista, dia);

        // Normalizar fechas a medianoche para comparación correcta
        const fechaDiaNormalizada = new Date(fechaDia.getFullYear(), fechaDia.getMonth(), fechaDia.getDate());
        const fechaReferenciaNormalizada = new Date(fechaReferencia.getFullYear(), fechaReferencia.getMonth(), fechaReferencia.getDate());

        const esFechaReferencia = dia === diaReferencia && mesVista === mesReferencia && anioVista === anioReferencia;
        const esAnteriorReferencia = fechaDiaNormalizada < fechaReferenciaNormalizada;

        let clases = 'calendar-day';
        if (esAnteriorReferencia) {
            clases += ' disabled';
        } else {
            clases += ' selectable';
            if (esFechaReferencia) clases += ' fecha-emision';
        }

        html += `<div class="${clases}"
                    data-dia="${dia}"
                    data-mes="${mesVista + 1}"
                    data-anio="${anioVista}">${dia}</div>`;
    }

    // Días vacíos al final
    const celdasUsadas = ajusteDia + diasEnMes;
    const filasNecesarias = Math.ceil(celdasUsadas / 7);
    const totalCeldas = filasNecesarias * 7;
    const diasVaciosFinal = totalCeldas - celdasUsadas;

    for (let i = 1; i <= diasVaciosFinal; i++) {
        html += `<div class="calendar-day disabled" style="color: #d1dade;">${i}</div>`;
    }

    html += `</div></div>`;

    extraSelects.innerHTML = html;

    // Navegación
    const prevBtn = document.getElementById('prevMonthAnual');
    const nextBtn = document.getElementById('nextMonthAnual');

    if (prevBtn && !prevBtn.disabled) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            calendarioAnualMesActual.setMonth(calendarioAnualMesActual.getMonth() - 1);
            generarCalendarioAnual(-1);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            calendarioAnualMesActual.setMonth(calendarioAnualMesActual.getMonth() + 1);
            generarCalendarioAnual(1);
        });
    }

    // Eventos de selección
    document.querySelectorAll('.calendar-day.selectable').forEach(function(elemento) {
        elemento.addEventListener('click', function() {
            document.querySelectorAll('.calendar-day').forEach(el => {
                el.classList.remove('selected');
            });

            this.classList.add('selected');

            // ✅ ÚNICO CAMBIO: Guardar día, mes y año directamente
            diaSeleccionadoAnual = parseInt(this.getAttribute('data-dia'));
            mesSeleccionadoAnual = parseInt(this.getAttribute('data-mes'));
            const anioSeleccionado = parseInt(this.getAttribute('data-anio'));

            document.getElementById('dia_anual_hidden').value = diaSeleccionadoAnual;
            document.getElementById('mes_anual_hidden').value = mesSeleccionadoAnual;
            document.getElementById('anio_anual_hidden').value = anioSeleccionado;
        });
    });

    // Restaurar selección guardada
    const diaGuardado = document.getElementById('dia_anual_hidden').value;
    const mesGuardado = document.getElementById('mes_anual_hidden').value;

    if (diaGuardado && diaGuardado !== "" && mesGuardado && mesGuardado !== "") {
        const diasAcumulados = parseInt(diaGuardado);

        // Calcular la fecha real sumando días acumulados a la fecha de referencia
        @if($renovacion && $fecha_vencimiento)
            const fechaVencimientoBase = "{{ $fecha_vencimiento->format('d-m-Y') }}";
            let fechaBase;

            if (fechaVencimientoBase) {
                const separador = fechaVencimientoBase.includes('/') ? '/' : '-';
                const partes = fechaVencimientoBase.split(separador);

                if (partes.length === 3) {
                    const dia = parseInt(partes[0]);
                    const mes = parseInt(partes[1]) - 1;
                    const anio = parseInt(partes[2]);
                    fechaBase = new Date(anio, mes, dia);
                } else {
                    fechaBase = new Date();
                }
            } else {
                fechaBase = new Date();
            }
        @else
            const fechaEmisionBase = "{{ $cotizacion->fecha_emision }}";
            let fechaBase;

            if (fechaEmisionBase) {
                const separador = fechaEmisionBase.includes('/') ? '/' : '-';
                const partes = fechaEmisionBase.split(separador);

                if (partes.length === 3) {
                    const dia = parseInt(partes[0]);
                    const mes = parseInt(partes[1]) - 1;
                    const anio = parseInt(partes[2]);
                    fechaBase = new Date(anio, mes, dia);
                } else {
                    fechaBase = new Date();
                }
            } else {
                fechaBase = new Date();
            }
        @endif

        const fechaSeleccionada = new Date(fechaBase);
        fechaSeleccionada.setDate(fechaSeleccionada.getDate() + diasAcumulados);

        diaSeleccionadoAnual = fechaSeleccionada.getDate();
        mesSeleccionadoAnual = fechaSeleccionada.getMonth() + 1;

        if (mesSeleccionadoAnual === mesVista + 1) {
            document.querySelectorAll('.calendar-day.selectable').forEach(el => {
                if (parseInt(el.getAttribute('data-dia')) === diaSeleccionadoAnual) {
                    el.classList.add('selected');
                }
            });
        }
    }
}

// ==================== EVENT LISTENERS ====================
document.addEventListener("DOMContentLoaded", function () {
    const checkRenovacion = document.getElementById("estado_renovacion");
    const contenedorRenovacion = document.getElementById("renovacion_container");
    const selectFecha = document.getElementById("select_fecha");
    const extraSelects = document.getElementById("extra_selects");

    // Al cargar, si hay frecuencia seleccionada, generar el calendario correspondiente
    if (selectFecha.value === "Mensual") {
        generarCalendarioMensual(0);
    } else if (selectFecha.value === "Anual") {
        generarCalendarioAnual(0);
    }

    checkRenovacion.addEventListener("change", function () {
        contenedorRenovacion.style.display = this.checked ? "block" : "none";
        if (!this.checked) {
            selectFecha.value = "";
            extraSelects.innerHTML = "";
            document.getElementById('dia_mensual_hidden').value = "";
            document.getElementById('dia_anual_hidden').value = "";
            document.getElementById('mes_anual_hidden').value = "";
            document.getElementById('anio_anual_hidden').value = "";
            diaSeleccionadoAnual = null;
            mesSeleccionadoAnual = null;
        }
    });

    selectFecha.addEventListener("change", function () {
        const selected = this.value;
        extraSelects.innerHTML = "";
        document.getElementById('dia_mensual_hidden').value = "";
        document.getElementById('dia_anual_hidden').value = "";
        document.getElementById('mes_anual_hidden').value = "";
        document.getElementById('anio_anual_hidden').value = "";
        diaSeleccionadoAnual = null;
        mesSeleccionadoAnual = null;

        if (selected === "Mensual") {
            generarCalendarioMensual(0);
        } else if (selected === "Anual") {
            generarCalendarioAnual(0);
        }
    });
});
</script>

@endsection
