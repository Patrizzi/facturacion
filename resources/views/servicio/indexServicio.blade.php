@extends('layout')
@section('title', 'Cotizacion Manual Servicios')
@section('atributo_actu', 'hidden')
@section('href_accion', route('cotizacion_manual.create'))
{{-- @section('value_accion', 'Agregar') --}}

@section('content')
<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/ordenservicio.css') }}">

    @if ($errors->any())
        <div style="padding-top: 20px;">
            <div class="alert alert-danger">
                <a class="alert-link" href="#">
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </a>
            </div>
        </div>
    @endif

    {{-- obtener errores --}}
    @if (Session::has('successMsg'))
        <div style="padding-top: 20px;">
            <div class="alert alert-warning">
                <a class="alert-link" href="#">
                    <li style="color: black">{{ Session::get('successMsg') }}</li>
                </a>
            </div>
        </div>
    @endif

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                            @include('servicio._shared.second-tabs')
                            <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                <button class="btn btn-primary" id="btn-agregar-guia" data-toggle="modal" data-target="#productoModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </ul>
                        </ul>

                        <div class="tabs-content">
                            <div class="tab-pane active show" id="tab-2">
                                <br>
                                <div class="search-responsive" style="padding-right: 15px;padding-left: 15px;">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="daterange"
                                                            id="data_range_filter" value="" readonly="readonly" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary" id="revert_select">
                                                                <i class="fa fa-history"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <input type="search" class="form-control" placeholder="Buscar:"
                                                        id="search_all_column">
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                            <button type="button" class="btn btn-block btn-primary"
                                                        id="filter_buttons">Buscar
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Codigo de Cotizacion</th>
                                                <th>Cliente</th>
                                                <th>N°Documento</th>
                                                <th>Fecha Emi. </th>
                                                <th style="display: none"></th>
                                                <th>Importe T.</th>
                                                <th>Ver</th>
                                                <th>Estado</th>
                                                <th style="display: none">Tipo de Cotizacion</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($cotizacion as $cotizaciones)
                                                <tr class="gradeX">
                                                    <td>{{ $cotizaciones->id }}</td>
                                                    <td>{{ $cotizaciones->cod_cotizacion }}</td>
                                                    <td>{{ $cotizaciones->cliente->nombre }}</td>
                                                    <td>{{ $cotizaciones->cliente->numero_documento }}</td>
                                                    <td>{{ Carbon\Carbon::parse($cotizaciones->fecha_emision)->format('d-m-Y') }}
                                                    </td>
                                                    <span
                                                        hidden>{{ $subtotal = $cotizaciones->op_gravada + $cotizaciones->op_inafecta + $cotizaciones->op_exonerada }}
                                                    </span>
                                                    <span hidden>
                                                        @if ($cotizaciones->moneda_id == 2)
                                                            {{-- Dolares --}}
                                                            {{ $total = round($subtotal + ($cotizaciones->op_gravada * $igv->renta) / 100, 2) }}
                                                            {{ $total_conv = $total * $cotizaciones->cambio }}
                                                        @else
                                                            {{ $total = round($subtotal + ($cotizaciones->op_gravada * $igv->renta) / 100, 2) }}
                                                            {{ $total_conv = round($subtotal + ($cotizaciones->op_gravada * $igv->renta) / 100, 2) }}
                                                        @endif
                                                    </span>
                                                    <td style="display: none">
                                                        {{ $total_conv }}
                                                    </td>
                                                    <td>{{ $cotizaciones->moneda->simbolo }}
                                                        {{ number_format(round($subtotal + ($cotizaciones->op_gravada * $igv->renta) / 100, 2), 2) }}
                                                    </td>
                                                    {{-- Ver --}}
                                                    <td align="center">
                                                        {{-- <a href="{{ route('cotizacion_manual.show', $cotizaciones->id) }}">
                                                            <button type="button" class="btn btn-success"><i
                                                                    class="fa fa-eye"></i></button>
                                                        </a> --}}
                                                        <form
                                                            id="form-show-cotizacionm-{{ $cotizaciones->id }}"
                                                            action="{{ route('cotizacion_manual.show', $cotizaciones->id) }}"
                                                            method="GET"
                                                            style="display: none;"
                                                        >
                                                        </form>
                                                        <button
                                                            class="btn btn-primary"
                                                            onclick="verCotizacion({{ $cotizaciones->id }})"
                                                        >
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        @if ($cotizaciones->estado == '0')
                                                            <button type="button" class="btn btn-w-m btn-info">En Proceso</button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-w-m btn-default">Procesado</button>
                                                        @endif
                                                    </td>
                                                    <td style="display: none">
                                                        {{ $cotizaciones->tipo }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-right">Total General</th>
                                                <th colspan="4"></th>
                                            </tr>
                                        </tfoot>
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




    <style>
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

    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            var table2 = $('.dataTables-example').DataTable({
                pageLength: 25,
                order: [[0, "desc"]],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                 language: {
                    lengthMenu: "",
                    search: "",
                    info: "",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    }
                },
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

                    // Total filtered rows on the selected column
                    var sumCol4Filtered = display.map(el => data[el][5]).reduce((a, b) => intVal(a) +
                        intVal(b), 0);

                    // Update footer
                    $(api.column(5).footer()).html(
                        'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                    );
                },
            buttons: []
        });
        $('.dataTables_filter input').css('display', 'none');
        $('#tab-2').addClass('active');
        $('.scroll_content').slimscroll({
            height: '450px'
        });
        // Setup date range picker for main table only (table2)
        $('input[name="daterange"]').daterangepicker({
            "locale": {
                "separator": " | ",
                "applyLabel": "Guardar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                "monthNames": [
                    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
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
            table2.column(4).search(dateRangeString, true, false).draw();
        });

        // Type filter for main table
        $(document).on('change', '#select_tipo_coti', function(event) {
            var nombre = $("#select_tipo_coti option:selected").val();
            table2.column(9).search(nombre).draw();
        });

        // Set default filter for main table
        table2.column(4).search(`{{ date('m-Y') }}`).draw();

        // Global functions
        window.limpiar_select = function() {
            table2.column(4).search("").draw();
        };

        window.revert_select = function() {
            table2.column(4).search(`{{ date('m-Y') }}`).draw();
        };
    });
    </script>
<script>
    function mostrarSeccion(id, boton) {
        document.querySelectorAll('.ordencontenido').forEach(seccion => {
            seccion.classList.remove('activo');
        });

        document.getElementById(id).classList.add('activo');

        document.querySelectorAll('.ordenboton').forEach(b => {
            b.classList.remove('activo');
        });

        boton.classList.add('activo');
    }

    document.addEventListener("DOMContentLoaded", function () {
        let seccionActiva = document.querySelector(".ordencontenido.activo");
        if (!seccionActiva) {
            document.getElementById("seccion1").classList.add("activo");
        }
    });


    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector(".ordenboton").classList.add("activo");
    });

    function mostrarModalEditar(select) {
        if (select.value === "editar") {
            var modal = new bootstrap.Modal(document.getElementById('modalEditar'));
            modal.show();
            select.value = "Seleccione";
        }
    }

    function verCotizacion(cotizacionSMId) {
        const form = document.getElementById(`form-show-cotizacionm-${cotizacionSMId}`)
        if(form) {
            form.submit();
        }
    }
</script>

@endsection
@section('scripts')

@endsection
