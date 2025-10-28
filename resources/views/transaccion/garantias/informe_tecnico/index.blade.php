@extends('layout')

@section('title', 'Guias Informe Tecnico')
@section('breadcrumb', 'Informe Tecnico')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_informe_tecnico.guias'))
@section('value_accion', 'Agregar')

@section('content')

    @if (session('repite'))
        <div class="alert alert-danger">
            {{ session('repite') }}
        </div>
    @endif
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

    @include('transaccion.garantias._shared.statistics')

    <div class="wrapper wrapper-content animated fadeInRight pt-0">
        <!--Base para agregar el tab para el los contenidos-->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs d-flex justify-content-between align-items-center" role="tablist">
                                @include('transaccion.garantias._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    {{-- <a class="btn btn-sm btn-success" href="{{ route('garantia_informe_tecnico.guias') }}"
                                        id="create_guia_ingreso"><i class="fa fa-plus"></i></a> --}}
                                    <button type="button" id="bnt-imprimir" class="btn btn-sm btn-success" title="Imprimir">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <button type="button" id="btn-exportar-filtrado" class="btn btn-sm btn-success" title="Exportar a Excel">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                    <button type="button" id="btn-descargar-filtrado" class="btn btn-primary" title="Descargar PDF/ZIP">
                                        <i class="fa fa-download"></i>
                                    </button>
                                </ul>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="tab-3" class="tab-pane active show">
                                    <br>
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
                                                <select class="form-control select2" name="marcas_filter"
                                                    id="marcas_filter">
                                                    <option value=""></option>
                                                    @foreach ($marcas as $marca)
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                                    @endforeach
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
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-informe_tecnico">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <th>ID</th>
                                                    <th>Código Interno</th>
                                                    <th>Equipo</th>
                                                    <th>Marca</th>
                                                    <th>Serie</th>
                                                    <th>Cliente</th>
                                                    <th>RUC</th>
                                                    <th>Fecha</th>
                                                    <th>Ver</th>
                                                    {{-- <th>Estado</th> --}}
                                                </tr>
                                            </thead>
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

    @include('transaccion.garantias._shared.js_shared')

    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Seleccionar todos los check -->
<script>
    $(document).ready(function() {
        // "ACTIVA EL TAB DE COTIZACION"
        $('#tab-3').addClass('active');

        // Inicializar Select2
        $('#marcas_filter').select2({
            placeholder: "Selecciona una marca",
            allowClear: true,
            width: '100%'
        });

        // Variables para manejar selecciones
        var selectedRows = {};
        var tableId = 'dataTables-informe_tecnico';
        selectedRows[tableId] = {};

        // Función para inicializar iCheck
        function initializeICheck(container) {
            container.find('input[type="checkbox"]:not(.iCheck-helper + input)').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        }

        // Función para actualizar contador de selecciones
        function updateSelectionCounter() {
            var count = Object.keys(selectedRows[tableId] || {}).length;
            var counter = $('.dataTables-informe_tecnico').closest('.dataTables_wrapper').find('.selection-counter');
        }

        // Función para actualizar el estado del checkbox master
        function updateMasterCheckbox() {
            var masterCheckbox = $('.dataTables-informe_tecnico thead input[type="checkbox"]');
            var selectedCount = Object.keys(selectedRows[tableId] || {}).length;

            // Para server-side necesitamos obtener el total de registros del DataTable
            var dataTable = $('.dataTables-informe_tecnico').DataTable();
            var totalRows = dataTable.page.info().recordsTotal;

            if (selectedCount === 0) {
                masterCheckbox.iCheck('uncheck');
            } else if (selectedCount === totalRows) {
                masterCheckbox.iCheck('check');
            } else {
                // Estado intermedio - necesitamos manejarlo manualmente
                masterCheckbox.iCheck('indeterminate');
            }
        }

        // Función para restaurar el estado de los checkboxes en la página actual
        function restoreCheckboxState() {
            $('.dataTables-informe_tecnico tbody input[type="checkbox"]').each(function() {
                var rowId = $(this).val();
                if (selectedRows[tableId] && selectedRows[tableId][rowId]) {
                    $(this).iCheck('check');
                } else {
                    $(this).iCheck('uncheck');
                }
            });
            updateMasterCheckbox();
        }

        // Inicializar DataTable
        var coti_table = $('.dataTables-informe_tecnico').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_guia_informe_tecnico') }}",
                method: "get",
                data: function(d) {
                    // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                    d.daterange = $('#data_range_filter').val();
                    d.marca = $('#marcas_filter').val();
                    d.value = $('#search_all_column').val();
                }
            },
            "drawCallback": function(settings) {
                // Esta función se ejecuta después de cada draw/redraw del DataTable
                initializeICheck($('.dataTables-informe_tecnico'));
                restoreCheckboxState();
                updateSelectionCounter();
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0], // Aplica a la primera columna (index 0)
                    'orderable': false, // Deshabilitar ordenación en esta columna
                    'render': function(data, type, full, meta) {
                        // Renderizar el checkbox en la primera columna
                        return '<input type="checkbox" class="i-checks" name="select_row" value="' + full[0] + '">';
                    }
                },
                {
                    'width': '5%',
                    'targets': [1],
                },
                {
                    // 'width': '8%',
                    'targets': [2],
                },
                {
                    'width': '8%',
                    'targets': [3],
                },
                {
                    'width': '10%',
                    'targets': [4],
                },
                {
                    // 'width': '25%',
                    'targets': [5],
                },
                {
                    'targets': [6],
                },
                {
                    // 'width': '25%',
                    'targets': [7],
                },
                {
                    // 'width': '25%',
                    'targets': [8],
                },
                {
                    'targets': [9],
                    'width': '5%',
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('garantia_informe_tecnico.show', ':id') }}';
                        url = url.replace(':id', full[0]); // Reemplazar el placeholder con el valor dinámico
                        // ver
                        var concat = `<div class="tooltip-demo">
                            <a href="${url}">
                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ver"> <i class="fa fa-eye"></i> </button>
                            </a>`;

                        return concat;
                    }
                },
                // {
                //     'targets': [10], // Configuración para otra columna (como la de acciones)
                //     'width': '5%',
                //     'orderable': false,
                //     'render': function(data, type, full, meta) {
                //         // Generar la URL de forma dinámica usando la función route con un placeholder

                //         var concat2 = ``;
                //         if (full[11] == 0) { // Si no está egresado
                //             if (full[10] == 1) { // Si está activo
                //                 concat2 +=
                //                     `<a data-toggle="modal" class="btn btn-warning btn-circle btn-ls" onclick="anular_guia(` +
                //                     full[0] + `, '` + full[2] +
                //                     `')"><i class="fa fa-trash-o" style="color:white;font-size: 110%"></i></a>`;
                //             } else { // Si no  está activo
                //                 concat2 +=
                //                     `<button class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle" style="color:white;font-size: 110%"></i></button>`;
                //             }
                //         } else { // Si está egresado
                //             concat2 +=
                //                 `<button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle" style="color:white;font-size: 110%"></i></button>`;
                //         }

                //         return concat2;
                //     }
                // }
            ],
        });

        // Inicialización inicial
        initializeICheck($(document));

        // Controlar el checkbox del thead (seleccionar/deseleccionar todos)
        $(document).on('ifChecked ifUnchecked', '.dataTables-informe_tecnico thead input[type="checkbox"]', function(event) {
            if (event.type === 'ifChecked') {
                // Confirmar selección masiva si hay muchos registros
                var totalRows = coti_table.page.info().recordsTotal;
                if (totalRows > 50) {
                    swal({
                        title: "Seleccionar todos",
                        text: `¿Estás seguro de que quieres seleccionar todos los ${totalRows} registros?`,
                        type: "info",
                        showCancelButton: true,
                        confirmButtonText: "Sí, seleccionar todos",
                        cancelButtonText: "Cancelar"
                    }, function(isConfirm) {
                        if (isConfirm) {
                            selectAllRecords();
                        } else {
                            // Revertir el checkbox master
                            $('.dataTables-informe_tecnico thead input[type="checkbox"]').iCheck('uncheck');
                        }
                    });
                } else {
                    selectAllRecords();
                }
            } else {
                // Deseleccionar todos
                selectedRows[tableId] = {};
                $('.dataTables-informe_tecnico tbody input[type="checkbox"]').iCheck('uncheck');
                updateSelectionCounter();
            }
        });

        // Función para seleccionar todos los registros
        function selectAllRecords() {
            // Para server-side, necesitamos hacer una petición AJAX para obtener todos los IDs
            var ajaxData = {
                daterange: $('#data_range_filter').val(),
                marca: $('#marcas_filter').val(),
                value: $('#search_all_column').val(),
                get_all_ids: true // Parámetro especial para obtener solo IDs
            };

            $.ajax({
                url: "{{ route('api.get_guia_informe_tecnico') }}",
                method: "GET",
                data: ajaxData,
                success: function(response) {
                    // Asumiendo que el servidor devuelve los IDs cuando get_all_ids=true
                    if (response.all_ids) {
                        response.all_ids.forEach(function(id) {
                            selectedRows[tableId][id] = true;
                        });
                    } else {
                        // Fallback: usar los datos actuales de la página
                        coti_table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                            var data = this.data();
                            if (data && data[0]) {
                                selectedRows[tableId][data[0]] = true;
                            }
                        });
                    }

                    $('.dataTables-informe_tecnico tbody input[type="checkbox"]').iCheck('check');
                    updateMasterCheckbox();
                    updateSelectionCounter();
                },
                error: function() {
                    // Fallback: seleccionar solo los visibles
                    console.warn('No se pudo obtener todos los IDs, seleccionando solo los visibles');
                    $('.dataTables-informe_tecnico tbody input[type="checkbox"]').each(function() {
                        var rowId = $(this).val();
                        if (rowId) {
                            selectedRows[tableId][rowId] = true;
                            $(this).iCheck('check');
                        }
                    });
                    updateMasterCheckbox();
                    updateSelectionCounter();
                }
            });
        }

        // Manejar selección individual de checkboxes
        $(document).on('ifChanged', '.dataTables-informe_tecnico tbody input[type="checkbox"]', function(event) {
            var rowId = $(this).val();

            if ($(this).is(':checked')) {
                selectedRows[tableId][rowId] = true;
            } else {
                delete selectedRows[tableId][rowId];
            }

            updateMasterCheckbox();
            updateSelectionCounter();
        });

        // Configuración del date range picker
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

        // Evento para filtrar
        $(`#filter_buttons`).on('click', function() {
            // Limpiar selecciones al filtrar
            selectedRows[tableId] = {};
            updateSelectionCounter();
            coti_table.ajax.reload();
        });

        // Evento para crear guía de ingreso
        $('#create_guia_ingreso').on('click', function() {
            $('#modal-form').modal('show');
        });

        // Evento para revertir selección
        $('#revert_select').on('click', function() {
            var start = moment().startOf('month');
            var end = moment().endOf('month');

            // Setear en el input
            $('input[name="daterange"]').data('daterangepicker').setStartDate(start);
            $('input[name="daterange"]').data('daterangepicker').setEndDate(end);

            // Limpiar selecciones
            selectedRows[tableId] = {};
            updateSelectionCounter();
            coti_table.ajax.reload();
        });

        // Función para anular guía
        window.anular_guia = function(id, valor) {
            console.log(id);
            let form = document.getElementById('formulario_anular');
            let action = form.getAttribute('action');
            // Reemplaza ':id' por el valor que quieras
            action = action.replace(':id', id);
            form.setAttribute('action', action);
            $('#valor_ind').text(valor);
            $(`#modal-anular`).modal('show');
        };

        // Función para exportar
        $(document).on('click', '#btn-exportar-filtrado', function(e) {
            e.preventDefault();

            // Obtener los valores actuales de los filtros (exactamente como en tu DataTable)
            var daterange = $('#data_range_filter').val();
            var value = $('#search_all_column').val(); // Cambiado de 'search' a 'value'
            var marca = $('#marcas_filter').val();

            // Construir la URL con parámetros
            var exportUrl = "{{ route('export.garantia_informe_tecnico') }}";
            var params = new URLSearchParams();

            if (daterange) {
                params.append('daterange', daterange);
            }
            if (value) {
                params.append('value', value);
            }
            if (marca) {
                params.append('marca', marca);
            }

            // Redirigir para descargar
            window.location.href = exportUrl + '?' + params.toString();
        });

        // Función para imprimir múltiples informes técnicos
        $('#bnt-imprimir').on('click', function(e) {
            e.preventDefault();

            var selectedIds = Object.keys(selectedRows[tableId] || {}).filter(function(id) {
                return selectedRows[tableId][id] === true && id !== '' && id !== 'undefined';
            });

            if (selectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos un informe técnico para imprimir.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            // Confirmar acción
            swal({
                title: "Confirmar impresión",
                text: `¿Deseas imprimir ${selectedIds.length} informe(s) técnico(s) seleccionado(s)?`,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, imprimir",
                cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (isConfirm) {
                    // Construir URL con parámetros GET
                    var url = '{{ route("informeTecnico.print.multiple") }}';
                    var params = new URLSearchParams();

                    selectedIds.forEach(function(id) {
                        params.append('informe_ids[]', id);
                    });

                    // Abrir nueva pestaña para impresión
                    var printWindow = window.open(
                        url + '?' + params.toString(),
                        '_blank'
                    );

                    if (printWindow) {
                        printWindow.focus();
                    } else {
                        alert('Por favor, permite ventanas emergentes para imprimir');
                    }
                }
            });
        });

        // Inicializar contador
        updateSelectionCounter();

        // Descargar 1..N informes técnicos en PDF/ZIP
        $('#btn-descargar-filtrado').on('click', function(e) {
            e.preventDefault();

            // Reusar estructura de selección de esta vista
            var selectedIds = Object.keys(selectedRows[tableId] || {}).filter(function(id) {
                return selectedRows[tableId][id] === true &&
                    id !== '' &&
                    id !== 'undefined' &&
                    !isNaN(parseInt(id));
            });

            if (selectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos un informe técnico para descargar.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            const msg = selectedIds.length === 1
                ? "¿Deseas descargar el informe técnico seleccionado en PDF?"
                : `¿Deseas descargar ${selectedIds.length} informes técnicos en un archivo ZIP?`;

            swal({
                title: "Confirmar descarga",
                text: msg,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, descargar",
                cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (!isConfirm) return;

                // Form dinámico para POST (abre en nueva pestaña)
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("GarantiaIT.download.multiple") }}';
                form.target = '_blank'; // opcional, evita bloquear la UI

                // CSRF
                var csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                // IDs seleccionados
                selectedIds.forEach(function(id) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'informe_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);

                // Mensaje corto (opcional)
                swal({
                    title: "Procesando",
                    text: selectedIds.length === 1
                        ? "Generando PDF del informe técnico..."
                        : "Generando y comprimiendo los informes técnicos...",
                    type: "success",
                    timer: 1800,
                    showConfirmButton: false
                });
            });
        });
    });
</script>
@endsection
