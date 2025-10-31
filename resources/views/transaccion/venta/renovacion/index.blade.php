@extends('layout')

@section('title', 'Ventas | Renovaciones')


@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- RESUMEN (si lo necesitas) --}}
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
                           {{--   @include('transaccion\venta\_shared\statistics')--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABS Y CONTENIDO --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-scroll-top"></div>
                        <div class="tabs-scroll-bottom">
                            {{-- TABS --}}
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;border-bottom: 0px !important;">
                                @include('transaccion\venta\_shared\tabs')
                                {{-- Almacen --}}
                                <ul class="ml-auto d-flex"
                                    style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                    <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                        <a class="btn btn-primary" href="{{ route('cotizacion_manual.create') }}"><i
                                                class="fa fa-plus"></i>
                                        </a>
                                    </ul>

                                    <button type="button" id="bnt-imprimir" class="btn btn-primary" title="Imprimir">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <button type="button" id="btn_export_renovacion" class="btn btn-primary" title="Exportar a Excel">
                                        <i class="fa fa-upload"></i>
                                    </button>

                                    <button type="button" id="btn-descargar-filtrado" class="btn btn-primary"
                                        title="Descargar a PDF zip">
                                        <i class="fa fa-download"></i>
                                    </button>
                                </ul>
                            </ul>
                        </div>
                        <div class="tab-content" style="margin-top: -1px">
                                <!-- RENOVACIONES -->
                                <div role="tabpanel" id="tab-2" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row" style="row-gap: 5px">
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
                                    <br>{{--  Tabla de Renovaciones   --}}
                                    <div class="scrooll-table-responsive">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-renovacion" style="min-width: 982px">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>N°</th>
                                                    <th>RUC-DNI</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha de Emisión</th>
                                                    <th>Fecha de Vencimiento</th>
                                                    <th>Tiempo de Vencimiento</th>
                                                    <th>Forma</th>
                                                    <th>Importe T.</th>
                                                    <th style="width: 0.5vmax !important">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="8"></th>
                                                    <th class="total-columna">Total: 0</th>
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

    {{-- SCRIPTS AL FINAL --}}
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
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
            // "ACTIVA EL TAB DE RENOVACIÓN"
            $('#tab-renovacion').addClass('active');

            // Variables globales para checkbox múltiple
            var allSelectedIds = [];
            var masterChecked = false;
            var isUpdatingCheckboxes = false;

            // Inicializar iCheck
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Función para obtener TODOS los IDs mediante AJAX
            function getAllIds(callback) {
                $.ajax({
                    url: "/ventas/renovacion/registros", // ← CAMBIA ESTO (URL directa)
                    method: "GET",
                    data: {
                        daterange: $('#data_range_filter').val(),
                        tipo_renovacion: $('#select_tipo_coti').val(),
                        value: $('#search_all_column').val(),
                        length: -1,
                        start: 0,
                        get_all_ids: true
                    },
                    success: function(response) {
                        var ids = [];
                        if (response.data && response.data.length > 0) {
                            response.data.forEach(function(row) {
                                if (row[0]) {
                                    ids.push(row[0].toString());
                                }
                            });
                        }
                        console.log('getAllIds() encontró estos IDs:', ids);
                        callback(ids);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error obteniendo todos los IDs:', error);
                        callback([]);
                    }
                });
            }

            // Función para actualizar el estado del master checkbox
            function updateMasterCheckbox() {
                if (isUpdatingCheckboxes) return;

                getAllIds(function(allIds) {
                    var allSelected = allIds.length > 0 && allIds.every(function(id) {
                        return allSelectedIds.includes(id);
                    });

                    isUpdatingCheckboxes = true;
                    if (allSelected && !masterChecked) {
                        masterChecked = true;
                        $('thead input[type="checkbox"]').iCheck('check');
                    } else if (!allSelected && masterChecked) {
                        masterChecked = false;
                        $('thead input[type="checkbox"]').iCheck('uncheck');
                    }
                    isUpdatingCheckboxes = false;
                });
            }

            // Checkbox del header - seleccionar/deseleccionar todos
            $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
                if (isUpdatingCheckboxes) return;

                if (event.type === 'ifChecked') {
                    masterChecked = true;
                    console.log('Master checkbox marcado');

                    getAllIds(function(ids) {
                        allSelectedIds = [...ids];
                        console.log('allSelectedIds después del master:', allSelectedIds);

                        isUpdatingCheckboxes = true;
                        $('.dataTables-example-renovacion tbody input[type="checkbox"]').iCheck('check');
                        isUpdatingCheckboxes = false;
                    });
                } else {
                    masterChecked = false;
                    allSelectedIds = [];
                    console.log('Master checkbox desmarcado');

                    isUpdatingCheckboxes = true;
                    $('.dataTables-example-renovacion tbody input[type="checkbox"]').iCheck('uncheck');
                    isUpdatingCheckboxes = false;
                }
            });

            // Checkboxes individuales
            $(document).on('ifChecked ifUnchecked', '.dataTables-example-renovacion tbody input[type="checkbox"]', function(event) {
                if (isUpdatingCheckboxes) return;

                var checkboxValue = $(this).val();

                if (event.type === 'ifChecked') {
                    if (!allSelectedIds.includes(checkboxValue)) {
                        allSelectedIds.push(checkboxValue);
                    }
                    console.log('Registro seleccionado:', checkboxValue);
                } else {
                    allSelectedIds = allSelectedIds.filter(function(selectedId) {
                        return selectedId !== checkboxValue;
                    });
                    console.log('Registro deseleccionado:', checkboxValue);

                    if (masterChecked) {
                        masterChecked = false;
                        isUpdatingCheckboxes = true;
                        $('thead input[type="checkbox"]').iCheck('uncheck');
                        isUpdatingCheckboxes = false;
                    }
                }

                console.log('allSelectedIds:', allSelectedIds);
                setTimeout(updateMasterCheckbox, 50);
            });

            var renovacion_table = $('.dataTables-example-renovacion').DataTable({
                "lengthChange": false,
                "responsive": true,
                "searching": false,
                "pageLength": 15,
                "serverSide": true,
                "ajax": {
                    url: "/ventas/renovacion/registros", // ← CAMBIA ESTO (URL directa)
                    method: "get",
                    data: function(d) {
                        d.daterange = $('#data_range_filter').val();
                        d.tipo_renovacion = $('#select_tipo_coti').val();
                        d.value = $('#search_all_column').val();
                    },
                    dataSrc: function(json) {
                        var total_columna = json.total_columna;
                        var total_table = json.total_table;

                        $('.dataTables-example-renovacion tfoot th.total-columna').html('Total: ' + total_columna);
                        $('.dataTables-example-renovacion tfoot th.total-total').html('Total G.: ' + total_table);

                        return json.data;
                    }
                },
                "columnDefs": [
                {
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" name="select_row" value="' + full[0] + '">';
                    }
                },
                {
                    'width': '30%',
                    'targets': [4] // Cliente
                },
                {
                    'targets': [7], // Tiempo de Vencimiento
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return data ? data : ''; // Si está vacío, no muestra nada
                    }
                },
                {
                    'targets': [10], // Acciones (ahora es la columna 10)
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('cotizacion_manual.show', ':id') }}';
                        url = url.replace(':id', full[1]);

                        if (full[11] == '0') { // Estado ahora está en full[11]
                            return `<a href="${url}">
                                        <button type="button" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-warning btn-sm">
                                        <i class="fa fa-clock-o"></i>
                                    </button>`;
                        } else {
                            return `<a href="${url}">
                                        <button type="button" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-info btn-sm">
                                        <i class="fa fa-check-circle"></i>
                                    </button>`;
                        }
                    }
                }
            ],
            });

            // Cuando se redibuje la tabla
            renovacion_table.on('draw', function() {
                console.log('Tabla redibujada. allSelectedIds:', allSelectedIds);

                $('.dataTables-example-renovacion tbody input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

                setTimeout(function() {
                    isUpdatingCheckboxes = true;

                    $('.dataTables-example-renovacion tbody input[type="checkbox"]').each(function() {
                        var checkboxValue = $(this).val();

                        if (allSelectedIds.includes(checkboxValue)) {
                            $(this).iCheck('check');
                        } else {
                            $(this).iCheck('uncheck');
                        }
                    });

                    if (masterChecked) {
                        $('thead input[type="checkbox"]').iCheck('check');
                    } else {
                        $('thead input[type="checkbox"]').iCheck('uncheck');
                    }

                    isUpdatingCheckboxes = false;
                    setTimeout(updateMasterCheckbox, 100);
                }, 150);
            });

            $('input[name="daterange"]').daterangepicker({
                "locale": {
                    "separator": " | ",
                    "applyLabel": "Guardar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    "monthNames": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    "firstDay": 1
                }
            });

            let mostrarToast = false;
            $('#filter_buttons').on('click', function() {
                mostrarToast = true;
                renovacion_table.ajax.reload();
            });

            renovacion_table.on('xhr.dt', function(e, settings, json, xhr) {
                if (mostrarToast) {
                    toastr.success(" ", 'Se han aplicado los filtros correctamente', {
                        timeOut: 3000
                    });
                    mostrarToast = false;
                }
            });

            $('#revert_select').on('click', function() {
                $('input[name="daterange"]').val("{{ date('01/m/Y') }} - {{ date('t/m/Y') }}").trigger('change');
                mostrarToast = true;
                renovacion_table.ajax.reload();
            });

            // Exportar renovaciones
            $('#btn_export_renovacion').on('click', function(e) {
                e.preventDefault();

                var daterange = $('#data_range_filter').val();
                var tipo_renovacion = $('#select_tipo_coti').val();
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

                var info = renovacion_table.page.info();

                if (info.recordsTotal === 0 || info.recordsDisplay === 0) {
                    swal({
                        title: "No hay registros",
                        text: "No hay registros para exportar con los filtros aplicados.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    });
                    return;
                }

                // var exportUrl = ' route("exportarRenovacion") ';
                var params = new URLSearchParams({
                    daterange: daterange,
                    tipo_renovacion: tipo_renovacion || '',
                    value: value || ''
                });

                window.location.href = exportUrl + '?' + params.toString();
            });

            // Imprimir renovaciones seleccionadas
            $('#bnt-imprimir').on('click', function(e) {
                e.preventDefault();

                console.log('IDs seleccionados para imprimir:', allSelectedIds);

                if (allSelectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una renovación para imprimir.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    });
                    return;
                }

                swal({
                    title: "Confirmar impresión",
                    text: `¿Deseas imprimir ${allSelectedIds.length} renovación(es) seleccionada(s)?`,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Sí, imprimir",
                    cancelButtonText: "Cancelar"
                }, function(isConfirm) {
                    if (isConfirm) {
                        // var url = ' route("renovacion.print.multiple") ';
                        var params = new URLSearchParams();

                        allSelectedIds.forEach(function(id) {
                            params.append('renovacion_ids[]', id);
                        });

                        var printWindow = window.open(url + '?' + params.toString(), '_blank');

                        if (printWindow) {
                            printWindow.focus();
                        } else {
                            alert('Por favor, permite ventanas emergentes para imprimir');
                        }

                        swal({
                            title: "Procesando",
                            text: "Las renovaciones se están imprimiendo...",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Descargar renovaciones seleccionadas en PDF/ZIP
            $('#btn-descargar-filtrado').on('click', function(e) {
                e.preventDefault();

                console.log('IDs seleccionados para descargar:', allSelectedIds);

                if (allSelectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una renovación para descargar.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    });
                    return;
                }

                var mensaje = allSelectedIds.length === 1
                    ? "¿Deseas descargar la renovación seleccionada en PDF?"
                    : `¿Deseas descargar ${allSelectedIds.length} renovaciones en un archivo ZIP?`;

                swal({
                    title: "Confirmar descarga",
                    text: mensaje,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Sí, descargar",
                    cancelButtonText: "Cancelar"
                }, function(isConfirm) {
                    if (isConfirm) {
                        // var url = ' route("renovacion.download.multiple") ';
                        var params = new URLSearchParams();

                        allSelectedIds.forEach(function(id) {
                            params.append('renovacion_ids[]', id);
                        });

                        console.log('URL de descarga:', url + '?' + params.toString());

                        window.location.href = url + '?' + params.toString();

                        swal({
                            title: "Procesando",
                            text: allSelectedIds.length === 1
                                ? "La renovación se está descargando..."
                                : "Las renovaciones se están comprimiendo y descargando...",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Funciones helper
            window.clearAllSelections = function() {
                allSelectedIds = [];
                masterChecked = false;
                isUpdatingCheckboxes = true;
                $('thead input[type="checkbox"]').iCheck('uncheck');
                $('.dataTables-example-renovacion tbody input[type="checkbox"]').iCheck('uncheck');
                isUpdatingCheckboxes = false;
                console.log('Todas las selecciones limpiadas');
            };

            window.getSelectedIds = function() {
                console.log('IDs actualmente seleccionados:', allSelectedIds);
                return allSelectedIds;
            };
        });
    </script>

    <script>
        $(document).ready(function () {
            @if(session('success'))
                toastr.success("{{ session('success') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if(session('error'))
                toastr.error("{{ session('error') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if(session('warning'))
                toastr.warning("{{ session('warning') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if(session('info'))
                toastr.info("{{ session('info') }}", '', {
                    timeOut: 3000
                });
            @endif
        });
    </script>

    @include('transaccion.venta._shared.js_shared')

@endsection
