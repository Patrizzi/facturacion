@extends('layout')

@section('title', 'Guias Ingreso')
@section('breadcrumb', 'Guia de ingreso')
@section('breadcrumb2', 'Garantia')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/garantias/index.css')}}">
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
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                @include('transaccion.garantias._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <a class="btn btn-primary" id="create_guia_ingreso"><i class="fa fa-plus"></i></a>
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
                                            </button>
                                            <button type="button" id="btn-whatsapp-filtrado" class="dropdown-item">
                                                <i class="fa fa-whatsapp"></i> Whatsapp
                                            </button>--}}
                                        </div>
                                    </div>
                                </ul>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
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
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="" id="egresado_filter" class="form-control">
                                                    <option value="">Todos</option>
                                                    <option value="1">Egresados</option>
                                                    <option value="0">Sin Egresar</option>
                                                    <option value="3">Anulado</option>
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
                                    <!-- CONTENIDO DENTRO DEL TAB  1-->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-guia-ingreso">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <th>ID</th>
                                                    <th>Código Interno</th>
                                                    <th>Producto</th>
                                                    <th>Marca</th>
                                                    <th>Serie</th>
                                                    <th>Cliente</th>
                                                    <th>RUC</th>
                                                    <th>Fecha</th>
                                                    <th>Ver</th>
                                                    <th>Acciones</th>
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

        <!-- Agregar -->
        <div id="modal-form" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 b-r">
                                <h3 class="m-t-none m-b">Agregar</h3>
                                <p>Selecciona marca a agregar</p>
                                <form action="{{ route('garantia_guia_ingreso.create') }}" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Marca:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control m-b select-marca marca" name="marca">
                                                    @foreach ($marcas as $marca)
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                        type="submit"><strong>Grabar</strong></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-anular" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row" align="center">
                            <div class="col-sm-12 b-r">
                                <h3 class="m-t-none m-b">¿Seguro que desea anular la guía <strong><span
                                            id="valor_ind"></span></strong>?</h3>
                                <p>Esta guía se anulará inmediatamente. Esta acción no se puede deshacer</p>
                                <form id="formulario_anular" action=" {{ route('garantia_guia_ingreso.update', ':id') }} "
                                    enctype="multipart/form-data" method="post">
                                    @csrf @method('PATCH')
                                    <center><button type="submit" class="btn btn-w-m btn-danger">Anular</button></center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('transaccion.garantias._shared.js_shared')
    <!-- Seleccionar todos los check -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var selectedRows = {};
        var tableId = 'dataTables-guia-ingreso';
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
            var counter = $('.dataTables-guia-ingreso').closest('.dataTables_wrapper').find('.selection-counter');
        }

        // Función para actualizar el estado del checkbox master
        function updateMasterCheckbox() {
            var masterCheckbox = $('.dataTables-guia-ingreso thead input[type="checkbox"]');
            var selectedCount = Object.keys(selectedRows[tableId] || {}).length;

            // Para server-side necesitamos obtener el total de registros del DataTable
            var dataTable = $('.dataTables-guia-ingreso').DataTable();
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
            $('.dataTables-guia-ingreso tbody input[type="checkbox"]').each(function() {
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

        // $('#marcas_filter').select2({
        //     placeholder: "Selecciona una marca",
        //     allowClear: true,
        //     width: '100%'
        // });

        $('#tab-1').addClass('active');

        var coti_table = $('.dataTables-guia-ingreso').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_guia_ingreso') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#data_range_filter').val();
                    d.marca = $('#marcas_filter').val();
                    d.egreso = $('#egresado_filter').val();
                    d.value = $('#search_all_column').val();
                }
            },
            "drawCallback": function(settings) {
                // Esta función se ejecuta después de cada draw/redraw del DataTable
                initializeICheck($('.dataTables-guia-ingreso'));
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
                    'width': '8%',
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
                    'width': '25%',
                    'targets': [5],
                },
                {
                    'width': '25%',
                    'targets': [6],
                },
                {
                    'width': '25%',
                    'targets': [7],
                },
                {
                    'targets': [8],
                },
                {
                    'width': '5%',
                    'targets': [9],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('garantia_guia_ingreso.show', ':id') }}';
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
                    'width': '5%',
                    'targets': [10],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var concat2 = ``;
                        if (full[11] == 0) { // Si no está egresado
                            if (full[10] == 1) { // Si está activo
                                var url = '{{ route('garantia_guia_egreso.create_egreso', ':id') }}'
                                url = url.replace(':id', full[0]);
                                concat2 += `
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a data-toggle="modal" class="btn btn-warning btn-circle btn-ls" onclick="anular_guia(` + full[0] + `, '` + full[2] + `')"><i class="fa fa-trash-o" style="color:white;font-size: 110%"></i></a>
                                        <a href="${url}"><button type="button" class="btn btn-info"><i class="fa fa-sign-in"></i></button>
                                    </div>
                                `;
                            } else { // Si no está activo
                                concat2 += `<button class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle" style="color:white;font-size: 110%"></i></button>`;
                            }
                        } else { // Si está egresado
                            concat2 += `<button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle" style="color:white;font-size: 110%"></i></button>`;
                        }
                        return concat2;
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
        $(document).on('ifChecked ifUnchecked', '.dataTables-guia-ingreso thead input[type="checkbox"]', function(event) {
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
                            $('.dataTables-guia-ingreso thead input[type="checkbox"]').iCheck('uncheck');
                        }
                    });
                } else {
                    selectAllRecords();
                }
            } else {
                // Deseleccionar todos
                selectedRows[tableId] = {};
                $('.dataTables-guia-ingreso tbody input[type="checkbox"]').iCheck('uncheck');
                updateSelectionCounter();
            }
        });

        // Función para seleccionar todos los registros
        function selectAllRecords() {
            // Para server-side, necesitamos hacer una petición AJAX para obtener todos los IDs
            var ajaxData = {
                daterange: $('#data_range_filter').val(),
                marca: $('#marcas_filter').val(),
                egreso: $('#egresado_filter').val(),
                value: $('#search_all_column').val(),
                get_all_ids: true // Parámetro especial para obtener solo IDs
            };

            $.ajax({
                url: "{{ route('api.get_guia_ingreso') }}",
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

                    $('.dataTables-guia-ingreso tbody input[type="checkbox"]').iCheck('check');
                    updateMasterCheckbox();
                    updateSelectionCounter();
                },
                error: function() {
                    // Fallback: seleccionar solo los visibles
                    console.warn('No se pudo obtener todos los IDs, seleccionando solo los visibles');
                    $('.dataTables-guia-ingreso tbody input[type="checkbox"]').each(function() {
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
        $(document).on('ifChanged', '.dataTables-guia-ingreso tbody input[type="checkbox"]', function(event) {
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

            $('#modal-form').on('shown.bs.modal', function () {
    var $select = $('#modal-form .select-marca');

    // Verificar si Select2 ya está inicializado antes de destruir
    if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy');
    }

    // Inicializar Select2
    $select.select2({
        placeholder: 'Selecciona una marca...',
        allowClear: true,
        dropdownParent: $('#modal-form')
    });
});

// Limpiar Select2 al cerrar el modal
$('#modal-form').on('hidden.bs.modal', function () {
    var $select = $('#modal-form .select-marca');

    // Verificar si Select2 está inicializado antes de destruir
    if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy');
    }
});

// ALTERNAT

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
                    text: "Por favor, selecciona al menos una guía de ingreso para imprimir.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            swal({
                title: "Confirmar impresión",
                text: `¿Deseas imprimir ${selectedIds.length} guía(s) de ingreso seleccionada(s)?`,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, imprimir",
                cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (isConfirm) {
                    var url = '{{ route("garantiaGuiaI.print.multiple") }}';
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
                    text: "Por favor, selecciona al menos una guía de ingreso para exportar.",
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
                    var exportUrl = "{{ route('garantiasI.exportar') }}";
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
                        text: "Las guías de ingreso se están exportando a Excel...",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Función para descargar guías de egreso seleccionadas en PDF/ZIP
        $('#btn-descargar-filtrado').on('click', function(e) {
            e.preventDefault();

            var selectedIds = Object.keys(selectedRows[tableId] || {}).filter(function(id) {
                return selectedRows[tableId][id] === true &&
                    id !== '' &&
                    id !== 'undefined' &&
                    !isNaN(parseInt(id));
            });

            console.log('IDs seleccionados para descargar:', selectedIds);

            if (selectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una guía de ingreso para descargar.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            var mensaje = selectedIds.length === 1
                ? "¿Deseas descargar la guía de ingreso seleccionada en PDF?"
                : `¿Deseas descargar ${selectedIds.length} guías de ingreso en un archivo ZIP?`;

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
                    form.action = '{{ route("GarantiaI.download.multiple") }}';

                    // Agregar token CSRF
                    var csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Agregar método spoofing para PUT/PATCH si es necesario
                    var methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'POST';
                    form.appendChild(methodInput);

                    // Agregar cada ID seleccionado
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
                            ? "La guía de ingreso se está descargando..."
                            : "Las guías de ingreso se están comprimiendo y descargando...",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
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
