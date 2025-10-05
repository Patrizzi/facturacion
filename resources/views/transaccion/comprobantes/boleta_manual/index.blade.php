@extends('layout')

@section('title', 'Comprobantes | Boleta Manual')

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
                                        <a class="btn btn-primary" href="{{ route('boleta_manual.create') }}"><i class="fa fa-plus"></i></a>
                                        {{-- ALMACEN --}}
                                        <button type="button" id="btn-imprimir" class="btn btn-primary" title="Imprimir">
                                            <i class="fa fa-print"></i>
                                        </button>
                                        <button type="button" id="btn-exportar-filtrado" class="btn btn-primary" title="Exportar a Excel">
                                            <i class="fa fa-upload"></i>
                                        </button>
                                        <button type="button" id="btn-descargar-filtrado" class="btn btn-primary" title="Descargar a PDF zip">
                                            <i class="fa fa-download"></i>
                                        </button>
                                    </ul>
                                </ul>
                            </div>
                            <div class="tab-content" style="margin-top: -1px">
                                {{-- BOLETA --}}
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
                                        <table class="table table-striped table-bordered dataTables-example-boleta" style="min-width: 982px">
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
                                                    <th>Ver</th>
                                                    <th style="width: 0.5vmax !important">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="7"></th>
                                                    <th class="total-columna">Total: 0</th>
                                                    <th colspan="2" class="total-total">Total G: 0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                {{-- BOLETA MANUAL --}}
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('transaccion/comprobantes/_shared/js_shared')

    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-2-tab').addClass('active');

        });

        //  {{-- SCRIPTS PARA DATATABLE --}}

        var coti_table = $('.dataTables-example-boleta').DataTable({
            "pageLength": 15,
            "serverSide": true,
            "ajax": {
                url: "{{ route('comprobantes.boletaM_registers') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#data_range_filter').val();
                    d.estado_s = $('#select_estado_sunat').val();
                    d.value = $('#search_all_column').val();
                },
                dataSrc: function(json) {
                    var total_columna = json.total_columna;
                    var total_table = json.total_table;

                    $('.dataTables-example-boleta tfoot th.total-columna').html('Total: ' + total_columna);
                    $('.dataTables-example-boleta tfoot th.total-total').html('Total  G.: ' + total_table);

                    return json.data;
                }
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" name="select_row" value="' + full[2] +
                            '" class="i-checks-boletaM">';
                    }
                },
                {
                    'width': '30%',
                    'targets': [4]
                },
                {
                    'width': '0.5vmax',
                    'targets': [8],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('boleta_manual.show', ':id') }}';
                        url = url.replace(':id', full[0]);
                        return `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a> `;
                    }
                },
                {
                    'targets': [9], // Configuración para otra columna (como la de acciones)
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

                        const estadoSunat = parseInt(full[9]);
                        const estadoCredito = parseInt(full[10]);
                        const estadoDebito = parseInt(full[11]);

                        const e0 = estados[estadoSunat];
                        end += `<button class="btn ${e0.clase} btn-circle btn-ls" title=" ${e0.texto}">
                                    <i class="${e0.icono}"></i>
                                </button> `;
                        // Solo muestra botón si el estado es válido y diferente de 99
                        if (estadoCredito != 99) {
                            const e1 = estados[estadoCredito];
                            end += `<button class="btn ${e1.clase} btn-circle btn-ls" title="Nota de crédito: ${e1.texto}">
                                        <i style="font-weight: 700" >NC</i>
                                    </button> `;
                        }

                        if (estadoDebito != 99) {
                            const e2 = estados[estadoDebito];
                            end += `<button class="btn ${e2.clase} btn-circle btn-ls" title="Nota de débito: ${e2.texto}">
                                        <i style="font-weight: 700" >ND</i>
                                    </button> `;
                        }

                        return end;

                    }
                }
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('.i-checks-boletaM').iCheck({
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

    <script>
        $(document).ready(function() {
            // Manejar click del botón de exportar
            $(document).on('click', '#btn-exportar-filtrado', function(e) {
                e.preventDefault();

                // Verificar si hay datos en la tabla
                var table = coti_table; // Asegúrate que esta variable coincida con tu tabla de boletasM
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

                // Si hay registros, proceder con la exportación
                // Obtener los valores actuales de los filtros (exactamente como en tu DataTable)
                var daterange = $('#data_range_filter').val();
                var value = $('#search_all_column').val(); // Cambiado de 'search' a 'value'
                var tipo_coti = $('#select_tipo_coti').val();

                // Construir la URL con parámetros
                var exportUrl = "{{ route('boletasM.exportar') }}";
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

                // Redirigir para descargar
                window.location.href = exportUrl + '?' + params.toString();
            });
        });
    </script>

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
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
    var isUpdatingCheckboxes = false; // Flag para evitar loops infinitos

    // Función para obtener TODOS los IDs mediante AJAX (para serverSide DataTables)
    function getAllIds(callback) {
        $.ajax({
            url: "{{ route('comprobantes.boletaM_registers') }}",
            method: "GET",
            data: {
                daterange: $('#data_range_filter').val(),
                tipo_comprobante: $('#select_tipo_coti').val(),
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
                console.log('Total de IDs encontrados:', ids.length);
                callback(ids);
            },
            error: function(xhr, status, error) {
                console.error('Error obteniendo todos los IDs:', error);
                callback([]);
            }
        });
    }

    // Función para actualizar el estado del master checkbox automáticamente
    function updateMasterCheckbox() {
        if (isUpdatingCheckboxes) return;

        getAllIds(function(allIds) {
            // Si hay IDs disponibles y todos están seleccionados, marcar master
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

    // Controlar el checkbox del thead
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
                $('.i-checks-boletaM').iCheck('check');
                isUpdatingCheckboxes = false;
            });
        } else {
            masterChecked = false;
            allSelectedIds = [];
            console.log('Master checkbox desmarcado manualmente - allSelectedIds limpio');

            isUpdatingCheckboxes = true;
            $('.i-checks-boletaM').iCheck('uncheck');
            isUpdatingCheckboxes = false;
        }
    });

    // Controlar checkboxes individuales
    $(document).on('ifChecked ifUnchecked', '.i-checks-boletaM', function(event) {
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

                // Cuando se desmarca individualmente, salir del modo master
                if (masterChecked) {
                    masterChecked = false;
                    isUpdatingCheckboxes = true;
                    $('thead input[type="checkbox"]').iCheck('uncheck');
                    isUpdatingCheckboxes = false;
                    console.log('Master checkbox desmarcado por deselección individual');
                }
            }

            console.log('allSelectedIds después de checkbox individual:', allSelectedIds);

            // AQUÍ ESTÁ LA MAGIA: Verificar automáticamente si todos están seleccionados
            setTimeout(updateMasterCheckbox, 50);
        }
    });

    // Detectar cuando se cambia de tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var activeTab = $(e.target).attr('href');
        $(activeTab).find('.i-checks').iCheck('update');
    });

    // Cuando se redibuje la tabla (cambio de página, filtros, etc.)
    coti_table.on('draw', function() {
        console.log('Tabla redibujada. allSelectedIds actual:', allSelectedIds);
        console.log('masterChecked actual:', masterChecked);

        // Reinicializar iCheck para los nuevos elementos
        $('.i-checks-boletaM').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Usar setTimeout para asegurar que iCheck esté completamente inicializado
        setTimeout(function() {
            isUpdatingCheckboxes = true;

            // Procesar cada checkbox en la página actual
            $('.i-checks-boletaM').each(function() {
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

    // Función para imprimir boletas manuales seleccionadas
    $('#btn-imprimir').on('click', function(e) {
        e.preventDefault();

        console.log('IDs seleccionados para imprimir:', allSelectedIds);

        // Validar que hay boletas seleccionadas
        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una boleta manual para imprimir.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // Confirmar acción
        swal({
            title: "Confirmar impresión",
            text: `¿Deseas imprimir ${allSelectedIds.length} boleta(s) manual(es) seleccionada(s)?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, imprimir",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                // Construir URL con parámetros GET
                var url = '{{ route("boletaM.print.multiple") }}';
                var params = new URLSearchParams();

                allSelectedIds.forEach(function(id) {
                    params.append('boletaM_ids[]', id);
                });

                console.log('URL completa:', url + '?' + params.toString());

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
                    text: "Las boletas manuales se están imprimiendo...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // Funciones helper para debugging (opcional)
    window.clearAllSelections = function() {
        allSelectedIds = [];
        masterChecked = false;
        isUpdatingCheckboxes = true;
        $('thead input[type="checkbox"]').iCheck('uncheck');
        $('.i-checks-boletaM').iCheck('uncheck');
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
