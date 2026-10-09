@extends('layout')

@section('title', 'Pagos de Facturas Manuales')
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

    {{-- @include('cobranzas.facturas_manual._shared.statitics') --}}


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist"
                                style="align-items: center;border-bottom: 0px !important;">
                                @include('cobranzas.facturas_manuales._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <button class="btn btn-primary" type="button" id="pago_lote_total" disabled><i
                                            class="fa fa-money"></i></button>
                                </ul>
                            </ul>
                            <div class="tab-content" style="margin-top: -1px">
                                <div class="tab-pane active show" role="tabpanel" id="tab-1"
                                    style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter" value="" readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group" style="flex-wrap: nowrap;">
                                                    <select class="select2_demo_client" name="cliente" id="cliente"
                                                        required=""></select>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_select()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <select class="select_2_estado" name="" id="select_estado">
                                                        <option value="">Seleccionar Estado de Pago</option>
                                                        <option value="0">Sin Pagar</option>
                                                        <option value="1">Pagado Parcial</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <select class="select_2_tipo_pago" name="" id="select_tipo_pago">
                                                        <option value="">Seleccionar Forma de Pago</option>
                                                        <option value="1">Contado</option>
                                                        <option value="2">Credito</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-primary btn-block"
                                                    id="button_filtros">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table
                                            class="table table-striped table-bordered table-hover dataTables-example-facturas_manual">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th style="width: 150px">Cliente</th>
                                                    <th>Documento</th>
                                                    <th>Facturas Creadas</th>
                                                    <th>Facturas Pagadas completas</th>
                                                    <th>Monto Soles Pagados de Facturas Completas</th>
                                                    {{-- <th style="width: 63px !important">T.C Promedio</th> --}}
                                                    <th>Monto Dolares Pagados de Facturas Completas</th>
                                                    <th>Detalles</th>
                                                    {{-- <th>Cliente</th>
                                                    <th>Total Pagado</th>
                                                    <th>Ultima Fecha de Pago</th>
                                                    <th>Detalles</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($clientes as $index3 => $clie)
                                                    @if (count($facturas_m->where('cliente_id', $clie->id)) >= 1)
                                                        <div class="display: none">
                                                            <div style="display: none">
                                                                {{ $cal_sol = 0 }} {{ $cal_dol = 0 }}
                                                                {{ $count_fact_pag = 0 }}
                                                                {{ $prom_tc = 0 }} {{ $cant = 1 }}
                                                            </div>
                                                            <!-- @foreach ($facturas_m->where('cliente_id', $clie->id) as $facturas_norma)
    <div style="display: none">
                                                                        {{ $std_cuot = $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->where('estado', 1)->count() }}
                                                                        {{ $std_cuot2 = $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->count() }}
                                                                        {{ $simbolo_mon_sol = 'S/.' }}
                                                                        {{ $simbolo_mon_dol = '$' }}
                                                                    </div>
                                                                    @if ($std_cuot == $std_cuot2)
    <div style="display: none">
                                                                            {{ $prom_tc += $facturas_norma->cambio }}
                                                                            {{ $cant += 1 }}
                                                                        </div>
                                                                        {{-- {{$facturas_norma->moneda->nombre}} --}}
                                                                        @if ($facturas_norma->moneda->nombre == 'soles')
    {{-- CONVERTIR EN SOLES MONT TOTAL / TIPO CAMBIO EN ESE DIA --}}
                                                                            <div style="display: none">
                                                                                {{ $cal_sol += $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->sum('monto') }}
                                                                                {{ $cal_dol += $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->sum('monto') / $facturas_norma->cambio }}
                                                                            </div>
    @endif
                                                                        @if ($facturas_norma->moneda->nombre == 'Dolares')
    {{-- CONVERTIR EN DOLARES MONT TOTAL * TIPO CAMBIO EN ESE DIA --}}
                                                                            <div style="display: none">
                                                                                {{ $cal_dol += $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->sum('monto') }}
                                                                                {{ $cal_sol += $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->sum('monto') * $facturas_norma->cambio }}
                                                                            </div>
    @endif
    @endif
    @endforeach
                                                            </div>
                                                            {{-- COLUMNAS PARA MONTO SOLES Y MONTO DOLARES, COLUMNA ADICIONAL CON LOS 2 PRECIO TOTALES POR CLIENTE --}}
                                                            <tr>
                                                                <td>{{ $index3++ }}</td>
                                                                <td>{{ $clie->nombre }}</td>
                                                                <td>{{ $clie->numero_documento }}</td>
                                                                {{-- <td></td>
                                                        <td></td> --}}
                                                                <td>
                                                                    {{ $clie->cantidad_fact }}
                                                                </td>
                                                                <td>
                                                                    {{ $facturas_m->where('cliente_id', $clie->id)->where('estado_pago', 2)->count() }}
                                                                </td>
                                                                <td>
                                                                    {{ $simbolo_mon_sol }}
                                                                    {{ $var_precio_tot[$index3]['tot'] }}
                                                                </td>
                                                                {{-- <td>
                                                            {{ number_format($prom_tc / $cant, 2) }}
                                                        </td> --}}
                                                                <td>
                                                                    {{ $simbolo_mon_dol }}
                                                                    {{ $var_precio_tot[$index3]['tot_dol'] }}
                                                                </td>
                                                                <td>
                                                                    {{-- <button class="btn btn-secondary">Ver detalles</button> --}}
                                                                    <a href="{{ route('pagos.show_cliente_factura_m', $clie->numero_documento) }}"
                                                                        class="btn btn-secondary">Ver Detalles</a>
                                                                </td>
                                                            </tr>
    @endif
    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- scripts -->
                                                            <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
                                                            <script src="{{ asset('js/popper.min.js') }}"></script>
                                                            <script src="{{ asset('js/bootstrap.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

                                                            <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

                                                            <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

                                                            <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

                                                            <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>

                                                            <link href="{{ asset('css/plugins/switchery/switchery.css') }}"
                                                                rel="stylesheet">

                                                            <!-- Switchery -->
                                                            <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

                                                            <script src="{{ asset('js/inspinia.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
                                                            <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>


                                                        @endsection
