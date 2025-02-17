@extends('layout')
@section('title', 'Facturacion Electronica')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @include('facturacion_electronica.factura.stadistics')
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            {{-- CONTENIDO DE TABS --}}
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                    @include('facturacion_electronica.factura.shared.tabs')
                                    <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;margin-right: 15px">
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle">
                                                <i class="fa fa-download"></i></button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">XML</a></li>
                                                <li><a class="dropdown-item" href="#">CDR</a></li>
                                                <li class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="download_pdf_select()">PDF</a></li>
                                            </ul>
                                        </div>
                                    </ul>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-5" class="tab-pane active show">
                                <div class="panel-body ">
                                    <div class="row">
                                        <div class="col-lg-12" id="alert_factura">

                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                <input class="form-control" type="text" name="dateranger_factura"
                                                    value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="revert_select_factura()">
                                                        <i class="fa fa-history"></i>
                                                    </button>
                                                </span>
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="limpiar_select_factura()">
                                                        <i class="fa fa-eraser"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-5 ">
                                            <div class="input-group">
                                                <label for="inputBuscar"
                                                    class="col-lg-2 col-form-label "><strong>Buscar:</strong></label>
                                                <input type="text" id="inputBuscar" class="form-control"
                                                    aria-describedby="passwordHelpInline">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary  btn-block">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  -->
                                    <table class="table table-striped dataTables-detraccion">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-detraccion"
                                                        name="input_detraccion[]"></th>
                                                <th>ID</th>
                                                <th>N° de Doc</th>
                                                <th>Tipo</th>
                                                <th>Fecha de Emisión</th>
                                                <th>Monto total</th>
                                                <th>Monto Detracción</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 150px !important;"
                                                    class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1"
                                                    aria-label="SUNAT: activate to sort column ascending"><img
                                                        src="{{ asset('sunat.png') }}" width="15px">SUNAT
                                                </th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detraccion_facturas as $fact_det)
                                                <tr>
                                                    <td><input type="checkbox" class="i-checks-detraccion" name="input[]"
                                                            value="{{ $fact_det->codigo_fac }}"></td>
                                                    @if ($fact_det->factura_id != null)
                                                        <td>{{ $fact_det->id }}</td>
                                                        <td>{{ $fact_det->factura->codigo_fac }}</td>
                                                        <td>Factura</td>
                                                        <td>{{ Carbon\Carbon::parse($fact_det->factura->fecha_emision)->format('d-m-Y') }}
                                                        </td>
                                                        <td>{{ $fact_det->factura->moneda->simbolo }}
                                                            {{ $fact_det->monto_total_factura }} </td>
                                                        <td>S/. {{ $fact_det->monto_detraccion }}</td>
                                                        <td style="text-align: center;" class="tooltip-demo">
                                                            @if ($fact_det->factura->f_electronica == 1)
                                                                <button type="button"
                                                                    class="btn btn-info btn-circle btn-ls"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Aceptada"><i
                                                                        class="fa fa-check-circle"></i></button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-danger btn-circle btn-ls"><i
                                                                        class="fa fa-times-circle" data-toggle="tooltip"
                                                                        data-placement="top" title="Anulada"></i></button>
                                                            @endif
                                                            @if ($fact_det->factura->nota_credito != 0)
                                                                @if ($fact_det->factura->nota_credito == 1)
                                                                    <button class="btn btn-info btn-circle btn-ls"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Nota de Credito:  Aceptada"><i
                                                                            style="font-weight: 700">NC</i></button>
                                                                @else
                                                                    <button class="btn btn-warning btn-circle btn-ls "
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Nota de Credito: En  Espera"><i
                                                                            style="font-weight: 700">NC</i></button>
                                                                @endif
                                                            @endif
                                                            @if ($fact_det->factura->nota_debito != 0)
                                                                @if ($fact_det->factura->nota_debito == 1)
                                                                    <button class="btn btn-info btn-circle btn-ls "
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Nota de Debito:  Aceptada"><i
                                                                            style="font-weight: 700">ND</i></button>
                                                                @else
                                                                    <button class="btn btn-warning btn-circle btn-ls "
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Nota de Debito: En Espera"><i
                                                                            style="font-weight: 700">ND</i></button>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td align="center" class="tooltip-demo">
                                                            <form class="btn"
                                                                action="{{ route('pdf_fac', $fact_det->factura->id) }}"
                                                                method="GET">
                                                                @csrf
                                                                <input type="hidden" name="name" maxlength="50"
                                                                    value="{{ $fact_det->factura->codigo_fac }}">
                                                                <button type="submit"
                                                                    class="btn btn-link p-0 border-0 bg-transparent"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Descargar PDF">
                                                                    <img src="{{ asset('pdf/icon.png') }}" width="30px"
                                                                        alt="Descargar PDF">
                                                                </button>
                                                            </form>
                                                            <span style="margin-right: 20px !important"></span>
                                                            <a href="{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-01-{{ $fact_det->factura->codigo_fac }}.xml"
                                                                download><img src="{{ asset('xml.png') }}"
                                                                    width="30px"></a>
                                                            <span style="margin-right: 20px !important"></span>
                                                            <a href="{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-01-{{ $fact_det->factura->codigo_fac }}.zip"
                                                                download><img src="{{ asset('zip.png') }}"
                                                                    width="25px"></a>
                                                        </td>
                                                    @else
                                                        <td>{{ $fact_det->id }}</td>
                                                        <td>{{ $fact_det->factura_m->codigo_fac }}</td>
                                                        <td>Factura M.</td>
                                                        <td>{{ Carbon\Carbon::parse($fact_det->factura_m->fecha_emision)->format('d-m-Y') }}
                                                        </td>
                                                        <td>{{ $fact_det->factura_m->moneda->simbolo }}
                                                            {{ $fact_det->monto_total_factura }}</td>
                                                        <td>S/. {{ $fact_det->monto_detraccion }}</td>
                                                        <td style="text-align: center" class="tooltip-demo">
                                                            @if ($fact_det->factura_m->f_electronica == 1)
                                                                <button type="button"
                                                                    class="btn btn-info btn-circle btn-ls"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Aceptada"><i
                                                                        class="fa fa-check-circle"></i></button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-danger btn-circle btn-ls"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Anulada"><i
                                                                        class="fa fa-times-circle"></i></button>
                                                            @endif
                                                            @if ($fact_det->factura_m->nota_credito != 0)
                                                                @if ($fact_det->factura_m->nota_credito == 1)
                                                                    <button class="btn btn-info btn-circle btn-ls"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Nota de Credito:  Aceptada"><i
                                                                            style="font-weight: 700">NC</i></button>
                                                                @else
                                                                    <button class="btn btn-warning btn-circle btn-ls "
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Nota de Credito: En  Espera"><i
                                                                            style="font-weight: 700">NC</i></button>
                                                                @endif
                                                            @endif
                                                            @if ($fact_det->factura_m->nota_debito != 0)
                                                                @if ($fact_det->factura_m->nota_debito == 1)
                                                                    <button class="btn btn-info btn-circle btn-ls "
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Nota de Debito:  Aceptada"><i
                                                                            style="font-weight: 700">ND</i></button>
                                                                @else
                                                                    <button class="btn btn-warning btn-circle btn-ls "
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Nota de Debito: En Espera"><i
                                                                            style="font-weight: 700">ND</i></button>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td align="center">
                                                            <form class="btn"
                                                                action="{{ route('pdf_fac', $fact_det->factura_m->id) }}"
                                                                method="GET">
                                                                @csrf
                                                                <input type="hidden" name="name" maxlength="50"
                                                                    value="{{ $fact_det->factura_m->codigo_fac }}">
                                                                <button type="submit"
                                                                    class="btn btn-link p-0 border-0 bg-transparent"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Descargar PDF">
                                                                    <img src="{{ asset('pdf/icon.png') }}" width="30px"
                                                                        alt="Descargar PDF">
                                                                </button>
                                                            </form>
                                                            <span style="margin-right: 20px !important"></span>
                                                            <a href="{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-01-{{ $fact_det->factura_m->codigo_fac }}.xml"
                                                                download><img src="{{ asset('xml.png') }}"
                                                                    width="30px"></a>
                                                            <span style="margin-right: 20px !important"></span>
                                                            <a href="{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-01-{{ $fact_det->factura_m->codigo_fac }}.zip"
                                                                download><img src="{{ asset('cdr.png') }}"
                                                                    width="25px"></a>
                                                        </td>
                                                    @endif
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
        </div>
    </div>

    <style>
        .model-footer {
            > :not(:last-child) {
                margin-right: .0rem;
            }
        }

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

        #alert_one_factura {
            margin-bottom: 0px !important;
        }

        form.btn {
            padding: 0px 0px;
        }
    </style>

    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>

    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#tab_factura_detraccion').addClass('active');

            $('.i-checks-detraccion').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            // {{-- Datatable Facturas --}}
            table_factura = $('.dataTables-detraccion').DataTable({
                pageLength: 15,
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [],
                aoColumnDefs: [{
                    'bSortable': false,
                    'aTargets': [0]
                }]
            });
            $('input[name="dateranger_factura"]').daterangepicker({

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
                    table_factura.column(5).search(dateRangeString, true, false).draw();
                }
            );
        });

        // Detraccion 
        function limpiar_select_detraccion() {
            table_detraccion.column(4).search("").draw();
        }

        function revert_select_detraccion() {
            table_detraccion.column(4).search(`{{ date('m-Y') }}`).draw();
        }
        $('thead input[class="i-checks-detraccion"]').on('ifChecked ifUnchecked', function(event) {
            var table = $(this).closest('table');
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input.i-checks-detraccion').not(':disabled').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input.i-checks-detraccion').not(':disabled').iCheck('uncheck');
            }
        });

        $('tbody input.i-checks-detraccion').on('ifChanged', function(event) {
            if ($(this).prop('disabled')) {
                return; // Si el checkbox está deshabilitado, no hace nada
            }

            var table = $(this).closest('table'); // Limita el control a la tabla visible

            var checkboxesHabilitados = table.find('tbody input.i-checks-detraccion').not(':disabled');
            var checkboxesMarcados = checkboxesHabilitados.filter(':checked');

            // Si todos los checkboxes habilitados están marcados, marcar el de <thead>
            if (checkboxesMarcados.length === checkboxesHabilitados.length) {
                table.find('thead input.i-checks-detraccion').iCheck('check');
            } else {
                table.find('thead input.i-checks-detraccion').iCheck('uncheck');
            }
        });
    </script>
@endsection
