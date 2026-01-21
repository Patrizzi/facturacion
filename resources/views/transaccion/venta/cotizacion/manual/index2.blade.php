@extends('layout')

@section('title', 'Ventas | Cotización Manual')

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
                                <ul class="nav nav-tabs" role="tablist" style="align-items: center;border-bottom: 0px !important;">
                                    @include('transaccion\venta\_shared\tabs')
                                    {{-- Almacen --}}
                                    <ul class="ml-auto d-flex"
                                        style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                        {{-- Almacen --}}
                                        <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                            <a class="btn btn-primary" href="{{ route('cotizacion_manual.create') }}"><i
                                                    class="fa fa-plus"></i></a>
                                            {{-- ALMACEN --}}
                                            {{-- <button class="btn btn-primary" type="button">
                                                <i class="fa fa-upload"></i>
                                            </button> --}}
                                        </ul>
                                        <a href="#" id="btn-duplicar-cotizacion" class="btn btn-primary" title="Duplicar cotizaciones">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                        <div class="btn-group">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-download"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button type="button" id="bnt-imprimir" class="dropdown-item">
                                                    <i class="fa fa-print"></i> Imprimir
                                                </button>
                                                <button type="button" id="btn_export_cotizacionM" class="dropdown-item">
                                                    <i class="fa fa-file-excel-o"></i> Excel
                                                </button>

                                                <button type="button" id="btn-descargar-filtrado" class="dropdown-item">
                                                    <i class="fa fa-file-pdf-o"></i> PDF
                                                </button>
                                                <button type="button" id="btn-correo-filtrado" class="dropdown-item">
                                                    <i class="fa fa-envelope"></i> Correo
                                                </button>
                                                <button type="button" id="btn-whatsapp-filtrado" class="dropdown-item">
                                                    <i class="fa fa-whatsapp"></i> Whatsapp
                                                </button>
                                            </div>
                                        </div>
                                    </ul>
                                </ul>
                            </div>
                            <div class="tab-content" style="margin-top: -1px">
                                <!-- COTIZACION MANUAL-->
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
                                    <br>{{--  Tabla de Cotizacion Manual   --}}
                                    <div class="scrooll-table-responsive">
                                    </div>
                                    <div class="table-responsive">
                                        <table
                                            class="table table-striped table-bordered dataTables-example-cotizacion_manual" style="min-width: 982px">
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
                                                    <th>Compartir R.</th>
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

    @include('transaccion.venta._shared.js_shared')

    {{-- SCRIPTS PARA DATATABLE --}}
    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-2-tab').addClass('active');
        });
        var coti_table = $('.dataTables-example-cotizacion_manual').DataTable({
            "lengthChange": false,
            "responsive": true,
            "searching": false,
            "pageLength": 15,
            "serverSide": true,
            "ajax": {
                url: "{{ route('ventas.cotizacion_manual_registers') }}",
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
                    $('.dataTables-example-cotizacion_manual tfoot th.total-columna').html('Total: ' +
                        total_columna);
                    $('.dataTables-example-cotizacion_manual tfoot th.total-total').html('Total  G.: ' +
                        total_table);

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
                    'width': '30%',
                    'targets': [4]
                },
                {
                    'targets': [8], // Configuración para otra columna (como la de acciones)
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        // Generar la URL de forma dinámica usando la función route con un placeholder
                        var url = '{{ route('cotizacion_manual.show', ':id') }}';
                        url = url.replace(':id', full[
                            0]); // Reemplazar el placeholder con el valor dinámico

                        if (full[9] == '0') {
                            return `<a href="${url}"> <button type="button" class="btn btn-primary"> <i class="fa fa-eye"></i> </button> </a> <button type="button" class="btn btn-warning"><i class="fa fa-clock-o"></i></button>`;
                        } else {
                            return `<a href="${url}"> <button type="button" class="btn btn-primary"> <i class="fa fa-eye"></i> </button> </a> <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>`;
                        }
                    }
                },
                {
                    'targets': [9], // Columna de Compartir (Boton de correo sin funcionamiento por ahora)
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        const cotizacionMId = full[0];
                        const codigoCotizacionM = full[2];
                        const celularCliente = full[10] || '';
                        const emailCliente = full[11] || '';

                        return `
                            <div style="display: inline-block; white-space: nowrap;">
                                <!-- Contenedor Correo -->
                                <div class="email-container" data-id="${cotizacionId}"
                                    style="display: inline-block; position: relative; vertical-align: top; margin-right: 5px;">
                                    <button type="button" class="btn btn-secondary" style="cursor: pointer;">
                                        <i class="fa fa-envelope fa-lg"></i>
                                    </button>
                                    <div class="email-form" data-id="${cotizacionId}"
                                        style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                        overflow: hidden; transition: height .4s; background: white;
                                        box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                        z-index: 9999; white-space: nowrap; min-width: 250px;">
                                        <form class="form-enviar-email" data-cotizacion-id="${cotizacionId}" style="padding: 10px;">
                                            @csrf
                                            <div style="margin-bottom: 5px;">
                                                <input type="email" name="emails[]" placeholder="correo@ejemplo.com"
                                                    value="${emailCliente}"
                                                    style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                            </div>
                                            <div class="emails-adicionales-${cotizacionId}"></div>
                                            <button type="button" class="btn-agregar-email btn btn-info btn-xs" data-id="${cotizacionId}"
                                                    style="padding: 3px 8px; margin-bottom: 5px; font-size: 11px;">
                                                <i class="fa fa-plus"></i> Agregar correo
                                            </button>
                                            <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; float: right;">
                                                <i class="fa fa-send fa-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <!-- Contenedor WhatsApp -->
                                <div class="wsp-container" data-id="${cotizacionMId}"
                                    style="display: inline-block; position: relative; vertical-align: top;">
                                    <a class="btn btn-success" style="background: green; border-color: green; cursor: pointer;">
                                        <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                    </a>
                                    <div class="wsp-form" data-id="${cotizacionMId}"
                                        style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                        overflow: hidden; transition: height .4s; background: white;
                                        box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                        z-index: 9999; white-space: nowrap;">
                                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" target="_blank" style="padding: 10px;">
                                            @csrf
                                            <input type="tel" name="numero" placeholder="999999999" value="${celularCliente}"
                                                style="width: 130px; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                            <input type="text" name="mensaje" hidden />
                                            <input type="hidden" name="url" value="{{ route('cotizacion_manual_pdf', '') }}/${cotizacionMId}?archivo=" />
                                            <input type="hidden" name="name_sin_cambio" value="Cotización_${codigoCotizacionM}" />
                                            <button type="submit" class="btn btn-success"
                                                style="background: green; border-color: green; padding: 5px 10px; margin-left: 5px;">
                                                <i class="fa fa-send fa-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
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
        let mostrarToast = false;
        $(`#filter_buttons`).on('click', function() {
            mostrarToast = true;
            coti_table.ajax.reload();
        });
        coti_table.on('xhr.dt', function(e, settings, json, xhr) {
            if (mostrarToast) {
                toastr.success(" ",
                'Se han aplicado los filtros correctamente', {
                    timeOut: 3000
                });
                mostrarToast = false; // reseteo el flag
            }
        });
        $('#revert_select').on('click', function() {
            $('input[name="daterange"]').val("{{ date('01/m/Y') }} - {{ date('t/m/Y') }}").trigger('change');
            mostrarToast = true;
            coti_table.ajax.reload();
        });
    </script>
    <!-- Seleccionar todos los check -->
<script>
$(document).ready(function() {
    // Variables globales
    var allSelectedIds = [];
    var masterChecked = false;
    var isUpdatingCheckboxes = false; // Flag para evitar loops infinitos

    // Inicializar iCheck
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Función para obtener TODOS los IDs mediante AJAX (para serverSide DataTables)
    function getAllIds(callback) {
        $.ajax({
            url: "{{ route('ventas.cotizacion_manual_registers') }}",
            method: "GET",
            data: {
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

    // Checkbox del header - seleccionar/deseleccionar todos
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
                $('.dataTables-example-cotizacion_manual tbody input[type="checkbox"]').iCheck('check');
                isUpdatingCheckboxes = false;
            });
        } else {
            masterChecked = false;
            allSelectedIds = [];
            console.log('Master checkbox desmarcado manualmente - allSelectedIds limpio');

            isUpdatingCheckboxes = true;
            $('.dataTables-example-cotizacion_manual tbody input[type="checkbox"]').iCheck('uncheck');
            isUpdatingCheckboxes = false;
        }
    });

    // Checkboxes individuales
    $(document).on('ifChecked ifUnchecked', '.dataTables-example-cotizacion_manual tbody input[type="checkbox"]', function(event) {
        if (isUpdatingCheckboxes) return; // Evitar que se ejecute cuando estamos actualizando programáticamente

        var checkboxValue = $(this).val();

        if (event.type === 'ifChecked') {
            // Agregar ID si no está ya seleccionado
            if (!allSelectedIds.includes(checkboxValue)) {
                allSelectedIds.push(checkboxValue);
            }
            console.log('Registro seleccionado:', checkboxValue);
        } else {
            // Remover ID de la selección
            allSelectedIds = allSelectedIds.filter(function(selectedId) {
                return selectedId !== checkboxValue;
            });
            console.log('Registro deseleccionado:', checkboxValue);

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

        // Reinicializar checkboxes
        $('.dataTables-example-cotizacion_manual tbody input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Usar setTimeout para asegurar que iCheck esté completamente inicializado
        setTimeout(function() {
            isUpdatingCheckboxes = true;

            // Procesar cada checkbox en la página actual
            $('.dataTables-example-cotizacion_manual tbody input[type="checkbox"]').each(function() {
                var checkboxValue = $(this).val();

                // Si este ID está en nuestra lista de seleccionados, marcarlo
                if (allSelectedIds.includes(checkboxValue)) {
                    $(this).iCheck('check');
                } else {
                    $(this).iCheck('uncheck');
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

    // ============CORREO ============
    $(document).on('mouseenter', '.email-container', function() {
        const form = $(this).find('.email-form');
        form.css('height', (form.find('form').outerHeight() + 20) + 'px');
    });

    $(document).on('mouseenter', '.email-form', function() {
        $(this).css('height', ($(this).find('form').outerHeight() + 20) + 'px');
    });

    // Fijar cuando se hace clic en el botón de correo
    $(document).on('click', '.email-container .btn-secondary', function(e) {
        e.stopPropagation();
        const form = $(this).siblings('.email-form');
        form.addClass('email-fixed').css('height', (form.find('form').outerHeight() + 20) + 'px');
    });

    // Fijar también cuando se hace clic en el formulario o inputs
    $(document).on('click', '.email-form', function(e) {
        e.stopPropagation();
        $(this).addClass('email-fixed').css('height', ($(this).find('form').outerHeight() + 20) + 'px');
    });

    $(document).on('mouseleave', '.email-container, .email-form', function() {
        const isContainer = $(this).hasClass('email-container');
        const target = isContainer ? $(this).find('.email-form') : $(this);
        const checkElement = isContainer ? target : $(this).closest('.email-container');

        // No cerrar si está fijado
        if (target.hasClass('email-fixed')) return;

        setTimeout(() => {
            if (!target.is(':hover') && !checkElement.is(':hover')) {
                target.css('height', '0px');
            }
        }, 200);
    });

    $(document).on('click', '.btn-agregar-email', function() {
        const cotizacionId = $(this).data('id');
        const container = $(`.emails-adicionales-${cotizacionId}`);

        container.append(`
            <div style="margin-bottom: 5px; position: relative;">
                <input type="email" name="emails[]" placeholder="correo@ejemplo.com"
                    style="width: calc(100% - 30px); padding: 5px; border: 1px solid #ccc; border-radius: 3px;" />
                <button type="button" class="btn-eliminar-email btn btn-danger btn-xs"
                    style="padding: 3px 6px; position: absolute; right: 0; top: 0; height: 100%;">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        `);

        const form = $(`.email-form[data-id="${cotizacionId}"]`);
        form.css('height', (form.find('form').outerHeight() + 20) + 'px');
    });

    $(document).on('click', '.btn-eliminar-email', function() {
        const form = $(this).closest('.email-form');
        $(this).closest('div').remove();
        form.css('height', (form.find('form').outerHeight() + 20) + 'px');
    });

    // ============ ENVÍO DE CORREO AJAX ============
    $(document).on('submit', '.form-enviar-email', function(e) {
        e.preventDefault();

        const form = $(this);
        const cotizacionId = form.data('cotizacion-id');
        const button = form.find('button[type="submit"]');
        const originalHtml = button.html();
        const emailFormContainer = $(`.email-form[data-id="${cotizacionId}"]`);

        // Validar que haya al menos un email
        const emails = form.find('input[type="email"]').map(function() {
            return $(this).val();
        }).get().filter(email => email.trim() !== '');

        if (emails.length === 0) {
            toastr.warning('Debes ingresar al menos un correo electrónico', 'Atención');
            return;
        }

        // Deshabilitar botón y mostrar loading
        button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        // Mostrar toast de carga
        toastr.info('<i class="fa fa-spinner fa-spin"></i> Enviando correo, no cierre esta pestaña...', 'Procesando', {
            timeOut: 0,
            extendedTimeOut: 0,
            closeButton: false,
            tapToDismiss: false
        });

        // Preparar datos
        const formData = new FormData(form[0]);

        $.ajax({
            url: "{{ route('cotizacionM.enviar-correo-directo', '') }}/" + cotizacionId,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Limpiar todos los toasts
                toastr.clear();

                if (response.success) {
                    // Cerrar formulario
                    emailFormContainer.removeClass('email-fixed').css('height', '0px');

                    // Resetear formulario
                    form[0].reset();
                    $(`.emails-adicionales-${cotizacionId}`).empty();

                    // Mostrar mensaje de éxito con Toast
                    toastr.success(response.message, '¡Enviado!');
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function(xhr) {
                // Limpiar todos los toasts
                toastr.clear();

                let errorMsg = 'Error al enviar el correo';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }

                toastr.error(errorMsg, 'Error');
            },
            complete: function() {
                // Rehabilitar botón
                button.prop('disabled', false).html(originalHtml);
            }
        });
    });

    // Cerrar al hacer clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.email-container, .email-form').length) {
            $('.email-form').removeClass('email-fixed').css('height', '0px');
        }
    });

    // ============ WHATSAPP ============
    $(document).on('mouseenter', '.wsp-container', function() {
        $(this).find('.wsp-form').css('height', '50px');
    });

    $(document).on('mouseenter', '.wsp-form', function() {
        $(this).css('height', '50px');
    });

    $(document).on('click', '.wsp-container .btn-success', function(e) {
        e.stopPropagation();
        $(this).siblings('.wsp-form').addClass('wsp-fixed').css('height', '50px');
    });

    // Fijar también cuando se hace clic en el input o en cualquier parte del formulario
    $(document).on('click', '.wsp-form', function(e) {
        e.stopPropagation();
        $(this).addClass('wsp-fixed').css('height', '50px');
    });

    $(document).on('mouseleave', '.wsp-container, .wsp-form', function() {
        const isContainer = $(this).hasClass('wsp-container');
        const target = isContainer ? $(this).find('.wsp-form') : $(this);
        const checkElement = isContainer ? target : $(this).closest('.wsp-container');

        // No cerrar si está fijado
        if (target.hasClass('wsp-fixed')) return;

        setTimeout(() => {
            if (!target.is(':hover') && !checkElement.is(':hover')) {
                target.css('height', '0px');
            }
        }, 200);
    });

    $(document).on('submit', '.wsp-form form', function() {
        const form = $(this).closest('.wsp-form');
        form.removeClass('wsp-fixed').css('height', '0px');
    });

    // Cerrar al hacer clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.wsp-container, .wsp-form').length) {
            $('.wsp-form').removeClass('wsp-fixed').css('height', '0px');
        }
    });

    // BOTÓN DUPLICAR - SOLO UNA COTIZACIÓN
    $('#btn-duplicar-cotizacion').on('click', function(e) {
        e.preventDefault();
        console.log('IDs seleccionados:', allSelectedIds);

        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona UNA cotización para duplicar.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        if (allSelectedIds.length > 1) {
            swal({
                title: "Solo una cotización",
                text: "Solo puedes duplicar UNA cotización a la vez.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        var cotizacionId = allSelectedIds[0];

        swal({
            title: "Confirmar duplicación",
            text: "¿Deseas duplicar esta cotización?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, duplicar",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                // ✅ CORRECCIÓN: Agregar el ID como parámetro GET
                var form = $('<form>', {
                    'method': 'GET',
                    'action': '{{ route("cotizacion_manual.create") }}'
                });

                // ✅ ESTO FALTABA: Crear el input con el ID
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'id',
                    'value': cotizacionId
                }));

                $('body').append(form);
                form.submit();
            }
        });
    });

    // Función para imprimir cotizaciones manuales seleccionadas
    $('#bnt-imprimir').on('click', function(e) {
        e.preventDefault();

        console.log('IDs seleccionados para imprimir:', allSelectedIds);

        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una cotización manual para imprimir.",
                type: "warning",
                confirmButtonText: "Entendido",
                confirmButtonColor: "#2641F8"
            });
            return;
        }

        swal({
            title: "Confirmar impresión",
            text: `¿Deseas imprimir ${allSelectedIds.length} cotización(es) manual(es) seleccionada(s)?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, imprimir",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#2641F8"
        }, function(isConfirm) {
            if (isConfirm) {
                var url = '{{ route("cotizacionM.print.multiple") }}';
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
                    text: "Las cotizaciones manuales se están imprimiendo...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // Manejar click del botón de exportar
    $('#btn_export_cotizacionM').on('click', function(e) {
        e.preventDefault();

        console.log('IDs seleccionados para exportar:', allSelectedIds);

        // Validar que hay boletas seleccionadas
        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una cotización para exportar.",
                type: "warning",
                confirmButtonText: "Entendido",
                confirmButtonColor: "#2641F8"
            });
            return;
        }

        // Confirmar acción
        swal({
            title: "Confirmar exportación",
            text: `¿Deseas exportar ${allSelectedIds.length} cotizacion(es) seleccionada(s) a Excel?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, exportar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#2641F8"
        }, function(isConfirm) {
            if (isConfirm) {
                // Construir URL con los IDs seleccionados
                var exportUrl = "{{ route('exportarCotizacionM') }}";
                var params = new URLSearchParams();

                allSelectedIds.forEach(function(id) {
                    params.append('cotizacion_ids[]', id);
                });

                console.log('URL de exportación:', exportUrl + '?' + params.toString());

                // Redirigir para exportar
                window.location.href = exportUrl + '?' + params.toString();

                // Mensaje de éxito
                swal({
                    title: "Procesando",
                    text: "Las cotizaciones se están exportando a Excel...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // Función para descargar cotizaciones manuales seleccionadas en PDF/ZIP
    $('#btn-descargar-filtrado').on('click', function(e) {
        e.preventDefault();

        console.log('IDs seleccionados para descargar:', allSelectedIds);

        // Validar que hay boletas seleccionadas
        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una cotizacion manual para descargar.",
                type: "warning",
                confirmButtonText: "Entendido",
                confirmButtonColor: "#2641F8"
            });
            return;
        }

        // Mensaje personalizado según cantidad
        var mensaje = allSelectedIds.length === 1
            ? "¿Deseas descargar la cotizacion maual seleccionada en PDF?"
            : `¿Deseas descargar ${allSelectedIds.length} cotizaciones manuales en un archivo ZIP?`;

        // Confirmar acción
        swal({
            title: "Confirmar descarga",
            text: mensaje,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, descargar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#2641F8"
        }, function(isConfirm) {
            if (isConfirm) {
                // Construir URL con parámetros
                var url = '{{ route("cotizacion-manual.download.multiple") }}';
                var params = new URLSearchParams();

                allSelectedIds.forEach(function(id) {
                    params.append('cotizacion_ids[]', id);
                });

                console.log('URL de descarga:', url + '?' + params.toString());

                // Redirigir para descargar
                window.location.href = url + '?' + params.toString();

                // Mensaje de éxito
                swal({
                    title: "Procesando",
                    text: allSelectedIds.length === 1
                        ? "La cotizacion manual se está descargando..."
                        : "Las cotizaciones manual se están comprimiendo y descargando...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // Función para enviar boletas por Correo múltiple
    $('#btn-correo-filtrado').on('click', function(e) {
        e.preventDefault();

        if (allSelectedIds.length === 0) {
            return swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una cotización manual para enviar por correo.",
                type: "warning",
                confirmButtonText: "Entendido",
                confirmButtonColor: "#2641F8"
            });
        }

        swal({
            title: "Enviar por Correo",
            text: `Ingresa el correo electrónico para enviar ${allSelectedIds.length} cotizacion(es):`,
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "Enviar",
            cancelButtonText: "Cancelar",
            inputPlaceholder: "ejemplo@correo.com",
            confirmButtonColor: "#2641F8"
        }, function(inputValue) {
            if (inputValue === false) return false;
            if (!inputValue) return swal.showInputError("Por favor ingresa un correo electrónico");

            // Validar formato de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(inputValue)) {
                return swal.showInputError("Por favor ingresa un correo electrónico válido");
            }

            // Mostrar mensaje de procesando
            swal({
                title: "Enviando...",
                text: `Procesando ${allSelectedIds.length} cotizacion(es). Por favor espera...`,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });

            // Enviar por AJAX
            $.ajax({
                url: '{{ route('envioCorreo.cotizacionM.multiple') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    email: inputValue,
                    cotizacion_ids: allSelectedIds
                },
                success: function(response) {
                    if (response.success) {
                        swal({
                            title: "¡Enviado!",
                            text: response.message || `Se han enviado ${allSelectedIds.length} cotizacion(es) por correo`,
                            type: "success",
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonColor: "#2641F8"
                        });
                    } else {
                        swal({
                            title: "Error",
                            text: response.message || "Hubo un error al enviar los correos",
                            type: "error",
                            confirmButtonText: "Entendido",
                            confirmButtonColor: "#2641F8"
                        });
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Error al enviar los correos';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    swal({
                        title: "Error",
                        text: errorMsg,
                        type: "error",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#2641F8"
                    });
                }
            });
        });
    });

    // Función para enviar guias por WhatsApp multiple
    $('#btn-whatsapp-filtrado').on('click', function(e) {
        e.preventDefault();

        if (allSelectedIds.length === 0) {
            return swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una cotización para enviar por WhatsApp.",
                type: "warning",
                confirmButtonText: "Entendido",
                confirmButtonColor: "#2641F8"
            });
        }

        swal({
            title: "Enviar por WhatsApp",
            text: `Ingresa el número de WhatsApp para enviar ${allSelectedIds.length} cotización(es):`,
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "Enviar",
            cancelButtonText: "Cancelar",
            inputPlaceholder: "Ejemplo: 999999999",
            confirmButtonColor: "#2641F8"
        }, function(inputValue) {
            if (inputValue === false) return false;
            if (!inputValue) return swal.showInputError("Por favor ingresa un número de WhatsApp válido");
            if (!/^\d+$/.test(inputValue)) return swal.showInputError("Por favor ingresa solo números");

            swal.close();
            swal({
                title: "Procesando...",
                text: "Enviando cotizaciones por WhatsApp",
                type: "info",
                showConfirmButton: false,
                allowOutsideClick: false
            });

            const form = $('<form>', {
                action: '{{ route('envioWhatsapp.cotizacionM.multiple') }}',
                method: 'POST',
                target: '_blank',
                style: 'display:none;'
            });

            form.append($('<input>', {type: 'hidden', name: '_token', value: '{{ csrf_token() }}'}));
            form.append($('<input>', {type: 'hidden', name: 'numero', value: inputValue}));

            allSelectedIds.forEach(id => {
                form.append($('<input>', {type: 'hidden', name: 'cotizacion_ids[]', value: id}));
            });

            $('body').append(form);
            form.submit();
            setTimeout(() => form.remove(), 1000);
            setTimeout(() => {
                swal({
                    title: "¡Enviado!",
                    text: `Se han enviado ${allSelectedIds.length} cotizacion(es) por WhatsApp`,
                    type: "success",
                    timer: 3000,
                    showConfirmButton: true
                });
            }, 500);
        });
    });

    // Funciones helper para debugging (opcional)
    window.clearAllSelections = function() {
        allSelectedIds = [];
        masterChecked = false;
        isUpdatingCheckboxes = true;
        $('thead input[type="checkbox"]').iCheck('uncheck');
        $('.dataTables-example-cotizacion_manual tbody input[type="checkbox"]').iCheck('uncheck');
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
