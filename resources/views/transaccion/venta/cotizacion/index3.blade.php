@extends('layout')

@section('title', 'Cotización')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            @include('transaccion\venta\_shared\statistics')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                @include('transaccion\venta\_shared\tabs')
                                {{-- Almacen --}}
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    {{-- ALMACEN --}}
                                    @if (auth()->user()->name == "Administrador"){{-- Condicional por tipo de user  --}}
                                        <span class="dropdown" >
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                                <span style="margin-left:12px;"><b>Almacenes:</b></span>
                                                @foreach ($almacen as $almacens)
                                                    <li>
                                                        <form action="{{ route('cotizacion.create_factura') }}" enctype="multipart/form-data"
                                                            method="post">
                                                            @csrf
                                                            <input type="text" value="{{ $almacens->id }}"
                                                                hidden="hidden" name="almacen">
                                                            <button class="btn btn-w-m btn-link"
                                                                type="submit">{{ $almacens->nombre }}</button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </span>
                                    @else
                                        <form action="{{ route('cotizacion.create_factura') }}" enctype="multipart/form-data" method="post" class="tooltip-demo">
                                            @csrf
                                            <input type="text" value="{{ auth()->user()->almacen_id }}" hidden="hidden"
                                                name="almacen">
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <button class="btn btn-success" type="button">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>

                            </ul>
                            <div class="tab-content">
                                <!-- COTIZACION-->
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter"
                                                        value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" name="" id="select_tipo_coti">
                                                    <option value="" selected>Todos los comprobantes</option>
                                                    <option value="factura">Factura</option>
                                                    <option value="boleta">Boleta</option>
                                                    <option value="nota_venta">Nota de Venta</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>{{--  Tabla de   --}}
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-cotizacion">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Forma</th>
                                                    <th>Importe T.</th>
                                                    <th style="width: 0.5vmax !important">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="7"></th>
                                                    <th class="total-columna">Total: 0</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8"></th>
                                                    <th class="total-total">Total G: 0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <!-- COTIZACION MANUAL-->
                                {{-- <div role="tabpanel" id="tab-2" class="tab-pane">

                                </div> --}}
                                <!-- NOTA DE VENTA-->
                                <div role="tabpanel" id="tab-3" class="tab-pane">

                                </div>
                                <!-- CLIENTES-->
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"
                                                        for=""><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example"
                                                id="table_cliente">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Correo</th>
                                                        <th>Celular</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                {{--   <tbody>
                                                    @foreach ($clientes as $cliente)
                                                    <tr>
                                                        <td>{{$cliente->id}}</td>
                                                        <td>{{$cliente->numero_documento}}</td>
                                                        <td>{{$cliente->nombre}}</td>
                                                        <td>{{$cliente->email}}</td>
                                                        <td>{{$cliente->celular}}</td>
                                                        <td>
                                                            <a href="{{ route('cliente.show', $cliente->id) }}" target="_blank">
                                                                <button type="button" class="btn btn-primary">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </a>
                                                            <button type="button" class="btn btn-info">
                                                                <i class="fa fa-check-circle"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody> --}}
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

        .table {
            width: 100% !important;
        }

        .ibox-content>.row {
            margin: auto;
        }

        .nav-tabs-right {
            margin-left: auto;
            /* Esto empuja el tab hacia la derecha */
        }

        .search-responsive {
            padding-right: 15px;
            padding-left: 15px;
        }

        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        .btn-link {
            width: 100%;
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

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    {{-- SCRIPTS PARA DATATABLE --}}
    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-1-tab').addClass('active');
        });
        var coti_table = $('.dataTables-example-cotizacion').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('ventas.cotizacion_registers') }}",
                method: "get",
                data: function(d) {
                    // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                    d.daterange = $('#data_range_filter').val(); // Supongamos que tienes un campo input con rango de fechas
                    d.tipo_coti = $('#select_tipo_coti').val(); // Supongamos que tienes un select para el tipo de cotización
                    d.value = $('#search_all_column').val(); 
                },
                dataSrc: function(json) {
                    // Suponiendo que el valor adicional viene con el nombre 'total'
                    var total_columna = json.total_columna;
                    var total_table = json.total_table;

                    // Actualiza el pie de la tabla (tfoot) con el valor que viene del servidor
                    $('.dataTables-example-cotizacion tfoot th.total-columna').html('Total: ' + total_columna);
                    $('.dataTables-example-cotizacion tfoot th.total-total').html('Total  G.: ' + total_table);
                    
                    // Retorna los datos de la tabla para que Datatables los procese
                    return json.data;
                }
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0], // Aplica a la primera columna (index 0)
                    'orderable': false, // Deshabilitar ordenación en esta columna
                    'render': function(data, type, full, meta) {
                        // Renderizar el checkbox en la primera columna
                        return '<input type="checkbox" name="select_row" value="' + full[0] +
                            '">';
                    }
                },
                {
                    'targets': [1],
                    'orderable': false
                },
                {
                    'targets': [2],
                    'orderable': false
                },
                {
                    'targets': [3],
                    'orderable': false
                },
                {
                    'width': '30%',
                    'targets': [4],
                    'orderable': false
                },
                {
                    'targets': [5],
                    'orderable': false
                },
                {
                    'targets': [6],
                    'orderable': false
                },
                {
                    'targets': [7],
                    'orderable': false
                },
                {
                    'targets': [8], // Configuración para otra columna (como la de acciones)
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        // Generar la URL de forma dinámica usando la función route con un placeholder
                        var url = '{{ route('cotizacion.show', ':id') }}';
                        url = url.replace(':id', full[
                            0]); // Reemplazar el placeholder con el valor dinámico

                        if (full[9] == '1') {
                            return `
                                <div class="tooltip-demo">
                                    <a href="${url}">
                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ver"> <i class="fa fa-eye"></i> </button> 
                                    </a> 
                                    <button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Procesado"><i class="fa fa-clock-o"></i></button>
                                </div>`;
                        } else {
                            return `
                                <div class="tooltip-demo">
                                    <a href="${url}">
                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ver"> <i class="fa fa-eye"></i> </button> 
                                    </a> 
                                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Sin Procesar"><i class="fa fa-check-circle"></i></button>
                                </div>`;
                        }
                    }
                }
            ],
        });
        $('input[name="daterange"]').daterangepicker({
            "locale": {
                "separator": " | ",
                "applyLabel": "Guardar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
        });
        $(`#filter_buttons`).on('click', function() {
            coti_table.ajax.reload();
        });
    </script>
    <!-- Seleccionar todos los check -->
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Controlar el checkbox del thead 
            $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
                var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
                if (event.type === 'ifChecked') {
                    // Selecciona 
                    table.find('tbody input[type="checkbox"]').iCheck('check');
                } else {
                    // Deselecciona 
                    table.find('tbody input[type="checkbox"]').iCheck('uncheck');
                }
            });

            // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
            $('tbody input[type="checkbox"]').on('ifChanged', function(event) {
                var table = $(this).closest('table'); // Limita el control a la tabla visible
                if (table.find('tbody input[type="checkbox"]').filter(':checked').length === table.find(
                        'tbody input[type="checkbox"]').length) {
                    table.find('thead input[type="checkbox"]').iCheck('check');
                } else {
                    table.find('thead input[type="checkbox"]').iCheck('uncheck');
                }
            });

            // Detectar cuando se cambia de tab 
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                // Restablecer el estado de los checkboxes 
                var activeTab = $(e.target).attr('href'); // ID del tab activo
                $(activeTab).find('.i-checks').iCheck('update');
            });
        });
    </script>
    {{-- Script para el llamada a los otros tabs --}}
    <script>

    </script>
    <!--Clientes-->
    <script>
        $(document).ready(function() {
            $('#table_cliente').DataTable({
                "serverSide": true,
                "ajax": "{{ url('api/clientes') }}",
                "columns": [{
                        data: 'id'
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'numero_documento'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'celular'
                    },
                    {
                        name: '',
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function(data) {
                            var actions = '';
                            actions +=
                                '<a href="{{ route('cliente.show', ':id') }}" target="_blank"><button type="button" class="btn btn-primary mr-2"><i class="fa fa-eye"></i></button></a>';
                            actions +=
                                '<button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>';
                            return actions.replace(/:id/g, data.id);
                        }
                    }
                ]
            });
        });
    </script>
@endsection
