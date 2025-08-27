@extends('layout')

@section('title', 'Comprobantes | Factura Manual')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            @include('transaccion\comprobantes\_shared\statistics')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                @include('transaccion\comprobantes\_shared\tabs')
                                {{-- Almacen --}}
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    {{-- ALMACEN --}}
                                    <a class="btn btn-success" href="{{ route('facturacion_manual.create') }}"><i
                                            class="fa fa-plus"></i></a>
                                    <button type="button" id="btn-imprimir" class="btn btn-success" title="Imprimir">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <button type="button" id="btn-exportar-filtrado" class="btn btn-success" title="Exportar a Excel">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>

                            </ul>
                            <div class="tab-content">
                                <!-- Factura-->
                                <div role="tabpanel" id="tab-4" class="tab-pane active show">
                                    <br> {{-- FILTRADO DE DATOS --}}
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
                                            {{-- <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" name="" id="select_tipo_coti">
                                                    <option value="" selected>Todos los comprobantes</option>
                                                    <option value="factura">Factura</option>
                                                    <option value="factura">factura</option>
                                                    <option value="nota_venta">Nota de Venta</option>
                                                </select>
                                            </div> --}}
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
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-factura">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha Emisión</th>
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
                                                </tr>
                                                <tr>
                                                    <th colspan="8"></th>
                                                    <th colspan="2" class="total-total">Total G: 0</th>
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
    {{-- <style>
        select.form-control:not([size]):not([multiple]) {
            height: 100%;
        }

        .dropdown-menu {
            left: 70px;
            padding: 20px 0;
        }

        #DataTables_Table_0_wrapper {
            /* padding-right: 0px; */
        }

        .table {
            width: 100% !important;
        }

        .ibox-content>.row {
            margin: auto;
        }

        .nav-tabs-right {
            margin-left: auto;
            /* Esto empuja el tab hacia la derecha */
        }

        .search-responsive {
            padding-right: 15px;
            padding-left: 15px;
        }

        .tab-pane.active.show {
            border-right: 1px;
            border-left: 1px;
            border-bottom: 1px;
        }

        .btn-link {
            width: 100%;
        }

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

        /* PANTALLA TABLET */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .row>.col-md-6 {
                margin-bottom: 12px;
            }
        }

        .slick-slider {
            margin-bottom: 0px;
        }

        .slick-prev {
            left: 20px;
        }

        .slick-next {
            right: 20px;
        }

        .slick-slider>button {
            z-index: 9999;
        }

        .slick-dots {
            display: none !important;
        }
    </style> --}}

    @include('transaccion\comprobantes\_shared\js_shared')
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-4-tab').addClass('active');
        });

        //  {{-- SCRIPTS PARA DATATABLE --}}

        var coti_table = $('.dataTables-example-factura').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('comprobantes.facturaM_registers') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#data_range_filter').val();
                    d.tipo_coti = $('#select_tipo_coti').val();
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
                        var url = '{{ route('facturacion_manual.show', ':id') }}';
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

    <script>
        $(document).ready(function() {
            // Manejar click del botón de exportar
            $(document).on('click', '#btn-exportar-filtrado', function(e) {
                e.preventDefault();

                // Verificar si hay datos en la tabla
                var table = coti_table; // Asegúrate que esta variable coincida con tu tabla de facturasM
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
                var exportUrl = "{{ route('facturasM.exportar') }}";
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
    // Array para almacenar todos los IDs seleccionados
    var selectedIds = [];
    var selectAllState = false;

    // Inicializar iCheck
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Checkbox del header - seleccionar/deseleccionar todos
    $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
        if (event.type === 'ifChecked') {
            selectAllState = true;
            // Obtener todos los datos de la tabla (incluyendo páginas no visibles)
            var allData = coti_table.rows().data();
            selectedIds = [];

            // Agregar todos los IDs al array
            for (var i = 0; i < allData.length; i++) {
                if (allData[i][0]) {
                    selectedIds.push(allData[i][0].toString());
                }
            }

            // Marcar checkboxes visibles
            $('.dataTables-example-factura tbody input[type="checkbox"]').iCheck('check');
        } else {
            selectAllState = false;
            selectedIds = [];
            $('.dataTables-example-factura tbody input[type="checkbox"]').iCheck('uncheck');
        }
    });

    // Checkboxes individuales
    $(document).on('ifChanged', '.dataTables-example-factura tbody input[type="checkbox"]', function(event) {
        var row = $(this).closest('tr');
        var rowData = coti_table.row(row).data();
        var id = rowData[0].toString();

        if ($(this).is(':checked')) {
            // Agregar ID si no existe
            if (selectedIds.indexOf(id) === -1) {
                selectedIds.push(id);
            }
        } else {
            // Remover ID
            var index = selectedIds.indexOf(id);
            if (index > -1) {
                selectedIds.splice(index, 1);
            }
            // Si se desmarca uno, desmarcar el "seleccionar todos"
            selectAllState = false;
            $('thead input[type="checkbox"]').iCheck('uncheck');
        }
    });

    // Cuando se redibuje la tabla (cambio de página, etc.)
    coti_table.on('draw', function() {
        // Reinicializar checkboxes
        $('.dataTables-example-factura tbody input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Si "seleccionar todos" está activo, marcar checkboxes visibles
        if (selectAllState) {
            $('.dataTables-example-factura tbody input[type="checkbox"]').iCheck('check');
        } else {
            // Marcar solo los que estén en el array selectedIds
            $('.dataTables-example-factura tbody input[type="checkbox"]').each(function() {
                var row = $(this).closest('tr');
                var rowData = coti_table.row(row).data();
                var id = rowData[0].toString();

                if (selectedIds.indexOf(id) > -1) {
                    $(this).iCheck('check');
                }
            });
        }
    });

    // Función de impresión múltiple
    $('#btn-imprimir').on('click', function(e) {
        e.preventDefault();

        console.log('IDs seleccionados:', selectedIds);

        if (selectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una factura manual para imprimir.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        swal({
            title: "Confirmar impresión",
            text: `¿Deseas imprimir ${selectedIds.length} factura(s) manual(es) seleccionada(s)?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, imprimir",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                var url = '{{ route("facturaM.print.multiple") }}';
                var params = new URLSearchParams();

                selectedIds.forEach(function(id) {
                    params.append('facturaM_ids[]', id);
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

                /*swal({
                    title: "Procesando",
                    text: "Las facturas manuales se están imprimiendo...",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });*/
            }
        });
    });
});
</script>


@endsection
