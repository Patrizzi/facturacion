@extends('layout')

@section('title', 'Ventas | Nota de Venta')

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
                                    @if (auth()->user()->name == 'Administrador'){{-- Condicional por tipo de user  --}}
                                        <span class="dropdown">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                                <span style="margin-left:12px;"><b>Almacenes:</b></span>
                                                @foreach ($almacen as $almacens)
                                                    <li>
                                                        <form action="{{ route('nota_venta.create') }}"
                                                            enctype="multipart/form-data" method="post">
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
                                        <form action="{{ route('nota_venta.create') }}" enctype="multipart/form-data"
                                            method="post" class="tooltip-demo">
                                            @csrf
                                            <input type="text" value="{{ auth()->user()->almacen_id }}" hidden="hidden"
                                                name="almacen">
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <button type="button" id="btn-imprimir" class="btn btn-success" title="Imprimir">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <button type="button" id="btn-exportar-filtrado" class="btn btn-success" title="Exportar a Excel">
                                        <i class="fa fa-upload"></i>
                                    </button>    

                                </ul>

                            </ul>
                            <div class="tab-content">
                                <!-- COTIZACION-->
                                <div role="tabpanel" id="tab-1" class="tab-pane">
                                </div>

                                <!-- COTIZACION MANUAL-->
                                <div role="tabpanel" id="tab-2" class="tab-pane ">
                                </div>

                                <!-- NOTA DE VENTA-->
                                <div role="tabpanel" id="tab-3" class="tab-pane active show">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter"
                                                        value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}"
                                                        readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--<div class="col-lg-3 col-md-6 col-sm-12">
                                                        <select class="form-control" name="" id="select_tipo_coti">
                                                            <option value="" selected>Todos los comprobantes</option>
                                                            <option value="factura">Factura</option>
                                                            <option value="boleta">Boleta</option>
                                                            <option value="nota_venta">Nota de Venta</option>
                                                        </select>
                                                    </div> -->
                                            <div class="col-lg-5 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>{{--  Tabla de Nota de Venta   --}}
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-nota_venta">
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
                            </div>
                            <!-- CLIENTES-->
                            <div role="tabpanel" id="tab-4" class="tab-pane">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('transaccion.venta._shared.js_shared')

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
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
$(document).ready(function() {
    // "ACTIVA EL TAB DE NOTA VENTA"
    $('#tab-3-tab').addClass('active');
    
    var coti_table = $('.dataTables-example-nota_venta').DataTable({
        "serverSide": true,
        "ajax": {
            url: "{{ route('ventas.nota_venta_registers') }}",
            method: "get",
            data: function(d) {
                d.daterange = $('#data_range_filter').val();
                d.tipo_coti = $('#select_tipo_coti').val();
                d.value = $('#search_all_column').val();
            },
            dataSrc: function(json) {
                var total_columna = json.total_columna;
                var total_table = json.total_table;

                $('.dataTables-example-nota_venta tfoot th.total-columna').html('Total: ' + total_columna);
                $('.dataTables-example-nota_venta tfoot th.total-total').html('Total G.: ' + total_table);

                return json.data;
            }
        },
        "columnDefs": [{
                'width': '1vmax',
                'targets': [0],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    return '<input type="checkbox" name="select_row" value="' + full[0] +
                        '" class="i-checks-boleta">';
                }
            },
            {
                'width': '30%',
                'targets': [4]
            },
            {
                'targets': [8],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    var url = '{{ route('nota_venta.show', ':id') }}';
                    url = url.replace(':id', full[0]);

                    if (full[9] == '1') {
                        return `<a href="${url}"> 
                                    <button type="button" class="btn btn-primary"> 
                                        <i class="fa fa-eye"></i> 
                                    </button> 
                                </a> 
                                <button type="button" class="btn btn-warning">
                                    <i class="fa fa-clock-o"></i>
                                </button>`;
                    } else {
                        return `<a href="${url}"> 
                                    <button type="button" class="btn btn-primary"> 
                                        <i class="fa fa-eye"></i> 
                                    </button> 
                                </a> 
                                <button type="button" class="btn btn-info">
                                    <i class="fa fa-check-circle"></i>
                                </button>`;
                    }
                }
            }
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('.i-checks-boleta').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        }
    });

    // Configuración del datepicker
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

    // Configuración de iCheck para checkboxes
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Variable para rastrear el estado del checkbox principal
    var allChecked = false;

    // Controlar el checkbox del thead
    $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
        var table = $(this).closest('table');

        if (event.type === 'ifChecked') {
            allChecked = true;
            // Selecciona TODOS los checkboxes de TODAS las páginas
            table.find('tbody input[type="checkbox"]').iCheck('check');
            // También selecciona los que no están visibles (en otras páginas)
            $('.i-checks-boleta').iCheck('check');
        } else {
            allChecked = false;
            // Deselecciona TODOS los checkboxes de TODAS las páginas
            table.find('tbody input[type="checkbox"]').iCheck('uncheck');
            // También deselecciona los que no están visibles (en otras páginas)
            $('.i-checks-boleta').iCheck('uncheck');
        }
    });

    // Manejar cambios en checkboxes individuales
    $(document).on('ifChanged', '.i-checks-boleta', function(event) {
        var table = $('.dataTables-example-nota_venta');
        var totalCheckboxes = $('.i-checks-boleta').length;
        var checkedCheckboxes = $('.i-checks-boleta:checked').length;

        if (checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0) {
            table.find('thead input[type="checkbox"]').iCheck('check');
            allChecked = true;
        } else {
            table.find('thead input[type="checkbox"]').iCheck('uncheck');
            allChecked = false;
        }
    });

    // Manejar el redibujado de la tabla (paginación, filtros, etc.)
    coti_table.on('draw', function() {
        // Reinicializar iCheck para los nuevos elementos
        $('.i-checks-boleta').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Si estaba todo seleccionado, mantener la selección
        if (allChecked) {
            $('.i-checks-boleta').iCheck('check');
        }
    });

    // Función para imprimir notas de venta seleccionadas
    $('#btn-imprimir').on('click', function(e) {
        e.preventDefault();

        // Recolectar IDs de notas de venta seleccionadas
        var selectedIds = [];
        $('.i-checks-boleta:checked').each(function() {
            var row = $(this).closest('tr');
            var rowData = coti_table.row(row).data();
            if (rowData && rowData[0]) {
                selectedIds.push(rowData[0]);
            }
        });

        // Validar que hay notas de venta seleccionadas
        if (selectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una nota de venta para imprimir.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // Confirmar acción
        swal({
            title: "Confirmar impresión",
            text: `¿Deseas imprimir ${selectedIds.length} nota(s) de venta seleccionada(s)?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, imprimir",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                // Construir URL con parámetros GET
                var url = '{{ route("notaVenta.print.multiple") }}';
                var params = new URLSearchParams();

                selectedIds.forEach(function(id) {
                    params.append('nota_ids[]', id);
                });

                // Abrir nueva pestaña
                var printWindow = window.open(
                    url + '?' + params.toString(),
                    '_blank'
                );

                if (printWindow) {
                    printWindow.focus();
                } else {
                    alert('Por favor, permite ventanas emergentes para imprimir');
                }

                // Mostrar mensaje de éxito
                swal({
                    title: "Procesando",
                    text: "Las notas de venta se están imprimiendo...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // Manejar click del botón de exportar
    $(document).on('click', '#btn-exportar-filtrado', function(e) {
        e.preventDefault();

        var daterange = $('#data_range_filter').val();
        var value = $('#search_all_column').val();
        var tipo_coti = $('#select_tipo_coti').val();

        var exportUrl = "{{ route('export.nota_venta') }}";
        var params = new URLSearchParams();

        if (daterange) {
            params.append('daterange', daterange);
        }
        if (value) {
            params.append('value', value);
        }
        if (tipo_coti) {
            params.append('tipo_coti', tipo_coti);
        }

        window.location.href = exportUrl + '?' + params.toString();
    });
});
</script>
@endsection
