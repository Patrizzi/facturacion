@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Boleta Electronica')
@section('content')


    <!-- Modal para BOLETA MANUAL  -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="exampleModal2">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviando Boletas a Sunat</h5>
                </div>
                <div class="modal-body">
                    <div id="msg_bole_el_man">
                        {{-- Contenido del ajax --}}
                    </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <div class="row">
                        <div class="col-sm-6">
                            *En caso de algún error al enviar la Factura, por favor comunicarse de manera inmediata.
                        </div>
                        <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                            <button type="button" class="btn btn-primary" id="cerrar_modal2">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @include('facturacion_electronica.boleta.stadistics')
            </div>
        </div>
    </div>
    {{-- Base para agregar el tab para el los contenidos --}}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist"
                                    style="align-items: center;border-bottom: 0px !important;">
                                    @include('facturacion_electronica.boleta.shared.tabs')
                                    <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;margin-right: 15px">
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
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
                            <div role="tabpanel" id="tab-7" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                <div class="search-responsive">
                                    <div class="row">
                                        <div class="col-lg-12" id="alert_boleta">

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                <input class="form-control" type="text" name="daterange-boleta_m"
                                                    value="" readonly />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="revert_select()">
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
                                            <button class="btn btn-primary  btn-block">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped table-bordered dataTables-boleta_m">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-boletas-head"
                                                        name="input_boletas[]"></th>
                                                <th>Item</th>
                                                <th>Código de Boleta</th>
                                                <th>Cliente</th>
                                                <th>N° de Documento</th>
                                                <th>Fecha de Creación</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;"
                                                    class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1">
                                                    @can('boleta.emitir')
                                                        <img src="{{ asset('sunat.png') }}"
                                                            width="15px">SUNAT
                                                    @endcan
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($boletas_m as $index => $boleta)
                                                <tr @if ($boleta->diff_day > 3) style="color: red" @endif>
                                                    <td><input type="checkbox" class="i-checks-boletas"
                                                            name="input_boleta[]" value="{{ $boleta->codigo_boleta }}">
                                                    </td>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $boleta->codigo_boleta }}</td>
                                                    @if (isset($boleta->cliente_id))
                                                        <!-- Nombre del cliente -->
                                                        <td>{{ $boleta->cliente->nombre }}</td>
                                                        <td>{{ $boleta->cliente->numero_documento }}</td>
                                                    @else
                                                        <td>{{ $boleta->cotizacion->cliente->nombre }}</td>
                                                        <td>{{ $boleta->cotizacion->cliente->numero_documento }}</td>
                                                    @endif
                                                    <td>{{ $boleta->fecha_emision }}</td>
                                                    <td style="text-align: center">
                                                        @can('boleta.emitir')
                                                            <button type="button"
                                                                class="btn btn-success btn-ls"
                                                                value="{{ $boleta->codigo_boleta }}"
                                                                onclick="envio_boleta_m(this)"><i
                                                                    class="fa fa-cloud-upload"></i></button>
                                                        @endcan    
                                                        </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @can('boleta.emitir')
                                            <tfoot>
                                                <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                <td align="center"><button type="button" class="btn btn-primary"
                                                        id="boleta_elec_all_m">Enviar</button></td>
                                            </tfoot>
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
    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>


    <!-- Seleccionar todos los check -->
    <script>
        $(document).ready(function() {

            $('#index_boleta_m').addClass('active');

            $('.i-checks-boletas').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('.i-checks-boletas-head').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // {{-- Datatable Facturas --}}
            table_boleta_m = $('.dataTables-boleta_m').DataTable({
                pageLength: 12,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'ExampleFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

            });

            $('input[name="daterange-boleta_m"]').daterangepicker({

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
                    table_boleta_m.column(5).search(dateRangeString, true, false).draw();
                }
            );
        });
        // Factuas Manuales
        function limpiar_select() {
            table_boleta_m.column(5).search("").draw();
        }

        function revert_select() {
            table_boleta_m.column(5).search(`{{ date('m-Y') }}`).draw();
        }
    </script>
    <script>
        // CHECKS FACTURAS
        $('thead input[class="i-checks-boletas-head"]').on('ifChecked ifUnchecked', function(event) {
            var table = $(this).closest('table');
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input.i-checks-boletas').not(':disabled').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input.i-checks-boletas').not(':disabled').iCheck('uncheck');
            }
        });

        $('tbody input.i-checks-boletas').on('ifChanged', function(event) {
            if ($(this).prop('disabled')) {
                return; // Si el checkbox está deshabilitado, no hace nada
            }

            var table = $(this).closest('table'); // Limita el control a la tabla visible

            var checkboxesHabilitados = table.find('tbody input.i-checks-boletas').not(':disabled');
            var checkboxesMarcados = checkboxesHabilitados.filter(':checked');

            // Si todos los checkboxes habilitados están marcados, marcar el de <thead>
            if (checkboxesMarcados.length === checkboxesHabilitados.length) {
                table.find('thead input.i-checks-boletas').iCheck('check');
            } else {
                table.find('thead input.i-checks-boletas').iCheck('uncheck');
            }
        });
    </script>

    <script>
        //BOLETA MANUAL
        function envio_boleta_m(codigo) {
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
            $(codigo).closest('tr').find('input[type="checkbox"]').prop('disabled', 'disabled');
            $(codigo).prop('disabled', 'disabled');
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.boleta_m_e_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_bol': value_check,
                },
                success: function(response) {
                    var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                    var result = salt.substr(0, 13);
                    // console.log(result);
                    if (result == "Codigo Error:") {
                        var data = `
                            <div id="alert_one_boleta" class="alert alert-danger">
                                <button class="close close_mini" id="cerrar_solo">&times;</button>
                                <span class="alert-link" id="` + value_check + `">Error N°  ` + value_check +
                            ' <br> ' +
                            response + `</span>
                            </div>
                    `;
                    } else {
                        var data = `
                            <div id="alert_one_boleta" class=" alert alert-success" >
                                <button class="close close_mini" id="cerrar_solo">&times;</button>
                                <span class="alert-link clos_mini" id="` + value_check + `">` + response + `</span>
                            </div>
                        `;
                    }
                    $('#alert_boleta').append(data);
                    revision(value_check, response, 'boleta');
                    $('#cerrar_solo').on('click', function() {
                        location.reload();
                    });
                }
            });
        }

        function submit_boleta_click_manual(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('input[class=case2]:checkbox:checked')[repetir].value;
                $.ajax({
                    type: "post",
                    url: "{{ route('facturacion_electronica.boleta_m_e_all') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'codigo_bol': value_check,
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
                            </div>
                        `;
                        } else {
                            var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#" id="` + value_check + `">` + response + `</a>
                            </div>
                        `;
                        }
                        revision(value_check, response, 'boleta_manual');
                        $('#msg_bole_el_man').append(data);
                        repetir++;
                        submit_boleta_click_manual(repetir, maximo);
                    }
                });
                $('#exampleModal2').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }
        $('#boleta_elec_all_m').on('click', function() {
            var cant_checks = $('input[class=i-checks-boletas]:checkbox:checked').length;
            if (cant_checks != 0) {
                // $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                submit_boleta_click_manual(0, cant_checks);
            }

        });
        
        $('#cerrar_modal2').on('click', function() {
            location.reload();
        });

        function revision(codigo, msg, tipo) {
            console.log('a');
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.validacion_sunat_boleta') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tipo': tipo,
                    'codigo_bol': codigo,
                    'msg': msg,
                },
                success: function(response) {
                    var data2 = `<p style="margin-bottom: 0px">` + response + `</p>`
                    $(`#` + codigo + ``).append(data2);
                }
            });
        }
    </script>
@endsection
