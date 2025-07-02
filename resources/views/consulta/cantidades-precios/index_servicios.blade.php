@extends('layout')
@section('title', 'Consulta de Servicios')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')
@section('content')


<!-- Inico código Gaby -->
<div class="wrapper wrapper-content animated fadeInRight pb-0">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="row pt-3 d-flex justify-content-around align-content-center text-center">
                        <div class="col-auto">
                            <div><span id="sparkline5"></span></div>
                            <br><br>
                            <h4 class="text-danger">Productos: 34</h4>
                            <p>Stock mín: 10<br>Stock máx: 3</p>
                        </div>
                        <div class="col-auto">
                            <div><span id="sparkline6"></span></div>
                            <br><br>
                            <h4 class="text-warning">Servicios: 27</h4>
                            <p>Activos: 23<br>Inactivos: 4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight pt-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            @include('consulta\cantidades-precios\tabs')
                        </ul>

                        <!-- Buscar 1
                        <div class="d-flex justify-content-end row pt-3 border-left border-right border-secondary-subtle" style="margin-left: 0.1px; margin-right: 0.1px;">
                            <div class="col-auto">
                                <label for="inputBuscar" class="col-form-label">Buscar:</label>
                            </div>
                            <div class="col-5 input-group">
                                <input type="text" id="inputBuscar" class="form-control" >
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" style="background-color:blue; border-color:blue;"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>-->

                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane">
                            </div>

                            <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                <div class="panel-body table-responsive">

                                    <!-- Buscar -->
                                    <div class="row pt-3 pb-4 ">
                                        <div class="col-5 input-group ml-3">
                                            <input class="form-control" type="text" name="daterange" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                                    <i class="fa fa-history"></i>
                                                </button>
                                            </span>
                                            <span class="input-group-append">
                                            <button type="button" class="btn btn-primary" style="background-color:blue; border-color:blue;" onclick="limpiar_select()">
                                                <i class="fa fa-eraser"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <div class="col-7 d-flex justify-content-end row">
                                            <div class="col-auto">
                                                <label for="#search-servicio" class="col-form-label">Buscar:</label>
                                            </div>
                                            <div class="col-8 input-group">
                                                <input type="text" id="search-servicio" class="form-control" >
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary" style="background-color:blue; border-color:blue;"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CONTENIDO DENTRO DEL TAB  2 - Servicios -->
                                    <table class="table table-striped text-md-center dataTables-servicios">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Còdigo</th>
                                                <th>Precio Nac. Venta</th>
                                                <th>/IGV nac.</th>
                                                <th>Precio Ext. Venta</th>
                                                <th>/IGV ext.</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($servicio as $index => $servicios)
                                            <tr>
                                                <td>{{$servicios->nombre}}</td>
                                                <td>{{$servicios->codigo_original}}</td>
                                                <td>{{$moneda_nacional->simbolo}}. {{$precio_nacional[$index] }}</td>
                                                <td>{{$moneda_nacional->simbolo}}. {{round($precio_nacional[$index] + ($precio_nacional[$index] * ($igv->igv_total/100)),2)}}</td>
                                                <td>{{$moneda_extranjera->simbolo}}. {{$precio_extranjero[$index] }}</td>
                                                <td>{{$moneda_extranjera->simbolo}}. {{round($precio_extranjero[$index] + ($precio_extranjero[$index] * ($igv->igv_total/100)),2)}}</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-3" class="tab-pane">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin código Gaby -->



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <input type="text" class="form-control form-control-sm m-b-xs" id="filter"
                        placeholder="Buscar">
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="25" data-filter=#filter>
                            <thead>
                                <tr>
                                    <th data-toggle="true">Id</th>
                                    <th>Nombre del Servicio</th>
                                    <th>Codigo Orig.</th>
                                    <th>Precio Nac. Venta</th>
                                    <th>/I.G.V</th>
                                    <th>Precio Ex. Venta</th>
                                    <th>/I.G.V</th>
                                    <th data-hide="all" >Codigo Serv.</th>
                                    <th data-hide="all">Descripcion</th>
                                    <th data-hide="all">Marca</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($servicio as $index => $servicios)
                                @if($servicio_count == 0 )

                                @else
                                <tr class="gradeX">
                                    <td>{{$id_t1++}}</td>
                                    <td>
                                        <a href="{{ route('servicios.show', $servicios->id) }}" target="_blank">
                                            {{$servicios->nombre}}
                                        </a>
                                    </td>
                                    <td>{{$servicios->codigo_original}}</td>
                                    <td>{{$moneda_nacional->simbolo}}. {{$precio_nacional[$index] }}</td>
                                    <td>{{$moneda_nacional->simbolo}}. {{round($precio_nacional[$index] + ($precio_nacional[$index] * ($igv->igv_total/100)),2)}}</td>
                                    <td>{{$moneda_extranjera->simbolo}}. {{$precio_extranjero[$index] }}</td>
                                    <td>{{$moneda_extranjera->simbolo}}. {{round($precio_extranjero[$index] + ($precio_extranjero[$index] * ($igv->igv_total/100)),2)}}</td>
                                    <td>{{$servicios->codigo_servicio}}</td>
                                    <td>{{$servicios->descripcion}} </td>
                                    <td>{{$servicios->marca->nombre}}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #DataTables_Table_0_filter{
        display:none;
    }
    #DataTables_Table_0_length{
        display: none;
    }
    #DataTables_Table_1_filter{
        display:none;
    }
    #DataTables_Table_1_length{
        display: none;
    }
    div.dt-buttons{
        display: none;
    }
</style>


<style type="text/css">
    .footable > thead > tr > th.null > span.footable-sort-indicator{
        display: none;
        padding: 0px 0px 0px 0px;
    }
    .table-responsive{
        display: revert;
    }
    .form-table-input {
    background-image: none;
    border: 1px solid #e5e6e7;
    border-radius: 5px;
    background-color: #FFFFFF;
    color: inherit;
    /*display: block;*/
    padding: 3px 6px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100px;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    input[type=number] { -moz-appearance:textfield; }
</style>
<!-- Mainly scripts -->

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

<!-- Data picker -->
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

<script>
    $(document).ready(function() {

        $('.footable').footable();
        $('.footable3').footable();

    });

</script>

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
        table.column(4).search(`02-2025`).draw();
    }


</script>

<script>
    $(document).ready(function(){
        $('#tab-2-tab').addClass('active show');

        $('.dataTables-servicios').DataTable({
            pageLength: 15,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });

        //buscar Servicio
        $('#search-servicio').on('keyup',function(){
            $('.dataTables-servicios').DataTable().search(this.value).draw();
        });

        //
        $("#sparkline5").sparkline([10, 21, 3], {
            type: 'pie',
            height: '175px',
            sliceColors: ['#a14832', '#d4afa7', '#ffedab']});

        $("#sparkline6").sparkline([23, 4], {
            type: 'pie',
            height: '175px',
            sliceColors: ['#f2d8a0', '#d19d54']});

        $("#sparkline7").sparkline([5, 12, 7], {
            type: 'pie',
            height: '175px',
            sliceColors: ['#1ab394', '#b8c2d4', '#e4f0fb']});
    });
</script>

@endsection
