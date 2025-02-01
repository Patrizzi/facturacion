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
                    <div class="row pt-3 d-flex justify-content-around justify-content-between align-content-center text-center">
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
                        <div class="col-auto">
                            <div><span id="sparkline7"></span></div>
                            <br><br>
                            <h4 class="text-success">Garantías: 40</h4>
                            <p>Activos: 23<br>Inactivos: 17</p>
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
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#"><span style="color: white; background-color: red;" class="px-1">34</span> Productos

                                </a>
                            </li>
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-2"><span style="color: white; background-color: orange;" class="px-1">27</span> Servicios

                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-3"><span style="color: white; background-color: blue;" class="px-1">40</span> Garantías

                                </a>
                            </li>
                        </ul>

                        <!-- Buscar -->
                        <div class="d-flex justify-content-end row pt-3 border-left border-right border-secondary-subtle" style="margin-left: 0.1px; margin-right: 0.1px;">
                            <div class="col-auto">
                                <label for="inputBuscar" class="col-form-label">Buscar:</label>
                            </div>
                            <div class="col-5 input-group">
                                <input type="text" id="inputBuscar" class="form-control" >
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>

                        <!-- Tablas y su contenido -->
                        <div class="tab-content">

                            <div role="tabpanel" id="tab-1" class="tab-pane">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB - Productos -->
                                    <table class="table table-striped text-md-center dataTables-productos">
                                        <thead>
                                            <tr>
                                                <th >Nombre</th>
                                                <th >Còdigo</th>
                                                <th >UdM</th>
                                                <th >Stock</th>
                                                <th>Stock mín.</th>
                                                <th>Stock máx.</th>
                                                <th>Precio Nac. Venta</th>
                                                <th>/IGV nac.</th>
                                                <th>Precio Ext. Venta</th>
                                                <th>/IGV ext.</th>
                                                <th>Garantía</th>
                                                <th>Marca</th>
                                                <th>Entradas</th>
                                                <th>Salidas</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            s
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane active show">
                                <div class="panel-body table-responsive">
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
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 - Garantía-->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th >Nombre</th>
                                                <th >Còdigo</th>
                                                <th >UdM</th>
                                                <th >Stock</th>
                                                <th>Stock mín.</th>
                                                <th>Stock máx.</th>
                                                <th>Precio Nac. Venta</th>
                                                <th>/IGV nac.</th>
                                                <th>Precio Ext. Venta</th>
                                                <th>/IGV ext.</th>
                                                <th>Entradas</th>
                                                <th>Salidas</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Caddy slim 2.9</td>
                                                <td>BA00-00000001</td>
                                                <td>UN</td>
                                                <td>150</td>
                                                <td>13</td>
                                                <td>145</td>
                                                <td>S/5.2</td>
                                                <td>S/6.4</td>
                                                <td>$1.4</td>
                                                <td>$1.65</td>
                                                <td>39</td>
                                                <td>47</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Caddy slim 2.9</td>
                                                <td>BA00-00000001</td>
                                                <td>UN</td>
                                                <td>150</td>
                                                <td>13</td>
                                                <td>145</td>
                                                <td>S/5.2</td>
                                                <td>S/6.4</td>
                                                <td>$1.4</td>
                                                <td>$1.65</td>
                                                <td>39</td>
                                                <td>47</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Caddy slim 2.9</td>
                                                <td>BA00-00000001</td>
                                                <td>UN</td>
                                                <td>150</td>
                                                <td>13</td>
                                                <td>145</td>
                                                <td>S/5.2</td>
                                                <td>S/6.4</td>
                                                <td>$1.4</td>
                                                <td>$1.65</td>
                                                <td>39</td>
                                                <td>47</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Caddy slim 2.9</td>
                                                <td>BA00-00000001</td>
                                                <td>UN</td>
                                                <td>150</td>
                                                <td>13</td>
                                                <td>145</td>
                                                <td>S/5.2</td>
                                                <td>S/6.4</td>
                                                <td>$1.4</td>
                                                <td>$1.65</td>
                                                <td>39</td>
                                                <td>47</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
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
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>


<script>
    $(document).ready(function() {

        $('.footable').footable();
        $('.footable3').footable();

    });

</script>

<script>
    $(document).ready(function(){
        $('.dataTables-servicios').DataTable({
            pageLength: 15,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });

        //
        $("#sparkline5").sparkline([10, 21, 3], {
            type: 'pie',
            height: '150px',
            sliceColors: ['#a14832', '#d4afa7', '#ffedab']});

        $("#sparkline6").sparkline([23, 4], {
            type: 'pie',
            height: '150px',
            sliceColors: ['#f2d8a0', '#d19d54']});

        $("#sparkline7").sparkline([5, 12, 7], {
            type: 'pie',
            height: '150px',
            sliceColors: ['#1ab394', '#b8c2d4', '#e4f0fb']});
    });
</script>

@endsection
