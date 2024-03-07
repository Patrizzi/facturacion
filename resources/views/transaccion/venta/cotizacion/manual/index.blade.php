@extends('layout')
@section('title', 'Cotizacion Manual')
@section('atributo_actu', 'hidden')
@section('href_accion', route('cotizacion_manual.create'))
@section('value_accion', 'Agregar')
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

    {{-- obtener errores --}}
    @if (Session::has('successMsg'))
        <div style="padding-top: 20px;">
            <div class="alert alert-warning">
                <a class="alert-link" href="#">
                    <li style="color: black">{{ Session::get('successMsg') }}</li>
                </a>
            </div>
        </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                    <input class="form-control" type="text" name="daterange"
                                        value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                                            <i class="fa fa-eraser"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for=""><strong>Tipo de
                                            Cotizacion:</strong></label>
                                    <select class="form-control col-lg-8" name="" id="select_tipo_coti">
                                        <option value="">Todos los comprobantes</option>
                                        <option value="factura">Factura</option>
                                        <option value="boleta">Boleta</option>
                                        <option value="nota_venta">Nota de Venta</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Codigo de Cotizacion</th>
                                        <th>Cliente</th>
                                        <th>N°Documento</th>
                                        <th>Fecha </th>
                                        <th>Importe T.</th>
                                        <th>Ver</th>
                                        <th>Estado</th>
                                        <th style="display: none">Tipo de Cotizacion</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($cotizacion as $cotizaciones)
                                        <tr class="gradeX">
                                            <td>{{ $cotizaciones->id }}</td>
                                            <td>{{ $cotizaciones->cod_cotizacion }}</td>
                                            <td>{{ $cotizaciones->cliente->nombre }}</td>
                                            <td>{{ $cotizaciones->cliente->numero_documento }}</td>
                                            <td>{{ Carbon\Carbon::parse($cotizaciones->fecha_emision)->format('d-m-Y') }}
                                            </td>
                                            <span
                                                hidden>{{ $subtotal = $cotizaciones->op_gravada + $cotizaciones->op_inafecta + $cotizaciones->op_exonerada }}
                                            </span>
                                            <td>{{ $cotizaciones->moneda->simbolo }}
                                                {{ number_format(round($subtotal + ($cotizaciones->op_gravada * $igv->renta) / 100, 2), 2) }}
                                            </td>
                                            {{-- Ver --}}
                                            <td align="center">
                                                <a href="{{ route('cotizacion_manual.show', $cotizaciones->id) }}">
                                                    <button type="button" class="btn btn-success"><i
                                                            class="fa fa-eye"></i></button>
                                                </a>
                                            </td>
                                            <td>
                                                @if ($cotizaciones->estado == '0')
                                                    <button type="button" class="btn btn-w-m btn-info">En Proceso</button>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-w-m btn-default">Procesado</button>
                                                @endif
                                            </td>
                                            <td style="display: none">
                                                {{ $cotizaciones->tipo }}
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
        #DataTables_Table_0_wrapper{
            padding-right: 0px;
        }
        .table{
            width: 100% !important;
        }
        .ibox-content > .row{
            margin: auto;
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

    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 25,
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });

            table.column(4).search(`{{ date('m-Y')}}`).draw();
            
            $(document).on('change', '#select_tipo_coti', function(event) {
                var nombre = $("#select_tipo_coti option:selected").val();
                // console.log(nombre);
                table.column(8).search(nombre).draw();
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
                },
                function(start, end, label) {
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
                    table.column(4).search(dateRangeString, true, false).draw();
                }
            );
        });
        function limpiar_select(){
            table.column(4).search("").draw();
        }
    </script>
@endsection
