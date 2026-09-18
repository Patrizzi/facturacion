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
                    <div class="ibox-content">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h2><strong>{{ $boleta->codigo_boleta }} - Error en descripción</strong></h2>
                            </div>
                            <form action="{{ route('nota-credito.store_boleta', $boleta->id) }}"
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
                                                                        @else{{ $boleta->cotizacion->forma_pago->nombre }} @endif"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label">
                                                                    <strong>
                                                                        @if ($boleta->cliente->tipo_documento == 'RUC')
                                                                            RUC:
                                                                        @else
                                                                            DNI:
                                                                        @endif
                                                                    </strong></label>
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
                                                                    <input required="required" class="form-control"
                                                                        type="text" id="motivo" name=""
                                                                        value="Error en descripción" readonly />
                                                                    <input type="hidden" name="motivo" value="{{$tipo_nota_credito}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-4 col-form-label"><strong>Motivo o
                                                                        Sustento:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input required="required" class="form-control"
                                                                        type="text" id="sustento" name="sustento"
                                                                        value="{{ $sustento }}" readonly />
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
                                                                <label class="col-sm-4 col-form-label"><strong>Fecha de
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
                                                                        Boleta Electrónica:</strong></label>
                                                                <div class="col-sm-8">
                                                                    <input required="required" class="form-control"
                                                                        type="text" id="nueva_boleta"
                                                                        name="nueva_boleta"
                                                                        value="{{ $nueva_boleta }}"readonly />
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
                                                            <th style="width: 5%;">Acción</th>
                                                            <th style="width: 5%;">N°</th>
                                                            <th style="width: 10%;">Código</th>
                                                            {{-- <th style="width: 5%;">Nueva Cantidad</th> --}}
                                                            <th style="width: 35%;">Descripción</th>
                                                            <th style="width: 5%;">Cantidad</th>
                                                            <th style="width: 10%;">Precio Unitario</th>
                                                            {{-- <th style="width: 10%;">Nuevo Precio</th> --}}
                                                            {{-- <th style="width: 5%;">Nuevo Descuento</th> --}}
                                                            <th style="width: 10%;">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <span hidden="hidden">{{ $u = 1 }} </span>
                                                        @foreach ($boleta_registro as $e => $boleta_registros)
                                                            <tr>
                                                                <td style="text-align: center"><input
                                                                        class="form-check-input i-checks" type="checkbox"
                                                                        id="inlineCheckbox_{{ $e }}"
                                                                        name="inlineCheckbox_{{ $e }}"
                                                                        onclick="check('{{ $e }}')"></td>
                                                                <td><input type="text" readonly
                                                                        value="{{ $u++ }}" class="form-control"
                                                                        name="" id=""></td>
                                                                @if (isset($boleta_registros->producto_id))
                                                                    <td><input type="text" readonly
                                                                            value="{{ $boleta_registros->producto->codigo_producto }}"
                                                                            class="form-control" name=""
                                                                            id="">
                                                                    </td>
                                                                @elseif(isset($boleta_registros->servicio_id))
                                                                    <td><input type="text" class="form-control"
                                                                            readonly
                                                                            value="{{ $boleta_registros->servicio->codigo_servicio }}"
                                                                            name="" id="">
                                                                    </td>
                                                                @endif

                                                                <td>
                                                                    @if (isset($boleta_registros->producto_id))
                                                                        <input required="required" class="form-control"
                                                                            type="text"
                                                                            id="input_descripcion_{{ $e }}"
                                                                            name="input_descripcion_{{ $e }}"
                                                                            value="{{ $boleta_registros->producto->nombre }}"
                                                                            readonly>
                                                                    @elseif(isset($boleta_registros->servicio_id))
                                                                        <input required="required" class="form-control"
                                                                            type="text"
                                                                            id="input_descripcion_{{ $e }}"
                                                                            name="input_descripcion_{{ $e }}"
                                                                            value="{{ $boleta_registros->servicio->nombre }}"
                                                                            readonly>
                                                                    @endif
                                                                </td>
                                                                {{-- Cantidad --}}
                                                                <td><input type="text" readonly
                                                                        value="{{ $boleta_registros->cantidad }}"
                                                                        class="form-control" name=""
                                                                        id=""></td>
                                                                {{-- CANTIDAD NUEVA --}}
                                                                <td style="display: none"><input required="required"
                                                                        class="form-control" type="text"
                                                                        id="input_cantidad_{{ $e }}"
                                                                        name="input_cantidad_{{ $e }}"
                                                                        value="{{ $boleta_registros->cantidad }}"
                                                                        readonly></td>
                                                                @if ($tipo == 'boleta_origi')
                                                                    <td><input type="text"
                                                                            value="{{ $boleta_registros->precio_unitario_comi }}"
                                                                            class="form-control" readonly name=""
                                                                            id=""></td>
                                                                    {{-- Precio Unitario --}}
                                                                    <td style="display: none"><input required="required"
                                                                            class="form-control" type="text"
                                                                            id="input_precio_{{ $e }}"
                                                                            name="input_precio_{{ $e }}"
                                                                            value="{{ $boleta_registros->precio_unitario_comi }}"
                                                                            readonly></td> {{-- Nuevo Precio --}}
                                                                @else
                                                                    <td><input type="text" readonly
                                                                            value="{{ $boleta_registros->precio }}"
                                                                            class="form-control" name=""
                                                                            id=""></td>
                                                                    {{-- Precio Unitario --}}
                                                                    <td style="display: none"><input required="required"
                                                                            class="form-control" type="text"
                                                                            id="input_precio_{{ $e }}"
                                                                            name="input_precio_{{ $e }}"
                                                                            value="{{ $boleta_registros->precio }}"
                                                                            readonly></td> {{-- Nuevo Precio --}}
                                                                @endif
                                                                @if ($tipo == 'boleta_origi')
                                                                    <td><input type="text"
                                                                            value="{{ $boleta_registros->precio_unitario_comi * $boleta_registros->cantidad }}"
                                                                            readonly class="form-control" name=""
                                                                            id="">
                                                                    </td> {{-- Total --}}
                                                                @else
                                                                    <td><input type="text"
                                                                            value="{{ $boleta_registros->precio * $boleta_registros->cantidad }}"
                                                                            readonly class="form-control" name=""
                                                                            id="">
                                                                    </td> {{-- Total --}}
                                                                @endif
                                                                <td style="display: none">
                                                                    {{ $sub_total = $boleta_registros->boleta_i->op_gravada + $boleta_registros->boleta_i->op_inafecta + $boleta_registros->boleta_i->op_exonerada }}
                                                                    {{ $sub_total_gravado = $boleta_registros->boleta_i->op_gravada }}
                                                                    {{ $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100 }}
                                                                    {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center" style="margin-top: 20px;">
                                                <button type="submit" class="ladda-button btn btn-success">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
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
