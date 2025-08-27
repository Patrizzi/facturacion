
@extends('layout')

@section('title', 'Comprobantes | Guia de Remision')

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
                                    @if (auth()->user()->name == 'Administrador' && $almacen->count() != 1){{-- Condicional por tipo de user  --}}
                                        <span class="dropdown">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" >
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                                <span style="margin-left:12px;"><b>Almacenes:</b></span>
                                                @foreach ($almacen as $almacens)
                                                    <li>
                                                        <form action="{{ route('guia_remision.create') }}"
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
                                        <form action="{{ route('guia_remision.create') }}" enctype="multipart/form-data"
                                            method="post" class="tooltip-demo">
                                            @csrf
                                            <input type="text" value="{{ auth()->user()->almacen_id }}" hidden="hidden"
                                                name="almacen">
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <button type="button" id="btn-imprimir" class="btn btn-success" title="Imprimir">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <button type="button" id="btn-exportar-guias" class="btn btn-success" title="Exportar a Excel">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>

                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-5" class="tab-pane active show">
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
                                                    <option value="factura_manual">factura Manual</option>
                                                    <option value="boleta">Boleta</option>
                                                    <option value="boleta_manual">Boleta Manual</option>
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
                                        <table class="table table-striped table-bordered dataTables-example-guia-remision">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>RUC</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Fecha de Entrega</th>
                                                    <th>Ver</th>
                                                    <th style="width: 0.5vmax !important">Acciones</th>
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
    <form id="form-pdf-lote" method="POST"
        action="{{ route('guia_remision.print.multiple') }}"
        target="_blank" style="display:none;">
        @csrf
    </form>
    @include('transaccion\comprobantes\_shared\js_shared')
    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-7-tab').addClass('active');
        });
        var coti_table = $('.dataTables-example-guia-remision').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('comprobantes.guiaRemision_registers') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#data_range_filter').val();
                    // d.tipo_comprobante = $('#select_tipo_coti').val();
                    d.value = $('#search_all_column').val();
                }
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" name="select_row" value="' + full[0] + '" class="i-checks-boleta">';
                    }
                },
                {
                    'width': '0.5vmax',
                    'targets': [3]
                },

                {
                    'width': '0.5vmax',
                    'targets': [7],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('guia_remision.show', ':id') }}';
                        url = url.replace(':id', full[0]);
                        return `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a> `;
                    }
                },
                {
                    'targets': [8], // Configuración para otra columna (como la de acciones)
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

                        const estadoSunat = parseInt(full[8]);
                        const estadoCredito = parseInt(full[9]);
                        const estadoDebito = parseInt(full[10]);

                        const e0 = estados[estadoSunat];
                        end += `<button class="btn ${e0.clase} btn-circle btn-ls" title=" ${e0.texto}">
                                    <i class="${e0.icono}"></i>
                                </button> `;
                        return end;

                    }
                }
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('.i-checks-boleta').iCheck({
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
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Click en Exportar
            $(document).on('click', '#btn-exportar-guias', function (e) {
                e.preventDefault();

                // 1) Verificar que la DataTable tenga registros visibles
                var info = $('.dataTables-example-guia-remision').DataTable().page.info();
                if (info.recordsTotal === 0 || info.recordsDisplay === 0) {
                    swal({
                        title: "No hay registros",
                        text: "No hay registros para exportar con los filtros aplicados.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    });
                    return;
                }

                // 2) Tomar los filtros actuales EXACTAMENTE como los usa la DataTable
                var daterange = $('#data_range_filter').val();
                var value = $('#search_all_column').val();

                // IMPORTANTE: usa el mismo separador que espera el backend.
                // Si el backend explota por ' - ', procura que el input tenga ' - ' también.

                // 3) Construir la URL hacia la nueva ruta de exportación
                var exportUrl = "{{ route('guia_remision.exportar') }}";
                var params = new URLSearchParams();
                if (daterange) params.append('daterange', daterange);
                if (value)     params.append('value', value);

                // 4) Disparar la descarga (por ahora abrirá la ruta; luego devolverá el Excel)
                window.location.href = exportUrl + '?' + params.toString();
            });
        });
    </script>

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            var allChecked = false;

            // Seleccionar/Deseleccionar todo (encabezado)
            $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
                var table = $(this).closest('table');

                if (event.type === 'ifChecked') {
                    allChecked = true;
                    table.find('tbody input[type="checkbox"]').iCheck('check');
                    $('.i-checks-boleta').iCheck('check');
                } else {
                    allChecked = false;
                    table.find('tbody input[type="checkbox"]').iCheck('uncheck');
                    $('.i-checks-boleta').iCheck('uncheck');
                }
            });

            // Si todos los de la página están check -> marcar header; si no, desmarcar
            $(document).on('ifChanged', '.i-checks-boleta', function(event) {
                var table = $('.dataTables-example-guia-remision');
                var totalCheckboxes = $('.i-checks-boleta').length;
                var checkedCheckboxes = $('.i-checks-boleta:checked').length;

                if (checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0) {
                    table.find('thead input[type="checkbox"]').iCheck('check');
                    allChecked = true;
                } else {
                    table.find('thead input[type="checkbox"]').iCheck('uncheck');
                    allChecked = false;
                }
            });

            // Redibujado de la DT => re-init iCheck
            coti_table.on('draw', function() {
                $('.i-checks-boleta').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

                // Mantener marcado de página si el header estaba activo
                if (allChecked) {
                    $('.i-checks-boleta').iCheck('check');
                }
            });

            // === Botón IMPRIMIR (igual al de factura) ===
            $('#btn-imprimir').on('click', function(e) {
                e.preventDefault();

                var selectedIds = [];
                $('.i-checks-boleta:checked').each(function() {
                    var row = $(this).closest('tr');
                    var rowData = coti_table.row(row).data();
                    if (rowData && rowData[0]) {
                        selectedIds.push(rowData[0]); // ID en col 0
                    }
                });

                if (selectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una guía para imprimir.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    });
                    return;
                }

                swal({
                    title: "Confirmar impresión",
                    text: `¿Deseas imprimir ${selectedIds.length} guía(s) seleccionada(s)?`,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Sí, imprimir",
                    cancelButtonText: "Cancelar"
                }, function(isConfirm) {
                    if (isConfirm) {
                        var url = '{{ route("guia_remision.print.multiple") }}';
                        var params = new URLSearchParams();
                        selectedIds.forEach(function(id) {
                            params.append('guia_ids[]', id);
                        });

                        var printWindow = window.open(
                            url + '?' + params.toString(),
                            '_blank'
                        );

                        if (printWindow) {
                            printWindow.focus();
                        } else {
                            alert('Por favor, permite ventanas emergentes para imprimir');
                        }
                    }
                });
            });
        });
    </script>

@endsection



