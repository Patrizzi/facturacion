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

        <div class="row">

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
                            <div role="tabpanel" id="tab-6" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                <br>
                                <br>
                                {{-- <div class="row">
                                    <div class="col-lg-12" id="alert_factura">

                                    </div>
                                </div> --}}
                                <div class="search-responsive">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                <input class="form-control" type="text" name="daterange-factura_env"
                                                    value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}"
                                                    id="daterange-factura_env" readonly="readonly" />
                                                {{-- <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter"
                                                        value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}"
                                                        readonly="readonly" /> --}}
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="revert_select_fact_env()">
                                                        <i class="fa fa-history"></i>
                                                    </button>
                                                </span>
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="limpiar_select_fact_env()">
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
                                            <button class="btn btn-primary  btn-block" id="filter_buttons">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered dataTables-fact_enviadas">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-facturas_env_all" name="input[]">
                                                </th>
                                                <th>Item</th>
                                                <th>Código</th>
                                                <th>RUC | DNI</th>
                                                <th>Cliente</th>
                                                <th>Fecha de emisión</th>
                                                <th>Precio Total</th>
                                                <th>@can('factura.xml') XML @endcan</th>
                                                <th>@can('factura.cdr') CDR @endcan</th>
                                                <th style="text-align:center;color: #0073c1"><img src="{{ asset('sunat.png') }}"
                                                        width="25px">SUNAT</th>
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
        .table {
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
        #alert_one_factura {
            margin-bottom: 0px !important;
        }

        /* .nav-tabs .dropdown-menu{
                        padding-top: 5px !important;
                        padding-bottom: 5px !important;
                    } */
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
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE FACTURAS "
            $('#tab_fact_env').addClass('active');
            // CHEK
            $('.i-checks-facturas_env_all').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
         });
        // {{-- Datatable Facturas Enviadas  --}}
        var permiso_xml = false;
        var permiso_cdr = false;
        var table_factura_enviada = $('.dataTables-fact_enviadas').DataTable({
            "serverSide": true,
            "searching": false,
            "info": false,
            "pageLength": 15,
            "responsive": true,
            "ajax": {
                url: "{{ route('facturas_electronicas.enviadas_lst') }}",
                method: "get",
                data: function(d) {
                    // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                    d.daterange = $('#daterange-factura_env')
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
                            '" class="i-checks-facturas_env">';
                    }
                },
                {
                    'width': '30%',
                    'targets': [4]
                },
                {
                    'targets': [7], // Descargar XML
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url =
                            `{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-01-${full[2]}.xml`;
                        var button = ``;
                        if(permiso_xml){
                            button += `<a href="${url}" download ><img src="{{ asset('xml.png') }}" width="25px"></i></a>`;
                        }
                        return button;
                    }
                },
                {
                    'targets': [8],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var url =
                            `{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-01-${full[2]}.zip`;
                        var button = ``;
                        if(permiso_cdr){
                            button = `<a href="${url}" download ><img src="{{ asset('cdr.png') }}" width="25px"></i></a>`;
                        }
                        return button;
                    }
                },
                {
                    'targets': [9], // Estado
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
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('.i-checks-facturas_env').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            }
        });
       
        $('input[name="daterange-factura_env"]').daterangepicker({

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
        $(`#filter_buttons`).on('click', function() {
            table_factura_enviada.ajax.reload();
        });

        // Facturas Enviadas
        function limpiar_select_fact_env() {
            table_factura_enviada.column(5).search("").draw();
        }

        function revert_select_fact_env() {
            table_factura_enviada.column(5).search(`{{ date('m-Y') }}`).draw();
        }

        // CHECKS FACTURAS
        $('thead input[class="i-checks-facturas_env_all"]').on('ifChecked ifUnchecked', function(event) {

            var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input[class="i-checks-facturas_env"]').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input[class="i-checks-facturas_env"]').iCheck('uncheck');
            }
        });

        // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
        $('tbody input[class="i-checks-facturas_env "]').on('ifChanged', function(event) {
            var table = $(this).closest('table'); // Limita el control a la tabla visible
            if (table.find('tbody input[class="i-checks-facturas_env    "]').filter(':checked').length === table
                .find(
                    'tbody input[class="i-checks-facturas_env   "]').length) {
                table.find('thead input[class=i-checks-facturas_env_all"]').iCheck('check');
            } else {
                table.find('thead input[class=i-checks-facturas_env_all"]').iCheck('uncheck');
            }
        });
    </script>

    <script>
        // PDF
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
