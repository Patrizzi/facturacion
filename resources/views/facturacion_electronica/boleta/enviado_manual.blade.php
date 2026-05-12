@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Boleta Electronica')
@section('content')

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
                        <div class="tab-content" style="margin-top: -2px">
                            <div role="tabpanel" id="tab-8" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                <br>
                                <br>
                                <div class="search-responsive">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                <input class="form-control" id="daterange-boleta_env" type="text"
                                                    name="daterange-boleta_env"
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
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped table-bordered dataTables-bol_enviadas">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-boletas_env_all" name="input[]">
                                                <th>Item</th>
                                                <th>Código de Boleta Manual</th>
                                                <th>Cliente</th>
                                                <th>RUC /DNI</th>
                                                <th>Fecha de emisión</th>
                                                <th>Precio Total</th>
                                                <th style="text-align:center;color: #0073c1"><img
                                                        src="{{ asset('sunat.png') }}" width="25px">SUNAT</th>
                                                <th>@can('boleta_m.xml') XML @endcan</th>
                                                <th>@can('boleta_m.cdr') CDR @endcan</th>
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

    <style>
        .table{
            width: 100% !important;
        }
        .dropdown-menu {
            left: 70px;
            padding: 20px 0;
        }

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

        #alert_one_boleta {
            margin-bottom: 0px !important;
        }

        .nav-tabs .dropdown-menu {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        .td_status {
            text-align: center;
        }
        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        .search-responsive, .table-responsive {
            padding-right: 15px !important;
            padding-left: 15px !important;
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
    {{-- <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script> --}}
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE FACTURAS "
            $('#boeltas_m_enviados').addClass('active');
            // CHEK
            $('.i-checks-boletas_env_all').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            var permiso_xml = false;
            var permiso_cdr = false;
            // {{-- Datatable Facturas Enviadas  --}}
            var table_boleta_end = $('.dataTables-bol_enviadas').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('boletas_electronicas.list_boletas_env') }}",
                    method: "get",
                    data: function(d) {
                        // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                        d.daterange = $('#daterange-boleta_env')
                            .val(); // Supongamos que tienes un select para el tipo de cotización
                        d.value = $('#inputBuscar').val();
                    },
                    dataSrc: function(json) {
                        permiso_xml = json.permiso_xml;
                        permiso_cdr = json.permiso_cdr;
                        return json.data;
                    }
                },
                "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                    $(nRow).addClass('tooltip-demo');
                    return nRow;
                },
                "columnDefs": [{
                        'width': '1vmax',
                        'targets': [0], // Aplica a la primera columna (index 0)
                        'orderable': false, // Deshabilitar ordenación en esta columna
                        'render': function(data, type, full, meta) {
                            // Renderizar el checkbox en la primera columna
                            return '<input type="checkbox" name="select_row" value="' + full[2] +
                                '" class="i-checks-boletas_env">';
                        }
                    },
                    {
                        'width': '30%',
                        'targets': [4]
                    },
                    {
                        'targets': [7], // Estado
                        'orderable': false,
                        'className': 'td_status',
                        'render': function(data, type, full, meta) {
                            var end = ``;
                            if (full[7] == 1) {
                                end +=
                                    `<button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button> `;
                            } else {
                                end +=
                                    `<button type="button" class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle"></i></button> `;
                            }
                            // NOTA DE CREDITO
                            if (full[9] != 0) {
                                if (full[9] == 1) {
                                    end +=
                                        `<button class="btn btn-info btn-circle btn-ls"  data-toggle="tooltip" data-placement="bottom" title="Nota de Credito:  Aceptada"><i style="font-weight: 700">NC</i></button> `;
                                } else {
                                    end +=
                                        `<button class="btn btn-warning btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Credito: En Espera"><i style="font-weight: 700">NC</i></button> `;
                                }
                            }
                            // NOTA DE DEBITO
                            if (full[10] != 0) {
                                if (full[10] == 1) {
                                    end +=
                                        `<button class="btn btn-info btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Debito:  Aceptada"><i style="font-weight: 700">ND</i></button>`;
                                } else {
                                    end +=
                                        `<button class="btn btn-warning btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Debito: En Espera"><i style="font-weight: 700">ND</i></button>`;
                                }
                            }

                            return end;
                        }
                    },
                    {
                        'targets': [8], // Descargar XML
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url =
                                `{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-03-${full[2]}.xml`;
                            var button = ``;
                            if(permiso_xml){
                                button += `<a href="${url}" download ><img src="{{ asset('xml.png') }}" width="25px"></i></a>`;
                            }
                            return button;
                        }
                    },
                    {
                        'targets': [9],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url =
                                `R-{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-03-${full[2]}.zip`;
                            var button = ``;
                            if(permiso_xml){
                                button += `<a href="${url}" download ><img src="{{ asset('cdr.png') }}" width="25px"></i></a>`;
                            }
                            return button;
                        }
                    }
                ],
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip();
                    $('.i-checks-boletas_env').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });
                }
            });

            $('input[name="daterange-boleta_env"]').daterangepicker({

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
        });


        // Facturas Enviadas
        function limpiar_select() {
            table_boleta_end.column(5).search("").draw();
        }

        function revert_select() {
            table_boleta_end.column(5).search(`{{ date('m-Y') }}`).draw();
        }
        // CHECKS FACTURAS
        $('thead input[class="i-checks-boletas_env_all"]').on('ifChecked ifUnchecked', function(event) {

            var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input[class="i-checks-boletas_env"]').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input[class="i-checks-boletas_env"]').iCheck('uncheck');
            }
        });

        // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
        $('tbody input[class="i-checks-boletas_env"]').on('ifChanged', function(event) {
            var table = $(this).closest('table'); // Limita el control a la tabla visible
            if (table.find('tbody input[class="i-checks-boletas_env"]').filter(':checked').length === table
                .find(
                    'tbody input[class="i-checks-boletas_env"]').length) {
                table.find('thead input[class=i-checks-boletas_env_all"]').iCheck('check');
            } else {
                table.find('thead input[class=i-checks-boletas_env_all"]').iCheck('uncheck');
            }
        });
    </script>

    <script>
        // PDF
        function download_pdf_select() {
            var checks = $('input[class=i-checks-boletas_env]:checkbox:checked');
            // var checks_all = checks.concat(checks_m, checks_d);
            checks.each(function() {
                var codigo = $(this).val();
                console.log(codigo);
            });
        }
    </script>

@endsection
