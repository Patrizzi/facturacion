@extends('layout')

@section('title', 'Cotización')
@section('atributo_actu', 'hidden')

@if ($conteo_almacen == 1)
    @section('value_accion', 'Agregar')
    @section('onclick1', 'Enviar_create()')
@else
    @section('atributo_1', 'hidden')
    @section('boton_opcional')
        @if ($user_login->name == 'Administrador')
            <span class="dropdown ">
                <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown">Agregar</button>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <span style="margin-left:12px;"><b>Almacenes:</b></span>
                    @foreach ($almacen as $almacens)
                        <li><a class="dropdown-item" onclick="alm_adm_{{ $almacens->id }}()">{{ $almacens->nombre }}</a></li>
                        <form action="{{ route('cotizacion.create_factura') }}" id="alm_adm_{{ $almacens->id }}"
                            enctype="multipart/form-data" method="post">
                            @csrf
                            <input type="text" value="{{ $almacens->id }}" hidden="hidden" name="almacen">
                        </form>
                        <script>
                            console.log({{ $almacens->id }});

                            function alm_adm_{{ $almacens->id }}() {
                                document.getElementById('alm_adm_{{ $almacens->id }}').submit();
                            }
                        </script>
                    @endforeach
                </ul>
            </span>
        @elseif($user_login->name == 'Colaborador')
            <button class="btn btn-primary" type="button" onclick="Enviar_create2()">Agregar</button>
        @endif
    @endsection
@endif

@section('content')
    <span hidden>
        <script>
            function Enviar_create() {
                document.getElementById('myform1').submit();
            }

            function Enviar_create2() {
                document.getElementById('myform2').submit();
            }
        </script>
        <form id="myform1" action="{{ route('cotizacion.create_factura') }}" enctype="multipart/form-data" method="post">
            @csrf
            <input type="text" value="{{ $almacen_primero->id }}" hidden="hidden" name="almacen">
        </form>
        <form id="myform2" action="{{ route('cotizacion.create_factura') }}" enctype="multipart/form-data"
            method="post">
            @csrf
            <input type="text" hidden="hidden" name="almacen" value="{{ $user_login->almacen_id }}">
        </form>
    </span>
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
            <a class="alert-link" href="#">
                @foreach ($errors->all() as $error)
                    <li class="error" style="color: red">{{ $error }}</li>
                @endforeach
            </a>
        </div>
    @endif

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                    <input class="form-control" type="text" name="daterange"
                                        value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                                            <i class="fa fa-eraser"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for=""><strong>Tipo de
                                            Cotizacion:</strong></label>
                                    <select class="form-control col-lg-8" name="" id="select_tipo_coti">
                                        <option value="">Todos los comprobantes</option>
                                        <option value="factura">Factura</option>
                                        <option value="boleta">Boleta</option>
                                        <option value="nota_venta">Nota de Venta</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example-facturacion">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>N° Cotización</th>
                                        <th>Ruc/DNI</th>
                                        <th>Cliente</th>
                                        <th>Fecha Emision</th>
                                        <th>Importe T.</th>
                                        <th>Ver</th>
                                        <th>Estado</th>
                                        <th>Estado Aprobado</th>
                                        <th>Creado por</th>
                                        <th style="display: none">Tipo de Cotizacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cotizacion as $cotizacions)
                                        <tr class="gradeX">
                                            <span hidden>{{ $subtotal = 0 }}</span>
                                            <td>{{ $cotizacions->id }}</td>
                                            <td>{{ $cotizacions->cod_cotizacion }}</td>
                                            <td>{{ $cotizacions->cliente->numero_documento }}</td>
                                            <td>{{ $cotizacions->cliente->nombre }}</td>
                                            <td>{{ $cotizacions->created_at }}</td>
                                            <span hidden>
                                                {{ $subtotal = $cotizacions->op_gravada + $cotizacions->op_inafecta + $cotizacions->op_exonerada }}
                                            </span>
                                            <td>{{ $cotizacions->moneda->simbolo }}
                                                {{ number_format(round($subtotal + ($cotizacions->op_gravada * $igv->renta) / 100, 2), 2) }}
                                            </td>
                                            <td>
                                                <center><a href="{{ route('cotizacion.show', $cotizacions->id) }}"><button
                                                            type="button" class="btn btn-primary"><i
                                                                class="fa fa-eye"></i></button></a></center>
                                            </td>
                                            <td>
                                                @if ($cotizacions->estado == '0')
                                                    <button type="button" class="btn btn-w-m btn-info">En Proceso</button>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-w-m btn-default">Procesado</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($cotizacions->estado_aprovar == '0')
                                                    <form action="{{ route('cotizacion.aprobar', $cotizacions->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('put')
                                                        <button type="submit" class="btn btn-w-m btn-info">Aprobar</button>
                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-w-m btn-default">Aprobado por <br>
                                                        @if ($cotizacions->aprobado->personal->nombres == auth()->user()->personal->nombres)
                                                            usted
                                                        @else
                                                            {{ $cotizacions->aprobado->personal->nombres }}
                                                        @endif
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($cotizacions->user_personal->personal->nombres == auth()->user()->personal->nombres)
                                                    Creado por usted
                                                @else
                                                    Creado por {{ $cotizacions->user_personal->personal->nombres }}
                                                @endif
                                            </td>
                                            <td style="display: none">
                                                {{ $cotizacions->tipo }}
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
    <style>
        .dropdown-menu {
            left: 70px;
            padding: 20px 0;
        }
        #DataTables_Table_0_wrapper{
            padding-right: 0px;
        }
        .table{
            width: 100% !important;
        }
        .ibox-content > .row{
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
                buttons: []
            });

            table.column(4).search(`{{ date('m-Y')}}`).draw();

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
        function limpiar_select(){
            table.column(4).search("").draw();
        }
    </script>
@endsection
