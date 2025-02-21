@extends('layout')

@section('title', 'Guia de remision')
@section('breadcrumb', 'Guia de remision')
@section('breadcrumb2', 'Guia de remision')

@extends('layout_comunicado')
@section('content')
    <span
        hidden="">{{ $i = 1 }}{{ $a = 1 }}{{ $j = 1 }}{{ $x = 1 }}{{ $y = 1 }}{{ $o = 1 }}</span>


    {{--  --}}

    <!-- Modal para Guia de Remision  -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="exampleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviando Guias a Sunat</h5>
                </div>
                <div class="modal-body">
                    <div id="msg_remision_el">
                        {{-- Contenido del ajax --}}
                    </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <div class="row">
                        <div class="col-sm-6">
                            *En caso de algún error al enviar la Guia de Remision, por favor comunicarse de manera
                            inmediata.
                        </div>
                        <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                            <button type="button" class="btn btn-primary" id="cerrar">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para Guia de Remision Manual -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="exampleModal_M">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviando Guias a Sunat</h5>
                </div>
                <div class="modal-body">
                    <div id="msg_remision_el_m">
                        {{-- Contenido del ajax --}}
                    </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <div class="row">
                        <div class="col-sm-6">
                            *En caso de algún error al enviar la Guia de Remision Manual, por favor comunicarse de manera
                            inmediata.
                        </div>
                        <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                            <button type="button" class="btn btn-primary" id="cerrar_m">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ESTILOS --}}
    <style type="text/css">
        .table {
            font-size: 13px;
        }

        .a {
            width: 200px
        }

        /* .ibox-content{
            padding: 0px;
            border: none;
        }*/
        .model-footer {
            > :not(:last-child) {
                margin-right: .0rem;
            }
        }

        .guia_m {
            color: black !important;
            text-decoration: underline !important;
        }

        .guia_remi {
            color: blue !important;
            text-decoration: underline !important;
        }
    </style>




    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @include('facturacion_electronica.guia_remision.stadistics')
            </div>
        </div>
    </div>
    {{-- Base para agregar el tab para el los contenidos --}}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    @include('facturacion_electronica.factura.shared.tabs')
                                </ul>
                            </div>
                            <div> <!-- Botón de descarga -->
                                <div class="btn-group">
                                    <button data-toggle="dropdown" type="button"
                                        class="btn btn-success dropdown-toggle ">
                                        <i class="fa fa-cloud-download"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">PDF</a></li>
                                        <li><a class="dropdown-item" href="#">WORD</a></li>
                                        <li><a class="dropdown-item" href="#">CSV</a></li>
                                        <li><a class="dropdown-item" href="#">EXCEL</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-6" class="tab-pane ">
                            </div>

                            <div role="tabpanel" id="tab-7" class="tab-pane active show">
                                <div class="d-flex justify-content-md-start row mx-3 mt-4">
                                    <div class="input-group col-md-4 mx-5">
                                        <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                        <input class="form-control" type="text" name="daterange3"
                                            value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                                <i class="fa fa-history"></i>
                                            </button>
                                        </span>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                                                <i class="fa fa-eraser"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <div class="row g-3 col-md-5">
                                        <div class="col-auto">
                                            <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="inputBuscar" class="form-control"
                                                aria-describedby="passwordHelpInline">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <div class="ibox-content">
                                        <div class="alert alert-warning">
                                            <span>Debido a la actualizacion de SUNAT, la anulación de una Guia de Remisión
                                                se debe hacer desde el portal de SUNAT con el Usuario y Clave Sol.</span>
                                        </div>
                                    </div>
                                    <table class="table table-striped dataTables-example3">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="input[] "></th>
                                                <th>ID</th>
                                                <th>Código de Guia</th>
                                                <th>Fecha emision</th>
                                                <th>Fecha entrega</th>
                                                <th>Tipo Transporte</th>
                                                <th>PDF</th>
                                                <th>XML</th>
                                                <th>ZIP</th>
                                                <th>Nª de Ticket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach ($guia_remision_enviados as $guia_remision)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="i-checks" name="input[] ">
                                                    </td>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $guia_remision->cod_guia }}</td>
                                                    <td>{{ $guia_remision->fecha_emision }}</td>
                                                    <td>{{ $guia_remision->fecha_entrega }}</td>

                                                    @if ($guia_remision->tipo_transporte == 0)
                                                        <td>Sin Trasporte</td>
                                                    @elseif($guia_remision->tipo_transporte == 1)
                                                        <td>Trasporte Publico</td>
                                                    @else
                                                        <td>Trasporte Privado</td>
                                                    @endif
                                                    <td><a href="{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-09-{{ $guia_remision->cod_guia }}.xml"
                                                            download><img src="{{ asset('xml.png') }}"
                                                                width="25px"></a></td>
                                                    <td>
                                                        @if (!isset($guia_remision->ticket_guia_remision_sunat) || $guia_remision->estado_ticket_guia == 1)
                                                            <a href="{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-09-{{ $guia_remision->cod_guia }}.zip"
                                                                download><img src="{{ asset('zip.png') }}"
                                                                    width="25px"></a>
                                                        @else
                                                            <div id="div_btn_app">
                                                                <button type="button" class="btn"
                                                                    id="guia_remi_ind_man"
                                                                    value="{{ $guia_remision->id }}"
                                                                    onclick="valid_cdr_normal(this)"><img
                                                                        src="{{ asset('zip.png') }}"
                                                                        width="25px"></button>
                                                            </div>
                                                            <div style="display: none;" id="div_dw_non">
                                                                <a id="download_cdr_post"
                                                                    href="{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-09-{{ $guia_remision->cod_guia }}.zip"
                                                                    download><img src="{{ asset('zip.png') }}"
                                                                        width="25px"></a>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($guia_remision->ticket_guia_remision_sunat == null)
                                                            <span style="font-style: italic"> Sin Ticket | Enviado con la
                                                                version antigua de las Guia de Remision</span>
                                                        @else
                                                            <strong>{{ $guia_remision->ticket_guia_remision_sunat }}</strong>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach --}}
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

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    <!-- Seleccionar todos los check -->
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Controlar el checkbox del thead 
            $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
                var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
                if (event.type === 'ifChecked') {
                    // Selecciona 
                    table.find('tbody input[type="checkbox"]').iCheck('check');
                } else {
                    // Deselecciona 
                    table.find('tbody input[type="checkbox"]').iCheck('uncheck');
                }
            });

            // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
            $('tbody input[type="checkbox"]').on('ifChanged', function(event) {
                var table = $(this).closest('table'); // Limita el control a la tabla visible
                if (table.find('tbody input[type="checkbox"]').filter(':checked').length === table.find(
                        'tbody input[type="checkbox"]').length) {
                    table.find('thead input[type="checkbox"]').iCheck('check');
                } else {
                    table.find('thead input[type="checkbox"]').iCheck('uncheck');
                }
            });

            // Detectar cuando se cambia de tab 
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                // Restablecer el estado de los checkboxes 
                var activeTab = $(e.target).attr('href'); // ID del tab activo
                $(activeTab).find('.i-checks').iCheck('update');
            });
        });
    </script>
    <!-- Page-Level Scripts -->

    <script>
        $(document).ready(function() {
            table3 = $('.dataTables-example3').DataTable({
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
            $('input[name="daterange3"]').daterangepicker({

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
                    table3.column(3).search(dateRangeString, true, false).draw();
                }
            );
        });

        function limpiar_select() {
            table3.column(3).search("").draw();
        }

        function revert_select() {
            table3.column(3).search(`{{ date('m-Y') }}`).draw();
        }
    </script>

    <!-- Page Scripts -->
    <script>
        $(document).ready(function() {
            // $('#comunicado_modal').modal({backdrop: 'static', keyboard: false});
            // $('#comunicado_modal').modal('show');

            $('.dataTables-example').DataTable({
                pageLength: 15,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });


        });
        $(function() {
            $('[data-toggle="popover"]').popover()
        })

        function toggle() {
            $(function() {
                $('[data-toggle="popover"]').popover()
            })
        }

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

        function envio_guia(codigo) {
            // console.log(codigo.val());
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
            console.log(value_check);
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.guia_remision_elec_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_remision': value_check,
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
                    // revision(value_check, response, 'factura');
                    inv_close();
                    $('#msg_individual').append(data);
                    $("#success-alert").show();
                }
            });
        }

        //* ALL ENVIO GUIA 

        function select_all_remision() {
            $('input[class=case]:checkbox').each(function() {
                // console.log($('input[class=check_all]:checkbox:checked'));
                if ($('input[class=check_all_remi]:checkbox:checked').length == 0) {
                    // console.log("a");
                    $(this).prop("checked", false);
                } else {
                    // console.log("b");
                    $(this).prop("checked", true);
                }
            });
        }

        function submit_remision_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('input[class=case]:checkbox:checked')[repetir].value;
                $.ajax({
                    type: "post",
                    url: "{{ route('facturacion_electronica.guia_remision_elec_all') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'codigo_remision': value_check,
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
                        $('#msg_remision_el').append(data);
                        repetir++;
                        submit_remision_click(repetir, maximo);
                    }
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }
        $('#remision_elec_all').on('click', function() {
            var cant_checks = $('input[class=case]:checkbox:checked').length;
            console.log(cant_checks)
            // var max_menos = cant_checks -1;
            if (cant_checks == 0) {
                console.log("ninguno marcado");
            } else {
                $('#exampleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#exampleModal").modal("show");
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                submit_remision_click(0, cant_checks);
            }

        });
        $('#cerrar').on('click', function() {
            location.reload();
        });
        //* REMISION MANUAL
        function envio_guia_manual(codigo) {
            // console.log(codigo.val());
            $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
            console.log(value_check);
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.guia_remision_m_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_remision': value_check,
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
                    // revision(value_check, response, 'factura');
                    inv_close();
                    $('#msg_individual').append(data);
                    $("#success-alert").show();
                }
            });
        }


        function select_all_remision_m() {
            $('input[class=case_m]:checkbox').each(function() {
                // console.log($('input[class=check_all]:checkbox:checked'));
                if ($('input[class=check_all_remision_m]:checkbox:checked').length == 0) {
                    // console.log("a");
                    $(this).prop("checked", false);
                } else {
                    // console.log("b");
                    $(this).prop("checked", true);
                }
            });
        }

        function submit_remision_m_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('input[class=case_m]:checkbox:checked')[repetir].value;
                $.ajax({
                    type: "post",
                    url: "{{ route('facturacion_electronica.guia_remision_m_all') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'codigo_remision': value_check,
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
                        $('#msg_remision_el_m').append(data);
                        repetir++;
                        submit_remision_m_click(repetir, maximo);
                    }
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }

        $('#remision_m_elec_all').on('click', function() {
            var cant_checks = $('input[class=case_m]:checkbox:checked').length;
            console.log(cant_checks)
            // var max_menos = cant_checks -1;
            if (cant_checks == 0) {
                console.log("ninguno marcado");
            } else {
                $('#exampleModal_M').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#exampleModal_M").modal("show");
                $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
                submit_remision_m_click(0, cant_checks);
            }

        });
        $('#cerrar_m').on('click', function() {
            location.reload();
        });

        // VALIDAR CDR

        function valid_cdr_normal(codigo) {
            var value_check = codigo.value;

            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.valid_cdr') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_remision': value_check,
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
                    // revision(value_check, response, 'factura');
                    // inv_close();
                    $('#msg_individual').append(data);
                    $("#success-alert").show();
                }
            });

            $('#div_btn_app').css('display', 'none');
            $('#div_dw_non').css('display', 'block');

            setTimeout(() => {
                const etiqueta = document.getElementById('download_cdr_post');
                etiqueta.click();
            }, 5000);


        }

        function valid_cdr_manual(codigo) {
            var value_check = codigo.value;

            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.valid_cdr_manual') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_remision': value_check,
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
                    // revision(value_check, response, 'factura');
                    // inv_close();
                    $('#msg_individual').append(data);
                    $("#success-alert").show();
                }
            });

            $('#div_btn_app_man').css('display', 'none');
            $('#div_dw_non_man').css('display', 'block');

            setTimeout(() => {
                const etiqueta = document.getElementById('download_cdr_post');
                etiqueta.click();
            }, 5000);

        }
    </script>
@endsection
