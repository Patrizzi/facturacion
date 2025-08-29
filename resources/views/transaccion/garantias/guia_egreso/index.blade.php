@extends('layout')

@section('title', ' Guias Egreso')
@section('breadcrumb', 'Guias de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.guias'))
@section('value_accion', 'Agregar')

@section('content')

    @if (session('repite'))
        <div class="alert alert-danger">
            {{ session('repite') }}
        </div>
    @endif
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

    @include('transaccion.garantias._shared.statistics')

    <div class="wrapper wrapper-content animated fadeInRight pt-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                @include('transaccion.garantias._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <a class="btn btn-sm btn-success" href="{{ route('garantia_guia_egreso.guias') }}"
                                        id="create_guia_ingreso"><i class="fa fa-plus"></i></a>
                                    <button type="button" id="bnt-imprimir" class="btn btn-sm btn-success" title="Imprimir">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <button onclick="exportarEgresosConFiltros()" class="btn btn-sm btn-success"
                                        title="Exportar a Excel">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <br>
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col">
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
                                            <div class="col">
                                                <select class="form-control select2" name="marcas_filter"
                                                    id="marcas_filter">
                                                    <option value=""></option>
                                                    @foreach ($marcas as $marca)
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="" id="procesado_filter" class="form-control">
                                                    <option value="">Todos</option>
                                                    <option value="1">Procesado</option>
                                                    <option value="0">Sin Procesar</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-egreso">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <th>ID</th>
                                                    <th>Orden Servicio</th>
                                                    <th>Marca</th>
                                                    <th>Fecha</th>
                                                    <th>Motivo</th>
                                                    <th>Asuntos</th>
                                                    <th>Cliente</th>
                                                    <th>Ver</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
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
    </style>

    @include('transaccion.garantias._shared.js_shared')
    <!-- Seleccionar todos los check -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $('#marcas_filter').select2({
            placeholder: "Selecciona una marca",
            allowClear: true,
            width: '100%'
        });
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-2').addClass('active');

        });
        var coti_table = $('.dataTables-egreso').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_guia_egreso') }}",
                method: "get",
                data: function(d) {
                    // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                    d.daterange = $('#data_range_filter').val();
                    d.marca = $('#marcas_filter').val();
                    d.procesado = $('#procesado_filter').val();
                    d.value = $('#search_all_column').val();
                }
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0], // Aplica a la primera columna (index 0)
                    'orderable': false, // Deshabilitar ordenación en esta columna
                    'render': function(data, type, full, meta) {
                        // Renderizar el checkbox en la primera columna
                        return '<input type="checkbox" name="select_row" value="' + full[0] +
                            '">';
                    }
                },
                {
                    'width': '5%',
                    'targets': [1],
                },
                {
                    'width': '10%',
                    'targets': [2],
                },
                {
                    // 'width': '8%',
                    'targets': [3],
                },
                {
                    // 'width': '10%',
                    'targets': [4],
                },
                {
                    // 'width': '8%',
                    'targets': [5],
                },
                {
                    // 'width': '8%',
                    'targets': [6],
                },
                {
                    'width': '25%',
                    'targets': [7],
                },
                {

                    'targets': [8],
                    'width': '5%',
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('garantia_guia_egreso.show', ':id') }}';
                        url = url.replace(':id', full[
                            0]); // Reemplazar el placeholder con el valor dinámico
                        // ver
                        var concat = `<div class="tooltip-demo">
                            <a href="${url}">
                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Ver"> <i class="fa fa-eye"></i> </button>
                            </a>`;

                        return concat;
                    }
                },
                {
                    'targets': [9],
                    'orderable': false,
                    'width': '5%',
                    'render': function(data, type, full, meta) {
                        var informe_tecnico = '';
                        if (full[9] == 1) {
                            informe_tecnico =
                                `<button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle" style="color:white;font-size: 110%"></i></button>`;
                        } else {
                            informe_tecnico =
                                `<button class="btn btn-warning btn-circle btn-ls"><i class="fa fa-exclamation-circle" style="color:white;font-size: 110%"></i></button>`;

                        }
                        return informe_tecnico;
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
        $(`#filter_buttons`).on('click', function() {
            coti_table.ajax.reload();
        });

        function anular_guia(id, valor) {
            console.log(id);
            let form = document.getElementById('formulario_anular');
            let action = form.getAttribute('action');
            // Reemplaza ':id' por el valor que quieras
            action = action.replace(':id', id);
            form.setAttribute('action', action);
            $('#valor_ind').text(valor);
            $(`#modal-anular`).modal('show');
        }
        $('#create_guia_ingreso').on('click', function() {
            $('#modal-form').modal('show');
        });
        $('#revert_select').on('click', function() {
            var start = moment().startOf('month');
            var end = moment().endOf('month');

            // Setear en el input
            $('input[name="daterange"]').data('daterangepicker').setStartDate(start);
            $('input[name="daterange"]').data('daterangepicker').setEndDate(end);
            coti_table.column(7).search("").draw();
        });
    </script>

    <script>
        function exportarEgresosConFiltros() {
            // Verificar si hay datos en la tabla
            var table = coti_table; // Asegúrate que esta variable coincida con tu tabla de egresos
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
            var daterange = $('#data_range_filter').val();
            var marca = $('#marcas_filter').val();
            var search = $('#search_all_column').val();

            var url = "{{ route('garantiasE.exportar') }}";
            var params = [];

            if (daterange) {
                params.push('daterange=' + encodeURIComponent(daterange));
            }
            if (marca) {
                params.push('marca=' + encodeURIComponent(marca));
            }
            if (search) {
                params.push('value=' + encodeURIComponent(search));
            }

            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            // Redirigir a la URL de exportación
            window.location.href = url;
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Controlar el checkbox del thead
            $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
                var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
                if (event.type === 'ifChecked') {
                    // Selecciona
                    table.find('tbody input[type="checkbox"]').iCheck('check');
                } else {
                    // Deselecciona
                    table.find('tbody input[type="checkbox"]').iCheck('uncheck');
                }
            });

           // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
            $('tbody input[type="checkbox"]').on('ifChanged', function(event) {
                var table = $(this).closest('table'); // Limita el control a la tabla visible

                var totalCheckboxes = table.find('tbody input[type="checkbox"]').length;
                var checkedCheckboxes = table.find('tbody input[type="checkbox"]').filter(':checked').length;

                if (totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes) {
                    table.find('thead input[type="checkbox"]').iCheck('check');
                } else if (checkedCheckboxes === 0) {
                    // Solo desmarcar el master si no hay elementos seleccionados
                    table.find('thead input[type="checkbox"]').iCheck('uncheck');
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

    <script>
        $(document).ready(function() {
            $('#bnt-imprimir').on('click', function(e) {
                e.preventDefault();

                var selectedIds = [];

                $('input[name="select_row"]:checked').each(function() {
                    var value = $(this).val();
                    if (value && value !== '') {
                        selectedIds.push(value);
                    }
                });

                if (selectedIds.length === 0) {
                    $('.dataTables-egreso tbody input[type="checkbox"]').each(function() {
                        if ($(this).is(':checked') || $(this).parent().hasClass('checked')) {
                            var value = $(this).val();
                            if (value && value !== '') {
                                selectedIds.push(value);
                            }
                        }
                    });
                }

                if (selectedIds.length === 0) {
                    swal({
                        title: "Sin selección",
                        text: "Por favor, selecciona al menos una guía de egreso para imprimir.",
                        type: "warning",
                        confirmButtonText: "Entendido"
                    });
                    return;
                }

                swal({
                    title: "Confirmar impresión",
                    text: `¿Deseas imprimir ${selectedIds.length} guía(s) de egreso seleccionada(s)?`,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Sí, imprimir",
                    cancelButtonText: "Cancelar"
                }, function(isConfirm) {
                    if (isConfirm) {
                        var url = '{{ route("garantiaGuiaE.print.multiple") }}';
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
