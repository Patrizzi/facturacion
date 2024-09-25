@extends('layout')

@section('title', 'Cotización')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <!-- Primer Círculo -->
                            <div class="col-md-3">
                                <div
                                    style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                    <div
                                        style="border: 2px solid green; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                        <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
                                    </div>
                                    <h4 style="font-weight: bold; margin-top: 15px;">Cotización</h4>
                                    <p style="margin: 5px 0;">{{ $cotizacion_mes['cantidad'] }} Documentos</p>
                                    <p style="color: green; font-weight: bold;">S/. {{ $cotizacion_mes['total'] }}</p>
                                </div>
                            </div>
                            <!-- Segundo Círculo -->
                            <div class="col-md-3">
                                <div
                                    style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                    <div
                                        style="border: 2px solid orange; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                        <i class="fa fa-file-text-o" style="font-size: 50px; color: black;"></i>
                                    </div>
                                    <h4 style="font-weight: bold; margin-top: 15px;">Cotización Manual</h4>
                                    <p style="margin: 5px 0;">4 Documentos</p>
                                    <p style="color: orange; font-weight: bold;">S/. 658.00</p>
                                </div>
                            </div>
                            <!-- Tercer Círculo -->
                            <div class="col-md-3">
                                <div
                                    style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                    <div
                                        style="border: 2px solid red; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                        <i class="fa fa-file-o" style="font-size: 50px; color: black;"></i>
                                    </div>
                                    <h4 style="font-weight: bold; margin-top: 15px;">Nota de Venta</h4>
                                    <p style="margin: 5px 0;">3 Documentos</p>
                                    <p style="color: red; font-weight: bold;">S/. 320.00</p>
                                </div>
                            </div>
                            <!-- Cuarto Círculo -->
                            <div class="col-md-3">
                                <div
                                    style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                    <div
                                        style="border: 2px solid blue; border-radius: 50%; padding: 30px; display: flex; justify-content: center; align-items: center;">
                                        <i class="fa fa-user-o" style="font-size: 50px; color: black;"></i>
                                    </div>
                                    <h4 style="font-weight: bold; margin-top: 15px;">Clientes</h4>
                                    <p style="margin: 5px 0;">5 Clientes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-toggle="tab" href="#tab-1" id="tab-1-tab">
                                        <span class="badge badge-success" style="background-color :green;">4</span>
                                        Cotización
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-2" id="tab-2-tab">
                                        <span class="badge badge-success" style="background-color: orange;">4</span>
                                        Cotización Manual
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-3" id="tab-3-tab">
                                        <span class="badge badge-success" style="background-color: red;">3</span> Nota de
                                        Venta
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-4">
                                        <span class="badge badge-success" style="background-color: blue;">5</span> Clientes
                                    </a>
                                </li>
                                <div class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" id="oficina-arequipa">Oficina
                                                    Arequipa</a></li>
                                            <li><a class="dropdown-item" href="#" id="galeria-centro-lima">Galería
                                                    Centro Lima</a></li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-success" type="button">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </div>
                            </ul>
                            <div class="tab-content">
                                <!-- COTIZACION-->
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">

                                </div>

                                <!-- COTIZACION MANUAL-->
                                <div role="tabpanel" id="tab-2" class="tab-pane">

                                </div>
                                <!-- NOTA DE VENTA-->
                                <div role="tabpanel" id="tab-3" class="tab-pane">

                                </div>
                                <!-- CLIENTES-->
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"
                                                        for=""><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example"
                                                id="table_cliente">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Correo</th>
                                                        <th>Celular</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                {{--   <tbody>
                                                    @foreach ($clientes as $cliente)
                                                    <tr>
                                                        <td>{{$cliente->id}}</td>
                                                        <td>{{$cliente->numero_documento}}</td>
                                                        <td>{{$cliente->nombre}}</td>
                                                        <td>{{$cliente->email}}</td>
                                                        <td>{{$cliente->celular}}</td>
                                                        <td>
                                                            <a href="{{ route('cliente.show', $cliente->id) }}" target="_blank">
                                                                <button type="button" class="btn btn-primary">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </a>
                                                            <button type="button" class="btn btn-info">
                                                                <i class="fa fa-check-circle"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody> --}}
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
                .dropdown-menu {
                    left: 70px;
                    padding: 20px 0;
                }

                #DataTables_Table_0_wrapper {
                    padding-right: 0px;
                }

                .table {
                    width: 100% !important;
                }

                .ibox-content>.row {
                    margin: auto;
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
            </style>
            <!-- Mainly scripts -->
            <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
            <script src="{{ asset('js/popper.min.js') }}"></script>
            <script src="{{ asset('js/bootstrap.js') }}"></script>
            <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
            <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

            <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
            <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

            <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
            <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
            <!-- Custom and plugin javascript -->
            <script src="{{ asset('js/inspinia.js') }}"></script>
            <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

            <!-- check -->
            <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
            <script src="{{ asset('js/icheck.min.js') }}"></script>

            {{-- SCRIPTS PARA TABS --}}
            <script>
                $(document).ready(function() {
                    $('#tab-1').load('{{ route('ventas.cotizacion') }}');
                    // Función para cargar contenido en una pestaña cuando se hace clic en ella
                    function loadTabContent(tab, url) {
                        if (!$(tab).data('loaded')) {  // Solo cargar si aún no ha sido cargado
                            $.get(url, function(data) {
                                $(tab).html(data);
                                $(tab).data('loaded', true); // Marcar pestaña como cargada
                            });
                        }
                    }

                    // Cargar contenido de la pestaña 2 al hacer clic
                    $('#tab-2-tab').on('click', function() {
                        loadTabContent('#tab-2', '{{ route('ventas.cotizacion_manual') }}');
                    });

                    // Cargar contenido de la pestaña 3 al hacer clic
                    $('#tab-3-tab').on('click', function() {
                        loadTabContent('#tab-3', '{{ route('ventas.nota_venta') }}');
                    });
                    // $('#tab-1').load('{{ route('ventas.cotizacion') }}');

                    // $('#tab-2').load('{{ route('ventas.cotizacion_manual') }}');

                    // $('#tab-3').load('{{ route('ventas.nota_venta') }}');
                });
            </script>
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

            <!--Organizar-->
            {{-- <script>
                $(document).ready(function() {
                    table = $('.dataTables-example-facturacion').DataTable({
                        pageLength: 10,
                        order: [
                            [0, "desc"]
                        ],
                        responsive: true,
                        dom: '<"html5buttons"B>lTfgitp',
                        footerCallback: function(tr, data, start, end, display) {
                            var api = this.api(),
                                data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function(i) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '') * 1 :
                                    typeof i === 'number' ?
                                    i : 0;
                            };

                            // Total over all pages
                            total = api
                                .column(7)
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Total filtered rows on the selected column (code part added)
                            var sumCol4Filtered = display.map(el => data[el][7]).reduce((a, b) => intVal(a) +
                                intVal(b), 0);

                            // Update footer
                            $(api.column(7).footer()).html(
                                'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                            );
                        },
                        buttons: []
                    });

                    revert_select();

                    $(document).on('change', '#select_tipo_coti', function(event) {
                        var nombre = $("#select_tipo_coti option:selected").val();
                        // console.log(nombre);
                        table.column(10).search(nombre).draw();
                    });
                    $('input[name="daterange"]').daterangepicker({
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
                            table.column(4).search(dateRangeString, true, false).draw();
                        }
                    );
                });

                function limpiar_select() {
                    table.column(4).search("").draw();
                }

                function revert_select() {
                    table.column(4).search(`{{ date('m-Y') }}`).draw();
                }
            </script> --}}

            <!--Clientes-->
            <script>
                $(document).ready(function() {
                    $('#table_cliente').DataTable({
                        "serverSide": true,
                        "ajax": "{{ url('api/clientes') }}",
                        "columns": [{
                                data: 'id'
                            },
                            {
                                data: 'nombre'
                            },
                            {
                                data: 'numero_documento'
                            },
                            {
                                data: 'email'
                            },
                            {
                                data: 'celular'
                            },
                            {
                                name: '',
                                data: null,
                                sortable: false,
                                searchable: false,
                                render: function(data) {
                                    var actions = '';
                                    actions +=
                                        '<a href="{{ route('cliente.show', ':id') }}" target="_blank"><button type="button" class="btn btn-primary mr-2"><i class="fa fa-eye"></i></button></a>';
                                    actions +=
                                        '<button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>';
                                    return actions.replace(/:id/g, data.id);
                                }
                            }
                        ]
                    });
                });
            </script>
        @endsection
