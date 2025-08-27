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
                <h4><strong>Generar Cotizacion</strong></h4>
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
                                        <label class="col-form-label col-md-4"><strong>Garantia:</strong></label>
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
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-form-label col-md-1"><strong>Observación:</strong></label>
                                <div class="col-md-11">
                                    <textarea class="form-control" name="observacion" id="observacion" rows="1">Emitimos la siguiente Cotización a vuestra solicitud</textarea>
                                </div>
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
                                                <input hidden="hidden" class="celda" name="articulo[]"
                                                    id="input_prod1">
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
                            <button data-style="zoom-out" class="guardar ladda-button btn btn-primary btn-outline"
                                type="submit">Guardar</button>
                            <button class="btn btn-primary  demo3 float-right" style="margin-left: 10px;"
                                type="button">Guardar y Finalizar</button>
                            <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden=""
                                data-style="zoom-out"></button>
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
                            <small style="padding-right: 12px;padding-left: 12px ">Filtrado por Producto o Servicio</small>
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
            console.log(parameters.id);
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
                        confirmButtonColor: "#3686ff",
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
        $(document).ready(function() {
            // Bind normal buttons
            Ladda.bind('.ladda-button', {
                timeout: 8000
            });
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
                    var tipo_coti = $('[name="tipo_coti"]:checked').val();
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
                    console.log('a');
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
    @include('transaccion.venta.clientes.modal_create')
@endsection
