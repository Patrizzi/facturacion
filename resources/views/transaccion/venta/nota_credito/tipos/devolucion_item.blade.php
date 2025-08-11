@extends('layout')

@section('title', 'Nota Credito Devolucion por Item')
@section('breadcrumb', 'Nota Credito Devolucion por Item')
@section('breadcrumb2', 'Nota Credito Devolucion por Item')
@section('href_accion', route('nota-credito.index'))
@section('value_accion', 'atras')

@section('content')

    <div class="wrapper wrapper-content">
        <div class="row animated fadeInDown">
            <div class="col-lg-12">
                <div class="ibox">
                    {{-- <div class="ibox-content"> --}}
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h2><strong>{{ $facturacion->codigo_fac }} - Devolución por Item</strong></h2>
                            </div>
                            <form action="{{ route('nota-credito.store_factura', $facturacion->id) }}"
                                enctype="multipart/form-data"method="post">
                                @csrf
                                <input type="hidden" name="tipo" value="{{$tipo}}">
                                <div class="col-lg-12">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            <!--Datos Generales -->
                                            <div class="panel panel-success">
                                                {{-- <div class="panel-heading">
                                                    <h3 class="text-center"><strong>Datos Generales</strong></h3>
                                                </div> --}}
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-sm-4 col-form-label"><strong>Cliente:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        value="@if (isset($facturacion->cliente_id)) {{ $facturacion->cliente->nombre }}
                                                                        @else{{ $facturacion->cotizacion->cliente->nombre }} @endif"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-sm-4 col-form-label"><strong>Condiciones:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        value="@if (isset($facturacion->cliente_id)) {{ $facturacion->forma_pago->nombre }}
                                                                        @else{{ $facturacion->cotizacion->forma_pago->nombre }} @endif"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">
                                                                    <strong>
                                                                    @if($facturacion->cliente->documento_identificacion == 'RUC') RUC: @else DNI: @endif
                                                                    </strong>
                                                                </label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        value="@if (isset($facturacion->cliente_id)) {{ $facturacion->cliente->numero_documento }}
                                                                        @else{{ $facturacion->cotizacion->cliente->numero_documento }} @endif"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-sm-4 col-form-label"><strong>Tipo:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        value="@if (isset($facturacion->cliente_id)) {{ $facturacion->moneda->nombre }}
                                                                        @else{{ $facturacion->cotizacion->moneda->nombre }} @endif"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group-last row">
                                                                <label
                                                                    class="col-sm-2 col-form-label"><strong>Dirección:</strong></label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control"
                                                                        value="@if (isset($facturacion->cliente_id)) {{ $facturacion->cliente->direccion }}
                                                                        @else{{ $facturacion->cotizacion->cliente->direccion }} @endif"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Condiciones Generales -->
                                            <div class="panel panel-success">
                                                {{-- <div class="panel-heading">
                                                    <h3 class="text-center"><strong>Condiciones Generales</strong></h3>
                                                </div> --}}
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"><strong>Orden de
                                                                        Compra:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $facturacion->orden_compra }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"><strong>Guía de
                                                                        Remisión:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $facturacion->guia_remision }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label
                                                                    class="col-sm-4 col-form-label"><strong>Tipo:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input required="required" class="form-control"
                                                                        type="text" id="motivo" name=""
                                                                        value="Devolución por Item" readonly>
                                                                    <input type="hidden" name="motivo" value="{{$tipo_nota_credito}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"><strong>Motivo o
                                                                        Sustento:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input required="required" class="form-control"
                                                                        type="text" id="sustento" name="sustento"
                                                                        value="{{ $sustento }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"><strong>Fecha de
                                                                        Inicio:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" name="fecha_emision"
                                                                        id="fecha_emision" value="{{ $fecha_emision }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"><strong>Fecha de
                                                                        Vencimiento:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" name="fecha_emision"
                                                                        id="fecha_emision" value="{{ $fecha_emision }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"><strong>Descuento
                                                                        Global:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input required="required" class="form-control"
                                                                        type="text" id="descuento_global"
                                                                        name="descuento_global"
                                                                        value="{{ $descuento_global }}" readonly />
                                                                </div>
                                                            </div>
                                                            <div class="form-group-last row">
                                                                <label class="col-sm-4 col-form-label"><strong>Nueva
                                                                        Factura Electronica:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input required="required" class="form-control"
                                                                        type="text" id="nueva_factura"
                                                                        name="nueva_factura" value="{{ $nueva_factura }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Tabla-->
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr
                                                            style="background-color: #1c84c6; color: white; text-align: center;">
                                                            <th>Acción</th>
                                                            <th>N°</th>
                                                            <th>Código</th>
                                                            <th>Descripcion</th>
                                                            <th style="width:30px">Cantidad</th>
                                                            <th>Precio U.</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <span hidden="hidden">{{ $u = 1 }} </span>
                                                        @foreach ($facturacion_registro as $e => $facturacion_registros)
                                                            <tr>
                                                                <td style="text-align: center">
                                                                    <button class="btn e btn-danger delete_item"
                                                                        type="button"><i
                                                                            class="fa fa-trash"></i></button>
                                                                </td>
                                                                <td>{{ $u++ }}</td>
                                                                @if (isset($facturacion_registros->producto_id))
                                                                    <td>{{ $facturacion_registros->producto->codigo_producto }}
                                                                        <input type="hidden" name="tipo_afec[]"
                                                                            id="tipo_afec{{ $e }}"
                                                                            value="{{ $facturacion_registros->producto->tipo_afec_i_producto->informacion }}">
                                                                        <input type="hidden" name="tipo_item[]"
                                                                            value="producto | {{ $facturacion_registros->producto_id }}">
                                                                        <input hidden="hidden" class="celda">
                                                                    </td>
                                                                @elseif(isset($facturacion_registros->servicio_id))
                                                                    <td>{{ $facturacion_registros->servicio->codigo_servicio }}
                                                                        <input type="hidden" name="tipo_afec[]"
                                                                            id="tipo_afec{{ $e }}"
                                                                            value="{{ $facturacion_registros->servicio->tipo_afec_i_serv->informacion }}">
                                                                        <input type="hidden" name="tipo_item[]"
                                                                            value="servicio | {{ $facturacion_registros->servicio_id }}">
                                                                        <input hidden="hidden" class="celda">
                                                                    </td>
                                                                @endif

                                                                <td>
                                                                    @if (isset($facturacion_registros->producto_id))
                                                                        <input required="required" class="form-control"
                                                                            type="text"
                                                                            id="input_descripcion_{{ $e }}"
                                                                            name="input_descripcion[]"
                                                                            value="{{ $facturacion_registros->producto->nombre }}"
                                                                            hidden>
                                                                        <p>{{ $facturacion_registros->producto->nombre }}
                                                                        </p>
                                                                        {{-- Cambiar po select2 --}}
                                                                    @elseif(isset($facturacion_registros->servicio_id))
                                                                        <input required="required" class="form-control"
                                                                            type="text"
                                                                            id="input_descripcion_{{ $e }}"
                                                                            name="input_descripcion[]"
                                                                            value="{{ $facturacion_registros->servicio->nombre }}"
                                                                            hidden>
                                                                        <p>{{ $facturacion_registros->servicio->nombre }}
                                                                        </p>
                                                                        {{-- Cambiar po select2 --}}
                                                                    @endif
                                                                </td>
                                                                {{-- <td>{{$facturacion_registros->cantidad}}</td> Cantidad --}}
                                                                <td><input required="required" class="form-control"
                                                                        type="number"
                                                                        id="input_cantidad_{{ $e }}"
                                                                        name="input_cant[]"
                                                                        value="{{ $facturacion_registros->cantidad }}"
                                                                        max="{{ $facturacion_registros->cantidad }}"
                                                                        onkeyup="multi({{ $e }})"></td>
                                                                {{-- Cantidad Nueva --}}
                                                                @if ($tipo == 'factura_origi')
                                                                    <td><input class="form-control"
                                                                            value="{{ $facturacion_registros->precio_unitario_comi }}"
                                                                            type="text"
                                                                            id="input_precio_{{ $e }}"
                                                                            max="{{ $facturacion_registros->precio_unitario_comi }}"
                                                                            onkeyup="multi({{ $e }})"
                                                                            name="input_precio[]"></td>
                                                                    {{-- Precio TOTAL --}}
                                                                    <td><input required="required" class="form-control"
                                                                            type="text"
                                                                            id="input_precio_tot_{{ $e }}"
                                                                            name="input_precio_tot"
                                                                            value="{{ $facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad }}"
                                                                            readonly
                                                                            max="{{ $facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad }}"
                                                                            onkeyup="multi({{ $e }})">
                                                                        <input type="text"
                                                                            id="afectacion_{{ $e }}"
                                                                            name="afectacion" class="form-control"
                                                                            hidden="" required autocomplete="off"
                                                                            value="{{ $facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad }}" />
                                                                    </td>
                                                                @else
                                                                    <td><input type="text" class="form-control"
                                                                            value="{{ $facturacion_registros->precio }}"
                                                                            max="{{ $facturacion_registros->precio }}"
                                                                            id="input_precio_{{ $e }}"
                                                                            name="input_precio[]" onkeyup="multi({{$e}})"></td>
                                                                    {{-- Precio TOTAL --}}
                                                                    <td><input required="required" class="form-control"
                                                                            type="text"
                                                                            id="input_precio_tot_{{ $e }}"
                                                                            name="input_precio_tot"
                                                                            value="{{ $facturacion_registros->precio * $facturacion_registros->cantidad }}"
                                                                            max="{{ $facturacion_registros->precio * $facturacion_registros->cantidad }}"
                                                                            readonly>
                                                                        <input type="text"
                                                                            id="afectacion_{{ $e }}"
                                                                            name="afectacion" class="form-control"
                                                                            hidden="" required autocomplete="off"
                                                                            value="{{ $facturacion_registros->precio * $facturacion_registros->cantidad }}" />
                                                                    </td>
                                                                @endif
                                                                <td style="display: none">
                                                                    {{ $sub_total = $facturacion_registros->factura_ids->op_gravada + $facturacion_registros->factura_ids->op_inafecta + $facturacion_registros->factura_ids->op_exonerada }}
                                                                    {{ $sub_total_gravado = $facturacion_registros->factura_ids->op_gravada }}
                                                                    {{ $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100 }}
                                                                    {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tbody>
                                                        <tr style="background-color: #f5f5f500;" align="center">
                                                            <td colspan="5"></td>
                                                            <td> <strong>Subtotal :</strong></td>
                                                            <td colspan="">
                                                                @if ($tipo == 'factura_origi')
                                                                    <input id='sub_total' disabled="disabled"
                                                                        class="form-control" required
                                                                        value="{{ $sub_total }}" />
                                                                    <input id='subtotal_gravado' disabled="disabled"
                                                                        hidden="" class="form-control" required />
                                                                @else
                                                                    <input id='sub_total' disabled="disabled"
                                                                        class="form-control" required
                                                                        value="{{ $sub_total }}" />
                                                                    <input id='subtotal_gravado' disabled="disabled"
                                                                        hidden="" class="form-control" required />
                                                                @endif
                                                                <input id='subtotal_gravado' disabled="disabled"
                                                                    hidden="" class="form-control" required />
                                                            </td>
                                                        </tr>
                                                        <tr style="background-color: #f5f5f500;" align="center">
                                                            <td colspan="5"></td>
                                                            <td> <strong>IGV :</strong></td>
                                                            <td colspan=""><input id='igv' disabled="disabled"
                                                                    class="form-control" required
                                                                    value="{{ round($igv_p, 2) }}" />
                                                            </td>
                                                        </tr>
                                                        <tr align="center">
                                                            <td colspan="5"></td>
                                                            <td> <strong>Total :</strong></td>
                                                            <td colspan=""><input id='total_final'
                                                                    disabled="disabled" class="form-control" required
                                                                    value="{{ round($end, 2) }}" /></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center" style="margin-top: 20px;">
                                                <button type="submit" class="btn btn-success">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>

    <style> 
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
        h2{
            margin-top: 5px;
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
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script>
        // var estado = 1;
        // $('.select2').select2();

        // function change_variables(val) {
        //     var cantidad = $(`#input_cantidad_` + val).val();
        //     var precio = $(`#input_precio_` + val).val();
        //     console.log(cantidad)
        // }

        function multi(a) {
            var total = 1;
            var totales = 0;
            var change = false; //
            // $(`.monto${a}`).each(function() {
            //     if (!isNaN(parseFloat($(this).val()))) {
            //         change = true;
            //         total *= parseFloat($(this).val());
            //     }
            // });
            // total = (change) ? total : 0;

            var cantidad = document.querySelector(`#input_cantidad_${a}`).value;
            var precio = document.querySelector(`#input_precio_${a}`).value;
            var afec = document.querySelector(`#tipo_afec${a}`).value;
            var multiplier = 100;
            var igv_valor = {{ $igv->renta }};

            var end = parseFloat(precio) * cantidad;
            var final_igv_round = Math.round(end * multiplier) / multiplier;

            if (afec.includes("Gravado")) {
                document.getElementById(`afectacion_${a}`).value = final_igv_round;
            }
            // console.log(final_igv_round);

            document.getElementById(`input_precio_tot_${a}`).value = Math.round(final_igv_round * multiplier) / multiplier;

            var totalInp = $('[name="input_precio_tot"]');
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
            console.log(totalInpG);
            var multiplier3 = 100;
            var total_ttg = Math.round(total_tg * multiplier3) / multiplier3;
            // console.log(totalInpG);
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
        $(document).on('click', '.delete_item', function(event) {
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

            console.log(e);

            var totalInp = $('[name="input_precio_tot"]');
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
            console.log(totalInpG);
            var multiplier3 = 100;
            var total_ttg = Math.round(total_tg * multiplier3) / multiplier3;
            // console.log(totalInpG);
            $('#subtotal_gravado').val(total_ttg);
            console.log(total_ttg);
            var subtotal = document.querySelector(`#sub_total`).value;
            var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;

            var igv_valor = {{ $igv->renta }};

            var igv = subtotal_gravado * igv_valor / 100;
            var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            var end = parseFloat(subtotal) + igv_decimal;
            var end2 = Math.round(end * multiplier2) / multiplier2;
            console.log(igv_decimal);
            document.getElementById("igv").value = igv_decimal;
            document.getElementById("total_final").value = end2;

        });
    </script>
@endsection
