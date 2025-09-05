@extends('layout')

@section('title', 'Nota Credito Error en descripcion')
@section('breadcrumb', 'Nota Credito Error en descripcion')
@section('breadcrumb2', 'Nota Credito Error en descripcion')
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
                            <h2><strong>{{ $facturacion->codigo_fac }} - Error en descripcion</strong></h2>
                        </div>
                        <form action="{{ route('nota-credito.store_factura', $facturacion->id) }}"
                            enctype="multipart/form-data" method="post">
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
                                                            <label class="col-sm-4 col-form-label"><strong>
                                                                    @if ($facturacion->cliente->documento_identificacion == 'RUC')
                                                                        RUC:
                                                                    @else
                                                                        DNI:
                                                                    @endif
                                                                </strong></label>
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
                                                        <div class="form-group row">
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
                                                                    value="{{ $facturacion->orden_compra }}" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><strong>Guía de
                                                                    Remisión:</strong></label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control"
                                                                    value="{{ $facturacion->guia_remision }}" readonly />
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label
                                                                class="col-sm-4 col-form-label"><strong>Tipo:</strong></label>
                                                            <div class="col-sm-8">
                                                                <input required="required" class="form-control"
                                                                    type="text" id="motivo" name=""
                                                                    value="Error de Descripción" readonly>
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
                                                                <input class="form-control" name=""
                                                                    id="fecha_emision" value="{{ $fecha_emision }}"
                                                                    readonly />
                                                                <input type="hidden" name="fecha_emision" id="" value="{{$fecha_emision_db}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label"><strong>F. de
                                                                    Vencimiento:</strong></label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control" name="fecha_vencimiento"
                                                                    id="fecha_vencimiento" value="{{ $fecha_emision }}"
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
                                                        <div class="form-group row">
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
                                                        style="background-color: #3366cc; color: white; text-align: center;">
                                                        <th style="width: 5%;">Acción</th>
                                                        <th style="width: 5%;">N°</th>
                                                        <th style="width: 15%;">Código</th>
                                                        <th style="width: 30%;">Descripción</th>
                                                        <th style="width: 5%;">Cantidad</th>
                                                        {{-- <th style="width: 5%;">Nueva Cantidad</th> --}}
                                                        <th style="width: 10%;">Precio U.</th>
                                                        {{-- <th style="width: 10%;">Nuevo Precio</th>
                                                        <th style="width: 5%;">Nuevo Descuento</th> --}}
                                                        <th style="width: 10%;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <span hidden="hidden">{{ $u = 1 }} </span>
                                                    @foreach ($facturacion_registro as $e => $facturacion_registros)
                                                        <tr>
                                                            <td style="text-align: center"><input class="form-check-input i-checks" type="checkbox"
                                                                    id="inlineCheckbox_{{ $e }}"
                                                                    name="inlineCheckbox_{{ $e }}"
                                                                    onclick="check('{{ $e }}')"></td>
                                                            <td><input type="text" class="form-control" value="{{ $u++ }}" readonly name="" id=""></td>
                                                            @if (isset($facturacion_registros->producto_id))
                                                                <td><input type="text" class="form-control" value="{{ $facturacion_registros->producto->codigo_producto }}" readonly name="" id="">
                                                                </td>
                                                            @elseif(isset($facturacion_registros->servicio_id))
                                                                <td>{{ $facturacion_registros->servicio->codigo_servicio }}
                                                                </td>
                                                            @endif
                                                            
                                                            {{-- Cantidad --}}
                                                            <td ><input required="required" class="form-control"
                                                                    type="text"
                                                                    id="input_cantidad_{{ $e }}"
                                                                    name="input_cantidad_{{ $e }}"
                                                                    value="{{ $facturacion_registros->cantidad }}"
                                                                    readonly></td>
                                                            <td>
                                                                @if (isset($facturacion_registros->producto_id))
                                                                    <input required="required" class="form-control"
                                                                        type="text"
                                                                        id="input_descripcion_{{ $e }}"
                                                                        name="input_descripcion_{{ $e }}"
                                                                        value="{{ $facturacion_registros->producto->nombre }}"
                                                                        readonly>
                                                                @elseif(isset($facturacion_registros->servicio_id))
                                                                    <input required="required" class="form-control"
                                                                        type="text"
                                                                        id="input_descripcion_{{ $e }}"
                                                                        name="input_descripcion_{{ $e }}"
                                                                        value="{{ $facturacion_registros->servicio->nombre }}"
                                                                        readonly>
                                                                @endif
                                                            </td>
                                                            <td><input type="text" value="{{ $facturacion_registros->cantidad }}" readonly class="form-control" name="" id=""></td>
                                                            @if ($tipo == 'factura_origi')
                                                                <td>{{ $facturacion_registros->precio_unitario_comi }}
                                                                </td> {{-- Precio Unitario --}}
                                                                <td><input required="required" class="form-control"
                                                                        type="text"
                                                                        id="input_precio_{{ $e }}"
                                                                        name="input_precio_{{ $e }}"
                                                                        value="{{ $facturacion_registros->precio_unitario_comi }}"
                                                                        readonly></td> {{-- Nuevo Precio --}}
                                                            @else
                                                                <td><input type="text" class="form-control" value="{{ $facturacion_registros->precio }}" readonly name="" id=""></td>
                                                                {{-- Precio Unitario --}}
                                                                {{-- <td><input required="required" class="form-control"
                                                                        type="text"
                                                                        id="input_precio_{{ $e }}"
                                                                        name="input_precio_{{ $e }}"
                                                                        value="{{ $facturacion_registros->precio }}"
                                                                        readonly></td> Nuevo Precio --}}
                                                            @endif
                                                            {{-- <td><input required="required" class="form-control"
                                                                    type="text"
                                                                    id="input_descuento_{{ $e }}"
                                                                    name="input_descuento_{{ $e }}"
                                                                    value="0" readonly></td> --}}
                                                            {{-- Nuevo Descuento --}}
                                                            @if ($tipo == 'factura_origi')
                                                                <td><input type="text" class="form-control" value="{{ $facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad }}" readonly name="" id="">
                                                                </td> {{-- Total --}}
                                                            @else
                                                                <td><input type="text" class="form-control" readonly value="{{ $facturacion_registros->precio * $facturacion_registros->cantidad }}" name="" id="">
                                                                </td> {{-- Total --}}
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

        h2 {
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

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>

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
                const checkbox = document.getElementById(id);
                const input = document.getElementById(`input_descripcion_${id.split('_')[1]}`);

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
    </script>
@endsection
