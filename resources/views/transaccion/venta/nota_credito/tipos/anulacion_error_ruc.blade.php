@extends('layout')

@section('title', 'Nota Credito Anulacion Error Ruc')
@section('breadcrumb', 'Nota Credito Anulacion Error Ruc')
@section('breadcrumb2', 'Nota Credito Anulacion Error Ruc')
@section('href_accion', route('nota-credito.index'))
@section('value_accion', 'atras')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row ">
            <div class="col-lg-12">
                <div class="ibox">
                    {{-- <div class="ibox-content"> --}}
                    <div class="panel panel-success">
                        <div class="panel-heading text-center">
                            <h2><strong>{{ $facturacion->codigo_fac }} - Anulación por error de RUC </strong></h2>
                        </div>
                        <form action="{{ route('nota-credito.store_factura', $facturacion->id) }}"
                            enctype="multipart/form-data" method="post">
                            @csrf
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
                                                                    type="text" id="motivo" name="motivo"
                                                                    value="Anulación por error de RUC" readonly>
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
                                                        <th style="width: 5%;">N°</th>
                                                        <th style="width: 15%;">Código</th>
                                                        <th style="width: 30%;">Descripción</th>
                                                        <th style="width: 5%;">Cantidad</th>
                                                        <th style="width: 10%;">Precio Unitario</th>
                                                        {{-- <th style="width: 10%;">Nuevo Precio</th> --}}
                                                        {{-- <th style="width: 10%;">Nuevo Descuento</th> --}}
                                                        <th style="width: 10%;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <span hidden="hidden">{{ $u = 1 }} </span>
                                                    @foreach ($facturacion_registro as $e => $facturacion_registros)
                                                        <tr>
                                                            <td><input type="text" value="{{ $u++ }}"
                                                                    class="form-control" readonly name=""
                                                                    id=""></td>
                                                            @if (isset($facturacion_registros->producto_id))
                                                                <td><input type="text"
                                                                        value="{{ $facturacion_registros->producto->codigo_producto }}"
                                                                        class="form-control" readonly name=""
                                                                        id="">
                                                                </td>
                                                            @elseif(isset($facturacion_registros->servicio_id))
                                                                <td><input type="text" value="{{ $facturacion_registros->servicio->codigo_servicio }}" readonly class="form-control" name="" id="">
                                                                </td>
                                                            @endif
                                                            {{-- Cantidad --}}
                                                            <td style="display: none"><input required="required" class="form-control"
                                                                    type="text"
                                                                    id="input_cantidad_{{ $e }}"
                                                                    name="input_cantidad_{{ $e }}"
                                                                    value="{{ $facturacion_registros->cantidad }}"
                                                                    readonly></td> {{--  Cantidad Nueva --}}
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
                                                            <td><input type="text" class="form-control" value="{{ $facturacion_registros->cantidad }}" readonly name="" id=""></td>
                                                            @if ($tipo == 'factura_origi')
                                                                <td><input type="text" class="form-control" readonly value="{{ $facturacion_registros->precio_unitario_comi }}" name="" id="">
                                                                </td> {{-- Precio Unitario --}}
                                                                <td style="display: none"><input required="required" class="form-control"
                                                                        type="text"
                                                                        id="input_precio_{{ $e }}"
                                                                        name="input_precio_{{ $e }}"
                                                                        value="{{ $facturacion_registros->precio_unitario_comi }}"
                                                                        readonly></td> {{--  Nuevo Precio --}}
                                                            @else
                                                                <td><input type="text" class="form-control" value="{{ $facturacion_registros->precio }}" readonly name="" id=""></td>
                                                                {{-- Precio Unitario --}}
                                                                <td style="display: none"><input required="required" class="form-control"
                                                                        type="text"
                                                                        id="input_precio_{{ $e }}"
                                                                        name="input_precio_{{ $e }}"
                                                                        value="{{ $facturacion_registros->precio }}"
                                                                        readonly></td> {{--  Nuevo Precio --}}
                                                            @endif
                                                            <td style="display: none"><input required="required" class="form-control"
                                                                    type="text"
                                                                    id="input_descuento_{{ $e }}"
                                                                    name="input_descuento_{{ $e }}"
                                                                    value="0" readonly></td>
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


    <script>
        var estado = 1;
    </script>
@endsection
