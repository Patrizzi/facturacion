@extends('layout')

@section('title', 'Ventas | Cotización')

@section('content')
    <style>
        /* Ajustes para el popover de la nota informativa */
        .popover {
            max-width: 400px; /* Permitir que sea más ancho si hay mucho texto */
        }
        .popover-body {
            font-weight: normal !important; /* Quitar negrilla */
            white-space: pre-wrap; /* Respetar saltos de línea y no desbordar */
            word-wrap: break-word; /* Romper palabras largas si es necesario */
            color: #333;
        }
    </style>
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
                            @include('transaccion.venta._shared.statistics')
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
                                <ul class="nav nav-tabs" role="tablist"
                                    style="align-items: center;border-bottom: 0px !important;">
                                    @include('transaccion.venta._shared.tabs')
                                    {{-- Almacen --}}
                                    <ul class="ml-auto d-flex"
                                        style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                        {{-- ALMACEN --}}
                                        @if (auth()->user()->name == 'Administrador')
                                            {{-- Condicional por tipo de user --}}
                                            <span class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                                    <span style="margin-left:12px;"><b>Almacenes:</b></span>
                                                    @foreach ($almacen as $almacens)
                                                        <li>
                                                            <form action="{{ route('cotizacion.create_factura') }}"
                                                                enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                <input type="text" value="{{ $almacens->id }}" hidden="hidden"
                                                                    name="almacen">
                                                                <button class="btn btn-w-m btn-link"
                                                                    type="submit">{{ $almacens->nombre }}</button>
                                                            </form>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </span>
                                        @else
                                            <form action="{{ route('cotizacion.create_factura') }}"
                                                enctype="multipart/form-data" method="post" class="tooltip-demo">
                                                @csrf
                                                <input type="text" value="{{ auth()->user()->almacen_id }}" hidden="hidden"
                                                    name="almacen">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="#" id="btn-duplicar-cotizacion" class="btn btn-primary"
                                            title="Duplicar cotizaciones">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-download"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button type="button" id="btn-imprimir" class="dropdown-item">
                                                    <i class="fa fa-print"></i> Imprimir
                                                </button>
                                                <button type="button" id="btn_export_cotizaciones" class="dropdown-item">
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
                                <!-- COTIZACION-->
                                <div role="tabpanel" id="tab-1" class="tab-pane active show"
                                    style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
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
                                    <br>{{-- Tabla de --}}
                                    <div class="scrooll-table-responsive">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-cotizacion"
                                            style="min-width: 982px">
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



    <!-- Estilos personalizados para iconos -->
    <style>
        /* botón sin fondo ni borde para que solo el icono sea visible */
        .info-icon {
            background-color: transparent;
            border: none;
            padding: 0;
            transition: none;
            color: inherit;
            /* hereda color del contexto (texto cercano) */
        }

        /* transiciones aplicadas al svg interior */
        .info-icon svg {
            transition: fill 0.3s, transform 0.2s;
            fill: currentColor;
            /* mismo color que el texto */
        }

        /* hover: cambia el tono (azul oscuro) y aumenta un poco */
        .info-icon:hover svg {
            color: #0056b3;
            /* tono diferente para indicar hover */
            transform: scale(1.1);
        }

        /* eliminar outline/box-shadow al enfocar el botón */
        .info-icon:focus {
            outline: none;
            box-shadow: none;
        }

        /* Estilos personalizados para el Popover */
        .popover-header {
            background-color: #2641f8; /* Azul solicitado */
            color: white;
            font-weight: normal !important;
        }

        .popover-body {
            background-color: white; /* Blanco solicitado */
            color: black;
            font-weight: normal !important;
        }
    </style>

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
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        //Cerrar el popover al hacer click fuera
        $('body').on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popovers
                //the 'has' for icons within a button that triggers a popover
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });

        $(document).ready(function () {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-1-tab').addClass('active');
        });
        var coti_table = $('.dataTables-example-cotizacion').DataTable({
            "lengthChange": false,
            "responsive": true,
            "searching": false,
            "pageLength": 15,
            "serverSide": true,
            "ajax": {
                url: "{{ route('ventas.cotizacion_registers') }}",
                method: "get",
                data: function (d) {
                    // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                    d.daterange = $('#data_range_filter')
                        .val(); // Supongamos que tienes un campo input con rango de fechas
                    d.tipo_coti = $('#select_tipo_coti')
                        .val(); // Supongamos que tienes un select para el tipo de cotización
                    d.value = $('#search_all_column').val();
                },
                dataSrc: function (json) {
                    // Suponiendo que el valor adicional viene con el nombre 'total'
                    var total_columna = json.total_columna;
                    var total_table = json.total_table;

                    // Actualiza el pie de la tabla (tfoot) con el valor que viene del servidor
                    $('.dataTables-example-cotizacion tfoot th.total-columna').html('Total: ' + total_columna);
                    $('.dataTables-example-cotizacion tfoot th.total-total').html('Total  G.: ' + total_table);

                    // Retorna los datos de la tabla para que Datatables los procese
                    return json.data;
                }
            },
            "columnDefs": [{
                'width': '1vmax',
                'targets': [0], // Aplica a la primera columna (index 0)
                'orderable': false, // Deshabilitar ordenación en esta columna
                'render': function (data, type, full, meta) {
                    // Renderizar el checkbox en la primera columna
                    return '<input type="checkbox" name="select_row" value="' + full[0] +
                        '">';
                }
            },
            {
                'targets': [1],
                'orderable': false
            },
            {
                'targets': [2],
                'orderable': false,
                'render': function (data, type, full, meta) {
                    const cotizacionId = full[0];
                    const codigoCotizacion = full[2];
                    const notaInformativa = full[12];

                    let tieneNota = notaInformativa !== null && notaInformativa !== '';
                    let contenidoBoton = '';

                    if(tieneNota){
                        let escapedNota = notaInformativa.replace(/'/g, '&#39;').replace(/"/g, '&quot;');
                        let jsEscapedNota = notaInformativa.replace(/'/g, "\\'").replace(/"/g, '&quot;').replace(/\n/g, '\\n');

                        contenidoBoton = `
                            <button type="button" class="btn btn-sm info-icon"
                                    data-trigger="hover"
                                    data-placement="top"
                                    data-toggle="popover"
                                    title="Nota Informativa"
                                    data-content="${escapedNota}"
                                    onclick="gestionarNota(${cotizacionId}, '${jsEscapedNota}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-square-fill" viewBox="0 0 16 16">
                                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm8.93 4.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                </svg>
                            </button>
                        `;
                    } else {
                        contenidoBoton = `
                            <button type="button" class="btn btn-sm info-icon text-muted"
                                    title="Añadir Nota"
                                    onclick="gestionarNota(${cotizacionId}, '')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-dotted" viewBox="0 0 16 16">
                                    <path d="M2.5 0c-.166 0-.33.016-.487.048l.194.98A1.51 1.51 0 0 1 2.5 1h.458V0zm2.292 0h-.917v1h.917zm1.833 0h-.917v1h.917zm1.833 0h-.916v1h.916zm1.834 0h-.917v1h.917zm1.833 0h-.917v1h.917zM13.5 0h-.458v1h.458c.1 0 .199.01.293.029l.194-.981A2.51 2.51 0 0 0 13.5 0m2.079 1.11a2.5 2.5 0 0 0-.69-.689l-.556.831c.164.11.305.251.415.415l.83-.556zM1 2.292V3.21h-1v-.917h1zm14 0v.917h1v-.917zM1 4.125v.917h-1v-.917h1zm14 0v.917h1v-.917zM1 5.958v.917h-1v-.917zm14 0v.917h1v-.917zM1 7.792v.916h-1v-.916zm14 0v.916h1v-.916zM1 9.625v.917h-1v-.917zm14 0v.917h1v-.917zM1 11.458v.917h-1v-.917zm14 0v.917h1v-.917zM1 13.292v.917h-1v-.917zm14 0v.917h1v-.917zM1.531 15.348a2.5 2.5 0 0 0 .69.689l.556-.831a1.5 1.5 0 0 1-.415-.415l-.83.556zM2.5 16h.458v-1h-.458a1.5 1.5 0 0 1-.293-.029l-.194.981c.157.032.321.048.487.048m2.292 0h.917v-1h-.917zm1.833 0h.917v-1h-.917zm1.833 0h.916v-1h-.916zm1.834 0h.917v-1h-.917zm1.833 0h.917v-1h-.917zM13.5 16c.166 0 .33-.016.487-.048l-.194-.98A1.51 1.51 0 0 1 13.5 15h-.458v1zM8 4.5a.5.5 0 0 1 .5.5v2.5H11a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V8.5H5a.5.5 0 0 1 0-1h2.5V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </button>
                        `;
                    }

                    return `
                        <div class="d-flex align-items-center">
                            <span class="mr-2 text-secondary-emphasis">
                                ${codigoCotizacion}
                            </span>
                            ${contenidoBoton}
                        </div>
                    `;
                }
            },
            {
                'targets': [3],
                'orderable': false
            },
            {
                'width': '30%',
                'targets': [4],
                'orderable': false
            },
            {
                'targets': [5],
                'orderable': false
            },
            {
                'targets': [6],
                'orderable': false
            },
            {
                'targets': [7],
                'orderable': false
            },
            {
                'targets': [8], // Configuración para otra columna (como la de acciones)
                'orderable': false,
                'render': function (data, type, full, meta) {
                    // Generar la URL de forma dinámica usando la función route con un placeholder
                    var url = '{{ route('cotizacion.show', ':id') }}';
                    url = url.replace(':id', full[
                        0]); // Reemplazar el placeholder con el valor dinámico

                    var iconoRenovacion = '';
                    if (full[13] == 1) {
                        iconoRenovacion = `<button type="button" class="btn" style="background-color:#1ab394; border-color:#1ab394; color:white;" data-toggle="tooltip" data-placement="bottom" data-original-title="Renovación activa">
                            <i class="fa fa-refresh"></i>
                        </button>`;
                    } else if (full[13] == 2) {
                        iconoRenovacion = `<button type="button" class="btn" style="background-color:#f8ac59; border-color:#f8ac59; color:white;" data-toggle="tooltip" data-placement="bottom" data-original-title="Próxima a vencer">
                            <i class="fa fa-refresh"></i>
                        </button>`;
                    } else if (full[13] == 3) {
                        iconoRenovacion = `<button type="button" class="btn" style="background-color:#1c84c6; border-color:#1c84c6; color:white;" data-toggle="tooltip" data-placement="bottom" data-original-title="Renovada">
                            <i class="fa fa-refresh"></i>
                        </button>`;
                    } else if (full[13] == 4) {
                        iconoRenovacion = `<button type="button" class="btn" style="background-color:#ed5565; border-color:#ed5565; color:white;" data-toggle="tooltip" data-placement="bottom" data-original-title="Renovación vencida"><i class="fa fa-refresh"></i></button>`;
                    }

                    if (full[9] == '0') {
                        return `
                        <div class="tooltip-demo">
                            <a href="${url}">
                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ver">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </a>
                            <button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Procesado">
                                <i class="fa fa-clock-o"></i>
                            </button>
                            ${iconoRenovacion}
                        </div>`;
                    } else {
                        return `
                        <div class="tooltip-demo">
                            <a href="${url}">
                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ver">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </a>
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Sin Procesar">
                                <i class="fa fa-check-circle"></i>
                            </button>
                            ${iconoRenovacion}
                        </div>`;
                    }
                }
            },
            {
                'targets': [9], // Columna de Compartir
                'orderable': false,
                'render': function (data, type, full, meta) {
                    const cotizacionId = full[0];
                    const codigoCotizacion = full[2];
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
                        <div class="wsp-container" data-id="${cotizacionId}"
                            style="display: inline-block; position: relative; vertical-align: top;">
                            <a class="btn btn-success" style="background: green; border-color: green; cursor: pointer;">
                                <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                            </a>
                            <div class="wsp-form" data-id="${cotizacionId}"
                                style="position: absolute; top: 100%; right: 0; margin-top: 5px; height: 0px;
                                overflow: hidden; transition: height .4s; background: white;
                                box-shadow: 0px 0px 5px rgba(0,0,0,0.3); border-radius: 4px;
                                z-index: 9999; white-space: nowrap;">
                                <form action="{{ route('agregado.whatsapp_send') }}" method="post" target="_blank" style="padding: 10px;">
                                    @csrf
                                    <input type="tel" name="numero" placeholder="999999999" value="${celularCliente}"
                                        style="width: 130px; padding: 5px; border: 1px solid #ccc; border-radius: 3px;" required />
                                    <input type="text" name="mensaje" hidden />
                                    <input type="hidden" name="url" value="{{ route('pdf_cotizacion', '') }}/${cotizacionId}?archivo=" />
                                    <input type="hidden" name="name_sin_cambio" value="Cotización_${codigoCotizacion}" />
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
        $(`#filter_buttons`).on('click', function () {
            mostrarToast = true;
            coti_table.ajax.reload();
        });
        coti_table.on('xhr.dt', function (e, settings, json, xhr) {
            if (mostrarToast) {
                toastr.success(" ",
                    'Se han aplicado los filtros correctamente', {
                    timeOut: 3000
                });
                mostrarToast = false; // reseteo el flag
            }
        });
        $('#revert_select').on('click', function () {
            $('input[name="daterange"]').val("{{ date('01/m/Y') }} - {{ date('t/m/Y') }}").trigger('change');
            mostrarToast = true;
            coti_table.ajax.reload();
        });
    </script>
    <script>
        $(document).ready(function () {
            // Variables globales
            var allSelectedIds = [];
            var masterChecked = false;
            var isUpdatingCheckboxes = false;

            // Inicializar iCheck
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            function hasAnySelection() {
                return Array.isArray(allSelectedIds) && allSelectedIds.length > 0;
            }

            function closeWhatsappPanels() {
                $('.wsp-form').removeClass('wsp-fixed').css('height', '0px');
            }

            function closeEmailPanels() {
                $('.email-form').removeClass('email-fixed').css('height', '0px');
            }

            // Función para obtener TODOS los IDs mediante AJAX
            function getAllIds(callback) {
                $.ajax({
                    url: "{{ route('ventas.cotizacion_registers') }}",
                    method: "GET",
                    data: {
                        daterange: $('#data_range_filter').val(),
                        tipo_coti: $('#select_tipo_coti').val(),
                        value: $('#search_all_column').val(),
                        length: -1,
                        start: 0,
                        get_all_ids: true
                    },
                    success: function (response) {
                        var ids = [];
                        if (response.data && response.data.length > 0) {
                            response.data.forEach(function (row) {
                                if (row[0]) {
                                    ids.push(row[0].toString());
                                }
                            });
                        }
                        callback(ids);
                    },
                    error: function (xhr, status, error) {
                        callback([]);
                    }
                });
            }

            function updateMasterCheckbox() {
                if (isUpdatingCheckboxes) return;

                getAllIds(function (allIds) {
                    var allSelected = allIds.length > 0 && allIds.every(function (id) {
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

            // Checkbox del header
            $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function (event) {
                if (isUpdatingCheckboxes) return;

                closeWhatsappPanels();
                closeEmailPanels();

                if (event.type === 'ifChecked') {
                    masterChecked = true;
                    getAllIds(function (ids) {
                        allSelectedIds = [...ids];
                        isUpdatingCheckboxes = true;
                        $('.dataTables-example-cotizacion tbody input[type="checkbox"]').iCheck('check');
                        isUpdatingCheckboxes = false;
                    });
                } else {
                    masterChecked = false;
                    allSelectedIds = [];
                    isUpdatingCheckboxes = true;
                    $('.dataTables-example-cotizacion tbody input[type="checkbox"]').iCheck('uncheck');
                    isUpdatingCheckboxes = false;
                }
            });

            // Checkboxes individuales
            $(document).on('ifChecked ifUnchecked', '.dataTables-example-cotizacion tbody input[type="checkbox"]', function (event) {
                if (isUpdatingCheckboxes) return;

                closeWhatsappPanels();
                closeEmailPanels();

                var checkboxValue = $(this).val();

                if (event.type === 'ifChecked') {
                    if (!allSelectedIds.includes(checkboxValue)) {
                        allSelectedIds.push(checkboxValue);
                    }
                } else {
                    allSelectedIds = allSelectedIds.filter(function (selectedId) {
                        return selectedId !== checkboxValue;
                    });

                    if (masterChecked) {
                        masterChecked = false;
                        isUpdatingCheckboxes = true;
                        $('thead input[type="checkbox"]').iCheck('uncheck');
                        isUpdatingCheckboxes = false;
                    }
                }

                setTimeout(updateMasterCheckbox, 50);
            });

            // Detectar cuando se cambia de tab
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var activeTab = $(e.target).attr('href');
                $(activeTab).find('.i-checks').iCheck('update');
            });

            // Cuando se redibuje la tabla
            coti_table.on('draw', function () {
                $('[data-toggle="popover"]').popover();
                closeWhatsappPanels();
                closeEmailPanels();
                $('.dataTables-example-cotizacion tbody input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

                setTimeout(function () {
                    isUpdatingCheckboxes = true;

                    $('.dataTables-example-cotizacion tbody input[type="checkbox"]').each(function () {
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

            // ============CORREO ============
            // Fijar cuando se hace clic en el botón de correo
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

            // Fijar también cuando se hace clic en el formulario o inputs
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

            $(document).on('click', '.btn-agregar-email', function () {
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

            $(document).on('click', '.btn-eliminar-email', function () {
                const form = $(this).closest('.email-form');
                $(this).closest('div').remove();
                form.css('height', (form.find('form').outerHeight() + 20) + 'px');
            });

            // ============ ENVÍO DE CORREO AJAX ============
            $(document).on('submit', '.form-enviar-email', function (e) {
                e.preventDefault();

                const form = $(this);
                const cotizacionId = form.data('cotizacion-id');
                const button = form.find('button[type="submit"]');
                const originalHtml = button.html();
                const emailFormContainer = $(`.email-form[data-id="${cotizacionId}"]`);

                // Validar que haya al menos un email
                const emails = form.find('input[type="email"]').map(function () {
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
                    url: "{{ route('cotizacion.enviar-correo-directo', '') }}/" + cotizacionId,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
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
                    error: function (xhr) {
                        // Limpiar todos los toasts
                        toastr.clear();

                        let errorMsg = 'Error al enviar el correo';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        toastr.error(errorMsg, 'Error');
                    },
                    complete: function () {
                        // Rehabilitar botón
                        button.prop('disabled', false).html(originalHtml);
                    }
                });
            });

            // Cerrar al hacer clic fuera
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.email-container, .email-form').length) {
                    $('.email-form').removeClass('email-fixed').css('height', '0px');
                }
            });

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

            // Fijar también cuando se hace clic en el input o en cualquier parte del formulario
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

            // BOTÓN DUPLICAR - SOLO UNA COTIZACIÓN
            $('#btn-duplicar-cotizacion').on('click', function (e) {
                e.preventDefault();

                // console.log('IDs seleccionados:', allSelectedIds);

                if (allSelectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona UNA cotización para duplicar.",
                        type: "warning",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#1a3bb3"
                    });
                    return;
                }

                if (allSelectedIds.length > 1) {
                    swal({
                        title: "Solo una cotización",
                        text: "Solo puedes duplicar UNA cotización a la vez. Por favor, selecciona solo una.",
                        type: "warning",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#1a3bb3"
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
                    confirmButtonColor: "#1a3bb3",
                    cancelButtonText: "Cancelar"
                }, function (isConfirm) {
                    if (isConfirm) {
                        var form = $('<form>', {
                            'method': 'POST',
                            'action': '{{ route("cotizacion.create_factura") }}'
                        });

                        form.append($('<input>', {
                            'type': 'hidden',
                            'name': '_token',
                            'value': '{{ csrf_token() }}'
                        }));

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

            // Imprimir cotizaciones
            $('#btn-imprimir').on('click', function (e) {
                e.preventDefault();

                if (allSelectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una cotización para imprimir.",
                        type: "warning",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#1a3bb3"
                    });
                    return;
                }

                swal({
                    title: "Confirmar impresión",
                    text: `¿Deseas imprimir ${allSelectedIds.length} cotización(es) seleccionada(s)?`,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Sí, imprimir",
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#1a3bb3"
                }, function (isConfirm) {
                    if (isConfirm) {
                        var url = '{{ route("cotizacion.print.multiple") }}';
                        var params = new URLSearchParams();

                        allSelectedIds.forEach(function (id) {
                            params.append('cotizacion_ids[]', id);
                        });

                        var printWindow = window.open(url + '?' + params.toString(), '_blank');

                        if (printWindow) {
                            printWindow.focus();
                        } else {
                            alert('Por favor, permite ventanas emergentes para imprimir');
                        }

                        swal({
                            title: "Procesando",
                            text: "Las cotizaciones se están imprimiendo...",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Manejar click del botón de exportar
            $('#btn_export_cotizaciones').on('click', function (e) {
                e.preventDefault();

                // Validar que hay boletas seleccionadas
                if (allSelectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una cotización para exportar.",
                        type: "warning",
                        confirmButtonColor: "#1a3bb3"
                    });
                    return;
                }

                // Confirmar acción
                swal({
                    title: "Confirmar exportación",
                    text: `¿Deseas exportar ${allSelectedIds.length} cotizacion(es) seleccionada(s) a Excel?`,
                    type: "info",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#1a3bb3"
                }, function (isConfirm) {
                    if (!isConfirm) return;

                    $('#btn_export_cotizaciones').prop('disabled', true);

                    $.ajax({
                        url: "{{ route('exportarCotizacion') }}",
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({ cotizacion_ids: allSelectedIds }),
                        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                        xhrFields: { responseType: 'blob' },
                        complete: () => $('#btn_export_cotizaciones').prop('disabled', false),
                        success: function (blob) {
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = `Cotizaciones_${new Date().toISOString().slice(0, 10)}.xlsx`;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        }
                    });
                });
            });

            // Función para descargar boletas seleccionadas en PDF/ZIP
            $('#btn-descargar-filtrado').on('click', function (e) {
                e.preventDefault();

                console.log('IDs seleccionados para descargar:', allSelectedIds);

                // Validar que hay boletas seleccionadas
                if (allSelectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una cotizacion para descargar.",
                        type: "warning",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#1a3bb3"
                    });
                    return;
                }

                // Mensaje personalizado según cantidad
                var mensaje = allSelectedIds.length === 1
                    ? "¿Deseas descargar la cotizacion seleccionada en PDF?"
                    : `¿Deseas descargar ${allSelectedIds.length} cotizaciones en un archivo ZIP?`;

                // Confirmar acción
                swal({
                    title: "Confirmar descarga",
                    text: mensaje,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Sí, descargar",
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#1a3bb3"
                }, function (isConfirm) {
                    if (isConfirm) {
                        // Construir URL con parámetros
                        var url = '{{ route("cotizacion.download.multiple") }}';
                        var params = new URLSearchParams();

                        allSelectedIds.forEach(function (id) {
                            params.append('cotizacion_ids[]', id);
                        });

                        console.log('URL de descarga:', url + '?' + params.toString());

                        // Redirigir para descargar
                        window.location.href = url + '?' + params.toString();

                        // Mensaje de éxito
                        swal({
                            title: "Procesando",
                            text: allSelectedIds.length === 1
                                ? "La cotizacion se está descargando..."
                                : "Las cotizaciones se están comprimiendo y descargando...",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

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
                        url: '{{ route('envioCorreo.cotizacion.multiple') }}',
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

            // Función para enviar guias por WhatsApp multiple
            $('#btn-whatsapp-filtrado').on('click', function (e) {
                e.preventDefault();

                if (allSelectedIds.length === 0) {
                    return swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una cotización para enviar por WhatsApp.",
                        type: "warning",
                        confirmButtonText: "Entendido",
                        confirmButtonColor: "#1a3bb3"
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
                    confirmButtonColor: "#1a3bb3"
                }, function (inputValue) {
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
                        action: '{{ route('envioWhatsapp.cotizacion.multiple') }}',
                        method: 'POST',
                        target: '_blank',
                        style: 'display:none;'
                    });

                    form.append($('<input>', { type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }));
                    form.append($('<input>', { type: 'hidden', name: 'numero', value: inputValue }));

                    allSelectedIds.forEach(id => {
                        form.append($('<input>', { type: 'hidden', name: 'cotizacion_ids[]', value: id }));
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

            // Funciones helper
            window.clearAllSelections = function () {
                allSelectedIds = [];
                masterChecked = false;
                isUpdatingCheckboxes = true;
                $('thead input[type="checkbox"]').iCheck('uncheck');
                $('.dataTables-example-cotizacion tbody input[type="checkbox"]').iCheck('uncheck');
                isUpdatingCheckboxes = false;
            };

            window.getSelectedIds = function () {
                console.log('IDs actualmente seleccionados:', allSelectedIds);
                return allSelectedIds;
            };
        });

        // Función para gestionar nota usando un Modal Bootstrap estilizado e Inspinia-like
        function gestionarNota(id, notaActual) {
            // Cerrar popovers primero para que no estorben
            $('[data-toggle="popover"]').popover('hide');

            // Eliminar modal anterior si existe en el DOM
            $('#modalGestionarNota').remove();

            let title = notaActual ? 'Editar Nota Informativa' : 'Agregar Nota Informativa';
            let deleteBtn = notaActual ? `<button type="button" class="btn btn-danger" style="border-radius: 4px;" onclick="confirmarEliminarNota(${id})"><i class="fa fa-trash"></i> Eliminar</button>` : '';
            let saveBtnText = notaActual ? 'Actualizar' : 'Guardar';
            let iconHeader = notaActual ? 'fa-pencil-square-o' : 'fa-plus-circle';

            let modalHTML = `
            <div class="modal fade" id="modalGestionarNota" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content border-0 shadow" style="border-radius: 6px; overflow: hidden;">
                        <div class="modal-header d-flex justify-content-between align-items-center" style="background-color: #1a3bb3; color: white; border-bottom: none; padding: 15px 20px;">
                            <h5 class="modal-title" style="margin: 0; font-weight: 500; font-size: 16px;"><i class="fa ${iconHeader} mr-2"></i>${title}</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.8; padding: 10px; margin: -10px -10px -10px auto; outline: none; text-shadow: none;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body bg-light" style="padding: 20px;">
                            <label class="font-weight-bold text-muted mb-2">Contenido de la nota:</label>
                            <textarea id="input-modal-nota" class="form-control" rows="4" placeholder="Escriba aquí..." style="border-radius: 4px; resize: none;"></textarea>
                        </div>
                        <div class="modal-footer bg-white d-flex justify-content-between align-items-center" style="border-top: 1px solid #e7eaec; padding: 12px 20px;">
                            <div>
                                ${deleteBtn}
                            </div>
                            <div>
                                <button type="button" class="btn btn-white" data-dismiss="modal" style="border-radius: 4px; margin-right: 5px;">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="guardarDesdeModal(${id})" style="background-color: #1a3bb3; border-color: #1a3bb3; border-radius: 4px;">${saveBtnText}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

            $('body').append(modalHTML);
            $('#input-modal-nota').val(notaActual);

            // Enfocar automáticamente el textarea cuando el modal se abre
            $('#modalGestionarNota').on('shown.bs.modal', function () {
                $('#input-modal-nota').focus();
            });

            $('#modalGestionarNota').modal('show');
        }

        function guardarDesdeModal(id) {
            let nota = $('#input-modal-nota').val().trim();
            if (!nota) {
                toastr.warning('La nota no puede estar vacía al guardar. Si desea borrarla, use el botón rojo de "Eliminar".');
                $('#input-modal-nota').focus();
                return;
            }
            enviarNotaAjax(id, nota, false);
        }

        function confirmarEliminarNota(id) {
            // Ocultamos el modal principal mientras mostramos SweetAlert sobre el borrado
            $('#modalGestionarNota').modal('hide');

            setTimeout(function() {
                swal({
                    title: "¿Eliminar nota?",
                    text: "Esta acción no se puede deshacer.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ed5565",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true
                }, function(isConfirm){
                    if(isConfirm){
                        enviarNotaAjax(id, '', true);
                    } else {
                        // Si cancela, reabrimos el modal de edición
                        $('#modalGestionarNota').modal('show');
                    }
                });
            }, 300);
        }

        function enviarNotaAjax(id, nota, isDelete = false) {
            // Bloqueamos los botones para evitar doble submit
            $('#modalGestionarNota').find('.btn').prop('disabled', true);

            $.ajax({
                url: "{{ route('cotizacion.guardar_nota', ':id') }}".replace(':id', id),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nota_informativa: nota
                },
                success: function(response) {
                    if(response.success){
                        $('#modalGestionarNota').modal('hide');
                        if (isDelete) {
                            toastr.success('Nota eliminada correctamente', 'Éxito');
                        } else {
                            toastr.success(response.message, 'Éxito');
                        }
                        // Recargar tabla
                        $('.dataTables-example-cotizacion').DataTable().ajax.reload(null, false);
                    }else{
                        toastr.error(response.message, "Error");
                        $('#modalGestionarNota').find('.btn').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    toastr.error("Error al procesar la nota.", "Error");
                    $('#modalGestionarNota').find('.btn').prop('disabled', false);
                }
            });
        }
    </script>

@endsection
