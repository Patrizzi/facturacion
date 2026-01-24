@extends('layout')

@section('title', 'Comprobantes | Factura')

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
                                        @if (auth()->user()->name == 'Administrador' && $almacen->count() != 1){{-- Condicional por tipo de user  --}}
                                            <span class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                                    <span style="margin-left:12px;"><b>Almacenes:</b></span>
                                                    @foreach ($almacen as $almacens)
                                                        <li>
                                                            <form action="{{ route('facturacion.create') }}"
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
                                            <form action="{{ route('facturacion.create') }}" enctype="multipart/form-data"
                                                method="post" class="tooltip-demo">
                                                @csrf
                                                <input type="text" value="{{ auth()->user()->almacen_id }}" hidden="hidden"
                                                    name="almacen">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <div class="btn-group">
                                             <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-download"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button type="button" id="btn-imprimir" class="dropdown-item">
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
                            </div>
                            <div class="tab-content" style="margin-top: -1px">
                                <!-- Factura-->
                                <div role="tabpanel" id="tab-3" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row" style="row-gap: 5px;">
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
                                        <table class="table table-striped table-bordered dataTables-example-factura" style="min-width: 982px">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>N°</th>
                                                    <th>RUC-/DNI</th>
                                                    <th>Cliente</th>
                                                    <th>Emisión</th>
                                                    <th>Forma</th>
                                                    <th>Importe T.</th>
                                                    <th>Ver</th>
                                                    <th style="width: 0.5vmax !important">Acciones</th>
                                                    <th>Compartir</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="8"></th>
                                                    <th class="total-columna">Total: 0</th>
                                                    <th colspan="2" class="total-total">Total G: 0</th>
                                                </tr>
                                                {{-- <tr>
                                                    <th colspan="9"></th>
                                                    <th colspan="2" class="total-total">Total G: 0</th>
                                                </tr> --}}
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

    @include('transaccion.comprobantes._shared.js_shared')

    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-3-tab').addClass('active');
            var $bottom = $('.tabs-scroll-bottom');
            var $nav = $bottom.find('.nav-custom');
            var $tab = $nav.find('li').eq(2);

            if ($tab.length) {
                var target = $tab[0].offsetLeft - ($bottom.innerWidth() / 2) + ($tab.outerWidth(true) / 2);

                $bottom.animate({ scrollLeft: target }, 600);
            }
        });

        //  {{-- SCRIPTS PARA DATATABLE --}}

        var coti_table = $('.dataTables-example-factura').DataTable({
            "pageLength": 15,
            "serverSide": true,
            "ajax": {
                url: "{{ route('comprobantes.factura_registers') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#data_range_filter').val();
                    d.estado_s = $('#select_estado_sunat').val();
                    d.value = $('#search_all_column').val();
                },
                dataSrc: function(json) {
                    var total_columna = json.total_columna;
                    var total_table = json.total_table;

                    $('.dataTables-example-factura tfoot th.total-columna').html('Total: ' + total_columna);
                    $('.dataTables-example-factura tfoot th.total-total').html('Total  G.: ' + total_table);

                    return json.data;
                }
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" name="select_row" value="' + full[2] +
                            '" class="i-checks-factura">';
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
                        var url = '{{ route('facturacion.show', ':id') }}';
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
                },
                {
                    'targets': [10], // Columna de Compartir (Boton de correo sin funcionamiento por ahora)
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        const facturaId = full[0];
                        const codigoFactura = full[2];
                        const celularCliente = full[12] || '';
                        const emailCliente = full[13] || '';

                        return `
                            <div style="display: inline-block; white-space: nowrap;">
                                <!-- Aqui ira lo del correo -->
                                <!-- Contenedor WhatsApp -->
                                <div class="wsp-container" data-id="${facturaId}"
                                    style="display: inline-block; position: relative; vertical-align: top;">
                                    <a class="btn btn-success" style="background: green; border-color: green; cursor: pointer;">
                                        <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                    </a>
                                    <div class="wsp-form" data-id="${facturaId}"
                                        style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                        overflow: hidden; transition: height .4s; background: white;
                                        box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                        z-index: 9999; white-space: nowrap;">
                                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" target="_blank" style="padding: 10px;">
                                            @csrf
                                            <input type="tel" name="numero" placeholder="999999999" value="${celularCliente}"
                                                style="width: 130px; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                            <input type="text" name="mensaje" hidden />
                                            <input type="hidden" name="url" value="{{ route('pdf_fac', '') }}/${facturaId}?archivo=" />
                                            <input type="hidden" name="name_sin_cambio" value="Factura_${codigoFactura}" />
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
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('.i-checks-factura').iCheck({
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

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset(path: 'js/icheck.min.js') }}"></script>
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
                url: "{{ route('comprobantes.factura_registers') }}",
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
                    $('.i-checks-factura').iCheck('check');
                    isUpdatingCheckboxes = false;
                });
            } else {
                masterChecked = false;
                allSelectedIds = [];
                console.log('Master checkbox desmarcado manualmente - allSelectedIds limpio');

                isUpdatingCheckboxes = true;
                $('.i-checks-factura').iCheck('uncheck');
                isUpdatingCheckboxes = false;
            }
        });

        // Controlar checkboxes individuales
        $(document).on('ifChecked ifUnchecked', '.i-checks-factura', function(event) {
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
            $('.i-checks-factura').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Usar setTimeout para asegurar que iCheck esté completamente inicializado
            setTimeout(function() {
                isUpdatingCheckboxes = true;

                // Procesar cada checkbox en la página actual
                $('.i-checks-factura').each(function() {
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

        // ============ AQUI IRA LO DEL CORREO ============

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

        // Función para imprimir facturas seleccionadas
        $('#btn-imprimir').on('click', function(e) {
            e.preventDefault();

            console.log('IDs seleccionados para imprimir:', allSelectedIds);

            // Validar que hay facturas seleccionadas
            if (allSelectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una factura para imprimir.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            // Confirmar acción
            swal({
                title: "Confirmar impresión",
                text: `¿Deseas imprimir ${allSelectedIds.length} factura(s) seleccionada(s)?`,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, imprimir",
                cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (isConfirm) {
                    // Construir URL con parámetros GET
                    var url = '{{ route("factura.print.multiple") }}';
                    var params = new URLSearchParams();

                    allSelectedIds.forEach(function(id) {
                        params.append('factura_ids[]', id);
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
                        text: "Las facturas se están imprimiendo...",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Manejar click del botón de exportar
        $('#btn-exportar-filtrado').on('click', function(e) {
            e.preventDefault();

            console.log('IDs seleccionados para exportar:', allSelectedIds);

            // Validar que hay boletas seleccionadas
            if (allSelectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una factura para exportar.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            // Confirmar acción
            swal({
                title: "Confirmar exportación",
                text: `¿Deseas exportar ${allSelectedIds.length} factura(s) seleccionada(s) a Excel?`,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, exportar",
                cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (isConfirm) {
                    // Construir URL con los IDs seleccionados
                    var exportUrl = "{{ route('facturas.exportar') }}";
                    var params = new URLSearchParams();

                    // Agregar los IDs seleccionados como parámetro boleta_ids[]
                    allSelectedIds.forEach(function(id) {
                        params.append('factura_ids[]', id);
                    });

                    console.log('URL de exportación:', exportUrl + '?' + params.toString());

                    // Redirigir para exportar
                    window.location.href = exportUrl + '?' + params.toString();

                    // Mensaje de éxito
                    swal({
                        title: "Procesando",
                        text: "Las facturas se están exportando a Excel...",
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
            $('.i-checks-factura').iCheck('uncheck');
            isUpdatingCheckboxes = false;
            console.log('Todas las selecciones limpiadas');
        };

        window.getSelectedIds = function() {
            console.log('IDs actualmente seleccionados:', allSelectedIds);
            return allSelectedIds;
        };
    // Función para descargar facturas seleccionadas en PDF/ZIP
    $('#btn-descargar-filtrado').on('click', function(e) {
        e.preventDefault();

        console.log('IDs seleccionados para descargar:', allSelectedIds);

        // Validar que hay facturas seleccionadas
        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una factura para descargar.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // Mensaje personalizado según cantidad
        var mensaje = allSelectedIds.length === 1
            ? "¿Deseas descargar la factura seleccionada en PDF?"
            : `¿Deseas descargar ${allSelectedIds.length} facturas en un archivo ZIP?`;

        // Confirmar acción
        swal({
            title: "Confirmar descarga",
            text: mensaje,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, descargar",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                // Construir URL con parámetros
                var url = '{{ route("facturas.download.multiple") }}';
                var params = new URLSearchParams();

                allSelectedIds.forEach(function(id) {
                    params.append('factura_ids[]', id);
                });

                var fullUrl = url + '?' + params.toString();
                console.log('URL de descarga:', fullUrl);

                // Usar fetch para descargar sin redirigir
                fetch(fullUrl, { method: 'GET' })
                    .then(response => {
                        if (!response.ok) {
                            // Si hay error, mostrar mensaje sin redirigir
                            return response.text().then(text => {
                                // Intentar parsear como JSON si es posible
                                try {
                                    const data = JSON.parse(text);
                                    throw new Error(data.error || 'Error desconocido');
                                } catch {
                                    // Si no es JSON, mostrar el texto como error
                                    throw new Error('Error del servidor: ' + text.substring(0, 100));
                                }
                            });
                        }
                        // Si es exitosa, convertir a blob y descargar
                        return response.blob();
                    })
                    .then(blob => {
                        if (blob) {
                            // Crear enlace temporal para descargar el blob
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.style.display = 'none';
                            a.href = url;
                            a.download = allSelectedIds.length === 1
                                ? 'Factura.pdf'
                                : 'Facturas_' + new Date().toISOString().slice(0, 19).replace(/:/g, '-') + '.zip';
                            document.body.appendChild(a);
                            a.click();
                            window.URL.revokeObjectURL(url);
                            document.body.removeChild(a);
                        }
                    })
                    .catch(error => {
                        console.error('Error en descarga:', error);
                        // Mostrar error en la misma vista
                        swal({
                            title: "Error",
                            text: "Error al descargar: " + error.message,
                            type: "error",
                            confirmButtonText: "Entendido"
                        });
                    });
                    }
                });
            });

            // Función para enviar facturas por WhatsApp multiple
            $('#btn-whatsapp-filtrado').on('click', function(e) {
                e.preventDefault();

                if (allSelectedIds.length === 0) {
                    return swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una factura para enviar por WhatsApp.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    });
                }

                swal({
                    title: "Enviar por WhatsApp",
                    text: `Ingresa el número de WhatsApp para enviar ${allSelectedIds.length} factura(s):`,
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
                        text: "Enviando facturas por WhatsApp",
                        type: "info",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    const form = $('<form>', {
                        action: '{{ route('envioWhatsapp.factura.multiple') }}',
                        method: 'POST',
                        target: '_blank',
                        style: 'display:none;'
                    });

                    form.append($('<input>', {type: 'hidden', name: '_token', value: '{{ csrf_token() }}'}));
                    form.append($('<input>', {type: 'hidden', name: 'numero', value: inputValue}));

                    allSelectedIds.forEach(id => {
                        form.append($('<input>', {type: 'hidden', name: 'factura_ids[]', value: id}));
                    });

                    $('body').append(form);
                    form.submit();
                    setTimeout(() => form.remove(), 1000);
                    setTimeout(() => {
                        swal({
                            title: "¡Enviado!",
                            text: `Se han enviado ${allSelectedIds.length} factura(s) por WhatsApp`,
                            type: "success",
                            timer: 3000,
                            showConfirmButton: true
                        });
                    }, 500);
                });
            });
        });
    </script>
@endsection
