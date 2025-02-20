@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Boleta Electronica')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    @if (Session::has('successMsg'))
                        <div class="alert alert-success">
                            <a class="alert-link" href="#">{{ session('successMsg') }}</a>.
                        </div>
                    @endif
                    {{-- MENSAJE DEL AJAX PARA LAS FACTURAS INDIVIDUALES --}}
                    <div id="msg_individual" class="">

                    </div>
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Boletas</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">Enviados</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-3">Boleta Manual</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-4">Enviados</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane">
                                <div class="panel-body">
                                    <div class="table-responsive" id="ibox1">
                                        <div class="ibox-content">
                                            <div class="sk-spinner sk-spinner-double-bounce">
                                                <div class="sk-double-bounce1"></div>
                                                <div class="sk-double-bounce2"></div>
                                            </div>
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><input class='check_all_boleta' type='checkbox'
                                                                onclick="select_all_boleta()" /></th>
                                                        <th>Item</th>
                                                        <th>Codigo de Boleta</th>
                                                        <th>Cliente</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Fecha Vencimiento</th>
                                                        <th style="text-align:center;color: #0073c1"><img
                                                                src="{{ asset('sunat.png') }}" width="25px">SUNAT</th>
                                                    </tr>
                                                </thead>
                                                <input type="hidden" name="_token" id="token"
                                                    value="{{ csrf_token() }}">
                                                <tbody>
                                                    <span hidden>{{ $i = 1 }}</span>
                                                    @foreach ($boletas as $boleta)
                                                        <tr class="gradeX">
                                                            <td><input type='checkbox' class='case'
                                                                    value="{{ $boleta->codigo_boleta }}" /></td>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $boleta->codigo_boleta }}</td>
                                                            @if (isset($boleta->cliente_id))
                                                                <!-- Nombre del cliente -->
                                                                <td>{{ $boleta->cliente->nombre }}</td>
                                                                <td>{{ $boleta->cliente->numero_documento }}</td>
                                                            @else
                                                                <td>{{ $boleta->cotizacion->cliente->nombre }}</td>
                                                                <td>{{ $boleta->cotizacion->cliente->numero_documento }}
                                                                </td>
                                                            @endif
                                                            <td>{{ $boleta->fecha_vencimiento }}</td>
                                                            <td>
                                                                <center>
                                                                    {{-- <form action="{{route('facturacion_electronica.boleta_sunat')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="boleta_id" value="{{$boleta->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form> --}}
                                                                    <button type="button"
                                                                        class="btn btn-success btn-circle btn-ls boleta_ind"
                                                                        id="boleta_ind"
                                                                        value="{{ $boleta->codigo_boleta }}"
                                                                        onclick="envio_boleta(this)"><i
                                                                            class="fa fa-cloud-upload"></i></button>
                                                                </center>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfooter>
                                                    <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                    <td align="center"><button type="button" class="btn btn-primary"
                                                            id="boleta_elec_all">Enviar</button></td>
                                                </tfooter>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Codigo de Factura</th>
                                                    <th>Cliente</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Fecha Vencimiento</th>
                                                    <th style="text-align:center;color: #0073c1"><img
                                                            src="{{ asset('sunat.png') }}" width="25px">SUNAT</th>
                                                    <th>XML</th>
                                                    <th>ZIP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <span hidden>{{ $i = 1 }}</span>
                                                @foreach ($boletas_enviadas as $boleta_env)
                                                    <tr class="gradeX">
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $boleta_env->codigo_boleta }}</td>
                                                        @if (isset($boleta_env->cliente_id))
                                                            <!-- Nombre del cliente -->
                                                            <td>{{ $boleta_env->cliente->nombre }}</td>
                                                            <td>{{ $boleta_env->cliente->numero_documento }}</td>
                                                        @else
                                                            <td>{{ $boleta_env->cotizacion->cliente->nombre }}</td>
                                                            <td>{{ $boleta_env->cotizacion->cliente->numero_documento }}
                                                            </td>
                                                        @endif
                                                        <td>{{ $boleta_env->fecha_vencimiento }}</td>
                                                        <td>
                                                            <center>
                                                                <button type="button"
                                                                    class="btn btn-info btn-circle btn-ls"><i
                                                                        class="fa fa-check-circle"></i></button>
                                                            </center>
                                                        </td>
                                                        <td align="center">
                                                            <a href="{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-03-{{ $boleta_env->codigo_boleta }}.xml"
                                                                download><img src="{{ asset('xml.png') }}"
                                                                    width="25px"></a>
                                                        </td>
                                                        <td align="center">
                                                            <a href="{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-03-{{ $boleta_env->codigo_boleta }}.zip"
                                                                download><img src="{{ asset('zip.png') }}"
                                                                    width="25px"></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-3" class="tab-pane show">
                                <div class="panel-body">
                                    <div class="table-responsive" id="ibox2">
                                        <div class="ibox-content">
                                            <div class="sk-spinner sk-spinner-double-bounce">
                                                <div class="sk-double-bounce1"></div>
                                                <div class="sk-double-bounce2"></div>
                                            </div>
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th><input class='check_all_boleta_m' type='checkbox'
                                                                onclick="select_all_boleta_m()" /></th>
                                                        <th>Item</th>
                                                        <th>Codigo de Boleta</th>
                                                        <th>Cliente</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Fecha Vencimiento</th>
                                                        <th style="text-align:center;color: #0073c1"><img
                                                                src="{{ asset('sunat.png') }}" width="25px">SUNAT</th>
                                                    </tr>
                                                </thead>
                                                <input type="hidden" name="_token" id="token"
                                                    value="{{ csrf_token() }}">
                                                <tbody>
                                                    <span hidden>{{ $i = 1 }}</span>
                                                    @foreach ($boletas_m as $boleta_m)
                                                        <tr class="gradeX">
                                                            <td><input type='checkbox' class='case2'
                                                                    value="{{ $boleta_m->codigo_boleta }}" /></td>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $boleta_m->codigo_boleta }}</td>
                                                            <td>{{ $boleta_m->cliente->nombre }}</td>
                                                            <td>{{ $boleta_m->cliente->numero_documento }}</td>
                                                            <td>{{ $boleta_m->fecha_vencimiento }}</td>
                                                            <td>
                                                                <center>
                                                                    {{-- <form action="{{route('facturacion_electronica.boleta_m_e')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="boleta_id" value="{{$boleta_m->id}}">
                                                                <button type="submit" class="btn btn-success btn-circle btn-ls" ><i class="fa fa-cloud-upload"></i></button>
                                                            </form> --}}
                                                                    <button type="button"
                                                                        class="btn btn-success btn-circle btn-ls boleta_ind"
                                                                        id="boleta_ind"
                                                                        value="{{ $boleta_m->codigo_boleta }}"
                                                                        onclick="envio_boleta_m(this)"><i
                                                                            class="fa fa-cloud-upload"></i></button>

                                                                </center>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfooter>
                                                    <td colspan="6" align="right" style="padding-right: 2em"></td>
                                                    <td align="center"><button type="button" class="btn btn-primary"
                                                            id="boleta_elec_all_m">Enviar</button></td>
                                                </tfooter>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <div class="table-responisve">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Codigo de Factura</th>
                                                    <th>Cliente</th>
                                                    <th>Ruc/DNI</th>
                                                    <th>Fecha Vencimiento</th>
                                                    <th style="text-align:center;color: #0073c1"><img
                                                            src="{{ asset('sunat.png') }}" width="25px">SUNAT</th>
                                                    <th>XML</th>
                                                    <th>ZIP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <span hidden>{{ $i = 1 }}</span>
                                                @foreach ($boletas_enviadas_m as $boleta_env_m)
                                                    <tr class="gradeX">
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $boleta_env_m->codigo_boleta }}</td>
                                                        <td>{{ $boleta_env_m->cliente->nombre }}</td>
                                                        <td>{{ $boleta_env_m->cliente->numero_documento }}</td>
                                                        <td>{{ $boleta_env_m->fecha_vencimiento }}</td>
                                                        <td>
                                                            <center>
                                                                <button type="button"
                                                                    class="btn btn-info btn-circle btn-ls"><i
                                                                        class="fa fa-check-circle"></i></button>
                                                            </center>
                                                        </td>
                                                        <td align="center">
                                                            <a href="{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-03-{{ $boleta_env_m->codigo_boleta }}.xml"
                                                                download><img src="{{ asset('xml.png') }}"
                                                                    width="25px"></a>
                                                        </td>
                                                        <td align="center">
                                                            <a href="{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-03-{{ $boleta_env_m->codigo_boleta }}.zip"
                                                                download><img src="{{ asset('zip.png') }}"
                                                                    width="25px"></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
    </div>
    {{-- ESTILOS --}}
    <style type="text/css">
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
    </style>



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
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    @include('facturacion_electronica.boleta.shared.tabs')
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
                            <div role="tabpanel" id="tab-8" class="tab-pane active show">
                                <div class="d-flex justify-content-md-start row mx-3 mt-4">
                                    <div class="input-group col-md-4 mx-5">
                                        <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                        <input class="form-control" type="text" name="daterange5"
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
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped dataTables-example5">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                <th>Item</th>
                                                <th>Código de Boleta Manual</th>
                                                <th>Cliente</th>
                                                <th>RUC /DNI</th>
                                                <th>Fecha de emisión</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;"
                                                    class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1"
                                                    aria-label="SUNAT: activate to sort column ascending"><img
                                                        src="http://127.0.0.1:8000/sunat.png" width="15px">SUNAT</th>
                                                <th>XML</th>
                                                <th>ZIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{ $i = 1 }}</span>
                                            @foreach ($boletas_enviadas_m as $boleta_env_m)
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $boleta_env_m->codigo_boleta }}</td>
                                                    <td>{{ $boleta_env_m->cliente->nombre }}</td>
                                                    <td>{{ $boleta_env_m->cliente->numero_documento }}</td>
                                                    <td>{{ $boleta_env_m->fecha_vencimiento }}</td>
                                                    <td><button type="button" class="btn btn-info btn-circle btn-ls"><i
                                                                class="fa fa-check-circle"></i></button></td>
                                                    <td><a href="{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-03-{{ $boleta_env_m->codigo_boleta }}.xml"
                                                            download><img src="{{ asset('xml.png') }}"
                                                                width="25px"></a></td>
                                                    <td>
                                                        <a href="{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-03-{{ $boleta_env_m->codigo_boleta }}.zip"
                                                            download><img src="{{ asset('zip.png') }}"
                                                                width="25px"></a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
            table = $('.dataTables-example5').DataTable({
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
            $('input[name="daterange5"]').daterangepicker({

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
                    table.column(5).search(dateRangeString, true, false).draw();
                }
            );
        });

        function limpiar_select() {
            table.column(5).search("").draw();
        }

        function revert_select() {
            table.column(5).search(`{{ date('m-Y') }}`).draw();
        }
    </script>





    <!-- Page Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 20,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });

        function select_all_boleta() {
            $('input[class=case]:checkbox').each(function() {
                if ($('input[class=check_all_boleta]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        function select_all_boleta_m() {
            $('input[class=case2]:checkbox').each(function() {
                if ($('input[class=check_all_boleta_m]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }
        // BOlETA ENVIO
        function envio_boleta(codigo) {
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.boleta_elec_all') }}",
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
                        <div id="myAlert" class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Haga click para cerrar esta notificación">&times;</a>
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
                    revision(value_check, response, 'boleta');
                    inv_close();
                    $('#msg_individual').append(data);
                    $("#success-alert").show();
                }
            });
        }
        $('#boleta_elec_all').on('click', function() {
            var cant_checks = $('input[class=case]:checkbox:checked').length;
            if (cant_checks == 0) {
                console.log("ninguno marcado");
            } else {
                $('#exampleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#exampleModal").modal("show");
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                submit_boleta_click(0, cant_checks);
            }

        });

        function submit_boleta_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('input[class=case]:checkbox:checked')[repetir].value;
                $.ajax({
                    type: "post",
                    url: "{{ route('facturacion_electronica.boleta_elec_all') }}",
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
                        console.log('b');
                        revision(value_check, response, 'boleta');
                        $('#msg_bole_el').append(data);
                        repetir++;
                        submit_boleta_click(repetir, maximo);
                    }
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }

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

        //BOLETA MANUAL
        function envio_boleta_m(codigo) {
            $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
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
                        <div id="myAlert" class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Haga click para cerrar esta notificación">&times;</a>
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
                    revision(value_check, response, 'boleta_manual');
                    inv_close();
                    $('#msg_individual').append(data);
                    $("#success-alert").show();
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
                        console.log('b');
                        revision(value_check, response, 'boleta_manual');
                        $('#msg_bole_el_man').append(data);
                        repetir++;
                        submit_boleta_click_manual(repetir, maximo);
                    }
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }
        $('#boleta_elec_all_m').on('click', function() {
            var cant_checks = $('input[class=case2]:checkbox:checked').length;
            if (cant_checks == 0) {
                console.log("ninguno marcado");
            } else {
                $('#exampleModal2').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#exampleModal2").modal("show");
                $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
                submit_boleta_click_manual(0, cant_checks);
            }

        });

        function click() {
            console.log("click");
            $('[data-toggle="popover"]').popover();
            $('#cerrar_popup').trigger('click');
        }
        $('#cerrar_modal').on('click', function() {
            location.reload();
        });
        $('#cerrar_modal2').on('click', function() {
            location.reload();
        });
    </script>
@endsection
