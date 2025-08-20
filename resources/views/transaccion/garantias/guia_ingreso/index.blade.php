@extends('layout')

@section('title', 'Guias Ingreso')
@section('breadcrumb', 'Guia de ingreso')
@section('breadcrumb2', 'Garantia')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
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
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                @include('transaccion.garantias._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <a class="btn btn-sm btn-success" id="create_guia_ingreso"><i class="fa fa-plus"></i></a>
                                    <button onclick="exportarConFiltros()" class="btn btn-sm btn-success" title="Exportar a Excel">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
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
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="" id="egresado_filter" class="form-control">
                                                    <option value="">Todos</option>
                                                    <option value="1">Egresados</option>
                                                    <option value="0">Sin Egresar</option>
                                                    <option value="3">Anulado</option>
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
                                    <!-- CONTENIDO DENTRO DEL TAB  1-->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-guia-ingreso">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <th>ID</th>
                                                    <th>Orden Servicio</th>
                                                    <th>Motivo</th>
                                                    <th>Asuntos</th>
                                                    <th>Cliente</th>
                                                    <th>Marca</th>
                                                    <th>Fecha</th>
                                                    <th>Ver</th>
                                                    <th>Acciones</th>
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

        <!-- Agregar -->
        <div id="modal-form" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 b-r">
                                <h3 class="m-t-none m-b">Agregar</h3>
                                <p>Selecciona marca a agregar</p>
                                <form action="{{ route('garantia_guia_ingreso.create') }}" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Marca:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control m-b" name="marca">
                                                    @foreach ($marcas as $marca)
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                        type="submit"><strong>Grabar</strong></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-anular" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row" align="center">
                            <div class="col-sm-12 b-r">
                                <h3 class="m-t-none m-b">¿Seguro que desea anular la guia <strong><span
                                            id="valor_ind"></span></strong>?</h3>
                                <p>Esta guia se anulara inmediatamente. Esta acción no se puede deshacer</p>
                                <form id="formulario_anular" action=" {{ route('garantia_guia_ingreso.update', ':id') }} "
                                    enctype="multipart/form-data" method="post">
                                    @csrf @method('PATCH')
                                    <center><button type="submit" class="btn btn-w-m btn-danger">Anular</button></center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('transaccion.garantias._shared.js_shared')
    <!-- Seleccionar todos los check -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $('#marcas_filter').select2({
            placeholder: "Filtrar marca",
            allowClear: true,
            width: '100%'
        });
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-1').addClass('active');

        });
        var coti_table = $('.dataTables-guia-ingreso').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_guia_ingreso') }}",
                method: "get",
                data: function(d) {
                    // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                    d.daterange = $('#data_range_filter').val();
                    d.marca = $('#marcas_filter').val();
                    d.egreso = $('#egresado_filter').val();
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
                    // 'width': '5%',
                    'targets': [1],
                },
                {
                    // 'width': '8%',
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
                    'width': '25%',
                    'targets': [5],
                },
                {
                    'targets': [6],
                },
                {
                    'targets': [7],
                },
                {
                    'width': '5%',
                    'targets': [8],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url = '{{ route('garantia_guia_ingreso.show', ':id') }}';
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
                    'width': '5%',
                    'targets': [9], // Configuración para otra columna (como la de acciones)
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        // Generar la URL de forma dinámica usando la función route con un placeholder

                        var concat2 = ``;
                        if (full[10] == 0) { // Si no está egresado
                            if (full[9] == 1) { // Si está activo
                                concat2 +=
                                    `<a data-toggle="modal" class="btn btn-warning btn-circle btn-ls" onclick="anular_guia(` +full[0] + `, '` + full[2] + `')"><i class="fa fa-trash-o" style="color:white;font-size: 110%"></i></a>`;
                            } else { // Si no  está activo
                                concat2 +=
                                    `<button class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle" style="color:white;font-size: 110%"></i></button>`;
                            }
                        } else { // Si está egresado
                            concat2 +=`<button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle" style="color:white;font-size: 110%"></i></button>`;
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
    // Para INGRESOS - Reemplaza la función existente
    function exportarConFiltros() {
        // Verificar si hay datos en la tabla
        var table = coti_table;
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

        var url = "{{ route('garantiasI.exportar') }}";
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

        window.location.href = url;
    }
    </script>
@endsection
