@extends('layout')
@section('title', 'Facturacion Electronica')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')

    <!-- Modal para Mesajen  Factura  -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="exampleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviando Facturas a Sunat</h5>
                </div>
                <div class="modal-body">
                    <div id="msg_c_bol">
                        {{-- Contenido del ajax --}}
                    </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <div class="row">
                        <div class="col-sm-6">
                            *En caso de algún error al enviar la Factura, por favor comunicarse de manera inmediata.
                        </div>
                        <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                            <button type="button" class="btn btn-primary" id="cerrar_factura">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                <ul class="nav nav-tabs" role="tablist"
                                    style="align-items: center;border-bottom: 0px !important;">
                                    @include('facturacion_electronica.factura.shared.tabs')
                                    <ul class="ml-auto d-flex"
                                        style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-default  dropdown-toggle">
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
                         <div class="tab-content" style="margin-top: -2px">
                            <div role="tabpanel" id="tab-5" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                <div class="row">
                                    <div class="col-lg-12" id="alert_factura">

                                    </div>
                                </div>
                                <hr style="margin-left: 15px;margin-right: 15px;" />
                                <div class="search-responsive">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                <input class="form-control" type="text" name="dateranger_factura"
                                                    value="" readonly id="daterange-factura" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="revert_select_factura()">
                                                        <i class="fa fa-history"></i>
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
                                            <button class="btn btn-primary btn-block" id="filter_buttons">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <!-- CONTENIDO DENTRO DEL TAB  -->
                                <div class="table-responsive">
                                    <table class="table table-hover dataTables-factura">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-facturas-head"
                                                        name="input_facturas[]"></th>
                                                <th>Item</th>
                                                <th>Código</th>
                                                <th>RUC | DNI</th>
                                                <th>Cliente</th>
                                                <th>Fecha de Creacion</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;"
                                                    class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1">
                                                    @can('factura.emitir')
                                                        <img src="{{ asset('sunat.png') }}"
                                                            width="15px">SUNAT
                                                    @endcan
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($facturacion as $index => $facturaciones)
                                                <tr @if ($facturaciones->diff_day > 3) style="color: red" @endif>
                                                    <td><input type="checkbox" class="i-checks-facturas"
                                                            name="input_factura[]"
                                                            value="{{ $facturaciones->codigo_fac }}">
                                                    </td>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $facturaciones->codigo_fac }}</td>
                                                    @if (isset($facturaciones->cliente_id))
                                                        <td>{{ $facturaciones->cliente->numero_documento }}</td>
                                                        <td>{{ $facturaciones->cliente->nombre }}</td>
                                                    @else
                                                        <td>{{ $facturaciones->cotizacion->cliente->numero_documento }}</td>
                                                        <td>{{ $facturaciones->cotizacion->cliente->nombre }}</td>
                                                    @endif
                                                    <td>
                                                        <span>{{ $facturaciones->fecha_emision }}</span>
                                                    </td>
                                                    <td style="text-align: center">
                                                        @can('factura.emitir')
                                                            <button type="button"
                                                                class="btn btn-success "
                                                                value="{{ $facturaciones->codigo_fac }}"
                                                                onclick="envio_factura(this)">
                                                                <i class="fa fa-cloud-upload"></i>
                                                            </button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @can('factura.emitir')
                                            <tfooter>
                                                <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                <td align="center"><button type="button" class="btn btn-primary"
                                                        id="fac_elec_all">Enviar</button></td>
                                            </tfooter>
                                        @endcan
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
        /* div.dataTables_length {
            display: none;
        }
        div.dataTables_filter {
            display: none;
        }

        div.dt-buttons {
            display: none;
        } */

        #alert_one_factura {
            margin-bottom: 0px !important;
        }

        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        .search-responsive, .table-responsive {
            padding-right: 15px;
            padding-left: 15px;
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
            $('#tab_factura').addClass('active');

            $('.i-checks-facturas').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('.i-checks-facturas-head').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

        // {{-- Datatable Facturas --}}
        var table_factura = $('.dataTables-factura').DataTable({
            info: false,
            pageLength: 15,
            responsive: true
        });
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                
                let range = $('input[name="dateranger_factura"]').val();

                if (!range || range.trim() === '') {
                    return true;
                }

                let dates = range.split(' - ');

                if (dates.length !== 2) {
                    return true;
                }

                let min = moment(dates[0], 'DD/MM/YYYY');
                let max = moment(dates[1], 'DD/MM/YYYY');

                let current = moment(data[5], 'DD/MM/YYYY');

                if (!current.isValid()) {
                    return false;
                }

                return current.isBetween(min, max, undefined, '[]');
            }
        );

        $('input[name="dateranger_factura"]').daterangepicker({
            "locale": {
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
                "firstDay": 1,
                "format": "DD/MM/YYYY"
            }
        });

        $('#filter_buttons').on('click', function() {

            table_factura.draw();

        });

        // Facturas
        function limpiar_select_factura() {
            table_factura.column(5).search("").draw();
        }

        function revert_select_factura() {
            table_factura.column(5).search(`{{ date('m-Y') }}`).draw();
        }
    </script>
    <script>
        // CHECKS FACTURAS
        $('thead input[class="i-checks-facturas-head"]').on('ifChecked ifUnchecked', function(event) {
            var table = $(this).closest('table');
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input.i-checks-facturas').not(':disabled').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input.i-checks-facturas').not(':disabled').iCheck('uncheck');
            }
        });

        $('tbody input.i-checks-facturas').on('ifChanged', function(event) {
            if ($(this).prop('disabled')) {
                return; // Si el checkbox está deshabilitado, no hace nada
            }

            var table = $(this).closest('table'); // Limita el control a la tabla visible

            var checkboxesHabilitados = table.find('tbody input.i-checks-facturas').not(':disabled');
            var checkboxesMarcados = checkboxesHabilitados.filter(':checked');

            // Si todos los checkboxes habilitados están marcados, marcar el de <thead>
            if (checkboxesMarcados.length === checkboxesHabilitados.length) {
                table.find('thead input.i-checks-facturas').iCheck('check');
            } else {
                table.find('thead input.i-checks-facturas').iCheck('uncheck');
            }
        });
    </script>
    <script>
        // ENVIO DE FACTURA INDIVIDUAL
        function envio_factura(codigo) {
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
            $(codigo).closest('tr').find('input[type="checkbox"]').prop('disabled', 'disabled');
            $(codigo).prop('disabled', 'disabled');
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.factura_elec_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_fac': value_check,
                },
                success: function(response) {
                    var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                    var result = salt.substr(0, 13);
                    // console.log(result);
                    if (result == "Codigo Error:") {
                        var data = `
                            <div id="alert_one_factura" class="alert alert-danger">
                                <button class="close close_mini" id="cerrar_solo">&times;</button>
                                <span class="alert-link" id="` + value_check + `">Error N°  ` + value_check +
                            ' <br> ' +
                            response + `</span>
                            </div>
                        `;
                    } else {
                        var data = `
                        <div id="alert_one_factura" class=" alert alert-success" >
                            <button class="close close_mini" id="cerrar_solo">&times;</button>
                            <span class="alert-link clos_mini" id="` + value_check + `">` + response + `</span>
                        </div>
                    `;
                    }
                    revision(value_check, response, 'factura');
                    // cerrar_only_send();
                    $('#alert_factura').append(data);
                    $('#cerrar_solo').on('click', function() {
                        location.reload();
                    });
                }
            });
        }
        //Facturas masivas
        function submit_factura_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('tbody input[class=i-checks-facturas]:checkbox:checked')[repetir].value;
                $.ajax({
                    type: "post",
                    url: "{{ route('facturacion_electronica.factura_elec_all') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'codigo_fac': value_check,
                    },
                    success: function(response) {
                        var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                        var result = salt.substr(0, 13);
                        // console.log(result);
                        if (result == "Codigo Error:") {
                            var data = `
                            <div class="alert alert-danger">
                                <a class="alert-link" href="#" id="` + value_check + `">Error N°  ` + value_check +
                                ' <br> ' + response + `</a>
                            </div>`;
                        } else {
                            var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#" id="` + value_check + `">` + response + `</a>
                            </div>`;
                        }
                        revision(value_check, response, 'factura');
                        $('#msg_c_bol').append(data);
                        repetir++;
                        submit_factura_click(repetir, maximo);
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

        $('#fac_elec_all').on('click', function() {
            var cant_checks = $('input[class=i-checks-facturas]:checkbox:checked').length;
            if (cant_checks != 0) {
                // $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                submit_factura_click(0, cant_checks);
            }
        });

        $('#cerrar_factura').on('click', function() {
            location.reload();
        });

        function revision(codigo, msg, tipo) {
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.validacion_sunat') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tipo': tipo,
                    'codigo_fac': codigo,
                    'msg': msg,
                },
                success: function(response) {
                    // console.log(response);
                    var data2 = `<p style="margin-bottom: 0px">` + response + `</p>`
                    $(`#` + codigo + ``).append(data2);
                }
            });
        }
    </script>
@endsection
