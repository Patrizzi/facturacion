@extends('layout')

@section('title', 'Guia de remision')
@section('breadcrumb', 'Guia de remision')
@section('breadcrumb2', 'Guia de remision')

{{-- @extends('layout_comunicado') --}}
@section('content')
    @include('layout_comunicado')
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
                                <div style="margin:0px 15px 10px 15px">
                                    <div class="row">
                                        <div class="col-lg-12" id="alert_guia" style="min-height: 15px">

                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                <input class="form-control" type="text" name="dateranger_remision"
                                                    id="dateranger_remision"
                                                    value="{{ date('m/01/Y') }} - {{ date('t/m/Y') }}" readonly />
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
                                            <button class="btn btn-primary btn-block"
                                                id="sercha_remision_lsitado">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered dataTables-example3">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-remision_env_all" name="input[]">
                                                </th>
                                                <th>ID</th>
                                                <th>Código</th>
                                                <th>RUC | DNI</th>
                                                <th>Cliente</th>
                                                <th>Fecha emision</th>
                                                <th>Fecha entrega</th>
                                                <th>Tipo Transporte</th>
                                                <th>XML</th>
                                                <th>CDR</th>
                                                {{-- <th>Estado</th> --}}
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>

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
    <div id="ticket-panel" class="ticket-panel">
        {{-- <div class="ticket-panel-header">
            Ticket
            <span class="ticket-close">×</span>
        </div> --}}
        <div class="ticket-panel-body"></div>
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

        .table {
            width: 100% !important;
        }

        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        .search-responsive {
            padding-right: 15px;
            padding-left: 15px;
        }

        .ticket-panel {
            position: absolute;
            width: 320px;
            background: #ffffff;
            border: 1px solid #e7eaec;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            display: none;
            font-size: 12px;
        }

        .ticket-panel-header {
            background: #1ab394;
            color: #fff;
            padding: 8px 10px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ticket-close {
            cursor: pointer;
            font-size: 16px;
        }

        .ticket-panel-body {
            padding: 10px;
            color: #333;
            white-space: pre-wrap;
            /* respeta saltos */
            user-select: text;
            /* CLAVE */
            cursor: text;
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

    {{-- alertas SWEET --}}
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

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
        // {{-- Datatable Facturas Enviadas  --}}
        var table_remision_env = $('.dataTables-example3').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('guias_electronicas.list_remision_env') }}",
                method: "get",
                data: function(d) {
                    d.daterange = $('#dateranger_remision').val();
                    d.value = $('#inputBuscar').val();
                },
                dataSrc: function(json) {
                    return json.data;
                }
            },
            drawCallback: function() {
                $('.tooltip-demo [data-toggle="tooltip"]').tooltip({
                    container: 'body'
                });

                $('.tooltip-demo [data-toggle="popover"]').popover({
                    container: 'body',
                    trigger: 'hover'
                });
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
                    'targets': [8], // Descargar XML
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url =
                            `{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-09-${full[2]}.xml`;
                        return `<a href="${url}" download ><img src="{{ asset('xml.png') }}" width="25px"></i></a>`;
                    }
                },
                {
                    'targets': [9],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        if (`${full[9]}` != null || `${full[9]}` == 1) {
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
                    'targets': [10], // Estado
                    'orderable': false,
                    'className': 'td_status',
                    'width': '10%',
                    'render': function(data, type, full, meta) {
                        // Estado
                        var end = ``;
                        if (full[10] == 1) {
                            end +=
                                `<button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button> `;
                        }
                        if (full[10] == 2) {
                            end +=
                                `<button type="button" class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle"></i></button> `;
                        }
                        // N de Ticket
                        end += `
                              <button class="btn btn-primary btn-sm ticket-btn"
                                    data-ticket="Ticket N°  ${full[11]}">
                                <i class="fa fa-exclamation"></i>
                            </button>
                        `;
                        // Botón Anular
                        if (full[10] == 2) { //Si está anulado
                            end += `
                              <button class="btn btn-danger btn-sm" disabled>
                                <i class="fa fa-trash"></i>
                            </button>
                        `;
                        } else { //Si se puede anular
                            end += `
                              <button class="btn btn-danger btn-sm boton-anular"  data-id="${full[0]}" data-codigo="${full[2]}">
                                <i class="fa fa-trash"></i>
                            </button>
                        `;
                        }
                        return end;
                    }
                },
                // {
                //     'targets': [11],
                //     'orderable': false,
                //     'className': 'td_ticket',
                //     'render': function(data, type, full, meta) {
                //         return `${full[11]}`;
                //     }
                // }
            ],
            drawCallback: function() {
                $('.i-checks-remision_env').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            }
        });
        $('#sercha_remision_lsitado').on('click', function() {
            table_remision_env.ajax.reload();
        });

        function revert_select() {
            $('#dateranger_remision').val(`{{ date('m/01/Y') }} - {{ date('t/m/Y') }}`)
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

        // PDF
        function download_pdf_select() {
            var checks = $('input[class=i-checks-remision_env]:checkbox:checked');
            // var checks_all = checks.concat(checks_m, checks_d);
            checks.each(function() {
                var codigo = $(this).val();
                console.log(codigo);
            });
        }


        $(document).on('click', '.ticket-btn', function(e) {
            e.stopPropagation();

            const panel = $('#ticket-panel');
            const text = $(this).data('ticket');

            panel.find('.ticket-panel-body').text(text);

            const btnOffset = $(this).offset();
            const panelWidth = panel.outerWidth();
            const panelHeight = panel.outerHeight();
            const btnWidth = $(this).outerWidth();

            panel.css({
                top: btnOffset.top - panelHeight - 8,
                left: btnOffset.left - panelWidth + btnWidth
            }).fadeIn(150);
        });


        /* Cerrar */
        $(document).on('click', '.ticket-close, body', function() {
            $('#ticket-panel').fadeOut(100);
        });

        /* Evita cerrar al seleccionar texto */
        $('#ticket-panel').on('click', function(e) {
            e.stopPropagation();
        });
        

        $(document).on('click', '.boton-anular', function() {

            const id = $(this).data('id');
            const codigo = $(this).data('codigo');

            swal({
                    title: "¿Estás seguro?",
                    text: "Vas a anular la Guia: " + codigo + " y se efectuará el re-stock de los Productos. Esto no anulará la Guia en Sunat, eso debe realizarse desde el mismo portal SOL",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "No, cancelar",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        // Aquí usas la variable
                        console.log('Eliminar ID:', id);
                        $.ajax({
                            type: "post",
                            url: "{{ route('guia_remision.anular') }}",
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id_guia': id,
                            },
                            success: function(response) {
                               if (response.success) {
                                    // swal("Anulado", resp.message, "success");
                                    table_remision_env.ajax.reload();
                                } else {
                                    // swal("Error", resp.message, "error");
                                }
                            },
                            error: function (xhr) {
                                const msg = xhr.responseJSON?.message || 'Error inesperado';
                                swal("Error", msg, "error");
                            }
                        });

                        swal("Eliminado", "El ticket fue eliminado correctamente.", "success");
                    } else {
                        swal("Cancelado", "La operación fue cancelada.", "error");
                    }
                }
            );
        });
    </script>
@endsection
