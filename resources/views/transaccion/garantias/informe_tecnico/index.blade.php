@extends('layout')

@section('title', 'Guias Informe Tecnico')
@section('breadcrumb', 'Informe Tecnico')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_informe_tecnico.guias'))
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
        <!--Base para agregar el tab para el los contenidos-->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs d-flex justify-content-between align-items-center" role="tablist">
                                @include('transaccion.garantias._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <a class="btn btn-sm btn-success" href="{{ route('garantia_informe_tecnico.guias') }}"
                                        id="create_guia_ingreso"><i class="fa fa-plus"></i></a>
                                    <button type="button" id="bnt-imprimir" class="btn btn-sm btn-success" title="Imprimir">
                                        <i class="fa fa-download"></i>
                                    </button>
                                    <button type="button" id="btn-exportar-filtrado" class="btn btn-sm btn-success" title="Exportar a Excel">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="tab-3" class="tab-pane active show">
                                    <br>
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
                                                <select class="form-control select2" name="marcas_filter"
                                                    id="marcas_filter">
                                                    <option value=""></option>
                                                    @foreach ($marcas as $marca)
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                                    @endforeach
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
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-informe_tecnico">
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

    @include('transaccion.garantias._shared.js_shared')

    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Seleccionar todos los check -->
    <script>
        $('#marcas_filter').select2({
            placeholder: "Selecciona una marca",
            allowClear: true,
            width: '100%'
        });
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-3').addClass('active');

        });
        var coti_table = $('.dataTables-informe_tecnico').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_guia_informe_tecnico') }}",
                method: "get",
                data: function(d) {
                    // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                    d.daterange = $('#data_range_filter').val();
                    d.marca = $('#marcas_filter').val();
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
                    'width': '8%',
                    'targets': [2],
                },
                {
                    'width': '8%',
                    'targets': [3],
                },
                {
                    'width': '10%',
                    'targets': [4],
                },
                {
                    // 'width': '25%',
                    'targets': [5],
                },
                {
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
                        var url = '{{ route('garantia_informe_tecnico.show', ':id') }}';
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
                    'targets': [9], // Configuración para otra columna (como la de acciones)
                    'width': '5%',
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        // Generar la URL de forma dinámica usando la función route con un placeholder

                        var concat2 = ``;
                        if (full[10] == 0) { // Si no está egresado
                            if (full[9] == 1) { // Si está activo
                                concat2 +=
                                    `<a data-toggle="modal" class="btn btn-warning btn-circle btn-ls" onclick="anular_guia(` +
                                    full[0] + `, '` + full[2] +
                                    `')"><i class="fa fa-trash-o" style="color:white;font-size: 110%"></i></a>`;
                            } else { // Si no  está activo
                                concat2 +=
                                    `<button class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle" style="color:white;font-size: 110%"></i></button>`;
                            }
                        } else { // Si está egresado
                            concat2 +=
                                `<button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle" style="color:white;font-size: 110%"></i></button>`;
                        }

                        return concat2;
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
    $(document).ready(function() {
        // Manejar click del botón de exportar
        $(document).on('click', '#btn-exportar-filtrado', function(e) {
            e.preventDefault();

            // Obtener los valores actuales de los filtros (exactamente como en tu DataTable)
            var daterange = $('#data_range_filter').val();
            var value = $('#search_all_column').val(); // Cambiado de 'search' a 'value'
            var tipo_coti = $('#select_tipo_coti').val();

            // Construir la URL con parámetros
            var exportUrl = "{{ route('export.garantia_informe_tecnico') }}";
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
                if (table.find('tbody input[type="checkbox"]').filter(':checked').length === table.find(
                        'tbody input[type="checkbox"]').length) {
                    table.find('thead input[type="checkbox"]').iCheck('check');
                } else {
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

            // Primero intenta obtener de checkboxes normales
            $('input[name="select_row"]:checked').each(function() {
                var value = $(this).val();
                if (value && value !== '') {
                    selectedIds.push(value);
                }
            });

            // Si no hay seleccionados, intenta con iCheck
            if (selectedIds.length === 0) {
                $('.dataTables-informe_tecnico tbody input[type="checkbox"]').each(function() {
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
                    text: "Por favor, selecciona al menos un informe técnico para imprimir.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            // Confirmar acción
            swal({
                title: "Confirmar impresión",
                text: `¿Deseas imprimir ${selectedIds.length} informe(s) técnico(s) seleccionado(s)?`,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, imprimir",
                cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (isConfirm) {
                    // Construir URL con parámetros GET
                    var url = '{{ route("informeTecnico.print.multiple") }}';
                    var params = new URLSearchParams();

                    selectedIds.forEach(function(id) {
                        params.append('informe_ids[]', id);
                    });

                    // Abrir nueva pestaña para impresión
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
                        text: "Los informes técnicos se están imprimiendo...",
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
