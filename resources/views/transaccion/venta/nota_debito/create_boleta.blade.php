@extends('layout')

@section('title', 'Nota Debito Boleta')
@section('breadcrumb', 'Nota Debito Boleta')
@section('breadcrumb2', 'Nota Debito Boleta')
@section('href_accion', route('nota-debito.index'))
@section('value_accion', 'atras')

@section('content')

    <div class="wrapper wrapper-content">
        <div class="row animated fadeInDown">
            <div class="col-lg-12">
                <div class="ibox">
                    {{-- <div class="ibox-content"> --}}
                    <div class="panel panel-success">
                        <div class="panel-heading text-center">
                            <h2><strong>Nota de Débito de {{ $boleta->codigo_boleta }}</strong></h2>
                        </div>
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-content">
                                    <form action="{{ route('nota-debito.nota_debito_bol', $boleta->id) }}"
                                        enctype="multipart/form-data" method="post">
                                        @csrf
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
                                                                    value="@if (isset($boleta->cliente_id)) {{ $boleta->cliente->nombre }}
                                                                        @else{{ $boleta->cotizacion->cliente->nombre }} @endif"
                                                                    readonly />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><strong>Condiciones:</strong></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    value="@if (isset($boleta->cliente_id)) {{ $boleta->forma_pago->nombre }}
                                                                        @else{{ $boleta->cotizacion->forma_pago->nombre }} @endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                                                    readonly />

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><strong>RUC o
                                                                    DNI:</strong></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    value="@if (isset($boleta->cliente_id)) {{ $boleta->cliente->numero_documento }}
                                                                        @else{{ $boleta->cotizacion->cliente->numero_documento }} @endif"
                                                                    readonly />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><strong>Tipo:</strong></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    value="@if (isset($boleta->cliente_id)) {{ $boleta->moneda->nombre }}
                                                                    @else{{ $boleta->cotizacion->moneda->nombre }} @endif"
                                                                    readonly />

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-2 col-form-label"><strong>Dirección:</strong></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control"
                                                                    value="@if (isset($boleta->cliente_id)) {{ $boleta->cliente->direccion }}
                                                                        @else{{ $boleta->cotizacion->cliente->direccion }} @endif"
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
                                                                    value="{{ $boleta->orden_compra }}" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><strong>Guía de
                                                                    Remisión:</strong></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $boleta->guia_remision }}" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><strong>Tipo:</strong></label>
                                                            <div class="col-sm-8">
                                                                <select class="form-control" name="tipo">
                                                                    <option value="01">Interés por mora</option>
                                                                    <option value="02">Aumentos en el valor</option>
                                                                    <option value="03">Penalidades</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><strong>F. de
                                                                    Inicio:</strong></label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control"
                                                                    value="{{ $boleta->fecha_emision }}" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><strong>F. de
                                                                    Vencimiento:</strong></label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control"
                                                                    value="{{ $boleta->fecha_vencimiento }}" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><strong>Motivo:</strong></label>
                                                            <div class="col-sm-8">
                                                                <textarea type="textarea" name="motivo" id="mot" class="form-control" required placeholder="Descripción"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tabla-->
                                        <div class="table-responsive">
                                            <table class="table tables">
                                                <thead>
                                                    <tr
                                                        style="background-color: #3366cc; color: white; text-align: center;">
                                                        <th>Acción</th>
                                                        <th style="width: 5%">N°</th>
                                                        <th style="width: 10%">Código</th>
                                                        <th style="width: 40%;">Descripción</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio U.</th>
                                                        <th style="width: 12%;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <span hidden="hidden">{{ $u = 1 }} </span>
                                                    <span hidden="hidden"><input type="hidden" name="tipo_nota"
                                                            value="{{ $tipo }}"></span>
                                                    @foreach ($boleta_registro as $e => $boleta_registros)
                                                        <tr>
                                                            <td style="text-align: center"><input
                                                                    class="form-check-input i-checks check_2" type="checkbox"
                                                                    id="inlineCheckbox_{{ $e }}"
                                                                    name="inlineCheckbox_{{ $e }}"
                                                                    onclick="check('{{ $e }}')"></td>
                                                            <td><input type="text" value="{{ $u++ }}"
                                                                    readonly class="form-control" name=""
                                                                    id=""></td>
                                                            @if (isset($boleta_registros->producto_id))
                                                                <td><input type="text"
                                                                        value="{{ $boleta_registros->producto->codigo_producto }}"
                                                                        readonly class="form-control" name=""
                                                                        id=""></td>
                                                                <td><input type="text"
                                                                        value="{{ $boleta_registros->producto->nombre }}"
                                                                        readonly class="form-control" name=""
                                                                        id="">
                                                                    <strong>N/S:</strong>
                                                                    {{ $boleta_registros->numero_serie }}
                                                                    <input type="hidden" name="tipo_afec[]"
                                                                        id="tipo_afec{{ $e }}"
                                                                        value="{{ $boleta_registros->producto->tipo_afec_i_producto->informacion }}">
                                                                </td>
                                                            @else
                                                                <td><input type="text"
                                                                        value="{{ $boleta_registros->servicio->codigo_producto }}"
                                                                        readonly class="form-control"></td>
                                                                <td>{{ $boleta_registros->servicio->nombre }}
                                                                    <strong>N/S:</strong>
                                                                    {{ $boleta_registros->numero_serie }}
                                                                </td>
                                                                <input type="hidden" name="tipo_afec[]"
                                                                    id="tipo_afec{{ $e }}"
                                                                    value="{{ $boleta_registros->servicio->tipo_afec_i_serv->informacion }}">
                                                            @endif
                                                            <td><input type="text" class="form-control" readonly
                                                                    value="{{ $boleta_registros->cantidad }}"
                                                                    name=""
                                                                    id="input_cantidad_{{ $e }}"></td>
                                                            @if ($tipo == 'manual')
                                                                {{-- PRECIO --}}
                                                                <td><input required="required" class="form-control"
                                                                        type="number"
                                                                        id="input_disabled_precio_{{ $e }}"
                                                                        name="input_disabled_precio_{{ $e }}"
                                                                        value="{{ $boleta_registros->precio }}"
                                                                        step="0.01" min="0.01" readonly
                                                                        onchange="multi({{ $e }})"></td>
                                                                <td><input type="text"
                                                                        value="{{ $boleta_registros->precio * $boleta_registros->cantidad }}"
                                                                        readonly class="form-control" name=""
                                                                        id="input_precio_tot_{{ $e }}">
                                                                </td>
                                                                <input type="text" id="afectacion_{{ $e }}"
                                                                    name="afectacion" class="form-control" hidden=""
                                                                    required autocomplete="off"
                                                                    value="{{ $boleta_registros->precio * $boleta_registros->cantidad }}" />
                                                            @else
                                                                {{-- PRECIO --}}
                                                                <td><input required="required" class="form-control"
                                                                        type="number"
                                                                        id="input_disabled_precio_{{ $e }}"
                                                                        name="input_disabled_precio_{{ $e }}"
                                                                        value="{{ $boleta_registros->precio_unitario_comi }}"
                                                                        step="0.01" min="0.01" readonly
                                                                        onchange="multi({{ $e }})"></td>
                                                                <td><input type="text" readonly
                                                                        value="{{ $boleta_registros->precio_unitario_comi * $boleta_registros->cantidad }}"
                                                                        class="form-control" name=""
                                                                        id="input_precio_tot_{{ $e }}">
                                                                </td>
                                                                <input type="text" id="afectacion_{{ $e }}"
                                                                    name="afectacion" class="form-control" hidden=""
                                                                    required autocomplete="off"
                                                                    value="{{ $boleta_registros->precio_unitario_comi * $boleta_registros->cantidad }}" />
                                                            @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-center" style="margin-top: 20px;">
                                            <button type="button" id="enviar_pt" class="btn btn-success ladda-button">Enviar</button>
                                            <button type="submit" id="submit_pt" style="display: none">enviar </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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

        h2 {
            margin-top: 5px;
        }

        .tr_head {
            background-color: #3366cc !important;
            color: white;
            text-align: center;
        }

        .tables {
            border: 1px solid #EBEBEB;
        }

        .tables>thead>tr>th,
        .tables>thead>tr>td {
            /* ba+ckground-color: #F5F5F6; */
            border-bottom-width: 1px;
        }

        .tables>thead>tr>th,
        .tables>tbody>tr>th,
        .tables>tfoot>tr>th,
        .tables>thead>tr>td,
        .tables>tbody>tr>td,
        .tables>tfoot>tr>td {
            border: 1px solid #e7e7e7;
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

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var estado = 1;
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('.i-checks').on('ifClicked', function(event) {
                const id = $(this).attr('id');
                console.log('Clic en:', id);
                check(id); // llamas tu función
            });

            function check(id) {
                console.log(`${id.split('_')[1]}`);
                const checkbox = document.getElementById(id);
                const input = document.getElementById(`input_disabled_precio_${id.split('_')[1]}`);

                if (!checkbox || !input) {
                    console.error("No se encontró algún elemento:", id);
                    return;
                }

                if (checkbox.value == "false") {
                    input.readOnly = true;
                    checkbox.value = "true";
                } else {
                    input.readOnly = false;
                    checkbox.value = "false";
                }
            }
        });

        function multi(a) {
            var cantidad = document.querySelector(`#input_cantidad_${a}`).value;
            var precio = document.querySelector(`#input_disabled_precio_${a}`).value;
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
        }
    </script>

    <script>
        var estado = 1;
        // function grabar(){
        $("#enviar_pt").click(function(e) {
            var hola = $('#mot').val();
            console.log(hola);

            if ($('.check_2:checked').length == 0 && $('#mot').val() == "") {
                $('#submit_pt').click();
            } else if ($('.check_2:checked').length == 0 && $('#mot').val() != "") {
                toastr.warning("Seleccionar al menos 1 producto para la Nota de Debito",
                    'Verifique si ha seleccionado al menos 1 producto', {
                        timeOut: 3000
                    });
            } else {
                $('#submit_pt').click();
            }
        });
        // }
    </script>
@endsection
