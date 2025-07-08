@extends('layout')

@section('title', 'Nota Credito Anulacion Error Ruc')
@section('breadcrumb', 'Nota Credito Anulacion Error Ruc')
@section('breadcrumb2', 'Nota Credito Anulacion Error Ruc')
@section('href_accion', route('nota-credito.index'))
@section('value_accion', 'atras')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12" style="margin-top: -5px;">
                <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <div class="row">
                        <div class="col-sm-4 text-left" align="left">
                            <address class="col-sm-4" align="left">
                                <img src="{{ asset('img/logos/') }}/{{ $empresa->foto }}" alt="" width="300px">
                            </address>
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4 ">
                            <div class="form-control ruc" style="height: 125px">
                                <center>
                                    <h3 style="padding-top:10px ">R.U.C : {{ $empresa->ruc }}</h3>
                                    <h2>NOTA DE CREDITO</h2>
                                    {{-- <h5> {{$facturacion->codigo_fac}}</h5> --}}
                                </center>
                            </div>
                        </div>
                    </div><br>
                    <form action="{{ route('nota-credito.store_factura', $facturacion->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3> Datos Generales</h3>
                                    <div align="left">
                                        <strong>Cliente:</strong>
                                        @if (isset($facturacion->cliente_id))
                                            {{ $facturacion->cliente->nombre }}
                                            @else{{ $facturacion->cotizacion->cliente->nombre }}
                                        @endif <br>
                                        <strong>R.U.C:</strong>
                                        @if (isset($facturacion->cliente_id))
                                            {{ $facturacion->cliente->numero_documento }}
                                            @else{{ $facturacion->cotizacion->cliente->numero_documento }}
                                        @endif <br>
                                        <strong>Direccion:</strong>
                                        @if (isset($facturacion->cliente_id))
                                            {{ $facturacion->cliente->direccion }}
                                            @else{{ $facturacion->cotizacion->cliente->direccion }}
                                        @endif <br>
                                        <strong>Condiciones de Pago:</strong>
                                        @if (isset($facturacion->cliente_id))
                                            {{ $facturacion->forma_pago->nombre }}
                                            @else{{ $facturacion->cotizacion->forma_pago->nombre }}
                                        @endif <br>
                                        <strong>Tipo de Moneda:</strong>
                                        @if (isset($facturacion->cliente_id))
                                            {{ $facturacion->moneda->nombre }}
                                            @else{{ $facturacion->cotizacion->moneda->nombre }}
                                        @endif <br>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Orden de Compra:</strong>
                                        {{ $facturacion->orden_compra }} <br>
                                        <strong>Guia de Remision:</strong>
                                        {{ $facturacion->guia_remision }} <br>
                                        <strong>Fecha Emision:</strong>
                                        {{ $fecha_emision }} <br>
                                        <input type="hidden" name="fecha_emision" id="fecha_emision"
                                            value="{{ $fecha_emision }}">
                                        <strong>Fecha de Vencimiento:</strong>
                                        {{ $fecha_emision }} <br>

                                        <strong>Tipo de nota de credito:</strong>
                                        <input required="required" class="form-control" type="text" id="motivo"
                                            name="motivo" value="{{ $tipo_nota_credito }}" readonly style="display: none">
                                        Anulacion error Ruc<br>

                                        <strong>Motivo o Sustento:</strong>
                                        <input required="required" class="form-control" type="text" id="sustento"
                                            name="sustento" value="{{ $sustento }}" readonly style="display: none">
                                        {{ $sustento }} <br>

                                        <strong>Número de la Nueva Factura Electrónica:</strong>
                                        <input required="required" class="form-control" type="text" id="nueva_factura"
                                            name="nueva_factura" value="{{ $nueva_factura }}" readonly
                                            style="display: none">
                                        {{ $nueva_factura }} <br>

                                        <strong>Descuento Global:</strong>
                                        <input required="required" class="form-control" type="text" id="descuento_global"
                                            name="descuento_global" value="{{ $descuento_global }}" readonly
                                            style="display: none">
                                        {{ $descuento_global }} <br>


                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" align="center">
                                <div class="form-control" style="border: none;height: auto">
                                    <div align="left">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Codigo Producto</th>
                                        <th style="width:30px">Cantidad</th>
                                        <th style="width:30px">Cantidad Nueva</th>
                                        <th>Descripción</th>
                                        <th>Precio unitario</th>
                                        <th>Nuevo Precio</th>
                                        <th>Nuevo Descuento</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <span hidden="hidden">{{ $u = 1 }} </span>
                                    <tr>
                                        @foreach ($facturacion_registro as $e => $facturacion_registros)
                                    <tr>
                                        <td>{{ $u++ }}</td>
                                        @if (isset($facturacion_registros->producto_id))
                                            <td>{{ $facturacion_registros->producto->codigo_producto }}</td>
                                        @elseif(isset($facturacion_registros->servicio_id))
                                            <td>{{ $facturacion_registros->servicio->codigo_servicio }}</td>
                                        @endif
                                        <td>{{ $facturacion_registros->cantidad }}</td> {{-- Cantidad --}}
                                        <td><input required="required" class="form-control" type="text"
                                                id="input_cantidad_{{ $e }}"
                                                name="input_cantidad_{{ $e }}"
                                                value="{{ $facturacion_registros->cantidad }}" readonly></td>
                                        {{-- Cantidad Nueva --}}

                                        <td>
                                            @if (isset($facturacion_registros->producto_id))
                                                <input required="required" class="form-control" type="text"
                                                    id="input_descripcion_{{ $e }}"
                                                    name="input_descripcion_{{ $e }}"
                                                    value="{{ $facturacion_registros->producto->nombre }}" readonly>
                                            @elseif(isset($facturacion_registros->servicio_id))
                                                <input required="required" class="form-control" type="text"
                                                    id="input_descripcion_{{ $e }}"
                                                    name="input_descripcion_{{ $e }}"
                                                    value="{{ $facturacion_registros->servicio->nombre }}" readonly>
                                            @endif
                                        </td>
                                        @if ($tipo == 'factura_origi')
                                            <td>{{ $facturacion_registros->precio_unitario_comi }}</td>
                                            {{-- Precio Unitario --}}
                                            <td><input required="required" class="form-control" type="text"
                                                    id="input_precio_{{ $e }}"
                                                    name="input_precio_{{ $e }}"
                                                    value="{{ $facturacion_registros->precio_unitario_comi }}" readonly>
                                            </td> {{-- Nuevo Precio --}}
                                        @else
                                            <td>{{ $facturacion_registros->precio }}</td> {{-- Precio Unitario --}}
                                            <td><input required="required" class="form-control" type="text"
                                                    id="input_precio_{{ $e }}"
                                                    name="input_precio_{{ $e }}"
                                                    value="{{ $facturacion_registros->precio }}" readonly></td>
                                            {{-- Nuevo Precio --}}
                                        @endif
                                        <td><input required="required" class="form-control" type="text"
                                                id="input_descuento_{{ $e }}"
                                                name="input_descuento_{{ $e }}" value="0" readonly></td>
                                        {{-- Nuevo Descuento --}}
                                        @if ($tipo == 'factura_origi')
                                            <td>{{ $facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad }}
                                            </td> {{-- Total --}}
                                        @else
                                            <td>{{ $facturacion_registros->precio * $facturacion_registros->cantidad }}</td>
                                            {{-- Total --}}
                                        @endif
                                        <td style="display: none">
                                            {{ $sub_total = $facturacion_registros->factura_ids->op_gravada + $facturacion_registros->factura_ids->op_inafecta + $facturacion_registros->factura_ids->op_exonerada }}
                                            {{ $sub_total_gravado = $facturacion_registros->factura_ids->op_gravada }}
                                            {{ $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100 }}
                                            {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <td colspan="13" align="right">
                                            <button type="submit" class="btn btn-w-m btn-primary">Guardar</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br><br><br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row ">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h2><strong>Anulación por error de RUC </strong></h2>
                            </div>
                            <form action="{{ route('nota-credito.store_factura', $facturacion->id) }}"
                                enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            <!--Datos Generales -->
                                            <div class="panel panel-success">
                                                <div class="panel-heading">
                                                    <h3 class="text-center"><strong>Datos Generales</strong></h3>
                                                </div>
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
                                                                <label class="col-sm-4 col-form-label"><strong>RUC o
                                                                        DNI:</strong></label>
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
                                                <div class="panel-heading">
                                                    <h3 class="text-center"><strong>Condiciones Generales</strong></h3>
                                                </div>
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
                                                            <th style="width: 5%;">Cantidad</th>
                                                            <th style="width: 5%;">Nueva Cantidad</th>
                                                            <th style="width: 30%;">Descripción</th>
                                                            <th style="width: 10%;">Precio Unitario</th>
                                                            <th style="width: 10%;">Nuevo Precio</th>
                                                            <th style="width: 10%;">Nuevo Descuento</th>
                                                            <th style="width: 10%;">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <span hidden="hidden">{{ $u = 1 }} </span>
                                                        @foreach ($facturacion_registro as $e => $facturacion_registros)
                                                            <tr>
                                                                <td>{{ $u++ }}</td>
                                                                @if (isset($facturacion_registros->producto_id))
                                                                    <td>{{ $facturacion_registros->producto->codigo_producto }}
                                                                    </td>
                                                                @elseif(isset($facturacion_registros->servicio_id))
                                                                    <td>{{ $facturacion_registros->servicio->codigo_servicio }}
                                                                    </td>
                                                                @endif
                                                                <td>{{ $facturacion_registros->cantidad }}</td>
                                                                {{-- Cantidad --}}
                                                                <td><input required="required" class="form-control"
                                                                        type="text"
                                                                        id="input_cantidad_{{ $e }}"
                                                                        name="input_cantidad_{{ $e }}"
                                                                        value="{{ $facturacion_registros->cantidad }}"
                                                                        readonly></td> {{-- Cantidad Nueva --}}

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
                                                                    <td>{{ $facturacion_registros->precio }}</td>
                                                                    {{-- Precio Unitario --}}
                                                                    <td><input required="required" class="form-control"
                                                                            type="text"
                                                                            id="input_precio_{{ $e }}"
                                                                            name="input_precio_{{ $e }}"
                                                                            value="{{ $facturacion_registros->precio }}"
                                                                            readonly></td> {{-- Nuevo Precio --}}
                                                                @endif
                                                                <td><input required="required" class="form-control"
                                                                        type="text"
                                                                        id="input_descuento_{{ $e }}"
                                                                        name="input_descuento_{{ $e }}"
                                                                        value="0" readonly></td>
                                                                {{-- Nuevo Descuento --}}
                                                                @if ($tipo == 'factura_origi')
                                                                    <td>{{ $facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad }}
                                                                    </td> {{-- Total --}}
                                                                @else
                                                                    <td>{{ $facturacion_registros->precio * $facturacion_registros->cantidad }}
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
                    </div>
                </div>
            </div>
        </div>
    </div>

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
