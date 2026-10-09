@extends('layout')

@section('title', 'Boletas Pagadas')
@section('content')
    @if ($errors->any())
        <div style="padding-top: 20px;">
            <div class="alert alert-danger">
                <a class="alert-link" href="#">
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </a>
            </div>
        </div>
    @endif

    {{-- @include('cobranzas.boletas.shared.statitics') --}}


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist"
                                style="align-items: center;border-bottom: 0px !important;">
                                @include('cobranzas.boletas._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-download"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button type="button" id="btn-exportar-filtrado" class="dropdown-item">
                                                <i class="fa fa-file-excel-o"></i> Excel
                                            </button>
                                        </div>
                                    </div>
                                </ul>
                            </ul>
                            <div class="tab-content" style="margin-top: -1px">
                                <div class="tab-pane active show" role="tabpanel" id="tab-1"
                                    style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter" value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group" style="flex-wrap: nowrap;">
                                                    <select class="select2_demo_client" name="cliente" id="cliente"
                                                        required=""></select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <select class="select_2_tipo_pago" name="forma_pago_id" id="tipo_forma_pago">
                                                        <option value="">Seleccionar Forma de Pago</option>
                                                        <option value="1">Contado</option>
                                                        <option value="2">Credito</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-primary btn-block"
                                                    id="button_filtros">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table
                                            class="table table-striped table-bordered table-hover dataTables-example-boletas-pagados">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>Estado</th>
                                                    <th>N° de Boleta</th>
                                                    <th>Cliente</th>
                                                    <th>Emisión</th>
                                                    <th>Forma de Pago</th>
                                                    <th>N° Cuotas</th>
                                                    <th>Total</th>
                                                    <th>Fecha Cancelado</th>
                                                    <th>@can('boleta.detalle_pago') Acciones @endcan</th>
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
    <style>
        table {
            width: 100% !important;
        }

        .pago_m {
            display: none;
        }

        .pago_m.m_pago_1 {
            display: block;
        }

        #view_all {
            display: none;
        }

        .view_pagos {
            display: none;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .select2-search__field {
            width: 100% !important;
        }

        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        .select2-selection.select2-selection--single {
            height: 100%;
        }

        .select2-container.select2-container--default.select2-container--open {
            z-index: 3200;
        }

        .div_select>.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        label.col-form-label {
            font-weight: bold;
        }

        .input-group.col-sm-4 {
            height: fit-content;
        }

        .input-group-text {
            width: 40px;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .col-sm-9>.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        i.fa.fa-arrow-right.icon.icon-arrow-right.glyphicon.glyphicon-arrow-right {
            color: black;
            display: none;
        }

        .next.available::after {
            content: ">>";
        }

        i.fa.fa-arrow-left.icon.icon-arrow-left.glyphicon.glyphicon-arrow-left {
            color: black;
            display: none;
        }

        .prev.available::after {
            content: "<<";
        }

        .form-control.tipo_check {
            width: 20px;
        }

        #collapse-head-three,
        #collapse-head-four {
            cursor: pointer;
        }

        .tab-pane.active.show {
            border-right: 1px;
            border-left: 1px;
            border-bottom: 1px;
        }

        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        .search-responsive {
            padding-right: 15px;
            padding-left: 15px;
        }
    </style>
    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>

    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">

    <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $(".select2_demo_client").select2({
            placeholder: "Seleccionar Cliente",
            allowClear: true,
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    var tipo_coti = $('[name="tipo_coti"]:checked').val();
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_coti: tipo_coti
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };
                        })
                    };
                },
                cache: true
            }
        });
        $('.select_2_estado').select2();
        $('.select_2_tipo_pago').select2();

        $('#tab-2-tab').addClass('active');
        $(".select2_demo_client").select2({
            placeholder: "Seleccionar Cliente",
            allowClear: true,
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    var tipo_coti = $('[name="tipo_coti"]:checked').val();
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_coti: tipo_coti
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };
                        })
                    };
                },
                cache: true
            }
        });
        $('.select_2_estado').select2();
        $('.select_2_tipo_pago').select2();
        // FUNCION DE DATATABLE FACTURA M
        var permiso_ver = false;
        var boleta_table = $('.dataTables-example-boletas-pagados').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('cobranzas.lista_boletas_pagados_index') }}",
                method: "get",
                data: function(d) {
                    d.datarange = $('#data_range_filter').val();
                    d.cliente_id = $("#cliente option:selected").val();
                    d.estado_pago = $('#select_estado').val();
                    d.tipo = $('#select_tipo_pago').val();
                },
                dataSrc: function(json){
                    permiso_ver = json.permiso_ver;
                    return json.data
                }
            },
            "drawCallback": function(settings) {
                // Esta función se ejecuta después de cada draw/redraw del DataTable
                // initializeICheck($('.dataTables-guia-ingreso'));
                // restoreCheckboxState();
                // updateSelectionCounter();
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" id="check_' + full[0] +
                            '" class="i-checks check_only check_lost_' + full[0] +
                            '" name="select_row" value="' + full[0] + '" >';
                    }
                },
                {
                    // 'width': '5%',
                    'targets': [1],
                    'render': function(data, type, full, meta) {
                        return `<span class="badge badge-primary">Pagado</span>`;
                    }
                },
                {
                    // 'width': '5%',
                    'targets': [2],
                },
                {
                    // 'width': '5%',
                    'targets': [3],
                },
                {
                    // 'width': '5%',
                    'targets': [4],
                },
                {
                    // 'width': '5%',
                    'targets': [5],
                },
                {
                    // 'width': '5%',
                    'targets': [6],
                },
                {
                    // 'width': '5%',
                    'targets': [7],
                },
                {
                    // 'width': '5%',
                    'targets': [8],
                    // 'render': function(data, type, full, meta) {
                    //     var fechaStr = full[8];
                    //     if (!fechaStr) return "";

                    //     var partes = fechaStr.split("-");
                    //     var fecha = new Date(partes[2], partes[1] - 1, partes[0]);

                    //     var hoy = new Date();


                    //     if (fecha < hoy) {
                    //         return `<span style="color:red; font-weight:bold;">${fechaStr}</span>`;
                    //     } else {

                    //         return `<span>${fechaStr}</span>`;
                    //     }
                    // }
                },
                {
                    // 'width': '55%',
                    'targets': [9],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var base_url = "{{ route('pagos.show_boletas', ':id') }}";
                        var url_view = base_url.replace(':id', full[0]);
                        var view =``;
                        if(permiso_ver){
                            view += `<a class="btn btn-primary btn-ls"
                                href=" ` + url_view + `"><i class="fa fa-eye"></i></a>`;
                        }
                        return view;
                    }
                },
                // {
                //     'width': '5%',
                //     'targets': [10],
                // },
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('.check_fact').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

                $('[data-toggle="popover"]').popover({
                    trigger: 'hover',
                    container: 'body'
                });
            }
        })
        $(`#button_filtros`).on('click', function() {
            boleta_table.ajax.reload();
        });
    </script>
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
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

            function hasAnySelection() {
                return Array.isArray(allSelectedIds) && allSelectedIds.length > 0;
            }
            // Función para obtener TODOS los IDs mediante AJAX (para serverSide DataTables)
            function getAllIds(callback) {
                $.ajax({
                    url: "{{ route('cobranzas.lista_boletas_pagados_index') }}",
                    method: "GET",
                    data: {
                        datarange: $('#data_range_filter').val(),
                        estado_pago: $('#select_estado').val(),
                        cliente_id: $("#cliente option:selected").val(),
                        tipo: $('#select_tipo_pago').val(),
                        value: "",
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
                        console.log(
                            'Master checkbox marcado automáticamente - todos los registros están seleccionados'
                            );
                    } else if (!allSelected && masterChecked) {
                        masterChecked = false;
                        $('thead input[type="checkbox"]').iCheck('uncheck');
                        console.log(
                            'Master checkbox desmarcado automáticamente - no todos los registros están seleccionados'
                            );
                    }
                    isUpdatingCheckboxes = false;
                });
            }

            // Checkbox del header - seleccionar/deseleccionar todos
            $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
                if (isUpdatingCheckboxes) return; // Evitar loops infinitos

                // closeWhatsappPanels();
                // closeEmailPanels();

                if (event.type === 'ifChecked') {
                    masterChecked = true;
                    console.log('Master checkbox marcado manualmente - obteniendo todos los IDs...');

                    getAllIds(function(ids) {
                        allSelectedIds = [...ids]; // Crear una copia del array
                        console.log('allSelectedIds después del master:', allSelectedIds);
                        console.log('Cantidad de IDs en allSelectedIds:', allSelectedIds.length);

                        // Marcar todos los checkboxes visibles en la página actual
                        isUpdatingCheckboxes = true;
                        $('.dataTables-example-boletas-pagados tbody input[type="checkbox"]')
                            .iCheck('check');
                        isUpdatingCheckboxes = false;
                    });
                } else {
                    masterChecked = false;
                    allSelectedIds = [];
                    console.log('Master checkbox desmarcado manualmente - allSelectedIds limpio');

                    isUpdatingCheckboxes = true;
                    $('.dataTables-example-boletas-pagados tbody input[type="checkbox"]').iCheck(
                    'uncheck');
                    isUpdatingCheckboxes = false;
                }
            });

            // Checkboxes individuales
            $(document).on('ifChecked ifUnchecked',
                '.dataTables-example-boletas-pagados tbody input[type="checkbox"]',
                function(event) {
                    if (isUpdatingCheckboxes)
                return; // Evitar que se ejecute cuando estamos actualizando programáticamente

                    // closeWhatsappPanels();
                    // closeEmailPanels();

                    var row = $(this).closest('tr');
                    var rowData = boleta_table.row(row).data();

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

            // Cuando se redibuje la tabla (cambio de página, etc.)
            boleta_table.on('draw', function() {
                // closeWhatsappPanels();
                // closeEmailPanels();
                console.log('Tabla redibujada. allSelectedIds actual:', allSelectedIds);
                console.log('masterChecked actual:', masterChecked);

                // Reinicializar checkboxes
                $('.dataTables-example-boletas-pagados tbody input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

                // Usar setTimeout para asegurar que iCheck esté completamente inicializado
                setTimeout(function() {
                    isUpdatingCheckboxes = true;

                    // Procesar cada checkbox en la página actual
                    $('.dataTables-example-boletas-pagados tbody input[type="checkbox"]').each(
                        function() {
                            var row = $(this).closest('tr');
                            var rowData = boleta_table.row(row).data();

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

            // Manejar click del botón de exportar
            $('#btn-exportar-filtrado').on('click', function(e) {
                e.preventDefault();

                if (allSelectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una boleta para exportar.",
                        type: "warning",
                        confirmButtonColor: "#1a3bb3"
                    });
                    return;
                }

                swal({
                    title: "Confirmar exportación",
                    text: `¿Deseas exportar ${allSelectedIds.length} boletas(s) seleccionada(s) a Excel?`,
                    type: "info",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: "#1a3bb3"
                }, function(isConfirm) {
                    if (!isConfirm) return;

                    $('#btn-exportar-filtrado').prop('disabled', true);

                    $.ajax({
                        url: "{{ route('cobranzas.boletas_exportar_pagadas') }}",
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            factura_ids: allSelectedIds
                        }),
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        complete: () => $('#btn-exportar-filtrado').prop('disabled', false),
                        success: function(blob) {
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download =
                                `Boletas_${new Date().toISOString().slice(0,10)}.xlsx`;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        }
                    });
                });
                // });
            });

            // Funciones helper para debugging (opcional)
            window.clearAllSelections = function() {
                allSelectedIds = [];
                masterChecked = false;
                isUpdatingCheckboxes = true;
                $('thead input[type="checkbox"]').iCheck('uncheck');
                $('.dataTables-example-boletas-pagados tbody input[type="checkbox"]').iCheck('uncheck');
                isUpdatingCheckboxes = false;
                console.log('Todas las selecciones limpiadas');
            };

            window.getSelectedIds = function() {
                console.log('IDs actualmente seleccionados:', allSelectedIds);
                return allSelectedIds;
            };
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
    </script>
@endsection
