@extends('layout')

@section('title', 'Ventas | Cotización')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                        <div class="ibox-tools custom">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            @include('transaccion\venta\_shared\statistics')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <div class="tabs-scroll-top"></div>
                            <div class="tabs-scroll-bottom">
                                <ul class="nav nav-tabs" role="tablist"
                                    style="align-items: center;border-bottom: 0px !important;">
                                    @include('transaccion\venta\_shared\tabs')
                                    {{-- Almacen --}}
                                    <ul class="ml-auto d-flex"
                                        style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                        {{-- ALMACEN --}}
                                        @if (auth()->user()->name == 'Administrador')
                                            {{-- Condicional por tipo de user  --}}
                                            <span class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                                    <span style="margin-left:12px;"><b>Almacenes:</b></span>
                                                    @foreach ($almacen as $almacens)
                                                        <li>
                                                            <form action="{{ route('cotizacion.create_factura') }}"
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
                                            <form action="{{ route('cotizacion.create_factura') }}"
                                                enctype="multipart/form-data" method="post" class="tooltip-demo">
                                                @csrf
                                                <input type="text" value="{{ auth()->user()->almacen_id }}"
                                                    hidden="hidden" name="almacen">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" id="bnt-imprimir" class="btn btn-success" title="Imprimir">
                                            <i class="fa fa-print"></i>
                                        </button>
                                        <button type="button" id="btn_export_cotizaciones" class="btn btn-primary"
                                            title="Exportar a Excel">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                    </ul>
                                </ul>
                            </div>
                            <div class="tab-content" style="margin-top: -1px">
                                <!-- COTIZACION-->
                                <div role="tabpanel" id="tab-1" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row" style="row-gap: 10px">
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
                                        <table class="table table-striped table-bordered dataTables-example-cotizacion"
                                            style="min-width: 982px">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>N°</th>
                                                    <th>RUC-DNI</th>
                                                    <th>Cliente</th>
                                                    <th>Emisión</th>
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

    {{-- SCRIPTS PARA DATATABLE --}}
    <script>


        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-1-tab').addClass('active');
        });
        var coti_table = $('.dataTables-example-cotizacion').DataTable({
            "lengthChange": false,
            "responsive": true,
            "searching": false,
            "pageLength": 15,
            "serverSide": true,
            "ajax": {
                url: "{{ route('ventas.cotizacion_registers') }}",
                method: "get",
                data: function(d) {
                    // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                    d.daterange = $('#data_range_filter')
                        .val(); // Supongamos que tienes un campo input con rango de fechas
                    d.tipo_coti = $('#select_tipo_coti')
                        .val(); // Supongamos que tienes un select para el tipo de cotización
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

                        if (full[9] == '0') {
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
    // Configuración de iCheck para checkboxes
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Variables globales
    var allSelectedIds = [];
    var masterChecked = false;

    // Función para obtener TODOS los IDs mediante AJAX (para serverSide DataTables)
    function getAllIds(callback) {
        // Hacer una petición AJAX al mismo endpoint que usa DataTables pero pidiendo TODOS los datos
        $.ajax({
            url: "{{ route('ventas.cotizacion_registers') }}", // Ruta para cotizaciones
            method: "GET",
            data: {
                // Incluye todos los filtros que uses en tu DataTable
                daterange: $('#data_range_filter').val(),
                tipo_coti: $('#select_tipo_coti').val(),
                value: $('#search_all_column').val(),
                length: -1, // -1 significa "todos los registros"
                start: 0,
                get_all_ids: true // Parámetro especial para indicar que solo queremos los IDs
            },
            success: function(response) {
                var ids = [];
                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(row) {
                        if (row[0]) { // El ID está en la columna 0
                            ids.push(row[0].toString());
                        }
                    });
                }
                console.log('getAllIds() encontró estos IDs:', ids);
                console.log('Total de IDs encontrados:', ids.length);
                callback(ids);
            },
            error: function(xhr, status, error) {
                console.error('Error obteniendo todos los IDs:', error);
                callback([]);
            }
        });
    }

    // Controlar el checkbox del thead
    $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
        if (event.type === 'ifChecked') {
            masterChecked = true;
            console.log('Master checkbox marcado - obteniendo todos los IDs...');

            // Obtener TODOS los IDs mediante AJAX
            getAllIds(function(ids) {
                allSelectedIds = ids;
                console.log('allSelectedIds después del master (debería tener TODOS):', allSelectedIds);
                console.log('Cantidad de IDs en allSelectedIds:', allSelectedIds.length);

                // Marcar todos los checkboxes visibles en la página actual
                $('.dataTables-example-cotizacion tbody input[type="checkbox"]').iCheck('check');
            });
        } else {
            masterChecked = false;
            allSelectedIds = [];
            console.log('Master checkbox desmarcado - allSelectedIds limpio');
            $('.dataTables-example-cotizacion tbody input[type="checkbox"]').iCheck('uncheck');
        }
    });

    // Controlar checkboxes individuales
    $(document).on('ifChecked ifUnchecked', '.dataTables-example-cotizacion tbody input[type="checkbox"]', function(event) {
        var row = $(this).closest('tr');
        var rowData = coti_table.row(row).data();

        if (rowData && rowData[0]) {
            var id = rowData[0].toString();

            if (event.type === 'ifChecked') {
                if (!allSelectedIds.includes(id)) {
                    allSelectedIds.push(id);
                }
            } else {
                allSelectedIds = allSelectedIds.filter(function(selectedId) {
                    return selectedId !== id;
                });

                // Si se desmarca uno, desmarcar el master
                masterChecked = false;
                $('thead input[type="checkbox"]').iCheck('uncheck');
            }
        }

        console.log('allSelectedIds después de checkbox individual:', allSelectedIds);
    });

    // Detectar cuando se cambia de tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var activeTab = $(e.target).attr('href');
        $(activeTab).find('.i-checks').iCheck('update');
    });

    // Cuando se redibuje la tabla (cambio de página, filtros, etc.)
    coti_table.on('draw', function() {
        // Reinicializar iCheck para los nuevos elementos
        $('.dataTables-example-cotizacion tbody input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Si master está marcado, marcar todos los checkboxes de esta página
        if (masterChecked) {
            setTimeout(function() {
                $('.dataTables-example-cotizacion tbody input[type="checkbox"]').iCheck('check');
            }, 100);
        } else {
            // Marcar solo los seleccionados individualmente
            setTimeout(function() {
                $('.dataTables-example-cotizacion tbody input[type="checkbox"]').each(function() {
                    var row = $(this).closest('tr');
                    var rowData = coti_table.row(row).data();
                    if (rowData && rowData[0]) {
                        var id = rowData[0].toString();
                        if (allSelectedIds.includes(id)) {
                            $(this).iCheck('check');
                        }
                    }
                });
            }, 100);
        }
    });

    // Exportar cotizaciones
    $('#btn_export_cotizaciones').on('click', function(e) {
        e.preventDefault();

        var daterange = $('#data_range_filter').val();
        var tipo_coti = $('#select_tipo_coti').val();
        var value = $('#search_all_column').val();

        if (!daterange) {
            swal({
                title: "Rango de fechas requerido",
                text: "Por favor selecciona un rango de fechas antes de exportar",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        var table = coti_table;
        var info = table.page.info();

        if (info.recordsTotal === 0 || info.recordsDisplay === 0) {
            swal({
                title: "No hay registros",
                text: "No hay registros para exportar con los filtros aplicados.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        var exportUrl = '{{ route("exportarCotizacion") }}';
        var params = new URLSearchParams({
            daterange: daterange,
            tipo_coti: tipo_coti || '',
            value: value || ''
        });

        window.location.href = exportUrl + '?' + params.toString();
    });

    // Función para imprimir cotizaciones seleccionadas
    $('#bnt-imprimir').on('click', function(e) {
        e.preventDefault();

        console.log('IDs seleccionados:', allSelectedIds);

        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una cotización para imprimir.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        swal({
            title: "Confirmar impresión",
            text: `¿Deseas imprimir ${allSelectedIds.length} cotización(es) seleccionada(s)?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, imprimir",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                var url = '{{ route("cotizacion.print.multiple") }}';
                var params = new URLSearchParams();

                allSelectedIds.forEach(function(id) {
                    params.append('cotizacion_ids[]', id);
                });

                console.log('URL completa:', url + '?' + params.toString());

                var printWindow = window.open(
                    url + '?' + params.toString(),
                    '_blank'
                );

                if (printWindow) {
                    printWindow.focus();
                } else {
                    alert('Por favor, permite ventanas emergentes para imprimir');
                }

                swal({
                    title: "Procesando",
                    text: "Las cotizaciones se están imprimiendo...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });
});
</script>
@endsection
