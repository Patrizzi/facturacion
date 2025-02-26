@extends('layout')

@section('title', 'Guia de remision')
@section('breadcrumb', 'Guia de remision')
@section('breadcrumb2', 'Guia de remision')

{{-- @extends('layout_comunicado') --}}
@section('content')
    @include('layout_comunicado')
    <div class="wrapper wrapper-content animated fadeInRight">
        @if ($msg_ticket ==  0)
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
                                <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
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
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-7" class="tab-pane active show">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12" id="alert_guia">

                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                <input class="form-control" type="text" name="dateranger_remision"
                                                    id="dateranger_remision"
                                                    value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="revert_select()">
                                                        <i class="fa fa-history"></i>
                                                    </button>
                                                </span>
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="limpiar_select()">
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
                                    <table class="table table-striped table-hover dataTables-example3">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-remision_env_all" name="input[]">
                                                </th>
                                                <th>ID</th>
                                                <th>Código de Guia</th>
                                                <th>RUC | DNI</th>
                                                <th>Cliente</th>
                                                <th>Fecha emision</th>
                                                <th>Fecha entrega</th>
                                                <th>Tipo Transporte</th>
                                                <th>Estado</th>
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

        .td_ticket {
            font-style: italic;
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


    <!-- Seleccionar todos los check -->
    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE FACTURAS "
            $('#tab_remision_env').addClass('active');
            // CHEK
            $('.i-checks-remision_env_all').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // {{-- Datatable Facturas Enviadas  --}}
            var table_remision_env = $('.dataTables-example3').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('guias_electronicas.list_remision_env') }}",
                    method: "get",
                    data: function(d) {
                        // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                        d.daterange = $('#dateranger_remision')
                            .val(); // Supongamos que tienes un select para el tipo de cotización
                        d.value = $('#inputBuscar').val();
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "columnDefs": [{
                        'width': '1vmax',
                        'targets': [0], // Aplica a la primera columna (index 0)
                        'orderable': false, // Deshabilitar ordenación en esta columna
                        'render': function(data, type, full, meta) {
                            // Renderizar el checkbox en la primera columna
                            return '<input type="checkbox" name="select_row" value="' + full[2] +
                                '" class="i-checks-remision_env">';
                        }
                    },
                    {
                        'width': '30%',
                        'targets': [4]
                    },
                    {
                        'targets': [8], // Estado
                        'orderable': false,
                        'className': 'td_status',
                        'render': function(data, type, full, meta) {
                            var end = ``;
                            if (full[8] == 1) {
                                end +=
                                    `<button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button> `;
                            }
                            if (full[8] == 2) {
                                end +=
                                    `<button type="button" class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle"></i></button> `;
                            }
                            return end;
                        }
                    },
                    {
                        'targets': [9], // Descargar XML
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url =
                                `{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-09-${full[2]}.xml`;
                            return `<a href="${url}" download ><img src="{{ asset('xml.png') }}" width="25px"></i></a>`;
                        }
                    },
                    {
                        'targets': [10],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            if (`${full[12]}` != null || `${full[13]}` == 1) {
                                var url =
                                    `{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-09-${full[2]}.zip`;

                                var finish_all =
                                    `<a href="${url}" download ><img src="{{ asset('cdr.png') }}" width="25px"></i></a>`;
                            } else {
                                var url =
                                    `{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-09-${full[2]}.zip`;

                                var finish_all = `
                                <div id="div_btn_app_man">
                                    <button type="button" class="btn" id="guia_remi_ind_man" value="${full[2]}" onclick="valid_cdr_normal(this)"><img src="{{ asset('cdr.png') }}" width="25px"></button>
                                </div>
                                <div style="display: none;" id="div_dw_non_man">
                                    <a id="download_cdr_post" href="${url}" download ><img src="{{ asset('cdr.png') }}" width="25px"></a>   
                                </div>  `;
                            };
                            return finish_all;
                        }
                    },
                    {
                        'targets': [11],
                        'orderable': false,
                        'className': 'td_ticket',
                        'render': function(data, type, full, meta) {
                            return `${full[11]}`;
                        }
                    }
                ],
                drawCallback: function() {
                    $('.i-checks-remision_env').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });
                }
            });

            $('input[name="dateranger_remision"]').daterangepicker({

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
                }

            );

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
        });

        // GUIAS Enviadas
        function limpiar_select() {
            table_remision_env.column(5).search("").draw();
        }

        function revert_select() {
            table_remision_env.column(5).search(`{{ date('m-Y') }}`).draw();
        }
        // CHECKS GUIAS
        $('thead input[class="i-checks-remision_env_all"]').on('ifChecked ifUnchecked', function(event) {

            var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input[class="i-checks-remision_env"]').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input[class="i-checks-remision_env"]').iCheck('uncheck');
            }
        });

        // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
        $('tbody input[class="i-checks-remision_env"]').on('ifChanged', function(event) {
            var table = $(this).closest('table'); // Limita el control a la tabla visible
            if (table.find('tbody input[class="i-checks-remision_env"]').filter(':checked').length === table
                .find(
                    'tbody input[class="i-checks-remision_env"]').length) {
                table.find('thead input[class=i-checks-remision_env_all"]').iCheck('check');
            } else {
                table.find('thead input[class=i-checks-remision_env_all"]').iCheck('uncheck');
            }
        });

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
                    $('#alert_guia').append(data);
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
    </script>
    <script>
        // PDF
        function download_pdf_select() {
            var checks = $('input[class=i-checks-remision_env]:checkbox:checked');
            // var checks_all = checks.concat(checks_m, checks_d);
            checks.each(function() {
                var codigo = $(this).val();
                console.log(codigo);
            });
        }
    </script>
@endsection
