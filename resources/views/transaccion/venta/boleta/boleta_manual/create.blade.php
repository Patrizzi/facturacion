@extends('layout')
@section('title', 'Create Boleta Manual')
@section('atributo_actu', 'hidden')
@section('href_accion', route('boleta_manual.create'))
@section('value_accion', 'Agregar')
{{-- @extends('layout_agregado_rapido') --}}
@section('content')

    {{-- <div class="social-bar">
        <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o"
                aria-hidden="true"></i>Cliente</a>
    </div> --}}

    {{-- obtener errores --}}
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

    @if (Session::has('successMsg'))
        <div style="padding-top: 20px;">
            <div class="alert alert-warning">
                <a class="alert-link" href="#">
                    <li style="color: black">{{ Session::get('successMsg') }}</li>
                </a>
            </div>
        </div>
    @endif
    {{-- obtener errores --}}

    {{-- @section('form_action_modal_cliente', route('agregado_rapido.cliente_cotizado')) --}}
    {{-- @section('ruta_retorno', 'boleta_manual') --}}

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h4><strong>Generar Boleta Manual</strong></h4>
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="" href="{{ route('comprobantes.index_boleta_manual') }}">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form action="{{ route('boleta_manual.store') }}" enctype="multipart/form-data" method="post"
                    id="form_store">
                    @csrf
                    <input type="hidden" name="almacen" id="_selec" class="form-control " value="{{ $sucursal->id }}"
                        readonly="readonly">
                    <input type="hidden" id="moneda_id" class="form-control " value="{{ $moneda->id }}"
                        readonly="readonly">
                    <input type="hidden" name="" id="igv_input" value="{{ $igv->renta }}">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-4"><strong>F. Emis.:</strong></label>
                                        <div class="col-md-8">
                                            <input type="date" id="fecha_emision" name="fecha_emision"
                                                class="form-control" value="{{ date('Y-m-d') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row" id="data_1">
                                        <label class="col-form-label col-md-4"><strong>F. Venci.</strong></label>
                                        <div class="col-md-8 input-group date">
                                            <span class="input-group-addon" style="display: none">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="date" class="form-control" id="fecha_vencimiento"
                                                name="fecha_vencimiento" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
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
                            </div> --}}
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
                            <div class="form-group row">
                                <label class="col-form-label col-md-2 "><strong>Almacén:</strong></label>
                                <div class="col-sm-10">
                                    <select class="select2_demo_almacen" name="almacen_id_selec" required=""
                                        onchange="codigo_numero()">
                                        @foreach ($almacenes as $almacen)
                                            <option value="{{ $almacen->id }}">{{ $almacen->nombre }} -
                                                {{ $almacen->abreviatura }}</option>
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
                                                    class="fa fa-calendar"></i></button>
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
                                            <th>Cantidad</th>
                                            <th>P. Sugerido</th>
                                            <th>P U. </th>
                                            <th>P. U. IGV.</th>
                                            <th>Total IGV.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <button type="button" class='delete borrar e btn btn-sm btn-danger'> <i
                                                        class="fa fa-trash" aria-hidden="true"></i></button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="monto0 select2_demo_3 select_change" required=""
                                                    id="articulo" onchange="ajax(0)" autocomplete="off"></select>
                                                <textarea type='text' {{-- id='descripcion0' --}} name='descripcion_item[]' class="form-control" autocomplete="off"
                                                    style="margin-top: 5px;"></textarea>
                                                <textarea type='text' id='numero_serie0' name='numero_serie[]' class="form-control" autocomplete="off"
                                                    style="margin-top: 5px;" placeholder="N° de Serie"></textarea>
                                                <input style="min-width: 100px" hidden="" type='text'
                                                    id='tipo_afec0' name='tipo_afec[]' readonly="readonly"
                                                    class="monto0 form-control" onkeyup="multi(0)" autocomplete="off" />
                                                <input type="hidden" class="celda" name="articulo[]" id="input_prod1">
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='text' id='cantidad0'
                                                    name='cantidad[]' max="" class="monto0 form-control inp"
                                                    onkeyup="multi(0)" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='text' id='precio_oficial0'
                                                    name='precio_oficial[]' ondblclick="copy(0)"
                                                    class="precio_oficial0 form-control inp" required readonly
                                                    data-toggle="tooltip" data-placement="top"
                                                    title="Doble click (Copiar)" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' step="0.0000000000000001"
                                                    id='precio0' name='precio[]' class="monto0 form-control inp"
                                                    onkeyup="multi_s_igv(0),multi(0)" required autocomplete="off" />
                                                <input hidden type='text' id='precio_s_igv_float0'
                                                    name='precio_s_igv_float' class="precio_s_igv_float form-control"
                                                    onkeyup="multi_s_igv(0),multi(0)" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' step="0.0000000000000001"
                                                    id='precio_c_igv0' name='precio_c_igv[]'
                                                    class="precio_c_igv monto0 form-control inp"
                                                    onkeyup="multi_c_igv(0),multi(0)" required autocomplete="off" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' id='total0'
                                                    name='total' disabled="disabled" class="total form-control inp"
                                                    required autocomplete="off" />
                                            </td>
                                            <span id="spTotal"></span>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr style="background-color: #f5f5f500;" align="right">
                                            <td colspan="5"><strong>Subtotal :</strong></td>
                                            <td colspan="2">
                                                <input id='sub_total_view' type="number" name="" readonly
                                                    class="form-control inp" required />
                                                <input type="hidden" name="sub_total_sin_igv" id="sub_total">
                                                <input id='subtotal_gravado' type="text" name="subtotal_gravado"
                                                    readonly class="form-control inp" required hidden="" />
                                            </td>
                                        </tr>
                                        <tr style="background-color: #f5f5f500;" align="right">
                                            <td colspan="5"><strong>IGV :</strong></td>
                                            <td colspan="2">
                                                <input id='igv_view' type="number" disabled="disabled"
                                                    class="form-control inp" required />
                                                <input type="hidden"  name="igv" id="igv">
                                            </td>
                                        </tr>
                                        <tr align="right">
                                            <td colspan="5"><strong>Total :</strong></td>
                                            <td colspan="2">
                                                <input id='total_final_view' type="number" name=""
                                                    readonly="readonly" class="form-control inp" required />
                                                <input type="hidden" name="costo_total" id="total_final">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end mt-4">
                                {{-- <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary button-ladda" id="boton" name="boton">Guardar</button>
                                </div> --}}
                                <button data-style="zoom-out" id="boton" name="boton" class="guardar button-lada btn btn-primary btn-outline"
                                    type="button">Guardar</button>
                                <button data-style="zoom-out" class="btn btn-primary float-right button-lada" style="margin-left: 10px;"
                                    type="button" id="finalizar">Guardar y Finalizar</button>
                                <button type="submit" id="button_submit" hidden name="button_submit" value="0" ></button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal de Cuotas -->
                    <div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
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
                                        <strong style="font-size:11px">La suma de las cuotas es diferente al monto
                                            total</strong>
                                        <button type="button" class="close_model_mt close" onclick="cerrar_but_mt()"
                                            style="padding: 6;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="row_number">
                                        <div class="pago_modal row">
                                            <div class="col-sm-1">
                                                <label>Fecha:</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="date" name="fecha_pago[]" id="fecha_pago0"
                                                    class="fecha_pago form-control" min="{{ $fecha_1 }}">
                                            </div>
                                            <div class="col-sm-1">
                                                <label>Monto:</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group mb-3" style="padding-right:15px">
                                                    <div class="input-group-prepend">

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
                    <!-- Modal de Cuotas -->
                </form>
            </div>
        </div>
    </div>


    {{-- MODALES Y BOTONES FLOTANTES --}}


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


    {{-- MODALES Y BOTONES FLOTANTES --}}
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

        .slimScrollBar {
            display: none !important;
        }

        #loaderGif {
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

        .dataTables_wrapper {
            padding-bottom: 0px;
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1200px;
            }
        }

        .td-width {
            min-width: 76px !important;
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

        .table>thead:first-child>tr:first-child>th {
            vertical-align: middle;
            text-align: left;
        }

        .input-group-addon {
            height: 28px !important;
            padding-top: 6px;
        }

        .td_selected>span.select2.select2-container.select2-container--default {
            max-width: 700px !important;
            width: 30vw !important;
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

    <script type="text/javascript">
        $(".select2_demo_almacen").select2({
            placeholder: "Seleccionar Almacen",
        });
        $(".select2_operacion").select2({
            placeholder: "Seleccionar Operacion",
        });
    </script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function toggle() {
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        }
    </script>
    <script>
        // TODO Selección de cliente por medio de ajax para mostrar los datos del cliente en el formularios
        // $('').val();
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
                                tipo_pago: item.tipo_pago_id
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
        $('.select2_demo_client').on('select2:select', function(e) {
            var data = e.params.data;
            // Si el tipo de pago es desde cliente cambiar
            $('select[name="forma_pago"]').find('option[value="'+data.tipo_pago+'"]').attr("selected",true); 
        });
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
                    <button type="button" class='delete borrar e btn btn-sm btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>";
                <td class="td_selected">
                    <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})" autocomplete="off" required></select>
                    <textarea type='text' {{-- id='descripcion${i}' --}}   name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
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
                    <input type='number' style="min-width: 100px"step="0.0000000000000001"  id='precio${i}' onchange="change(${i})" name='precio[]' class="monto${i} form-control inp" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off"/>
                    <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
                </td>
                <td>
                    <input style="min-width: 100px" type='number' step="0.0000000000000001"id='precio_c_igv${i}' name='precio_c_igv[]'  class="precio_c_igv p_inp monto${i} form-control inp" onkeyup="multi_c_igv(${i}),multi(${i})" required  autocomplete="off" />
                </td>
                <td>
                    <input type='number' id='total${i}'  style="min-width: 100px"  name='total' disabled="disabled" class="total form-control inp"  required  autocomplete="off"/>
                </td>
            </tr>
        `;
            $('.tables').append(data);
            $('#count_articles').val(i);
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
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
                            almacen: 0,
                            tipo_doc: 'manual'
                        };
                    },
                    processResults: function(data) {
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
                document.getElementById(`precio0`).value = copy;
                multi_s_igv(0);
            } else {
                var copy = document.getElementById(`precio_oficial${a}`).value;
                document.getElementById(`precio${a}`).value = copy;
                multi_s_igv(a);
            }
            multi(a);
        }

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
                    if (msg.price == 0 && msg.amount == 0) {
                        // $(`#precio${a}`).val(0);
                        $(`#cantidad${a}`).val(0);
                        $(`#cantidad${a}`).attr('max', msg.amount);
                        $(`#cantidad`).attr('max', msg.amount);
                        $(`#precio_oficial${a}`).val(msg.price)
                    } else {
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
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }

        // funcion dinamica de actualizar el total a cuotas
        function actualizarSaldoRestante() {
            var total = parseFloat(document.getElementById('total_final_view').value) || 0;
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

        function multi(a) {
            var igv = 18.00;
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

            var cantidad = document.querySelector(`#cantidad${a}`).value;
            var precio = document.querySelector(`#precio${a}`).value;

            var multiplier = 100;
            var final = precio * cantidad;
            // var final_decimal = Math.round(final * multiplier) / multiplier;
            var final_decimal = final;

            document.getElementById(`precio_s_igv_float${a}`).value = final_decimal;
            var only_igv = final + (parseFloat(final) * (igv / multiplier));
            // var igv_decimal = Math.round(only_igv * multiplier) / multiplier;
            var igv_decimal = only_igv;
            document.getElementById(`total${a}`).value = igv_decimal;

            // Operacion para subtotal sin igv
            var sub_igv = $('[name="precio_s_igv_float"]');
            var sub_igv_t = 0;
            sub_igv.each(function() {
                sub_igv_t += parseFloat($(this).val());
            });
            var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
            var sub_igv_tt = sub_igv_t;
            // $('#sub_total').val(sub_igv_tt);
            document.getElementById("sub_total").value = sub_igv_tt;
            document.getElementById("sub_total_view").value = sub_igv_tt.toFixed(2);

            //OPERACION PARA CALULCAR EL IGV
            var only_igv = (parseFloat(sub_igv_tt) * (igv / multiplier))
            // var igv_decimal = Math.round(only_igv * multiplier) / multiplier;
            var igv_decimal = only_igv;
            document.getElementById("igv").value = igv_decimal;
            document.getElementById("igv_view").value = igv_decimal.toFixed(2);

            var end = igv_decimal + parseFloat(sub_igv_tt);
            // var end2 = Math.round(end * multiplier) / multiplier;
            var end2 = end;
            // Operacion para total
            var totalInp = $('[name="total"]');
            var total_t = 0;
            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });
            // console.log(total_t);
            var multiplier2 = 100;
            // var total_tt = Math.round(total_t * multiplier2) / multiplier2;
            var total_tt = total_t;

            $('#total').val(total_tt);

            // var subtotal = document.querySelector(`#total`).value;
            document.getElementById("total_final").value = total_tt;
            document.getElementById("total_final_view").value = total_tt.toFixed(2);


            var monto_c = document.getElementsByClassName('monto_pago');

            var inp_mont = document.getElementsByClassName('monto_pago').length;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var fin = (end2 / inp_mont)
                document.getElementById("monto_pago0").value = Math.round(total_tt * multiplier) / multiplier;
            }
            $("#cuotas_footer").html(total_tt.T);
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
                // $(".borrar").prop("disabled", false);
                $(".addmore").prop("disabled", false);
            } else {
                // $(".borrar").prop("disabled", true);
                $(".addmore").prop("disabled", false);
                $(".select2_demo_3").val(null).trigger("change");
                $(".inp").val(null);

            }
            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            // var total_tt = Math.round(total_t * multiplier2) / multiplier2;
            var total_tt = total_t;

            $('#sub_total').val(total_tt);

            var igv_valor = $('#igv_input').val();
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv = subtotal * igv_valor / 100;

            // var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            var igv_decimal = igv;
            var end = igv_decimal + parseFloat(subtotal);

            // var end2 = Math.round(end * multiplier2) / multiplier2;
            var end2 = end;

            document.getElementById("igv").value = igv_decimal;
            document.getElementById("sub_total").value = subtotal;

            var end = parseFloat(igv_decimal) + parseFloat(subtotal);
            // var end3 = Math.round(end * multiplier2) / multiplier2;
            var end3 = end;
            document.getElementById("total_final").value = end3;

            var monto_c = document.getElementsByClassName('monto_pago');

             actualizarSaldoRestante();
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var fin = (end2 / inp_mont)
                document.getElementById("monto_pago0").value = Math.round(end2 * multiplier2) / multiplier2;
                $("#cuotas_footer").html(Math.round(end2 * multiplier2) / multiplier2);
                 actualizarSaldoRestante();
            }
            resetModalCuotas()
            articlesSelect2();
        });

        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

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

        var total = document.getElementById('total_final').value;
        var x = 1;
        $(".add_pago").on('click', function() {
            var total = document.getElementById('total_final').value;
            var data = `
                <div class="delete_modal${x} row">
                    <div class="col-sm-1"><label>Fecha:</label></div>
                        <div class="col-sm-4">
                        <input type="date" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" min="{{ $fecha_1 }}" >
                    </div>
                    <div class="col-sm-1"><label>Monto:</label></div>
                    <div class="col-sm-4">
                        <div class="input-group mb-3" style="padding-right:15px">
                            <div class="input-group-prepend">

                            </div>
                            <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}"   onkeypress="return filterFloat(event,this);" >
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label ><button type="button"  class="xd btn btn-danger" onclick="eliminar(${x})"><i class="fa fa-trash-o fa-lg" > </i></button></label>
                    </div>
                </div>
            `;
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

        $(document).on('click', '#button_cuotas_save', function(event) {

            var monto_c = document.getElementsByClassName('monto_pago');
            var monto_fc = document.getElementsByClassName('fecha_pago');
            console.log(monto_c);
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            // se usta el total real de la boleta manual, mas no el dinamico
            var total = parseFloat(document.getElementById('total_final').value) || 0;
            console.log(total);

            var fin = 0;
            var comp = 0;
            for (var i = 0; i < inp_mont; i++) {
                fin = parseFloat(fin) + parseFloat(monto_c[i].value);
            }
            var fin_r = Math.round(fin * 100) / 100;
            console.log(fin_r);

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
            }

            if (fin_r != total) {
                document.getElementById('suma_campos').style.display = "flex";
            } else {
                console.log('e')
                $('#cuotas_modal').modal('hide')
            }
            mostrarMensaje();

        });

        function mostrarMensaje() {
            // $("#alert_campos").show(200);
            $("#alert_campos").hide(3000);
            $("#suma_campos").hide(3000);
        }

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

        $("#boton").on("click", function(event) {
            event.preventDefault();

            var l = Ladda.create(document.querySelector('.button-lada'));
            var forma_pago = $("#forma_pago option:selected").val();

            if (forma_pago == 2) {
                var monto_c = document.getElementsByClassName('monto_pago');
                var monto_fc = document.getElementsByClassName('fecha_pago');
                var inp_mont = document.getElementsByClassName('monto_pago').length;

                var total = parseFloat(document.getElementById('total_final').value) || 0;

                var fin = 0.00;

                for (var i = 0; i < inp_mont; i++) {
                    var valor = parseFloat(monto_c[i].value) || 0;
                    fin = fin + valor;
                }
                var fin_r = Math.round(fin * 100) / 100;
                var total_r = Math.round(total * 100) / 100;

                var camposVacios = false;
                for (var i = 0; i < inp_mont; i++) {
                    var fecha = monto_fc[i].id;
                    var monto = monto_c[i].id;

                    var input_text = document.getElementById(`${monto}`).value;
                    var date_text = document.getElementById(`${fecha}`).value;

                    if (input_text.length == 0 || date_text.length == 0) {
                        camposVacios = true;
                        $('#cuotas_modal').modal('show');
                        document.getElementById('alert_campos').style.display = "flex";
                        setTimeout(mostrarMensaje, 3000);
                        break;
                    }
                }

                if (camposVacios) {
                    return;
                }

                if (fin_r != total_r) {
                    // console.log('Las sumas no coinciden:', 'Calculada:', fin_r, 'Esperada:', total_r);
                    $('#cuotas_modal').modal('show');
                    document.getElementById('suma_campos').style.display = "flex";
                    setTimeout(mostrarMensaje, 3000);
                    return;
                }

                var form = document.getElementById('form_store');
                if (form && !form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                l.start();

                if (form) {
                    $("#boton").off("click");
                    form.submit();
                } else {
                    var submitBtn = document.getElementById('button_submit');
                    if (submitBtn) {
                        submitBtn.click();
                    }
                }

            } else {
                var form = document.getElementById('form_store');
                if (form && !form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                l.start();

                if (form) {
                    $("#boton").off("click");
                    form.submit();
                } else {
                    var submitBtn = document.getElementById('button_submit');
                    if (submitBtn) {
                        submitBtn.click();
                    }
                }
            }
        });
         $("#finalizar").on("click", function(event) {
            event.preventDefault();

            var l = Ladda.create(document.querySelector('.button-lada'));
            var forma_pago = $("#forma_pago option:selected").val();

            if (forma_pago == 2) {
                var monto_c = document.getElementsByClassName('monto_pago');
                var monto_fc = document.getElementsByClassName('fecha_pago');
                var inp_mont = document.getElementsByClassName('monto_pago').length;

                var total = parseFloat(document.getElementById('total_final').value) || 0;

                var fin = 0.00;

                for (var i = 0; i < inp_mont; i++) {
                    var valor = parseFloat(monto_c[i].value) || 0;
                    fin = fin + valor;
                }
                var fin_r = Math.round(fin * 100) / 100;
                var total_r = Math.round(total * 100) / 100;

                var camposVacios = false;
                for (var i = 0; i < inp_mont; i++) {
                    var fecha = monto_fc[i].id;
                    var monto = monto_c[i].id;

                    var input_text = document.getElementById(`${monto}`).value;
                    var date_text = document.getElementById(`${fecha}`).value;

                    if (input_text.length == 0 || date_text.length == 0) {
                        camposVacios = true;
                        $('#cuotas_modal').modal('show');
                        document.getElementById('alert_campos').style.display = "flex";
                        setTimeout(mostrarMensaje, 3000);
                        break;
                    }
                }

                if (camposVacios) {
                    return;
                }

                if (fin_r != total_r) {
                    // console.log('Las sumas no coinciden:', 'Calculada:', fin_r, 'Esperada:', total_r);
                    $('#cuotas_modal').modal('show');
                    document.getElementById('suma_campos').style.display = "flex";
                    setTimeout(mostrarMensaje, 3000);
                    return;
                }

                var form = document.getElementById('form_store');
                if (form && !form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                l.start();

                if (form) {
                    $("finalizar").off("click");
                    form.submit();
                } else {
                    var submitBtn = document.getElementById('button_submit');
                    if (submitBtn) {
                        submitBtn.click();
                    }
                }

            } else {
                var form = document.getElementById('form_store');
                if (form && !form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                l.start();

                if (form) {
                    $("#finalizar").off("click");
                    form.submit();
                } else {
                    var submitBtn = document.getElementById('button_submit');
                    if (submitBtn) {
                        submitBtn.click();
                    }
                }
            }
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

        function cerrar_but_rc() {
            document.getElementById('alert_campos').style.display = "none";
        }

        function cerrar_but_mt() {
            document.getElementById('suma_campos').style.display = "none";
        }

        var igv = $('#igv_input').val();
        var multiplier = 100;

        function multi_s_igv(a) {
            var pr_s_igv = $(`#precio${a}`).val();
            $(`#precio_s_igv_float${a}`).val(pr_s_igv);
            var c_igv_s_redondeo = parseFloat(pr_s_igv) + (parseFloat(pr_s_igv) * igv / multiplier);
            // var c_igv_redondeo = Math.round(c_igv_s_redondeo * multiplier) / multiplier;
            var c_igv_redondeo = c_igv_s_redondeo;
            $(`#precio_c_igv${a}`).val(c_igv_redondeo);
        }

        function multi_c_igv(a) {
            var pr_c_igv = $(`#precio_c_igv${a}`).val();
            var igv_dec = igv / multiplier;
            var s_igv_s_base = parseFloat(pr_c_igv) / (1 + parseFloat(igv_dec));
            // var s_igv_redondeo = Math.round(s_igv_s_base * multiplier) / multiplier;
            var s_igv_redondeo = s_igv_s_base;
            $(`#precio${a}`).val(s_igv_redondeo);
            $(`#precio_s_igv_float${a}`).val(s_igv_redondeo);
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
            console.log(almacen);
            $.ajax({
                type: "post",
                url: "{{ route('boleta_manual.change_almacen_tipo') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'almacen': almacen,
                },
                success: function(msg) {
                    $('#codigo_bola_manual').html(msg)
                }
            })
        }

        function mostrarMensaje() {
            // $("#alert_campos").show(200);
            $("#alert_campos").hide(3000);
            $("#suma_campos").hide(3000);
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
                url: "{{ route('pa.search_multiple_manual') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': busqueda,
                    'almacen': almacen,
                    'moneda': moneda
                },
                success: function(msg) {
                    // console.log(data.mone)
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
                    var igv = $('#igv_input').val();
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
                                data: null,
                                title: 'CANTIDAD',
                                render: function(data, type, row, meta) {
                                    return `<input type="number" class="form-control form-control-sm input-cantidad" min="1" max="${row.stock}" value="1" data-price="${row.price}" data-id="${row.id}" />`;

                                }
                            },
                            {
                                data: 'price',
                                title: 'PRECIO S. C / IGV',
                                render: function(data, type, row) {
                                    const simbolo = row.moneda
                                        .simbolo; // Obtén el símbolo de la moneda
                                    const formattedPrice = $.fn.dataTable.render.number(',',
                                        '.', 2).display(data); // Formatea el precio
                                    return `${simbolo} ${formattedPrice}`; // Retorna el precio con el símbolo
                                }
                            },
                            {
                                data: 'price',
                                title: 'PRECIO S / IGV',
                                render: function(data, type, row) {
                                    const simbolo = row.moneda.simbolo;
                                    const formattedPrice = $.fn.dataTable.render.number(',',
                                        '.', 2).display(data); // Formatea el precio
                                    return `
                                        <div class="input-group input-group-sm" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon" id="basic-addon3">${simbolo}</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm total_s_igv" value="${formattedPrice}" id="precio_s_igv${row.id}" data-id="${row.id}">
                                        </div>
                                    `;
                                }
                            },
                            {
                                data: 'price',
                                title: 'PRECIO  C / IGV',
                                render: function(data, type, row) {
                                    const simbolo = row.moneda.simbolo;
                                    const formattedPrice = $.fn.dataTable.render.number(',',
                                        '.', 2).display(data); // Formatea el precio
                                    return `
                                         <div class="input-group input-group-sm" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon" >${simbolo}</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm total_c_igv" value="${formattedPrice}" id="precio_c_igv${row.id}" data-id="${row.id}">
                                        </div>
                                    `; // Retorna el precio con el símbolo
                                }
                            }
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

        // PRECIO SIN IGV
        $('.data_table_multiple').on('input', '.total_s_igv', function() {
            console.log($(this));
            const id = $(this).data('id');
            const price = parseFloat($(`#precio_s_igv${id}`).val());
            var simbolo = $('#basic-addon3').html();

            var igv = $('#igv_input').val();
            const precio_c_gv = price + (price * (igv / 100));
            $(`#precio_c_igv${id}`).val(`${precio_c_gv.toFixed(2)}`);
        });
        // PRECIO SIN IGV
        $('.data_table_multiple').on('input', '.total_c_igv', function() {
            console.log($(this));
            const id = $(this).data('id');
            const price = parseFloat($(`#precio_c_igv${id}`).val());
            var simbolo = $('#basic-addon3').html();

            var igv = $('#igv_input').val();
            const precio_s_igv = price / (1 + (igv / 100));
            $(`#precio_s_igv${id}`).val(`${precio_s_igv.toFixed(2)}`);
        });

        $('.data_table_multiple').on('click', 'tbody > tr', function(e) {
            if ($(e.target).is('input') || $(e.target).closest('td').index() === 3 || $(e.target).closest('td')
                .index() === 5 || $(e.target).closest('td').index() === 6) {
                return;
            }
            var cantidad = $(this).find('.input-cantidad').val();
            var precio_s_igv = $(this).find('.total_s_igv').val();

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
                    $(`#precio0`).val(precio_s_igv);
                    multi_s_igv(0);
                    multi(0);
                    console.log("se cambio de cantidad");
                    resetModalCuotas()
                }, 1000);
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
                    $(`#precio${count_artc}`).val(precio_s_igv);
                    multi_s_igv(`${count_artc}`);
                    multi(`${count_artc}`);
                    console.log("se cambio de cantidad")
                    resetModalCuotas()
                }, 1000);
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
    @include('transaccion.venta.clientes.modal_create')
@endsection
