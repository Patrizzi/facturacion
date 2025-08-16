@extends('layout')
@section('title', 'Boleta ')
@section('atributo_actu', 'hidden')
@section('href_accion', route('boleta.index'))

@section('value_accion', 'Atrás')
@section('content')
    {{-- <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');

    .word-style select,
    .word-style input,
    .word-style textarea,
    .word-style .select2-container--default .select2-selection--single {
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
        border-radius: 20px;
        border: 1px solid #ddd;
        height: 38px;
        padding: 6px 14px;
        box-shadow: none;
        transition: border 0.2s ease;
    }

    .word-style .select2-container--default .select2-selection--single {
        line-height: 24px;
    }

    .word-style .select2-selection__arrow {
        height: 36px !important;
        top: 3px !important;
    }

    .word-style .select2-container {
        width: 100% !important;
    }

    .word-style select:focus,
    .word-style input:focus,
    .word-style textarea:focus,
    .word-style .select2-container--default .select2-selection--single:focus {
        border-color: #8ca9ff;
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(140, 169, 255, 0.25);
    }

    .required {
        color: red;
        margin-left: 2px;
    }
</style> --}}

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

    @if ($errors->any())
        <div class="alert alert-danger">
            <a class="alert-link" href="#">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </a>
        </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h4><strong>Generar Boleta</strong></h4>
            </div>
            <div class="ibox-content">
                <form action="{{ route('boleta.store', $moneda->id) }}" enctype="multipart/form-data" method="post"
                    onsubmit="return valida(this)" id="form_store">
                    @csrf
                    @method('put')
                    <div class="row word-style">
                        <div class="col-md-6">
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
                                            <input type="text" class="form-control" name="orden_compra" value="0" />

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>G. Remisión:</strong></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="guia_r" id="guia_save_inp"
                                                value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>F. Emisión:</strong></label>
                                <div class="col-md-10">
                                    <input type="date" id="fecha_emision" name="fecha_emision" class="form-control"
                                        value="{{ date('Y-m-d') }}" readonly>
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>T. Operación </strong></label>
                                <div class="col-md-10">
                                    <select class="form-control select2_operacion" name="tipo_operacion">
                                        @foreach ($tipo_operacion as $index => $t_op)
                                            <option id="{{ $t_op->id }}"
                                                @if ($index == 0) selected @endif>
                                                {{ $t_op->codigo }} - {{ $t_op->informacion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Forma Pago:</strong></label>
                                        <div class="col-md-6 pago_first_column">
                                            <select class="form-control" name="forma_pago" id ="forma_pago"
                                                onchange="seleccionado_fp()">
                                                @foreach ($forma_pagos as $forma_pago)
                                                    <option value="{{ $forma_pago->id }}">
                                                        {{ $forma_pago->nombre }}</option>
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
                                        <label class="col-form-label col-md-2"><strong>Moneda:</strong></label>
                                        <div class="col-md-10">
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
                            <div class="form-group row" id="data_1">
                                <label class="col-form-label col-md-2"><strong>F. Vencimiento</strong></label>
                                <div class="col-md-10 input-group">
                                    <span class="input-group-addon" style="display: none">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="date" class="form-control" id="fecha_vencimiento"
                                        name="fecha_vencimiento" value="{{ date('Y-m-d') }}">
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
                                <table class="table tables">
                                    <thead>
                                        <tr>
                                            <th>
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
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="td_selected">
                                                <button type="button" class='delete borrar e btn btn-sm btn-danger'> <i
                                                        class="fa fa-trash" aria-hidden="true"></i> </button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="monto0 select2_demo_3 select_change" required=""
                                                    id="articulo" onchange="ajax(0)" autocomplete="off">
                                                </select>
                                                <textarea type='text' name='descripcion_item[]' placeholder="Descripcion de Item" class="form-control"
                                                    autocomplete="off" style="margin-top: 5px;"></textarea>
                                                <textarea id='numero_serie0' name='numero_serie[]' class="form-control" placeholder="N° de Serie"
                                                    autocomplete="off" style="margin-top: 5px"></textarea>
                                                <input type='text' id='tipo_afec0' name='tipo_afec[]'
                                                    readonly="readonly" class="monto0 form-control td-width"
                                                    onkeyup="multi(0)" hidden="" required autocomplete="off" />
                                                <input type="hidden" class="celda" name="articulo[]" id="input_prod1">

                                            </td>
                                            <td>
                                                <input type='text' id='stock0' readonly="readonly" name='stock[]'
                                                    class="form-control td-width" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input type='number' id='cantidad0' name='cantidad[]' max=""
                                                    min="1" class="monto0 form-control td-width"
                                                    onkeyup="multi(0)" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input type='number' id='precio0' name='precio[]' readonly="readonly"
                                                    class="monto0 form-control td-width" onkeyup="multi(0)" required
                                                    autocomplete="off" />
                                            </td>
                                            <td>
                                                <div style="position: relative; ">
                                                    <input class="text_des " type='text' id='descuento0'
                                                        name='descuento[]' readonly="readonly" required
                                                        autocomplete="off" />
                                                </div>
                                                <div class="div_check">
                                                    <input class="check td-width" type='checkbox' id='check0'
                                                        name='check[]' onclick="multi(0)" autocomplete="off" />
                                                </div>
                                                <input type='hidden' id='check_descuento0' name='check_descuento[]'
                                                    class="form-control td-width" required>
                                                <input type='hidden' id='promedio_original0' name='promedio_original[]'
                                                    class="form-control td-width" required>
                                            </td>
                                            <td>
                                                <input type='text' id='precio_unitario_descuento0'
                                                    name='precio_unitario_descuento[]' readonly="readonly"
                                                    class="precio_unitario_descuento0 form-control td-width" required
                                                    autocomplete="off" />
                                            </td>
                                            {{--                                        <td> --}}
                                            <input type='hidden' name="1" id='comision0' readonly="readonly"
                                                class="form-control td-width comision_input" required autocomplete="off" onchange="multi(0)" />
                                            {{--                                        </td> --}}
                                            <td>
                                                <input type='text' id='precio_unitario_comision0' readonly="readonly"
                                                    class="form-control td-width" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input type='text' id='total0' name='total' readonly="readonly"
                                                    class="total form-control td-width" required autocomplete="off" />
                                                <input type='text' id='afectacion0' name='afectacion'
                                                    readonly="readonly" class="afectacion form-control td-width"
                                                    hidden="" required autocomplete="off" />

                                            </td>
                                            <td>
                                                <input type='text' id='precio_unitario_igv0'
                                                    name='precio_unitario_igv[]' readonly="readonly"
                                                    class="form-control td-width" required autocomplete="off" />
                                            </td>
                                            <span id="spTotal"></span>
                                        </tr>

                                    </tbody>
                                    <tbody>
                                        <tr style="background-color: #f5f5f500;">
                                            <td colspan="8" class="text-right"><strong>Subtotal:</strong></td>
                                            <td colspan="2">
                                                <input id='sub_total' type="text" name="sub_total_sin_igv" readonly
                                                    class="form-control" required />
                                                <input id='subtotal_gravado' type="text" name="subtotal_gravado"
                                                    readonly class="form-control" required hidden="" />
                                            </td>
                                        </tr>
                                        <tr style="background-color: #f5f5f500;">
                                            <td colspan="8" class="text-right"><strong>IGV:</strong></td>
                                            <td colspan="2">
                                                <input id='igv' type="text" disabled="disabled"
                                                    class="form-control" required />
                                            </td>
                                        </tr>
                                        <tr align="center">
                                            <td colspan="8" class="text-right"><strong>Total:</strong></td>
                                            <td colspan="2">
                                                <input id='total_final' type="text" name="total_comi" readonly
                                                    class="form-control td-width" required />
                                            </td>
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
                                {{-- <button class="btn btn-primary float-right button-lada"  id="boton" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp;
                                <button class="ladda-button btn btn-primary float-right" type="button" id="boton" name="boton" ><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp; --}}
                                <button type="submit" id="button_submit" hidden ></button>

                            </div>
                        </div>
                    </div>
                    {{-- Modal de cuotas , va a aquí porque debe estar dentro del form --}}
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
                </form>
            </div>
        </div>
    </div>


    {{-- <div class="social-bar">
        <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i
                class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
    </div> --}}


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
                                    style="font-size: 100%;border-top: 1px solid #e7eaec;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>CODIGO</th>
                                            <th>ARTICULO</th>
                                            <th>STOCK</th>
                                            <th>CANTIDAD</th>
                                            <th>PRECIO UNITARO</th>
                                            <th>PRECIO TOTAL</th>
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

        /* .form-control{border-radius: 10px} */
        .select2_demo_3 {
            min-width: 500px !important;
        }

        .text_des {
            /* border-radius: 10px; */
            border: 1px solid #e5e6e7;
            width: 80px;
            padding: 7.5px 12px;
        }

        .check {
            -webkit-appearance: none;
            height: 34px;
            background-color: #ffffff00;
            -moz-appearance: none;
            border: none;
            appearance: none;
            width: 80px;
            /* border-radius: 10px; */
        }

        .div_check {
            position: relative;
            top: -34px;
            left: 0px;
            background-color: #ffffff00;
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
            max-width: 700px !important;
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
            width: 30vw !important;
        }

        #operacion_select>span.select2.select2-container.select2-container--default {
            max-width: 100% !important;
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
                /* width: 376px !important; */
                min-width: 376px !important;
            }
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1200px;
            }
        }

        .input_cantidad_modal {
            width: 50%;
        }

        #DataTables_Table_0_wrapper {
            padding-bottom: 0px !important;
        }

        #DataTables_Table_0_wrapper>.row:first-child {
            display: none;
        }

        #DataTables_Table_0_wrapper>.row>.col-sm-12 {
            padding-right: 0px;
            padding-left: 0px;
        }

        #DataTables_Table_0>tbody>tr>td {
            cursor: pointer !important;
        }

        .td-width {
            min-width: 76px !important;
        }

        .table>thead:first-child>tr:first-child>th {
            vertical-align: middle;
            text-align: left;
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
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>

    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>

    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    {{-- @include('layout_agregado_rapido') --}}

    <script type="text/javascript">
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
                    var tipo_coti = 3;
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
                },
                cache: true
            }
        });

        $('.select2_demo_client').on('select2:selecting', function(e) {
            var text = e.params.args.data.text.split(' | ');
            $('#nombre_cliente').html(text[0]);
            $('#rucdni_cliente').html(text[1]);
        });
        $(".select2_demo_comisionista").select2({
            // placeholder: "Sin comisión"
        });

        // Validar Formulario / No doble insercion de datos(Gente desdesperada)

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

        //Creador para la agregacion de articulos (Productos-Servicios) en vista

        var i = 2;
        $(".addmore").on('click', function() {
            var data = `[
                <tr>
                    <td >
                        <button type="button" class='delete borrar e btn btn-sm btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
                    </td>";
                    <td class="td_selected">
                        <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})"  autocomplete="off">
                        </select>
                        <textarea type='text'   name='descripcion_item[]' class="form-control" placeholder="Descripcion de Item"  autocomplete="off" style="margin-top: 5px;"></textarea>
                        <textarea  id='numero_serie${i}' placeholder="N° de Serie"  name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px"></textarea>
                        <input type='text'  id='tipo_afec${i}' name='tipo_afec[]' readonly="readonly" class="monto${i} form-control td-width" onkeyup="multi(${i})" required hidden   autocomplete="off" />
                        <input type="hidden" class="celda td-width"  name="articulo[]" id="input_prod${i}">
                    </td>
                    <td>
                        <input type='text' id='stock${i}' name='stock[]' disabled="disabled" class="form-control td-width" required  autocomplete="off"/>
                    </td>
                    <td>
                        <input type='number' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control td-width" onkeyup="multi(${i})" required  autocomplete="off" max=""  min="1"/>
                    </td>
                    <td>
                        <input type='text' id='precio${i}' name='precio[]' disabled="disabled" class="monto${i} form-control td-width" onkeyup="multi(${i})" required  autocomplete="off"/>
                    </td>
                    <td>
                        <div style="position: relative;" >
                            <input class="text_des td-width" type='text' id='descuento${i}' name='descuento[]' readonly="readonly" required onkeyup="multi(${i})"  autocomplete="off"/>
                        </div>
                        <div  class="div_check">
                            <input class="check td-width"  type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
                        </div>
                        <input type='hidden'id='check_descuento${i}' name='check_descuento[]' class="form-control td-width"  required >
                        <input type='hidden' id='promedio_original${i}' name='promedio_original[]'  class="form-control td-width" required >
                    </td>
                    <td>
                        <input type='text' id='precio_unitario_descuento${i}' name='precio_unitario_descuento[]' disabled="disabled" class="precio_unitario_descuento${i} form-control td-width"  required  autocomplete="off" />
                    </td>
                    <td>
                        <input type='hidden' name'${i}' id='comision${i}' disabled="disabled" class="form-control comision_input td-width"  required  autocomplete="off" onchange="multi(${i})" />
                        <input type='text' id='precio_unitario_comision${i}' disabled="disabled" class="form-control td-width"  required  autocomplete="off" />
                    </td>
                    <td>
                        <input type='text' id='total${i}' name='total' disabled="disabled" class="total form-control td-width"  required  autocomplete="off"/>
                        <input type='text' id='afectacion${i}' hidden  name='afectacion' disabled="disabled" class="afectacion form-control td-width"  required  autocomplete="off"/>
                    </td>
                    <td>
                        <input type='text' id='precio_unitario_igv${i}'
                            name='precio_unitario_igv[]' readonly="readonly" class="form-control td-width"
                            required autocomplete="off" />
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
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
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
            console.log(a)
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
                    console.log(msg)
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
                    var comision_v = reverseString(comision_v_r[1]); //convierte el precio al revez a la normalidad
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
        //Funcion de comision
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
            // console.log(comision_v);
            var campos_num = document.getElementsByClassName("total").length;
            console.log(campos_num);

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
            var precio = document.querySelector(`#precio${a}`).value;
            var igv = 0;
            var igv_new = {{ $igv->renta }};

            if (checkBox.checked == true && descuento > 0) {
                var promedio_original = document.querySelector(`#promedio_original${a}`).value;
                var comision_porcentaje = document.querySelector(`#comision${a}`).value;
                var multiplier = 100;
                var precio_uni = precio - (promedio_original * descuento / 100);
                if (afec.toString() == "Gravado") {

                    var precio_u = (precio_uni * (igv / 100));
                    var prec_uni = parseFloat(precio_uni) + parseFloat(precio_u);
                    var precio_uni_dec = Math.round(prec_uni * multiplier) / multiplier;
                    var comisiones9 = precio_uni + (precio_uni * comision_porcentaje / 100);
                    var comisiones = Math.round((comisiones9 + (comisiones9 * (igv / 100))) * multiplier) / multiplier;
                    var final = comisiones * cantidad;
                    var final_decimal = Math.round(final * multiplier) / multiplier;
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;

                    var precio_uni_igv = Math.round((final_decimal + (final_decimal * (igv_new / 100))) * multiplier) /
                        multiplier;

                } else {
                    var precio_uni_dec = Math.round((precio_uni + (precio_uni) * multiplier)) / multiplier;
                    var comisiones9 = precio_uni + (precio_uni * comision_porcentaje / 100);
                    var comisiones = Math.round((comisiones9) * multiplier) / multiplier;

                    var final = comisiones * cantidad;
                    var final_decimal = Math.round(final * multiplier) / multiplier;
                    // console.log(final_decimal);

                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = 0;
                    var precio_uni_igv = final_decimal;
                }
                document.getElementById(`check_descuento${a}`).value = descuento;
                document.getElementById(`precio_unitario_comision${a}`).value = comisiones;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;
                document.getElementById(`precio_unitario_igv${a}`).value = precio_uni_igv;


            } else {
                var multiplier = 100;
                var descuento = 0;
                var precio = document.querySelector(`#precio${a}`).value;
                var comision_porcentaje = document.querySelector(`#comision${a}`).value;
                if (afec.toString() == "Gravado") {
                    var precio_igv = Math.round((parseFloat(precio) + (precio * (igv / 100))) * multiplier) / multiplier;
                    var final = cantidad * precio;
                    var end9 = parseFloat(precio) + ((parseFloat(precio) * parseInt(comision_porcentaje) / 100));
                    var end = Math.round((end9 + (end9 * (igv / 100))) * multiplier) / multiplier;
                    var final2 = cantidad * end;
                    var final_decimal = Math.round(final2 * multiplier) / multiplier;
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;
                    var precio_uni_igv = Math.round((final_decimal + (final_decimal * (igv_new / 100))) * multiplier) /
                        multiplier;

                } else {
                    var precio_igv = (Math.round(precio * multiplier) / multiplier);
                    var final = cantidad * precio;
                    var end9 = parseFloat(precio) + ((parseFloat(precio) * parseInt(comision_porcentaje) / 100));
                    var end = Math.round((end9) * multiplier) / multiplier;
                    var final2 = cantidad * end;
                    var final_decimal = Math.round(final2 * multiplier) / multiplier;
                    document.getElementById(`total${a}`).value = final_decimal;
                    document.getElementById(`afectacion${a}`).value = final_decimal;
                    var precio_uni_igv = final_decimal;

                }
                document.getElementById(`check_descuento${a}`).value = 0;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio_igv;
                document.getElementById(`precio_unitario_comision${a}`).value = end;
                document.getElementById(`precio_unitario_igv${a}`).value = precio_uni_igv;
            }

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
            var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;
            var igv = subtotal_gravado * igv_valor / 100;
            var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            var end = igv_decimal + parseFloat(subtotal);
            var end2 = Math.round(end * multiplier2) / multiplier2;

            document.getElementById("igv").value = igv_decimal;
            document.getElementById("total_final").value = end2;

            var monto_c = document.getElementsByClassName('monto_pago');

            actualizarSaldoRestante();
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var fin = (total_tt / inp_mont)
                document.getElementById("monto_pago0").value = Math.round(end2 * multiplier2) / multiplier2;
                $("#cuotas_footer").html(Math.round(end2 * multiplier2) / multiplier2);
                actualizarSaldoRestante();
            }
            resetModalCuotas()
        }

        //Funcion para revertir un string dado
        function reverseString(str) {
            return str.split("").reverse().join("");;
        }

        //Función de borrado de fila de articulos (Producto-Servicio)
        $(document).on('click', '.borrar', function(event) {
            event.preventDefault();
            var e = document.getElementsByClassName("e").length;
            var fila = $(this).parents("tr");
            var input_text_opt = fila.find('input[class="celda"]').val();
            $('option[value="' + input_text_opt + '"]').prop("disabled", false);
            $(".addmore").prop("disabled", false);
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
            console.log(end);
            document.getElementById("igv").value = igv;
            document.getElementById("total_final").value = end;

            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var monto_c = document.getElementsByClassName('monto_pago');
            var multiplier2 = 100;

            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var fin = (end / inp_mont)
                document.getElementById("monto_pago0").value = Math.round(end * multiplier2) / multiplier2;;
                // document.getElementById(`${monto}`).value = end;
            }
        });

        // CODIGO PARA SELECCION DE FORMA DE PAGO
        function seleccionado_fp() {
            var opt = $('#forma_pago').val();
            if (opt == "1") {
                document.getElementById('credito_pago').style.display = "none";
                document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-4");
                document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-4");

                document.getElementById('fecha_vencimiento').removeAttribute('disabled');

            } else {
                document.getElementById('credito_pago').style.display = "contents";

                document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-4");
                document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-4");

                document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
            }
        }

        var total = document.getElementById('total_final').value;
        var x = 1;
        $(".add_pago").on('click', function() {
            var simb = $('#basic-addon3').html();
            var total = document.getElementById('total_final').value;
            var data = `
                <div class="delete_modal${x} row">
                    <div class="col-sm-1"><label>Fecha:</label>
                    </div>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" min="{{ $fecha_1 }}">
                    </div>
                    <div class="col-sm-1"><label>Monto:</label></div>
                    <div class="col-sm-4">
                        <div class="input-group mb-3" style="padding-right:15px">
                            <div class="input-group-prepend">
                                <span class="input-group-text span_simbolo_credido" id="basic-addon4">`+simb+`</span>
                            </div>
                            <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}" onkeypress="return filterFloat(event,this);">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label >
                            <button type="button"  class="xd btn btn-danger" onclick="eliminar(${x})"><i class="fa fa-trash-o fa-lg" > </i></button>
                        </label>
                    </div>
                </div>
            `;
            $('.row_number').append(data);

            var inp_mont = document.getElementsByClassName('monto_pago').length;
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

        // FUNCION PARA ELIMINAR LOS TR DE FORMA DE PAGO MODAL
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
        $(document).on('click', '#button_cuotas_save', function(event) {

            var monto_c = document.getElementsByClassName('monto_pago');
            var monto_fc = document.getElementsByClassName('fecha_pago');
            console.log(monto_c);
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            // se usa el total real, mas no el dinamico
            var total = parseFloat(document.getElementById('total_final').value) || 0;
            console.log(total);

            var fin = 0;
            var comp = 0;
            for (var i = 0; i < inp_mont; i++) {
                fin = parseFloat(fin) + parseFloat(monto_c[i].value);
            }
            var fin_r = Math.round(fin * 100) / 100;

            for (var i = 0; i < inp_mont; i++) {
                var fecha = monto_fc[i].id;
                var monto = monto_c[i].id;

                var input_text = document.getElementById(`${monto}`).value;
                var date_text = document.getElementById(`${fecha}`).value;
                if (input_text.length == 0 || date_text.length == 0) {
                    document.getElementById('alert_campos').style.display = "flex";
                    setTimeout(mostrarMensaje, 3000);
                    return;

                }
                var end_date = document.getElementById(`${fecha}`).value;
            }

            if (fin_r != total) {
                document.getElementById('suma_campos').style.display = "flex";
            } else {

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
        // SABER SI LAS CUOTAS DEL MODAL DE FORMA DE PAGO CONCUERDA CON EL MONTO FINAL
        $("#boton").on("click", function(buton) {
            var l = Ladda.create(document.querySelector('.button-ladda'));
            var forma_pago = $("#forma_pago option:selected").val();
            if (forma_pago == 2) {
                var monto_c = document.getElementsByClassName('monto_pago');
                var monto_fc = document.getElementsByClassName('fecha_pago');
                var inp_mont = document.getElementsByClassName('monto_pago').length;
                var total = parseFloat(document.getElementById('total_final').value) || 0;
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
                    if (input_text.length == 0 || date_text.length == 0) {
                        $('#cuotas_modal').modal('show');
                        document.getElementById('alert_campos').style.display = "flex";
                        setTimeout(mostrarMensaje, 3000);
                        return;
                    }
                }
                if (fin_r != total) {
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
                l.start();
                document.getElementById('button_submit').click();
            }

        });

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
        // FUNCIONES PARA LAS ALERTAS DE FORMA DE PAGO
        function cerrar_but_rc() {
            document.getElementById('alert_campos').style.display = "none";
        }

        function cerrar_but_mt() {
            document.getElementById('suma_campos').style.display = "none";
        }

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
                    // $(`#button_changeMoney`).html(msg.other);
                    $(`#basic-addon3`).html(msg.simbolo);
                    $(`#simb_fot`).html(msg.simbolo);

                    resetModalCuotas();

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

        // $(document).on({
        //     ajaxStart: function() {
        //         $("body").addClass("loading");
        //     },
        //     ajaxStop: function() {
        //         $("body").removeClass("loading");
        //     }
        // });

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
                    resetModalCuotas();
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
                    resetModalCuotas();
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

    <script></script>
@endsection
