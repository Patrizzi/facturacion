@extends('layout')

@section('title', 'Cobros')
@section('content')


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-control">
                                    <h1>INFO DE EMPRESA</h1>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-control">
                                    <h1>ESTADISTICAS DE FACTURAS</h1>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group row" style="margin-left: 15px">
                                        <label class="col-sm-3 col-form-label font-weight-bold ">Mes:</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="daterange"
                                                    value="{{$start_mes}} - {{$end_mes}}" />
                                                {{-- <input type="date" class="form-control" name="" id="fecha_emi">
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="limpiar_select_emision()">
                                                        <i class="fa fa-eraser"></i>
                                                    </button>
                                                </span> --}}
                                            </div>
                                        </div>
                                        <label class="col-sm-3 col-form-label font-weight-bold ">Año</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <select class="form-control" name="" id=""></select>
                                                {{-- <input type="date" class="form-control" name="" id="fecha_emi">
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="limpiar_select_emision()">
                                                        <i class="fa fa-eraser"></i>
                                                    </button>
                                                </span> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
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
                                <div class="col-sm-4">

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
                                            <td>{{ $fact->moneda->simbolo }}
                                                {{ number_format($cuotas_all->where('facturacion_id', $fact->id)->sum('monto'), 2) }}
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
                                                    <button class="btn btn-warning btn-circle btn-ls" data-toggle="tooltip"
                                                        data-placement="bottom" title="En Espera"><i
                                                            class="fa fa-check-circle"></i></button>
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

        .select2.select2-container.select2-container--default {
            /* width: 100% !important; */
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


    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script>
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

        function limpiar_select_emision() {
            // console.log('a');
            var table_lp = $('.dataTables-example').DataTable();
            table_lp.column(3).search('').draw();
            $('#fecha_emi').val(null).trigger('change');

        }
        $(document).ready(function() {
            $('input[name="daterange"]').daterangepicker({
                    "locale": {
                        "format": "DD-MM-YYYY",
                        "separator": " - ",
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
                    let startDate = start.format("DD-MM-YYYY").toString();
                    let endDate = end.format("DD-MM-YYYY").toString();

                    console.log(startDate);
                    console.log(endDate);
                    table.column(3).search(startDate).draw();
                    // document.getElementById("startDate").innerHTML =
                    //     "Start date: " + startDate;
                    // document.getElementById("endDate").innerHTML = "End date: " + endDate;

                }
            );
        });
    </script>
@endsection
