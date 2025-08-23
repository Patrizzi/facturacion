@extends('layout')

@section('title', 'Comprobantes | Nota de Debito')

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
                                    {{-- <a class="btn btn-success" href="{{ route('facturacion_manual.create') }}"><i
                                            class="fa fa-plus"></i></a> --}}
                                    <span class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                            <span style="margin-left:12px;"><b>Seleccionar tipo:</b></span>
                                            {{-- <button class="btn btn-w-m btn-link"
                                                type="submit"></button> --}}
                                            <a class="btn btn-w-m btn-link"
                                                href="{{ route('nota-credito.create') }}">Factura</a>
                                            <a class="btn btn-w-m btn-link"
                                                href="{{ route('nota-credito.create_boleta') }}">Boleta</a>
                                        </ul>
                                    </span>
                                    <button type="button" id="btn-imprimir" class="btn btn-success" title="Imprimir">
                                        <i class="fa fa-download"></i>
                                    </button>
                                    <button type="button" id="btn-exportar-filtrado" class="btn btn-success" title="Exportar a Excel">
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
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" name="" id="select_tipo_coti">
                                                    <option value="" selected>Todos los comprobantes</option>
                                                    <option value="factura">Factura</option>
                                                    <option value="factura_manual">factura Manual</option>
                                                    <option value="boleta">Boleta</option>
                                                    <option value="boleta_manual">Boleta Manual</option>
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
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-nota-credito">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>Doc. Afectado</th>
                                                    <th>RUC / DNI</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Forma</th>
                                                    {{-- <th>Importe T.</th> --}}
                                                    <th>Ver</th>
                                                    <th>Eliminar</th>
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
    {{-- MODAL DE ANULACION DE NOTA DE CREDITO --}}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <form action="{{ route('nota_credito.anular') }}" method="POST">
                            @csrf
                            <center>
                                <p>¿Desea Anular la Nota de credito N°<strong> <span id="strong_nota"> </span></strong>
                                    anidada al documento N° <strong><span id="string_doc"></span></strong>?</p>
                                <input type="hidden" name="id_nota_cre" value="" id="nota_credito_id">
                                <button class="btn btn-danger" type="submit">Anular</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('transaccion\comprobantes\_shared\js_shared')

    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-5-tab').addClass('active');
        });
        var coti_table = $('.dataTables-example-nota-credito').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('comprobantes.notaCredito_registers') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#data_range_filter').val();
                    d.tipo_comprobante = $('#select_tipo_coti').val();
                    d.value = $('#search_all_column').val();
                }
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" name="select_row" value="' + full[2] +
                            '" class="i-checks-boleta">';
                    }
                },
                {
                    'width': '100px',
                    'targets': [4]
                },

                {
                    'width': '0.5vmax',
                    'targets': [8],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('nota-credito.show', ':id') }}';
                        url = url.replace(':id', full[0]);
                        return `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a> `;
                    }
                },
                {
                    /// /* ELIMINAR
                    'width': '',
                    'targets': [9],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('nota-credito.show', ':id') }}';
                        url = url.replace(':id', full[0]);
                        if (full[9] == 1) {
                            return ` <button class="btn btn-secondary disabled" type="button"  data-toggle="tooltip" data-placement="bottom" title="Solo se puede Anular los pendientes a Enviar" ><i class="fa fa-trash"></i>
                                                </button>`;
                        } else {
                            return `<button value="` + full[2] + `"  onclick="anular_nota(this.value, '` +full[0]+`','`+full[3]+`' )" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter" ><i class="fa fa-trash"></i></button> `;
                        }
                    }
                },
                {
                    'targets': [10], // Configuración para otra columna (como la de acciones)
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

        function anular_nota(a1, id, doc) {
            console.log(a1);
            // $('#strong_nota').val(strong_nota);
            var val = a1;
            document.getElementById("strong_nota").innerHTML = a1;
            $('#nota_credito_id').val(id);
            $('#string_doc').html(doc);


            // document.getElementById.value
            // console.log(codigo_n_c);
            $('#exampleModalCenter').modal('show');
        }
    </script>
        <script>
    $(document).ready(function() {
        // Manejar click del botón de exportar
        $(document).on('click', '#btn-exportar-filtrado', function(e) {
            e.preventDefault();

            // Obtener los valores actuales de los filtros (exactamente como en tu DataTable)
            var daterange = $('#data_range_filter').val();
            var value = $('#search_all_column').val(); // Cambiado de 'search' a 'value'
            var tipo_coti = $('#select_tipo_coti').val();

            // Construir la URL con parámetros
            var exportUrl = "{{ route('export.notas.credito') }}";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Variable global para la DataTable
var coti_table;

$(document).ready(function() {
    // Inicializar iCheck para los checkboxes
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    var allChecked = false;

    // Checkbox principal para seleccionar/deseleccionar todos
    $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
        var table = $(this).closest('table');

        if (event.type === 'ifChecked') {
            allChecked = true;
            table.find('tbody input[type="checkbox"]').iCheck('check');
            $('.i-checks').iCheck('check');
        } else {
            allChecked = false;
            table.find('tbody input[type="checkbox"]').iCheck('uncheck');
            $('.i-checks').iCheck('uncheck');
        }
    });

    // Cuando cambien los checkboxes individuales
    $(document).on('ifChanged', '.i-checks', function(event) {
        var table = $('.dataTables-example-nota-credito');
        var totalCheckboxes = $('.i-checks').length;
        var checkedCheckboxes = $('.i-checks:checked').length;

        if (checkedCheckboxes === totalCheckboxes && totalCheckboxes > 0) {
            table.find('thead input[type="checkbox"]').iCheck('check');
            allChecked = true;
        } else {
            table.find('thead input[type="checkbox"]').iCheck('uncheck');
            allChecked = false;
        }
    });

    // Cuando cambien de pestaña
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var activeTab = $(e.target).attr('href');
        $(activeTab).find('.i-checks').iCheck('update');
    });

    // Inicializar DataTable
    coti_table = $('.dataTables-example-nota-credito').DataTable({
        "serverSide": true,
        "ajax": {
            url: "{{ route('comprobantes.notaCredito_registers') }}",
            method: "get",
            data: function(d) {
                d.daterange = $('#data_range_filter').val();
                d.tipo_comprobante = $('#select_tipo_coti').val();
                d.value = $('#search_all_column').val();
            }
        },
        "columnDefs": [{
                'targets': [0],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    return '<input type="checkbox" name="select_row" value="' + full[0] + '" class="i-checks">';
                }
            },
            {
                'width': '100px',
                'targets': [4]
            },
            {
                'width': '0.5vmax',
                'targets': [8],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    var url = '{{ route('nota-credito.show', ':id') }}';
                    url = url.replace(':id', full[0]);
                    return `<a href="${url}">
                                <button type="button" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </a>`;
                }
            },
            {
                'targets': [9],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    var url = '{{ route('nota-credito.show', ':id') }}';
                    url = url.replace(':id', full[0]);
                    if (full[9] == 1) {
                        return `<button class="btn btn-secondary disabled" type="button" data-toggle="tooltip" data-placement="bottom" title="Solo se puede Anular los pendientes a Enviar">
                                    <i class="fa fa-trash"></i>
                                </button>`;
                    } else {
                        return `<button value="${full[2]}" onclick="anular_nota(this.value, '${full[0]}','${full[3]}')" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class="fa fa-trash"></i>
                                </button>`;
                    }
                }
            },
            {
                'targets': [10],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    const estados = {
                        0: { texto: "Sin Enviar", clase: "btn-warning", icono: "fa fa-clock-o" },
                        1: { texto: "Enviado", clase: "btn-info", icono: "fa fa-check-circle" },
                        2: { texto: "Anulado", clase: "btn-danger", icono: "fa fa-check-circle" }
                    };

                    let end = "";
                    const estadoSunat = parseInt(full[9]);
                    const estadoCredito = parseInt(full[10]);
                    const estadoDebito = parseInt(full[11]);

                    const e0 = estados[estadoSunat];
                    end += `<button class="btn ${e0.clase} btn-circle btn-ls" title="${e0.texto}">
                                <i class="${e0.icono}"></i>
                            </button>`;
                    return end;
                }
            }
        ],
        "drawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
            
            // Reinicializar iCheck después de cada dibujo
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            if (allChecked) {
                $('.i-checks').iCheck('check');
            }
        }
    });

    // Configuración del datepicker
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

    // Función para filtrar
    $('#filter_buttons').on('click', function() {
        coti_table.ajax.reload();
    });

    // Función para exportar a Excel
    $('#btn-exportar-filtrado').on('click', function(e) {
        e.preventDefault();
        // ... (tu código existente para exportar)
    });

    // ==============================================
    // BOTÓN DE IMPRIMIR (Adaptado de tu ejemplo)
    // ==============================================
    $('#btn-imprimir').on('click', function(e) {
        e.preventDefault();

        var selectedIds = [];
        $('.i-checks:checked').each(function() {
            var row = $(this).closest('tr');
            var rowData = coti_table.row(row).data();
            if (rowData && rowData[0]) {
                selectedIds.push(rowData[0]);
            }
        });

        if (selectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una nota de crédito para imprimir.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        swal({
            title: "Confirmar impresión",
            text: `¿Deseas imprimir ${selectedIds.length} nota(s) de crédito seleccionada(s)?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, imprimir",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function(isConfirm) {
            if (isConfirm) {
                var url = '{{ route("nota-credito.print-multiple") }}';
                var params = new URLSearchParams();

                selectedIds.forEach(function(id) {
                    params.append('nota_ids[]', id);
                });

                var printWindow = window.open(
                    url + '?' + params.toString(),
                    '_blank'
                );

                if (printWindow) {
                    printWindow.focus();
                    swal({
                        title: "¡Éxito!",
                        text: "Las notas de crédito se están imprimiendo...",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    swal({
                        title: "Error",
                        text: "Por favor, permite ventanas emergentes para imprimir",
                        type: "error",
                        confirmButtonText: "Entendido"
                    });
                }
            }
        });
    });
});

// Función para anular nota
function anular_nota(a1, id, doc) {
    document.getElementById("strong_nota").innerHTML = a1;
    $('#nota_credito_id').val(id);
    $('#string_doc').html(doc);
    $('#exampleModalCenter').modal('show');
}
</script>
@endsection
