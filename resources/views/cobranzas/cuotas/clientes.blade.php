@extends('layout')

@section('title', 'Pagos Solo Facturas')
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-control">
                                    <h2 class="text-center"><strong>Datos Cliente</strong></h2>
                                    <br>
                                    <div style="margin: auto 10px">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><strong>Nombre:</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control">{{ $cliente->nombre }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="col-sm-3 col-form-label"><strong>{{ strtoupper($cliente->documento_identificacion) }}:</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control">{{ $cliente->numero_documento }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><strong>Telefono</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control">{{ $cliente->celular }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><strong>Email:</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control">{{ $cliente->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-control">
                                    <h2 class="text-center"><strong>Informacion General</strong></h2>
                                    <br>
                                    <div style="margin: auto 10px">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="text-center">Contado y Credito</p>
                                                <div class="flot-chart">
                                                    <div class="flot-chart-pie-content" id="flot-pie-chart"></div>
                                                </div>
                                                <p class="text-center small">Todas las Facturas</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <div class="form-group"><label class="small font-weight-bold">Cantidad de Facturas Totales</label>
                                                                <span class="form-control">{{$facturas->count()}}</span></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-group"><label class="small font-weight-bold">Monto Total Soles</label>
                                                                <span class="form-control">{{$moneda_sol->simbolo}} {{number_format(round($tot_sol,2),2)}}</span></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-group"><label class="small font-weight-bold">Facturas sin Pagar</label>
                                                                <span class="form-control">{{$fact_sin->count()}}</span></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-group"><label class="small font-weight-bold">Facturas en el Mes Actual</label>
                                                                <span class="form-control">{{$fact_mes->count()}}</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <div class="form-group"><label class="small font-weight-bold">Facturas Pagadas Totalmente</label>
                                                                <span class="form-control">{{$facturas->where('estado_pago', 2)->count()}}</span></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-group"><label class="small font-weight-bold">Monto Total Dolares</label>
                                                            <span class="form-control">{{$moneda_dol->simbolo}} {{number_format(round($tot_dol,2),2)}}</span></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-group"><label class="small font-weight-bold">Monto sin Pagar</label>
                                                                <span class="form-control">{{$moneda_sol->simbolo}} {{number_format(round($tot_sol_sp,2),2)}}</span></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-group"><label class="small font-weight-bold">Monto de Facturas del Mes ({{$moneda_sol->simbolo}})</label>
                                                                <span class="form-control">{{$moneda_sol->simbolo}} {{number_format(round($tot_sol_m,2),2)}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="ibox-content">
                        <div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group row" style="margin-left: 15px">
                                        <label class="col-sm-3 col-form-label font-weight-bold ">Mes:</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="daterange"
                                                    value="{{ $start_mes }} - {{ $end_mes }}" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="limpiar_select_emision()">
                                                        <i class="fa fa-eraser"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group row" style="margin-left: 15px">
                                        <label class="col-sm-3 col-form-label font-weight-bold ">Tipo:</label>
                                        <div class="col-sm-9">
                                            <div class="input-group" style="align-items: center">
                                                Contado: <input type="checkbox" class="form-control tipo_check"
                                                    name="" id="contad_check">
                                                Credito: <input type="checkbox" class="form-control tipo_check"
                                                    name="" id="credit_check">
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="limpiar_select_estado()" style="visibility: hidden">
                                                        <i class="fa fa-eraser"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group row" style="margin-left: 15px">
                                        <label class="col-sm-3 col-form-label font-weight-bold ">Estado:</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <select class="select2_demo_estado" name="estado" id="estado"
                                                    required="">
                                                    <option value="">Seleccionar Estado</option>
                                                    <option value="Pagado">Pagado</option>
                                                    <option value="Parcial">Pagado parcial</option>
                                                    <option value="Sin">Sin Pagar</option>
                                                </select>
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="limpiar_select_estado()">
                                                        <i class="fa fa-eraser"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example ibox-content">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Factura</th>
                                        <th>Tipo</th> {{-- CONTADO CREDITO --}}
                                        <th style="max-width: 100px">Fecha de Emision</th>
                                        <th>Monto Total</th>
                                        <th style="max-width: 50px;">Estado Pago</th> {{-- Estado de Pago --}}
                                        <th style="text-align:center;color: #0073c1;max-width: 100px;">
                                            <img src="{{ asset('sunat.png') }}" width="25px !important">SUNAT
                                        </th> {{--  Estado Pagado parcial o total  --}}
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($facturas as $fact)
                                        <tr>
                                            <td>{{ $fact->id }}</td>
                                            <td>{{ $fact->codigo_fac }}</td>
                                            <td>{{ $fact->forma_pago->nombre }}</td>
                                            <td>{{ $fact->fecha_emision }}</td>
                                            <td>
                                                @if ($fact->forma_pago_id == 1)
                                                    <span
                                                        hidden>{{ $subtotal = $fact->op_gravada + $fact->op_inafecta + $fact->op_exonerada }}
                                                    </span>
                                                    {{ $fact->moneda->simbolo }}
                                                    {{ number_format(round($subtotal + ($fact->op_gravada * $igv->renta) / 100, 2), 2) }}
                                                @else
                                                    {{ $fact->moneda->simbolo }}
                                                    {{ number_format($cuotas_all->where('facturacion_id', $fact->id)->sum('monto'), 2) }}
                                                @endif
                                            </td>
                                            <td class="td-center">
                                                @if ($cuotas_all->where('facturacion_id', $fact->id)->where('estado', 0)->count() == 0)
                                                    <button id="cancelado" class="btn btn-primary" style="width: 15vh"
                                                        disabled><strong>PAGADO TOTAL</strong></button>
                                                @elseif($cuotas_all->where('facturacion_id', $fact->id)->where('estado', 0)->count() < $cuotas_all->where('facturacion_id', $fact->id)->count())
                                                    <button id="parcial" class="btn btn-warning" style="width: 15vh"
                                                        disabled><strong>PAGO PARCIAL</strong></button>
                                                @else
                                                    <button id="nulo" class="btn btn-danger" style="width: 15vh"
                                                        disabled><strong>SIN PAGO</strong></button>
                                                @endif
                                            </td>
                                            <td class="td-center">
                                                @if ($fact->f_electronica == 1)
                                                    <!-- Nombre del cliente -->
                                                    <button class="btn btn-info btn-circle btn-ls" data-toggle="tooltip"
                                                        data-placement="bottom" title="Aceptada"><i
                                                            class="fa fa-check-circle"></i></button>
                                                    <span hidden>Aceptada</span>
                                                    @if ($fact->nota_credito != 0)
                                                        @if ($nota_credito[$index]->n_electronica == 1)
                                                            <button class="btn btn-info btn-circle btn-ls "
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Nota de Credito:  Aceptada"><i
                                                                    style="font-weight: 700">NC</i></button>
                                                        @else
                                                            <button class="btn btn-warning btn-circle btn-ls "
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Nota de Credito: En Espera"><i
                                                                    style="font-weight: 700">NC</i></button>
                                                        @endif
                                                        <span hidden>Nota de Credito</span>
                                                    @endif
                                                    @if ($fact->nota_debito != 0)
                                                        @if ($nota_debito[$index]->n_electronica == 1)
                                                            <button class="btn btn-info btn-circle btn-ls "
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Nota de Debito:  Aceptada"><i
                                                                    style="font-weight: 700">ND</i></button>
                                                        @else
                                                            <button class="btn btn-warning btn-circle btn-ls "
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Nota de Debito: En Espera"><i
                                                                    style="font-weight: 700">ND</i></button>
                                                        @endif
                                                        <span hidden>Nota de Debito</span>
                                                    @endif
                                                @elseif($fact->f_electronica == 2)
                                                    <button class="btn btn-danger btn-circle btn-ls" data-toggle="tooltip"
                                                        data-placement="bottom" title="Anulada"><i
                                                            class="fa fa-times-circle"></i></button>
                                                    <span hidden>Anulada</span>
                                                @else
                                                    <button class="btn btn-warning btn-circle btn-ls"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="En Espera"><i class="fa fa-check-circle"></i></button>
                                                    <span hidden>En Espera</span>
                                                @endif
                                            </td>
                                            {{-- <td><button class="btn btn-primary">Ver</button></td> --}}
                                            <td>
                                                <a href="{{ route('facturacion.show', $fact->id) }}"
                                                    class="btn btn-primary">Ver</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .td-center {
            text-align: center;
        }

        .estado-sunat {}

        .select2-selection.select2-selection--single {
            height: 100% !important;
        }

        .select2.select2-container.select2-container--default {
            width: calc(100% - 46px) !important;
        }

        .input-group>.select2-container--bootstrap {
            width: auto;
            flex: 1 1 auto;
        }

        .input-group>.select2-container--bootstrap .select2-selection--single {
            height: 100%;
            line-height: inherit;
            padding: 0.5rem 1rem;
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
    </style>
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


    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script>
        $(function() {

            var data = [{
                label: "Contado: " + {{ $facturas->where('forma_pago_id', 1)->count() }},
                data: {{ $facturas->where('forma_pago_id', 1)->count() }},
                color: "#FF6A6A",
            }, {
                label: "Crédito: " + {{ $facturas->where('forma_pago_id', 2)->count() }},
                data: {{ $facturas->where('forma_pago_id', 2)->count() }},
                color: "#6AA2FF",
            }];

            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });

        });

        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });
        $('.select2_demo_estado').select2();

        $(document).on('change', '#estado', function(event) {
            var nombre_2 = $("#estado option:selected").val();
            table.column(5).search(nombre_2).draw();
        });

        function limpiar_select_estado() {
            // console.log('a');
            var table_lp = $('.dataTables-example').DataTable();
            table_lp.column(5).search('').draw();
            $('#estado').val(null).trigger('change');

        }
        $(document).on('change', '#fecha_emi', function(event) {
            var nombre_2 = $("#fecha_emi option:selected").val();
            table.column(3).search(nombre_2).draw();
        });
        $(document).ready(function() {
            $('input[name="daterange"]').daterangepicker({
                    "locale": {
                        "format": "DD-MM-YYYY",
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
                },
                function(start, end, label) {
                    var startDate = start.format('DD-MM-YYYY');
                    var endDate = end.format('DD-MM-YYYY');
                    var dates = [];
                    var currentDate = new Date(start);

                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    console.log(dateRangeString);
                    table.column(3).search(dateRangeString, true, false).draw();
                }
            );
        });

        function limpiar_select_emision() {
            // console.log('a');
            var table_lp = $('.dataTables-example').DataTable();
            table_lp.column(3).search('').draw();
            $('#fecha_emi').val(null).trigger('change');

        }
        $('#contad_check').on('click', function() {
            var count_check = document.querySelectorAll('.tipo_check');
            let checkboxesDesactivados = 0;
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
            });
            if (checkboxesDesactivados == 0 || checkboxesDesactivados == 2) {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(2).search('credito|contado', true, false).draw();
            } else {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(2).search('contado', true, false).draw();
            }


        });
        $('#credit_check').on('click', function() {
            var count_check = document.querySelectorAll('.tipo_check');
            let checkboxesDesactivados = 0;

            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
            });
            if (checkboxesDesactivados == 0 || checkboxesDesactivados == 2) {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(2).search('credito|contado', true, false).draw();
            } else {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(2).search('credito', true, false).draw();
            }
        });
    </script>
@endsection
