@extends('layout')

@section('title', 'Ventas | Renovaciones')


@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- RESUMEN--}}
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
                           @include('transaccion.venta._shared.statistics')
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
                                @include('transaccion.venta._shared.tabs')
                                {{-- Almacen --}}
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-download"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button type="button" id="bnt-imprimir" class="dropdown-item">
                                                <i class="fa fa-print"></i> Imprimir
                                            </button>
                                            <button type="button" id="btn_export_renovacion" class="dropdown-item">
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
                                            <div class="row">
                                                <div class="col-6 pr-1">
                                                    <select class="form-control" id="select_tipo_coti">
                                                        <option value="" selected>Comprobantes</option>
                                                        <option value="factura">Factura</option>
                                                        <option value="boleta">Boleta</option>
                                                        <option value="nota_venta">Nota de Venta</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 pl-1">
                                                    <select id="select_estado_renovacion" class="form-control">
                                                        <option value="">Estados</option>
                                                        <option value="1">Activa</option>
                                                        <option value="2">Por vencer</option>
                                                        <option value="4">Vencida</option>
                                                    </select>
                                                </div>
                                            </div>
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
                                                <th>Emisión</th>
                                                <th>Vencimiento</th>
                                                <th>Dias</th>
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
                                                <th colspan="9"></th>
                                                <th class="total-columna">Total: 0</th>
                                                <th class="total-total">Total G: 0</th>
                                                <th></th>
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
            var allSelectedIds = [];
            var masterChecked = false;
            var isUpdatingCheckboxes = false;
            // Función para enviar boletas por Correo múltiple
            $('#btn-correo-filtrado').on('click', function (e) {
                e.preventDefault();

                if (allSelectedIds.length === 0) {
                    return swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una cotización para enviar por correo.",
                        type: "warning",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#1a3bb3"
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
                    confirmButtonColor: "#1a3bb3"
                }, function (inputValue) {
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
                        url: '{{ route('envioCorreo.renovacion.multiple') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            email: inputValue,
                            cotizacion_ids: allSelectedIds
                        },
                        success: function (response) {
                            if (response.success) {
                                swal({
                                    title: "¡Enviado!",
                                    text: response.message || `Se han enviado ${allSelectedIds.length} cotizacion(es) por correo`,
                                    type: "success",
                                    timer: 3000,
                                    showConfirmButton: true,
                                    confirmButtonColor: "#1a3bb3"
                                });
                            } else {
                                swal({
                                    title: "Error",
                                    text: response.message || "Hubo un error al enviar los correos",
                                    type: "error",
                                    confirmButtonText: "Entendido",
                                    confirmButtonColor: "#1a3bb3"
                                });
                            }
                        },
                        error: function (xhr) {
                            let errorMsg = 'Error al enviar los correos';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            swal({
                                title: "Error",
                                text: errorMsg,
                                type: "error",
                                confirmButtonText: "Entendido",
                                confirmButtonColor: "#1a3bb3"
                            });
                        }
                    });
                });
            });
            // "ACTIVA EL TAB DE RENOVACIÓN"
            $('#tab-renovacion').addClass('active');

            $('#tab-5-tab').addClass('active');
            // Variables globales para checkbox múltiple
            var allSelectedIds = [];
            var masterChecked = false;
            var isUpdatingCheckboxes = false;

            function hasAnySelection() {
                return Array.isArray(allSelectedIds) && allSelectedIds.length > 0;
            }

            function closeWhatsappPanels() {
                $('.wsp-form').removeClass('wsp-fixed').css('height', '0px');
            }

            function closeEmailPanels() {
                $('.email-form').removeClass('email-fixed').css('height', '0px');
            }

            // Inicializar iCheck
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            function getAllIds(callback) {
                $.ajax({
                    url: "{{ route('ventas.renovacion_registers') }}", // ← misma ruta que el datatable
                    method: "GET",
                    data: {
                        daterange: $('#data_range_filter').val(),
                        tipo_renovacion: $('#select_tipo_coti').val(),
                        value: $('#search_all_column').val(),
                        estado_renovacion: $('#select_estado_renovacion').val(),
                        length: -1,
                        start: 0
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
                    url: "{{route('ventas.renovacion_registers')}}", // ← CAMBIA ESTO (URL directa)
                    method: "get",
                    data: function(d) {
                        d.daterange = $('#data_range_filter').val();
                        d.tipo_renovacion = $('#select_tipo_coti').val();
                        d.value = $('#search_all_column').val();
                        d.estado_renovacion = $('#select_estado_renovacion').val();
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
                    'targets': [10], // Acciones
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        // ✅ Detectar tipo usando full[12]
                        var url;
                        if (full[12] === 'manual') {
                            url = '{{ route('cotizacion_manual.show', ':id') }}';
                        } else {
                            url = '{{ route('cotizacion.show', ':id') }}';
                        }
                        url = url.replace(':id', full[1]);

                        if (full[11] == '0') {
                            return `<a href="${url}">
                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ver">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Procesado">
                                        <i class="fa fa-clock-o"></i>
                                    </button>`;
                        } else {
                            return `<a href="${url}">
                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ver">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Sin Procesar">
                                        <i class="fa fa-check-circle"></i>
                                    </button>`;
                        }
                    }
                },
                {
                    'targets': [11], // Compartir R.
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        const renovacionId = full[0];
                        const codigoRenovacion = full[2];
                        const celularCliente = full[13] || '';
                        const emailCliente = full[14] || '';
                        const tipoCotizacion = full[12] || '';
                        const nombreArchivo = tipoCotizacion === 'manual'
                            ? `Cotizacion_Manual_${codigoRenovacion}`
                            : `Cotizacion_${codigoRenovacion}`;

                        return `
                            <div style="display: inline-block; white-space: nowrap;">
                                <!-- Contenedor Correo -->
                                <div class="email-container" data-id="${renovacionId}"
                                    style="display: inline-block; position: relative; vertical-align: top; margin-right: 5px;">
                                    <button type="button" class="btn btn-secondary" style="cursor: pointer;">
                                        <i class="fa fa-envelope fa-lg"></i>
                                    </button>
                                    <div class="email-form" data-id="${renovacionId}"
                                        style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                        overflow: hidden; transition: height .4s; background: white;
                                        box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                        z-index: 9999; white-space: nowrap; min-width: 250px;">
                                        <form class="form-enviar-email-renovacion" data-renovacion-id="${renovacionId}" style="padding: 10px;">
                                            @csrf
                                            <div style="margin-bottom: 5px;">
                                                <input type="email" name="emails[]" placeholder="correo@ejemplo.com"
                                                    value="${emailCliente}"
                                                    style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                            </div>
                                            <div class="emails-adicionales-renovacion-${renovacionId}"></div>
                                            <button type="button" class="btn-agregar-email-renovacion btn btn-info btn-xs" data-id="${renovacionId}"
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
                                <div class="wsp-container" data-id="${renovacionId}"
                                    style="display: inline-block; position: relative; vertical-align: top;">
                                    <a class="btn btn-success" style="background: green; border-color: green; cursor: pointer;">
                                        <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                    </a>
                                    <div class="wsp-form" data-id="${renovacionId}"
                                        style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                        overflow: hidden; transition: height .4s; background: white;
                                        box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                        z-index: 9999; white-space: nowrap;">
                                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" target="_blank" style="padding: 10px;">
                                            @csrf
                                            <input type="tel" name="numero" placeholder="999999999" value="${celularCliente}"
                                                style="width: 130px; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                            <input type="text" name="mensaje" hidden />
                                            <input type="hidden" name="url" value="{{ url('renovacion/pdf') }}/${renovacionId}">
                                            <input type="hidden" name="name_sin_cambio" value="${nombreArchivo}" />
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

            // Imprimir renovaciones seleccionadas
            $('#bnt-imprimir').on('click', function(e) {
                e.preventDefault();

                console.log('IDs de renovaciones seleccionados:', allSelectedIds);

                if (allSelectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una renovación para imprimir.",
                        type: "warning",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#1a3bb3"
                    });
                    return;
                }

                swal({
                    title: "Confirmar impresión",
                    text: `¿Deseas imprimir ${allSelectedIds.length} renovación(es) seleccionada(s)?`,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Sí, imprimir",
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#1a3bb3"
                }, function(isConfirm) {
                    if (isConfirm) {
                        // **CAMBIO AQUÍ: usar una ruta diferente para renovaciones**
                        var url = '{{route("renovaciones.print.multiple")}}';

                        var params = new URLSearchParams();

                        allSelectedIds.forEach(function(id) {
                            // Enviar IDs de renovaciones, no de cotizaciones
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

            // Manejar click del botón de exportar renovaciones
            $('#btn_export_renovacion').on('click', function(e) {
                e.preventDefault();

                // Validar que hay renovaciones seleccionadas
                if (allSelectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una renovación para exportar.",
                        type: "warning",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#1a3bb3"
                    });
                    return;
                }

                // Confirmar acción
                swal({
                    title: "Confirmar exportación",
                    text: `¿Deseas exportar ${allSelectedIds.length} renovación(es) seleccionada(s) a Excel?`,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Sí, exportar",
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#1a3bb3"
                }, function(isConfirm) {
                    if (!isConfirm) return;

                    $('#btn_export_cotizaciones').prop('disabled', true);

                    $.ajax({
                        url: "{{ route('exportarRenovaciones') }}",
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({ renovacion_ids: allSelectedIds }),
                        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        xhrFields: { responseType: 'blob' },
                        complete: () => $('#btn_export_renovacion').prop('disabled', false),
                        success: function (blob) {
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = `Renovaciones_${new Date().toISOString().slice(0, 10)}.xlsx`;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        }
                    });
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
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#1a3bb3"
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
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#1a3bb3"
                }, function(isConfirm) {
                    if (isConfirm) {
                        var url = '{{route("renovaciones.download.multiple")}}';
                        var params = new URLSearchParams();

                        allSelectedIds.forEach(function(id) {
                            params.append('cotizacion_ids[]', id);
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

            // ============ WHATSAPP ============
            $(document).on('click', '.wsp-container .btn-success', function (e) {
                if (hasAnySelection()) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeWhatsappPanels();
                    return;
                }

                e.stopPropagation();
                $(this).siblings('.wsp-form').addClass('wsp-fixed').css('height', '50px');
            });

            // Fijar también cuando se hace clic dentro del formulario
            $(document).on('click', '.wsp-form', function (e) {
                if (hasAnySelection()) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeWhatsappPanels();
                    return;
                }

                e.stopPropagation();
                $(this).addClass('wsp-fixed').css('height', '50px');
            });

            $(document).on('submit', '.wsp-form form', function () {
                const form = $(this).closest('.wsp-form');
                form.removeClass('wsp-fixed').css('height', '0px');
            });

            // Cerrar al hacer clic fuera
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.wsp-container, .wsp-form').length) {
                    $('.wsp-form').removeClass('wsp-fixed').css('height', '0px');
                }
            });

            // ============ CORREO ============
            $(document).on('click', '.email-container .btn-secondary', function (e) {
                if (hasAnySelection()) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeEmailPanels();
                    return;
                }

                e.stopPropagation();
                const form = $(this).siblings('.email-form');
                form.addClass('email-fixed').css('height', (form.find('form').outerHeight() + 20) + 'px');
            });

            $(document).on('click', '.email-form', function (e) {
                if (hasAnySelection()) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeEmailPanels();
                    return;
                }

                e.stopPropagation();
                $(this).addClass('email-fixed').css('height', ($(this).find('form').outerHeight() + 20) + 'px');
            });

            // Cerrar al hacer clic fuera
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.email-container, .email-form').length) {
                    $('.email-form').removeClass('email-fixed').css('height', '0px');
                }
            });

            $(document).on('click', '.btn-agregar-email-renovacion', function () {
                const renovacionId = $(this).data('id');
                const container = $(`.emails-adicionales-renovacion-${renovacionId}`);

                container.append(`
                    <div style="margin-bottom: 5px; position: relative;">
                        <input type="email" name="emails[]" placeholder="correo@ejemplo.com"
                            style="width: calc(100% - 30px); padding: 5px; border: 1px solid #ccc; border-radius: 3px;" />
                        <button type="button" class="btn-eliminar-email-renovacion btn btn-danger btn-xs"
                            style="padding: 3px 6px; position: absolute; right: 0; top: 0; height: 100%;">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `);

                const form = $(`.email-form[data-id="${renovacionId}"]`);
                form.css('height', (form.find('form').outerHeight() + 20) + 'px');
            });

            $(document).on('click', '.btn-eliminar-email-renovacion', function () {
                const form = $(this).closest('.email-form');
                $(this).closest('div').remove();
                form.css('height', (form.find('form').outerHeight() + 20) + 'px');
            });

            $(document).on('submit', '.form-enviar-email-renovacion', function (e) {
                e.preventDefault();

                const form = $(this);
                const renovacionId = form.data('renovacion-id');
                const button = form.find('button[type="submit"]');
                const originalHtml = button.html();
                const emailFormContainer = $(`.email-form[data-id="${renovacionId}"]`);

                const emails = form.find('input[type="email"]').map(function () {
                    return $(this).val();
                }).get().filter(email => email.trim() !== '');

                if (emails.length === 0) {
                    toastr.warning('Debes ingresar al menos un correo electrónico', 'Atención');
                    return;
                }

                button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                toastr.info('<i class="fa fa-spinner fa-spin"></i> Preparando envío...', 'Procesando', {
                    timeOut: 0,
                    extendedTimeOut: 0,
                    closeButton: false,
                    tapToDismiss: false
                });

                const formData = new FormData(form[0]);

                $.ajax({
                    url: "{{ route('renovacion.enviar-correo-directo', '') }}/" + renovacionId,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        toastr.clear();

                        if (response.success) {
                            emailFormContainer.removeClass('email-fixed').css('height', '0px');
                            toastr.success(response.message, 'Correcto');
                        } else {
                            toastr.error(response.message || 'No se pudo procesar la solicitud', 'Error');
                        }
                    },
                    error: function (xhr) {
                        toastr.clear();

                        let errorMsg = 'Error al procesar el correo';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        toastr.error(errorMsg, 'Error');
                    },
                    complete: function () {
                        button.prop('disabled', false).html(originalHtml);
                    }
                });
            });
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
