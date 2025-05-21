@extends('layout')
@section('title', 'Factura Manual')
@section('atributo_actu', 'hidden')
@section('href_accion', route('facturacion_manual.index'))
@section('value_accion', 'Inicio')
@extends('layout_agregado_rapido')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')
{{-- errors --}}
@if($errors->any())
<div style="padding-top: 20px;">
    <div class="alert alert-danger">
        <a class="alert-link" href="#">
            @foreach ($errors->all() as $error)
            <li style="color: red">{{ $error }}</li>
            @endforeach
        </a>
    </div>
</div>
@endif

{{-- @section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado')) --}}
{{-- @section('ruta_retorno', 'facturacion') --}}
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>Cliente</a>
</div>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
    .word-style select,
    .word-style input,
    .word-style span{
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
    }
    .required {
    color: red;
    margin-left: 2px;
  }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
  <div class="ibox">
    <div class="ibox-content">
       <div class="row form-label word-style">
            <div class="col-md-6">
                <!-- Cliente -->
                <div class="form-group row d-flex align-items-center">
                <label class="col-lg-3 col-form-label">Cliente<span class="required">*</span></label>
                <div class="col-lg-9">
                    <select class="select2_demo_client form-control" name="cliente" id="cliente" required></select>
                </div>
                </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group row d-flex align-items-center">
                    <label class="col-lg-5 col-form-label">Orden de Compra<span class="required">*</span></label>
                    <div class="col-lg-7">
                        <input type="text" class="form-control" name="orden_compra" required  autocomplete="off" value="0">
                    </div>
                    </div>
                </div>
            <div class="col-md-6">
                <div class="form-group row d-flex align-items-center">
                <label class="col-lg-5 col-form-label">Guía de Remisión<span class="required">*</span></label>
                <div class="col-lg-7">
                    <input type="text" class="form-control"  name="guia_r" id="guia_save_inp" value="0">
                </div>
                </div>
            </div>
            </div>

            <!-- Detracción -->
            <div class="form-group row d-flex align-items-center">
            <label class="col-lg-3 col-form-label">Detracción<span class="required">*</span></label>
            <div class="col-lg-9 d-flex align-items-center">
                <input type="checkbox" class="js-switch" name="estado">
                <a href="#" id="button_detracc" class="ml-2"></a>
            </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Tipo de Operación -->
            <div class="form-group row d-flex align-items-center">
            <label class="col-lg-3 col-form-label">T. Operación<span class="required">*</span></label>
            <div class="col-lg-9">
               <select class="select2_tipo_op" name="tipo_operacion" >
                    @foreach($tipo_operacion as $t_op)
                    <option id="{{$t_op->id}}">{{$t_op->codigo}} - {{$t_op->informacion}}</option>
                    @endforeach
                </select>
            </div>
            </div>

            <!-- Forma de Pago y Moneda -->
            <div class="form-group row">
            <div class="col-sm-6">
                <div class="form-group row d-flex align-items-center">
                    <label class="col-lg-6 col-form-label">F. de Pago <span class="required">*</span></label>
                    <div class="col-lg-6">
                        <select class="form-control" name="forma_pago" id="forma_pago" onchange="seleccionado_fp()" required>
                            <option value="">Seleccione una opción</option>
                            @foreach($forma_pagos as $forma_pago_item)
                                <option value="{{ $forma_pago_item->id }}" 
                                    {{ (isset($forma_pago) && $forma_pago == $forma_pago_item->id) ? 'selected' : '' }}>
                                    {{ $forma_pago_item->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group row d-flex align-items-center">
                    <label class="col-lg-6 col-form-label">
                        Moneda <span class="required">*</span>
                    </label>
                    <div class="col-lg-6">
                        <select class="form-control" name="moneda" required>
                            <option value="nacional" {{ $moneda->tipo == 'nacional' ? 'selected' : '' }}>Soles</option>
                            <option value="extranjera" {{ $moneda->tipo == 'extranjera' ? 'selected' : '' }}>Dólares</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
            <!-- Fechas -->
            <div class="form-group row">
                <div class="col-sm-6">
                    <div class="form-group row d-flex align-items-center">
                    <label class="col-lg-6 col-form-label">F. Emisión<span class="required">*</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{date('d-m-Y')}}" disabled>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group row d-flex align-items-center">
                    <label class="col-lg-6 col-form-label">F. Vencimiento<span class="required">*</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" value="{{date('d-m-Y')}}" disabled>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
                <div class="form-group row d-flex align-items-center">
                    <label for="" class="col-lg-1 col-md-2">Observación<span class="required">*</label>
                    <div class="col-lg-11 col-md-10">
                        <textarea class="form-control" name="observacion" id="observacion" rows="1"></textarea>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>



<!-- Inicio-->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="{{route('facturacion_manual.store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)" id="form_store">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4 text-left" align="left">
                                <address class="col-sm-4" align="left">
                                    <img src="{{asset('img/logos/')}}//{{$empresa->foto}}" alt="" width="300px">
                                </address>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="form-control ruc tooltip-demo" style="height:125px">
                                    <center>
                                        <h3 style="padding-top:10px">{{$empresa->ruc}}</h3>
                                        <h2>FACTURA ELECTRONICA</h2>
                                        <h4 id="codigo_fac_manual">{{$factura_numero}} <span class="small" data-toggle="tooltip" data-placement="bottom" title="N° Referencial"><i class="fa fa-question-circle"></i></span></h4>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Cliente</td><td>:</td>
                                    <td>
                                        <select class="select2_demo_client" name="cliente" id="cliente" required=""></select>
                                    </td>
                                    <td>Almacen</td><td>:</td>
                                    <td>
                                        <select class="select2_demo_almacen" name="almacen_id_selec" required=""  onchange="codigo_numero()">
                                            @foreach($almacenes as $almacen)
                                                <option value="{{$almacen->id}}">{{$almacen->nombre}} - {{$almacen->abreviatura}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Orden de compra</td><td>:</td>
                                    <td><input type="text" class="form-control m-b" name="orden_compra" required  autocomplete="off" value="0"></td>
                                    <td>Guía remisión <small class="tooltip-demo"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" title="Ej: TE01-999  *  Mayusculas y separar solo con espacios en blanco"></i></small></td><td>:</td>
                                    <td>
                                        <input list="guia_list" type="text" class="form-control" value="0" name="" id="guia_remi_input" autocomplete="off">
                                        <datalist id="guia_list">
                                        </datalist>
                                        <span id="lista_gr"></span>
                                        <input type="hidden" name="guia_r" id="guia_save_inp" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Vendedor</td><td>:</td>
                                    <td><input type="text" class="form-control" name="personal" disabled required="required" value="{{auth()->user()->name}}"></td>
                                    <td>Forma de pago</td><td>:</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <select class="form-control" name="forma_pago"  id ="forma_pago" onchange="seleccionado_fp()">
                                                    @foreach($forma_pagos as $forma_pago) <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option> @endforeach
                                                <select>
                                            </div>
                                            <div class="col-sm-6" id="credito_pago" style="visibility: hidden;">
                                                <button  type="button" class='cuota_modal btn btn-info' id="cuota_modal"  data-toggle="modal" data-target="#cuotas_modal">Cuotas</button>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Modal de Cuotas -->
                                    <div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
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
                                                            <div class="col-sm-1">
                                                                <label>Fecha:</label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <input type="date" name="fecha_pago[]" id="fecha_pago0"  class="fecha_pago form-control" min="{{$fecha_1}}" >
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <label>Monto:</label>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="input-group mb-3" style="padding-right:15px">
                                                                    <div class="input-group-prepend">

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
                                                            <label for=""><strong>Precio Total: &nbsp;</strong>{{$moneda->simbolo}}&nbsp;</label><label id="cuotas_footer"></label>
                                                        </div>
                                                        <div class="col-sm-6" align="right">
                                                            <button type="button" id="button_cuotas_save" class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal de Cuotas -->
                                </tr>
                                <tr>
                                    <td>Moneda</td>
                                    <td>:</td>
                                    <td>
                                        <div class="row">
                                            <input type="hidden" name="almacen" id="_selec" class="form-control " value="{{$sucursal->id}}" readonly="readonly">
                                            <input type="hidden" id="moneda_id" class="form-control " value="{{$moneda->id}}" readonly="readonly">
                                            <div class="col-sm-5">
                                                <input type="text" name="moneda" id="moneda" class="form-control " value="{{$moneda->nombre}}" readonly="readonly">
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
                                    <td>Fecha</td><td>:</td>
                                    <td><input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly"></td>
                                </tr>
                                <tr>
                                    <td>Tipo de Operación</td><td>:</td>
                                    <td>
                                        <select class="select2_tipo_op" name="tipo_operacion" >
                                            @foreach($tipo_operacion as $t_op)
                                            <option id="{{$t_op->id}}">{{$t_op->codigo}} - {{$t_op->informacion}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td id="ven_1p" style="visibility: initial;">Fecha de Vencimiento</td><td id="ven_2p" style="visibility: initial;">:</td>
                                    <td id="ven_3p" style="visibility: initial;"><input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{date("Y-m-d")}}"></td>
                                </tr>
                                <tr>
                                    <td>Observación</td><td>:</td>
                                    <td><textarea class="form-control" name="observacion" id="observacion" >Emitimos la siguiente Factura a vuestra solicitud</textarea></td>
                                    <td>Detraccion</td><td>:</td>
                                    <td>
                                        <input type="checkbox" class="js-switch" name="estado">
                                        <a href="" id="button_detracc" data-toggle="modal" data-target="#modal_detraccion" style="margin: auto" ><i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999" ></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="table-responsive">
                            {{-- <div  > --}}
                                <table cellspacing="0" class="table tables  " >
                                    <thead>
                                        <tr>
                                            <th style="width: 10px"></th>
                                            <th >Articulo</th>
                                            <th style="width:100px">Cantidad</th>
                                            <th style="width:100px">P.Sugerido</th>
                                            <th style="width:100px">Precio s/Igv</th>
                                            <th style="width:100px">Precio c/Igv</th>
                                            <th style="width:100px">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <button type="button" class='delete borrar e btn btn-danger'> <i class="fa fa-trash" aria-hidden="true"></i> </button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="monto0 select2_demo_3 select_change" required="" id="articulo" onchange="ajax(0)" autocomplete="off"></select>
                                                <textarea  type='text' {{-- id='descripcion0' --}}  name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                                                <textarea type='text' id='numero_serie0'  name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px;" placeholder="N° de Serie"></textarea>
                                                <input style="min-width: 100px" hidden="" type='text' id='tipo_afec0' name='tipo_afec[]' readonly="readonly" class="monto0 form-control" onkeyup="multi(0)" autocomplete="off"  />
                                                <input type="hidden" class="celda"  name="articulo[]" id="input_prod1" >
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='text' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control inp"  onkeyup="multi(0)"  required  autocomplete="off"/>
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='text' id='precio_oficial0' name='precio_oficial[]' ondblclick="copy(0)"  class="precio_oficial0 form-control inp" required readonly  data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)"/>
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' step="0.0000001" id='precio0' name='precio[]'  class="monto0 form-control inp" onkeyup="multi_s_igv(0),multi(0)" required  autocomplete="off" />
                                                <input hidden type='text' id='precio_s_igv_float0' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(0),multi(0)" required  autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' step="0.0000001" id='precio_c_igv0' name='precio_c_igv[]'  class="precio_c_igv monto0 form-control inp" onkeyup="multi_c_igv(0),multi(0)" required  autocomplete="off" />
                                            </td> 
                                            <td>
                                                <input style="min-width: 100px"  type='number' id='total0' name='total' disabled="disabled" class="total form-control inp" required  autocomplete="off" />
                                            </td>
                                            <span id="spTotal"></span>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr style="background-color: #f5f5f500;" align="center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Subtotal :</td>
                                            <td colspan="2">
                                                <input id='sub_total' type="number" name="sub_total_sin_igv" readonly class="form-control inp" required />
                                                <input id='subtotal_gravado' type="text" name="subtotal_gravado" readonly class="form-control inp" required hidden="" />
                                            </td>
                                        </tr>
                                        <tr style="background-color: #f5f5f500;" align="center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>IGV :</td>
                                            <td colspan="2">
                                                <input id='igv' type="number" disabled="disabled" class="form-control inp" required />
                                            </td>
                                        </tr>
                                        <tr align="center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total :</td>
                                            <td colspan="2"><input id='total_final' type="number" name="costo_total"  readonly="readonly" class="form-control inp" required /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            {{-- </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                
                                <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
                            </div>
                            <div class="col-sm-6 ">
                                <button type="button" name="name" value="pdf" class="ladda-button btn btn-info float-right" id="boton"  style="margin-right: 5px">Enviar</button>
                                <button id="button_submit" hidden type="submit">Button DB</button>
                            </div>
                        </div>
                        <!-- Modal DETRACCIONES DENTRO DEL FORM, EN EL CONTROLLER CONDICIONAL PARA TOMAR O NO DETRACCION-->
                        <div class="modal fade" id="modal_detraccion" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Configuración de Detracciones</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="detraccion_valores">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h3 class="text-center text-bold">Por indicaciones de Sunat la Detracción se envía en Soles.</h3>
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <label for=""><strong>Tipo de Detraccion</strong></label>
                                                            <select class="select2_tipodetrac ipt_detrac" name="tipo_detraccion" id="select_tipo_pago" > 
                                                                <option value="">Seleccionar Tipo</option>
                                                                @foreach ($detraccion as $detra)
                                                                    <option value="{{$detra->id}}">{{$detra->codigo}} - {{$detra->descripcion}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="detracc_campo_required">
                                                                <small>Selecciona un campo</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for=""><strong>Porcentaje de Detraccion</strong></label>
                                                            <input type="text" class="form-control ipt_detrac" name="porcentaje_detraccion" id="porcentaje_detc" >
                                                            <div class="detracc_campo_required">
                                                                <small>Rellena este campo</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr style="margin-top: 5px; margin-bottom: 5px">
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <label for=""><strong>Medio de Pago</strong></label>
                                                            <select class="select2_mediopago ipt_detrac" name="medio_pago_detraccion" id="" >
                                                                <option value="">Seleccionar Medio de Pago</option>
                                                                @foreach ($medio_pago as $m_pago)
                                                                    <option value="{{$m_pago->id}}">{{$m_pago->codigo}} - {{$m_pago->descripcion}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="detracc_campo_required">
                                                                <small>Selecciona un campo</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for=""><strong>Total de Detraccion</strong></label>
                                                            <div class="input-group m-b">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-addon">S/.</span>
                                                                </div>
                                                                <input type="text" class="form-control ipt_detrac" name="total_detraccion" id="tota_detra" placeholder="0.00" readonly >
                                                            </div>
                                                            
                                                            <div class="detracc_campo_required">
                                                                <small>Rellena este campo</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-sm-6">

                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary" onclick="save_detraccion()">Verificar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    .slimScrollBar{
        display: none !important;
    }
    span.select2-container.select2-container--default.select2-container--open{
        z-index: 999999;
    }
    #loaderGif{
        /* background:url({{ asset('img/loading.gif') }}) 50% 50% no-repeat #000000a3; */
        background-size: 250px;
        display: none;
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100vh;
        z-index: 20;
    }
    @media only screen and (max-width: 1497px){
        .td_selected > span.select2.select2-container.select2-container--default{
            min-width: 376px !important;
        }
    }
    .item_guia{
        font-size: 11px;
        margin: 0px 7px;
        cursor: hand;
    }
    a.item_guia::after{
        content: "x";
        font-size: 9px;
        color: red;
        vertical-align: top;
    }
    .detracc_campo_required{
        display: none;
        /* font-size: 9px; */
        color: red;
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
<!-- Switchery -->
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>

<script type="text/javascript">
    $(".select2_demo_3").select2({
        placeholder: "Seleccionar Producto",
    });
    
    $(".select2_demo_almacen").select2({
        placeholder: "Seleccionar Almacen",
    });

    var elem_2 = document.querySelector('.js-switch');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
    switchery_2.disable();
 
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function toggle(){
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    }
    var changeCheckbox = document.querySelector('.js-switch');
    changeCheckbox.onchange = function() {
        if(changeCheckbox.checked == true){
            $('#modal_detraccion').modal('show');
            var inputs = document.querySelectorAll('.ipt_detrac');
            inputs.forEach(function(input) {
                // input.setAttribute('required', 'required');
            });
        }else{
            var inputs = document.querySelectorAll('.ipt_detrac');
            inputs.forEach(function(input) {
                // input.removeAttribute('required');
            });
        }
        
    };
        

    $('.select2_tipo_op').select2();
    $('.select2_mediopago').select2();
    $('.select2_tipodetrac').select2();
    $('.select2_tipodetrac').on('select2:select', function (e) {
        
        var data = e.params.data;
        var id_data = data.id;
        $.ajax({
            type: "post",
            url: "{{ route('pa.tipo_op_search') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'id_tipo_detra': data.id,
            },
            success: function (msg) {
                // console.log(msg.tasa)
                $('#porcentaje_detc').val(msg.tasa);
                multi_detraccion();
            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });
    });

    function multi_detraccion(){
        
        var moneda = $('#moneda_id').val();
        
        if(moneda == 1){ //soles
            var total = $('#total_final').val();
            var porc_det = $('#porcentaje_detc').val();
            var op_det = total * (porc_det / 100);
            var sub_zero = Math.round(op_det * 100) / 100;
            console.log(sub_zero);
            $('#tota_detra').val(sub_zero);
        }else{ //dolares
            var total_dol = $('#total_final').val();
            
            var tipo_cam = $('#tipo_paralelo').val();
            var total = total_dol * tipo_cam;

            var porc_det = $('#porcentaje_detc').val();
            var op_det = total * (porc_det / 100);
            var sub_zero = Math.round(op_det * 100) / 100;
            
            $('#tota_detra').val(sub_zero);
        }
    }

    $('#porcentaje_detc').on('keyup', function(){
        multi_detraccion();
    });

    $('.select2_tipo_op').on('select2:select', function (e) {
        
        var id = e.params.data.id;
        var split_id = id.split(' ');
        if(split_id[0] == '1001' || split_id[0] == '1002' || split_id[0] == '1003' ||split_id[0] == '1004'){
            console.log('a');
            $('#button_detracc').attr('disabled', false); 
            switchery_2.enable();
            $('.js-switch').trigger('click');
        }else{
            console.log('b');
            $('#button_detracc').attr('disabled', true); 
            switchery_2.disable();
            $('.js-switch').trigger('click');
        }
        // console.log(id.split(' '));
    });
</script>



{{-- Validar Formulario / No doble insercion de datos(Gente desesperado) --}}
<script>
    // TODO Selección de cliente por medio de ajax para mostrar los datos del cliente en el formularios
    // $('').val();
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
                //LIMPIAR EL INPUT GUIA REMISION
                $('#guia_save_inp').val("0");
            },
            cache: true
        }
    });
    $('.select2_demo_client').on('select2:select', function (e) {
        $('#guia_remi_input').val('0');
        var s = document.getElementById("guia_list");
        var numChilds = s.children.length;
        for(var i=0;i<numChilds;i++){
            s.children[0].remove() 
        }
        var data = e.params.data;
        $.ajax({
            type: "post",
            url: "{{ route('facturacion_manual.ajx_remision') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'id_cliente': data.id,
            },
            success: function (msg) {
                var miSpan = document.getElementById('lista_gr');
                while (miSpan.firstChild) {
                    miSpan.removeChild(miSpan.firstChild);
                }
                $('#guia_save_inp').val("0");

                if(typeof(msg) == "object"){
                    for (let index = 0; index < msg.length; index++) {
                        $('#guia_list').append("<option value='" + msg[index] + "'>");
                    }
                }
            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });
    });
    function agregarElemento() {

        const input = document.getElementById("guia_remi_input");
        const datalist = document.getElementById("guia_list");
        const listaElementos = document.getElementById("lista_gr");
        const opciones = input.value.trim().split(' ');

        opciones.forEach(opcion => {
            if (opcion && !Array.from(listaElementos.children).some(el => el.textContent === opcion)) {
                var val = $('#guia_save_inp').val();
                listaElementos.innerHTML += `<a class="item_guia" onclick="remove_item(this)">${opcion}</a>`;
                
                if(val == "0" ){
                    $('#guia_save_inp').val("");
                }
                var val2 = $('#guia_save_inp').val();
                $('#guia_save_inp').val(val2+`${opcion} `);
            }
        });

        input.value = "";
    }
    function remove_item(elemento){
        var input = $('#guia_save_inp').val();
        var texto = elemento.innerText;
        var new_text = texto+' ';
        var nuevoValor = input.replace(new_text, '');
        $('#guia_save_inp').val(nuevoValor);
        elemento.remove();
    }
    
    function valida(f) {
        var boton=document.getElementById("boton");
        var completo = true;
        var incompleto = false;
        if( f.elements[0].value == "" )
            { alert(incompleto); }
        else{boton.type = 'button';}
    }

</script>
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desesperado) --}}

{{-- @if($categoria=='producto') --}}
<script>
    var i = 2;
    $(".addmore").on('click', function () {
        var data = `[
            <tr>
                <td>
                    <button type="button" class='delete borrar e btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>
                <td class="td_selected">
                    <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})" autocomplete="off" required></select>
                    <textarea type='text' {{-- id='descripcion${i}'--}}   name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                    <textarea type='text' id='numero_serie${i}' placeholder="N° de Serie" name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                    <input type="hidden" class="celda"  name="articulo[]" id="input_prod${i}" >
                </td>
                <td>
                    <input type='text' style="min-width: 100px"  id='cantidad${i}' name='cantidad[]' class="monto${i} form-control inp" onkeyup="multi(${i})" required  autocomplete="off"/>
                </td>
                <td class="full-height-scroll tooltip-demo">
                    <input type='text' style="min-width: 100px"  id='precio_oficial${i}' name='precio_oficial[]' ondblclick="copy(${i})" class="precio_oficial${i} form-control inp" required  autocomplete="off" readonly data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" />
                </td>
                <td>
                    <input type='number' style="min-width: 100px"step="0.0000001"  id='precio${i}' onchange="change(${i})" name='precio[]' class="monto${i} form-control inp" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off"/>
                    <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
                </td>
                <td>
                    <input style="min-width: 100px" type='number' step="0.0000001"id='precio_c_igv${i}' name='precio_c_igv[]'  class="precio_c_igv p_inp monto${i} form-control inp" onkeyup="multi_c_igv(${i}),multi(${i})" required  autocomplete="off" />
                </td>
                <td>
                    <input type='number' id='total${i}'  style="min-width: 100px"  name='total' disabled="disabled" class="total form-control inp"  required  autocomplete="off"/>
                </td>
            </tr>
        `;
        $('.tables').append(data);
        i++;

        //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
        articlesSelect2();
        toggle();

        $(".addmore").prop("disabled", true);
        // $(".borrar").prop("disabled", false);
    });

    //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
    $(document).ready(function() {
        articlesSelect2();
    });

    //Funcion para el select articles "AJAX" (productos- servicios), ejecutandose cada vez realizada una llamada
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
                        search: params.term, // search term 
                        almacen: 0,
                        tipo_doc: 'manual' 
                    };
                },
                processResults: function (data) {
                    //validador de articulos multiples
                    let data_length = data.length;
                    let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                    let articles_selected_count_ajax = articles_selected_ajax.length; 
                    // for(var z=0;z<articles_selected_count_ajax;z++){
                    //     var selected_ajax=document.getElementsByClassName("select2_demo_3 select_change")[z].value;
                    //     for(var y=0;y<data_length;y++){
                    //         if(selected_ajax == data[y].id+ " | " + data[y].codigo + " | " + data[y].codigo_original + " | " + data[y].nombre){
                    //             if(data[y].tipo == 'producto'){
                    //                 data[y].disabled=true;
                    //             }else{
                    //                 data[y].disabled=false;
                    //             }
                    //         }
                    //     }
                    // }
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

    //Funcion Copiar
    function copy(a){
        if(a==0){
            var copy = document.getElementById(`precio_oficial0`).value;
            document.getElementById(`precio0`).value = copy;
            multi_s_igv(0);
        }else{
            var copy = document.getElementById(`precio_oficial${a}`).value;
            document.getElementById(`precio${a}`).value = copy;
            multi_s_igv(a);
        }
        multi(a);
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
                if(msg.price == 0 && msg.amount == 0){
                    // $(`#precio${a}`).val(0);
                    $(`#cantidad${a}`).val(0);
                    $(`#cantidad${a}`).attr('max', msg.amount );
                    $(`#cantidad`).attr('max', msg.amount );
                    $(`#precio_oficial${a}`).val(msg.price)
                }else{
                    // $(`#precio${a}`).val(1);
                    $(`#precio_oficial${a}`).val(msg.price)
                    $(`#cantidad${a}`).val(1);
                    // $(`#cantidad${a}`).attr('max', msg.amount );
                    // $(`#cantidad`).attr('max', msg.amount );
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

    
    function multi(a){
        var igv = 18.00;
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

        var cantidad = document.querySelector(`#cantidad${a}`).value;
        var precio = document.querySelector(`#precio${a}`).value;
        
        var multiplier = 100;
        var final= precio * cantidad;
        var final_decimal = Math.round(final * multiplier) / multiplier;

        document.getElementById(`precio_s_igv_float${a}`).value = final_decimal;
        var only_igv = final + ( parseFloat(final) * ( igv / multiplier) );
        var igv_decimal = Math.round(only_igv * multiplier ) / multiplier;
        document.getElementById(`total${a}`).value = igv_decimal;

         // Operacion para subtotal sin igv
         var sub_igv = $('[name="precio_s_igv_float"]');
        var sub_igv_t = 0;
        sub_igv.each(function(){
            sub_igv_t += parseFloat($(this).val());
        });        
        var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
        $('#sub_total').val(sub_igv_tt);
        document.getElementById("sub_total").value = sub_igv_tt;

        //OPERACION PARA CALULCAR EL IGV
        var only_igv = (parseFloat(sub_igv_tt) * (igv/multiplier)) 
        var igv_decimal = Math.round(only_igv * multiplier ) / multiplier;
        document.getElementById("igv").value = igv_decimal;

        var end = igv_decimal+parseFloat(sub_igv_tt);
        var end2 = Math.round(end * multiplier) / multiplier;
       // Operacion para total
        // var totalInp = $('[name="total"]');
        // var total_t = 0;
        // totalInp.each(function(){
        //     total_t += parseFloat($(this).val());
        // });
        // console.log(total_t);
        // var multiplier2 = 100;
        var total_tt = sub_igv_tt+ end2;
        
        $('#total').val(total_tt);

        // var subtotal = document.querySelector(`#total`).value;
        document.getElementById("total_final").value = end2;


        var monto_c = document.getElementsByClassName('monto_pago');

        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (end2/inp_mont)
            document.getElementById("monto_pago0").value = Math.round(end2 * multiplier)/ multiplier;
            
        }
        $("#cuotas_footer").html(end2);
        multi_detraccion();
    }
    $(document).on('click','#button_cuotas_save', function(event){
            
        var monto_c = document.getElementsByClassName('monto_pago');
        var monto_fc = document.getElementsByClassName('fecha_pago');
        console.log(monto_c)
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        var total =  $("#cuotas_footer").html();
        var fin = 0.00;
        var comp = 0;
        for (var i = 0; i < inp_mont; i++) {
            fin = parseFloat(fin) + parseFloat(monto_c[i].value);
        }
        var fin_r = Math.round(fin * 100) / 100;
        console.log(total);
        for (var i = 0; i < inp_mont; i++) {
            var fecha = monto_fc[i].id;
            var monto = monto_c[i].id;

            var input_text = document.getElementById(`${monto}`).value;
            var date_text = document.getElementById(`${fecha}`).value;
            if( input_text.length  == 0 || date_text.length  == 0){
                console.log("a");
                document.getElementById('alert_campos').style.display = "flex";                    
                mostrarMensaje();
                return;
            }
        }
        if(fin_r != total){
            document.getElementById('suma_campos').style.display = "flex";
        }else{
            console.log('e')
            $('#cuotas_modal').modal('hide')
        }
        mostrarMensaje();
        
    });
    function mostrarMensaje(){
            // $("#alert_campos").show(200);
            $("#alert_campos").hide(3000);
            $("#suma_campos").hide(3000);
        }
        //Función de borrado de fila de articulos (Producto-Servicio)
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        var input_text_opt = fila.find('input[class="celda"]').val();
        $('option[value="'+input_text_opt+'"]').prop("disabled", false);
        $(".addmore").prop("disabled", false);
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Item",
        });
        // ELIMINAR TR
        if (e>1) {
            fila.closest('tr').remove();
            // $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        }else{
            // $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
            $(".select2_demo_3").val(null).trigger("change");
            $(".inp").val(null);

        }
        var totalInp = $('[name="total"]');
        var total_t = 0;

        totalInp.each(function(){
            total_t += parseFloat($(this).val());
        });

        var multiplier2 = 100;
        var total_tt = Math.round(total_t * multiplier2) / multiplier2;

        $('#sub_total').val(total_tt);

        var igv_valor={{$igv->renta}}; 
        var subtotal = document.querySelector(`#sub_total`).value;
        var igv=subtotal*igv_valor/100;

        var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
        var end=igv_decimal+parseFloat(subtotal);

        var end2 = Math.round(end * multiplier2) / multiplier2;

        document.getElementById("igv").value = igv_decimal;
        document.getElementById("sub_total").value = subtotal;

        var end=parseFloat(igv_decimal)+parseFloat(subtotal);
        var end3 = Math.round(end * multiplier2) / multiplier2;
        document.getElementById("total_final").value = end3;

        var monto_c = document.getElementsByClassName('monto_pago');

        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (end2/inp_mont)
            document.getElementById("monto_pago0").value = Math.round(end2 * multiplier2)/ multiplier2;
        }
        articlesSelect2();
    });
  
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

        function seleccionado_fp(){
            var opt = $('#forma_pago').val();
            if(opt=="1"){
                document.getElementById('credito_pago').style.visibility = "hidden";
                document.getElementById('ven_1p').style.visibility = "initial";
                document.getElementById('ven_2p').style.visibility = "initial";
                document.getElementById('ven_3p').style.visibility = "initial";
                document.getElementById('fecha_vencimiento').removeAttribute('disabled');
                    // $('#consulta_s').hide();
                }else{
                    // $('#consulta_p_input').prop('disabled', 'disabled');
                    document.getElementById('credito_pago').style.visibility = "initial";
                    document.getElementById('ven_1p').style.visibility = "hidden";
                    document.getElementById('ven_2p').style.visibility = "hidden";
                    document.getElementById('ven_3p').style.visibility = "hidden";
                    document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
                    // $('#consulta_s').show();
                }
            }
        
            var total = document.getElementById('total_final').value;
            var x = 1;
            $(".add_pago").on('click', function () {
                var total = document.getElementById('total_final').value;
                var data = `
                <div class="delete_modal${x} row">
                <div class="col-sm-1"><label>Fecha:</label></div>
                <div class="col-sm-4">
                <input type="date" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" min="{{$fecha_1}}">
                </div>
                <div class="col-sm-1"><label>Monto:</label></div>
                <div class="col-sm-4">
                <div class="input-group mb-3" style="padding-right:15px">
                <div class="input-group-prepend">
                
                </div>
                <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}"    onkeypress="return filterFloat(event,this);" >
                </div>
                </div>
                <div class="col-sm-2">
                <label ><button type="button"  class="xd btn btn-danger" onclick="eliminar(${x})"><i class="fa fa-trash-o fa-lg" > </i></button></label>
                </div>
                </div>`;
                $('.row_number').append(data);

                var inp_mont = document.getElementsByClassName('monto_pago').length;

       // document.getElementById(`monto_pago${x}`).value = (total/inp_mont);

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
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
            }
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            if(inp_mont>5){
                document.getElementById('add_pago').setAttribute('disabled', "true");
            }else{
                document.getElementById('add_pago').removeAttribute('disabled');
            }
        });

    </script>

    <style type="text/css">
        .a{color: red}
    </style>
    <script type="text/javascript">
        // $(".delete_pago").on('click', function () {
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
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
            }
            if(inp_mont>5){
                document.getElementById('add_pago').setAttribute('disabled', "true");
            }else if(inp_mont == 1){
                document.getElementById("monto_pago0").value = total;
            }else{
                document.getElementById('add_pago').removeAttribute('disabled');
            }
        };
    
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
                $(`#button_changeMoney`).html(msg.other);
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
        function cerrar_but_rc(){
            document.getElementById('alert_campos').style.display = "none";
        }
        function cerrar_but_mt(){
            document.getElementById('suma_campos').style.display = "none";
        }

    var igv = {{$igv->renta}}
    var multiplier = 100;
    function multi_s_igv(a){
        var pr_s_igv = $(`#precio${a}`).val();
        $(`#precio_s_igv_float${a}`).val(pr_s_igv);
        var c_igv_s_redondeo = parseFloat(pr_s_igv)+(parseFloat(pr_s_igv)*igv/multiplier);
        var c_igv_redondeo = Math.round(c_igv_s_redondeo * multiplier)/multiplier;
        $(`#precio_c_igv${a}`).val(c_igv_redondeo);
    }

    function multi_c_igv(a){
        var pr_c_igv = $(`#precio_c_igv${a}`).val();
        var igv_dec = igv / multiplier ;
        var s_igv_s_base = parseFloat(pr_c_igv) / ( 1 + parseFloat(igv_dec));
        var s_igv_redondeo = Math.round(s_igv_s_base * multiplier) / multiplier;
        $(`#precio${a}`).val(s_igv_redondeo);
        $(`#precio_s_igv_float${a}`).val(s_igv_redondeo);
    }
    function disabled_money(){
        $(`.money_change`).prop('disabled', true);
        $(`.button_money`).addClass('not-active');

        setTimeout(function(){
            $(`.money_change`).prop('disabled', false);
            $(`.button_money`).removeClass('not-active');
        }, 10000);
    }
    
    function codigo_numero(){
        var almacen = $('.select2_demo_almacen').val();
        console.log(almacen);
        $.ajax({
            type: "post",
            url: "{{route('facturacion_manual.change_almacen_tipo')}}",
            data: {
                '_token': "{{ csrf_token() }}",
                'almacen': almacen,
            },
            success: function(msg){
                $('#codigo_fac_manual').html(msg+` <span class="small" data-toggle="tooltip" data-placement="bottom" title="N° Referencial"><i class="fa fa-question-circle"></i></span>`)
            }
        })
    }
    $('#guia_remi_input').on('change', function(){
        var valor = this.value;
        var conversion = valor.replace(/ /g, "|");
        var listaNombres = valor.split(" ");    
        console.log(listaNombres);
        for (let i = 0; i < listaNombres.length; i++) {
            var compa = /^([A-Z0-9]{3,4})-\d{1,8}$/;
            var seg = compa.test(listaNombres[i])
            if(seg == true || listaNombres[i] == 0 ){
                $('#guia_remi_input').css('border', '1px solid #e5e6e7');
                agregarElemento();
            }else{
                $('#guia_remi_input').css('border', 'solid 1px red');
                
            }
        }
    });
    $("#guia_remi_input").on("keyup", function() {
        var value = $(this).val();
        var spaceIndex = value.indexOf(" ");
        if (spaceIndex > -1) {
            $('#guia_remi_input').click();
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
        function mostrarMensaje(){
            // $("#alert_campos").show(200);
            $("#alert_campos").hide(3000);
            $("#suma_campos").hide(3000);
        }
        function save_detraccion(){
            var seletc_det = $('.select2_tipo_op').val();
            var split_id = seletc_det.split(' ');
            if(split_id[0] == '1001' || split_id[0] == '1002' || split_id[0] == '1003' ||split_id[0] == '1004'){
                var tipo_detra = $('#select_tipo_pago').val();
                var ipt_medio = $('.select2_mediopago').val();
                var porce_detra = $('#porcentaje_detc').val();
                var tot_det = $('#tota_detra').val();
                
                if(tipo_detra == "" || ipt_medio == "" || porce_detra == "" || tot_det == ""){
                    $('#modal_detraccion').modal('show');
                    var inputs = document.querySelectorAll('.detracc_campo_required');
                    inputs.forEach(function(input) {
                        input.style.display = 'block';
                    });
                    return ;
                }else{
                    var inputs = document.querySelectorAll('.detracc_campo_required');
                    inputs.forEach(function(input) {
                        input.style.display = 'none';
                    });
                    $('#modal_detraccion').modal('hide');
                }
                
            }
        }204100 
    </script>
    @stop
