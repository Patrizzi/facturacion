@extends('layout')

@section('title', 'Nota Debito Boleta - lista')
@section('breadcrumb', 'Nota Debito Boleta - lista')
@section('breadcrumb2', 'Nota Debito Boleta - lista')
@section('href_accion', route('nota-debito.index'))
@section('value_accion', 'Atras')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    {{-- <div class="ibox-content"> --}}
                    <div class="container col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h2><strong>Listado de Nota de Débito</strong></h2>
                            </div>
                            @php $activeSet = false; @endphp
                            <div class="panel-body">
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @can('nota_debito.crear_boleta')
                                            <li class="nav-item">
                                                <a class="nav-link {{ !$activeSet ? 'active' : '' }}" data-toggle="tab" href="#tab-3">Boleta</a>
                                            </li>
                                            @php $activeSet = true; @endphp
                                        @endcan
                                        @can('nota_debito.crear_boleta_m')
                                            <li class="nav-item">
                                                <a class="nav-link {{ !$activeSet ? 'active' : '' }}" data-toggle="tab" href="#tab-4">Boleta Manual</a>
                                            </li>
                                            @php $activeSet = true; @endphp
                                        @endcan
                                    </ul>
                                    @php $activeSet = false; @endphp
                                    <div class="tab-content">
                                        @can('nota_debito.crear_boleta')
                                            <div id="tab-3" class="tab-pane active">
                                                <div class="panel-body">
                                                    <!-- Filtros -->
                                                    <div class="search-responsive mb-4">
                                                        <div class="row">
                                                            <div class="col-lg-5 col-md-6 col-sm-12">
                                                                <div class="input-group">
                                                                    <input class="form-control" type="text" name="daterange"
                                                                        id="data_range_filter"
                                                                        value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}"
                                                                        readonly="readonly" />
                                                                    <span class="input-group-append">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            id="revert_select">
                                                                            <i class="fa fa-history"></i>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-md-6 col-sm-12">
                                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                                    id="search_all_column">
                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                                <button type="button" class="btn btn-block btn-primary"
                                                                    id="filter_buttons">Buscar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-striped table-bordered dataTables-example-boleta">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Código</th>
                                                                    <th>RUC/DNI</th>
                                                                    <th>Fecha</th>
                                                                    <th>Cliente</th>
                                                                    <th>Importe Total</th>
                                                                    <th>Acción</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($boletas as $boleta)
                                                                    <tr class="gradeX">
                                                                        <td>{{ $boleta->id }}</td>
                                                                        <td>{{ $boleta->codigo_boleta }}</td>
                                                                        <td>{{ $boleta->cliente->numero_documento }}</td>
                                                                        <td>{{ $boleta->fecha_emision }}</td>
                                                                        <td>{{ $boleta->cliente->nombre }}</td>
                                                                        <span
                                                                            hidden>{{ $subtotal = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada }}
                                                                        </span>
                                                                        <td>{{ $boleta->moneda->simbolo }}
                                                                            {{ number_format(round($subtotal + ($boleta->op_gravada * $igv->renta) / 100, 2), 2) }}
                                                                        </td>
                                                                        <td>
                                                                            <form method="POST"
                                                                                action="{{ route('nota-debito.create_nota_debito_boleta') }}">
                                                                                @csrf
                                                                                <input type="hidden" name="tipo"
                                                                                    value="normal">
                                                                                <input type="hidden" name="boleta_id"
                                                                                    value="{{ $boleta->id }}">
                                                                                <button type="submit"
                                                                                    class="btn btn-warning btn-sm"><i
                                                                                        class="fa fa-edit"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @php $activeSet = true; @endphp
                                        @endcan
                                        <!-- Tab 2 -->
                                        @can('nota_debito.crear_boleta_m')
                                            <div id="tab-4" class="tab-pane">
                                                <div class="panel-body">
                                                    <div class="search-responsive mb-4">
                                                        <div class="row">
                                                            <div class="col-lg-5 col-md-6 col-sm-12">
                                                                <div class="input-group">
                                                                    <input class="form-control" type="text"
                                                                        name="daterange" id="data_range_filter2"
                                                                        value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}"
                                                                        readonly="readonly" />
                                                                    <span class="input-group-append">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            id="revert_select2">
                                                                            <i class="fa fa-history"></i>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-md-6 col-sm-12">
                                                                <input type="search" class="form-control"
                                                                    placeholder="Buscar:" id="search_all_column2">
                                                            </div>
                                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                                <button type="button" class="btn btn-block btn-primary"
                                                                    id="filter_buttons2">Buscar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-striped table-bordered dataTables-example-boletam">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Código</th>
                                                                    <th>RUC/DNI</th>
                                                                    <th>Fecha</th>
                                                                    <th>Cliente</th>
                                                                    <th>Importe Total</th>
                                                                    <th>Acción</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($boleta_manual as $boletam)
                                                                    <tr class="gradeX">
                                                                        <td>{{ $boletam->id }}</td>
                                                                        <td>{{ $boletam->codigo_boleta }}</td>
                                                                        <td>{{ $boletam->cliente->numero_documento }}</td>
                                                                        <td>{{ $boletam->fecha_emision }}</td>
                                                                        <td>{{ $boletam->cliente->nombre }}</td>
                                                                        <span
                                                                            hidden>{{ $subtotal = $boletam->op_gravada + $boletam->op_inafecta + $boletam->op_exonerada }}
                                                                        </span>
                                                                        <td>{{ $boletam->moneda->simbolo }}
                                                                            {{ number_format(round($subtotal + ($boletam->op_gravada * $igv->renta) / 100, 2), 2) }}
                                                                        </td>
                                                                        <td>
                                                                            <form method="POST"
                                                                                action="{{ route('nota-debito.create_nota_debito_boleta') }}">
                                                                                @csrf
                                                                                <input type="hidden" name="tipo"
                                                                                    value="manual">
                                                                                <input type="hidden" name="boleta_id"
                                                                                    value="{{ $boletam->id }}">
                                                                                <button type="submit"
                                                                                    class="btn btn-warning btn-sm"><i
                                                                                        class="fa fa-edit"></i></button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @php $activeSet = true; @endphp
                                        @endcan
                                    </div>
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
        select.form-control:not([size]):not([multiple]) {
            height: 100%;
        }

        .dropdown-menu {
            left: 70px;
            padding: 20px 0;
        }

        #DataTables_Table_0_wrapper {
            /* padding-right: 0px; */
        }

        /* OCULTANDO LO DE ORGANIZAR*/
        /* Ver (números) */
        div.dataTables_length {
            display: none;
        }

        /* El Buscar */
        div.dataTables_filter {
            display: none;
        }

        /* CSV, Excel, PDF, Print */
        div.dt-buttons {
            display: none;
        }

        /* PANTALLA TABLET */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .row>.col-md-6 {
                margin-bottom: 12px;
            }
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

    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {

            // FACTURA NORMALES
            var table = $('.dataTables-example-boleta').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });

            // Inicializar DateRangePicker en d/m/Y
            $('#data_range_filter').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: "Aplicar",
                    cancelLabel: "Limpiar",
                    customRangeLabel: "Personalizado"
                },
                autoUpdateInput: true
            });

            // Filtro personalizado por rango de fechas
            let fechaInicio = null;
            let fechaFin = null;

            // Este bloque NO filtra aún, solo guarda fechas cuando se seleccionan
            $('#data_range_filter').on('apply.daterangepicker', function(ev, picker) {
                fechaInicio = picker.startDate;
                fechaFin = picker.endDate;
            });

            $('#data_range_filter').on('cancel.daterangepicker', function() {
                fechaInicio = null;
                fechaFin = null;
                $(this).val('');
            });

            // Filtro personalizado, se usará cuando hagas click en el botón
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (!fechaInicio || !fechaFin) return true;

                var fechaTabla = moment(data[3], 'DD/MM/YYYY'); // columna "Fecha"
                if (!fechaTabla.isValid()) return true;

                return fechaTabla.isBetween(fechaInicio, fechaFin, null, '[]');
            });

            // 🔘 Al hacer click en el botón, aplicar filtro
            $('#filter_buttons').on('click', function() {
                var searchValue = $('#search_all_column').val();
                table.search(searchValue).draw();
            });

            // 🔘 Si querés que también aplique el rango de fechas al hacer clic:
            $('#filter_buttons').on('click', function() {
                table.draw();
            });

            $('#revert_select').on('click', function() {
                $('#data_range_filter').val('{{ date('01/m/Y') }} - {{ date('t/m/Y') }}');
                fechaInicio = moment('{{ date('01/m/Y') }}', 'DD/MM/YYYY');
                fechaFin = moment('{{ date('t/m/Y') }}', 'DD/MM/YYYY');
                table.draw();
            });

            // FACTURA MANUALES
            var table2 = $('.dataTables-example-boletam').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });

            // Inicializar DateRangePicker en d/m/Y
            $('#data_range_filter2').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: "Aplicar",
                    cancelLabel: "Limpiar",
                    customRangeLabel: "Personalizado"
                },
                autoUpdateInput: true
            });

            // Filtro personalizado por rango de fechas
            let fechaInicio2 = null;
            let fechaFin2 = null;

            // Este bloque NO filtra aún, solo guarda fechas cuando se seleccionan
            $('#data_range_filter2').on('apply.daterangepicker', function(ev, picker) {
                fechaInicio2 = picker.startDate;
                fechaFin2 = picker.endDate;
            });

            $('#data_range_filter2').on('cancel.daterangepicker', function() {
                fechaInicio2 = null;
                fechaFin2 = null;
                $(this).val('');
            });

            // Filtro personalizado, se usará cuando hagas click en el botón
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                if (!fechaInicio2 || !fechaFin2) return true;

                var fechaTabla2 = moment(data[3], 'DD/MM/YYYY'); // columna "Fecha"
                if (!fechaTabla2.isValid()) return true;

                return fechaTabla2.isBetween(fechaInicio2, fechaFin2, null, '[]');
            });

            // 🔘 Al hacer click en el botón, aplicar filtro
            $('#filter_buttons2').on('click', function() {
                var searchValue = $('#search_all_column2').val();
                table2.search(searchValue).draw();
            });

            // 🔘 Si querés que también aplique el rango de fechas al hacer clic:
            $('#filter_buttons2').on('click', function() {
                table2.draw();
            });
            $('#revert_select2').on('click', function() {
                $('#data_range_filter2').val('{{ date('01/m/Y') }} - {{ date('t/m/Y') }}');
                fechaInicio2 = moment('{{ date('01/m/Y') }}', 'DD/MM/YYYY');
                fechaFin2 = moment('{{ date('t/m/Y') }}', 'DD/MM/YYYY');
                table2.draw();
            });
        });
    </script>
@endsection
