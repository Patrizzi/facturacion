@extends('layout')

@section('title', 'Cotización')
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h4>Resumen de Febrero 2024</h4>
                    </div>
                    <div class="ibox-content">
                        {{-- Acá iria el tema de los circulos --}}
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
                            <ul class="nav nav-tabs" role="tablist">
                                <li>
                                    <a class="nav-link active show" data-toggle="tab" href="#tab-1">
                                        {{-- link del tab 1 --}}
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" data-toggle="tab" href="#tab-2">
                                        {{-- link del tab 2 --}}
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <div class="panel-body">
                                        {{-- CONTENIDO DENTRO DEL TAB  --}}
                                    </div>
                                </div>
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        {{-- CONTENIDO DENTRO DEL TAB  2 --}}
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="wrapper wrapper-content animated fadeInRight" >
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="bg-white p-4 rounded shadow-sm">
                    <b>
                        <h4 class="text-left">Resumen de Febrero 2024</h4>
                    </b>
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div style="border: 2px solid green; border-radius: 50%; padding: 20px; display: flex; justify-content: center; align-items: center;">
                                    <img src="/path/to/your/icon1.png" alt="" style="width: 40px;">
                                </div>
                                <h4 style="font-weight: bold">Cotización</h4>
                                <p>4 Documentos</p>
                                <p style="color: green; font-weight: bold;">S/. 471.55</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div style="border: 2px solid orange; border-radius: 50%; padding: 20px; display: flex; justify-content: center; align-items: center;">
                                    <img src="/path/to/your/icon2.png" alt="" style="width: 40px;">
                                </div>
                                <h4 style="font-weight: bold">Cotización Manual</h4>
                                <p>4 Documentos</p>
                                <p style="color: orange; font-weight: bold;">S/. 351.00</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div style="border: 2px solid red; border-radius: 50%; padding: 20px; display: flex; justify-content: center; align-items: center;">
                                    <img src="/path/to/your/icon3.png" alt="" style="width: 40px;">
                                </div>
                                <h4 style="font-weight: bold">Nota de Venta</h4>
                                <p>5 Documentos</p>
                                <p style="color: red; font-weight: bold;">S/. ****.**</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                <div style="border: 2px solid blue; border-radius: 50%; padding: 20px; display: flex; justify-content: center; align-items: center;">
                                    <img src="/path/to/your/icon4.png" alt="" style="width: 40px;">
                                </div>
                                <h4 style="font-weight: bold">Clientes</h4>
                                <p>25 Clientes</p>
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
                <div class="">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link active" data-toggle="tab" href="#tab-cotizacion">
                                    <span style="color: green;">4&#9632;</span> Cotización
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-cotizacion-manual">
                                    <span style="color: orange;">4&#9632;</span> Cotización Manual
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-nota-venta">
                                    <span style="color: red;">6&#9632;</span> Nota de Venta
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-clientes">
                                    <span style="color: blue;">25&#9632;</span> Clientes
                                </a>
                            </li>
                            <button class="btn btn-success dim" type="button" style="text-align:left;"><i
                                    class="fa fa-plus-square"></i></button>
                            <button class="btn btn-success dim" type="button"><i class="fa fa-upload"></i></button>
                        </ul>

                        <div class="">
                            <!-- Contenido de las pestañas -->
                            <div class="tab-content">

                                <!-- Tabla de cotizacion -->
                                <div id="tab-cotizacion" class="tab-pane active">
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
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
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-6 col-form-label" for=""><strong>Tipo de
                                                            Cotización:</strong></label>
                                                    <select class="form-control col-lg-6" name=""
                                                        id="select_tipo_coti">
                                                        <option value="">Comprobantes</option>
                                                        <option value="factura">Factura</option>
                                                        <option value="boleta">Boleta</option>
                                                        <option value="nota_venta">Nota de Venta</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"
                                                        for=""><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-6">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover ">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>N° Cotizacion</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha Emision</th>
                                                        <th>Forma</th>
                                                        <th>Importe T.</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>******</td>
                                                        <td>031465121</td>
                                                        <td>Marco Estrada</td>
                                                        <td>07-10-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 200.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>
                                                            <button type="button" class="btn btn-info"><i
                                                                    class="fa fa-check-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>

                                                <tbody>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>******</td>
                                                        <td>031465121</td>
                                                        <td>Marlo Calderon</td>
                                                        <td>08-02-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 320.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>
                                                            <button type="button" class="btn btn-warning"><i
                                                                    class="fa fa-clock-o"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="6" class="text-right">Total General</th>
                                                        <th colspan="4">S/. ****</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tabla de Cotizacion Manual -->
                                <div id="tab-cotizacion-manual" class="tab-pane fade">
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
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
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-6 col-form-label" for=""><strong>Tipo de
                                                            Cotización:</strong></label>
                                                    <select class="form-control col-lg-6" name=""
                                                        id="select_tipo_coti">
                                                        <option value="">Comprobantes</option>
                                                        <option value="factura">Factura</option>
                                                        <option value="boleta">Boleta</option>
                                                        <option value="nota_venta">Nota de Venta</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"
                                                        for=""><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-6">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>N° Cotizacion</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha Emision</th>
                                                        <th>Forma</th>
                                                        <th>Importe T.</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>******</td>
                                                        <td>70871200</td>
                                                        <td>Daniel Roman</td>
                                                        <td>07-10-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 200.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-warning"><i
                                                                    class="fa fa-clock-o"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="6" class="text-right">Total General</th>
                                                        <th colspan="4">S/. ****</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de Nota de Venta -->
                                <div id="tab-nota-venta" class="tab-pane fade">
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
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

                                            <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label"
                                                        for=""><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-6">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>N° Nota de Venta</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha Emision</th>
                                                        <th>Forma</th>
                                                        <th>Importe T.</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>****</td>
                                                        <td>08123245</td>
                                                        <td>Julio Flores</td>
                                                        <td>02-01-2024</td>
                                                        <td>Contado</td>
                                                        <td>S/. 200.00</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>

                                                            <button type="button" class="btn btn-danger"><i
                                                                    class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de Clientes -->
                                <div id="tab-clientes" class="tab-pane fade">
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label"
                                                        for=""><strong>Buscar:</strong></label>
                                                    <input type="search" class="form-control col-lg-6">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Codigo</th>
                                                        <th>Ruc/DNI</th>
                                                        <th>Cliente</th>
                                                        <th>Correo</th>
                                                        <th>Celular</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>*******</td>
                                                        <td>72531212</td>
                                                        <td>Marlo Samaniego Calderon</td>
                                                        <td>sincorreo@gmail.com</td>
                                                        <td>920123456</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>
                                                            <button type="button" class="btn btn-info"><i
                                                                    class="fa fa-check-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>*******</td>
                                                        <td>77893000</td>
                                                        <td>Carlos Antoñez Gomez</td>
                                                        <td>sincorreo@gmail.com</td>
                                                        <td>970841600</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"><i
                                                                    class="fa fa-eye"></i></button>
                                                            <button type="button" class="btn btn-info"><i
                                                                    class="fa fa-check-circle"></i></button>
                                                        </td>
                                                    </tr>
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

    <!-- Page-Level Scripts -->
    <script>
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
                        .column(5)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total filtered rows on the selected column (code part added)
                    var sumCol4Filtered = display.map(el => data[el][5]).reduce((a, b) => intVal(a) +
                        intVal(b), 0);

                    // Update footer
                    $(api.column(5).footer()).html(
                        'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                    );
                },
                buttons: []
            });

            revert_select();

            $(document).on('change', '#select_tipo_coti', function(event) {
                var nombre = $("#select_tipo_coti option:selected").val();
                // console.log(nombre);
                table.column(11).search(nombre).draw();
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
    </script>
@endsection
