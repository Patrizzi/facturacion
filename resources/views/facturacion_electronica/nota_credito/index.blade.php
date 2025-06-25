@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Nota de credito Electronica')
@section('content')

    <!-- Modal para Guia de Remision  -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="exampleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviando Nota de Credito a Sunat</h5>
                </div>
                <div class="modal-body">
                    <div id="msg_nota_credito_el">
                        {{-- Contenido del ajax --}}
                    </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <div class="row">
                        <div class="col-sm-6">
                            *En caso de algún error al enviar la Nota de Credito, por favor comunicarse de manera inmediata.
                        </div>
                        <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                            <button type="button" class="btn btn-primary" id="cerrar_modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @include('facturacion_electronica.nota_credito.stadistics')
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
                                            @if (Session::has('successMsg'))
                                                <div class="alert alert-success">
                                                    <a class="alert-link" href="#">{{ session('successMsg') }}</a>.
                                                </div>
                                            @endif

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
                                                <th><input type="checkbox" class="i-checks-credito-head"
                                                        name="input_credito[]"></th>
                                                <th>Item</th>
                                                <th>Código de NC</th>
                                                <th>Tipo</th>
                                                <th>N° de Doc. Asoc.</th>
                                                <th>Ruc/DNI</th>
                                                <th>Cliente</th>
                                                <th>Fecha Emisión</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;"
                                                    class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1"><img src="{{ asset('sunat.png') }}"
                                                        width="15px">SUNAT
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($n_creditos as $index => $n_credito)
                                                <tr>
                                                    <td><input type="checkbox" class="i-checks-credito" name="input[]"
                                                            value="{{ $n_credito->codigo_n_c }}"></td>
                                                    <td>{{ $index + 1 }}</td>
                                                    @if ($n_credito->facturacion_id != null)
                                                        <td>{{ $n_credito->codigo_n_c }}</td>
                                                        <td>Factura</td>
                                                        <td><a class="link_tds" target="_blank"
                                                                href="{{ route('facturacion.show', $n_credito->nota_i_facturacion->id) }}">{{ $n_credito->nota_i_facturacion->codigo_fac }}</a>
                                                        </td>
                                                        <td>{{ $n_credito->nota_i_facturacion->cliente->nombre }}</td>
                                                        <td>{{ $n_credito->nota_i_facturacion->cliente->numero_documento }}
                                                        </td>
                                                        <td>{{ $n_credito->nota_i_facturacion->created_at }}</td>
                                                        <td>
                                                            <form
                                                                action="{{ route('facturacion_electronica.nota_credito') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $n_credito->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-circle btn-ls"><i
                                                                        class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @elseif($n_credito->boleta_id != null)
                                                        <td>{{ $n_credito->codigo_n_c }}</td>
                                                        <td>Boleta</td>
                                                        <td><a class="link_tds" target="_blank"
                                                                href="{{ route('boleta.show', $n_credito->nota_i_boleta->id) }}">{{ $n_credito->nota_i_boleta->codigo_boleta }}</a>
                                                        </td>
                                                        <td>{{ $n_credito->nota_i_boleta->cliente->numero_documento }}</td>
                                                        <td>{{ $n_credito->nota_i_boleta->cliente->nombre }}</td>
                                                        <td>{{ $n_credito->nota_i_boleta->created_at }}</td>
                                                        <td>
                                                            <form
                                                                action="{{ route('facturacion_electronica.nota_credito_bol') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $n_credito->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-circle btn-ls"><i
                                                                        class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @elseif($n_credito->boleta_m_id != null)
                                                        <td>{{ $n_credito->codigo_n_c }}</td>
                                                        <td>Boleta Manual</td>
                                                        <td><a class="link_tds" target="_blank"
                                                                href="{{ route('boleta_manual.show', $n_credito->nota_i_boleta_manual->id) }}">{{ $n_credito->nota_i_boleta_manual->codigo_boleta }}
                                                        </td>
                                                        <td>{{ $n_credito->nota_i_boleta_manual->cliente->nombre }}</td>
                                                        <td>{{ $n_credito->nota_i_boleta_manual->cliente->numero_documento }}
                                                        </td>
                                                        <td>{{ $n_credito->nota_i_boleta_manual->created_at }}</td>
                                                        <td>
                                                            <form
                                                                action="{{ route('facturacion_electronica.nota_credito_bol') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $n_credito->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-circle btn-ls"><i
                                                                        class="fa fa-cloud-upload"></i></button>
                                                            </form>
                                                        </td>
                                                    @else
                                                        <td>{{ $n_credito->codigo_n_c }}</td>
                                                        <td>Factura Manual</td>
                                                        <td><a class="link_tds" target="_blank"
                                                                href="{{ route('facturacion_manual.show', $n_credito->nota_i_fac_manual->id) }}">{{ $n_credito->nota_i_fac_manual->codigo_fac }}
                                                        </td>
                                                        <td>{{ $n_credito->nota_i_fac_manual->cliente->nombre }}</td>
                                                        <td>{{ $n_credito->nota_i_fac_manual->cliente->numero_documento }}
                                                        </td>
                                                        <td>{{ $n_credito->nota_i_fac_manual->created_at }}</td>
                                                        <td>
                                                            <form
                                                                action="{{ route('facturacion_electronica.nota_credito') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $n_credito->id }}">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-circle btn-ls"><i
                                                                        class="fa fa-cloud-upl , oad"></i></button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfooter>
                                            <td colspan="8" align="right" style="padding-right: 2em"></td>
                                            <td align="center"><button type="button" class="btn btn-primary"
                                                    id="nota_credito_elec_all">Enviar</button></td>
                                        </tfooter>
                                    </table>
                                </div>
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

    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    {{-- ESTILOS --}}
    <style type="text/css">
        .a {
            width: 200px;
        }

        .link_tds {
            color: black !important;
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
    </style>

    <!-- Seleccionar todos los check -->
    <script>
        $(document).ready(function() {
            $('#tab_credito').addClass('active');

            $('.i-checks-credito').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('.i-checks-credito-head').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            // {{-- Datatable Facturas --}}
            table_factura = $('.dataTables-example2').DataTable({
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
            $('input[name="daterange2"]').daterangepicker({

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
                    table2.column(7).search(dateRangeString, true, false).draw();
                }
            );
        });

        function limpiar_select() {
            table2.column(7).search("").draw();
        }

        function revert_select() {
            table2.column(7).search(`{{ date('m-Y') }}`).draw();
        }
    </script>
    <!-- Page Scripts -->
    <script>
        // CHECKS 
        $('thead input[class="i-checks-credito-head"]').on('ifChecked ifUnchecked', function(event) {
            var table = $(this).closest('table');
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input.i-checks-credito').not(':disabled').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input.i-checks-credito').not(':disabled').iCheck('uncheck');
            }
        });

        $('tbody input.i-checks-credito').on('ifChanged', function(event) {
            if ($(this).prop('disabled')) {
                return; // Si el checkbox está deshabilitado, no hace nada
            }

            var table = $(this).closest('table'); // Limita el control a la tabla visible

            var checkboxesHabilitados = table.find('tbody input.i-checks-credito').not(':disabled');
            var checkboxesMarcados = checkboxesHabilitados.filter(':checked');

            // Si todos los checkboxes habilitados están marcados, marcar el de <thead>
            if (checkboxesMarcados.length === checkboxesHabilitados.length) {
                table.find('thead input.i-checks-credito').iCheck('check');
            } else {
                table.find('thead input.i-checks-credito').iCheck('uncheck');
            }
        });

        function submit_nota_credito_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('tbody input[class=i-checks-credito]:checkbox:checked')[repetir].value;
                $.ajax({
                    type: "post",
                    url: "{{ route('facturacion_electronica.nota_credito_all') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'codigo_nota_credito': value_check,
                    },
                    success: function(response) {
                        var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                        var result = salt.substr(0, 13);
                        console.log(result);
                        if (result == "Codigo Error:") {
                            var data = `
                            <div class="alert alert-danger">
                                <a class="alert-link" href="#">Error N°  ` + value_check + ' <br> ' + response + `</a>
                            </div>
                        `;
                        } else {
                            var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#">` + response + `</a>
                            </div>
                        `;
                        }
                        $('#alert_credito').append(data);
                        repetir++;
                        submit_nota_credito_click(repetir, maximo);
                    }
                });
                $('#exampleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }
        $('#nota_credito_elec_all').on('click', function() {
            var cant_checks = $('input[class=i-checks-credito]:checkbox:checked').length;
            if (cant_checks != 0) {
                // $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                submit_nota_credito_click(0, cant_checks);
            }

        });
        $('#cerrar_modal').on('click', function() {
            location.reload();
        });
    </script>
@endsection
