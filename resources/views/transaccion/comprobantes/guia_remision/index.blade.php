
@extends('layout')

@section('title', 'Comprobantes | Guia de Remision')

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
                            @include('transaccion\comprobantes\_shared\statistics')
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
                            <div class="tabs-scroll-top-comprobantes"></div>
                            <div class="tabs-scroll-bottom">
                                <ul class="nav nav-tabs" role="tablist" style="align-items: center;border-bottom: 0px !important;">
                                    @include('transaccion\comprobantes\_shared\tabs')
                                    {{-- Almacen --}}
                                    <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                        {{-- ALMACEN --}}
                                        @if (auth()->user()->name == 'Administrador' && $almacen->count() != 1){{-- Condicional por tipo de user  --}}
                                            <span class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" >
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                                    <span style="margin-left:12px;"><b>Almacenes:</b></span>
                                                    @foreach ($almacen as $almacens)
                                                        <li>
                                                            <form action="{{ route('guia_remision.create') }}"
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
                                            <form action="{{ route('guia_remision.create') }}" enctype="multipart/form-data"
                                                method="post" class="tooltip-demo">
                                                @csrf
                                                <input type="text" value="{{ auth()->user()->almacen_id }}" hidden="hidden"
                                                    name="almacen">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" id="btn-imprimir" class="btn btn-primary" title="Imprimir">
                                            <i class="fa fa-print"></i>
                                        </button>
                                        <button type="button" id="btn-exportar-guias" class="btn btn-primary" title="Exportar a Excel">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                        <button type="button" id="btn-descargar-filtrado" class="btn btn-primary" title="Descargar a PDF zip">
                                            <i class="fa fa-download"></i>
                                        </button>
                                    </ul>

                                </ul>
                            </div>
                            <div class="tab-content" style="margin-top: -1px">
                                <div role="tabpanel" id="tab-5" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
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
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" name="" id="select_estado_sunat">
                                                    <option value="" selected>Estado Sunat</option>
                                                    <option value="0">Sin Enviar</option>
                                                    <option value="1">Enviado</option>
                                                    <option value="2">Anulado</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>{{--  Tabla de Cotizacion Manual   --}}
                                    <div class="scrooll-table-responsive">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-guia-remision" style="min-width: 982px">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>RUC</th>
                                                    <th>Cliente</th>
                                                    <th>Emisión</th>
                                                    <th>Entrega</th>
                                                    <th>Ver</th>
                                                    <th style="width: 0.5vmax !important">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

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
    <form id="form-pdf-lote" method="POST"
        action="{{ route('guia_remision.print.multiple') }}"
        target="_blank" style="display:none;">
        @csrf
    </form>
    @include('transaccion\comprobantes\_shared\js_shared')
    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-7-tab').addClass('active');
            var $bottom = $('.tabs-scroll-bottom');
            var $nav = $bottom.find('.nav-custom');
            var $tab = $nav.find('li').eq(6);

            if ($tab.length) {
                var target = $tab[0].offsetLeft - ($bottom.innerWidth() / 2) + ($tab.outerWidth(true) / 2);

                $bottom.animate({ scrollLeft: target }, 600);
            }
        });
        var coti_table = $('.dataTables-example-guia-remision').DataTable({
            "pageLength": 15,
            "serverSide": true,
            "ajax": {
                url: "{{ route('comprobantes.guiaRemision_registers') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#data_range_filter').val();
                    d.estado_s = $('#select_estado_sunat').val();
                    d.value = $('#search_all_column').val();
                }
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" name="select_row" value="' + full[0] + '" class="i-checks-boleta">';
                    }
                },
                {
                    'width': '0.5vmax',
                    'targets': [3]
                },

                {
                    'width': '0.5vmax',
                    'targets': [7],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('guia_remision.show', ':id') }}';
                        url = url.replace(':id', full[0]);
                        return `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a> `;
                    }
                },
                {
                    'targets': [8], // Configuración para otra columna (como la de acciones)
                    'orderable': false,
                    'render': function(data, type, full, meta) {

                        const estados = {
                            0: {
                                texto: "Sin Enviar",
                                clase: "btn-warning",
                                icono: "fa fa-clock-o"
                            },
                            1: {
                                texto: "Enviado",
                                clase: "btn-info",
                                icono: "fa fa-check-circle"
                            },
                            2: {
                                texto: "Anulado",
                                clase: "btn-danger",
                                icono: "fa fa-check-circle"
                            }
                            // No incluimos 99 porque no queremos que aparezca
                        };

                        let end = "";

                        const estadoSunat = parseInt(full[8]);
                        const estadoCredito = parseInt(full[9]);
                        const estadoDebito = parseInt(full[10]);

                        const e0 = estados[estadoSunat];
                        end += `<button class="btn ${e0.clase} btn-circle btn-ls" title=" ${e0.texto}">
                                    <i class="${e0.icono}"></i>
                                </button> `;
                        return end;

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
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Click en Exportar
            $(document).on('click', '#btn-exportar-guias', function (e) {
                e.preventDefault();

                // 1) Verificar que la DataTable tenga registros visibles
                var info = $('.dataTables-example-guia-remision').DataTable().page.info();
                if (info.recordsTotal === 0 || info.recordsDisplay === 0) {
                    swal({
                        title: "No hay registros",
                        text: "No hay registros para exportar con los filtros aplicados.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    });
                    return;
                }

                // 2) Tomar los filtros actuales EXACTAMENTE como los usa la DataTable
                var daterange = $('#data_range_filter').val();
                var value = $('#search_all_column').val();

                // IMPORTANTE: usa el mismo separador que espera el backend.
                // Si el backend explota por ' - ', procura que el input tenga ' - ' también.

                // 3) Construir la URL hacia la nueva ruta de exportación
                var exportUrl = "{{ route('guia_remision.exportar') }}";
                var params = new URLSearchParams();
                if (daterange) params.append('daterange', daterange);
                if (value)     params.append('value', value);

                // 4) Disparar la descarga (por ahora abrirá la ruta; luego devolverá el Excel)
                window.location.href = exportUrl + '?' + params.toString();
            });
        });
    </script>

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    <script>
    $(document).ready(function() {
        var allSelectedIds = [];
        var masterChecked = false;
        var isUpdatingCheckboxes = false; // Flag para evitar loops infinitos

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Función para obtener TODOS los IDs mediante AJAX (para serverSide DataTables)
        function getAllIds(callback) {
            $.ajax({
                url: "{{ route('comprobantes.guiaRemision_registers') }}",
                method: "GET",
                data: {
                    daterange: $('#data_range_filter').val(),
                    tipo_comprobante: $('#select_tipo_coti').val(),
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

        // CORRECCIÓN: Función para actualizar el master checkbox automáticamente
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
                    console.log('Master checkbox marcado automáticamente - todos los registros están seleccionados');
                } else if (!allSelected && masterChecked) {
                    masterChecked = false;
                    $('thead input[type="checkbox"]').iCheck('uncheck');
                    console.log('Master checkbox desmarcado automáticamente - no todos los registros están seleccionados');
                }
                isUpdatingCheckboxes = false;
            });
        }

        // CORRECCIÓN: Checkbox del header - seleccionar/deseleccionar todos
        $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
            if (isUpdatingCheckboxes) return; // Evitar loops infinitos

            if (event.type === 'ifChecked') {
                masterChecked = true;
                console.log('Master checkbox marcado manualmente - obteniendo todos los IDs...');

                getAllIds(function(ids) {
                    allSelectedIds = [...ids]; // Crear una copia del array
                    console.log('allSelectedIds después del master:', allSelectedIds);
                    console.log('Cantidad de IDs en allSelectedIds:', allSelectedIds.length);

                    // Marcar todos los checkboxes visibles en la página actual
                    isUpdatingCheckboxes = true;
                    $('.i-checks-boleta').iCheck('check');
                    isUpdatingCheckboxes = false;
                });
            } else {
                masterChecked = false;
                allSelectedIds = [];
                console.log('Master checkbox desmarcado manualmente - allSelectedIds limpio');

                isUpdatingCheckboxes = true;
                $('.i-checks-boleta').iCheck('uncheck');
                isUpdatingCheckboxes = false;
            }
        });

        // CORRECCIÓN: Checkboxes individuales
        $(document).on('ifChecked ifUnchecked', '.i-checks-boleta', function(event) {
            if (isUpdatingCheckboxes) return; // Evitar que se ejecute cuando estamos actualizando programáticamente

            var row = $(this).closest('tr');
            var rowData = coti_table.row(row).data();

            if (rowData && rowData[0]) {
                var id = rowData[0].toString();

                if (event.type === 'ifChecked') {
                    // Agregar ID si no está ya seleccionado
                    if (!allSelectedIds.includes(id)) {
                        allSelectedIds.push(id);
                    }
                    console.log('Registro seleccionado:', id);
                } else {
                    // Remover ID de la selección
                    allSelectedIds = allSelectedIds.filter(function(selectedId) {
                        return selectedId !== id;
                    });
                    console.log('Registro deseleccionado:', id);

                    // CORRECCIÓN: Cuando se desmarca individualmente, salir del modo master
                    if (masterChecked) {
                        masterChecked = false;
                        isUpdatingCheckboxes = true;
                        $('thead input[type="checkbox"]').iCheck('uncheck');
                        isUpdatingCheckboxes = false;
                        console.log('Master checkbox desmarcado por deselección individual');
                    }
                }
            }

            console.log('allSelectedIds después de checkbox individual:', allSelectedIds);

            // CORRECCIÓN: Verificar automáticamente si todos están seleccionados
            setTimeout(updateMasterCheckbox, 50);
        });

        // CORRECCIÓN: Cuando se redibuje la tabla (cambio de página, filtros, etc.)
        coti_table.on('draw', function() {
            console.log('Tabla redibujada. allSelectedIds actual:', allSelectedIds);
            console.log('masterChecked actual:', masterChecked);

            // Reinicializar checkboxes
            $('.i-checks-boleta').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Usar setTimeout para asegurar que iCheck esté completamente inicializado
            setTimeout(function() {
                isUpdatingCheckboxes = true;

                // Procesar cada checkbox en la página actual
                $('.i-checks-boleta').each(function() {
                    var row = $(this).closest('tr');
                    var rowData = coti_table.row(row).data();
                    if (rowData && rowData[0]) {
                        var id = rowData[0].toString();

                        // Si este ID está en nuestra lista de seleccionados, marcarlo
                        if (allSelectedIds.includes(id)) {
                            $(this).iCheck('check');
                        } else {
                            $(this).iCheck('uncheck');
                        }
                    }
                });

                // Actualizar el estado del master checkbox
                if (masterChecked) {
                    $('thead input[type="checkbox"]').iCheck('check');
                } else {
                    $('thead input[type="checkbox"]').iCheck('uncheck');
                }

                isUpdatingCheckboxes = false;

                // Verificar si necesitamos actualizar el master checkbox automáticamente
                setTimeout(updateMasterCheckbox, 100);
            }, 150);
        });

        // Detectar cuando se cambia de tab
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var activeTab = $(e.target).attr('href');
            $(activeTab).find('.i-checks').iCheck('update');
        });

        // Función para imprimir guías de remisión seleccionadas
        $('#btn-imprimir').on('click', function(e) {
            e.preventDefault();

            console.log('IDs seleccionados:', allSelectedIds);

            if (allSelectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una guía para imprimir.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            swal({
                title: "Confirmar impresión",
                text: `¿Deseas imprimir ${allSelectedIds.length} guía(s) seleccionada(s)?`,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, imprimir",
                cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (isConfirm) {
                    var url = '{{ route("guia_remision.print.multiple") }}';
                    var params = new URLSearchParams();

                    allSelectedIds.forEach(function(id) {
                        params.append('guia_ids[]', id);
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
                        text: "Las guías de remisión se están imprimiendo...",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
        // Descargar guías seleccionadas en PDF/ZIP
        $('#btn-descargar-filtrado').on('click', function(e) {
            e.preventDefault();

            console.log('IDs seleccionados para descargar:', allSelectedIds);

            // 1) Validación: debe haber selección
            if (allSelectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una guía para descargar.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            // 2) Mensaje según cantidad
            const mensaje = allSelectedIds.length === 1
                ? "¿Deseas descargar la guía seleccionada en PDF?"
                : `¿Deseas descargar ${allSelectedIds.length} guías en un archivo ZIP?`;

            // 3) Confirmación
            swal({
                title: "Confirmar descarga",
                text: mensaje,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, descargar",
                cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (!isConfirm) return;

                // 4) Construir la URL hacia la ruta (la crearás en el controlador/rutas)
                const url = '{{ route("guia_remision.download.multiple") }}';
                const params = new URLSearchParams();

                // El backend esperará el array como guia_ids[]
                allSelectedIds.forEach(id => params.append('guia_ids[]', id));

                console.log('URL de descarga:', url + '?' + params.toString());

                // 5) Disparar la descarga
                window.location.href = url + '?' + params.toString();

                // 6) Mensaje de proceso
                swal({
                    title: "Procesando",
                    text: allSelectedIds.length === 1
                        ? "La guía se está generando y descargando..."
                        : "Las guías se están comprimiendo y descargando...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        });

        window.clearAllSelections = function() {
            allSelectedIds = [];
            masterChecked = false;
            isUpdatingCheckboxes = true;
            $('thead input[type="checkbox"]').iCheck('uncheck');
            $('.i-checks-boleta').iCheck('uncheck');
            isUpdatingCheckboxes = false;
            console.log('Todas las selecciones limpiadas');
        };

        window.getSelectedIds = function() {
            console.log('IDs actualmente seleccionados:', allSelectedIds);
            return allSelectedIds;
        };
    });
    </script>

@endsection



