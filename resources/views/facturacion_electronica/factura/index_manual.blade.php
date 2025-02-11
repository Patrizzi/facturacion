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
                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-7" class="tab-pane active show">
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
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped dataTables-fact_manual">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-facturas"
                                                    name="input_facturas[]"></th>
                                                <th>Item</th>
                                                <th>Código</th>
                                                <th>Cliente</th>
                                                <th>N° Doc</th>
                                                <th>Fecha de Vencimiento</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;"
                                                    class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1"><img src="{{ asset('sunat.png') }}"
                                                        width="15px">SUNAT
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <span hidden>{{ $a = 1 }}</span> --}}
                                            @foreach ($facturas_manual as $index => $facturaciones_m)
                                                <tr @if ($facturaciones_m->diff_day > 3) style="color: red" @endif>
                                                    <td><input type="checkbox" class="i-checks-facturas" name="input[]"
                                                        value="{{ $facturaciones_m->codigo_fac }}"></td>
                                                    <td>{{ $index+1 }}</td>
                                                    <td>{{ $facturaciones_m->codigo_fac }}</td>
                                                    @if (isset($facturaciones_m->cliente_id))
                                                        <!-- Nombre del cliente -->
                                                        <td>{{ $facturaciones_m->cliente->nombre }}</td>
                                                        <td>{{ $facturaciones_m->cliente->numero_documento }}</td>
                                                    @else
                                                        <td>{{ $facturaciones_m->cotizacion->cliente->nombre }}</td>
                                                        <td>{{ $facturaciones_m->cotizacion->cliente->numero_documento }}
                                                        </td>
                                                    @endif
                                                    <td>{{ $facturaciones_m->fecha_vencimiento }}</td>
                                                    <td style="text-align: center"><button type="button"
                                                            class="btn btn-success btn-circle btn-ls factura_ind"
                                                            id="factura_ind" value="{{ $facturaciones_m->codigo_fac }}"
                                                            onclick="envio_factura_manual(this)"><i
                                                                class="fa fa-cloud-upload"></i></button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfooter>
                                            <td colspan="6" align="right" style="padding-right: 2em"></td>
                                            <td align="center"><button type="button" class="btn btn-primary"
                                                    id="fac_m_elec_all">Enviar</button></td>
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
    <style>
        /*.ibox-content{
                                                padding: 0px;
                                                border: none;
                                            }*/
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
            $('#tab_fact_m').addClass('active');
            $('.i-checks-facturas').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            // {{-- Datatable Facturas --}}
            table_factura = $('.dataTables-fact_manual').DataTable({
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
    </script>
    <script>
        //FUNCIONES PARA FACTURA NORMAL
        //FACTURAS INDIVIVUALES
        function inv_close() {
            $(document).ready(function() {
                $("#myAlert").bind('closed.bs.alert', function() {
                    location.reload();
                })
            });
            $('[data-toggle="popover"]').popover();
            const myTimeout = setTimeout(click, 5000);
        }

        function click() {
            console.log("click");
            $('[data-toggle="popover"]').popover();
            $('#cerrar_popup').trigger('click');
        }

        function envio_factura_manual(codigo) {
            console.log(codigo);
            // $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
            console.log(value_check);
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.fac_elec_man_all') }}",
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
                        <div id="myAlert" class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">&times;</a>
                            <span class="alert-link" id="` + value_check + `">Error N°  ` + value_check + ' <br> ' +
                            response + `</span>
                        </div>
                    `;
                    } else {
                        var data = `
                        <div id="myAlert" class=" alert alert-success" >
                            <a id="cerrar_popup" class="close"  data-container="body" data-trigger="click" data-toggle="popover"  data-placement="bottom" data-content="Haga click para cerrar esta notificación." style="color:#d4edda;width: 0">&times;</a>
                            <a class="close" data-dismiss="alert">&times;</a>
                            <span class="alert-link" id="` + value_check + `">` + response + `</span>
                        </div>
                    `;
                    }
                    revision(value_check, response, 'factura_manual');
                    inv_close();
                    $('#msg_individual').append(data);
                    $("#success-alert").show();
                }
            });
        }
        //  FUNCION PARASELECCION MUILTIPLE
        function select_all_fact() {
            $('input[class=case]:checkbox').each(function() {
                // console.log($('input[class=check_all]:checkbox:checked'));
                if ($('input[class=check_all]:checkbox:checked').length == 0) {
                    // console.log("a");
                    $(this).prop("checked", false);
                } else {
                    // console.log("b");
                    $(this).prop("checked", true);
                }
            });
        }
        //Facturas masivas
        function submit_factura_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('input[class=i-checks-facturas]:checkbox:checked')[repetir].value;
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
        //

        //FUNCIONES PARA FACTURA MANUAL
        function select_all_fact_man() {
            $('input[class=case_m]:checkbox').each(function() {
                // console.log($('input[class=check_all]:checkbox:checked'));
                if ($('input[class=check_all_fac_m]:checkbox:checked').length == 0) {
                    // console.log("a");
                    $(this).prop("checked", false);
                } else {
                    // console.log("b");
                    $(this).prop("checked", true);
                }
            });
        }

        function submit_factura_manual_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('input[class=case_m]:checkbox:checked')[repetir].value;
                $.ajax({
                    type: "post",
                    url: "{{ route('facturacion_electronica.fac_elec_man_all') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'codigo_fac': value_check,
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
                        revision(value_check, response, 'factura_manual');
                        $('#msg_c_fac_m').append(data);
                        repetir++;
                        submit_factura_manual_click(repetir, maximo);
                    }
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }
        $('#fac_m_elec_all').on('click', function() {
            var cant_checks = $('input[class=case_m]:checkbox:checked').length;
            console.log(cant_checks)
            // var max_menos = cant_checks -1;
            if (cant_checks == 0) {
                console.log("ninguno marcado");
            } else {
                $('#exampleModalManual').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#exampleModalManual").modal("show");
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                submit_factura_manual_click(0, cant_checks);
            }

        });
        $('#cerrar_factura_m').on('click', function() {
            location.reload();
        });
        // Mensaje para que cierre x

        function download_pdf_select() {
            var checks = $('input[class=i-checks-facturas_env]:checkbox:checked');
            // var checks_all = checks.concat(checks_m, checks_d);
            checks.each(function() {
                var codigo = $(this).val();
                console.log(codigo);
            });

        }
    </script>
@endsection
