@extends('layout')

@section('title', 'Ventas | Nota de Venta')

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
                                        {{-- ALMACEN --}}
                                        @if (auth()->user()->name == 'Administrador')
                                            {{-- Condicional por tipo de user  --}}
                                            <span class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                                    <span style="margin-left:12px;"><b>Almacenes:</b></span>
                                                    @foreach ($almacen as $almacens)
                                                        <li>
                                                            <form action="{{ route('nota_venta.create') }}"
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
                                            <form action="{{ route('nota_venta.create') }}" enctype="multipart/form-data"
                                                method="post" class="tooltip-demo">
                                                @csrf
                                                <input type="text" value="{{ auth()->user()->almacen_id }}"
                                                    hidden="hidden" name="almacen">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" id="btn-imprimir" class="btn btn-success" title="Imprimir">
                                            <i class="fa fa-print"></i>
                                        </button>
                                        <button type="button" id="btn-exportar-filtrado" class="btn btn-primary"
                                            title="Exportar a Excel">
                                            <i class="fa fa-upload"></i>
                                        </button>

                                    </ul>

                                </ul>
                            </div>
                            </div>
                            <div class="tab-content" style="margin-top: -1px">
                                <!-- NOTA DE VENTA-->
                                <div role="tabpanel" id="tab-3" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row" style="row-gap: 10px;">
                                            <div class="col-lg-3 col-md-6 col-sm-12">
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
                                                <select class="form-control select2_demo_client" name=""
                                                    id="cliente_id">
                                                    {{-- <option value="" selected>Todos los clientes</option> --}}
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>{{--  Tabla de Nota de Venta   --}}
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-nota_venta" style="min-width: 982px">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>N°</th>
                                                    <th>RUC-DNI</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Forma</th>
                                                    <th>Importe T.</th>
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
                                                    <th class="total-total">Total G: 0</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- CLIENTES-->
                            <div role="tabpanel" id="tab-4" class="tab-pane">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('transaccion.venta._shared.js_shared')
    <style>
        .select2.select2-container.select2-container--default{
            width: 100% !important;
            height: 100% !important;
        }
        .select2.select2-container.select2-container--default  > span {
            height: 100% !important;
        }
        .select2-container--default .select2-selection--single{
            height: 100% !important;
            display: flex;
            align-content: center;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            top: 0px !important;
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

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
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
        var coti_table = $('.dataTables-example-nota_venta').DataTable({
            "lengthChange": false,
            "responsive": true,
            "pageLength": 15,
            "searching": false,
            "serverSide": true,
            "ajax": {
                url: "{{ route('ventas.nota_venta_registers') }}",
                method: "get",
                data: function(d) {
                    // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                    d.daterange = $('#data_range_filter').val(); // Supongamos que tienes un campo input con rango de fechas
                    d.cliente_id = $('#cliente_id').val();
                    d.value = $('#search_all_column').val();
                },
                dataSrc: function(json) {
                    // Suponiendo que el valor adicional viene con el nombre 'total'
                    var total_columna = json.total_columna;
                    var total_table = json.total_table;

                $('.dataTables-example-nota_venta tfoot th.total-columna').html('Total: ' + total_columna);
                $('.dataTables-example-nota_venta tfoot th.total-total').html('Total G.: ' + total_table);

                return json.data;
            }
        },
        "columnDefs": [{
                'width': '1vmax',
                'targets': [0],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    return '<input type="checkbox" name="select_row" value="' + full[0] +
                        '" class="i-checks-boleta">';
                }
            },
            {
                'width': '30%',
                'targets': [4]
            },
            {
                'targets': [8],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    var url = '{{ route('nota_venta.show', ':id') }}';
                    url = url.replace(':id', full[0]);

                    if (full[9] == '1') {
                        return `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-warning">
                                    <i class="fa fa-clock-o"></i>
                                </button>`;
                    } else {
                        return `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-info">
                                    <i class="fa fa-check-circle"></i>
                                </button>`;
                    }
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

    // Configuración del datepicker
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

    $('#filter_buttons').on('click', function() {
        coti_table.ajax.reload();
    });

    // Configuración de iCheck para checkboxes
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    // Variables globales
    var allSelectedIds = [];
    var masterChecked = false;

    // Función para obtener TODOS los IDs mediante AJAX (para serverSide DataTables)
    function getAllIds(callback) {
        $.ajax({
            url: "{{ route('ventas.nota_venta_registers') }}",
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

    // Controlar el checkbox del thead
    $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
        if (event.type === 'ifChecked') {
            masterChecked = true;
            console.log('Master checkbox marcado - obteniendo todos los IDs...');

            // Obtener TODOS los IDs mediante AJAX
            getAllIds(function(ids) {
                allSelectedIds = ids;
                console.log('allSelectedIds después del master (debería tener TODOS):', allSelectedIds);
                console.log('Cantidad de IDs en allSelectedIds:', allSelectedIds.length);

                // Marcar todos los checkboxes visibles en la página actual
                $('.i-checks-boleta').iCheck('check');
            });
        } else {
            masterChecked = false;
            allSelectedIds = [];
            console.log('Master checkbox desmarcado - allSelectedIds limpio');
            $('.i-checks-boleta').iCheck('uncheck');
        }
    });

    // Controlar checkboxes individuales
    $(document).on('ifChecked ifUnchecked', '.i-checks-boleta', function(event) {
        var row = $(this).closest('tr');
        var rowData = coti_table.row(row).data();

        if (rowData && rowData[0]) {
            var id = rowData[0].toString();

            if (event.type === 'ifChecked') {
                if (!allSelectedIds.includes(id)) {
                    allSelectedIds.push(id);
                }
            } else {
                allSelectedIds = allSelectedIds.filter(function(selectedId) {
                    return selectedId !== id;
                });

                // Si se desmarca uno, desmarcar el master
                masterChecked = false;
                $('thead input[type="checkbox"]').iCheck('uncheck');
            }
        }

        console.log('allSelectedIds después de checkbox individual:', allSelectedIds);
    });

    // Cuando se redibuje la tabla (cambio de página, filtros, etc.)
    coti_table.on('draw', function() {
        // Reinicializar iCheck para los nuevos elementos
        $('.i-checks-boleta').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Si master está marcado, marcar todos los checkboxes de esta página
        if (masterChecked) {
            setTimeout(function() {
                $('.i-checks-boleta').iCheck('check');
            }, 100);
        } else {
            // Marcar solo los seleccionados individualmente
            setTimeout(function() {
                $('.i-checks-boleta').each(function() {
                    var row = $(this).closest('tr');
                    var rowData = coti_table.row(row).data();
                    if (rowData && rowData[0]) {
                        var id = rowData[0].toString();
                        if (allSelectedIds.includes(id)) {
                            $(this).iCheck('check');
                        }
                    }
                });
            }, 100);
        }
    });

    // Función para imprimir notas de venta seleccionadas
    $('#btn-imprimir').on('click', function(e) {
        e.preventDefault();

        console.log('IDs seleccionados:', allSelectedIds);

        if (allSelectedIds.length === 0) {
            swal({
                title: "Sin selección",
                text: "Por favor, selecciona al menos una nota de venta para imprimir.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        swal({
            title: "Confirmar impresión",
            text: `¿Deseas imprimir ${allSelectedIds.length} nota(s) de venta seleccionada(s)?`,
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sí, imprimir",
            cancelButtonText: "Cancelar"
        }, function(isConfirm) {
            if (isConfirm) {
                var url = '{{ route("notaVenta.print.multiple") }}';
                var params = new URLSearchParams();

                allSelectedIds.forEach(function(id) {
                    params.append('nota_ids[]', id);
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
            });

            // Detectar cuando se cambia de tab
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                // Restablecer el estado de los checkboxes
                var activeTab = $(e.target).attr('href'); // ID del tab activo
                $(activeTab).find('.i-checks').iCheck('update');
            });
        });
    </script>
    {{-- Script para el llamada a los otros tabs --}}
    <script></script>

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
                var exportUrl = "{{ route('export.nota_venta') }}";
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

        $(".select2_demo_client").select2({
            // theme: "bootstrap",
            placeholder: "Seleccionar Cliente",
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
                        tipo_coti: 2
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
    </script>

@endsection
