@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Nota de Debito Electronica')
@section('content')



    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @include('facturacion_electronica.nota-debito.stadistics')
            </div>
        </div>
    </div>
    {{-- Base para agregar el tab para el los contenidos --}}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                    @include('facturacion_electronica.nota_credito.shared.tabs')
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
                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-6" class="tab-pane active show">
                                <div class="panel-body ">
                                    <div class="row">
                                        <div class="col-lg-12" id="alert_credito">

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
                                    <table class="table table-striped dataTables-example2">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                <th>Item</th>
                                                <th>Código de NC</th>
                                                <th>Tipo</th>
                                                <th>Cliente</th>
                                                <th>Ruc/DNI</th>
                                                <th>Fecha Emisión</th>
                                                <th style="text-align:center;color: #0073c1"><img
                                                        src="{{ asset('sunat.png') }}" width="25px">SUNAT</th>
                                            </tr>
                                        </thead>
                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                        <tbody>
                                            <span hidden>{{ $i = 1 }}</span>
                                            @foreach ($n_debitos as $nota_d)
                                                <tr>
                                                    <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $nota_d->codigo_n_d }}</td>
                                                    @if ($nota_d->facturacion_id != null)
                                                        <td>Factura</td>
                                                        <td>{{ $nota_d->nota_i_facturacion->cliente->nombre }}</td>
                                                        <td>{{ $nota_d->nota_i_facturacion->cliente->numero_documento }}
                                                        </td>
                                                        <td>{{ $nota_d->nota_i_facturacion->created_at }}</td>
                                                        <td style="text-align: center">
                                                            <form
                                                                action="{{ route('facturacion_electronica.nota_debito') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $nota_d->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-circle btn-ls"><i
                                                                        class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @elseif($nota_d->boleta_id != null)
                                                        <td>Boleta</td>
                                                        <td>{{ $nota_d->nota_i_boleta->cliente->nombre }}</td>
                                                        <td>{{ $nota_d->nota_i_boleta->cliente->numero_documento }}</td>
                                                        <td>{{ $nota_d->nota_i_boleta->created_at }}</td>
                                                        <td style="text-align: center">
                                                            <form
                                                                action="{{ route('facturacion_electronica.nota_debito_bol') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $nota_d->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-circle btn-ls"><i
                                                                        class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @elseif($nota_d->boleta_m_id != null)
                                                        <td>Boleta Manual</td>
                                                        <td>{{ $nota_d->nota_i_boleta_manual->cliente->nombre }}</td>
                                                        <td>{{ $nota_d->nota_i_boleta_manual->cliente->numero_documento }}
                                                        </td>
                                                        <td>{{ $nota_d->nota_i_boleta_manual->created_at }}</td>
                                                        <td style="text-align: center">
                                                            <form
                                                                action="{{ route('facturacion_electronica.nota_debito_bol') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $nota_d->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-circle btn-ls"><i
                                                                        class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @else
                                                        <td>Factura Manual</td>
                                                        <td>{{ $nota_d->nota_i_fac_manual->cliente->nombre }}</td>
                                                        <td>{{ $nota_d->nota_i_fac_manual->cliente->numero_documento }}
                                                        </td>
                                                        <td>{{ $nota_d->nota_i_fac_manual->created_at }}</td>
                                                        <td style="text-align: center">
                                                            <form
                                                                action="{{ route('facturacion_electronica.nota_debito') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $nota_d->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-circle btn-ls"><i
                                                                        class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfooter>
                                            <td colspan="7" align="right" style="padding-right: 2em"></td>
                                            <td align="center"><button type="button" class="btn btn-primary"
                                                    id="nota_debito_elec_all">Enviar</button></td>
                                        </tfooter>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-7" class="tab-pane">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>

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

    <script>
        $(document).ready(function() {
            $('#tab_debito').addClass('active');
            $('.i-checks-debito').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('.i-checks-debito-head').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
        table_credito = $('.dataTables-example2').DataTable({
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
                table_credito.column(4).search(dateRangeString, true, false).draw();
            }
        );


        function limpiar_select() {
            table_credito.column(4).search("").draw();
        }

        function revert_select() {
            table_credito.column(4).search(`{{ date('m-Y') }}`).draw();
        }
    </script>
    <script>
        // CHECKS 
        $('thead input[class="i-checks-debito-head"]').on('ifChecked ifUnchecked', function(event) {
            var table = $(this).closest('table');
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input.i-checks-debito').not(':disabled').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input.i-checks-debito').not(':disabled').iCheck('uncheck');
            }
        });

        $('tbody input.i-checks-debito').on('ifChanged', function(event) {
            if ($(this).prop('disabled')) {
                return; // Si el checkbox está deshabilitado, no hace nada
            }

            var table = $(this).closest('table'); // Limita el control a la tabla visible

            var checkboxesHabilitados = table.find('tbody input.i-checks-debito').not(':disabled');
            var checkboxesMarcados = checkboxesHabilitados.filter(':checked');

            // Si todos los checkboxes habilitados están marcados, marcar el de <thead>
            if (checkboxesMarcados.length === checkboxesHabilitados.length) {
                table.find('thead input.i-checks-debito').iCheck('check');
            } else {
                table.find('thead input.i-checks-debito').iCheck('uncheck');
            }
        });
    </script>
@endsection
