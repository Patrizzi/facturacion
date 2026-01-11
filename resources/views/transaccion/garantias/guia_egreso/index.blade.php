@extends('layout')

@section('title', ' Guias Egreso')
@section('breadcrumb', 'Guias de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.guias'))
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
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                @include('transaccion.garantias._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    {{-- <a class="btn btn-sm btn-success" href="{{ route('garantia_guia_egreso.guias') }}"
                                        id="create_guia_ingreso"><i class="fa fa-plus"></i></a> --}}
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-download"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button type="button" id="bnt-imprimir" class="dropdown-item">
                                                <i class="fa fa-print"></i> Imprimir
                                            </button>
                                            <button type="button" id="btn-exportar-filtrado" class="dropdown-item">
                                                <i class="fa fa-file-excel-o"></i> Excel
                                            </button>
                                            <button type="button" id="btn-descargar-filtrado" class="dropdown-item">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </button>
                                            {{--  <button type="button" id="btn-correo-filtrado" class="dropdown-item">
                                                <i class="fa fa-envelope"></i> Correo
                                            </button>--}}
                                            <button type="button" id="btn-whatsapp-filtrado" class="dropdown-item">
                                                <i class="fa fa-whatsapp"></i> Whatsapp
                                            </button>
                                        </div>
                                    </div>
                                </ul>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <br>
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col">
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
                                            <div class="col">
                                                <select class="form-control select2" name="marcas_filter"
                                                    id="marcas_filter">
                                                    <option value=""></option>
                                                    @foreach ($marcas as $marca)
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="" id="procesado_filter" class="form-control">
                                                    <option value="">Todos</option>
                                                    <option value="1">Procesado</option>
                                                    <option value="0">Sin Procesar</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-egreso">
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
                                                    <th>Estado</th>
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

    <style>
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
    </style>

@include('transaccion.garantias._shared.js_shared')
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
       $(document).ready(function() {

    var selectedRows = {};
    var tableId = 'dataTables-egreso';
    selectedRows[tableId] = {};

    function initializeICheck(container) {
        container.find('input[type="checkbox"]:not(.iCheck-helper + input)').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    }

    // Función para actualizar contador de selecciones
    function updateSelectionCounter() {
        var count = Object.keys(selectedRows[tableId] || {}).length;
        var counter = $('.dataTables-egreso').closest('.dataTables_wrapper').find('.selection-counter');
    }

    // Función para actualizar el estado del checkbox master
    function updateMasterCheckbox() {
        var masterCheckbox = $('.dataTables-egreso thead input[type="checkbox"]');
        var selectedCount = Object.keys(selectedRows[tableId] || {}).length;

        // Para server-side necesitamos obtener el total de registros del DataTable
        var dataTable = $('.dataTables-egreso').DataTable();
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
        $('.dataTables-egreso tbody input[type="checkbox"]').each(function() {
            var rowId = $(this).val();
            if (selectedRows[tableId] && selectedRows[tableId][rowId]) {
                $(this).iCheck('check');
            } else {
                $(this).iCheck('uncheck');
            }
        });
        updateMasterCheckbox();
    }

    // ==============================================
    // CONFIGURACIÓN DEL DATATABLE
    // ==============================================

    $('#marcas_filter').select2({
        placeholder: "Selecciona una marca",
        allowClear: true,
        width: '100%'
    });

    $('#tab-2').addClass('active');

    var coti_table = $('.dataTables-egreso').DataTable({
        "serverSide": true,
        "ajax": {
            url: "{{ route('api.get_guia_egreso') }}",
            method: "get",
            data: function(d) {
                d.daterange = $('#data_range_filter').val();
                d.marca = $('#marcas_filter').val();
                d.procesado = $('#procesado_filter').val();
                d.value = $('#search_all_column').val();
            }
        },
        "drawCallback": function(settings) {
            // Esta función se ejecuta después de cada draw/redraw del DataTable
            initializeICheck($('.dataTables-egreso'));
            restoreCheckboxState();
            updateSelectionCounter();
        },
        "columnDefs": [{
                'width': '1vmax',
                'targets': [0],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    return '<input type="checkbox" class="i-checks" name="select_row" value="' + full[0] + '">';
                }
            },
            {
                'width': '5%',
                'targets': [1],
            },
            {
                'width': '10%',
                'targets': [2],
            },
            {
                'targets': [3],
            },
            {
                'targets': [4],
            },
            {
                'targets': [5],
            },
            {
                'targets': [6],
            },
            {
                'width': '25%',
                'targets': [7],
            },
            {
                'width': '25%',
                'targets': [8],
            },
            {
                'targets': [9],
                'width': '5%',
                'orderable': false,
                'render': function(data, type, full, meta) {
                    var url = '{{ route('garantia_guia_egreso.show', ':id') }}';
                    url = url.replace(':id', full[0]);
                    return `<div class="tooltip-demo">
                        <a href="${url}">
                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver">
                                <i class="fa fa-eye"></i>
                            </button>
                        </a>
                    </div>`;
                }
            },
            {
                'targets': [10],
                'orderable': false,
                'width': '5%',
                'render': function(data, type, full, meta) {
                    if (full[9] == 1) {
                        return `
                        <button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle" style="color:white;font-size: 110%"></i></button>

                        `;
                    } else {
                        var url = '{{ route('garantia_informe_tecnico.create_tecnico', ':id') }}';
                        url = url.replace(':id', full[0]);
                        return `
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-warning btn-circle btn-ls"><i class="fa fa-exclamation-circle" style="color:white;font-size: 110%"></i></button>
                            <a href="${url}"><button type="button" class="btn btn-info"><i class="fa fa-sign-in"></i></button></a>
                        </div>
                        `;
                    }
                }
            }
        ],
    });

    // ==============================================
    // EVENT LISTENERS
    // ==============================================

    // Inicialización inicial
    initializeICheck($(document));

    // Controlar el checkbox del thead (seleccionar/deseleccionar todos)
    $(document).on('ifChecked ifUnchecked', '.dataTables-egreso thead input[type="checkbox"]', function(event) {
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
                        $('.dataTables-egreso thead input[type="checkbox"]').iCheck('uncheck');
                    }
                });
            } else {
                selectAllRecords();
            }
        } else {
            // Deseleccionar todos
            selectedRows[tableId] = {};
            $('.dataTables-egreso tbody input[type="checkbox"]').iCheck('uncheck');
            updateSelectionCounter();
        }
    });

    // Función para seleccionar todos los registros
    function selectAllRecords() {
        // Para server-side, necesitamos hacer una petición AJAX para obtener todos los IDs
        var ajaxData = {
            daterange: $('#data_range_filter').val(),
            marca: $('#marcas_filter').val(),
            procesado: $('#procesado_filter').val(),
            value: $('#search_all_column').val(),
            get_all_ids: true // Parámetro especial para obtener solo IDs
        };

        $.ajax({
            url: "{{ route('api.get_guia_egreso') }}",
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

                $('.dataTables-egreso tbody input[type="checkbox"]').iCheck('check');
                updateMasterCheckbox();
                updateSelectionCounter();
            },
            error: function() {
                // Fallback: seleccionar solo los visibles
                console.warn('No se pudo obtener todos los IDs, seleccionando solo los visibles');
                $('.dataTables-egreso tbody input[type="checkbox"]').each(function() {
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
    $(document).on('ifChanged', '.dataTables-egreso tbody input[type="checkbox"]', function(event) {
        var rowId = $(this).val();

        if ($(this).is(':checked')) {
            selectedRows[tableId][rowId] = true;
        } else {
            delete selectedRows[tableId][rowId];
        }

        updateMasterCheckbox();
        updateSelectionCounter();
    });

    // ==============================================
    // OTROS EVENT LISTENERS
    // ==============================================

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

    $('#filter_buttons').on('click', function() {
        // Limpiar selecciones al filtrar
        selectedRows[tableId] = {};
        updateSelectionCounter();
        coti_table.ajax.reload();
    });

    $('#create_guia_ingreso').on('click', function() {
        $('#modal-form').modal('show');
    });

    $('#revert_select').on('click', function() {
        var start = moment().startOf('month');
        var end = moment().endOf('month');
        $('input[name="daterange"]').data('daterangepicker').setStartDate(start);
        $('input[name="daterange"]').data('daterangepicker').setEndDate(end);
        selectedRows[tableId] = {};
        updateSelectionCounter();
        coti_table.ajax.reload();
    });

    // ==============================================
    // FUNCIÓN DE IMPRESIÓN
    // ==============================================

    $('#bnt-imprimir').on('click', function(e) {
        e.preventDefault();

        var selectedIds = Object.keys(selectedRows[tableId] || {}).filter(function(id) {
            return selectedRows[tableId][id] === true && id !== '' && id !== 'undefined';
        });

        console.log('IDs seleccionados para impresión:', selectedIds);

        if (selectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una guía de egreso para imprimir.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        swal({
            title: "Confirmar impresión",
            text: `¿Deseas imprimir ${selectedIds.length} guía(s) de egreso seleccionada(s)?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, imprimir",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                var url = '{{ route("garantiaGuiaE.print.multiple") }}';
                var params = new URLSearchParams();

                selectedIds.forEach(function(id) {
                    params.append('guia_ids[]', id);
                });

                var finalUrl = url + '?' + params.toString();
                console.log('URL de impresión:', finalUrl);

                var printWindow = window.open(finalUrl, '_blank');

                if (printWindow) {
                    printWindow.focus();
                } else {
                    alert('Por favor, permite ventanas emergentes para imprimir');
                }

                // Opcional: limpiar selecciones después de imprimir
                // selectedRows[tableId] = {};
                // updateSelectionCounter();
                // restoreCheckboxState();
            }

        });
    });

    // Manejar click del botón de exportar
    $('#btn-exportar-filtrado').on('click', function(e) {
        e.preventDefault();

        var selectedIds = Object.keys(selectedRows[tableId] || {}).filter(function(id) {
            return selectedRows[tableId][id] === true && id !== '' && id !== 'undefined';
        });

        console.log('IDs seleccionados para exportar:', selectedIds);

        // Validar que hay guías seleccionadas
        if (selectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una guía de egreso para exportar.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // Confirmar acción
        swal({
            title: "Confirmar exportación",
            text: `¿Deseas exportar ${selectedIds.length} guía(s) seleccionada(s) a Excel?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, exportar",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                // Construir URL con los IDs seleccionados
                var exportUrl = "{{ route('garantiasE.exportar') }}";
                var params = new URLSearchParams();

                selectedIds.forEach(function(id) {
                    params.append('guia_ids[]', id);
                });

                console.log('URL de exportación:', exportUrl + '?' + params.toString());

                // Redirigir para exportar
                window.location.href = exportUrl + '?' + params.toString();

                // Mensaje de éxito
                swal({
                    title: "Procesando",
                    text: "Las guías de egreso se están exportando a Excel...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    $('#btn-descargar-filtrado').on('click', function(e) {
        e.preventDefault();

        var selectedIds = Object.keys(selectedRows[tableId] || {}).filter(function(id) {
            return selectedRows[tableId][id] === true &&
                id !== '' &&
                id !== 'undefined' &&
                !isNaN(parseInt(id));
        });

        console.log('IDs seleccionados para descargar (egreso):', selectedIds);

        if (selectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una guía de egreso para descargar.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        var mensaje = selectedIds.length === 1
            ? "¿Deseas descargar la guía de egreso seleccionada en PDF?"
            : `¿Deseas descargar ${selectedIds.length} guías de egreso en un archivo ZIP?`;

        swal({
            title: "Confirmar descarga",
            text: mensaje,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, descargar",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                // Crear formulario dinámico para enviar los IDs
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("GarantiaE.download.multiple") }}';

                // Agregar token CSRF
                var csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Agregar método spoofing
                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'POST';
                form.appendChild(methodInput);

                // Agregar cada ID seleccionado (CORRECCIÓN: usar 'guia_ids[]' en lugar de 'boleta_ids[]')
                selectedIds.forEach(function(id) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'guia_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                // Enviar formulario
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);

                swal({
                    title: "Procesando",
                    text: selectedIds.length === 1
                        ? "La guía de egreso se está descargando..."
                        : "Las guías de egreso se están comprimiendo y descargando...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // Función para enviar guías por WhatsApp múltiple
    $('#btn-whatsapp-filtrado').on('click', function(e) {
        e.preventDefault();

        // Usar la misma lógica que la descarga para obtener los IDs seleccionados
        var selectedIds = Object.keys(selectedRows[tableId] || {}).filter(function(id) {
            return selectedRows[tableId][id] === true &&
                id !== '' &&
                id !== 'undefined' &&
                !isNaN(parseInt(id));
        });

        console.log('IDs seleccionados para WhatsApp:', selectedIds);

        if (selectedIds.length === 0) {
            return swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una guía de egreso para enviar por WhatsApp.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
        }

        swal({
            title: "Enviar por WhatsApp",
            text: `Ingresa el número de WhatsApp para enviar ${selectedIds.length} guía(s) de egreso:`,
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "Enviar",
            cancelButtonText: "Cancelar",
            inputPlaceholder: "Ejemplo: 999999999"
        }, function(inputValue) {
            if (inputValue === false) return false;
            if (!inputValue) return swal.showInputError("Por favor ingresa un número de WhatsApp válido");
            if (!/^\d+$/.test(inputValue)) return swal.showInputError("Por favor ingresa solo números");

            swal.close();
            swal({
                title: "Procesando...",
                text: "Enviando guías de egreso por WhatsApp",
                type: "info",
                showConfirmButton: false,
                allowOutsideClick: false
            });

            const form = $('<form>', {
                action: '{{ route('envioWhatsapp.guiaEgreso.multiple') }}',
                method: 'POST',
                target: '_blank',
                style: 'display:none;'
            });

            form.append($('<input>', {type: 'hidden', name: '_token', value: '{{ csrf_token() }}'}));
            form.append($('<input>', {type: 'hidden', name: 'numero', value: inputValue}));

            selectedIds.forEach(id => {
                form.append($('<input>', {type: 'hidden', name: 'guia_ids[]', value: id}));
            });

            $('body').append(form);
            form.submit();
            setTimeout(() => form.remove(), 1000);
            setTimeout(() => {
                swal({
                    title: "¡Enviado!",
                    text: `Se han enviado ${selectedIds.length} guía(s) de egreso por WhatsApp`,
                    type: "success",
                    timer: 3000,
                    showConfirmButton: true
                });
            }, 500);
        });
    });

    // ==============================================
    // FUNCIONES AUXILIARES GLOBALES
    // ==============================================

    window.getSelectedIds = function() {
        return Object.keys(selectedRows[tableId] || {}).filter(function(id) {
            return selectedRows[tableId][id] === true && id !== '' && id !== 'undefined';
        });
    };

    window.clearTableSelections = function() {
        selectedRows[tableId] = {};
        restoreCheckboxState();
        updateSelectionCounter();
    };

    // Función para anular guía (ya existente)
    function anular_guia(id, valor) {
        console.log(id);
        let form = document.getElementById('formulario_anular');
        let action = form.getAttribute('action');
        action = action.replace(':id', id);
        form.setAttribute('action', action);
        $('#valor_ind').text(valor);
        $('#modal-anular').modal('show');
    }

    // Hacer la función global
    window.anular_guia = anular_guia;

    // Inicializar contador
    updateSelectionCounter();
});
    </script>

@endsection
