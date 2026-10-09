 @extends('layout')

 @section('title', 'Facturar Cotización')
 @section('breadcrumb', 'Facturar')
 @section('breadcrumb2', 'Facturar')
 @section('href_accion', route('cotizacion.show', $cotizacion->id))
 @section('value_accion', 'Atrás')

 @section('content')
     {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
    <div class="wrapper wrapper-content animated fadeInRight">
        <form action="{{ route('cotizacion.facturar_store') }}" enctype="multipart/form-data" method="post"
            onsubmit="return valida(this)">
            @csrf
            <input type="text" value="{{ $cotizacion->id }}" name="id_cotizador"
                hidden="hidden">
            <input type="text" value="{{ $cotizacion->comisionista_id }}"
                name="id_comisionista" hidden="hidden">
            <div class="ibox">
                <div class="ibox-title">
                    <a href="{{ route('cotizacion.show', $cotizacion->id)}}" class="no-hover-icon" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" style="cursor: pointer;">
                        <i class="fa fa-arrow-left text-muted"></i>
                    </a>
                    <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up text-muted"></i>
                        </a>
                        <a class="" href="{{ route('ventas.cotizacion') }}">
                            <i class="fa fa-times text-muted"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 style="margin: 0;">{{ $cod_fac }}</h3>
                                <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                            </div>
                            <div class="col-12 col-md-4 text-center">
                                <h2 class="mb-0 text-nowrap" style="text-align: center">
                                    COTIZACION -> FACTURA
                                </h2>
                            </div>
                            <div class="col-md-4">
                                
                            </div>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="margin-top: -26px;">
                    <div class="ibox-content">
                        <div class="row form-label word-style">
                            <div class="col-md-6">
                                {{-- Cliente --}}
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                                    <div class="col-md-10">
                                        <input type="text" name="" class="form-control" value="{{$cotizacion->cliente->nombre.' - '.$cotizacion->cliente->numero_documento}}"  id="" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Moneda:</strong></label>
                                    <div class="col-md-10">
                                        <input type="text" name="" class="form-control" value="{{$cotizacion->moneda->nombre}}"  id="" readonly>
                                    </div>
                                </div>
                                <div class="form-group row" style="justify-content: left">
                                    <label class="col-form-label col-md-2"><strong>F. Pago:</strong></label>
                                    <div class="col-md-8" class="">
                                        <select class="form-control" name="forma_pago" id="forma_pago"
                                            onchange="seleccionado_fp()">
                                            @foreach ($forma_pagos as $forma_pago)
                                                <option value="{{ $forma_pago->id }}"
                                                    @if ($cotizacion->forma_pago_id == $forma_pago->id) selected @endif>
                                                    {{ $forma_pago->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="credito_pago" style="display: none;">
                                        <button type="button" class='cuota_modal btn btn-info' id="cuota_modal"
                                            data-toggle="modal" data-target="#cuotas_modal"><i
                                                class="fa fa-calendar"></i></button>
                                         <!-- Modal -->
                                        <div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert alert-danger alert-dismissible fade show"
                                                            role="alert" id="alert_campos" style="display: none">
                                                            <strong style="font-size:11px">Rellenar todos los
                                                                campos</strong>
                                                            <button type="button" class="close_model_rc close"
                                                                onclick="cerrar_but_rc()" style="padding: 6;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="alert alert-danger alert-dismissible fade show"
                                                            role="alert" id="suma_campos" style="display: none">
                                                            <strong style="font-size:11px">La suma de las cuotas es
                                                                diferente del monto total</strong>
                                                            <button type="button" class="close_model_mt close"
                                                                onclick="cerrar_but_mt()" style="padding: 6;">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="row_number">
                                                            <div class="pago_modal row">
                                                                <div class="col-sm-1"><label>Fecha:</label></div>
                                                                <div class="col-sm-4">
                                                                    <input type="date" name="fecha_pago[]"
                                                                        id="fecha_pago0"
                                                                        class="fecha_pago form-control"
                                                                        min="{{ $fecha_1 }}">
                                                                </div>
                                                                <div class="col-sm-1"><label>Monto:</label></div>
                                                                <div class="col-sm-4">
                                                                    <div class="input-group mb-3"
                                                                        style="padding-right:15px">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"
                                                                                id="basic-addon3">{{ $cotizacion->moneda->simbolo }}</span>
                                                                        </div>
                                                                        <input type="text" name="monto_pago[]"
                                                                            id="monto_pago0"
                                                                            class="monto_pago form-control"
                                                                            onkeypress="return filterFloat(event,this);">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label><button type="button" aria-hidden="true"
                                                                            id="add_pago"
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
                                                                <label for=""><strong>Precio Total:
                                                                        &nbsp;</strong>{{ $cotizacion->moneda->simbolo }}&nbsp;</label><label
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
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><strong>Detracción:</strong></label>
                                            <div class="col-sm-6">
                                                {{-- {{$cotizacion->precio_total}} --}}
                                                {{-- @if($) disabled @endif --}}
                                                <select class="form-control" id="detraccion" name="detraccion_value" @if($cotizacion->precio_total < 700 ) disabled @endif >
                                                    <option value="0">Desactiva</option>
                                                    <option value="1">Activa</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2" style="display: flex" id="popup_detraccion" style="">
                                                <a href="" id="button_detracc" data-toggle="modal"
                                                    style="margin: auto"><i
                                                        class="fa fa-question-circle"
                                                        style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999;pointer-events: none"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"><strong>Retención:</strong></label>
                                            <div class="col-sm-6">
                                                <input type="checkbox" name="check_retencion" id="retencion_check" class="js-switch" >
                                            </div>
                                            <div class="col-sm-2" style="display: flex" id="popup_retencion" style="">
                                                <a href="" id="button_retencion" data-toggle="modal"
                                                    data-target="#modal_retencion" style="margin: auto"><i
                                                        class="fa fa-question-circle"
                                                        style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>T. Operación </strong></label>
                                    <div class="col-md-10">
                                        <select class="select2_tipo_op" name="tipo_operacion">
                                            @foreach ($tipo_operacion as $t_op)
                                                <option value="{{ $t_op->id }}">{{ $t_op->codigo }} - {{ $t_op->informacion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Cliente --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-4"><strong>O. Compra:</strong></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="0" name="orden_compra">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-4"><strong>G. Remision:</strong></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="guia_remision" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Emision</strong></label>
                                    <div class="col-md-10">
                                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly="readonly" name=fecha_emision>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Vencimiento:</strong></label>
                                    <div class="col-md-10">
                                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-1"><strong>Observacion</strong></label>
                                    <div class="col-md-11">
                                        <textarea class="form-control" name="observacion" rows="1">{{ $cotizacion->observacion }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table tables">
                                        <thead>
                                            <tr>
                                                <th style="width: 130px">Código</th>
                                                <th>Descripcion</th>
                                                <th style="width: 110px">Cantidad</th>
                                                <th style="width: 110px">Stock </th>
                                                <th style="width: 150px">Precio U.</th>
                                                <th style="width: 150px">Precio T.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $stock_total = true;
                                            ?>
                                            @foreach ($cotizacion_registros as $index => $cotizacion_registro)
                                                <tr>
                                                    @if (isset($cotizacion_registro->producto_id))
                                                        <td>
                                                            <input type="text" class="form-control" name="" id="" value="{{ $cotizacion_registro->producto->codigo_producto }}" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" readonly value="{{ $cotizacion_registro->producto->nombre }}" name="" id="" class="form-control">
                                                            <textarea class="form-control" name="descripcion_item[]" placeholder="Descripción del item" rows="2"
                                                                cols="2" style="margin-top: 5px">{{ $cotizacion_registro->descripcion_item }}</textarea>
                                                            <input type="text" class="form-control" name="numero_serie[{{ $index }}]" placeholder="N° Serie" style="margin-top: 5px">
                                                        </td>
                                                    @else
                                                        <td>
                                                            <input type="text" class="form-control" name="" id="" value="{{ $cotizacion_registro->servicio->codigo_servicio }}" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" readonly value="{{ $cotizacion_registro->servicio->nombre }}" name="" id="" class="form-control">
                                                            <textarea class="form-control" name="descripcion_item[]" placeholder="Descripción del item" rows="2"
                                                                cols="2" style="margin-top: 5px">{{ $cotizacion_registro->descripcion_item }}</textarea>

                                                            <input type="text" class="form-control" name="numero_serie[{{ $index }}]" placeholder="N° de Serie" style="margin-top: 5px">
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <input  type="text" class="form-control" name="" id="" value="{{ $cotizacion_registro->cantidad }}" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly value="{{ $array_cantidad[$index] }}" name="" id="" class="form-control" @if($array_cantidad[$index] < $cotizacion_registro->cantidad) style="border-color: red" {{$stock_total = false}} @endif>
                                                    </td>
                                                    {{-- MODIFICAR ESTA PARTE CON LOGICA DE REPROGRAMACION PARA UN NUEVO PRODUCTO DIRECTAMENTE DESDE KARDEX --}}
                                                    <td style="display: none;">
                                                        {{ $desc_array = round($array[$index] - ($array_promedio[$index] * $cotizacion_registro->descuento) / 100, 2) }}
                                                        {{ $comis_array = round($desc_array + $desc_array * ($comi / 100), 2) }}
                                                    </td>
                                                    <td>
                                                        <div class="input-group m-b">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-addon">{{ $cotizacion->moneda->simbolo }}</span>
                                                            </div>
                                                            <input type="text" readonly class="form-control" value="{{ round($comis_array, 2) }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group m-b">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-addon">{{ $cotizacion->moneda->simbolo }}</span>
                                                            </div>
                                                            <input type="text" readonly class="form-control" value="{{ number_format(round($comis_array * $cotizacion_registro->cantidad, 2), 2) }}">
                                                        </div>
                                                    </td>

                                                    <td style="display: none">
                                                        {{ $sub_total = $cotizacion->op_gravada + $cotizacion->op_exonerada + $cotizacion->op_inafecta }}
                                                        {{ $sub_total_gravado = $cotizacion->op_gravada }}
                                                        S/.{{ $igv_p = round($sub_total_gravado, 2) * ($igv->igv_total / 100) }}
                                                        {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                                        {{ $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="vertical-align: middle">
                                                    <?php 
                                                        use Luecano\NumeroALetras\NumeroALetras;
                                                        $v = new NumeroALetras();
                                                        $letra = $v->toInvoice($end, 2);
                                                        // $end_final_point=strstr($end2, '.',false);
                                                        // $end_final=str_replace('.', '',$end_final_point);
                                                    ?>
                                                    <strong>Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $cotizacion->moneda->nombre }}</strong>
                                                    <!-- {{-- {{$end2}} --}} -->
                                                </td>
                                                <td style="vertical-align: middle"><strong>Subtotal: </strong></td>
                                                <td colspan="2">
                                                    <div class="input-group m-b">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{ $cotizacion->moneda->simbolo }}</span>
                                                        </div>
                                                        <input id='subtotal_gravado' disabled="disabled" hidden=""
                                                        class="form-control limp_txt" required value="{{ $sub_total }}" />
                                                        <input type="text" id="sub_total" name="sub_total" disabled class="form-control limp_txt"
                                                            value="{{ $sub_total }}">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td style="vertical-align: middle"><strong>Igv:</strong></td>
                                                <td colspan="2">
                                                    <div class="input-group m-b">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{ $cotizacion->moneda->simbolo }}</span>
                                                        </div>
                                                        <input type="text" id="igv_input" name="igv_input" disabled class="form-control limp_txt"
                                                        value="{{ number_format(round($igv_p, 2), 2) }}">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td style="vertical-align: middle"><strong>Total :</strong></td>
                                                <td colspan="2">
                                                    <div class="input-group m-b">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{ $cotizacion->moneda->simbolo }}</span>
                                                        </div>
                                                        <input type="text" id="" name="" disabled
                                                        class="form-control limp_txt" value="{{ number_format(round($end, 2), 2) }}">
                                                        <input type="hidden"  name="total_final" id="total_final" value="{{round($end, 2)}}">
                                                    </div>
                                                </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="col-sm-12" align="right">
                                <button class="btn btn-primary boton_submit" style="margin-top: 5px;margin-right: 8px" type="button" @if($stock_total == false) disabled @endif
                                    id="boton">
                                    <i class="fa fa-cloud-upload"></i>&nbsp;Guardar
                                </button>
                                <button type="submit" hidden id="submit_button">Guardar DB</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Detraccion --}}
            @include('transaccion.venta.cotizacion._shared.modal_detraccion')
            {{-- Retencion --}}
            @include('transaccion.venta.cotizacion._shared.modal_retencion')
        </form>
    </div>
 


    <style type="text/css">
        .word-style select,
        .word-style input,
        .word-style textarea,
        .word-style span {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
        }
        .m-b{
            margin-bottom: 0px;
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
        span.select2-container.select2-container--default.select2-container--open {
            z-index: 999999;
        }
        .detracc_campo_required, .retenc_campo_required {
            display: none;
            /* font-size: 9px; */
            color: red;
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
    <!-- TouchSpin -->
    <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    {{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}

    @if($stock_total == false)
        <script>
            $(document).ready(function() {
                toastr.error('Producto con Stock Insuficiente', '', {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    tapToDismiss: false
                });
            });
        </script>
    @endif


    <script type="text/javascript">
        $(document).ready(function() {

            $("form").keypress(function(e) {
                if (e.which == 13) {
                    setTimeout(function() {
                        e.target.value += ' | ';
                    }, 4);
                    e.preventDefault();
                }
            });

            multi_retencion();
            seleccionado_fp();
        });
    </script>
    <script>
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
    </script>
    {{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
    <script type="text/javascript">
        function most_tot() {
            var monto_0 = document.getElementById("monto_pago0").value;
            if (monto_0.length == 0) {
                var total_final = document.getElementById('total_final').value;
                document.getElementById("monto_pago0").value = total_final;
            }
        }
    </script>
 
    <script>
        var elem_2 = document.querySelector('.js-switch');
        window.switchery_2 = new Switchery(elem_2, {
            size: 'small', 
            color: '#ED5565'
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
                    <span class="input-group-text" id="basic-addon3">{{ $cotizacion->moneda->simbolo }}</span>
                </div>
                <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}" onkeypress="return filterFloat(event,this);"    >
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
    @if($cotizacion->precio_total < 700 ) 
        <script>
            switchery_2.disable();
        </script>    
    @endif
    <script type="text/javascript">
        $('#detraccion').on('change', function() {
            var selected = this.value;
            console.log(selected);
            if (selected == "1") {
                $('#modal_detraccion').modal('show');
                var inputs = document.querySelectorAll('.ipt_detrac');
                inputs.forEach(function(input) {
                    // input.setAttribute('required', 'required');
                });
                $('.select2_tipo_op').val('12').trigger('change.select2');
                var retencion_check = document.querySelector('.js-switch');
                if( retencion_check.checked == true){
                    window.switchery_2.element.click();
                }
                window.switchery_2.disable(); 
            } else {
                var inputs = document.querySelectorAll('.ipt_detrac');
                inputs.forEach(function(input) {
                    // input.removeAttribute('required');
                });
                $('.select2_tipo_op').val('1').trigger('change.select2');
                window.switchery_2.enable(); 

            }
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

            var moneda = `{{$cotizacion->moneda->id}}`;

            if (moneda == 1) { //soles
                var total = $('#total_final').val();
                var porc_det = $('#porcentaje_detc').val();
                var op_det = total * (porc_det / 100);
                var sub_zero = Math.round(op_det * 100) / 100;
                console.log(sub_zero);
                $('#tota_detra').val(sub_zero);
            } else { //dolares
                var total_dol = $('#total_final').val();

                var tipo_cam = $('#tc_paralelo').html();
                console.log(tipo_cam);
                var total = total_dol * tipo_cam;
                console.log(total);
                var porc_det = $('#porcentaje_detc').val();
                var op_det = total * (porc_det / 100);
                var sub_zero = Math.round(op_det * 100) / 100;
                console.log(sub_zero);
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
                $('#button_detracc').attr('data-target', '#modal_detraccion');
                $('#detraccion').attr('disabled', false);
            }
        });

        function multi_retencion(){
            var ret_porc = $('#porcentaje_ret').val();
            var total = $('#total_final').val();
            var op_ret = total * (parseInt(ret_porc) / 100);
            var sub_zero = Math.round(op_ret * 100) / 100;
            $('#tota_reten').val(sub_zero);
        }
        $('#porcentaje_ret').on('keyup', function() {
            multi_retencion();
        });
        // $(".delete_pago").on('click', function () {
        function eliminar(x) {
            $(`.delete_modal${x}`).remove();
            var monto_c = document.getElementsByClassName('monto_pago');
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var multiplier2 = 100;

            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var total = document.getElementById('total_final').value;
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
        $("#boton").on(" click", function(buton) {
            var l = Ladda.create(document.querySelector('.boton_submit'));
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
                    // console.log('e')
                    l.start();
                    document.getElementById('submit_button').click();
                }
                // buton.preventDefault();
            } else {
                l.start();
                document.getElementById('submit_button').click();
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
    </script>
    <script type="text/javascript">
        function seleccionado_fp() {
            var opt = $('#forma_pago').val();
            if (opt == "1") {
                // $('#consulta_p_input').prop('disabled', false);

                document.getElementById('credito_pago').style.display = "none";
                // document.getElementById('colum-col').className = "col-sm-5";
                // document.getElementById('ven_1p').style.visibility = "initial";
                // document.getElementById('ven_3p').style.visibility = "initial";
                document.getElementById('fecha_vencimiento').removeAttribute('disabled');
            } else {
                document.getElementById('credito_pago').style.display = "block";
                // document.getElementById('colum-col').className = "col-sm-3";
                // document.getElementById('ven_1p').style.visibility = "hidden";
                // document.getElementById('ven_3p').style.visibility = "hidden";
                document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var total = document.getElementById('total_final').value;
            document.getElementById("monto_pago0").value = total
            $("#cuotas_footer").html(total);
        });
    </script>
    <script>
        $(document).on('click', '#button_cuotas_save', function(event) {
            var monto_c = document.getElementsByClassName('monto_pago');
            var monto_fc = document.getElementsByClassName('fecha_pago');
            console.log(monto_c)
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
                    console.log("a");
                    document.getElementById('alert_campos').style.display = "flex";
                    setTimeout(mostrarMensaje, 3000);
                    return;
                }
            }
            if (fin_r != total) {
                document.getElementById('suma_campos').style.display = "flex";
                setTimeout(mostrarMensaje, 3000);

            } else {
                // console.log('e')
                $('#cuotas_modal').modal('hide');
            }
            mostrarMensaje();

        });

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
    </script>
 @endsection
