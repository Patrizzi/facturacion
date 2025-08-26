@extends('layout')
@section('title', 'Facturacion')
@section('href_accion', route('facturacion.index'))
@section('value_accion', 'Atras')

@section('content')

    @if ($errors->any())
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

    {{-- Boton de modal para clientes --}}
    {{-- @section('ruta_retorno', 'facturacion')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o"
            aria-hidden="true"></i>cliente </a>
</div> --}}
    {{-- Fin de boton de modal para clientes --}}

    {{-- <style>
    /* @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap'); */
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
</style> --}}

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h4><strong>Generar Factura</strong></h4>
            </div>
            <div class="ibox-content">
                <form action="{{ route('facturacion.store', $moneda->id) }}" enctype="multipart/form-data" method="post"
                    onsubmit="return valida(this)" id="form_store">
                    @csrf
                    @method('PUT')
                    <div class="row form-label word-style">
                        <div class="col-md-6">
                            <!-- Cliente -->
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <select class="select2_demo_client" name="cliente" id="cliente" required=""
                                            value="{{ old('nombre') }}">
                                        </select>
                                        <div class="input-group-append">
                                            <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente"><i
                                                    class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Orden C.:</strong></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="orden_compra" required
                                                autocomplete="off" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>G. Remisión: </strong>
                                            <small class="tooltip-demo"><i class="fa fa-info-circle" data-toggle="tooltip"
                                                    data-placement="bottom"
                                                    title="Ej: TE01-999  *  Mayusculas y separar solo con espacios en blanco"></i></small></label>
                                        <div class="col-md-8">
                                            <input list="guia_list" class="form-control" name="guia_r" id="guia_remi_input"
                                                value="0" autocomplete="off">
                                            <datalist id="guia_list">
                                            </datalist>
                                            <span id="lista_gr"></span>
                                            <input type="hidden" name="guia_r" id="guia_save_inp" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>Comisionista:</strong></label>
                                <div class="col-md-10">
                                    <select name="comisionista" id="comisionista" class="select2_demo_comisionista"
                                        onchange="comision()">
                                        <option value="Sin Comisión - 0 %">Sin Comisión - 0 %</option>
                                        @foreach ($p_venta as $comisionista)
                                            <option id="{{ $comisionista->id }}">{{ $comisionista->cod_vendedor }} -
                                                {{ $comisionista->personal->personal_l->nombres }} -
                                                <span style="color: red">{{ $comisionista->comision }} %</span>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>Vendedor:</strong></label>
                                <div class="col-md-10">
                                    {{-- <span class="form-control" id="nombre_vendedor">{{ auth()->user()->name }}</span> --}}
                                    <input type="text" name="" id="" class="form-control"
                                        id="nombre_vendedor" readonly value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Tipo de Operación -->
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>T. Operación </strong></label>
                                <div class="col-md-10">
                                    <select class="select2_tipo_op" name="tipo_operacion">
                                        @foreach ($tipo_operacion as $t_op)
                                            <option id="{{ $t_op->id }}">{{ $t_op->codigo }} - {{ $t_op->informacion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Forma de Pago y Moneda -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Forma Pago:</strong></label>
                                        <div class="col-md-6 pago_first_column">
                                            <select class="form-control" name="forma_pago" id="forma_pago"
                                                onchange="seleccionado_fp()" required>
                                                @foreach ($forma_pagos as $forma_pago_item)
                                                    <option value="{{ $forma_pago_item->id }}"
                                                        {{ isset($forma_pago) && $forma_pago == $forma_pago_item->id ? 'selected' : '' }}>
                                                        {{ $forma_pago_item->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2" id="credito_pago" style="display: none;">
                                            <button type="button" class='cuota_modal btn btn-info' id="cuota_modal"
                                                data-toggle="modal" data-target="#cuotas_modal"><i
                                                    class="fa fa-dollar"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Moneda:</strong></label>
                                        <div class="col-md-8">
                                            <select name="" id="" class="form-control"
                                                onchange="changeMoney()">
                                                <option value="nacional"
                                                    {{ $moneda->tipo == 'nacional' ? 'selected' : '' }}>Soles</option>
                                                <option value="extranjera"
                                                    {{ $moneda->tipo == 'extranjera' ? 'selected' : '' }}>Dólares</option>
                                            </select>
                                            <input type="hidden" name="moneda" id="moneda" class="form-control "
                                                value="{{ ucwords($moneda->nombre) }}" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fechas -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>F. Emisión:</strong></label>
                                        <div class="col-md-8 pago_first_column">
                                            <input type="date" id="fecha_emision" name="fecha_emision"
                                                class="form-control" value="{{ date('Y-m-d') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>F. Venc.:</strong></label>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control" id="fecha_vencimiento"
                                                name="fecha_vencimiento" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Detracción -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><strong>Detracción:</strong></label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="detraccion" name="detraccion_value">
                                        <option value="0">Desactiva</option>
                                        <option value="1">Activa</option>
                                    </select>
                                </div>
                                <div class="col-sm-2" style="display: flex">
                                    <a href="" id="button_detracc" data-toggle="modal"
                                        data-target="#modal_detraccion" style="margin: auto"><i
                                            class="fa fa-question-circle"
                                            style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-form-label col-md-1"><strong>Observación:</strong></label>
                                <div class="col-md-11">
                                    <textarea class="form-control" name="observacion" id="observacion" autocomplete="off" placeholder="Observación"
                                        rows="1">Emitimos la siguiente Boleta a vuestra solicitud</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
                            <input type="hidden" name="almacen" id="almacen_id" class="form-control "
                                value="{{ $sucursal->id }}" readonly="readonly">
                            <input type="hidden" id="moneda_id" class="form-control " value="{{ $moneda->id }}">
                        </div>
                        <input type="hidden" name="" id="count_articles" value="">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table cellspacing="0" class="table tables">
                                    <thead>
                                        <tr style="">
                                            <th style="vertical-align: middle;width: 50px;">
                                                <div>
                                                    <button type="button" class='addmore btn btn-sm btn-info'
                                                        style="display: none"><i class="fa fa-plus-square"
                                                            aria-hidden="true"></i></button>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#add_product_data">
                                                    <i class="fa fa-plus-square"></i>
                                                </button>
                                            </th>
                                            <th>Artículo</th>
                                            <th>Stock</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Dscto.</th>
                                            <th>P. U. Dcto.</th>
                                            <th>P. U. Com.</th>
                                            <th>Total</th>
                                            <th>Total IGV</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <button type="button" class='delete borrar e btn btn-sm btn-danger'> <i
                                                        class="fa fa-trash" aria-hidden="true"></i> </button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="monto0 select2_demo_3 select_change" required=""
                                                    id="articulo" onchange="ajax(0)" autocomplete="off">
                                                </select>
                                                <textarea type='text' {{-- id='descripcion0' --}} name='descripcion_item[]' class="form-control"
                                                    placeholder="Descripción de Item" autocomplete="off" style="margin-top: 5px;"></textarea>
                                                <textarea type='text' id='numero_serie0' name='numero_serie[]' class="form-control" autocomplete="off"
                                                    style="margin-top: 5px;" placeholder="N° de Serie"></textarea>
                                                <input style="" hidden="" type='text' id='tipo_afec0'
                                                    name='tipo_afec[]' readonly="readonly" class="monto0 form-control"
                                                    onkeyup="multi(0)" autocomplete="off" />
                                                <input type="hidden" class="celda" name="articulo[]" id="input_prod1">
                                            </td>
                                            <td>
                                                <input style="" type='text' id='stock0' readonly="readonly"
                                                    name='stock[]' class="form-control" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="" type='number' id='cantidad0' name='cantidad[]'
                                                    max="" min="1" class="monto0 form-control"
                                                    onkeyup="multi(0)" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="" type='text' id='precio0' name='precio[]'
                                                    readonly="readonly" class="monto0 form-control" onkeyup="multi(0)"
                                                    required autocomplete="off" />
                                            </td>
                                            <td>
                                                <div style="position: relative; "> <input class="text_des"type='text'
                                                        id='descuento0' name='descuento[]' readonly="readonly"
                                                        class="" required autocomplete="off" /></div>
                                                <div class="div_check">
                                                    <input class="check" type='checkbox' id='check0' name='check[]'
                                                        onclick="multi(0)" style="" autocomplete="off" />
                                                </div>
                                                <input type='hidden' id='check_descuento0' name='check_descuento[]'
                                                    class="form-control" required>
                                                <input type='hidden' id='promedio_original0' name='promedio_original[]'
                                                    class="form-control" required>
                                            </td>
                                            <td>
                                                <input style="" type='text' id='precio_unitario_descuento0'
                                                    name='precio_unitario_descuento[]' readonly="readonly"
                                                    class="precio_unitario_descuento0 form-control" required
                                                    autocomplete="off" />
                                            </td>
                                            <input type='hidden' name="comision[]" id='comision0'
                                                readonly="readonly" class="form-control comision_input" required autocomplete="off" onchange="multi(0)" />
                                            <td>
                                                <input style="" type='text' id='precio_unitario_comision0'
                                                    name='precio_unitario_comision[]' readonly="readonly"
                                                    class="form-control" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="" type='text' id='total0' name='total'
                                                    disabled="disabled" class="total form-control " required
                                                    autocomplete="off" />
                                                <input type='text' id='afectacion0' style="" name='afectacion'
                                                    disabled="disabled" class="afectacion form-control " hidden=""
                                                    autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="" type='text' id='precio_unitario_igv0'
                                                    name='precio_unitario_igv[]' readonly="readonly"
                                                    class="precio_unitario_igv0 form-control" required
                                                    autocomplete="off" />
                                            </td>

                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr style="background-color: #f5f5f500;" align="center">
                                            <td class="text-right" colspan="8"><strong>Subtotal:</strong></td>
                                            <td colspan="2">
                                                <input id='sub_total' type="text" name="sub_total_sin_igv" readonly
                                                    class="form-control" required />
                                                <input id='subtotal_gravado' type="text" name="subtotal_gravado"
                                                    readonly class="form-control" required hidden="" />
                                            </td>
                                        </tr>
                                        <tr style="background-color: #f5f5f500;" align="center">
                                            <td class="text-right" colspan="8"><strong>IGV :</strong></td>
                                            <td colspan="2"><input id='igv' type="text" disabled="disabled"
                                                    class="form-control" required /></td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="8" class="text-right"><strong>Total :</strong></td>
                                            <td colspan="2"><input id='total_final' type="text"
                                                    name="precio_final_igv" readonly="" class="form-control"
                                                    required /></td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" id="boton" name="boton" class="btn btn-primary button-lada"
                                    style="background: #0400c2; border-radius:8px; font-weight:450; font-size: 1rem; padding: 7px 20px;">
                                    <strong>Guardar</strong>
                                </button>
                                {{-- <button class="btnn float-right" id="finalizar_button" type="button"
                                    style="margin-left:10px; background: #6c757d; border-radius:8px; font-weight:450; font-size: 1rem; padding: 7px 20px; border: none; color: white;">
                                    <strong>Guardar y finalizar</strong>
                                </button> --}}
                                {{-- <button class="ladda-button btn btn-primary float-right" type="button" id="boton" name="boton" ><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp; --}}
                                <button type="submit" id="button_submit" hidden ></button>

                            </div>
                        </div>
                    </div>
                    <!-- Modal Tipo de Pago | Cuotas -->
                    <div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                        id="alert_campos" style="display: none">
                                        <strong style="font-size:11px">Rellenar todos los campos</strong>
                                        <button type="button" class="close_model_rc close" onclick="cerrar_but_rc()"
                                            style="padding: 6;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                        id="suma_campos" style="display: none">
                                        <strong style="font-size:11px">La suma de las cuotas es diferente del monto
                                            total</strong>
                                        <button type="button" class="close_model_mt close" onclick="cerrar_but_mt()"
                                            style="padding: 6;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="row_number">
                                        <div class="pago_modal row">
                                            <div class="col-sm-1"><label>Fecha:</label></div>
                                            <div class="col-sm-4">
                                                <input type="date" name="fecha_pago[]" id="fecha_pago0"
                                                    class="fecha_pago form-control" min="{{ $fecha_1 }}">
                                            </div>
                                            <div class="col-sm-1"><label>Monto:</label></div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3" style="padding-right:15px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            id="basic-addon3">{{ $moneda->simbolo }}</span>
                                                    </div>
                                                    <input type="text" name="monto_pago[]" id="monto_pago0"
                                                        class="monto_pago form-control"
                                                        onkeypress="return filterFloat(event,this);">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <label><button type="button" aria-hidden="true" id="add_pago"
                                                        class="add_pago btn btn-success"><i
                                                            class="fa fa-plus-square-o fa-lg">
                                                        </i></button></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="display: block">
                                    <div class="row">
                                        <div class="col-sm-6" style="">
                                            <label for=""><strong>Precio Total: &nbsp;</strong><span
                                                    id="simb_fot">{{ $moneda->simbolo }}</span>&nbsp;</label><label
                                                id="cuotas_footer"></label>
                                        </div>
                                        <div class="col-sm-6" align="right">
                                            <button type="button" id="button_cuotas_save"
                                                class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  --}}
                    <!-- Modal DETRACCIONES DENTRO DEL FORM, EN EL CONTROLLER CONDICIONAL PARA TOMAR O NO DETRACCION-->
                    <div class="modal fade" id="modal_detraccion" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Configuración de
                                        Detracciones</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="detraccion_valores">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3 class="text-center text-bold">Por indicaciones de Sunat la
                                                    Detracción se envía en Soles.</h3>
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <label for=""><strong>Tipo de
                                                                Detraccion</strong></label>
                                                        <select class="select2_tipodetrac ipt_detrac"
                                                            name="tipo_detraccion" id="select_tipo_pago">
                                                            <option value="">Seleccionar Tipo</option>
                                                            @foreach ($detraccion as $detra)
                                                                <option value="{{ $detra->id }}">
                                                                    {{ $detra->codigo }} -
                                                                    {{ $detra->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="detracc_campo_required">
                                                            <small>Selecciona un campo</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for=""><strong>Porcentaje de
                                                                Detraccion</strong></label>
                                                        <input type="text" class="form-control ipt_detrac"
                                                            name="porcentaje_detraccion" id="porcentaje_detc">
                                                        <div class="detracc_campo_required">
                                                            <small>Rellena este campo</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr style="margin-top: 5px; margin-bottom: 5px">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <label for=""><strong>Medio de
                                                                Pago</strong></label>
                                                        <select class="select2_mediopago ipt_detrac"
                                                            name="medio_pago_detraccion" id="">
                                                            <option value="">Seleccionar Medio de Pago
                                                            </option>
                                                            @foreach ($medio_pago as $m_pago)
                                                                <option value="{{ $m_pago->id }}">
                                                                    {{ $m_pago->codigo }} -
                                                                    {{ $m_pago->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="detracc_campo_required">
                                                            <small>Selecciona un campo</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for=""><strong>Total de
                                                                Detraccion</strong></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-addon">S/.</span>
                                                            </div>
                                                            <input type="text" class="form-control ipt_detrac"
                                                                name="total_detraccion" id="tota_detra"
                                                                placeholder="0.00" readonly>
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
                                    <button type="button" class="btn btn-primary"
                                        onclick="save_detraccion()">Verificar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal AGREGAR CON UN CLICK UN ARTICULO -->
    <div class="modal fade bd-example-modal-lg" id="add_product_data" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Agregado Rápido de Articulos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12" style="margin-bottom: 15px">
                            <input type="text" name="" id="search_product" class="form-control"
                                placeholder="Buscar por código o nombre del producto o Servicio" autocomplete="off">
                            <small>Filtrado por Producto o Servicio</small>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover data_table_multiple"
                                    style="font-size: 90%;border-top: 1px solid #e7eaec;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>CODIGO</th>
                                            <th>ARTICULO</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO U. SUGERIDO </th>
                                            <th>PRECIO S/IGV</th>
                                            <th>PRECIO C/IGV</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close_add_product_data"
                        data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="loaderGif"></div>

    <style>
        .input-group>.select2-container--bootstrap {
            width: auto;
            flex: 1 1 auto;
        }

        .input-group>.select2-container--bootstrap .select2-selection--single {
            height: 100%;
            line-height: inherit;
            padding: 0.5rem 1rem;
            border: 1px solid #e5e6e7;
        }

        .select2-results__option.select2-results__option--highlighted {
            background-color: #1c84c6 !important;
            color: white !important;
        }

        .text_des {
            border-radius: 10px;
            border: 1px solid #e5e6e7;
            width: 80px;
            padding: 6px 12px;
        }

        .check {
            -webkit-appearance: none;
            height: 34px;
            background-color: #ffffff00;
            -moz-appearance: none;
            border: none;
            appearance: none;
            width: 80px;
            border-radius: 10px;
        }

        .div_check {
            position: relative;
            top: -33px;
            left: 0px;
            background-color: #ffffff00;
            top: -35;
        }

        .check:checked {
            background: #0375bd6b;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        label.col-form-label::marker {
            list-style: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 12px;
        }

        .select2-container--default .select2-selection--single {
            border: none;
        }

        span.select2.select2-container.select2-container--default {
            width: 100% !important;
            background-color: #FFFFFF;
            background-image: none;
            border-radius: 1px;
            display: block;
            padding: 3px 12px;
            border: 1px solid #e5e6e7;
        }

        .td_selected>span.select2.select2-container.select2-container--default {
            max-width: 700px !important;
            width: 40vw !important;
        }

        #operacion_select>span.select2.select2-container.select2-container--default {
            max-width: 100% !important;
        }

        span.select2-container.select2-container--default.select2-container--open {
            z-index: 999999;
        }

        .a {
            color: red
        }

        #loaderGif {
            background: url({{ asset('img/loading.gif') }}) 50% 50% no-repeat #000000a3;
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

        @media only screen and (max-width: 1497px) {
            .td_selected>span.select2.select2-container.select2-container--default {
                min-width: 376px !important;
            }
        }

        .item_guia {
            font-size: 11px;
            margin: 0px 7px;
            cursor: hand;
        }

        a.item_guia::after {
            content: "x";
            font-size: 9px;
            color: red;
            vertical-align: top;
        }

        .detracc_campo_required {
            display: none;
            /* font-size: 9px; */
            color: red;
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1200px;
            }
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
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>

    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

    <script type="text/javascript">
        // var elem_2 = document.querySelector('.js-switch');
        // var switchery_2 = new Switchery(elem_2, {
        //     color: '#ED5565'
        // });
        // switchery_2.disable();

        // var changeCheckbox = document.querySelector('.js-switch');
        // changeCheckbox.onchange = function() {
        //     if (changeCheckbox.checked == true) {
        //         $('#modal_detraccion').modal('show');
        //         var inputs = document.querySelectorAll('.ipt_detrac');
        //         inputs.forEach(function(input) {
        //             // input.setAttribute('required', 'required');
        //         });
        //     } else {
        //         var inputs = document.querySelectorAll('.ipt_detrac');
        //         inputs.forEach(function(input) {
        //             // input.removeAttribute('required');
        //         });
        //     }

        // };

        // DETRACCION
        $('#detraccion').on('change', function() {
            var selected = this.value;
            console.log(selected);
            if (selected == "1") {
                $('#modal_detraccion').modal('show');
                var inputs = document.querySelectorAll('.ipt_detrac');
                inputs.forEach(function(input) {
                    // input.setAttribute('required', 'required');
                });
            } else {
                var inputs = document.querySelectorAll('.ipt_detrac');
                inputs.forEach(function(input) {
                    // input.removeAttribute('required');
                });
            }
        });
        $(".select2_demo_comisionista").select2({
            // placeholder: "Sin comisión"
        });
        $('.select2_tipo_op').select2();
        $('.select2_mediopago').select2();
        $('.select2_tipodetrac').select2();

        $('.select2_tipodetrac').on('select2:select', function(e) {

            var data = e.params.data;
            var id_data = data.id;
            $.ajax({
                type: "post",
                url: "{{ route('pa.tipo_op_search') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id_tipo_detra': data.id,
                },
                success: function(msg) {
                    // console.log(msg.tasa)
                    $('#porcentaje_detc').val(msg.tasa);
                    multi_detraccion();
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        });

        function multi_detraccion() {

            var moneda = $('#moneda_id').val();

            if (moneda == 1) { //soles
                var total = $('#total_final').val();
                var porc_det = $('#porcentaje_detc').val();
                var op_det = total * (porc_det / 100);
                var sub_zero = Math.round(op_det * 100) / 100;
                console.log(sub_zero);
                $('#tota_detra').val(sub_zero);
            } else { //dolares
                var total_dol = $('#total_final').val();

                var tipo_cam = $('#tipo_paralelo').val();
                var total = total_dol * tipo_cam;

                var porc_det = $('#porcentaje_detc').val();
                var op_det = total * (porc_det / 100);
                var sub_zero = Math.round(op_det * 100) / 100;

                $('#tota_detra').val(sub_zero);
            }
        }

        $('#porcentaje_detc').on('keyup', function() {
            multi_detraccion();
        });

        $('.select2_tipo_op').on('select2:select', function(e) {

            var id = e.params.data.id;
            var split_id = id.split(' ');
            if (split_id[0] == '1001' || split_id[0] == '1002' || split_id[0] == '1003' || split_id[0] == '1004') {
                console.log('a');
                $('#button_detracc').attr('disabled', false);
                switchery_2.enable();
                $('.js-switch').trigger('click');
            } else {
                console.log('b');
                $('#button_detracc').attr('disabled', true);
                switchery_2.disable();
                $('.js-switch').trigger('click');
            }
            // console.log(id.split(' '));
        });
        $(".select2_demo_client").select2({
            theme: "bootstrap",
            placeholder: "Seleccionar Cliente",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    var tipo_coti = 1;
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_coti: tipo_coti
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };

                        })
                    };
                    //LIMPIAR EL INPUT GUIA REMISION
                    $('#guia_save_inp').val("0");
                },
                cache: true
            }
        });
        $('.select2_demo_client').on('select2:selecting', function(e) {
            var text = e.params.args.data.text.split(' | ');
            $('#nombre_cliente').html(text[0]);
            $('#rucdni_cliente').html(text[1]);
        });
        $('.select2_demo_client').on('select2:select', function(e) {
            $('#guia_remi_input').val('0');
            var s = document.getElementById("guia_list");
            var numChilds = s.children.length;
            for (var i = 0; i < numChilds; i++) {
                s.children[0].remove()
            }
            var data = e.params.data;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion.ajx_remision') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id_cliente': data.id,
                },
                success: function(msg) {
                    var miSpan = document.getElementById('lista_gr');
                    while (miSpan.firstChild) {
                        miSpan.removeChild(miSpan.firstChild);
                    }
                    $('#guia_save_inp').val("0");

                    if (typeof(msg) == "object") {
                        for (let index = 0; index < msg.length; index++) {
                            $('#guia_list').append("<option value='" + msg[index] + "'>");
                        }
                    }
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
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

                    if (val == "0") {
                        $('#guia_save_inp').val("");
                    }
                    var val2 = $('#guia_save_inp').val();
                    $('#guia_save_inp').val(val2 + `${opcion} `);
                }
            });

            input.value = "";
        }

        function remove_item(elemento) {
            var input = $('#guia_save_inp').val();
            var texto = elemento.innerText;
            var new_text = texto + ' ';
            var nuevoValor = input.replace(new_text, '');
            $('#guia_save_inp').val(nuevoValor);
            elemento.remove();
        }
        // TODO Validacion de formulario el no doble incerción
        function valida(f) {
            var boton = document.getElementById("boton");
            var completo = true;
            var incompleto = false;
            if (f.elements[0].value == "") {
                alert(incompleto);
            } else {
                boton.type = 'button';
            }
        }

        var i = 2;
        $(".addmore").on('click', function() {
            var data = `[
        <tr>
            <td>
                <button type="button" class='delete e borrar btn btn-sm btn-danger'> <i class="fa fa-trash" aria-hidden="true"></i> </button>
            </td>";
            <td class="td_selected">
                <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})" autocomplete="off" required></select>
                <textarea type='text' id='descripcion${i}' name='descripcion_item[]' class="form-control" placeholder="Descripción de Item"  autocomplete="off" style="margin-top: 5px;"></textarea>
                <textarea type='text' id='numero_serie0' placeholder="N° de Serie" name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                <input type='text' style="min-width: 76px"  id='tipo_afec${i}' name='tipo_afec[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" hidden   autocomplete="off" />
                <input type="hidden"    class="celda"  name="articulo[]" id="input_prod${i}">
            </td>
            <td>
                <input type='text' style="min-width: 76px"  id='stock${i}' name='stock[]' readonly="readonly" class="form-control" required  autocomplete="off"/>
            </td>
            <td>
                <input type='number' style="min-width: 76px"  id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off" min="1" max=""/>
            </td>
            <td>
                <input type='text' style="min-width: 76px"  id='precio${i}' name='precio[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
            </td>
            <td>
                <div style="position: relative;" >
                    <input class="text_des"type='text' id='descuento${i}' name='descuento[]' readonly="readonly" class="" required onkeyup="multi(${i})"  autocomplete="off"/>
                </div>
                <div  class="div_check">
                    <input class="check"  type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
                </div>
                <input style="min-width: 76px" type='hidden'id='check_descuento${i}' name='check_descuento[]'  class="form-control"  required >
                <input type='hidden' id='promedio_original${i}' name='promedio_original[]'  class="form-control"   >
            </td>
            <td>
                <input type='text' id='precio_unitario_descuento${i}'  style="min-width: 76px"  name='precio_unitario_descuento[]' readonly="readonly" class=" form-control"  required  autocomplete="off" />
            </td>
            <td>
                <input type='hidden' name="comision[]" id='comision${i}'  style="min-width: 76px"  readonly="readonly" class="form-control comision_input"  required  autocomplete="off" onchange="multi(${i})" />
                <input type='text' id='precio_unitario_comision${i}'  style="min-width: 76px"  name='precio_unitario_comision[]' readonly="readonly" class="form-control"  required  autocomplete="off" />
            </td>
            <td>
                <input type='text' id='total${i}'  style="min-width: 76px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
                <input type='text' id='afectacion${i}'  style="min-width: 76px" hidden  name='afectacion' disabled="disabled" class="afectacion form-control "  required  autocomplete="off"/>
            </td>
            <td>
                <input type='text' id='precio_unitario_igv${i}'  style="min-width: 76px"  name='precio_unitario_igv[]' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
            </td>
        </tr>
        `;
            $('.tables').append(data);
            $('#count_articles').val(i);
            i++;
            //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
            articlesSelect2();

            var input_ds = [];
            var number_tot = document.getElementsByName('articulo[]').length;
            for (j = 0; j < number_tot; j++) {
                input_ds[j] = document.getElementsByName('articulo[]')[j].value;
                if (input_ds[j].indexOf("SERV-") == 4) {
                    $('option[value="' + input_ds[j] + '"]').prop("disabled", false);
                } else {
                    $('option[value="' + input_ds[j] + '"]').prop("disabled", true);
                }
            };
            $(".addmore").prop("disabled", true);
            $(".borrar").prop("disabled", false);

        });

        //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
        $(document).ready(function() {
            articlesSelect2();
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
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
                            almacen: almacen
                        };
                    },
                    processResults: function(data) {
                        //validador de articulos multiples
                        let data_length = data.length;
                        let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                        let articles_selected_count_ajax = articles_selected_ajax.length;
                        for (var z = 0; z < articles_selected_count_ajax; z++) {
                            var selected_ajax = document.getElementsByClassName("select2_demo_3 select_change")[
                                z].value;
                            for (var y = 0; y < data_length; y++) {
                                if (selected_ajax == data[y].id + " | " + data[y].codigo + " | " + data[y]
                                    .codigo_original + " | " + data[y].nombre) {
                                    data[y].disabled = true;
                                }
                            }
                        }
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id + " | " + item.codigo + " | " + item.codigo_original +
                                        " | " + item.nombre,
                                    text: item.id + " | " + item.codigo + " | " + item.codigo_original +
                                        " | " + item.nombre,
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
        function ajax(a) {
            if (a == 0) {
                var articulo = document.getElementById(`articulo`).value;
                document.getElementById(`input_prod1`).value = articulo;
            } else {
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
                success: function(msg) {
                    console.log(msg);
                    $(`#tipo_afec${a}`).val(msg.afectacion);
                    $(`#precio${a}`).val(msg.price);
                    $(`#cantidad${a}`).val(1);
                    $(`#precio_unitario_descuento${a}`).val(msg.price);
                    $(`#promedio_original${a}`).val(msg.average);
                    $(`#stock${a}`).val(msg.amount);
                    $(`#descuento${a}`).val(msg.discount);
                    $(`#check_descuento${a}`).val(0);
                    $(`#cantidad${a}`).attr('max', msg.amount);
                    $(`#cantidad`).attr('max', msg.amount);
                    var separador = " ";
                    var comision = document.querySelector(`#comisionista`).value;
                    //revirtiendo la cadena
                    var reverse9 = reverseString(comision); //devuelve toda la cadena articulo al reves
                    //para comision
                    var comision_v_r = reverse9.split(separador, 2); //devuelve el precio en objeto al revez
                    var comision_r = comision_v_r[1]; //obtiene el precio del objeto [0] al revez
                    var comision_v = reverseString(comision_v_r[
                        1]); //convierte el precio al revez a la normalidad
                    if (comision) {
                        document.getElementById(`comision${a}`).value = comision_v;
                    } else {
                        document.getElementById(`comision${a}`).value = 0;
                    }
                    multi(a);
                    $(`.addmore`).prop("disabled", false);
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }

        // funcion para comisionistas
        function comision() {
            //comision
            var comision = document.querySelector(`#comisionista`).value;
            var separador = " ";
            //revirtiendo la cadena
            var reverse9 = reverseString(comision); //devuelve toda la cadena articulo al reves
            //para comision
            var comision_v_r = reverse9.split(separador, 2); //devuelve el precio en objeto al revez

            var comision_r = comision_v_r[1]; //obtiene el precio del objeto [0] al revez

            var comision_v = reverseString(comision_v_r[1]); //convierte el precio al revez a la normalidad
            // console.log("rever"+comision_v);
            var campos_num = document.getElementsByClassName("total").length;
            console.log("total"+campos_num);
            var comisiones_input = document.querySelectorAll('input.comision_input');
            comisiones_input.forEach(element => {
                element.value = parseFloat(comision_v);
                element.onchange();
                console.log(element);
            });
        }

        //Función para el calculo de los totales de cada articulo y para los totales de la factura
        function multi(a) {
            var total = 1;
            var totales = 0;
            var change = false; //
            $(`.monto${a}`).each(function() {
                if (!isNaN(parseFloat($(this).val()))) {
                    change = true;

                    total *= parseFloat($(this).val());
                }
            });
            total = (change) ? total : 0;

            // Get the checkbox
            var checkBox = document.getElementById(`check${a}`);
            var cantidad = document.querySelector(`#cantidad${a}`).value;
            var promedio_origina_descuento1 = document.querySelector(`#precio_unitario_descuento${a}`).value;
            var promedio_original2 = document.querySelector(`#promedio_original${a}`).value;
            var descuento = document.querySelector(`#descuento${a}`).value;
            var afec = document.querySelector(`#tipo_afec${a}`).value;
            var igv_new = {{ $igv->renta }};

            if (checkBox.checked == true && descuento > 0) {

                var precio = document.querySelector(`#precio${a}`).value;
                var promedio_original = document.querySelector(`#promedio_original${a}`).value;
                var comision_porcentaje = document.querySelector(`#comision${a}`).value;
                var multiplier = 100;
                var precio_uni = precio - (promedio_original * descuento / 100);
                var precio_uni_dec = Math.round(precio_uni * multiplier) / multiplier;

                document.getElementById(`check_descuento${a}`).value = descuento;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;

                var comisiones9 = precio_uni_dec + (precio_uni_dec * comision_porcentaje / 100);
                var comisiones = Math.round(comisiones9 * multiplier) / multiplier;
                document.getElementById(`precio_unitario_comision${a}`).value = comisiones;

                var final = comisiones * cantidad;
                var final_decimal = Math.round(final * multiplier) / multiplier;
                console.log(final_decimal);
                if (afec.toString() == "Gravado") {
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;
                    var precio_uni_igv = Math.round((final_decimal + (final_decimal * (igv_new / 100))) * multiplier) /
                        multiplier;
                } else {
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = 0;
                    var precio_uni_igv = final_decimal;
                }
                document.getElementById(`precio_unitario_igv${a}`).value = precio_uni_igv;
            } else {
                var multiplier = 100;
                var descuento = 0;
                var precio = document.querySelector(`#precio${a}`).value;
                var comision_porcentaje = document.querySelector(`#comision${a}`).value;
                var final = cantidad * precio;
                var end9 = parseFloat(precio) + (parseFloat(precio) * parseInt(comision_porcentaje) / 100);

                var end = Math.round(end9 * multiplier) / multiplier;
                var final2 = cantidad * end;
                var final_decimal = Math.round(final2 * multiplier) / multiplier;

                console.log("la promedio_origina_descuento1 es:" + promedio_origina_descuento1);
                console.log("la comision procentaje es:" + comision_porcentaje);
                console.log("la promedio_original2 procentaje es:" + promedio_original2);
                console.log("la end es:" + end);

                document.getElementById(`check_descuento${a}`).value = 0;

                document.getElementById(`precio_unitario_descuento${a}`).value = precio;
                document.getElementById(`precio_unitario_comision${a}`).value = end;
                if (afec.toString() == "Gravado") {
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;
                    var precio_uni_igv = Math.round((final_decimal + (final_decimal * (igv_new / 100))) * multiplier) /
                        multiplier;
                } else {
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = 0;
                    var precio_uni_igv = final_decimal;

                }
                document.getElementById(`precio_unitario_igv${a}`).value = precio_uni_igv;
            }

            // var totalInp = $('[name="afectacion"]');

            //SUMA SUBTOTAL SIN IGV
            var totalInp = $('[name="total"]');

            var total_t = 0;

            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            var total_tt = Math.round(total_t * multiplier2) / multiplier2;

            $('#sub_total').val(total_tt);

            //SOLO GRAVADO
            var totalInpG = $('[name="afectacion"]');
            var total_tg = 0;

            totalInpG.each(function() {
                total_tg += parseFloat($(this).val());
            });

            var multiplier3 = 100;
            var total_ttg = Math.round(total_tg * multiplier3) / multiplier3;

            $('#subtotal_gravado').val(total_ttg);


            var igv_valor = {{ $igv->renta }};

            var subtotal = document.querySelector(`#sub_total`).value;
            // var igv=subtotal*igv_valor/100;

            //GRAVADO
            var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;
            var igv = subtotal_gravado * igv_valor / 100;

            var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            var end = igv_decimal + parseFloat(subtotal);

            var end2 = Math.round(end * multiplier2) / multiplier2;

            document.getElementById("igv").value = igv_decimal;
            document.getElementById("total_final").value = end2;
            // var total = document.getElementById("total_final").value;
            // $(`#monto_pago0`).attr('max', end2);
            // document.getElementById("monto_pago0").value = end2;
            var monto_c = document.getElementsByClassName('monto_pago');

            actualizarSaldoRestante();
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                // var input_text = document.getElementById(`${monto}`).value;
                var fin = (end2 / inp_mont)
                document.getElementById("monto_pago0").value = Math.round(end2 * multiplier2) / multiplier2;
                $("#cuotas_footer").html(Math.round(end2 * multiplier2) / multiplier2);
                actualizarSaldoRestante();
                // document.getElementById(`${monto}`).value = end2;
            }
            multi_detraccion();
            resetModalCuotas()
            $(document).on('input', '.monto_pago', function() {
                actualizarSaldoRestante();
            });
        }
        $(document).on('click', '#button_cuotas_save', function(event) {

            var monto_c = document.getElementsByClassName('monto_pago');
            var monto_fc = document.getElementsByClassName('fecha_pago');
            console.log(monto_c)
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            // se usa el total real, mas no el dinamico
            var total = parseFloat(document.getElementById('total_final').value) || 0;
            var fin = 0;
            var comp = 0;
            for (var i = 0; i < inp_mont; i++) {
                fin = parseFloat(fin) + parseFloat(monto_c[i].value);
            }
            var fin_r = Math.round(fin * 100) / 100;
            var total_r = Math.round(total * 100) / 100;

            for (var i = 0; i < inp_mont; i++) {
                var fecha = monto_fc[i].id;
                var monto = monto_c[i].id;

                var input_text = document.getElementById(`${monto}`).value;
                var date_text = document.getElementById(`${fecha}`).value;
                console.log(date_text);
                if (input_text.length == 0 || date_text.length == 0) {
                    console.log("a");
                    document.getElementById('alert_campos').style.display = "flex";
                    mostrarMensaje();
                    return;
                }
                var end_date = document.getElementById(`${fecha}`).value;
            }

            if (fin_r != total_r) {
                document.getElementById('suma_campos').style.display = "flex";
            } else {
                console.log('e')
                var [year, month, day] = end_date.split("-");
                var formattedDate = `${year}-${month}-${day}`;
                $('#fecha_vencimiento').val(formattedDate)
                $('#cuotas_modal').modal('hide')
            }
            mostrarMensaje();

        });

        function mostrarMensaje() {
            // $("#alert_campos").show(200);
            $("#alert_campos").hide(3000);
            $("#suma_campos").hide(3000);
        }
        //Funcion para revertir un string dado
        function reverseString(str) {
            return str.split("").reverse().join("");
        }

        //Función de borrado de fila de articulos (Producto-Servicio)
        $(document).on('click', '.borrar', function(event) {
            event.preventDefault();
            var e = document.getElementsByClassName("e").length;
            var fila = $(this).parents("tr");
            var input_text_opt = fila.find('input[class="celda"]').val();
            $('option[value="' + input_text_opt + '"]').prop("disabled", false);
            $(".addmore").prop("disabled", false);
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Producto",
            });
            // ELIMINAR TR
            if (e > 1) {
                fila.closest('tr').remove();
                $(".borrar").prop("disabled", false);
                $(".addmore").prop("disabled", false);
            } else {
                $(".borrar").prop("disabled", true);
                $(".addmore").prop("disabled", false);
            }
            var multiplier = 100;
            var totalInp = $('[name="afectacion"]');
            var total_t = 0;

            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });

            $('#subtotal_gravado').val(total_t);
            //GRAVADO
            var totalInpG = $('[name="total"]');
            var total_tt = 0;

            totalInpG.each(function() {
                total_tt += parseFloat($(this).val());
            });
            $('#sub_total').val(total_tt);

            var igv_valor = ({{ $igv->renta }});
            var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv_val = parseFloat(subtotal_gravado) * igv_valor / 100;
            var igv = Math.round(igv_val * multiplier) / multiplier;
            var end_2 = parseFloat(igv) + parseFloat(subtotal);
            var end = Math.round(end_2 * multiplier) / multiplier;

            document.getElementById("igv").value = igv;
            document.getElementById("total_final").value = end;
            articlesSelect2();
        })

        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

        // TODO Script para cambiar por moneda
        let status = 0;

        function resetModalCuotas() {
            x = 1;
            $('.row_number .delete_modal1, .row_number .delete_modal2, .row_number .delete_modal3, .row_number .delete_modal4, .row_number .delete_modal5, .row_number .delete_modal6').remove();

            $('#fecha_pago0').val('');
            $('#monto_pago0').val('');

            $('.add_pago').prop('disabled', false);
            $('#add_pago').prop('disabled', false);

            $('#cuotas_footer').html('0.00').css('color', 'green');
            $('#cuotas_footer').parent().find('strong').html('Total Restante: &nbsp;');

            actualizarSaldoRestante();
        }

        function changeMoney() {
            $.ajax({
                type: "post",
                url: "{{ route('pa.money') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'status': status,
                },
                beforeSend: function() {
                    $('#loaderGif').show();
                },
                complete: function(data) {
                    /*
                     * Se ejecuta al termino de la petición
                     * */
                },
                success: function(msg) {
                    //Cambio de moneda
                    $(`#moneda_id`).val(msg.id);
                    $(`#moneda`).val(msg.nombre);
                    $(`#button_changeMoney`).html(msg.other);
                    $(`#basic-addon3`).html(msg.simbolo);
                    $(`.span_simbolo_credido`).html(msg.simbolo);

                    $(`#simb_fot`).html(msg.simbolo);

                    resetModalCuotas()
                    if (status == 1) {
                        status = 0;
                    } else {
                        status = 1;
                    }
                    $('#loaderGif').hide();
                    let articles_selected = document.getElementsByClassName("select2_demo_3");
                    let articles_selected_count = articles_selected.length;
                    for (let z = 0; z < articles_selected_count; z++) {
                        let selected = document.getElementsByClassName("select2_demo_3 select_change")[z]
                            .getAttribute('id');
                        if (selected == 'articulo') {
                            ajax(0);
                        } else {
                            ajax(selected.substring(8));
                        }
                    }

                    disabled_money();
                },
            });
        }

        jQuery.event.special.touchstart = {
            setup: function(_, ns, handle) {
                this.addEventListener("touchstart", handle, {
                    passive: !ns.includes("noPreventDefault")
                });
            }
        };
        jQuery.event.special.touchmove = {
            setup: function(_, ns, handle) {
                this.addEventListener("touchmove", handle, {
                    passive: !ns.includes("noPreventDefault")
                });
            }
        };
        jQuery.event.special.wheel = {
            setup: function(_, ns, handle) {
                this.addEventListener("wheel", handle, {
                    passive: true
                });
            }
        };
        jQuery.event.special.mousewheel = {
            setup: function(_, ns, handle) {
                this.addEventListener("mousewheel", handle, {
                    passive: true
                });
            }
        };

        function disabled_money() {
            $(`.money_change`).prop('disabled', true);
            $(`.button_money`).addClass('not-active');

            setTimeout(function() {
                $(`.money_change`).prop('disabled', false);
                $(`.button_money`).removeClass('not-active');
            }, 10000);
        }


        function seleccionado_fp() {
            var opt = $('#forma_pago').val();
            if (opt == "1") {
                document.getElementById('credito_pago').style.display = "none";
                document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-5");
                document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-8");

                document.getElementById('fecha_vencimiento').removeAttribute('disabled');

            } else {
                document.getElementById('credito_pago').style.display = "block";

                document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-8");
                document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-5");

                document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
            }
        }

    </script>
    <script>
        var total = document.getElementById('total_final').value;
        var x = 1;
        $(".add_pago").on('click', function() {
            var simb = $('#basic-addon3').html();
            var total = document.getElementById('total_final').value;
            var data = `
                <div class="delete_modal${x} row">
                <div class="col-sm-1"><label>Fecha:</label></div>
                <div class="col-sm-4">
                <input type="date" min="{{ $fecha_1 }}" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" >
                </div>
                <div class="col-sm-1"><label>Monto:</label></div>
                <div class="col-sm-4">
                <div class="input-group mb-3" style="padding-right:15px">
                <div class="input-group-prepend">
                <span class="input-group-text span_simbolo_credido" id="basic-addon4">`+simb+`</span>
                </div>
                <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}" onkeypress="return filterFloat(event,this);"  >
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
            if (inp_mont > 6) {
                $('.add_pago').attr('disabled');
            }
            var multiplier2 = 100;
            var monto_c = document.getElementsByClassName('monto_pago');
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var fin = (total / inp_mont)
                document.getElementById("monto_pago0").value = '';
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
            }
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            if (inp_mont > 5) {
                document.getElementById('add_pago').setAttribute('disabled', "true");
            } else {
                document.getElementById('add_pago').removeAttribute('disabled');
            }
            actualizarSaldoRestante();
        });
        $(document).on('input', '.monto_pago', function() {
            actualizarSaldoRestante();
        });
    </script>
    <style type="text/css">
        .a {
            color: red
        }
    </style>
    <script type="text/javascript">
        // funcion dinamica de actualizar el total a cuotas
        function actualizarSaldoRestante() {
            var total = parseFloat(document.getElementById('total_final').value) || 0;
            var sumaMontos = 0;

            // Sumar todos los montos ingresados
            $('.monto_pago').each(function() {
                var valor = parseFloat($(this).val()) || 0;
                sumaMontos += valor;
            });

            var saldoRestante = total - sumaMontos;
            var multiplier = 100;
            saldoRestante = Math.round(saldoRestante * multiplier) / multiplier;

            if (saldoRestante > 0) {
                $('#cuotas_footer').html(saldoRestante).css('color', 'red');
                $('#cuotas_footer').parent().find('strong').html('Total Restante: &nbsp;');
            } else if (saldoRestante === 0) {
                $('#cuotas_footer').html('0.00').css('color', 'green');
                $('#cuotas_footer').parent().find('strong').html('¡Completo! &nbsp;');
            } else {
                $('#cuotas_footer').html(Math.abs(saldoRestante)).css('color', 'orange');
                $('#cuotas_footer').parent().find('strong').html('Exceso: &nbsp;');
            }
        }

        // $(".delete_pago").on('click', function () {
        function eliminar(x) {
            $(`.delete_modal${x}`).remove();
            var monto_c = document.getElementsByClassName('monto_pago');
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var total = document.getElementById('total_final').value;
            var multiplier2 = 100;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;

                var fin = (total / inp_mont)
                document.getElementById("monto_pago0").value = '';
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
            }
            if (inp_mont > 5) {
                document.getElementById('add_pago').setAttribute('disabled', "true");
            } else if (inp_mont == 1) {
                document.getElementById("monto_pago0").value = total;
            } else {
                document.getElementById('add_pago').removeAttribute('disabled');
            }
            actualizarSaldoRestante();
        };
        $(document).on('input', '.monto_pago', function() {
            actualizarSaldoRestante();
        });
    </script>

    <script>
       $("#boton").on("click", function(buton) {
            var l = Ladda.create(document.querySelector('.button-lada'));
            // $('#modal_detraccion').modal('show');
            // DETRACCIONES?
            var seletc_det = $('.select2_tipo_op').val();
            var split_id = seletc_det.split(' ');
            if (split_id[0] == '1001' || split_id[0] == '1002' || split_id[0] == '1003' || split_id[0] == '1004') {
                var tipo_detra = $('#select_tipo_pago').val();
                var ipt_medio = $('.select2_mediopago').val();
                var porce_detra = $('#porcentaje_detc').val();
                var tot_det = $('#tota_detra').val();

                if (tipo_detra == "" || ipt_medio == "" || porce_detra == "" || tot_det == "") {
                    $('#modal_detraccion').modal('show');
                    var inputs = document.querySelectorAll('.detracc_campo_required');

                    inputs.forEach(function(input) {
                        input.style.display = 'block';
                    });
                    return;
                }

            }
            // return;

            var forma_pago = $("#forma_pago option:selected").val();
            if (forma_pago == 2) {
                var monto_c = document.getElementsByClassName('monto_pago');
                var monto_fc = document.getElementsByClassName('fecha_pago');
                var inp_mont = document.getElementsByClassName('monto_pago').length;
                // correcion, se esta usando el total real, y no el dinamico
                var total = parseFloat(document.getElementById('total_final').value) || 0;
                var fin = 0.00;
                var comp = 0;
                for (var i = 0; i < inp_mont; i++) {
                    fin = parseFloat(fin) + parseFloat(monto_c[i].value);
                }
                var fin_r = Math.round(fin * 100) / 100;
                var total_r = Math.round(total * 100) / 100;  // Redondea el total también para comparación precisa
                // console.log(total);
                for (var i = 0; i < inp_mont; i++) {
                    var fecha = monto_fc[i].id;
                    var monto = monto_c[i].id;

                    var input_text = document.getElementById(`${monto}`).value;
                    var date_text = document.getElementById(`${fecha}`).value;
                    if (input_text.length == 0 || date_text.length == 0) {
                        $('#cuotas_modal').modal('show');
                        document.getElementById('alert_campos').style.display = "flex";
                        setTimeout(mostrarMensaje, 3000);
                        return;
                    }
                }
                if (fin_r != total_r) {  // Compara las versiones redondeadas
                    $('#cuotas_modal').modal('show');
                    document.getElementById('suma_campos').style.display = "flex";
                    setTimeout(mostrarMensaje, 3000);
                } else {
                    var form = document.getElementById('form_store');
                    if (!form.checkValidity()) {
                        form.reportValidity(); // muestra mensajes nativos de HTML5
                        return;
                    }
                    l.start();
                    document.getElementById('button_submit').click();
                }
                // buton.preventDefault();

            } else {
                var form = document.getElementById('form_store');
                if (!form.checkValidity()) {
                    form.reportValidity(); // muestra mensajes nativos de HTML5
                    return;
                }
                document.getElementById('button_submit').click();
                l.start();
            }

        });
        $('#guia_remi_input').on('change', function() {
            var valor = this.value;
            var conversion = valor.replace(/ /g, "|");
            var listaNombres = valor.split(" ");
            console.log(listaNombres);
            for (let i = 0; i < listaNombres.length; i++) {
                var compa = /^([A-Z0-9]{3,4})-\d{1,8}$/;
                var seg = compa.test(listaNombres[i])
                if (seg == true || listaNombres[i] == 0) {
                    $('#guia_remi_input').css('border', '1px solid #e5e6e7');
                    agregarElemento();
                } else {
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
    </script>
    <script>
        function cerrar_but_rc() {
            document.getElementById('alert_campos').style.display = "none";
        }

        function cerrar_but_mt() {
            document.getElementById('suma_campos').style.display = "none";
        }

        function filterFloat(evt, input) {
            var key = window.Event ? evt.which : evt.keyCode;
            var chark = String.fromCharCode(key);
            var tempValue = input.value + chark;

            if (key >= 48 && key <= 57) {
                if (filter(tempValue) === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                if (key == 8 || key == 13 || key == 0) {
                    return true;
                } else if (key == 46) {
                    if (filter(tempValue) === false) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
            }
        }

        function filter(__val__) {
            var preg = /^([0-9]+\.?[0-9]{0,2})$/;
            if (preg.test(__val__) === true) {
                return true;
            } else {
                return false;
            }
        }

        function save_detraccion() {
            var seletc_det = $('.select2_tipo_op').val();
            var split_id = seletc_det.split(' ');
            if (split_id[0] == '1001' || split_id[0] == '1002' || split_id[0] == '1003' || split_id[0] == '1004') {
                var tipo_detra = $('#select_tipo_pago').val();
                var ipt_medio = $('.select2_mediopago').val();
                var porce_detra = $('#porcentaje_detc').val();
                var tot_det = $('#tota_detra').val();

                if (tipo_detra == "" || ipt_medio == "" || porce_detra == "" || tot_det == "") {
                    $('#modal_detraccion').modal('show');
                    var inputs = document.querySelectorAll('.detracc_campo_required');
                    inputs.forEach(function(input) {
                        input.style.display = 'block';
                    });
                    return;
                } else {
                    var inputs = document.querySelectorAll('.detracc_campo_required');
                    inputs.forEach(function(input) {
                        input.style.display = 'none';
                    });
                    $('#modal_detraccion').modal('hide');
                }

            }
        }

        // MODAL BUSQUEDA DE PRODUCTO
        let debounceTimer;
        $('#search_product').on('keyup', function(e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                var busqueda = $(this).val();
                search_multiple(busqueda);
            }, 500); // Espera 300 ms antes de ejecutar la acción
        });

        function search_multiple(busqueda) {
            // CLEAN DATABLE(?)
            if ($.fn.DataTable.isDataTable('.data_table_multiple')) {
                $('.data_table_multiple').DataTable().clear().destroy();
            }
            $('.data_table_multiple tbody').empty();

            var almacen = $('[id="almacen_id"]').val();
            var moneda = $('[id="moneda_id"]').val();
            $.ajax({
                type: "post",
                url: "{{ route('pa.search_multiple') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': busqueda,
                    'almacen': almacen,
                    'moneda': moneda
                },
                success: function(msg) {
                    // console.log(data.mone)
                    var data = JSON.parse(msg);
                    var quantity = $('#quantity_modal').val();
                    if (quantity == "") {
                        quantity = 1;
                    }
                    $('.data_table_multiple').DataTable({
                        "autoWidth": false,
                        pageLength: 10,
                        responsive: true,
                        "aaData": data,
                        "columns": [{
                                "data": "id"
                            },
                            {
                                "data": "codigo"
                            },
                            {
                                "data": "nombre",
                                "defaultContent": ""
                            },
                            {
                                "data": "stock",
                                "defaultContent": ""
                            },
                            {
                                data: null,
                                title: 'CANTIDAD',
                                render: function(data, type, row, meta) {
                                    return `<input type="number" class="form-control form-control-sm input-cantidad" min="1" max="${row.stock}" value="1" data-price="${row.price}" data-id="${row.id}" />`;

                                }
                            },
                            {
                                data: 'price',
                                title: 'PRECIO U.',
                                render: function(data, type, row) {
                                    const simbolo = row.moneda
                                        .simbolo; // Obtén el símbolo de la moneda
                                    const formattedPrice = $.fn.dataTable.render.number(',',
                                        '.', 2).display(data); // Formatea el precio
                                    return `${simbolo} ${formattedPrice}`; // Retorna el precio con el símbolo
                                }
                            },
                            {
                                data: null,
                                title: 'PRECIO TOTAL',
                                render: function(data, type, row, meta) {
                                    return `<span class="total" data-id="${row.id}">${row.moneda.simbolo} ${row.price.toFixed(2)}</span>`;
                                }
                            },
                        ]
                    });
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }
        $('.data_table_multiple').on('input', '.input-cantidad', function() {
            const cantidad = parseFloat($(this).val()) || 0;
            const price = parseFloat($(this).data('price'));
            const total = cantidad * price;
            var simbolo = $('#basic-addon3').html();
            const id = $(this).data('id');
            $(`.total[data-id="${id}"]`).text(`${simbolo}` + `${total.toFixed(2)}`);
        });

        $('.data_table_multiple').on('click', 'tbody > tr', function(e) {
            if ($(e.target).is('input') || $(e.target).closest('td').index() === 4) {
                return;
            }
            var stock = $(this).find("td:eq(3)").text();
            var cantidad = $(this).find('input').val();
            console.log(stock);
            console.log(cantidad);
            if (parseFloat(cantidad) > parseFloat(stock)) {
                console.log("dentro del if");
                toastr.warning("Cantidad mayor al stock",
                    '', {
                        timeOut: 3000
                    });
                return;
            }
            var count_artc = $('#count_articles').val();
            var id = $(this).find("td:eq(0)").text();
            var codigos = $(this).find("td:eq(1)").text();
            var nombres = $(this).find("td:eq(2)").text();

            var concat_data = id + " | " + codigos + " | " + nombres;
            const newOption = new Option(concat_data, concat_data, true, true);
            const selectedValue = $('#articulo').val();
            if (count_artc == "" && selectedValue == null) {
                $('#articulo').append(newOption).trigger('change');
                $('#count_articles').val(1);
                //
                let debounceTimer;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    $(`#cantidad0`).val(cantidad);
                    console.log("se cambio de cantidad");
                    resetModalCuotas()
                }, 1500);
                //
            } else {
                $('.addmore').click();
                var count_artc = $('#count_articles').val();
                $(`#articulo${count_artc}`).append(newOption).trigger('change');

                //
                let debounceTimer;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    $(`#cantidad${count_artc}`).val(cantidad);
                    console.log("se cambio de cantidad")
                    resetModalCuotas()
                }, 1500);
                //
            }
            toastr.info("Se agregó el Articulo correctamente",
                '', {
                    timeOut: 3000
                });
        });
    </script>
    @include('transaccion.venta.clientes.modal_create')

@endsection
