@extends('layout')

@section('title', 'Guia de remision')
@section('breadcrumb', 'Guia de remision')
@section('breadcrumb2', 'Guia de remision')


@section('content')

    @include('layout_comunicado')
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

    <div class="wrapper wrapper-content animated fadeInRight">
        @if ($msg_ticket == 0)
            <div class="alert alert-danger">
                <b>Por favor, ponerse en contacto con el soporte para ver el tema de Envio Guias de Remision a SUNAT</b>
            </div>
        @endif
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
                        <div class="">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist"
                                    style="align-items: center;border-bottom: 0px !important;">
                                    @include('facturacion_electronica.guia_remision.shared.tabs')
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
                        <div class="tab-content" style="margin-top: -2px">
                            <div role="tabpanel" id="tab-8" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12" id="alert_remision">
    
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                    <input class="form-control" type="text" name="dateranger_factura"
                                                        value=""  readonly/>
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
                                </div>
                                <div class="table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-bordered table-striped dataTables-example4">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-remision-head"
                                                        name="input_remision[]"></th>
                                                <th>ID</th>
                                                <th>Código de Guia</th>
                                                <th>RUC | DNI</th>
                                                <th>Cliente</th>
                                                <th>Fecha emision</th>
                                                <th>Fecha entrega</th>
                                                <th>Tipo Transporte</th>
                                                <th style="text-align:center;color: #0073c1">
                                                    @can('guia_remision_m.emitir')
                                                        <img src="{{ asset('sunat.png') }}" width="25px">SUNAT
                                                    @endcan
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($guia_remisiones as $index => $guia_remision)
                                                <tr>
                                                    <td><input type="checkbox" class="i-checks-remision" name="input[]"
                                                            value="{{ $guia_remision->cod_guia }}">
                                                    </td>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $guia_remision->cod_guia }}</td>
                                                    <td>{{ $guia_remision->cliente->numero_documento }}</td>
                                                    <td>{{ $guia_remision->cliente->nombre }}</td>
                                                    <td>{{ $guia_remision->fecha_emision }}</td>
                                                    <td>{{ $guia_remision->fecha_entrega }}</td>
                                                    @if ($guia_remision->tipo_transporte == 0)
                                                        <td>Sin Trasporte</td>
                                                    @elseif($guia_remision->tipo_transporte == 1)
                                                        <td>Trasporte Publico</td>
                                                    @else
                                                        <td>Trasporte Privado</td>
                                                    @endif
                                                    <td>
                                                        @can('guia_remision_m.emitir')
                                                            <button type="button"
                                                                class="btn btn-success btn-circle btn-ls factura_ind"
                                                                id="guia_remi_ind" value="{{ $guia_remision->cod_guia }}"
                                                                onclick="envio_guia_manual(this)"><i
                                                                    class="fa fa-cloud-upload"></i></button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @can('guia_remision_m.emitir')
                                            <tfoot>
                                                <tr>
                                                    <td colspan="8" align="right" style="padding-right: 2em"></td>
                                                    <td align="center">
                                                        <button type="submit" class="btn btn-primary"
                                                            id="remision_m_elec_all">Enviar</button>
                                                        {{-- <span class="btn btn-primary btn-ls disabled">
                                                            Enviar
                                                        </span> --}}
                                                    </td>
                                                </tr>
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

    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#tab_remision_m').addClass('active');

            $('.i-checks-remision').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('.i-checks-remision-head').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            // {{-- Datatable Facturas --}}
            table_remision = $('.dataTables-example4').DataTable({
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
                    table_remision.column(5).search(dateRangeString, true, false).draw();
                }
            );
        });

        function limpiar_select() {
            table_remision.column(3).search("").draw();
        }

        function revert_select() {
            table_remision.column(3).search(`{{ date('m-Y') }}`).draw();
        }

        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 20000
            };
            toastr.warning(
                'Debido a la actualizacion de SUNAT, la anulación de una Guia de Remisión se debe hacer desde el portal de SUNAT con el Usuario y Clave Sol'
            );

        }, 1300);
    </script>
    <script>
        $(document).ready(function() {
            // CHECKS FACTURAS
            $('thead input[class="i-checks-remision-head"]').on('ifChecked ifUnchecked', function(event) {
                var table = $(this).closest('table');
                if (event.type === 'ifChecked') {
                    // Selecciona
                    table.find('tbody input.i-checks-remision').not(':disabled').iCheck('check');
                } else {
                    // Deselecciona
                    table.find('tbody input.i-checks-remision').not(':disabled').iCheck('uncheck');
                }
            });

            $('tbody input.i-checks-remision').on('ifChanged', function(event) {
                if ($(this).prop('disabled')) {
                    return; // Si el checkbox está deshabilitado, no hace nada
                }

                var table = $(this).closest('table'); // Limita el control a la tabla visible

                var checkboxesHabilitados = table.find('tbody input.i-checks-remision').not(
                    ':disabled');
                var checkboxesMarcados = checkboxesHabilitados.filter(':checked');

                // Si todos los checkboxes habilitados están marcados, marcar el de <thead>
                if (checkboxesMarcados.length === checkboxesHabilitados.length) {
                    table.find('thead input.i-checks-remision').iCheck('check');
                } else {
                    table.find('thead input.i-checks-remision').iCheck('uncheck');
                }
            });
        });
    </script>
    <!-- Page Scripts -->
    <script>
        //* REMISION MANUAL
        function envio_guia_manual(codigo) {
            console.log(codigo);
            // $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
            $(codigo).closest('tr').find('input[type="checkbox"]').prop('disabled', 'disabled');
            $(codigo).prop('disabled', 'disabled');
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
                            <div id="alert_one_factura" class="alert alert-danger">
                                <button class="close close_mini" id="cerrar_solo">&times;</button>
                                <span class="alert-link" id="` + value_check + `">Error N°  ` + value_check +
                            ' <br> ' +
                            response + `</span>
                            </div>
                        `;
                    } else {
                        var data = `
                            <div id="alert_one_remision" class=" alert alert-success" >
                                <button class="close close_mini" id="cerrar_solo">&times;</button>
                                <span class="alert-link clos_mini" id="` + value_check + `">` + response + `</span>
                            </div>
                        `;
                    }
                    // revision(value_check, response, 'factura');
                    // inv_close();
                    $('#alert_remision').append(data);
                    $('#cerrar_solo').on('click', function() {
                        location.reload();
                    });
                }
            });
        }

        function submit_remision_m_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('input[class=i-checks-remision]:checkbox:checked')[repetir].value;
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
                $('#exampleModal_M').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }

        $('#remision_m_elec_all').on('click', function() {
            var cant_checks = $('input[class=i-checks-remision]:checkbox:checked').length;
            if (cant_checks != 0) {
                submit_remision_m_click(0, cant_checks);
            }
        });
        $('#cerrar_m').on('click', function() {
            location.reload();
        });

        // VALIDAR CDR
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
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Haga click para cerrar esta notificación.">&times;</a>
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
