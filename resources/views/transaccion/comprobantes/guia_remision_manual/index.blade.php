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
                                                <th>Compartir</th>
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
@include('transaccion\comprobantes\_shared\js_shared')
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
                                <!-- Aqui ira lo del correo -->
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
     * ========================= */
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
    });

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
                    confirmButtonText: "Entendido"
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

        console.log('IDs seleccionados para exportar:', allSelectedIds);

        // Validar que hay boletas seleccionadas
        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una guía de remisión para exportar.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // Confirmar acción
        swal({
            title: "Confirmar exportación",
            text: `¿Deseas exportar ${allSelectedIds.length} guias(s) seleccionada(s) a Excel?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, exportar",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                // Construir URL con los IDs seleccionados
                var exportUrl = "{{ route('guias.manual.exportar') }}";
                var params = new URLSearchParams();

                // Agregar los IDs seleccionados como parámetro boleta_ids[]
                allSelectedIds.forEach(function(id) {
                    params.append('guia_ids[]', id);
                });

                console.log('URL de exportación:', exportUrl + '?' + params.toString());

                // Redirigir para exportar
                window.location.href = exportUrl + '?' + params.toString();

                // Mensaje de éxito
                swal({
                    title: "Procesando",
                    text: "Las guías se están exportando a Excel...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
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
            confirmButtonText: "Entendido"
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
        cancelButtonText: "Cancelar"
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

// Función para enviar guias por WhatsApp multiple
$('#btn-whatsapp-filtrado').on('click', function(e) {
    e.preventDefault();

    if (allSelectedIds.length === 0) {
        return swal({
            title: "Sin selección",
            text: "Por favor, selecciona al menos una guía de remisión para enviar por WhatsApp.",
            type: "warning",
            confirmButtonText: "Entendido"
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
        inputPlaceholder: "Ejemplo: 999999999"
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
