@extends('layout')

@section('title', 'Comprobantes | Guia de Remision Manual')

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
                                    <a class="btn btn-success" href="{{ route('guia_remision_manual.create') }}"><i
                                            class="fa fa-plus"></i></a>
                                    <button class="btn btn-success" type="button">
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
    @include('transaccion\comprobantes\_shared\js_shared')
    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE COTIZACION"
            $('#tab-8-tab').addClass('active');
        });
        var coti_table = $('.dataTables-example-guia-remision').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('comprobantes.guiaRemisionM_registers') }}",
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
                        return '<input type="checkbox" name="select_row" value="' + full[2] +
                            '" class="i-checks-boleta">';
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
                        var url = '{{ route('guia_remision_manual.show', ':id') }}';
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
@endsection
