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
            </div>
            <div class="ibox-content">
                <form action="{{ route('cotizacion_manual.store') }}" enctype="multipart/form-data" method="post"
                    id="form_sto" onsubmit="return valida(this)">
                    @csrf
                    @if(isset($guia->id))
                        <input type="hidden" name="guia_id" value="{{ $guia->id }}">
                    @endif
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
                                <label class="col-form-label col-md-2"><strong>Almacen:</strong></label>
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
                                            <select name="tipo_coti" id="" class="select2_tipo_coti"
                                                onchange="select_tipo()">
                                                <option value="1">Factura</option>
                                                <option value="0">Boleta</option>
                                                <option value="2">Nota de Venta</option>
                                            </select>
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
                                                    <option value="{{ $forma_pago->id }}">{{ $forma_pago->nombre }}</option>
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
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-form-label col-md-1"><strong>Observación:</strong></label>
                                <div class="col-md-11">
                                    <textarea class="form-control" name="observacion" id="observacion" rows="1"
                                        placeholder="Ingrese una observación">Emitimos la siguiente Cotizacion a vuestra solicitud</textarea>
                                </div>
                            </div>
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
                                                    <button type="button" class='addmore btn btn-sm btn-info'
                                                        style="display: none"><i class="fa fa-plus-square"
                                                            aria-hidden="true"></i></button>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#add_product_data">
                                                    <i class="fa fa-plus-square"></i>
                                                </button>
                                            </th>
                                            <th style="width: 100%">Articulo</th>
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
                                                <button type="button" class='delete borrar e btn btn-sm btn-danger'>
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="select2_demo_3 select_change" required=""
                                                    id="articulo" onchange="inputs_campos(0),ajax(0)"
                                                    name="select_articulo"></select>
                                                <textarea type='text' id='descripcion0' name='descripcion_item[]' placeholder="Descripción de Item"
                                                    class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                                                <input hidden="hidden" class="celda" name="articulo[]"
                                                    id="input_prod1">
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
                            <button class="guardar ladda-button btn btn-info " type="submit">Guardar</button>
                            <button class="btn btn-warning demo3 float-right" id="finalizar_button"
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

        .form-control {
            border-radius: 10px
        }

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

        /* .table_form {
                                width: 100%;
                                max-width: 100%;
                            }

                            .table_form td,
                            .table_form th {
                                padding: 0.75rem;
                                vertical-align: top;
                                border-top: 1px solid rgb(222 226 230);
                            } */

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
        // $(document).ready(function () {
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
            } else {
                console.log("campos incompletos");
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
    </script>
    <script>
        var i = 2;
        $(".addmore").on('click', function() {
            console.log("add");
            var data = `[
        <tr>
            <td>
                <button type="button" class='delete borrar e btn btn-sm btn-danger'>
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
                            tipo_doc: 'manual'
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

        function inputs_campos(a) {

            if (a == 0) {
                var articulo = document.getElementById(`articulo`).value;
                document.getElementById(`input_prod1`).value = articulo;

            } else {
                var articulo = document.getElementById(`articulo${a}`).value;
                document.getElementById(`input_prod${a}`).value = articulo;
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

                console.log(total_tt);
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
                    // console.log(data.mone)
                    if (validarJson(msg)) {
                    } else {
                        toastr.warning("No se encontraron resultados",
                            '', {
                                timeOut: 3000
                            });
                        return;
                    }
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
    </script>
    {{-- @include('transaccpion.venta.clientes.modal_create') --}}

    {{-- agregar articulos si existe la guia --}}
    @if (isset($guia))
        <script type="text/javascript">
            $(document).ready(function() {
                // Array para almacenar los IDs de los productos que se incluyen en la cotización
                var productosIncluidos = [];

                var clienteId = {{ $guia->cliente_id }};
                var clienteNombre = "{{ $guia->cliente->nombre }}";
                var clienteDocumento = "{{ $guia->cliente->numero_documento }}";

                var clienteData = {
                    id: clienteId,
                    text: clienteNombre + ' | ' + clienteDocumento
                };

                var newOption = new Option(clienteData.text, clienteData.id, true, true);
                $(".select2_demo_client").append(newOption).trigger('change');

                // Obtener los productos de la guía
                var detalleGuia = @json($guia->servicio_guia_ingreso->detalle_guia_ingreso);

                // Para el primer producto, usamos la fila existente
                if (detalleGuia.length > 0) {
                    // Configurar el primer producto
                    $("#descripcion0").val(detalleGuia[0].producto + " - " + detalleGuia[0].serie);
                    $("#cantidad0").val(1);

                    // Registrar este producto como incluido
                    productosIncluidos.push(detalleGuia[0].id);

                    // Agregar el ID del producto como un campo oculto
                    $("#descripcion0").after('<input type="hidden" name="producto_ids[]" value="' + detalleGuia[0].id +
                        '">');
                }

                // Si hay más productos, agregamos filas adicionales
                var filasAgregadas = 0;

                function agregarSiguienteFila(index) {
                    if (index >= detalleGuia.length) return;

                    if (index > 0) {
                        $(".addmore").click();

                        // Esperar a que la fila se agregue al DOM
                        setTimeout(function() {
                            // El índice correcto para el DOM es el valor actual de 'i' - 1
                            // Ya que 'i' se incrementa DESPUÉS de agregar la fila
                            var currentRowIndex = i - 1;

                            // Configurar esta fila
                            $("#descripcion" + currentRowIndex).val(detalleGuia[index].producto + " - " +
                                detalleGuia[index].serie);
                            $("#cantidad" + currentRowIndex).val(1);

                            // Registrar este producto como incluido
                            productosIncluidos.push(detalleGuia[index].id);

                            // Agregar el ID del producto como un campo oculto
                            $("#descripcion" + currentRowIndex).after(
                                '<input type="hidden" name="producto_ids[]" value="' + detalleGuia[index]
                                .id + '">');

                            // Asegurarse de que los cálculos se actualicen
                            multi(currentRowIndex);

                            // Continuar con el siguiente producto
                            filasAgregadas++;
                            agregarSiguienteFila(index + 1);
                        }, 500);
                    } else {
                        // Si es el primer producto (ya configurado antes), continuar con el siguiente
                        filasAgregadas++;
                        agregarSiguienteFila(index + 1);
                    }
                }

                setTimeout(function() {
                    agregarSiguienteFila(0);
                }, 300);

                // Manejar eliminación de productos
                $(document).on('click', '.borrar', function() {
                    var row = $(this).closest('tr');
                    var productoId = row.find('input[name="producto_ids[]"]').val();

                    // Remover el ID del producto de la lista de incluidos
                    if (productoId) {
                        var index = productosIncluidos.indexOf(parseInt(productoId));
                        if (index > -1) {
                            productosIncluidos.splice(index, 1);
                        }
                    }
                });

                // Agregar un campo oculto con los IDs de productos al formulario cuando se envía
                $("form").on("submit", function() {
                    // Eliminar cualquier campo previo
                    $("#productos_incluidos_ids").remove();

                    // Agregar campo oculto con los IDs
                    $(this).append(
                        '<input type="hidden" id="productos_incluidos_ids" name="productos_incluidos_ids" value="' +
                        JSON.stringify(productosIncluidos) + '">');
                });
            });
        </script>
    @endif
    @include('transaccion.venta.clientes.modal_create')
@stop
