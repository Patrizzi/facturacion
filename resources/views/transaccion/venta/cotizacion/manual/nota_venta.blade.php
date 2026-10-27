@extends('layout')
@section('title', 'Cotizacion Manual Boletear')
@section('breadcrumb', 'Cotizacion Manual Boletear')
@section('breadcrumb2', 'Cotizacion Manual Boletear')
@section('href_accion', back())
@section('value_accion', 'Inicio')

{{-- @section('button2', 'Nueva Cotización') --}}
{{-- @section('config', route('cotizacion_manual.create')) --}}

@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <form action="{{ route('cotizacion_manual.nota_venta_store') }}" enctype="multipart/form-data" method="post"
            onsubmit="return valida(this)">
            @csrf
            <input type="text" value="{{ $cotizacion->id }}" name="id_cotizador" hidden="hidden">
            <input type="text" value="{{ $cotizacion->comisionista_id }}" name="id_comisionista" hidden="hidden">
            <div class="ibox">
                <div class="ibox-title">
                    <a href="{{ route('cotizacion.show', $cotizacion->id) }}" class="no-hover-icon" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
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
                            <h3 style="margin: 0;">{{ $cod_nota_venta }}</h3>
                            <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                        </div>
                        <div class="col-12 col-md-4 text-center">
                            <h2 class="mb-0 text-nowrap" style="text-align: center">
                                COTIZACION -> NOTA DE V. M.
                            </h2>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" style="margin-top: -26px;">
                    <div class="ibox-content" style=" margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row form-label word-style">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                                    <div class="col-md-10">
                                        <input type="text" name="" class="form-control"
                                            value="{{ $cotizacion->cliente->nombre . ' - ' . $cotizacion->cliente->numero_documento }}"
                                            id="" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>F. Emision:</strong></label>
                                    <div class="col-md-10">
                                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}"
                                            readonly="readonly" name=fecha_emision>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Moneda:</strong></label>
                                    <div class="col-md-10">
                                        <input type="text" name="" class="form-control"
                                            value="{{ $cotizacion->moneda->nombre }}" id="" readonly>
                                        <input type="text" name="tipo_moneda" value="{{ $cotizacion->moneda->id }}"
                                            hidden="hidden">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Almacen:</strong></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control"
                                            value="{{ $cotizacion->almacen->nombre }}" name="almacen" readonly>
                                        <input type="hidden" value="{{ $cotizacion->almacen_id }}" name="almacen_id"
                                            id="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>F Pago:</strong></label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="forma_pago" id ="forma_pago">
                                            @foreach ($forma_pagos as $forma_pago)
                                                <option value="{{ $forma_pago->id }}"
                                                    @if ($cotizacion->forma_pago->id == $forma_pago->id) selected @endif>
                                                    {{ $forma_pago->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Garantia:</strong></label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="garantia">
                                            @foreach ($garantia as $garantias)
                                                <option value="{{ $garantias->descripcion }}">
                                                    {{ $garantias->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for=""
                                        class="col-form-label col-md-1"><strong>Observacion:</strong></label>
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
                                                <th style="width: 150px">Precio U.</th>
                                                <th style="width: 150px">Precio T.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cotizacion_registros as $index => $cotizacion_registro)
                                                {{-- @if ($validor[$index] == 1) --}}
                                                <tr>
                                                    @if (isset($cotizacion_registro->producto_id))
                                                        <td>
                                                            <input type="text" class="form-control" name=""
                                                                readonly id=""
                                                                value="{{ $cotizacion_registro->producto->codigo_producto }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name=""
                                                                readonly id=""
                                                                value="{{ $cotizacion_registro->producto->nombre }}">
                                                            <textarea class="form-control" name="descripcion_item[]" placeholder="Descripción del item" rows="1"
                                                                style="margin-top: 5px" cols="2">{{ $cotizacion_registro->descripcion_item }}</textarea>
                                                        </td>
                                                        <div style="display: none">
                                                            @if (strpos($cotizacion_registro->producto->tipo_afec_i_producto->informacion, 'Gravado') !== false)
                                                                {{ $tot_igv_unit = $cotizacion_registro->precio + $cotizacion_registro->precio * ($igv->igv_total / 100) }}
                                                            @else
                                                                {{ $tot_igv_unit = $cotizacion_registro->precio }}
                                                            @endif
                                                            <input type="hidden" value="{{ $tot_igv_unit }}"
                                                                name="articulo_tot_end[]" id="">
                                                        </div>
                                                    @else
                                                        <td>
                                                            <input type="text" class="form-control" name=""
                                                                readonly id=""
                                                                value="{{ $cotizacion_registro->servicio->codigo_servicio }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name=""
                                                                readonly id=""
                                                                value="{{ $cotizacion_registro->servicio->nombre }}">
                                                            <p> /
                                                                {{ $cotizacion_registro->servicio->descripcion }}</p>
                                                            <textarea class="form-control" name="descripcion_item[]" placeholder="Descripción del item" rows="2"
                                                                cols="2">{{ $cotizacion_registro->descripcion_item }}</textarea>
                                                        </td>
                                                        <div style="display: none">
                                                            @if (strpos($cotizacion_registro->servicio->tipo_afec_i_serv->informacion, 'Gravado') !== false)
                                                                {{ $tot_igv_unit = $cotizacion_registro->precio + $cotizacion_registro->precio * ($igv->igv_total / 100) }}
                                                            @else
                                                                {{ $tot_igv_unit = $cotizacion_registro->precio }}
                                                            @endif
                                                            <input type="hidden" value="{{ $tot_igv_unit }}"
                                                                name="articulo_tot_end[]" id="">
                                                        </div>
                                                    @endif
                                                    <td>
                                                        <input type="text" readonly class="form-control"
                                                            value="{{ $cotizacion_registro->cantidad }}" name=""
                                                            id="">
                                                        <input type="hidden"
                                                            value="{{ $cotizacion_registro->cantidad }}"
                                                            name="cantidad_art[]" id="">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" readonly
                                                            value=" {{ number_format(round($tot_igv_unit, 2), 2) }}"
                                                            name="" id="">
                                                    </td>
                                                    <td>
                                                        <input type="text" readonly
                                                            value="{{ number_format(round($tot_igv_unit * $cotizacion_registro->cantidad, 2), 2) }}"
                                                            class="form-control">
                                                    </td>
                                                    <td style="display: none">
                                                        {{ $sub_total = $cotizacion->op_gravada + $cotizacion->op_exonerada + $cotizacion->op_inafecta }}
                                                        {{ $sub_total_gravado = $cotizacion->op_gravada }}
                                                        S/.{{ $igv_p = round($sub_total_gravado, 2) * ($igv->igv_total / 100) }}
                                                        {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                                        {{ $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2) }}

                                                    </td>
                                                </tr>
                                                {{-- @endif --}}
                                            @endforeach
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td style="vertical-align: middle"><strong>Total :</strong></td>
                                                <td colspan="3">
                                                    <div class="input-group m-b">
                                                        <div class="input-group-prepend">
                                                            <span
                                                                class="input-group-addon">{{ $cotizacion->moneda->simbolo }}</span>
                                                        </div>
                                                        <input type="text" id="" name="" disabled
                                                            class="form-control limp_txt"
                                                            value="{{ number_format(round($end, 2), 2) }}">
                                                        <input type="hidden" name="total_final" id="total_final"
                                                            value="{{ round($end, 2) }}">
                                                    </div>
                                                </td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="col-sm-12" align="right">
                                <button class="btn btn-primary " style="margin-top: 5px" type="button"
                                    id="boton">Guardar</button>
                                <button type="submit" hidden id="button_submit">Guardar Hidden</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        .m-b {
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

        .detracc_campo_required,
        .retenc_campo_required {
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


    {{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
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
    <script>
        $("#boton").on(" click", function(buton) {
            document.getElementById('button_submit').click();
        });
    </script>
@endsection
