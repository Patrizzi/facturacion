@extends('layout')
@section('title', 'Cotización ')
@section('href_accion', route('cotizacion.index'))
@section('atributo_actu', 'hidden')
{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
@section('content')

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

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h4><strong>Generar Cotización</strong></h4>
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="" href="{{ route('ventas.cotizacion') }}">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form action="{{ route('cotizacion.store_factura', $moneda->id) }}" enctype="multipart/form-data"
                    method="post" id="coti_store_Fac">
                    @csrf
                    @method('put')
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
                                        <label class="col-form-label col-md-4"><strong>Fecha Emisión</strong></label>
                                        <div class="col-md-8">
                                            <input type="text" name="fecha_emision" class="form-control"
                                                value="{{ date('d-m-Y') }}" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Validez: </strong></label>
                                        <div class="col-md-8">
                                            <select class="form-control select2_validez" name="validez" required="required">
                                                @foreach ($validez as $validezz)
                                                    <option value="{{ $validezz->descripcion }}">
                                                        {{ $validezz->descripcion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>T. Operación:</strong></label>
                                <div class="col-md-10">
                                    <select class="form-control select_2_tipo_op" name="tipo_operacion">
                                        @foreach ($tipo_operacion as $t_op)
                                            <option id="{{ $t_op->id }}">{{ $t_op->codigo }} -
                                                {{ $t_op->informacion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>Comisionista:</strong></label>
                                <div class="col-md-10">
                                    <select name="comisionista" id="comisionista"
                                        class="select2_demo_comisionista form-control" onchange="comision()">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Tipo:</strong></label>
                                        <div class="col-md-8">
                                            <select name="tipo_coti" id="" class="select2_tipo_coti form-control"
                                                onchange="select_tipo()">
                                                <option value="1">Factura</option>
                                                <option value="3">Boleta</option>
                                                <option value="2">Nota de Venta</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Moneda:</strong></label>
                                        <div class="col-md-8">
                                            <select name="moneda" id="" class="form-control"
                                                onchange="changeMoney()">
                                                <option value="nacional"
                                                    {{ $moneda->tipo == 'nacional' ? 'selected' : '' }}>
                                                    Soles
                                                </option>
                                                <option value="extranjera"
                                                    {{ $moneda->tipo == 'extranjera' ? 'selected' : '' }}>
                                                    Dólares</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Garantía:</strong></label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="garantia">
                                                @foreach ($garantia as $garantias)
                                                    <option value="{{ $garantias->descripcion }}">
                                                        {{ $garantias->descripcion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Forma Pago:</strong></label>
                                        <div class="col-md-8">
                                            <select class="form-control select2_forma_pago" name="forma_pago"
                                                required="">
                                                @foreach ($forma_pagos as $forma_pago)
                                                    <option value="{{ $forma_pago->id }}">{{ $forma_pago->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>Observación:</strong></label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="observacion" id="observacion" rows="1">Emitimos la siguiente Cotización a vuestra solicitud</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 renovacion">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="switch-container col-sm-12">
                                        <label class="switch">
                                            <input type="checkbox" id="estado_renovacion" name="estado_renovacion" value="1">
                                            <span class="slider"></span>
                                        </label>
                                        <label for="estado_renovacion" class="switch-label">Activar renovación</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12" id="renovacion_container" style="display: none;">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <select class="form-control" name="select_fecha" id="select_fecha" autocomplete="off">
                                            <option value="">Seleccione frecuencia</option>
                                            <option value="Mensual">Mensual</option>
                                            <option value="Anual">Anual</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-8" id="extra_selects">
                                        <!-- Aquí se generará el calendario -->
                                    </div>
                                </div>
                                 <!-- Inputs ocultos para guardar los valores -->
                                <input type="hidden" name="dia_mensual" id="dia_mensual_hidden">
                                <input type="hidden" name="dia_anual" id="dia_anual_hidden">
                                <input type="hidden" name="mes_anual" id="mes_anual_hidden">
                                <input type="hidden" name="anio_anual" id="anio_anual_hidden">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
                            <input type="hidden" name   ="almacen" id="almacen_id" class="form-control "
                                value="{{ $sucursal->id }}" readonly="readonly">
                            <input type="hidden" id="moneda_id" class="form-control " value="{{ $moneda->id }}">
                        </div>
                        <input type="hidden" name="" id="count_articles" value="">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table cellspacing="0" class="table tables" id="inp_s">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 10px">
                                                <div>
                                                    <button type="button" class='addmore btn btn-sm btn-primary btn-outline'
                                                        style="display: none"><i class="fa fa-plus-square"
                                                            aria-hidden="true"></i></button>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-primary btn-outline" data-toggle="modal"
                                                    data-target="#add_product_data">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </th>
                                            <th style="width: 500px">Artículo</th>
                                            <th style="min-width: 80px">Stock</th>
                                            <th style="min-width: 80px">Cantidad</th>
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
                                            <td>
                                                <button type="button" class='delete borrar e btn btn-sm btn-primary'> <i
                                                        class="fa fa-trash" aria-hidden="true"></i> </button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="monto0 select2_demo_3 select_change" required=""
                                                    id="articulo" onchange="ajax(0)" autocomplete="off"></select>
                                                <textarea type='text' id='descripcion0' name='descripcion_item[]' placeholder="Descripción de Item"
                                                    class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                                                <input style="width: 76px" hidden="" type='text' id='tipo_afec0'
                                                    name='tipo_afec[]' readonly="readonly" class="monto0 form-control"
                                                    onkeyup="multi(0)" required autocomplete="off" />
                                                {{-- <input hidden="hidden" class="celda" name="articulo[]"
                                                    id="input_prod1"> --}}
                                                    <input hidden="hidden" class="celda input-articulo" name="articulo[]">
                                            </td>
                                            <td>
                                                <input style="min-width: 80px;margin: 0px" type='text' id='stock0'
                                                    readonly="readonly" name='stock[]' class="form-control" required
                                                    autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="min-width: 80px" type='number' id='cantidad0'
                                                    name='cantidad[]' max="" min="1"
                                                    class="monto0 form-control" onkeyup="multi(0)" required
                                                    autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="min-width: 85px" type='text' id='precio0'
                                                    name='precio[]' readonly="readonly" class="monto0 form-control"
                                                    onkeyup="multi(0)" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <div style="position: relative;">
                                                    <input class="text_des" type='text' id='descuento0'
                                                        name='descuento[]' readonly="readonly" class="" required
                                                        autocomplete="off" />
                                                </div>
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
                                                <input style="min-width: 85px" type='text'
                                                    id='precio_unitario_descuento0' name='precio_unitario_descuento[]'
                                                    readonly="readonly" class="precio_unitario_descuento0 form-control"
                                                    required autocomplete="off" />
                                            </td>
                                            <input type='hidden' name="comision[]" id='comision0' readonly="readonly"
                                                class="form-control comision_input" required autocomplete="off"
                                                onchange="multi(0)" />
                                            <td>
                                                <input style="min-width: 85px" type='text'
                                                    id='precio_unitario_comision0' name='precio_unitario_comision[]'
                                                    readonly="readonly" class="form-control" required
                                                    autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="min-width: 85px" type='text' id='total0'
                                                    name='total' disabled="disabled" class="total form-control"
                                                    required autocomplete="off" />
                                                <input type='text' id='afectacion0' name='afectacion'
                                                    disabled="disabled" class="afectacion form-control" hidden=""
                                                    required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="min-width: 85px" type='text' id='precio_unitario_igv0'
                                                    name='precio_unitario_igv[]' readonly="readonly" class="form-control"
                                                    required autocomplete="off" />
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
                                            <td></td>
                                            <td></td>
                                            <td>Subtotal :</td>
                                            <td colspan="3">
                                                <input id='sub_total' disabled="disabled" class="form-control"
                                                    required />
                                                <input id='subtotal_gravado' disabled="disabled" hidden=""
                                                    class="form-control" required />
                                            </td>
                                        </tr>
                                        <tr style="background-color: #f5f5f500;" align="center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>IGV :</td>
                                            <td colspan="3"><input id='igv' disabled="disabled"
                                                    class="form-control" required /></td>
                                        </tr>
                                        <tr align="center">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total :</td>
                                            <td colspan="3"><input id='total_final' disabled="disabled"
                                                    class="form-control" required /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button data-style="expand-right" class="guardar ladda-button btn btn-primary btn-outline"
                                type="submit">
                                <span class="ladda-label">Guardar</span>
                            </button>
                            <button class="btn btn-primary  demo3 float-right" style="margin-left: 10px;"
                                type="button">Guardar y Finalizar</button>
                            {{--  <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden=""
                                data-style="zoom-out"></button>  --}}
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Agregado Rápido de Artículos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12" style="margin-bottom: 15px">
                            <input type="text" name="" id="search_product" class="form-control"
                                placeholder="Buscar por código o nombre del producto o Servicio" autocomplete="off">
                            <small style="padding-right: 12px;padding-left: 12px ">Filtrado por Producto o Servicio</small>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover data_table_multiple"
                                    style="font-size: 90%;border-top: 1px solid #e7eaec;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>CÓDIGO</th>
                                            <th>ARTÍCULO</th>
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
        .form-label .required {
            color: red;
            margin-left: 4px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-inline-label {
            display: flex;
            align-items: center;
        }
    </style>

    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap'); */

        .word-style select,
        .word-style input,
        .word-style span {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
        }

        .required {
            color: red;
            margin-left: 2px;
        }
    </style>


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

        /* .col-form-label {
                    margin-top: 15px !important;
                }

                .col-sm-5 {
                    margin-top: 15px !important;
                }

                .form-control {
                    border-radius: 10px
                } */

        .text_des {
            border-radius: 10px;
            border: 1px solid #e5e6e7;
            width: 80px;
            padding: 6px 12px;
        }

        .ladda-button[data-loading] {
    width: 42px !important;
    height: 42px !important;
    padding: 0 !important;
    transition: all 0.2s ease-in-out;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    position: relative; /* Necesario para posicionar el spinner */
    overflow: hidden;
}

/* 2. Ocultar el texto */
.ladda-button[data-loading] .ladda-label {
    display: none !important;
}

/* 3. Forzar al spinner de Ladda a ser visible y centrarse */
.ladda-button[data-loading] .ladda-progress {
    display: none !important; /* Oculta la barra de progreso si existe */
}

.ladda-button[data-loading] .ladda-spinner {
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    margin: 0 !important;
    /* Esto lo centra matemáticamente */
    transform: translate(-50%, -50%) !important;
    opacity: 1 !important;
    visibility: visible !important;
    display: block !important;
    width: 100% !important;
    height: 100% !important;
}

/* 4. Ajuste para el círculo del spinner interno */
.ladda-button[data-loading] .ladda-spinner > div {
    left: 50% !important;
    top: 50% !important;
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

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .form-check {
            margin: 20px 12px;
        }

        .select2-hidden-accessible {
            width: 0px;
            margin: 0px;
            width: auto;
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1200px;
            }
        }

        .dataTables_wrapper {
            padding-bottom: 0px;
        }
    </style>

    //Estilos para el check de activar renovacion
    <style>
    .renovacion {
        padding: 0;
        margin-bottom: 15px;
        margin-top: 7px;
    }

    /* Switch estilo original */
    .switch-container {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
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
    }

    #renovacion_container {
        animation: slideDown 0.3s ease-out;
        margin-top: 10px;
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

    /* CALENDARIO */
    .calendar-container {
        border: 1px solid #e5e6e7;
        background: #fff;
        border-radius: 3px;
        padding: 15px;
        max-width: 300px;
        margin-top: 0;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e6e7;
    }

    .calendar-header h6 {
        font-size: 13px;
        font-weight: 600;
        color: #676a6c;
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
        background: #f3f3f4;
        border-radius: 2px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 3px;
        font-size: 11px;
        border: 1px solid transparent;
        transition: all 0.2s;
        color: #676a6c;
        min-height: 28px;
        max-height: 30px;
        cursor: default;
    }

    .calendar-day.selectable {
        cursor: pointer;
        background: #fff;
    }

    .calendar-day.selectable:hover {
        background: #e8f4f8;
        border-color: #1ab394;
        transform: scale(1.05);
    }

    .calendar-day.disabled {
        color: #d1dade;
        background: #fafafa;
        cursor: not-allowed;
    }

    .calendar-day.selected {
        background: #1ab394 !important;
        color: white !important;
        font-weight: 600;
        border-color: #1ab394;
    }

    .calendar-day.fecha-emision {
        background: #1c84c6 !important;
        color: white !important;
        font-weight: 600;
        border-color: #1c84c6 !important;
    }

    .calendar-day.fecha-emision:hover {
        background: #1a7bb9 !important;
        border-color: #1a7bb9 !important;
        transform: scale(1.05);
    }

    .calendar-day.fecha-emision.selected {
        background: #1ab394 !important;
        color: white !important;
        box-shadow: 0 0 0 2px #1c84c6;
        border-color: #1ab394 !important;
    }

    .calendar-day.empty {
        background: transparent;
        border: none;
        pointer-events: none;
    }

    .renovacion .row {
        margin-bottom: 6px;
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
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Sweet alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        function ajax_confi(parameters) {
            var configuracion_seleccionado = parameters.id;
            $.ajax({
                type: "post",
                url: "{{ route('envio_confi_ingresos') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tipo_configuracion': configuracion_seleccionado
                },
                success: function(msg) {
                    // alert(msg);
                }
            });
        }

        function ConfiguracionSelector(parameters) {
            // console.log(parameters.id);
            var configuracion_seleccionado = parameters.id;

            var data1 = document.getElementById(configuracion_seleccionado + "_1");
            var data2 = document.getElementById(configuracion_seleccionado + "_2");

            if (data1.hasAttribute("hidden")) {
                data1.removeAttribute("hidden", "");
                data2.removeAttribute("hidden", "");
                ajax_confi(parameters);
            } else {
                data1.setAttribute("hidden", "");
                data2.setAttribute("hidden", "");
                ajax_confi(parameters);
            }
        }
        $('.demo3').click(function() {
            if (document.forms['coti_store_Fac'].reportValidity()) {
                swal({
                        title: "¿Estas seguro que deseas Finalizar?",
                        text: "Una vez Finalizado, No se podrá editar la Cotizacion",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#1a3bb3",
                        confirmButtonText: "Si, Finalizar",
                        cancelButtonText: "Cancelar!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            document.getElementById("finalizar").click();
                            swal("Cotizacion Finalizada", "", "success");
                        } else {
                            swal("Cancelado", "Cancelado la Finalizar", "error");
                        }
                    });
            } else {

            }
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function mostrarMensaje(mensaje) {
            $("#divmsg").empty(); //limpiar div
            $("#divmsg").append(mensaje);
            $("#divmsg").show(200);
        }
        $(".guardar").on('submit', function() {
            $(".demo3").attr('disabled', true);
            var data =
                `<input value="1" type='hidden' name='submit' class="form-control" required/>  <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);

        });
        $(".finalizar").on('click', function() {
            var data =
                `<input value="2" type='hidden' name='submit' class="form-control" required/>   <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);
            // $(".guardar").remove();
        });
    </script>

    {{-- Scripts realizados por el desarrollador --}}
    <script type="text/javascript">
        // TODO Selección de cliente por medio de ajax para mostrar los datos del cliente en el formularios
        // $('').val();

        $(".select2_demo_comisionista").select2();
        $(".select2_validez").select2();
        $(".select2_tipo_coti").select2();
        $(".select_2_tipo_op").select2();


        $(".select2_demo_client").select2({
            placeholder: "Seleccionar Cliente",
            theme: "bootstrap",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    var tipo_coti = $('[name="tipo_coti"]').val();
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

        //Creador para la agregacion de articulos (Productos-Servicios) en vista
        var i = 2;
        $(".addmore").on('click', function() {
            var data = `[
            <tr>
                <td>
                    <button type="button" class='delete borrar e btn btn-sm btn-primary'><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>";
                <td class="td_selected">
                    <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})"  autocomplete="off" required></select>
                    <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                    <input type='text' style="min-width: 85px" id='tipo_afec${i}' name='tipo_afec[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required hidden  autocomplete="off" />
                    <input hidden="hidden"  class="celda"  name="articulo[]" id="input_prod${i}">
                </td>
                <td>
                    <input type="" style="min-width: 85px"  id='stock${i}' name='stock[]' readonly="readonly" class="form-control" required autocomplete="off"/>
                </td>
                <td>
                    <input type='number' style="min-width: 80px" max="" min="1" id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
                </td>
                <td>
                    <input type='text' style="min-width: 85px"  id='precio${i}' name='precio[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
                </td>
                <td>
                    <div style="position: relative;" >
                        <input class="text_des"type='text' id='descuento${i}' name='descuento[]' readonly="readonly" class="" required onkeyup="multi(${i})"  autocomplete="off"/>
                    </div>
                    <div  class="div_check">
                        <input class="check"  type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
                    </div>
                    <input style="min-width: 85px" type='hidden'id='check_descuento${i}' name='check_descuento[]'  class="form-control"  required >
                    <input type='hidden' id='promedio_original${i}' name='promedio_original[]'  class="form-control"  required >
                </td>
                <td>
                    <input type='text' id='precio_unitario_descuento${i}' style="min-width: 85px"  name='precio_unitario_descuento[]' readonly="readonly" class=" form-control"  required  autocomplete="off" />
                </td>
                <input type='hidden' name="comision[]" id='comision${i}' style="min-width: 85px"  readonly="readonly" class="form-control comision_input" required autocomplete="off" onchange="multi(${i})" />
                <td>
                    <input type='text' id='precio_unitario_comision${i}' style="min-width: 85px"  name='precio_unitario_comision[]' readonly="readonly" class="form-control" required autocomplete="off" />
                </td>
                <td>
                    <input type='text' id='total${i}' style="min-width: 85px"  name='total' disabled="disabled" class="total form-control" required autocomplete="off"/>
                    <input type='text' id='afectacion${i}' style="min-width: 85px" hidden  name='afectacion' disabled="disabled" class="afectacion form-control" required autocomplete="off"/>
                </td>
                <td>
                    <input style="min-width: 85px" type='text' id='precio_unitario_igv${i}' name='precio_unitario_igv[]' readonly="readonly" class="form-control" required autocomplete="off" />
                <td>
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
                            almacen: almacen,
                            tipo_doc: "normal"
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
                                    if (data[y].tipo == 'producto') {
                                        data[y].disabled = true;
                                    } else {
                                        data[y].disabled = false;
                                    }
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
        // TODO funcion ajax para obtener los parametros requeridos de articulo (PRODUCTOS - SERVICIOS)
        function ajax(a) {
            // Determinar el ID del select
            const selectId = a === 0 ? 'articulo' : `articulo${a}`;
            const selectElement = document.getElementById(selectId);

            if (!selectElement) {
                // console.error(`❌ Select no encontrado: ${selectId}`);
                return;
            }

            const articulo = selectElement.value;

            if (!articulo) {
                // console.log('No hay artículo seleccionado');
                return;
            }

            // ✅ NAVEGACIÓN POR DOM: Encontrar el input oculto en la misma fila
            const fila = selectElement.closest('tr');
            const inputArticulo = fila.querySelector('input.celda');

            if (inputArticulo) {
                inputArticulo.value = articulo;
                // console.log(`✅ Input oculto actualizado en fila ${a}:`, articulo);
            } else {
                // console.error(`❌ No se encontró input.celda en fila ${a}`);
            }

            var almacen = $('#almacen_id').val();
            var moneda = $('#moneda_id').val();

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
                    $(`#descripcion${a}`).val(msg.description);
                    $(`#tipo_afec${a}`).val(msg.afectacion);
                    $(`#precio${a}`).val(msg.price);
                    $(`#cantidad${a}`).val(1);
                    $(`#precio_unitario_descuento${a}`).val(msg.price);
                    $(`#promedio_original${a}`).val(msg.average);
                    $(`#stock${a}`).val(msg.amount);
                    $(`#descuento${a}`).val(msg.discount);
                    $(`#check_descuento${a}`).val(0);
                    $(`#cantidad${a}`).attr('max', msg.amount);

                    if (a === 0) {
                        $('#cantidad').attr('max', msg.amount);
                    }

                    var separador = " ";
                    var comision = document.querySelector('#comisionista').value;

                    if (comision) {
                        var reverse9 = reverseString(comision);
                        var comision_v_r = reverse9.split(separador, 2);
                        var comision_v = reverseString(comision_v_r[1]);
                        document.getElementById(`comision${a}`).value = comision_v;
                    } else {
                        document.getElementById(`comision${a}`).value = 0;
                    }

                    multi(a);
                    $('.addmore').prop("disabled", false);
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        // console.log(eject.responseJSON.error);
                        console.log('Error')
                    }
                },
                cache: true
            });
        }
        //Funcion de comision
        function comision() {
            var comision = document.querySelector(`#comisionista`).value;
            var separador = " ";
            //revirtiendo la cadena
            var reverse9 = reverseString(comision); //devuelve toda la cadena articulo al reves
            //para comision
            var comision_v_r = reverse9.split(separador, 2); //devuelve el precio en objeto al revez
            var comision_r = comision_v_r[1]; //obtiene el precio del objeto [0] al revez
            var comision_v = reverseString(comision_v_r[1]); //convierte el precio al revez a la normalidad
            var campos_num = document.getElementsByClassName("total").length;
            console.log("total" + campos_num);
            var comisiones_input = document.querySelectorAll('input.comision_input');
            comisiones_input.forEach(element => {
                element.value = parseFloat(comision_v);
                element.onchange();
                // console.log(element);
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
            var cantidad_desc = document.getElementById(`check_descuento0${a}`)
            var descuento = document.querySelector(`#descuento${a}`).value;
            var afec = document.querySelector(`#tipo_afec${a}`).value;
            var precio = document.querySelector(`#precio${a}`).value;
            var comision_porcentaje = document.querySelector(`#comision${a}`).value;
            var multiplier = 100;
            var igv_valor = {{ $igv->renta }};
            // Con DESCUENTO
            if (checkBox.checked == true && descuento > 0) {
                // SACADA DE DESCUENTO PRIMERO
                var precio_uni = precio - (promedio_original2 * (descuento / 100));
                var precio_uni_dec = Math.round(precio_uni * multiplier) / multiplier;
                document.getElementById(`check_descuento${a}`).value = descuento;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;
                //SACADA DE COMISION
                var comisiones_base_uni = parseFloat(precio_uni_dec) + parseFloat(precio_uni_dec) * (comision_porcentaje /
                    100);
                var comisiones_red = Math.round(parseFloat(comisiones_base_uni) * multiplier) / multiplier;
                document.getElementById(`precio_unitario_comision${a}`).value = comisiones_red;
                var total_sin_igv = parseFloat(comisiones_red) * cantidad;
                document.getElementById(`total${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                // IGV POR GRAVADO O EXONERADO
                if (afec.toString() == "Gravado") {
                    //SACA IGV
                    var igv = (parseFloat(comisiones_red) * (igv_valor / 100));
                    var igv_decimal = Math.round(igv * multiplier) / multiplier;
                    var final_igv_round = parseFloat(comisiones_red) + parseFloat(igv_decimal);
                    var tot_tot = final_igv_round * cantidad;
                    // TOTAL PRECIO UNITARIO
                    document.getElementById(`afectacion${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                    // TOTAL PRECIO ALL
                    document.getElementById(`precio_unitario_igv${a}`).value = Math.round(tot_tot * multiplier) /
                        multiplier;
                } else {
                    // TOTAL PRECIO UNITARIO
                    document.getElementById(`afectacion${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                    // TOTAL PRECIO ALL
                    document.getElementById(`precio_unitario_igv${a}`).value = total_sin_igv;
                }
            } else {
                document.getElementById(`check_descuento${a}`).value = 0;
                document.getElementById(`precio_unitario_descuento${a}`).value = precio;
                //SACADA DE COMISION
                var comisiones_base_uni = parseFloat(precio) + parseFloat(precio) * (comision_porcentaje / 100);
                var comisiones_red = Math.round(parseFloat(comisiones_base_uni) * multiplier) / multiplier;
                document.getElementById(`precio_unitario_comision${a}`).value = comisiones_red;
                var total_sin_igv = parseFloat(comisiones_red) * cantidad;
                document.getElementById(`total${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                // IGV POR GRAVADO O EXONERADO
                if (afec.toString() == "Gravado") {
                    //SACA IGV

                    var igv = total_sin_igv * (igv_valor / 100);
                    var igv_decimal = Math.round(igv * multiplier) / multiplier;
                    var end = parseFloat(total_sin_igv) + igv_decimal;
                    var final_igv_round = Math.round(end * multiplier) / multiplier;

                    // TOTAL PRECIO UNITARIO
                    document.getElementById(`afectacion${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                    // TOTAL PRECIO ALL
                    document.getElementById(`precio_unitario_igv${a}`).value = Math.round(final_igv_round * multiplier) /
                        multiplier;
                } else {
                    // TOTAL PRECIO UNITARIO
                    document.getElementById(`afectacion${a}`).value = Math.round(total_sin_igv * multiplier) / multiplier;
                    // TOTAL PRECIO ALL
                    document.getElementById(`precio_unitario_igv${a}`).value = Math.round(total_sin_igv * multiplier) /
                        multiplier;
                }
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

            var subtotal = document.querySelector(`#sub_total`).value;
            var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;

            var igv_valor = {{ $igv->renta }};

            var igv = subtotal_gravado * igv_valor / 100;
            var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            var end = parseFloat(subtotal) + igv_decimal;
            var end2 = Math.round(end * multiplier2) / multiplier2;

            document.getElementById("igv").value = igv_decimal;
            document.getElementById("total_final").value = end2;
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
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Item",
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
        });

        function select_tipo() {
            $(".select2_demo_client").select2("val", "");
        }

        // TODO Script para cambiar por moneda
        let status = 0;

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
                    // console.log('a');
                    // document.getElementById("moneda_id").value = msg.id;
                    // document.getElementById("moneda").value = msg.nombre;
                    $('[id="moneda_id"]').val(msg.id);
                    $('[id="moneda_nam"]').val(msg.nombre);
                    $(`#button_changeMoney`).html(msg.other);
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

        $(document).on({
            ajaxStart: function() {
                $("body").addClass("loading");
            },
            ajaxStop: function() {
                $("body").removeClass("loading");
            }
        });

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
                    if (validarJson(msg)) {
                        var data = JSON.parse(msg);
                        if (data.length === 0) {
                            toastr.warning("No se encontraron resultados",
                                '', {
                                    timeOut: 3000
                                });
                            return;
                        }
                    } else if (msg == "[]") {
                        toastr.warning("No se encontraron resultados",
                            '', {
                                timeOut: 3000
                            });
                        return;
                    } else {
                        toastr.warning("No se encontraron resultados",
                            '', {
                                timeOut: 3000
                            });
                        return;
                    }
                    var quantity = $('#quantity_modal').val();
                    if (quantity == "") {
                        quantity = 1;
                    }
                    $('.data_table_multiple').DataTable({
                        "bLengthChange": false,
                        "searching": false,
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
                        console.log('Error');
                        // console.log(eject.responseJSON.error);
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
            // console.log(stock);
            // console.log(cantidad);
            if (parseFloat(cantidad) > parseFloat(stock)) {
                // console.log("dentro del if");
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
                    // console.log("se cambio de cantidad");
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
                    // console.log("se cambio de cantidad")
                }, 1500);
                //
            }
            toastr.info("Se agregó el Articulo correctamente",
                '', {
                    timeOut: 3000
                });
        });

        function validarJson(data) {
            try {
                JSON.parse(data);
                return true; // es JSON válido
            } catch (e) {
                return false; // no es JSON
            }
        }

        function validarJson(data) {
            try {
                JSON.parse(data);
                return true; // es JSON válido
            } catch (e) {
                return false; // no es JSON
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            var cotiDuplicada = @json($cotiDuplicada ?? null);

            if (cotiDuplicada) {
                // Guardar comisión GLOBALMENTE desde el inicio
                if (cotiDuplicada.comisionista) {
                    window.comisionDuplicada = parseFloat(cotiDuplicada.comisionista.comision);
                }

                setTimeout(function() {
                    cargarDatosCotizacion(cotiDuplicada);
                }, 800);
            }
        });

        function cargarDatosCotizacion(data) {
            // 1. TIPO
            let tipoCoti = '1';
            if (data.tipo === 'boleta') tipoCoti = '3';
            if (data.tipo === 'nota_venta') tipoCoti = '2';
            $('.select2_tipo_coti').val(tipoCoti).trigger('change');

            // 2. CLIENTE
            if (data.cliente) {
                setTimeout(function() {
                    if ($('#cliente').hasClass("select2-hidden-accessible")) {
                        $('#cliente').select2('destroy');
                    }

                    $('#cliente').empty();
                    const clienteOption = new Option(
                        data.cliente.nombre + ' | ' + data.cliente.numero_documento,
                        data.cliente.id,
                        true,
                        true
                    );
                    $('#cliente').append(clienteOption);

                    $('#cliente').select2({
                        theme: "bootstrap",
                        placeholder: "Seleccionar Cliente",
                        ajax: {
                            minimumInputLength: 1,
                            url: "{{ route('pa.clients') }}",
                            dataType: 'json',
                            type: "POST",
                            delay: 10,
                            data: function(params) {
                                var tipo_coti = $('.select2_tipo_coti').val();
                                return {
                                    _token: "{{ csrf_token() }}",
                                    search: params.term,
                                    tipo_coti: tipo_coti
                                };
                            },
                            processResults: function(response) {
                                return {
                                    results: $.map(response, function(item) {
                                        return {
                                            id: item.id,
                                            text: item.nombre + ' | ' + item.numero_documento
                                        };
                                    })
                                };
                            },
                            cache: true
                        }
                    });

                    $('#cliente').val(data.cliente.id).trigger('change');
                }, 600);
            }

            // 3. COMISIONISTA - CREAR OPCIÓN DESDE JSON
            if (data.comisionista) {
                setTimeout(function() {
                    // Destruir select2 primero
                    if ($('#comisionista').hasClass("select2-hidden-accessible")) {
                        $('#comisionista').select2('destroy');
                    }

                    // Construir el texto exacto como aparece en el HTML
                    const textoComisionista = data.comisionista.cod_vendedor + ' - ' +
                                            data.comisionista.personal.personal_l.nombres + ' - ' +
                                            data.comisionista.comision + ' %';

                    // Buscar si la opción ya existe
                    let opcionEncontrada = false;

                    $('#comisionista option').each(function() {
                        const opcionId = $(this).attr('id');
                        if (opcionId && opcionId == data.comisionista.id) {
                            $('#comisionista').val($(this).val());
                            opcionEncontrada = true;
                            console.log('✓ Comisionista encontrado:', $(this).val());
                            return false;
                        }
                    });

                    // Si NO existe, crear la opción dinámicamente desde el JSON
                    if (!opcionEncontrada) {
                        console.log('⚠ Comisionista no encontrado. Creando desde JSON...');

                        // Crear nueva opción con los datos del JSON
                        const nuevaOpcion = new Option(
                            textoComisionista,  // text
                            textoComisionista,  // value
                            false,              // defaultSelected
                            false               // selected
                        );

                        // Agregar el atributo id
                        $(nuevaOpcion).attr('id', data.comisionista.id);

                        // Insertar después de "Sin Comisión"
                        $('#comisionista').append(nuevaOpcion);

                        console.log('✓ Opción creada:', textoComisionista);
                    }

                    // Seleccionar el comisionista (ahora que existe)
                    $('#comisionista').val(textoComisionista);

                    // Reinicializar select2
                    $('.select2_demo_comisionista').select2();

                    // Forzar trigger de change
                    $('#comisionista').trigger('change');

                    // Ejecutar función comision()
                    setTimeout(function() {
                        comision();
                    }, 300);

                }, 700);
            } else {
                // Si no hay comisionista, seleccionar "Sin Comisión"
                setTimeout(function() {
                    if ($('#comisionista').hasClass("select2-hidden-accessible")) {
                        $('#comisionista').select2('destroy');
                    }
                    $('#comisionista').val('Sin Comisión - 0 %');
                    $('.select2_demo_comisionista').select2();
                    $('#comisionista').trigger('change');
                    window.comisionDuplicada = 0;
                }, 700);
            }
            // 4. VALIDEZ
            $('select[name="validez"]').val(data.validez).trigger('change');

            // 5. TIPO OPERACIÓN
            if (data.tipo_operacion) {
                const tipoOpTexto = data.tipo_operacion.codigo + ' - ' + data.tipo_operacion.informacion;
                $('.select_2_tipo_op').val(tipoOpTexto).trigger('change');
            }

            // 6. GARANTÍA
            $('select[name="garantia"]').val(data.garantia).trigger('change');

            // 7. FORMA DE PAGO
            $('select[name="forma_pago"]').val(data.forma_pago_id).trigger('change');

            // 8. OBSERVACIÓN
            $('#observacion').val(data.observacion);

            // 9. MONEDA
            if (data.moneda) {
                setTimeout(function() {
                    const monedaActual = $('[name="moneda"]').val();
                    const monedaDuplicada = data.moneda.tipo;

                    if (monedaActual !== monedaDuplicada) {
                        $('[name="moneda"]').val(monedaDuplicada).trigger('change');
                        setTimeout(function() {
                            cargarArticulos(data);
                        }, 1500);
                    } else {
                        setTimeout(function() {
                            cargarArticulos(data);
                        }, 1000);
                    }
                }, 600);
            } else {
                setTimeout(function() {
                    cargarArticulos(data);
                }, 1000);
            }
        }

        function cargarArticulos(data) {
            let registros = data.coti_factura_registro || [];
            if (registros.length === 0) return;
            cargarArticulosSecuencial(registros, 0);
        }

        function cargarArticulosSecuencial(registros, index) {
            if (index >= registros.length) return;

            const registro = registros[index];

            if (index === 0) {
                cargarArticuloEnFila(registro, 0, function() {
                    setTimeout(function() {
                        cargarArticulosSecuencial(registros, index + 1);
                    }, 400);
                });
            } else {
                crearNuevaFila(index, function() {
                    cargarArticuloEnFila(registro, index, function() {
                        setTimeout(function() {
                            cargarArticulosSecuencial(registros, index + 1);
                        }, 400);
                    });
                });
            }
        }

        function crearNuevaFila(index, callback) {
            var data = `
                <tr>
                    <td>
                        <button type="button" class='delete borrar e btn btn-sm btn-primary'><i class="fa fa-trash"></i></button>
                    </td>
                    <td class="td_selected">
                        <select class="monto0 select2_demo_3 select_change" id='articulo${index}' onchange="ajax(${index})" required></select>
                        <textarea id='descripcion${index}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" style="margin-top: 5px;"></textarea>
                        <input type='text' style="min-width: 85px" id='tipo_afec${index}' name='tipo_afec[]' readonly class="monto${index} form-control" onkeyup="multi(${index})" required hidden/>
                        <input hidden class="celda input-articulo" name="articulo[]">
                    </td>
                    <td><input type="" style="min-width: 85px" id='stock${index}' name='stock[]' readonly class="form-control" required/></td>
                    <td><input type='number' style="min-width: 80px" min="1" id='cantidad${index}' name='cantidad[]' class="monto${index} form-control" onkeyup="multi(${index})" required/></td>
                    <td><input type='text' style="min-width: 85px" id='precio${index}' name='precio[]' readonly class="monto${index} form-control" onkeyup="multi(${index})" required/></td>
                    <td>
                        <div style="position: relative;">
                            <input class="text_des" type='text' id='descuento${index}' name='descuento[]' readonly required onkeyup="multi(${index})"/>
                        </div>
                        <div class="div_check">
                            <input class="check" type='checkbox' id='check${index}' name='check[]' onclick="multi(${index})"/>
                        </div>
                        <input style="min-width: 85px" type='hidden' id='check_descuento${index}' name='check_descuento[]' class="form-control" required>
                        <input type='hidden' id='promedio_original${index}' name='promedio_original[]' class="form-control" required>
                    </td>
                    <td><input type='text' id='precio_unitario_descuento${index}' style="min-width: 85px" name='precio_unitario_descuento[]' readonly class="form-control" required/></td>
                    <input type='hidden' name="comision[]" id='comision${index}' style="min-width: 85px" readonly class="form-control comision_input" required onchange="multi(${index})"/>
                    <td><input type='text' id='precio_unitario_comision${index}' style="min-width: 85px" name='precio_unitario_comision[]' readonly class="form-control" required/></td>
                    <td>
                        <input type='text' id='total${index}' style="min-width: 85px" name='total' disabled class="total form-control" required/>
                        <input type='text' id='afectacion${index}' style="min-width: 85px" hidden name='afectacion' disabled class="afectacion form-control" required/>
                    </td>
                    <td><input style="min-width: 85px" type='text' id='precio_unitario_igv${index}' name='precio_unitario_igv[]' readonly class="form-control" required/></td>
                </tr>
            `;

            $('.tables tbody:first').append(data);
            $('#count_articles').val(index);

            setTimeout(function() {
                articlesSelect2();
                if (callback) callback();
            }, 250);
        }

        function cargarArticuloEnFila(registro, index, callback) {
            let articuloId, codigo, codigoOriginal, nombre;

            if (registro.producto_id && registro.producto) {
                articuloId = registro.producto.id;
                codigo = registro.producto.codigo_producto;
                codigoOriginal = registro.producto.codigo_original;
                nombre = registro.producto.nombre;
            } else if (registro.servicio_id && registro.servicio) {
                articuloId = registro.servicio.id;
                codigo = registro.servicio.codigo_servicio;
                codigoOriginal = registro.servicio.codigo_original;
                nombre = registro.servicio.nombre;
            } else {
                if (callback) callback();
                return;
            }

            const articuloTexto = `${articuloId} | ${codigo} | ${codigoOriginal} | ${nombre}`;
            const selectId = index === 0 ? '#articulo' : `#articulo${index}`;

            if ($(selectId).length === 0) {
                if (callback) callback();
                return;
            }

            const option = new Option(articuloTexto, articuloTexto, true, true);
            $(selectId).append(option).trigger('change');

            // Esperar a que ajax() termine
            setTimeout(function() {
                const descId = index === 0 ? '#descripcion0' : `#descripcion${index}`;
                const cantId = index === 0 ? '#cantidad0' : `#cantidad${index}`;
                const descuentoId = index === 0 ? '#descuento0' : `#descuento${index}`;
                const checkId = index === 0 ? '#check0' : `#check${index}`;
                const checkDescuentoId = index === 0 ? '#check_descuento0' : `#check_descuento${index}`;
                const comisionId = index === 0 ? '#comision0' : `#comision${index}`;

                // DESCRIPCIÓN
                if (registro.descripcion_item) {
                    $(descId).val(registro.descripcion_item);
                }

                // CANTIDAD
                $(cantId).val(registro.cantidad);

                // DESCUENTO
                if (registro.descuento && registro.descuento > 0) {
                    $(descuentoId).val(registro.descuento);
                    $(checkId).prop('checked', true);
                    $(checkDescuentoId).val(registro.descuento);
                }

                // COMISIÓN - FORZAR EL VALOR
                setTimeout(function() {
                    if (window.comisionDuplicada !== undefined) {
                        $(comisionId).val(window.comisionDuplicada);

                        // Forzar el evento onchange que está en el HTML
                        const comisionElement = document.querySelector(comisionId);
                        if (comisionElement && comisionElement.onchange) {
                            comisionElement.onchange();
                        }
                    } else {
                        // Si no hay comisión guardada, intentar obtenerla del select
                        const comisionSelect = document.querySelector('#comisionista').value;
                        if (comisionSelect) {
                            const separador = " ";
                            const reverse9 = reverseString(comisionSelect);
                            const comision_v_r = reverse9.split(separador, 2);
                            const comision_v = reverseString(comision_v_r[1]);
                            $(comisionId).val(comision_v);

                            const comisionElement = document.querySelector(comisionId);
                            if (comisionElement && comisionElement.onchange) {
                                comisionElement.onchange();
                            }
                        }
                    }

                    // Recalcular después de establecer la comisión
                    setTimeout(function() {
                        multi(index);
                        if (callback) {
                            setTimeout(callback, 250);
                        }
                    }, 300);
                }, 600); // Aumentar el timeout para dar tiempo a que se establezca el comisionista

            }, 2200);
        }
    </script>

    <script>
    // ==================== VARIABLES GLOBALES ====================
    let calendarioMesActual = new Date();
    let calendarioAnualMesActual = new Date();
    let fechaEmisionGlobal = new Date();
    let diaSeleccionadoAnual = null;
    let mesSeleccionadoAnual = null;

    // ==================== CALENDARIO MENSUAL (CORREGIDO) ====================
    function generarCalendarioMensual(mesOffset = 0) {
        const extraSelects = document.getElementById("extra_selects");

        let fechaEmision;
        const inputFechaEmision = document.querySelector('input[name="fecha_emision"]');

        if (inputFechaEmision && inputFechaEmision.value) {
            const separador = inputFechaEmision.value.includes('/') ? '/' : '-';
            const partes = inputFechaEmision.value.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaEmision = new Date(anio, mes, dia);
            } else {
                fechaEmision = new Date();
            }
        } else {
            fechaEmision = new Date();
        }

        if (isNaN(fechaEmision.getTime())) {
            fechaEmision = new Date();
        }

        fechaEmisionGlobal = fechaEmision;

        if (mesOffset === 0) {
            calendarioMesActual = new Date(fechaEmision.getFullYear(), fechaEmision.getMonth(), 1);
        }

        const mesVista = calendarioMesActual.getMonth();
        const anioVista = calendarioMesActual.getFullYear();
        const fechaMaxima = new Date(fechaEmision);
        fechaMaxima.setDate(fechaMaxima.getDate() + 30);

        const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        const primerDiaMesAnterior = new Date(anioVista, mesVista - 1, 1);
        const puedeRetroceder = primerDiaMesAnterior >= new Date(fechaEmision.getFullYear(), fechaEmision.getMonth(), 1);
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

        for (let i = ajusteDia - 1; i >= 0; i--) {
            const dia = diasMesAnterior - i;
            html += `<div class="calendar-day disabled" style="color: #d1dade;">${dia}</div>`;
        }

        const diaEmision = fechaEmision.getDate();
        const mesEmision = fechaEmision.getMonth();
        const anioEmision = fechaEmision.getFullYear();

        for (let dia = 1; dia <= diasEnMes; dia++) {
            const fechaDia = new Date(anioVista, mesVista, dia);
            const fechaDiaNormalizada = new Date(fechaDia.getFullYear(), fechaDia.getMonth(), fechaDia.getDate());
            const fechaEmisionNormalizada = new Date(fechaEmision.getFullYear(), fechaEmision.getMonth(), fechaEmision.getDate());

            const esFechaEmision = dia === diaEmision && mesVista === mesEmision && anioVista === anioEmision;
            const esAnteriorEmision = fechaDiaNormalizada < fechaEmisionNormalizada;
            const esPosteriorMaximo = fechaDia > fechaMaxima;
            const esDeshabilitado = esAnteriorEmision || esPosteriorMaximo;

            let clases = 'calendar-day';
            if (esDeshabilitado) {
                clases += ' disabled';
            } else {
                clases += ' selectable';
                if (esFechaEmision) clases += ' fecha-emision';
            }

            html += `<div class="${clases}" data-dia="${dia}" data-mes="${mesVista + 1}" data-anio="${anioVista}">${dia}</div>`;
        }

        const celdasUsadas = ajusteDia + diasEnMes;
        const filasNecesarias = Math.ceil(celdasUsadas / 7);
        const totalCeldas = filasNecesarias * 7;
        const diasVaciosFinal = totalCeldas - celdasUsadas;

        for (let i = 1; i <= diasVaciosFinal; i++) {
            html += `<div class="calendar-day disabled" style="color: #d1dade;">${i}</div>`;
        }

        html += `</div></div>`;
        extraSelects.innerHTML = html;

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

        document.querySelectorAll('.calendar-day.selectable').forEach(function(elemento) {
            elemento.addEventListener('click', function() {
                document.querySelectorAll('.calendar-day').forEach(el => el.classList.remove('selected'));
                this.classList.add('selected');

                const diaSeleccionado = parseInt(this.getAttribute('data-dia'));

                document.getElementById('dia_mensual_hidden').value = diaSeleccionado;
            });
        });
    }

    // ==================== CALENDARIO ANUAL ====================
    function generarCalendarioAnual(mesOffset = 0) {
        const extraSelects = document.getElementById("extra_selects");

        let fechaEmision;
        const inputFechaEmision = document.querySelector('input[name="fecha_emision"]');

        if (inputFechaEmision && inputFechaEmision.value) {
            const separador = inputFechaEmision.value.includes('/') ? '/' : '-';
            const partes = inputFechaEmision.value.split(separador);

            if (partes.length === 3) {
                const dia = parseInt(partes[0]);
                const mes = parseInt(partes[1]) - 1;
                const anio = parseInt(partes[2]);
                fechaEmision = new Date(anio, mes, dia);
            } else {
                fechaEmision = new Date();
            }
        } else {
            fechaEmision = new Date();
        }

        if (isNaN(fechaEmision.getTime())) {
            fechaEmision = new Date();
        }

        if (mesOffset === 0) {
            calendarioAnualMesActual = new Date(fechaEmision.getFullYear(), fechaEmision.getMonth(), 1);
        }

        const mesVista = calendarioAnualMesActual.getMonth();
        const anioVista = calendarioAnualMesActual.getFullYear();

        const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        const primerDiaMesAnterior = new Date(anioVista, mesVista - 1, 1);
        const puedeRetroceder = primerDiaMesAnterior >= new Date(fechaEmision.getFullYear(), fechaEmision.getMonth(), 1);

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

        for (let i = ajusteDia - 1; i >= 0; i--) {
            const dia = diasMesAnterior - i;
            html += `<div class="calendar-day disabled" style="color: #d1dade;">${dia}</div>`;
        }

        const diaEmision = fechaEmision.getDate();
        const mesEmision = fechaEmision.getMonth();
        const anioEmision = fechaEmision.getFullYear();

        for (let dia = 1; dia <= diasEnMes; dia++) {
            const fechaDia = new Date(anioVista, mesVista, dia);
            const fechaDiaNormalizada = new Date(fechaDia.getFullYear(), fechaDia.getMonth(), fechaDia.getDate());
            const fechaEmisionNormalizada = new Date(fechaEmision.getFullYear(), fechaEmision.getMonth(), fechaEmision.getDate());

            const esFechaEmision = dia === diaEmision && mesVista === mesEmision && anioVista === anioEmision;
            const esAnteriorEmision = fechaDiaNormalizada < fechaEmisionNormalizada;

            let clases = 'calendar-day';
            if (esAnteriorEmision) {
                clases += ' disabled';
            } else {
                clases += ' selectable';
                if (esFechaEmision) clases += ' fecha-emision';
            }

            html += `<div class="${clases}" data-dia="${dia}" data-mes="${mesVista + 1}" data-anio="${anioVista}">${dia}</div>`;
        }

        const celdasUsadas = ajusteDia + diasEnMes;
        const filasNecesarias = Math.ceil(celdasUsadas / 7);
        const totalCeldas = filasNecesarias * 7;
        const diasVaciosFinal = totalCeldas - celdasUsadas;

        for (let i = 1; i <= diasVaciosFinal; i++) {
            html += `<div class="calendar-day disabled" style="color: #d1dade;">${i}</div>`;
        }

        html += `</div></div>`;
        extraSelects.innerHTML = html;

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

        document.querySelectorAll('.calendar-day.selectable').forEach(function(elemento) {
            elemento.addEventListener('click', function() {
                document.querySelectorAll('.calendar-day').forEach(el => el.classList.remove('selected'));
                this.classList.add('selected');

                diaSeleccionadoAnual = parseInt(this.getAttribute('data-dia'));
                mesSeleccionadoAnual = parseInt(this.getAttribute('data-mes'));
                const anioSeleccionado = parseInt(this.getAttribute('data-anio'));

                document.getElementById('dia_anual_hidden').value = diaSeleccionadoAnual;
                document.getElementById('mes_anual_hidden').value = mesSeleccionadoAnual;
                document.getElementById('anio_anual_hidden').value = anioSeleccionado;
            });
        });
    }

    // ==================== EVENT LISTENERS ====================
    document.addEventListener("DOMContentLoaded", function () {
        const checkRenovacion = document.getElementById("estado_renovacion");
        const contenedorRenovacion = document.getElementById("renovacion_container");
        const selectFecha = document.getElementById("select_fecha");
        const extraSelects = document.getElementById("extra_selects");
        const divRenovacion = document.querySelector(".renovacion");

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

        const selectTipo = document.querySelector(".select2_tipo_coti");
        if (selectTipo) {
            if (selectTipo.value == "1") {
                divRenovacion.style.display = "block";
            } else {
                divRenovacion.style.display = "none";
            }
        }
    });

    function select_tipo() {
        const selectTipo = document.querySelector(".select2_tipo_coti");
        const divRenovacion = document.querySelector(".renovacion");

        if (selectTipo.value == "1") {
            divRenovacion.style.display = "block";
        } else {
            divRenovacion.style.display = "none";

            const checkRenovacion = document.getElementById("estado_renovacion");
            const contenedorRenovacion = document.getElementById("renovacion_container");
            const selectFecha = document.getElementById("select_fecha");
            const extraSelects = document.getElementById("extra_selects");

            if (checkRenovacion) checkRenovacion.checked = false;
            if (contenedorRenovacion) contenedorRenovacion.style.display = "none";
            if (selectFecha) selectFecha.value = "";
            if (extraSelects) extraSelects.innerHTML = "";
            if (document.getElementById('dia_mensual_hidden')) {
                document.getElementById('dia_mensual_hidden').value = "";
            }
            if (document.getElementById('dia_anual_hidden')) {
                document.getElementById('dia_anual_hidden').value = "";
            }
            if (document.getElementById('mes_anual_hidden')) {
                document.getElementById('mes_anual_hidden').value = "";
            }
            if (document.getElementById('anio_anual_hidden')) {
                document.getElementById('anio_anual_hidden').value = "";
            }
            diaSeleccionadoAnual = null;
            mesSeleccionadoAnual = null;
        }
    }
    </script>
    @include('transaccion.venta.clientes.modal_create')
@endsection
