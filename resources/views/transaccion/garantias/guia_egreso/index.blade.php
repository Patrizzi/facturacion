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
                            <ul class="nav nav-tabs d-flex justify-content-between align-items-center" role="tablist">
                                @include('transaccion.garantias._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <a class="btn btn-success" href="{{ route('garantia_guia_egreso.guias') }}"
                                        id="create_guia_ingreso"><i class="fa fa-plus"></i></a>
                                    <button class="btn btn-success" type="button">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane">
                                    <div class="panel-body">
                                        {{-- CONTENIDO DENTRO DEL TAB  1 --}}
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
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
                                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}
                                                        </option>
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
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                    @foreach ($garantias_guias_egresos as $garantias_guias_egreso)
                                                        <tr>
                                                            <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                            <td>{{ $garantias_guias_egreso->id }}</td>
                                                            <td>{{ $garantias_guias_egreso->orden_servicio }}
                                                            <td>{{ $garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre }}
                                                            <td>{{ $garantias_guias_egreso->garantia_ingreso_i->fecha }}
                                                            </td>
                                                            <td>{{ $garantias_guias_egreso->garantia_ingreso_i->motivo }}
                                                            </td>
                                                            <td>{{ $garantias_guias_egreso->garantia_ingreso_i->asunto }}
                                                            </td>
                                                            <td>{{ $garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre }}
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('garantia_guia_egreso.show', $garantias_guias_egreso->id) }}">
                                                                    <button type="button" class="btn btn-primary"><i
                                                                            class="fa fa-eye"
                                                                            style="color:white;"></i></button></a>

                                                                @if ($garantias_guias_egreso->estado == 1)
                                                                    <button class="btn btn-info"
                                                                        style="border-color: #28a745; background-color:#28a745;">
                                                                        <i class="fa fa-check"
                                                                            style="color:white;"></i></button>
                                                                @else
                                                                    <button type="button" class="btn btn-danger"><i
                                                                            class="fa fa-times"></i></button>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody> --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox ">
                                        <div class="ibox-content">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover dataTables-example" id="table_egreso" >
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Orden servicio</th>
                                                            <th>Marca</th>
                                                            <th>fecha</th>
                                                            <th>Motivo</th>
                                                            <th>Asunto</th>
                                                            <th>Cliente</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            -->
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
                    'render': function(data, type, full, meta) {
                        var informe_tecnico = '';
                        if(full[9] == 1) {
                            informe_tecnico = `<button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle" style="color:white;font-size: 110%"></i></button>`;
                        } else {
                            informe_tecnico = `<button class="btn btn-warning btn-circle btn-ls"><i class="fa fa-exclamation-circle" style="color:white;font-size: 110%"></i></button>`;

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
            coti_table.column(7).search("").draw();
            var start = moment().startOf('month');
            var end = moment().endOf('month');

            // Setear en el input
            $('#daterange').data('daterangepicker').setStartDate(start);
            $('#daterange').data('daterangepicker').setEndDate(end);
        });
    </script>

@endsection
