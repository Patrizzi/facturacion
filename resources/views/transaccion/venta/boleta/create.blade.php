@extends('layout')
@section('title', 'Boleta ')
@section('atributo_actu', 'hidden')
@section('href_accion', route('boleta.index'))
@extends('layout_agregado_rapido')
{{-- Boton para modal de Clientes --}}

{{-- FIN DE MODAL CLIENTE --}}
@section('value_accion', 'Atrás')

{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
@section('content')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>
@if (session('repite'))
<div class="alert alert-success">
    {{ session('repite') }}
</div>
@endif

@if (session('campo'))
<div class="alert alert-success">
    {{ session('campo') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <a class="alert-link" href="#">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </a>
</div>
@endif

<div class="wrapper wrapper-content animated fadeInRight">
    <form action="{{route('boleta.store',$moneda->id)}}" enctype="multipart/form-data" method="post" onsubmit="return valida(this)" id="form_store">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                        <h3><strong> Datos del cliente</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div style="margin: auto 50px">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><strong>Cliente:</strong></label>
                                        <div class="col-sm-8">
                                            <select class="select2_demo_client" name="cliente" id="cliente" required="" value="{{old('nombre')}}">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><strong>Nombre:</strong></label>
                                        <div class="col-sm-8">
                                            <span class="form-control" id="nombre_cliente">&nbsp;</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><strong>RUC:</strong></label>
                                        <div class="col-sm-8">
                                            <span class="form-control" id="rucdni_cliente">&nbsp;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                        <h3><strong> Datos del Vendedor</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div style="margin: auto 50px">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><strong>Vendedor:</strong></label>
                                        <div class="col-sm-8">
                                            <span class="form-control" id="nombre_vendedor">{{auth()->user()->name}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><strong>Celular:</strong></label>
                                        <div class="col-sm-8">
                                            <span class="form-control" id="celular_vendedor">@if(auth()->user()->celular != null ) {{auth()->user()->celular}} @else <i>Sin celular</i> @endif</span>
                                            {{-- <input type="text" class="form-control" name="personal" disabled required="required" value="{{auth()->user()->name}}"> --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label"><strong>Correo:</strong></label>
                                        <div class="col-sm-8">
                                            <span class="form-control" id="celular_vendedor">@if(auth()->user()->email_user != null ) {{auth()->user()->email_user}} @else {{auth()->user()->email}}  @endif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                        <h3><strong>Datos de la Venta</strong></h3>
                    </div>
                    <input type="hidden" name="almacen" id="almacen_id" class="form-control " value="{{$sucursal->id}}" readonly="readonly">
                    <input type="hidden" id="moneda_id" class="form-control " value="{{$moneda->id}}" readonly="readonly">
                    <div class="panel-body">
                        <div class="row col-lg-12">
                            <div class="col-md-6" style="margin: auto 0px">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Orden de Compra:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Guía de Remisión:</strong></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="0" name="guia_r">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Comisionista:</strong></label>
                                    <div class="col-sm-8">
                                        <input list="browsersc2" class="form-control" id="comisionista" name="comisionista" required value="Sin comision - 0" onkeyup="comision()" autocomplete="off">
                                        <datalist id="browsersc2" >
                                            <option id="">Sin comision - 0 </option>
                                            @foreach($p_venta as $p_ventas)
                                                <option id="{{$p_ventas->id}}">{{$p_ventas->cod_vendedor}} - {{$p_ventas->personal->personal_l->nombres}} - <span style="color: red">{{$p_ventas->comision}}</span></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Forma de pago:</strong></label>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-12 pago_first_column">
                                                <select class="form-control" name="forma_pago"  id ="forma_pago" onchange="seleccionado_fp()">
                                                    @foreach($forma_pagos as $forma_pago)
                                                        <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
                                                    @endforeach
                                                <select>
                                            </div>
                                            <div class="col-sm-3" id="credito_pago" style="display: none;">
                                                <button  type="button" class='cuota_modal btn btn-w-m btn-info' id="cuota_modal"  data-toggle="modal" data-target="#cuotas_modal" style="margin-left: -5px">Cuotas</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin: auto 00px">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Fecha de Inicio:</strong></label>
                                    <div class="col-sm-8">
                                        {{-- <input type="date" class="form-control" value="2024-11-06" /> --}}
                                        <input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group row" id="data_1">
                                    <label class="col-sm-4 col-form-label"><strong>Fecha de Vencimiento:</strong></label>
                                    <div class="col-sm-8 input-group date">
                                        <span class="input-group-addon" style="display: none"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="{{date("d-m-Y")}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Moneda:</strong></label>
                                    <div class="col-sm-5" style="padding-right: 0px">
                                        <input type="text" name="moneda" id="moneda" class="form-control " value="{{ucwords($moneda->nombre)}}" readonly="readonly">
                                    </div>
                                    <a class="col-sm-2 button_money" onclick="changeMoney()">
                                        <button style="" type="button" class='money_change btn btn-w-m btn-info' id="button_changeMoney">
                                            Cambiar
                                        </button>
                                    </a>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label"><strong>Tipo de Operacion</strong></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2_operacion" name="tipo_operacion">
                                            @foreach($tipo_operacion as $index => $t_op)
                                                <option id="{{$t_op->id}}" @if($index == 0) selected @endif >{{$t_op->codigo}} - {{$t_op->informacion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"><strong>Observación:</strong></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="observacion" id="observacion" autocomplete="off" placeholder="Observación"  rows="2" style="margin-top: 5px;"  >Emitimos la siguiente Boleta a vuestra solicitud</textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- Articulos --}}
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table cellspacing="0" class="table tables">
                                        <thead>
                                            <tr style="background-color: #3366cc; color: white; text-align: center;font-size: 90%">
                                                <th style="vertical-align: middle;width: 50px;">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </th>
                                                <th style="width: 300px; text-align: left !important">Artículo</th>
                                                <th>Stock</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Dcto</th>
                                                <th>PU. Dcto.</th>
                                                <th>PU. Com.</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><button type="button" class='addmore btn btn-sm btn-success'><i class="fa fa-plus-square" aria-hidden="true"></i></button></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal Tipo de Pago | Cuotas -->
<div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert"   id="alert_campos" style="display: none">
                    <strong style="font-size:11px">Rellenar todos los campos</strong>
                    <button type="button" class="close_model_rc close" onclick="cerrar_but_rc()" style="padding: 6;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-danger alert-dismissible fade show" role="alert"  id="suma_campos" style="display: none" >
                    <strong style="font-size:11px">La suma de las cuotas es diferente del monto total</strong>
                    <button type="button" class="close_model_mt close" onclick="cerrar_but_mt()" style="padding: 6;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row_number">
                    <div class="pago_modal row">
                        <div class="col-sm-1"><label>Fecha:</label></div>
                        <div class="col-sm-4">
                            <input type="date" name="fecha_pago[]" id="fecha_pago0"  class="fecha_pago form-control" min="{{$fecha_1}}">
                        </div>
                        <div class="col-sm-1"><label>Monto:</label></div>
                        <div class="col-sm-4">
                            <div class="input-group mb-3" style="padding-right:15px">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">{{$moneda->simbolo}}</span>
                            </div>
                            <input type="text" name="monto_pago[]" id="monto_pago0" class="monto_pago form-control"  onkeypress="return filterFloat(event,this);" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label ><button type="button"  aria-hidden="true" id="add_pago" class="add_pago btn btn-success"><i class="fa fa-plus-square-o fa-lg" > </i></button></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="display: block">
                <div class="row">
                    <div class="col-sm-6" style="">
                        <label for=""><strong>Precio Total: &nbsp;</strong><span id="simb_fot">{{$moneda->simbolo}}</span>&nbsp;</label><label id="cuotas_footer"></label>
                    </div>
                    <div class="col-sm-6" align="right">
                        <button type="button" id="button_cuotas_save" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="{{route('boleta.store',$moneda->id)}}" enctype="multipart/form-data" method="post" onsubmit="return valida(this)" id="form_store">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-sm-4 text-left" align="left">
                                <address class="col-sm-4" align="left">
                                   <img src="{{asset('img/logos/')}}//{{$empresa->foto}}" alt="" width="300px">
                               </address>
                            </div>
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4 ">
                                <div class="form-control ruc tooltip-demo" style="height: 125px">
                                    <center>
                                        <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                        <h2>BOLETA ELECTRONICA</h2>
                                        <h4>{{$boleta_numero}} <span class="small" data-toggle="tooltip" data-placement="bottom" title="N° Referencial"><i class="fa fa-question-circle"></i></span></h4>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Cliente</td>
                                    <td>:</td>
                                    <td>
                                        {{-- <select class="select2_demo_client" name="cliente" id="cliente" required="" value="{{old('nombre')}}">
                                        </select> --}}
                                    </td>
                                    <td>Comisionista</td>
                                    <td>:</td>
                                    <td> 
                                        <input list="browsersc2" class="form-control m-b" id="comisionista" name="comisionista" required value="Sin comision - 0" onkeyup="comision()" autocomplete="off">
                                        <datalist id="browsersc2" >
                                            <option id="">Sin comision - 0 </option>
                                            @foreach($p_venta as $p_ventas)
                                                <option id="{{$p_ventas->id}}">{{$p_ventas->cod_vendedor}} - {{$p_ventas->personal->personal_l->nombres}} - <span style="color: red">{{$p_ventas->comision}}</span></option>
                                            @endforeach
                                        </datalist>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Moneda</td>
                                    <td>:</td>
                                    <td class="row" style="padding-left: 20px">
                                        <div class="row">
                                            
                                            <div class="col-sm-5">
                                                {{-- <input type="text" name="moneda" id="moneda" class="form-control " value="{{$moneda->nombre}}" readonly="readonly"> --}}
                                            </div>
                                            <a class="col-sm-5 button_money" onclick="changeMoney()">
                                                <button style="height: 35px;width: auto" type="button" class='money_change btn btn-info' id="button_changeMoney">
                                                    @if($moneda->tipo=='nacional')
                                                        Dolares 
                                                    @elseif($moneda->tipo=='extranjera') 
                                                        Soles 
                                                    @endif
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                    <td>Guia remision</td>
                                    <td>:</td>
                                    <td>
                                        {{-- <input type="text" class="form-control" value="0" name="guia_r"> --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Vendedor</td>
                                    <td>:</td>
                                    <td>
                                        {{-- <input type="text" class="form-control" name="personal" disabled required="required" value="{{auth()->user()->name}}"> --}}
                                    </td>
                                    <td>Tipo de Operacion</td>
                                    <td>:</td>
                                    <td>
                                        {{-- <select class="form-control" name="tipo_operacion" >
                                        @foreach($tipo_operacion as $t_op)
                                            <option id="{{$t_op->id}}">{{$t_op->codigo}} - {{$t_op->informacion}}</option>
                                        @endforeach
                                        </select> --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fecha</td>
                                    <td>:</td>
                                    <td>
                                        {{-- <input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly"> --}}
                                    </td>
                                    <td>Forma de pago</td>
                                    <td>:</td>
                                    <td>
                                        <div class="row">
                                            {{-- <div class="col-sm-5">
                                                <select class="form-control" name="forma_pago"  id ="forma_pago" onchange="seleccionado_fp()">
                                                    @foreach($forma_pagos as $forma_pago)
                                                        <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
                                                    @endforeach
                                                <select>
                                            </div>
                                            <div class="col-sm-5" id="credito_pago" style="visibility: hidden;">
                                                <button  type="button" class='cuota_modal btn btn-info' id="cuota_modal"  data-toggle="modal" data-target="#cuotas_modal">Cuotas</button>
                                            </div> --}}
                                            
                                        </div>
                                    </td>             
                                </tr>
                                <tr>
                                    <td>Observacion</td>
                                    <td>:</td>
                                    <td colspan="">
                                        {{-- <textarea class="form-control" name="observacion" id="observacion"  rows="2"  >Emitimos la siguiente Boleta a vuestra solicitud</textarea> --}}
                                    </td>
                                    <td id="ven_1p" style="visibility: initial;">Fecha de Vencimiento</td>
                                    <td id="ven_2p" style="visibility: initial;">:</td>
                                    <td id="ven_3p" style="visibility: initial;">
                                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{date("Y-m-d")}}">
                                    </td>
                                </tr>
                            {{-- </div> --}}
                            </tbody>
                        </table>
                        <div id="resultado_moneda"></div>
                        <div class="div table-responsive">
                            <table cellspacing="0" class="table tables">
                                <thead>
                                    <tr>
                                        <th style="width: 10px"></th>
                                        <th style="width: 500px;font-size: 13px">Articulo</th>
                                        <th>Stock</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Dcto</th>
                                        <th>PU. Dcto.</th>
                                        <th>PU. Com.</th>
                                        <th>Total</th>
                                        <th>Total IGV</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td >
                                            <button type="button" class='delete borrar e btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                        </td>
                                        <td class="td_selected">
                                            <select class="monto0 select2_demo_3 select_change" required="" id="articulo"  onchange="ajax(0)"  autocomplete="off">
                                            </select>
                                            <textarea  type='text' name='descripcion_item[]' placeholder="Descripcion de Item" class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                                            <textarea id='numero_serie0'  name='numero_serie[]' class="form-control"  placeholder="N° de Serie" autocomplete="off" style="margin-top: 5px"></textarea>
                                            <input style="min-width: 76px" type='text' id='tipo_afec0' name='tipo_afec[]' readonly="readonly" class="monto0 form-control" onkeyup="multi(0)" hidden="" required  autocomplete="off"  />
                                            <input type="hidden" class="celda"  name="articulo[]" id="input_prod1" >

                                        </td>
                                        <td>
                                            <input style="min-width: 76px" type='text' id='stock0' disabled="disabled" name='stock[]' class="form-control" required  autocomplete="off"/>
                                        </td>
                                        <td>
                                            <input style="min-width: 76px" type='number' id='cantidad0' name='cantidad[]' max="" min="1" class="monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" />
                                        </td>
                                        <td>
                                            <input style="min-width: 76px" type='number' id='precio0' name='precio[]' disabled="disabled" class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" />
                                        </td>
                                        <td>
                                            <div style="position: relative; " > <input style="min-width: 76px" class="text_des"type='text' id='descuento0' name='descuento[]' readonly="readonly" class="" required  autocomplete="off"/></div>
                                            <div  class="div_check" >
                                                <input style="min-width: 76px" class="check"  type='checkbox' id='check0' name='check[]'    onclick="multi(0)" style="" autocomplete="off"/>
                                            </div>
                                            <input style="min-width: 76px" type='hidden' id='check_descuento0' name='check_descuento[]'  class="form-control"  required >
                                            <input style="min-width: 76px" type='hidden' id='promedio_original0' name='promedio_original[]'  class="form-control"  required >
                                        </td>
                                        <td>
                                            <input style="min-width: 76px" type='text' id='precio_unitario_descuento0' name='precio_unitario_descuento[]' disabled="disabled" class="precio_unitario_descuento0 form-control"  required  autocomplete="off" />
                                        </td>
                                        {{--                                        <td>--}}
                                            <input style="min-width: 76px" type='hidden' name="1" id='comision0'  disabled="disabled" class="form-control"  required  autocomplete="off" />
                                        {{--                                        </td>--}}
                                        <td>
                                            <input style="min-width: 76px" type='text' id='precio_unitario_comision0'  disabled="disabled" class="form-control"  required  autocomplete="off" />
                                        </td>
                                        <td>
                                            <input style="min-width: 76px" type='text' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" />
                                            <input style="min-width: 76px" type='text' id='afectacion0'  style=""  name='afectacion' disabled="disabled" class="afectacion form-control " hidden=""  required  autocomplete="off"/>

                                        </td>
                                        <td>
                                            <input style="min-width: 76px"   type='text' id='precio_unitario_igv0' name='precio_unitario_igv[]' readonly="readonly" class="form-control" required  autocomplete="off" />
                                        </td>
                                        <span id="spTotal"></span>
                                    </tr>

                                </tbody>
                                <br>
                                <tbody>
                                    <tr style="background-color: #f5f5f500;" align="center">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Subtotal:</td>
                                        <td colspan="2">
                                            <input id='sub_total' type="text" name="sub_total_sin_igv" readonly class="form-control" required />
                                            <input id='subtotal_gravado' type="text" name="subtotal_gravado" readonly class="form-control" required hidden="" />
                                        </td>
                                    </tr>
                                    <tr style="background-color: #f5f5f500;" align="center">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>IGV :</td>
                                        <td colspan="2">
                                            <input id='igv' type="text"     disabled="disabled" class="form-control" required />
                                        </td>
                                    </tr>
                                    <tr  align="center">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total :</td>
                                        <td colspan="2">
                                            <input id='total_final' type="text" name="total_comi"    readonly="" class="form-control" required />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class='addmore btn btn-success'><i class="fa fa-plus-square" aria-hidden="true"></i></button>&nbsp;
                        <button class="ladda-button btn btn-primary float-right" type="boton"  id="boton" name="boton"><i class="fa fa-cloud-upload" aria-hidden="true" >Guardar</i></button>&nbsp;
                        <button class="ladda-button btn btn-primary float-right" type="submit" hidden  id="button_submit" name="boton"><i class="fa fa-cloud-upload" aria-hidden="true" >Guardar DB</i></button>&nbsp;
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loaderGif"></div>
<style>
     .form-control{border-radius: 10px}
    .text_des{border-radius: 10px;border: 1px solid #e5e6e7;width: 80px;padding: 6px 12px;}
    .check{-webkit-appearance: none;height: 34px;background-color: #ffffff00;-moz-appearance: none;border: none;appearance: none;width: 80px;border-radius: 10px;}
    .div_check{position: relative;top: -33px;left: 0px;background-color: #ffffff00;  top: -35;}
    .check:checked {background: #0375bd6b;}
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] { -moz-appearance:textfield; }
    label.col-form-label::marker{
        list-style:none;
    }
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
    .a{
        color: red
    }
    #loaderGif{
        background:url({{ asset('img/loading.gif') }}) 50% 50% no-repeat #000000a3;
        background-size: 250px;
        display: none;
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100vh;
        z-index: 20;
    }
    .not-active { 
        pointer-events: none; 
        cursor: default; 
    }
    @media only screen and (max-width: 1497px){
        .td_selected > span.select2.select2-container.select2-container--default{
            /* width: 376px !important; */
            min-width: 376px !important;
        }
    }
</style>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>


<script type="text/javascript">
    

    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        ajax: {
            minimumInputLength: 1,
            url: "{{ route('pa.clients') }}",
            dataType: 'json',
            type: "POST",
            delay: 10,
            data: function (params) {
                var tipo_coti = 3;
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
    $('.select2_demo_client').on('select2:selecting', function(e){
        var text = e.params.args.data.text.split(' | ');
        $('#nombre_cliente').html(text[0]);
        $('#rucdni_cliente').html(text[1]);
    });
    // Validar Formulario / No doble insercion de datos(Gente desdesperada)

    function valida(f) {
        var boton=document.getElementById("boton");
        var completo = true;
        var incompleto = false;
        if( f.elements[0].value == "" ){
            alert(incompleto); 
        }else{
            boton.type = 'button';
        }
    }

    //Creador para la agregacion de articulos (Productos-Servicios) en vista
    
    var i = 2;
    $(".addmore").on('click', function () {
        var data = `[
        <tr>
            <td >
                <button type="button" class='delete borrar e btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
            </td>";
            <td class="td_selected">
                <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})"  autocomplete="off">
                </select>
                <textarea type='text'   name='descripcion_item[]' class="form-control" placeholder="Descripcion de Item"  autocomplete="off" style="margin-top: 5px;"></textarea>
                <textarea  id='numero_serie${i}' placeholder="N° de Serie"  name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px"></textarea>
                <input style="min-width: 76px" type='text'  id='tipo_afec${i}' name='tipo_afec[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required hidden   autocomplete="off" />
                <input style="min-width: 76px" type="hidden"    class="celda"  name="articulo[]" id="input_prod${i}">
            </td>
            <td>
                <input style="min-width: 76px" type='text' id='stock${i}' name='stock[]' disabled="disabled" class="form-control" required  autocomplete="off"/>
            </td>
            <td>
                <input style="min-width: 76px" type='number' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off" max=""  min="1"/>
            </td>
            <td>
                <input style="min-width: 76px" type='text' id='precio${i}' name='precio[]' disabled="disabled" class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
            </td>
            <td>
                <div style="position: relative;" >
                    <input style="min-width: 76px" class="text_des"type='text' id='descuento${i}' name='descuento[]' readonly="readonly" class="" required onkeyup="multi(${i})"  autocomplete="off"/>
                </div>
                <div  class="div_check">
                    <input style="min-width: 76px" class="check"  type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
                </div>
                <input style="min-width: 76px" type='hidden'id='check_descuento${i}' name='check_descuento[]' class="form-control"  required >
                <input style="min-width: 76px" type='hidden' id='promedio_original${i}' name='promedio_original[]'  class="form-control"  required >
            </td>
            <td>
                <input style="min-width: 76px" type='text' id='precio_unitario_descuento${i}' name='precio_unitario_descuento[]' disabled="disabled" class="precio_unitario_descuento${i} form-control"  required  autocomplete="off" />
            </td>
            <td>
                <input style="min-width: 76px" type='hidden' name'${i}' id='comision${i}' disabled="disabled" class="form-control"  required  autocomplete="off" />
                <input style="min-width: 76px" type='text' id='precio_unitario_comision${i}' disabled="disabled" class="form-control"  required  autocomplete="off" />
            </td>
            <td>
                <input style="min-width: 76px" type='text' id='total${i}' name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
                <input style="min-width: 76px" type='text' id='afectacion${i}'  style="width: 76px" hidden  name='afectacion' disabled="disabled" class="afectacion form-control "  required  autocomplete="off"/>
            </td>
            <td>
                <input style="min-width: 76px"   type='text' id='precio_unitario_igv${i}' name='precio_unitario_igv[]' readonly="readonly" class="form-control" required  autocomplete="off" />
            </td>
        </tr>`;
        $('.tables').append(data);
        i++;
        //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
        articlesSelect2();

        var input_ds = [];
        var number_tot = document.getElementsByName('articulo[]').length;
        for( j = 0; j < number_tot; j++){
            input_ds[j]  = document.getElementsByName('articulo[]')[j].value;
            if(input_ds[j].indexOf("SERV-") == 4){
                $('option[value="'+input_ds[j]+'"]').prop("disabled", false);
            }else{
                $('option[value="'+input_ds[j]+'"]').prop("disabled", true);
            }
        };
        $(".addmore").prop("disabled", true);
        $(".borrar").prop("disabled", false);
    });

    //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
    $(document).ready(function() {
        articlesSelect2();

        $('.select2_operacion').select2({
            placeholder: "Seleccionar Tipo Operacion"
        });
        $("form").keypress(function(e) {
            if (e.which == 13) {
                setTimeout(function() {
                    e.target.value += ' | ';
                }, 4);
                e.preventDefault();
            }
        });
        var mem = $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                dateFormat: 'dd-mm-yyyy'
            });
    });
    //Funcion para el select articles "AJAX" (productos- servicios), ejecutandose cada vez realizada una llamada
    function articlesSelect2() {
        var almacen = $('[id="almacen_id"]').val();
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
                        search: params.term, // search term 
                        almacen: almacen
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
                                data[y].disabled=true;
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
    // TODO funcion ajax para obtener los parametros requeridos de articulo (PRODUCTOS - SERVICIOS)
    function ajax (a){
        if(a==0){
            var articulo = document.getElementById(`articulo`).value;
            document.getElementById(`input_prod1`).value = articulo;
        }else{
            var articulo = document.getElementById(`articulo${a}`).value;
            document.getElementById(`input_prod${a}`).value = articulo;
        }

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
                $(`#tipo_afec${a}`).val(msg.afectacion);
                $(`#precio${a}`).val(msg.price);
                $(`#cantidad${a}`).val(1);
                $(`#precio_unitario_descuento${a}`).val(msg.price);
                $(`#promedio_original${a}`).val(msg.average);
                $(`#stock${a}`).val(msg.amount);
                $(`#descuento${a}`).val(msg.discount);
                $(`#check_descuento${a}`).val(0);
                $(`#cantidad${a}`).attr('max', msg.amount );
                $(`#cantidad`).attr('max', msg.amount );
                var separador=" ";
                var comision=document.querySelector(`#comisionista`).value;
                //revirtiendo la cadena
                var reverse9=reverseString(comision);//devuelve toda la cadena articulo al reves
                //para comision
                var comision_v_r=reverse9.split(separador,1); //devuelve el precio en objeto al revez
                var comision_r=comision_v_r[0];//obtiene el precio del objeto [0] al revez
                var comision_v =reverseString(comision_v_r[0]);//convierte el precio al revez a la normalidad
                if(comision){
                    document.getElementById(`comision${a}`).value = comision_v;
                }else{
                    document.getElementById(`comision${a}`).value = 0;
                }
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
        //comision
        var comision=document.querySelector(`#comisionista`).value;
        var separador=" ";
        //revirtiendo la cadena
        var reverse9=reverseString(comision);//devuelve toda la cadena articulo al reves
        //para comision
        var comision_v_r=reverse9.split(separador,1); //devuelve el precio en objeto al revez
        var comision_r=comision_v_r[0];//obtiene el precio del objeto [0] al revez
        var comision_v =reverseString(comision_v_r[0]);//convierte el precio al revez a la normalidad

        var campos_num = document.getElementsByClassName("total").length;

        console.log(comision_v);

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
    //Función para el calculo de los totales de cada articulo y para los totales de la factura
    function multi(a) {
        var total = 1;
        var totales=0;
        var change= false; //
        $(`.monto${a}`).each(function(){
            if (!isNaN(parseFloat($(this).val()))) {
                change= true;

                total *= parseFloat($(this).val());
            }
        });
        total = (change)? total:0;
        // Get the checkbox
        var checkBox = document.getElementById(`check${a}`);
        var cantidad = document.querySelector(`#cantidad${a}`).value;
        var promedio_origina_descuento1=document.querySelector(`#precio_unitario_descuento${a}`).value;
        var promedio_original2=document.querySelector(`#promedio_original${a}`).value;
        var descuento = document.querySelector(`#descuento${a}`).value;
        var afec = document.querySelector(`#tipo_afec${a}`).value;
        var precio = document.querySelector(`#precio${a}`).value;
        var igv = 0;
        var igv_new = {{$igv->renta}};

        if (checkBox.checked == true && descuento > 0){        
            var promedio_original=document.querySelector(`#promedio_original${a}`).value;
            var comision_porcentaje=document.querySelector(`#comision${a}`).value;
            var multiplier = 100;
            var precio_uni=precio-(promedio_original*descuento/100);
            if(afec.toString() == "Gravado"){

                var precio_u =  ( precio_uni * ( igv / 100 ) );
                var prec_uni = parseFloat(precio_uni) + parseFloat(precio_u) ; 
                var precio_uni_dec = Math.round(  prec_uni * multiplier ) / multiplier;
                var comisiones9=precio_uni+(precio_uni*comision_porcentaje/100);
                var comisiones = Math.round((comisiones9+(comisiones9*(igv/100))) * multiplier) / multiplier;
                var final=comisiones*cantidad;
                var final_decimal = Math.round(final * multiplier) / multiplier;
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = final_decimal;
                
                var precio_uni_igv =  Math.round((final_decimal+(final_decimal*(igv_new/100)))*multiplier)/multiplier;
                
            }else{
                var precio_uni_dec = Math.round((precio_uni+(precio_uni) * multiplier)) / multiplier;
                var comisiones9=precio_uni+(precio_uni*comision_porcentaje/100);
                var comisiones = Math.round((comisiones9) * multiplier) / multiplier;

                var final=comisiones*cantidad;
                var final_decimal = Math.round(final * multiplier) / multiplier;
                // console.log(final_decimal);
                
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = 0;
                var precio_uni_igv = final_decimal ;
            }
            document.getElementById(`check_descuento${a}`).value = descuento;
            document.getElementById(`precio_unitario_comision${a}`).value = comisiones;
            document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;
            document.getElementById(`precio_unitario_igv${a}`).value = precio_uni_igv ;
            

        } else {
            var multiplier = 100;
            var descuento = 0;
            var precio = document.querySelector(`#precio${a}`).value;
            var comision_porcentaje=document.querySelector(`#comision${a}`).value;
            if(afec.toString() == "Gravado"){
                var precio_igv = Math.round((parseFloat(precio)+(precio*(igv/100)))*multiplier)/multiplier;
                var final= cantidad*precio;
                var end9=parseFloat(precio)+((parseFloat(precio)*parseInt(comision_porcentaje)/100));
                var end = Math.round((end9+(end9*(igv/100)))*multiplier)/multiplier;
                var final2=cantidad*end;
                var final_decimal = Math.round(final2 * multiplier) / multiplier;
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = final_decimal;
                var precio_uni_igv =  Math.round((final_decimal+(final_decimal*(igv_new/100)))*multiplier)/multiplier;

            }else{
                var precio_igv = (Math.round(precio * multiplier) / multiplier);
                var final= cantidad*precio;
                var end9=parseFloat(precio)+((parseFloat(precio)*parseInt(comision_porcentaje)/100));
                var end = Math.round((end9)*multiplier)/multiplier;
                var final2=cantidad*end;
                var final_decimal = Math.round(final2 * multiplier) / multiplier;
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = final_decimal;
                var precio_uni_igv = final_decimal ;

            }
            document.getElementById(`check_descuento${a}`).value = 0;
            document.getElementById(`precio_unitario_descuento${a}`).value = precio_igv;
            document.getElementById(`precio_unitario_comision${a}`).value = end;
            document.getElementById(`precio_unitario_igv${a}`).value = precio_uni_igv;
        }

        var totalInp = $('[name="total"]');
        var total_t = 0;

        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });

        var multiplier2 = 100;
        var total_tt = Math.round(total_t * multiplier2) / multiplier2;

        $('#sub_total').val(total_tt);

        //SOLO GRAVADO
        var totalInpG = $('[name="afectacion"]');
        var total_tg = 0;

        totalInpG.each(function(){
            total_tg += parseFloat($(this).val());
        });

        var multiplier3 = 100;
        var total_ttg = Math.round(total_tg * multiplier3) / multiplier3;

        $('#subtotal_gravado').val(total_ttg);

        var igv_valor={{$igv->renta}};
        var subtotal = document.querySelector(`#sub_total`).value;
        var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;
        var igv=subtotal_gravado*igv_valor/100; 
        var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
        var end=igv_decimal+parseFloat(subtotal);
        var end2 = Math.round(end * multiplier2) / multiplier2;

        document.getElementById("igv").value = igv_decimal;
        document.getElementById("total_final").value = end2;

        var monto_c = document.getElementsByClassName('monto_pago');
        
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (total_tt/inp_mont)
            document.getElementById("monto_pago0").value = Math.round(end2 * multiplier2)/ multiplier2;
            $("#cuotas_footer").html(Math.round(end2 * multiplier2)/ multiplier2);
        }
    }
    
     //Funcion para revertir un string dado
    function reverseString(str) {
        return str.split("").reverse().join("");
        ;
    }

     //Función de borrado de fila de articulos (Producto-Servicio)
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        var input_text_opt = fila.find('input[class="celda"]').val();
        $('option[value="'+input_text_opt+'"]').prop("disabled", false);
        $(".addmore").prop("disabled", false);
        // ELIMINAR TR
        if (e>1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        }else{
            $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
        }
        var multiplier = 100;
        var totalInp = $('[name="afectacion"]');
        var total_t = 0;

        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });

        $('#subtotal_gravado').val(total_t);
        //GRAVADO
        var totalInpG = $('[name="total"]');
        var total_tt = 0;

        totalInpG.each(function(){
            total_tt += parseFloat($(this).val());
        });
        $('#sub_total').val(total_tt);

        var igv_valor=({{$igv->renta}});
        var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;
        var subtotal = document.querySelector(`#sub_total`).value;
        var igv_val=parseFloat(subtotal_gravado)*igv_valor/100;
        var igv = Math.round(igv_val * multiplier) / multiplier;
        var end_2=parseFloat(igv)+parseFloat(subtotal);
        var end = Math.round(end_2 * multiplier) / multiplier;
        console.log(end);
        document.getElementById("igv").value = igv;
        document.getElementById("total_final").value = end;

        var inp_mont = document.getElementsByClassName('monto_pago').length;
        var monto_c = document.getElementsByClassName('monto_pago');
        var multiplier2 = 100;

        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (end/inp_mont)
            document.getElementById("monto_pago0").value = Math.round(end * multiplier2)/ multiplier2; ;
            // document.getElementById(`${monto}`).value = end;
        }
    });
 
    // CODIGO PARA SELECCION DE FORMA DE PAGO
    function seleccionado_fp(){
        var opt = $('#forma_pago').val();
        if(opt=="1"){
            document.getElementById('credito_pago').style.display = "none";
            document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-8");
            document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-12");
            
            document.getElementById('fecha_vencimiento').removeAttribute('disabled');

        }else{
            document.getElementById('credito_pago').style.display = "contents";

            document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-12");
            document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-8");

            document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
        }
    }
 
    var total = document.getElementById('total_final').value;
    var x = 1;
    $(".add_pago").on('click', function () {
        var total = document.getElementById('total_final').value;
        var data = `
        <div class="delete_modal${x} row">
            <div class="col-sm-1"><label>Fecha:</label>
            </div>
            <div class="col-sm-4">
                <input type="date" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" min="{{$fecha_1}}">
            </div>
            <div class="col-sm-1"><label>Monto:</label></div>
            <div class="col-sm-4">
                <div class="input-group mb-3" style="padding-right:15px">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">{{$moneda->simbolo}}</span>
                    </div>
                    <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}" onkeypress="return filterFloat(event,this);">
                </div>
            </div>
            <div class="col-sm-2">
                <label >
                    <button type="button"  class="xd btn btn-danger" onclick="eliminar(${x})"><i class="fa fa-trash-o fa-lg" > </i></button>
                </label>
            </div>
        </div>`;
        $('.row_number').append(data);

        var inp_mont = document.getElementsByClassName('monto_pago').length;
        x++;
        if(inp_mont>6){
            $('.add_pago').attr('disabled');
        }
        var multiplier2 = 100;
        var monto_c = document.getElementsByClassName('monto_pago');
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (total/inp_mont)
            document.getElementById("monto_pago0").value = '';
        }
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        if(inp_mont>5){
            document.getElementById('add_pago').setAttribute('disabled', "true");
        }else{
            document.getElementById('add_pago').removeAttribute('disabled');
        }
    });

    // FUNCION PARA ELIMINAR LOS TR DE FORMA DE PAGO MODAL
    function eliminar(x){
        $(`.delete_modal${x}`).remove();
        var monto_c = document.getElementsByClassName('monto_pago');
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        var total = document.getElementById('total_final').value;
        var multiplier2 = 100;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (total/inp_mont)
            document.getElementById("monto_pago0").value = '';
        }
        if(inp_mont>5){
            document.getElementById('add_pago').setAttribute('disabled', "true");
        }else if(inp_mont == 1){
            document.getElementById("monto_pago0").value = total;
        }else{
            document.getElementById('add_pago').removeAttribute('disabled');
        }
    };
    $(document).on('click','#button_cuotas_save', function(event){
            
        var monto_c = document.getElementsByClassName('monto_pago');
        var monto_fc = document.getElementsByClassName('fecha_pago');
        console.log(monto_c);
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        var total =  $("#cuotas_footer").html();
        console.log(total);

        var fin = 0;
        var comp = 0;
        for (var i = 0; i < inp_mont; i++) {
            fin = parseFloat(fin) + parseFloat(monto_c[i].value);
        }
        var fin_r = Math.round(fin * 100) / 100;
        console.log(inp_mont);

        for (var i = 0; i < inp_mont; i++) {
            var fecha = monto_fc[i].id;
            var monto = monto_c[i].id;

            var input_text = document.getElementById(`${monto}`).value;
            var date_text = document.getElementById(`${fecha}`).value;
            if( input_text.length  == 0 || date_text.length  == 0){
                document.getElementById('alert_campos').style.display = "flex";                    
                setTimeout(mostrarMensaje, 3000 );
                return;
            
            var end_date = document.getElementById(`fecha_pago` + inp_mont);}
        }
        
        if(fin_r != total){
            document.getElementById('suma_campos').style.display = "flex";
        }else{
            
            end_date.toLocaleDateString("d-mm-yyyy");
            $('#fecha_vencimiento').val(end_date)
            $('#cuotas_modal').modal('hide')
        }
        mostrarMensaje();
        
    });
    function mostrarMensaje(){
        // $("#alert_campos").show(200);
        $("#alert_campos").hide(3000);
        $("#suma_campos").hide(3000);
    }
    // SABER SI LAS CUOTAS DEL MODAL DE FORMA DE PAGO CONCUERDA CON EL MONTO FINAL
    $("#boton").on("click",function(buton){
        var forma_pago = $("#forma_pago option:selected").val();
        if(forma_pago == 2){
            var monto_c = document.getElementsByClassName('monto_pago');
            var monto_fc = document.getElementsByClassName('fecha_pago');
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var total =  $("#cuotas_footer").html();
            var fin = 0.00;
            var comp = 0;
            for (var i = 0; i < inp_mont; i++) {
                fin = parseFloat(fin) + parseFloat(monto_c[i].value);
            }
            var fin_r = Math.round(fin * 100) / 100;
            // console.log(total);
            for (var i = 0; i < inp_mont; i++) {
                var fecha = monto_fc[i].id;
                var monto = monto_c[i].id;
    
                var input_text = document.getElementById(`${monto}`).value;
                var date_text = document.getElementById(`${fecha}`).value;
                if( input_text.length  == 0 || date_text.length  == 0){
                    $('#cuotas_modal').modal('show');
                    document.getElementById('alert_campos').style.display = "flex";                    
                    setTimeout(mostrarMensaje, 3000);
                    return;
                }
            }
            if(fin_r != total){
                $('#cuotas_modal').modal('show');
                document.getElementById('suma_campos').style.display = "flex";
                setTimeout(mostrarMensaje, 3000);
            }else{
                // console.log('e')
                
                document.getElementById('button_submit').click();
            }
        // buton.preventDefault();
        }else{
            document.getElementById('button_submit').click();
        }
        
    });
    function filterFloat(evt,input){
        var key = window.Event ? evt.which : evt.keyCode;    
        var chark = String.fromCharCode(key);
        var tempValue = input.value+chark;

        if(key >= 48 && key <= 57){
            if(filter(tempValue)=== false){
                return false;
            }else{       
                return true;
            }
        }else{
            if(key == 8 || key == 13 || key == 0) {     
                return true;              
            }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
            }else{
                return false;
            }
        }
    }
    function filter(__val__){
        var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
        if(preg.test(__val__) === true){
            return true;
        }else{
        return false;
        }   
    }
    // FUNCIONES PARA LAS ALERTAS DE FORMA DE PAGO
    function cerrar_but_rc(){
        document.getElementById('alert_campos').style.display = "none";
    }
    function cerrar_but_mt(){
        document.getElementById('suma_campos').style.display = "none";
    }

    // TODO Script para cambiar por moneda
    let status=0;
    function changeMoney() {
        $.ajax({
            type: "post",
            url: "{{ route('pa.money') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'status': status,
            },
            beforeSend: function(){
                $('#loaderGif').show(); 							
			},
			complete:function(data){
                /*
                * Se ejecuta al termino de la petición
                * */
            },
            success: function (msg) {
                //Cambio de moneda
                $(`#moneda_id`).val(msg.id);
                $(`#moneda`).val(msg.nombre);
                // $(`#button_changeMoney`).html(msg.other);
                $(`#basic-addon3`).html(msg.simbolo);
                $(`#simb_fot`).html(msg.simbolo);
                
                
                if(status==1){
                    status=0;
                }else{
                    status=1;
                    }
                $('#loaderGif').hide(); 
                let articles_selected = document.getElementsByClassName("select2_demo_3");
                let articles_selected_count = articles_selected.length;
                for(let z=0;z<articles_selected_count;z++){
                    let selected=document.getElementsByClassName("select2_demo_3 select_change")[z].getAttribute('id');
                    if(selected=='articulo'){
                        ajax(0); 
                    }else{
                        ajax(selected.substring(8)); 
                    }
                }    
                disabled_money();
            },
        });
    }

    $(document).on({
        ajaxStart: function(){
            $("body").addClass("loading"); 
        },
        ajaxStop: function(){ 
            $("body").removeClass("loading"); 
        }    
    });

    jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
    };
    jQuery.event.special.touchmove = {
        setup: function( _, ns, handle ) {
            this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
        }
    };
    jQuery.event.special.wheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("wheel", handle, { passive: true });
        }
    };
    jQuery.event.special.mousewheel = {
        setup: function( _, ns, handle ){
            this.addEventListener("mousewheel", handle, { passive: true });
        }
    };

    function disabled_money(){
        $(`.money_change`).prop('disabled', true);
        $(`.button_money`).addClass('not-active');

        setTimeout(function(){
            $(`.money_change`).prop('disabled', false);
            $(`.button_money`).removeClass('not-active');
        }, 10000);
    }
    </script>
    <style type="text/css">
    .a{color: red}
</style>
@endsection