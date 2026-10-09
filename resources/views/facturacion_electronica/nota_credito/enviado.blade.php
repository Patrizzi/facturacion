@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Nota de credito Electronica')
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @include('facturacion_electronica.nota_credito.stadistics')
            </div>
        </div>

    {{-- Base para agregar el tab para el los contenidos --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="">
                            <ul class="nav nav-tabs" role="tablist"
                                style="align-items: center;border-bottom: 0px !important;">
                                @include('facturacion_electronica.nota_credito.shared.tabs')
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
                        <!-- Tablas y su contenido -->
                        <div class="tab-content" style="margin-top: -2px">
                            <div role="tabpanel" id="tab-7" class="tab-pane active show" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                <br>
                                <br>
                                <div class="search-responsive">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                <input class="form-control" type="text" name="dateranger_credito"
                                                    id="dateranger_credito"
                                                    value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" readonly />
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
                                            <button class="btn btn-primary  btn-block" id="filter_buttons">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <table class="table table-striped table-bordered dataTables-example3">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-credito_env_all" name="input[]">
                                                <th>Item</th>
                                                <th>Código de NC</th>
                                                <th>Tipo</th>
                                                <th>Doc. Asoc.</th>
                                                <th>Ruc/DNI</th>
                                                <th>Cliente</th>
                                                <th>Fecha Emisión</th>
                                                <th>Fecha Envío</th>
                                                <th>@can('nota_credito.xml') XML @endcan</th>
                                                <th>@can('nota_credito.cdr') CDR @endcan</th>
                                                <th>Estado</th>
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
        .td_status {
            text-align: center;
        }
        .dataTables-example3{
            width: 100% !important;
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

    <!-- Seleccionar todos los check -->
    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE FACTURAS "
            $('#tab_credito_env').addClass('active');
            // CHEK
            $('.i-checks-credito_env_all').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // {{-- Datatable Facturas Enviadas  --}}
            var permiso_xml = false;
            var permiso_cdr = false;
            var table_credito_env = $('.dataTables-example3').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('facturacion_electronica.list_nota_credito_env') }}",
                    method: "get",
                    data: function(d) {
                        // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                        d.daterange = $('#dateranger_credito')
                            .val(); // Supongamos que tienes un select para el tipo de cotización
                        d.value = $('#inputBuscar').val();
                    },
                    dataSrc: function(json) {
                        permiso_xml = json.permiso_xml;
                        permiso_cdr = json.permiso_cdr;
                        return json.data;
                    }
                },
                "columnDefs": [{
                        'width': '1vmax',
                        'targets': [0], // Aplica a la primera columna (index 0)
                        'orderable': false, // Deshabilitar ordenación en esta columna
                        'render': function(data, type, full, meta) {
                            // Renderizar el checkbox en la primera columna
                            return '<input type="checkbox" name="select_row" value="' +
                                full[2] +
                                '" class="i-checks-credito_env">';
                        }
                    },
                    {
                        'width': '30%',
                        'targets': [6]
                    },
                    {
                        'targets': [9], // Descargar XML
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url =
                                `{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-07-${full[2]}.xml`;
                            var button = ``;
                            if(permiso_xml){
                                button += `<a href="${url}" download ><img src="{{ asset('xml.png') }}" width="25px"></i></a>` ;
                            }
                            return button;
                        }
                    },
                    {
                        'targets': [10],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url =
                                `{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-07-${full[2]}.zip`;
                            var button = ``;
                            if(permiso_cdr){
                                button += `<a href="${url}" download ><img src="{{ asset('cdr.png') }}" width="25px"></i></a>`;
                            }
                            return button;
                        }
                    },
                    {
                        'targets': [11], // Estado
                        'orderable': false,
                        'className': 'td_status',
                        'render': function(data, type, full, meta) {
                            var end = ``;
                            if (full[9] == 1) {
                                end +=
                                    `<button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button> `;
                            }
                            if (full[9] == 2) {
                                end +=
                                    `<button type="button" class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle"></i></button> `;
                            }
                            return end;
                        }
                    },

                ],
                drawCallback: function() {
                    $('.i-checks-credito_env').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });
                }
            });

            $('input[name="dateranger_credito"]').daterangepicker({
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
            });

            $(`#filter_buttons`).on('click', function() {
                table_credito_env.ajax.reload();
            });

            function limpiar_select() {
                table_credito_env.column(5).search("").draw();
            }

            function revert_select() {
                table_credito_env.column(5).search(`{{ date('m-Y') }}`).draw();
            }
        });



        $('thead input[class="i-checks-credito_env_all"]').on('ifChecked ifUnchecked', function(event) {

            var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
            if (event.type === 'ifChecked') {
                // Selecciona
                table.find('tbody input[class="i-checks-credito_env"]').iCheck('check');
            } else {
                // Deselecciona
                table.find('tbody input[class="i-checks-credito_env"]').iCheck('uncheck');
            }
        });

        // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
        $('tbody input[class="i-checks-credito_env"]').on('ifChanged', function(event) {
            var table = $(this).closest('table'); // Limita el control a la tabla visible
            if (table.find('tbody input[class="i-checks-credito_env"]').filter(':checked').length === table
                .find(
                    'tbody input[class="i-checks-credito_env"]').length) {
                table.find('thead input[class=i-checks-credito_env_all"]').iCheck('check');
            } else {
                table.find('thead input[class=i-checks-credito_env_all"]').iCheck('uncheck');
            }
        });
    </script>
    <script>
        // PDF
        function download_pdf_select() {
            var checks = $('input[class=i-checks-credito_env]:checkbox:checked');
            // var checks_all = checks.concat(checks_m, checks_d);
            checks.each(function() {
                var codigo = $(this).val();
                console.log(codigo);
            });
        }
    </script>
@endsection
