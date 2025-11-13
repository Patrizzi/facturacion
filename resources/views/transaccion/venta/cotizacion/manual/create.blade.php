@extends('layout')
@section('title', 'Cotizacion Manual')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
{{-- @extends('layout_agregado_rapido') --}}
{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
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
    {{-- @section('ruta_retorno', 'otros') --}}
    {{-- <div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o"
            aria-hidden="true"></i>cliente </a>
</div> --}}


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h4><strong>Generar Cotización Manual</strong></h4>
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="" href="{{ route('ventas.cotizacion_manual') }}">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form action="{{ route('cotizacion_manual.store') }}" enctype="multipart/form-data" method="post"
                    id="form_sto" onsubmit="return valida(this)">
                    @csrf
                    {{-- si existe un servicio guia en esta vista, mandarla al controller --}}
                    @if(isset($servicioGuia->id))
                        <input type="hidden" name="servicio_g_id" value="{{ $servicioGuia->id }}">
                    @endif
                    <div class="row form-label word-style">
                        <div class="col-md-6">
                            <!-- Cliente -->
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                                <div class="col-md-10">

                                    {{-- si existe un servicio guia en esta vista, bloquear el cliente para no poder cambiarlo con los mismos parámetros --}}
                                    @if(isset($servicioGuia->id))
                                        <input type="hidden" name="cliente" value="{{ $servicioGuia->cliente_id }}">
                                        <input type="text" class="form-control" value="{{ $servicioGuia->cliente->nombre }} | {{ $servicioGuia->cliente->numero_documento }}" readonly>
                                    @else
                                        {{-- en caso contrario, que esté como antes --}}
                                        <div class="input-group">
                                            <select class="select2_demo_client" name="cliente" id="cliente" required="" value="{{ old('nombre') }}">
                                            </select>
                                            <div class="input-group-append">
                                                <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Fecha Emisión:</strong></label>
                                        <div class="col-md-8">
                                            <input type="text" name="fecha_emision" class="form-control"
                                                value="{{ date('d-m-Y') }}" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Validez:</strong></label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="validez" required="required">
                                                @foreach ($validez as $validezz)
                                                    <option value="{{ $validezz->descripcion }}">
                                                        {{ $validezz->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>Almacén:</strong></label>
                                <div class="col-md-10">
                                    <select class="select2_demo_almacen" name="almacen_form" required="" value=""
                                        onchange="codigo_numero()">
                                        @foreach ($almacen as $almacenes)
                                            <option value="{{ $almacenes->id }}">{{ $almacenes->nombre }} -
                                                {{ $almacenes->abreviatura }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>T. Operación:</strong></label>
                                <div class="col-md-10">
                                    <select class="select2_tipo_op" name="tipo_operacion">
                                        @foreach ($tipo_operacion as $t_op)
                                            <option id="{{ $t_op->id }}">{{ $t_op->codigo }} -
                                                {{ $t_op->informacion }}
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
                                            @if(isset($servicioGuia->id))
                                                @php
                                                    $tipoComprobante = ($servicioGuia->cliente->documento_identificacion == 'RUC') ? 1 : 0;
                                                    $tipoTexto = ($tipoComprobante == 1) ? 'Factura' : 'Boleta';
                                                @endphp
                                                <input type="hidden" name="tipo_coti" value="{{ $tipoComprobante }}">
                                                <input type="text" class="form-control" value="{{ $tipoTexto }}" readonly>
                                            @else
                                                <select name="tipo_coti" id="" class="select2_tipo_coti" onchange="select_tipo()">
                                                    <option value="1">Factura</option>
                                                    <option value="0">Boleta</option>
                                                    <option value="2">Nota de Venta</option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Moneda:</strong></label>
                                        <div class="col-md-8">
                                            <select class="select2_moneda" name="moneda" required="required"
                                                onchange="changeMoney()">
                                                @foreach ($moneda as $monedas)
                                                    <option value="{{ $monedas->nombre }}">{{ $monedas->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Forma Pago:</strong></label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="forma_pago" required>
                                                @foreach ($forma_pagos as $forma_pago)
                                                    <option value="{{ $forma_pago->id }}">{{ $forma_pago->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>Garantía:</strong></label>
                                        <div class="col-md-8">
                                            <select class="form-control" name="garantia">
                                                @foreach ($garantia as $garantias)
                                                    <option value="{{ $garantias->descripcion }}">
                                                        {{ $garantias->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label class="col-form-label col-md-1"><strong>Observación:</strong></label>
                                <div class="col-md-11">
                                    <textarea class="form-control" name="observacion" id="observacion" rows="1"
                                        placeholder="Ingrese una observación">Emitimos la siguiente Cotizacion a vuestra solicitud</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 renovacion">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="switch-container">
                                        <label class="switch">
                                            <input type="checkbox" id="estado_renovacion" name="estado_renovacion" value="1">
                                            <span class="slider"></span>
                                        </label>
                                        <label for="estado_renovacion" class="switch-label">Activar renovación</label>
                                    </div>
                                </div>
                            </div>

                            <div id="renovacion_container" style="display: none; margin-top: 15px;">
                                <div class="row">
                                    <div class="col-sm-4">
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
                                <!-- Input oculto para guardar el día seleccionado -->
                                <input type="hidden" name="dia_mensual" id="dia_mensual_hidden">
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
                            @foreach ($moneda as $moneda_2)
                                @if ($moneda_2->principal == 1)
                                    <input type="hidden" id="moneda_id" class="form-control "
                                        value="{{ $moneda_2->id }}" readonly="readonly">
                                @endif
                            @endforeach
                        </div>
                        <input type="hidden" name="" id="count_articles" value="">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table cellspacing="0" class="table tables" id="inp_s">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">
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
                                            <th style="width: 100%">Artículo</th>
                                            <th style="width:100px">Cantidad</th>
                                            <th style="width:100px">P. Sugerido</th>
                                            <th style="width:100px">Precio s/Igv </th>
                                            <th style="width:100px">Precio c/Igv</th>
                                            <th style="width:100px">Total Igv</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <button type="button" class='delete borrar e btn btn-sm btn-primary'>
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="select2_demo_3 select_change" required=""
                                                    id="articulo" onchange="inputs_campos(0),ajax(0)"
                                                    name="select_articulo"></select>
                                                <textarea type='text' id='descripcion0' name='descripcion_item[]' placeholder="Descripción de Item"
                                                    class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                                                {{-- <input hidden="hidden" class="celda" name="articulo[]"
                                                    id="input_prod1"> --}}
                                                <input hidden="hidden" class="celda input-articulo" name="articulo[]">
                                            </td>

                                            <td>
                                                <input style="width: 100px" type='number' min="1" id='cantidad0'
                                                    name='cantidad[]' max="" class="cantidad monto0 form-control"
                                                    onkeyup="multi(0)" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="width: 100px" type='text' id='precio_oficial0'
                                                    name='precio_oficial[]' ondblclick="copy(0)"
                                                    class="precio_oficial0 p_inp form-control inp" required readonly
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Doble click (Copiar)" />
                                            </td>
                                            <td>
                                                <input style="width: 100px" type='number' step="0.0000001"
                                                    id='precio_s_igv0' name='precio_s_igv[]'
                                                    class="precio_s_igv form-control" onkeyup="multi_s_igv(0),multi(0)"
                                                    required autocomplete="off" />
                                                <input hidden type='text' id='precio_s_igv_float0'
                                                    name='precio_s_igv_float' class="precio_s_igv_float form-control"
                                                    onkeyup="multi_s_igv(0),multi(0)" autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="width: 100px" type='number' step="0.0000001"
                                                    id='precio_c_igv0' name='precio_c_igv[]'
                                                    class="precio_c_igv monto0 form-control"
                                                    onkeyup="multi_c_igv(0),multi(0)" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="width: 100px" type='number' id='total0' name='total'
                                                    disabled="disabled" class="total form-control " required
                                                    autocomplete="off" />
                                            </td>
                                            <span id="spTotal"></span>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <input id='sub_total' hidden /></td>
                                        <input id='total' hidden /></td>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Subtotal: </td>
                                            <td colspan="2">
                                                <input type="text" id='subtotal' name="subtotal" readonly="readonly"
                                                    class="subtotal form-control" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Igv:</td>
                                            <td colspan="2">
                                                <input type="text" id='igv' name="igv" readonly="readonly"
                                                    class="igv form-control" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Total :</td>
                                            <td colspan="2">
                                                <input type="text" id='total_final' name="total_final"
                                                    readonly="readonly" class="total_final form-control" required />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="guardar ladda-button btn btn-primary btn-outline" type="submit">Guardar</button>
                            <button class="btn btn-primary demo3 float-right" id="finalizar_button"
                                style="margin-left: 10px;" type="button">Guardar y Finalizar</button>
                            <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden=""
                                data-style="zoom-out">
                            </button>
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
                                            <th>STOCK</th>
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

        /*.form-control {
            border-radius: 10px
        }*/

        .text_des {
            border-radius: 10px;
            border: 1px solid #e5e6e7;
            width: 80px;
            padding: 6px 12px;
        }

        .a {
            color: red
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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
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

        .dataTables_wrapper {
            padding-bottom: 0px;
        }

        .td_selected>span.select2.select2-container.select2-container--default {
            width: 100%;
        }

        @media only screen and (max-width: 1498px) {
            .td_selected>span.select2.select2-container.select2-container--default {
                width: 100% !important;
                min-width: 376px !important;
            }
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1200px;
            }
        }
    </style>

    //Estilos para el check de activar renovacion
    <style>
    .renovacion {
        padding: 0;
        margin-bottom: 15px;
        margin-top: 7px;
    }

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

    /* Label del switch */
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

    .renovacion select:focus {
        outline: none;
        box-shadow: none;
        border-color: #e5e6e7;
    }

    .renovacion hr {
        display: none;
    }

    /* CALENDARIO */
    .calendar-container {
        padding: 16px;
        border: 1px solid #e5e6e7;
        margin-top: 0px;
        max-width: 300px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e6e7;
    }

    .calendar-header h3 {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        flex: 1;
        text-align: center;
        letter-spacing: 0.3px;
    }

    .calendar-nav-btn {
        background: #f8f9fa;
        border: 1px solid #e5e6e7;
        border-radius: 3px;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #676a6c;
        transition: all 0.2s;
        padding: 0;
    }

    .calendar-nav-btn:hover:not(:disabled) {
        background: #1c84c6;
        color: white;
        border-color: #1c84c6;
    }

    .calendar-nav-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .calendar-nav-btn svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
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
        border-radius: 3px;
        font-size: 11px;
        border: 1px solid transparent;
        transition: all 0.2s;
        color: #333;
        min-height: 28px;
        max-height: 30px;
    }

    .calendar-day.selectable {
        cursor: pointer;
    }

    .calendar-day.selectable:hover {
        background: #e8f4f8;
        border-color: #1c84c6;
        transform: scale(1.05);
    }

    .calendar-day.disabled {
        color: #d0d0d0;
        cursor: not-allowed;
        background: #fafafa;
    }

    .calendar-day.selected {
        background: #1c84c6 !important;
        color: white !important;
        font-weight: 600;
        border-color: #1c84c6;
        box-shadow: 0 2px 4px rgba(28, 132, 198, 0.3);
    }

    .calendar-day.today {
        background: #1ab394;
        color: white;
        font-weight: 600;
    }

    .calendar-day.fecha-emision {
        background: #1ab394 !important;
        color: white !important;
        font-weight: 600;
        border-color: #1ab394 !important;
    }

    .calendar-day.fecha-emision:hover {
        background: #18a085!important;
        border-color: #18a085 !important;
        transform: scale(1.05);
    }

    .calendar-day.fecha-emision.selected {
        background: #1c84c6 !important;
        color: white !important;
        box-shadow: 0 0 0 3px #1ab394;
        border-color: #1c84c6 !important;
    }

    .calendar-day.empty {
        background: transparent;
        border: none;
        cursor: default;
        pointer-events: none;
    }

    #renovacion_container {
        animation: slideDown 0.3s ease-out;
        margin-top: 6px;
    }

    .renovacion .row {
        margin-bottom: 6px;
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
    <!-- Sweet alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>


    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function toggle() {
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        }

        function select_tipo() {
            $(".select2_demo_client").select2("val", "");
        }
    </script>

    <script type="text/javascript">
        $('.demo3').click(function(e) {
            if (document.forms['form_sto'].reportValidity()) {
                swal({
                        title: "¿Estas seguro que deseas Finalizar?",
                        text: "Una vez Finalizado, no podras modificar la Cotizacion Manual",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3686ff",
                        confirmButtonText: "Si, Finalizar",
                        cancelButtonText: "Cancelar!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            swal("Edicion de Cotizacion Manual Finalizada", "Ya no podrás editar", "success");
                            $(".finalizar").click();
                            $(".guardar").attr('disabled', true);
                        } else {
                            swal("Cancelado", "Cancelado la Finalizar", "error");
                        }
                    });
            }
        });
        $(document).ready(function() {
            // Bind normal buttons
            Ladda.bind('.ladda-button', {
                timeout: 8000
            });
        });

        // $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        function mostrarMensaje(mensaje) {
            $("#divmsg").empty(); //limpiar div
            $("#divmsg").append(mensaje);
            $("#divmsg").show(200);
        }
        /* {{-- Darle valor a cada Boton si es Finalizar o solo Guardar --}} */
        $(".guardar").on('submit', function(e) {
            $(".demo3").attr('disabled', true);
            var data =
                `<input value="1" type='hidden' name='submit' class="form-control" required/>  <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);

        });
        $(".finalizar").on('click', function(e) {
            var data =
                `<input value="2" type='hidden' name='submit' class="form-control" required/>   <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);
            //  $(".guardar").dis();
        });
        $(".select2_demo_almacen").select2({
            placeholder: "Seleccionar Almacen",
        });
        $(".select2_tipo_op").select2();
        $(".select2_tipo_coti").select2();
        $(".select2_moneda").select2();


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

    @if(isset($servicioGuia->id) && isset($ingresoEquipos))
        $(document).ready(function() {
                precargarEquiposServicio();

        });

        function precargarEquiposServicio() {
            var equipos = @json($ingresoEquipos);
            // console.log('Equipos a cargar:', equipos);
            // servicio especifico para servicio tecnico
            var servicioSoporte = "{{ $servicios->where('codigo_servicio', 'SERV-00000048')->first()->id ?? '' }} | SERV-00000048 | SERV-00000048 | SERVICIO";

            equipos.forEach(function(equipo, index) {

                if (index > 0) {
                    agregarNuevaFila();
                    setTimeout(function() {
                        procesarEquipo(equipo, index, servicioSoporte);
                    }, 100);
                } else {
                    procesarEquipo(equipo, index, servicioSoporte);
                }
            });
        }

        function procesarEquipo(equipo, index, servicioSoporte) {
            var selectId = (index == 0) ? 'articulo' : `articulo${index + 1}`;
            var descripcionId = (index == 0) ? 'descripcion0' : `descripcion${index + 1}`;
            var cantidadId = (index == 0) ? 'cantidad0' : `cantidad${index + 1}`;
            var equipoInput = `<input type="hidden" name="equipo_ids[]" value="${equipo.id}">`;

            $(`#${selectId}`).closest('td').append(equipoInput);

            var $select = $(`#${selectId}`);
            if ($select.length) {
                $select.empty();

                var newOption = new Option(servicioSoporte, servicioSoporte, true, true);
                $select.append(newOption).trigger('change');

                var descripcionTexto = `Equipo: ${equipo.nombre_equipo}`;
                if (equipo.nro_serie) {
                    descripcionTexto += ` | Serie: ${equipo.nro_serie}`;
                }
                $(`#${descripcionId}`).val(descripcionTexto);

                $(`#${cantidadId}`).val(1);

                inputs_campos(index);
                ajax(index);

            } else {
                console.error('No se encontró el select:', selectId);
            }
        }

        function agregarNuevaFila() {
            // Simular click en el botón addmore
            var data = `
                <tr>
                    <td>
                        <button type="button" class='delete borrar e btn btn-sm btn-primary'>
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                    <td class="td_selected">
                        <select class="select2_demo_3 select_change" id='articulo${i}' onchange="inputs_campos(${i}),ajax(${i})" autocomplete="off" required></select>
                        <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                        <input hidden="hidden" class="celda" name="articulo[]" id="input_prod${i}">
                    </td>
                    <td>
                        <input type='number' min='1' style="width: 100px" id='cantidad${i}' name='cantidad[]' class="cantidad monto${i} form-control" onkeyup="multi(${i})" required autocomplete="off"/>
                    </td>
                    <td class="full-height-scroll tooltip-demo">
                        <input type='number' style="width: 100px" id='precio_oficial${i}' name='precio_oficial[]' ondblclick="copy(${i})" class="precio_oficial${i} form-control inp" required autocomplete="off" readonly data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" />
                    </td>
                    <td>
                        <input style="width: 100px" type='number' step="0.0000001" id='precio_s_igv${i}' name='precio_s_igv[]' class="precio_s_igv monto${i} form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required autocomplete="off" />
                        <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float' class="precio_s_igv_float form-control" onkeyup="multi_s_igv(${i}),multi(${i})" autocomplete="off" />
                    </td>
                    <td>
                        <input style="width: 100px" type='number' id='precio_c_igv${i}' name='precio_c_igv[]' step="0.0000001" class="precio_c_igv p_inp monto${i} form-control" onkeyup="multi_c_igv(${i}),multi(${i})" required autocomplete="off" />
                    </td>
                    <td>
                        <input type='number' id='total${i}' style="width: 100px" name='total' disabled="disabled" class="total form-control " required autocomplete="off"/>
                    </td>
                </tr>
            `;
            $('.tables tbody:first').append(data);
            $('#count_articles').val(i);
            i++;
            articlesSelect2();
        }
    @endif
    </script>

    <script>
        var i = 2;
        $(".addmore").on('click', function() {
            // console.log("add");
            var data = `[
        <tr>
            <td>
                <button type="button" class='delete borrar e btn btn-sm btn-primary'>
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
            </td>";
            <td class="td_selected">
                <select class="select2_demo_3 select_change" id='articulo${i}' onchange="inputs_campos(${i}),ajax(${i})"  autocomplete="off" required></select>
                <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                <input hidden="hidden"  class="celda"  name="articulo[]" id="input_prod${i}" >
            </td>
            <td>
                <input type='number' min='1' style="width: 100px"  id='cantidad${i}' name='cantidad[]' class="cantidad monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
            </td>
            <td class="full-height-scroll tooltip-demo">
                <input type='number' style="width: 100px"  id='precio_oficial${i}' name='precio_oficial[]' ondblclick="copy(${i})" class="precio_oficial${i} form-control inp" required  autocomplete="off" readonly data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" />
            </td>
            <td>
                <input style="width: 100px" type='number' step="0.0000001" id='precio_s_igv${i}' name='precio_s_igv[]'  class="precio_s_igv monto${i} form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
                <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(${i}),multi(${i})"   autocomplete="off" />
            </td>
            <td>
                <input style="width: 100px" type='number' id='precio_c_igv${i}' name='precio_c_igv[]' step="0.0000001" class="precio_c_igv p_inp monto${i} form-control" onkeyup="multi_c_igv(${i}),multi(${i})" required  autocomplete="off" />
            </td>
            <td>
                <input type='number' id='total${i}'  style="width: 100px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
            </td>
        </tr>
        `;
            $('.tables').append(data);
            $('#count_articles').val(i);
            i++;
            //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
            articlesSelect2();
            toggle();
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
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
                            almacen: 0,
                            tipo_doc: 'manual',
                            @if(isset($servicioGuia->id))
                                es_servicio_tecnico: true
                            @endif
                        };
                    },
                    processResults: function(data) {
                        //validador de articulos multiples
                        let data_length = data.length;
                        let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                        let articles_selected_count_ajax = articles_selected_ajax.length;
                        // for(var z=0;z<ar ticles_selected_count_ajax;z++){
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
        //Funcion Copiar
        function copy(a) {
            if (a == 0) {
                var copy = document.getElementById(`precio_oficial0`).value;
                document.getElementById(`precio_s_igv0`).value = copy;
                multi_s_igv(0);
            } else {
                var copy = document.getElementById(`precio_oficial${a}`).value;
                document.getElementById(`precio_s_igv${a}`).value = copy;
                multi_s_igv(a);
            }
            multi(a);

        }
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
                    if (msg.price == 0 && msg.amount == 0) {
                        $(`#cantidad${a}`).val(0);
                        $(`#cantidad${a}`).attr('max', msg.amount);
                        $(`#cantidad`).attr('max', msg.amount);
                        $(`#precio_oficial${a}`).val(msg.price);
                    } else {
                        $(`#precio_oficial${a}`).val(msg.price);
                        $(`#cantidad${a}`).val(1);
                    }
                    multi(a);
                    $(`.addmore`).prop("disabled", false);
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        // console.log(eject.responseJSON.error);
                        console.log('Error');
                    }
                },
                cache: true
            });
        }

        function inputs_campos(a) {
            const selectId = a === 0 ? 'articulo' : `articulo${a}`;
            const selectElement = document.getElementById(selectId);

            if (!selectElement) return;

            const articulo = selectElement.value;
            const fila = selectElement.closest('tr');
            const inputArticulo = fila.querySelector('input.celda');

            if (inputArticulo) {
                inputArticulo.value = articulo;
            }
        }
        var igv = {{ $igv->renta }}

        function multi(a) {
            var total = 1;
            var totales = 0;
            var change = false; //
            var multiplier = 100;
            $(`.monto${a}`).each(function() {
                if (!isNaN(parseFloat($(this).val()))) {
                    change = true;
                    total *= parseFloat($(this).val());
                }
            });
            total = (change) ? total : 0;
            var cantidad = document.querySelector(`#cantidad${a}`).value;
            //CALCULAR PRECIO SIN IGV
            var precio_sin = document.querySelector(`#precio_s_igv${a}`).value;
            var final_sin = precio_sin * cantidad;
            var final_decimal_sin = Math.round(final_sin * multiplier) / multiplier;


            document.getElementById(`precio_s_igv_float${a}`).value = final_decimal_sin;
            //CALCULAR PRECIO CON IGV
            // var precio = document.querySelector(`#precio_c_igv${a}`).value;
            // var final=precio*cantidad;
            // var final_decimal = Math.round(final * multiplier) / multiplier;
            //igv calculo
            var only_igv = final_sin + (parseFloat(final_sin) * (igv / multiplier));
            var igv_decimal = Math.round(only_igv * multiplier) / multiplier;

            document.getElementById(`total${a}`).value = igv_decimal;



            // Operacion para subtotal sin igv
            var sub_igv = $('[name="precio_s_igv_float"]');
            var sub_igv_t = 0;
            sub_igv.each(function() {
                sub_igv_t += parseFloat($(this).val());
            });
            var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
            $('#sub_total').val(sub_igv_tt);
            document.getElementById("subtotal").value = sub_igv_tt;

            //OPERACION PARA CALULCAR EL IGV
            var only_igv = (parseFloat(sub_igv_tt) * (igv / multiplier))
            var igv_decimal = Math.round(only_igv * multiplier) / multiplier;
            document.getElementById("igv").value = igv_decimal;

            // Operacion para total
            // var totalInp = $('[name="total"]');
            // var total_t = 0;
            // totalInp.each(function(){
            //     total_t += parseFloat($(this).val());
            // });
            // console.log(total_t);
            var multiplier2 = 100;
            var total_all = sub_igv_t + igv_decimal;
            var total_tt = Math.round(total_all * multiplier2) / multiplier2;

            $('#total').val(total_tt);

            var subtotal = document.querySelector(`#total`).value;
            document.getElementById("total_final").value = subtotal;

        }

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
                //RECALCULO PARA LOS SUBTOTAL IGV Y TOTAL
                // Operacion para subtotal sin igv
                var sub_igv = $('[name="precio_s_igv_float"]');
                var sub_igv_t = 0;
                sub_igv.each(function() {
                    sub_igv_t += parseFloat($(this).val());
                });
                var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
                $('#sub_total').val(sub_igv_tt);
                document.getElementById("subtotal").value = sub_igv_tt;

                //OPERACION PARA CALULCAR EL IGV
                var only_igv = (parseFloat(sub_igv_tt) * (igv / multiplier))
                var igv_decimal = Math.round(only_igv * multiplier) / multiplier;
                document.getElementById("igv").value = igv_decimal;

                // Operacion para total
                var totalInp = $('[name="total"]');
                var total_t = 0;
                totalInp.each(function() {
                    total_t += parseFloat($(this).val());
                });

                var multiplier2 = 100;
                var total_tt = Math.round(total_t * multiplier2) / multiplier2;

                // console.log(total_tt);
                $('#total').val(total_tt);

                var subtotal = document.querySelector(`#total`).value;
                document.getElementById("total_final").value = subtotal;
            } else {
                limpiar_inputs();
                $(".select2_demo_3").val(null).trigger("change");
                $(".addmore").prop("disabled", false);
                limpiar_inputs();

            }
            articlesSelect2();
        });

        var igv = {{ $igv->renta }}
        var multiplier = 100;

        function multi_s_igv(a) {
            var pr_s_igv = $(`#precio_s_igv${a}`).val();
            $(`#precio_s_igv_float${a}`).val(pr_s_igv);
            var c_igv_s_redondeo = parseFloat(pr_s_igv) + (parseFloat(pr_s_igv) * igv / multiplier);
            var c_igv_redondeo = Math.round(c_igv_s_redondeo * multiplier) / multiplier;
            $(`#precio_c_igv${a}`).val(c_igv_redondeo);
        }

        function multi_c_igv(a) {
            var pr_c_igv = $(`#precio_c_igv${a}`).val();
            var igv_dec = igv / multiplier;
            var s_igv_s_base = parseFloat(pr_c_igv) / (1 + parseFloat(igv_dec));
            var s_igv_redondeo = Math.round(s_igv_s_base * multiplier) / multiplier;
            $(`#precio_s_igv${a}`).val(s_igv_redondeo);
            $(`#precio_s_igv_float${a}`).val(s_igv_redondeo);


        }

        function click_radio_nota_venta() {
            if ($('input[class=n_nota_venta]:radio:checked').length == 0) {
                $(".select2_demo_client").select2("val", "");
            }

        }

        function click_radio_boleta() {
            if ($('input[class=n_boleta]:radio:checked').length == 0) {
                $(".select2_demo_client").select2("val", "");
            }

        }

        function click_radio_factura() {
            if ($('input[class=n_factura]:radio:checked').length == 0) {
                $(".select2_demo_client").select2("val", "");
            }
        }

        function limpiar_inputs() {
            $(`.precio_s_igv`).val("");
            $(`.precio_c_igv`).val("");
            $(`.cantidad`).val("");
            $(`.total`).val("");
            $(`.subtotal`).val("");
            $(`.igv`).val("");
            $(`.total_final`).val("");
            $(`.p_inp`).val("");
        }
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
                    $(`#moneda_id`).val(msg.id);
                    $(`#moneda`).val(msg.nombre);
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

        function disabled_money() {
            $(`.money_change`).prop('disabled', true);
            $(`.button_money`).addClass('not-active');

            setTimeout(function() {
                $(`.money_change`).prop('disabled', false);
                $(`.button_money`).removeClass('not-active');
            }, 10000);
        }

        function codigo_numero() {
            var almacen = $('.select2_demo_almacen').val();
            var tipo = $('[name="tipo_coti"]:checked').val();
            $.ajax({
                type: "post",
                url: "{{ route('cotizacion_manual.change_almacen_tipo') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tipo': tipo,
                    'almacen': almacen,
                },
                success: function(msg) {
                    $('#codigo_cot_manual').html(msg)
                }
            })
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
                        "autoWidth": false,
                        "bLengthChange": false,
                        "searching": false,
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
                        // console.log(eject.responseJSON.error);
                        console.log('Error');
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
</script>

    <script>
        $(document).ready(function() {
            var cotiDuplicada = @json($cotiDuplicada ?? null);

            if (cotiDuplicada) {
                // console.log('🔄 Cotización a duplicar:', cotiDuplicada);

                // ⏰ Esperar más tiempo para que TODOS los selects se inicialicen
                setTimeout(function() {
                    cargarDatosCotizacionManual(cotiDuplicada);
                }, 2000); // ← Aumentado a 2 segundos
            }
        });

        function cargarDatosCotizacionManual(data) {
            // console.log('📋 Cargando datos...');

            if (data.cliente) {
                // Esperar un poco antes de manipular el select del cliente
                setTimeout(function() {
                    // Destruir select2 si existe
                    if ($('#cliente').hasClass("select2-hidden-accessible")) {
                        $('#cliente').select2('destroy');
                    }

                    // Limpiar y agregar la opción del cliente
                    $('#cliente').empty();
                    const clienteOption = new Option(
                        data.cliente.nombre + ' | ' + data.cliente.numero_documento,
                        data.cliente.id,
                        true,
                        true
                    );
                    $('#cliente').append(clienteOption);

                    // Reinicializar select2 CON la configuración AJAX original
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
                                var tipo_coti = $('select[name="tipo_coti"]').val();
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

                    // Forzar el valor seleccionado
                    $('#cliente').val(data.cliente.id).trigger('change');

                    // console.log('✅ Cliente cargado:', data.cliente.nombre);
                }, 800); // Esperar 800ms antes de cargar el cliente
            }

            // 2. VALIDEZ
            if (data.validez) {
                $('select[name="validez"]').val(data.validez).trigger('change');
                // console.log('✅ Validez:', data.validez);
            }

            // 3. ALMACEN
            if (data.almacen_id) {
                $('select[name="almacen_form"]').val(data.almacen_id).trigger('change');
                // console.log('✅ Almacén ID:', data.almacen_id);
            }

            // 4. TIPO OPERACIÓN
            if (data.tipo_operacion) {
                const tipoOpTexto = data.tipo_operacion.codigo + ' - ' + data.tipo_operacion.informacion;
                $('.select2_tipo_op').val(tipoOpTexto).trigger('change');
                // console.log('✅ Tipo operación:', tipoOpTexto);
            }

            // 5. TIPO COTIZACIÓN
            let tipoCoti = '1'; // factura
            if (data.tipo === 'boleta') tipoCoti = '0';
            if (data.tipo === 'nota_venta') tipoCoti = '2';
            $('select[name="tipo_coti"]').val(tipoCoti).trigger('change');
            // console.log('✅ Tipo:', data.tipo);

            // 6. MONEDA
            if (data.moneda && data.moneda.nombre) {
                $('.select2_moneda').val(data.moneda.nombre).trigger('change');
                // console.log('✅ Moneda:', data.moneda.nombre);
            }

            // 7. FORMA DE PAGO
            if (data.forma_pago_id) {
                $('select[name="forma_pago"]').val(data.forma_pago_id).trigger('change');
                // console.log('✅ Forma pago ID:', data.forma_pago_id);
            }

            // 8. GARANTÍA
            if (data.garantia) {
                $('select[name="garantia"]').val(data.garantia).trigger('change');
                // console.log('✅ Garantía:', data.garantia);
            }

            // 9. OBSERVACIÓN
            if (data.observacion) {
                $('#observacion').val(data.observacion);
                // console.log('✅ Observación cargada');
            }

            // 10. ARTÍCULOS - Esperar más antes de cargar
            setTimeout(function() {
                cargarArticulosManual(data);
            }, 2000); // ← Aumentado
        }

        function cargarArticulosManual(data) {
            let registros = data.coti_manual_registros || [];

            if (registros.length === 0) {
                // console.log('⚠️ No hay artículos');
                return;
            }

            // console.log('📦 Artículos a cargar:', registros.length);
            cargarArticulosSecuencialManual(registros, 0);
        }

        function cargarArticulosSecuencialManual(registros, index) {
            if (index >= registros.length) {
                // console.log('✅ Todos los artículos cargados');
                return;
            }

            const registro = registros[index];
            // console.log(`\n--- Artículo ${index + 1}/${registros.length} ---`);

            if (index === 0) {
                cargarArticuloEnFilaManual(registro, 0, function() {
                    setTimeout(function() {
                        cargarArticulosSecuencialManual(registros, index + 1);
                    }, 800); // ← Tiempo entre artículos
                });
            } else {
                crearNuevaFilaManual(index, function() {
                    cargarArticuloEnFilaManual(registro, index, function() {
                        setTimeout(function() {
                            cargarArticulosSecuencialManual(registros, index + 1);
                        }, 800);
                    });
                });
            }
        }

        function crearNuevaFilaManual(index, callback) {
            var data = `
                <tr>
                    <td>
                        <button type="button" class='delete borrar e btn btn-sm btn-primary'>
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                    <td class="td_selected">
                        <select class="select2_demo_3 select_change" id='articulo${index}' onchange="inputs_campos(${index}),ajax(${index})" required></select>
                        <textarea id='descripcion${index}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" style="margin-top: 5px;"></textarea>
                        <input hidden class="celda input-articulo" name="articulo[]">
                    </td>
                    <td>
                        <input type='number' min='1' style="width: 100px" id='cantidad${index}' name='cantidad[]' class="cantidad monto${index} form-control" onkeyup="multi(${index})" required/>
                    </td>
                    <td>
                        <input type='number' style="width: 100px" id='precio_oficial${index}' name='precio_oficial[]' ondblclick="copy(${index})" class="precio_oficial${index} form-control inp" readonly data-toggle="tooltip" title="Doble click (Copiar)" />
                    </td>
                    <td>
                        <input style="width: 100px" type='number' step="0.0000001" id='precio_s_igv${index}' name='precio_s_igv[]' class="precio_s_igv monto${index} form-control" onkeyup="multi_s_igv(${index}),multi(${index})" required/>
                        <input hidden id='precio_s_igv_float${index}' name='precio_s_igv_float' class="precio_s_igv_float form-control" onkeyup="multi_s_igv(${index}),multi(${index})"/>
                    </td>
                    <td>
                        <input style="width: 100px" type='number' step="0.0000001" id='precio_c_igv${index}' name='precio_c_igv[]' class="precio_c_igv p_inp monto${index} form-control" onkeyup="multi_c_igv(${index}),multi(${index})" required/>
                    </td>
                    <td>
                        <input type='number' id='total${index}' style="width: 100px" name='total' disabled class="total form-control" required/>
                    </td>
                </tr>
            `;

            $('.tables tbody:first').append(data);
            $('#count_articles').val(index);

            setTimeout(function() {
                articlesSelect2();
                toggle();
                // console.log(`  ✓ Fila ${index} creada`);
                if (callback) callback();
            }, 400);
        }

        function cargarArticuloEnFilaManual(registro, index, callback) {
            // console.log(`  📝 Procesando fila ${index}:`, registro);

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
                // console.error('  ❌ Sin producto/servicio');
                if (callback) callback();
                return;
            }

            const articuloTexto = `${articuloId} | ${codigo} | ${codigoOriginal} | ${nombre}`;
            const selectId = index === 0 ? '#articulo' : `#articulo${index}`;

            // console.log(`  🎯 Select: ${selectId}`);
            // console.log(`  📦 Artículo: ${articuloTexto}`);

            if ($(selectId).length === 0) {
                // console.error(`  ❌ Select no existe`);
                if (callback) callback();
                return;
            }

            const option = new Option(articuloTexto, articuloTexto, true, true);
            $(selectId).append(option).trigger('change');

            // ⏰ Esperar a que ajax() termine
            setTimeout(function() {
                const descId = index === 0 ? '#descripcion0' : `#descripcion${index}`;
                const cantId = index === 0 ? '#cantidad0' : `#cantidad${index}`;
                const precioSIgvId = index === 0 ? '#precio_s_igv0' : `#precio_s_igv${index}`;

                // DESCRIPCIÓN
                if (registro.descripcion_item) {
                    $(descId).val(registro.descripcion_item);
                }

                // CANTIDAD
                $(cantId).val(registro.cantidad);

                var precio_s_igv = parseFloat(registro.precio);
                var multiplier = 100;
                var precio_s_igv_redondeo = Math.round(precio_s_igv * multiplier) / multiplier;

                $(precioSIgvId).val(precio_s_igv_redondeo);

                setTimeout(function() {
                    multi_s_igv(index);
                    multi(index);
                    // console.log(`  ✅ Fila ${index} OK`);
                    if (callback) callback();
                }, 500);

            }, 2500);
        }
    </script>

    {{-- script para manejar las renovaciones --}}
    <script>
    let calendarioMesActual = new Date();
    let fechaEmisionGlobal = new Date();

    function generarCalendarioMensual(mesOffset = 0) {
        const extraSelects = document.getElementById("extra_selects");
        const hoy = new Date();

        let fechaEmision = hoy;
        const inputFechaEmision = document.querySelector('input[name="fecha_emision"]');

        if (inputFechaEmision && inputFechaEmision.value) {
            const separador = inputFechaEmision.value.includes('/') ? '/' : '-';
            const partes = inputFechaEmision.value.split(separador);
            if (partes.length === 3) {
                fechaEmision = new Date(partes[2], partes[1] - 1, partes[0]);
            }
        }
        fechaEmisionGlobal = fechaEmision;

        if (mesOffset === 0) {
            calendarioMesActual = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        }

        const mesVista = calendarioMesActual.getMonth();
        const anioVista = calendarioMesActual.getFullYear();

        const fechaMaxima = new Date(fechaEmision);
        fechaMaxima.setDate(fechaMaxima.getDate() + 30);

        const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        const primerDiaMesAnterior = new Date(anioVista, mesVista - 1, 1);
        const ultimoDiaMesSiguiente = new Date(anioVista, mesVista + 2, 0);

        const puedeRetroceder = primerDiaMesAnterior >= new Date(fechaEmision.getFullYear(), fechaEmision.getMonth(), 1);
        const puedeAvanzar = new Date(anioVista, mesVista + 1, 1) <= fechaMaxima;

        let html = `
            <div class="calendar-container">
                <div class="calendar-header">
                    <button type="button" class="calendar-nav-btn" id="prevMonth" ${!puedeRetroceder ? 'disabled' : ''}>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M10 12L6 8l4-4"/>
                        </svg>
                    </button>
                    <h3>${meses[mesVista]} ${anioVista}</h3>
                    <button type="button" class="calendar-nav-btn" id="nextMonth" ${!puedeAvanzar ? 'disabled' : ''}>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M6 12l4-4-4-4"/>
                        </svg>
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
        for (let i = 0; i < ajusteDia; i++) {
            html += `<div class="calendar-day disabled"></div>`;
        }

        const diaHoy = hoy.getDate();
        const mesHoy = hoy.getMonth();
        const anioHoy = hoy.getFullYear();

        const diaEmision = fechaEmision.getDate();
        const mesEmision = fechaEmision.getMonth();
        const anioEmision = fechaEmision.getFullYear();

        for (let dia = 1; dia <= diasEnMes; dia++) {
            const fechaDia = new Date(anioVista, mesVista, dia);

            const esHoy = dia === diaHoy && mesVista === mesHoy && anioVista === anioHoy;
            const esFechaEmision = dia === diaEmision && mesVista === mesEmision && anioVista === anioEmision;

            const esAnteriorEmision = fechaDia < fechaEmision;
            const esPosteriorMaximo = fechaDia > fechaMaxima;
            const esDeshabilitado = esAnteriorEmision || esPosteriorMaximo;

            let clases = 'calendar-day';
            if (esDeshabilitado) {
                clases += ' disabled';
            } else {
                clases += ' selectable';
                if (esFechaEmision) clases += ' fecha-emision';
                else if (esHoy) clases += ' today';
            }

            html += `<div class="${clases}"
                        data-dia="${dia}"
                        data-mes="${mesVista + 1}"
                        data-anio="${anioVista}">${dia}</div>`;
        }

        const celdasUsadas = ajusteDia + diasEnMes;
        const filasNecesarias = Math.ceil(celdasUsadas / 7);
        const totalCeldas = filasNecesarias * 7;
        const diasVaciosFinal = totalCeldas - celdasUsadas;

        for (let i = 0; i < diasVaciosFinal; i++) {
            html += `<div class="calendar-day empty"></div>`;
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
                document.querySelectorAll('.calendar-day').forEach(el => {
                    el.classList.remove('selected');
                });

                this.classList.add('selected');

                const diaSeleccionado = parseInt(this.getAttribute('data-dia'));
                const mesSeleccionado = parseInt(this.getAttribute('data-mes'));
                const anioSeleccionado = parseInt(this.getAttribute('data-anio'));

                const fechaSeleccionada = new Date(anioSeleccionado, mesSeleccionado - 1, diaSeleccionado);

                const diffTime = fechaSeleccionada - fechaEmisionGlobal;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                document.getElementById('dia_mensual_hidden').value = diffDays;

                console.log('Fecha emisión:', fechaEmisionGlobal.toLocaleDateString());
                console.log('Fecha seleccionada:', fechaSeleccionada.toLocaleDateString());
                console.log('Días hasta vencimiento:', diffDays);
            });
        });

        const diaGuardado = document.getElementById('dia_mensual_hidden').value;
        if (diaGuardado) {
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
            }
        });

        selectFecha.addEventListener("change", function () {
            const selected = this.value;
            extraSelects.innerHTML = "";
            document.getElementById('dia_mensual_hidden').value = "";

            if (selected === "Mensual") {
                generarCalendarioMensual(0);

            } else if (selected === "Anual") {
                const selectMes = document.createElement("select");
                selectMes.name = "mes_anual";
                selectMes.id = "select_mes_anual";
                selectMes.className = "form-control mb-2";
                const meses = [
                    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ];
                meses.forEach((mes, index) => {
                    const option = document.createElement("option");
                    option.value = index + 1;
                    option.textContent = mes;
                    selectMes.appendChild(option);
                });

                const selectAnio = document.createElement("select");
                selectAnio.name = "anio_anual";
                selectAnio.id = "select_anio_anual";
                selectAnio.className = "form-control";
                for (let i = 2025; i <= 2035; i++) {
                    const option = document.createElement("option");
                    option.value = i;
                    option.textContent = i;
                    selectAnio.appendChild(option);
                }

                extraSelects.append(selectMes, selectAnio);
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
            document.getElementById('dia_mensual_hidden').value = "";
        }
    }
    </script>




    {{-- @include('transaccpion.venta.clientes.modal_create') --}}

    @include('transaccion.venta.clientes.modal_create')
@stop
