@extends('layout')

@section('title', 'Comprobantes | Guia de Remision Manual')

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
                        @include('transaccion.comprobantes._shared.statistics')
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
                                @include('transaccion.comprobantes._shared.tabs')
                                {{-- Almacen --}}
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                    {{-- ALMACEN --}}
                                    <a class="btn btn-primary" href="{{ route('guia_remision_manual.create') }}"><i class="fa fa-plus"></i></a>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-download"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button type="button" id="btn-imprimir-seleccion-grm" class="dropdown-item">
                                                <i class="fa fa-print"></i> Imprimir
                                            </button>
                                            <button type="button" id="btn-exportar-grm" class="dropdown-item">
                                                <i class="fa fa-file-excel-o"></i> Excel
                                            </button>

                                            <button type="button" id="btn-descargar-grm"class="dropdown-item">
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
                            <div role="tabpanel" id="tab-5" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                <br> {{-- FILTRADO DE DATOS --}}
                                <div class="search-responsive">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="daterange" id="data_range_filter" value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" readonly="readonly" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary" id="revert_select">
                                                        <i class="fa fa-history"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <input type="search" class="form-control" placeholder="Buscar:" id="search_all_column">
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
                                            <button type="button" class="btn btn-block btn-primary" id="filter_buttons">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <br>{{-- Tabla de Cotizacion Manual   --}}
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
                                                <th>Compartir R.</th>
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
@include('transaccion.comprobantes._shared.js_shared')
<script>
    /* =========================
     *  Navegación / pestañas
     * ========================= */
    $(document).ready(function() {
        $('.dataTables-example-guia-remision thead input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
        });

        $('#tab-8-tab').addClass('active');
        var $bottom = $('.tabs-scroll-bottom');
        var $nav = $bottom.find('.nav-custom');
        var $tab = $nav.find('li').eq(7);
        if ($tab.length) {
            var target = $tab[0].offsetLeft - ($bottom.innerWidth() / 2) + ($tab.outerWidth(true) / 2);
            $bottom.animate({
                scrollLeft: target
            }, 600);
        }
    });

    /* =========================
     *  Variables globales
     * ========================= */
    var allSelectedIds = []; // IDs seleccionados (persisten entre páginas)
    var masterChecked = false; // Estado del checkbox maestro
    var isUpdatingCheckboxes = false; // Evita bucles al marcar por código

    /* =========================
     *  DataTable
     * ========================= */
    var coti_table = $('.dataTables-example-guia-remision').DataTable({
        pageLength: 15
        , serverSide: true
        , ajax: {
            url: "{{ route('comprobantes.guiaRemisionM_registers') }}"
            , method: "get"
            , data: function(d) {
                d.daterange = $('#data_range_filter').val();
                d.estado_s = $('#select_estado_sunat').val();
                d.value = $('#search_all_column').val();
            }
        }
        , columnDefs: [{
                width: '1vmax'
                , targets: [0]
                , orderable: false
                , render: function(data, type, full) {
                    return '<input type="checkbox" name="select_row" value="' + full[0] + '" class="i-checks-grm">';
                }
            }
            , {
                width: '0.5vmax'
                , targets: [7]
                , orderable: false
                , render: function(data, type, full) {
                    var url = "{{ url('guia_remision_manual') }}/" + full[0];
                    return '<a href="' + url + '"><button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button></a>';
                }
            }
            , {
                targets: [8]
                , orderable: false
                , render: function(data, type, full) {
                    const estados = {
                        0: {
                            texto: "Sin Enviar"
                            , clase: "btn-warning"
                            , icono: "fa fa-clock-o"
                        }
                        , 1: {
                            texto: "Enviado"
                            , clase: "btn-info"
                            , icono: "fa fa-check-circle"
                        }
                        , 2: {
                            texto: "Anulado"
                            , clase: "btn-danger"
                            , icono: "fa fa-check-circle"
                        }
                    };
                    const e0 = estados[parseInt(full[8])] || estados[0];
                    return '<button class="btn ' + e0.clase + ' btn-circle btn-ls" title="' + e0.texto + '"><i class="' + e0.icono + '"></i></button>';
                }
            },
            {
                    'targets': [9], // Columna de Compartir (Boton de correo sin funcionamiento por ahora)
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        const guiaId = full[0];
                        const codigoGuia = full[2];
                        const celularCliente = full[9] || '';
                        const emailCliente = full[10] || '';

                        return `
                            <div style="display: inline-block; white-space: nowrap;">
                                <!-- Contenedor Correo -->
                                <div class="email-container" data-id="${guiaId}"
                                    style="display: inline-block; position: relative; vertical-align: top; margin-right: 5px;">
                                    <button type="button" class="btn btn-secondary" style="cursor: pointer;">
                                        <i class="fa fa-envelope fa-lg"></i>
                                    </button>
                                    <div class="email-form" data-id="${guiaId}"
                                        style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                        overflow: hidden; transition: height .4s; background: white;
                                        box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                        z-index: 9999; white-space: nowrap; min-width: 250px;">
                                        <form class="form-enviar-email" data-guia-id="${guiaId}" style="padding: 10px;">
                                            @csrf
                                            <div style="margin-bottom: 5px;">
                                                <input type="email" name="emails[]" placeholder="correo@ejemplo.com"
                                                    value="${emailCliente}"
                                                    style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                            </div>
                                            <div class="emails-adicionales-${guiaId}"></div>
                                            <button type="button" class="btn-agregar-email btn btn-info btn-xs" data-id="${guiaId}"
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
                                <div class="wsp-container" data-id="${guiaId}"
                                    style="display: inline-block; position: relative; vertical-align: top;">
                                    <a class="btn btn-success" style="background: green; border-color: green; cursor: pointer;">
                                        <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                    </a>
                                    <div class="wsp-form" data-id="${guiaId}"
                                        style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                        overflow: hidden; transition: height .4s; background: white;
                                        box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                        z-index: 9999; white-space: nowrap;">
                                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" target="_blank" style="padding: 10px;">
                                            @csrf
                                            <input type="tel" name="numero" placeholder="999999999" value="${celularCliente}"
                                                style="width: 130px; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                            <input type="text" name="mensaje" hidden />
                                            <input type="hidden" name="url" value="{{ route('remision_m.pdf', '') }}/${guiaId}?archivo=" />
                                            <input type="hidden" name="name_sin_cambio" value="GuíaRemisión_${codigoGuia}" />
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
        ]
        , drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    /* =========================
     *  Date Range Picker
     * ========================= */
    $('input[name="daterange"]').daterangepicker({
        locale: {
            separator: " | "
            , applyLabel: "Guardar"
            , cancelLabel: "Cancelar"
            , fromLabel: "Desde"
            , toLabel: "Hasta"
            , customRangeLabel: "Custom"
            , daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
            , monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
            , firstDay: 1
        }
    });

    /* =========================
     *  Buscar / refrescar
     * ========================= */
    $('#filter_buttons').on('click', function() {
        coti_table.ajax.reload();
    });

    /* =========================
     *  Exportar Excel
     * =========================
    $(document).on('click', '#btn-exportar-grm', function(e) {
        e.preventDefault();
        var info = coti_table.page.info();
        if (info.recordsDisplay === 0) {
            if (window.swal) {
                swal({
                    title: "No hay registros"
                    , text: "No hay registros para exportar con los filtros aplicados."
                    , type: "warning"
                    , confirmButtonText: "Entendido"
                });
            } else {
                alert("No hay registros para exportar con los filtros aplicados.");
            }
            return;
        }
        var daterange = $('#data_range_filter').val();
        var value = $('#search_all_column').val();
        var params = new URLSearchParams();
        if (daterange) params.append('daterange', daterange);
        if (value) params.append('value', value);
        window.location.href = "{{ route('guias.manual.exportar') }}?" + params.toString();
    });*/

    /* =========================
     *  Utilidad: obtener TODOS los IDs filtrados
     * ========================= */
    function getAllIds(callback) {
    $.ajax({
        url: "{{ route('comprobantes.guiaRemisionM_registers') }}"
        , method: "GET"
        , data: {
            daterange: $('#data_range_filter').val()
            , estado_s: $('#select_estado_sunat').val()
            , value: $('#search_all_column').val()
            , length: -1
            , start: 0
            , get_all_ids: true
        }
    }).done(function(response) {
        // console.log('Respuesta completa del servidor:', response);

        var ids = [];

        // ✅ Cambia esto para leer de response.ids
        if (response.ids && response.ids.length > 0) {
            ids = response.ids.map(function(id) {
                return String(id);
            });
        }
        // Fallback al formato anterior (por si acaso)
        else if (response.data && response.data.length > 0) {
            response.data.forEach(function(row) {
                if (row[0]) ids.push(String(row[0]));
            });
        }

        // console.log('IDs extraídos:', ids);
        callback(ids);
    }).fail(function(xhr, status, error) {
        // console.error('Error AJAX:', error, xhr.responseText);
        callback([]);
    });
}

    /* =========================
     *  Sincroniza maestro automáticamente
     * ========================= */
    function updateMasterCheckbox() {

        if (isUpdatingCheckboxes) return;
        getAllIds(function(allIds) {
            var allSelected = allIds.length > 0 && allIds.every(function(id) {
                return allSelectedIds.includes(String(id));
            });
            isUpdatingCheckboxes = true;
            var $head = $('.dataTables-example-guia-remision thead input[type="checkbox"]');
            if (allSelected) {
                masterChecked = true;
                if ($.fn.iCheck) $head.iCheck('check');
                else $head.prop('checked', true);
            } else {
                masterChecked = false;
                if ($.fn.iCheck) $head.iCheck('uncheck');
                else $head.prop('checked', false);
            }
            isUpdatingCheckboxes = false;
        });
    }

    /* =========================
     *  Listener DELEGADO del checkbox del header
     * ========================= */
        $(document).on('ifChecked ifUnchecked change', '.dataTables-example-guia-remision thead input[type="checkbox"]', function(event) {
        if (isUpdatingCheckboxes) return;

        var checked = (event.type === 'ifChecked') || $(this).prop('checked');

        if (checked) {
            getAllIds(function(ids) {
                allSelectedIds = (ids || []).map(String);
                masterChecked = true; // ✅ Mover aquí

                // Marca visualmente los visibles
                isUpdatingCheckboxes = true;
                if ($.fn.iCheck) {
                    $('.i-checks-grm').iCheck('check');
                } else {
                    $('.i-checks-grm').prop('checked', true).trigger('change');
                }
                isUpdatingCheckboxes = false;

                // console.log('Master marcado. IDs:', allSelectedIds); // Para verificar
            });
        } else {
            masterChecked = false;
            allSelectedIds = [];
            isUpdatingCheckboxes = true;
            if ($.fn.iCheck) {
                $('.i-checks-grm').iCheck('uncheck');
            } else {
                $('.i-checks-grm').prop('checked', false).trigger('change');
            }
            isUpdatingCheckboxes = false;
        }
    });

    /* =========================
     *  Checkboxes de filas (delegado)
     * ========================= */
    $(document).on('ifChecked ifUnchecked change', '.i-checks-grm', function(event) {
        if (isUpdatingCheckboxes) return;

        var row = $(this).closest('tr');

        var data = coti_table.row(row).data();
        var id = data ? String(data[0]) : String($(this).val());
        if (!id) return;

        var checked = (event.type === 'ifChecked') || $(this).prop('checked');

        if (checked) {
            if (!allSelectedIds.includes(id)) allSelectedIds.push(id);
        } else {
            allSelectedIds = allSelectedIds.filter(function(x) {
                return x !== id;
            });

            if (masterChecked) {
                masterChecked = false;
                isUpdatingCheckboxes = true;
                var $head = $('.dataTables-example-guia-remision thead input[type="checkbox"]');
                if ($.fn.iCheck) $head.iCheck('uncheck');
                else $head.prop('checked', false);
                isUpdatingCheckboxes = false;
            }
        }

        if ($.fn.iCheck) {
            if (checked) {
                $(this).iCheck('check');
            } else {
                $(this).iCheck('uncheck');
            }
        }
        setTimeout(updateMasterCheckbox, 50);
    });

    /* =========================
     *  En cada draw: re-inicializa iCheck, reaplica selección y sincroniza header
     * ========================= */
/* =========================
 *  En cada draw: re-inicializa iCheck, reaplica selección y sincroniza header
 * ========================= */
coti_table.on('draw', function() {
    $('[data-toggle="tooltip"]').tooltip();

    $('.i-checks-grm').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    setTimeout(function() {
        isUpdatingCheckboxes = true;
        // console.log('masterChecked:', masterChecked);
        // console.log('allSelectedIds:', allSelectedIds);

        $('.i-checks-grm').each(function() {
            var row = $(this).closest('tr');
            var rowData = coti_table.row(row).data();

            if (rowData && rowData[0]) {
                var id = rowData[0].toString();

                if (allSelectedIds.includes(id)) {
                    $(this).iCheck('check');
                } else {
                    $(this).iCheck('uncheck');
                }
            }
        });

        if (masterChecked) {
            $('.dataTables-example-guia-remision thead input[type="checkbox"]').iCheck('check');
        } else {
            $('.dataTables-example-guia-remision thead input[type="checkbox"]').iCheck('uncheck');
        }

        isUpdatingCheckboxes = false;
    }, 150);
});

    /* =========================
     *  Confirmación (SweetAlert v1 o confirm nativo)
     * ========================= */
    function askConfirm(message, onYes) {
        if (window.swal && typeof swal === 'function') {
            swal({
                title: "Confirmar impresión"
                , text: message
                , type: "info"
                , showCancelButton: true
                , confirmButtonText: "Sí, imprimir"
                , cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (isConfirm) onYes();
            });
            return;
        }
        if (confirm(message)) onYes();
    }

    // ============CORREO ============
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

    $(document).on('click', '.btn-agregar-email', function() {
        const guiaId = $(this).data('id');
        const container = $(`.emails-adicionales-${guiaId}`);

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

        const form = $(`.email-form[data-id="${guiaId}"]`);
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
        const guiaId = form.data('guia-id');
        const button = form.find('button[type="submit"]');
        const originalHtml = button.html();
        const emailFormContainer = $(`.email-form[data-id="${guiaId}"]`);

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
            url: "{{ route('guiaRemisionM.enviar-correo-directo', '') }}/" + guiaId,
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
                    $(`.emails-adicionales-${guiaId}`).empty();

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
    $(document).on('click', '.wsp-container .btn-success', function(e) {
        e.stopPropagation();
        $(this).siblings('.wsp-form').addClass('wsp-fixed').css('height', '50px');
    });

    // Fijar también cuando se hace clic en el input o en cualquier parte del formulario
    $(document).on('click', '.wsp-form', function(e) {
        e.stopPropagation();
        $(this).addClass('wsp-fixed').css('height', '50px');
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

    $(document).on('click', '#btn-imprimir-seleccion-grm', function(e) {
        e.preventDefault();

        var info = coti_table.page.info();
        var cantidadReal = masterChecked ? (info.recordsDisplay || 0) : allSelectedIds.length;

        if ((!masterChecked && allSelectedIds.length === 0) || (masterChecked && cantidadReal === 0)) {
            if (window.swal) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una guía para imprimir.",
                    type: "warning",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#1a3bb3"
                });
            } else {
                alert("Por favor, selecciona al menos una guía para imprimir.");
            }
            return;
        }

        askConfirm("¿Deseas imprimir " + cantidadReal + " guía(s) seleccionada(s)?", function() {
            var baseUrl = "{{ route('guia_remision_manual.print.multiple') }}";
            var params = new URLSearchParams();

            if (masterChecked) {
                params.set('select_all', 1);
                params.set('daterange', $('#data_range_filter').val());
                params.set('estado_s', $('#select_estado_sunat').val());
                params.set('value', $('#search_all_column').val());
            } else {
                allSelectedIds.forEach(function(id) {
                    params.append('guia_ids[]', id);
                });
            }

            var url = baseUrl + '?' + params.toString();
            var win = window.open(url, '_blank');

            if (window.swal) {
                swal({
                    title: "Procesando",
                    text: "Las guías se están abriendo en una nueva pestaña…",
                    type: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
            }

            if (!win || win.closed || typeof win.closed === 'undefined') {
                console.warn('El navegador bloqueó la ventana emergente.');
            }
        });
    });

    // Manejar click del botón de exportar
    $('#btn-exportar-grm').on('click', function(e) {
        e.preventDefault();

        // Validar que hay boletas seleccionadas
        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una guía de remisión para exportar.",
                type: "warning",
                confirmButtonColor: "#1a3bb3"
            });
            return;
        }

        // Confirmar acción
        swal({
            title: "Confirmar exportación",
            text: `¿Deseas exportar ${allSelectedIds.length} guias(s) seleccionada(s) a Excel?`,
            type: "info",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#1a3bb3"
        }, function(isConfirm) {
            if (!isConfirm) return;

            $('#btn-exportar-grm').prop('disabled', true);

            $.ajax({
                url: "{{ route('guias.manual.exportar') }}",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ guia_ids: allSelectedIds }),
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                xhrFields: { responseType: 'blob' },
                complete: () => $('#btn-exportar-filtrado').prop('disabled', false),
                success: function(blob) {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `Guías de Remisión_${new Date().toISOString().slice(0,10)}.xlsx`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                }
            });

        });
    });

   $(document).on('click', '#btn-descargar-grm', function(e) {
    e.preventDefault();

    var info = coti_table.page.info();
    var cantidadReal = masterChecked ? (info.recordsDisplay || 0) : allSelectedIds.length;

    if (cantidadReal === 0) {
        swal({
            title: "Sin selección",
            text: "Selecciona al menos una guía para descargar.",
            type: "warning",
            confirmButtonText: "Entendido",
            confirmButtonColor: "#1a3bb3"
        });
        return;
    }

    var mensaje = cantidadReal === 1
        ? "¿Deseas descargar la guía seleccionada en PDF?"
        : "¿Deseas descargar " + cantidadReal + " guías en un archivo ZIP?";

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
            var url = "{{ route('guia_remision_manual.download.multiple') }}";
            var params = new URLSearchParams();

            if (masterChecked) {
                params.set('select_all', 1);
                params.set('daterange', $('#data_range_filter').val());
                params.set('estado_s', $('#select_estado_sunat').val());
                params.set('value', $('#search_all_column').val());
            } else {
                allSelectedIds.forEach(function(id) {
                    params.append('guia_ids[]', id);
                });
            }

            window.location.href = url + '?' + params.toString();

            swal({
                title: "Procesando",
                text: cantidadReal === 1 ? "Generando PDF…" : "Generando ZIP…",
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
            text: "Por favor, selecciona al menos una guía de remisión manual para enviar por correo.",
            type: "warning",
            confirmButtonText: "Entendido",
            confirmButtonColor: "#1a3bb3"
        });
    }

    swal({
        title: "Enviar por Correo",
        text: `Ingresa el correo electrónico para enviar ${allSelectedIds.length} guía(s) de remisión:`,
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
        inputPlaceholder: "ejemplo@correo.com",
        confirmButtonColor: "#1a3bb3"
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
            text: `Procesando ${allSelectedIds.length} guía(s) de remisión. Por favor espera...`,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });

        // Enviar por AJAX
        $.ajax({
            url: '{{ route('envioCorreo.guia_remisionM.multiple') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: inputValue,
                guia_ids: allSelectedIds
            },
            success: function(response) {
                if (response.success) {
                    swal({
                        title: "¡Enviado!",
                        text: response.message || `Se han enviado ${allSelectedIds.length} guía(s) de remisión por correo`,
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
                    confirmButtonColor: "#1a3bb3"
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
            text: "Por favor, selecciona al menos una guía de remisión para enviar por WhatsApp.",
            type: "warning",
            confirmButtonText: "Entendido",
            confirmButtonColor: "#1a3bb3"
        });
    }

    swal({
        title: "Enviar por WhatsApp",
        text: `Ingresa el número de WhatsApp para enviar ${allSelectedIds.length} guía(s) de remisión(s):`,
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
        inputPlaceholder: "Ejemplo: 999999999",
        confirmButtonColor: "#1a3bb3"
    }, function(inputValue) {
        if (inputValue === false) return false;
        if (!inputValue) return swal.showInputError("Por favor ingresa un número de WhatsApp válido");
        if (!/^\d+$/.test(inputValue)) return swal.showInputError("Por favor ingresa solo números");

        swal.close();
        swal({
            title: "Procesando...",
            text: "Enviando notas de crédito por WhatsApp",
            type: "info",
            showConfirmButton: false,
            allowOutsideClick: false
        });

        const form = $('<form>', {
            action: '{{ route('envioWhatsapp.guiaRemisionM.multiple') }}',
            method: 'POST',
            target: '_blank',
            style: 'display:none;'
        });

        form.append($('<input>', {type: 'hidden', name: '_token', value: '{{ csrf_token() }}'}));
        form.append($('<input>', {type: 'hidden', name: 'numero', value: inputValue}));

        allSelectedIds.forEach(id => {
            form.append($('<input>', {type: 'hidden', name: 'guia_ids[]', value: id}));
        });

        $('body').append(form);
        form.submit();
        setTimeout(() => form.remove(), 1000);
        setTimeout(() => {
            swal({
                title: "¡Enviado!",
                text: `Se han enviado ${allSelectedIds.length} guía(s) de remisión(s) por WhatsApp`,
                type: "success",
                timer: 3000,
                showConfirmButton: true
            });
        }, 500);
    });
});
</script>
<!-- check -->
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
@endsection
