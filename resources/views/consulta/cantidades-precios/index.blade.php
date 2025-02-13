@extends('layout')
@section('title', 'Consulta de Productos')
@section('breadcrumb', 'Consulta de Productos')
@section('breadcrumb2', 'Consulta de Productos')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Reabastecer')

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
                            @include('consulta\cantidades-precios\tabs')
                        </ul>

                        <!-- Buscar -->
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
                        </div>

                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
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
                                            @foreach($stock_producto->sortByDesc('updated_at') as $index => $stock_productos)
                                            <tr>
                                                <td>{{$stock_productos->producto->nombre}}</td>
                                                <td>{{$stock_productos->producto->codigo_producto}}</td>
                                                <td>UN</td>
                                                <td>150</td>
                                                <td>13</td>
                                                <td>145</td>
                                                <td>{{$moneda_nacional->simbolo}}. {{$precio_nacional[$index] }}</td>
                                                <td>{{$moneda_nacional->simbolo}}. {{round($precio_nacional[$index] + ($precio_nacional[$index] * ($igv->igv_total/100)),2)}}</td>
                                                <td>{{$moneda_extranjera->simbolo}}. {{$precio_extranjero[$index] }}</td>
                                                <td>{{$moneda_extranjera->simbolo}}. {{round($precio_extranjero[$index] + ($precio_extranjero[$index] * ($igv->igv_total/100)),2)}}</td>
                                                <td>{{$stock_productos->producto->garantia}} </td>
                                                <td>{{$stock_productos->producto->marcas_i_producto->nombre}}</td>
                                                <td>39</td>
                                                <td>47</td>
                                                <td class="tooltip-demo">
                                                    <a href="#" data-toggle="tooltip" data-placement="left" title="Stock mínimo"><i class="fa fa-caret-square-o-down text-danger"></i></a>
                                                    <a href="#" data-toggle="tooltip" data-placement="left" title="Stock promedio"><i class="fa fa-window-minimize text-primary"></i></a>
                                                    <a href="#" data-toggle="tooltip" data-placement="left" title="Stock máximo"><i class="fa fa-caret-square-o-up text-warning"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">

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



<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-form">
  <div class="modal-dialog modal-lg" style="width: 120%">
    <div class="modal-content" style="width: 120%">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Productos para Reabastecer </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <form action="{{route('cantidad_precio.store')}}" method="post" enctype="multipart/form-data">
             @csrf
            @method('post')
          <div class="modal-body" style="padding-bottom: 0px">
            <div class="table-responsive">
                <input type="hidden" value="{{ $i = 1 }}" name="" id="">
                <input type="text" class="form-control form-control-sm m-b-xs" id="filter2" placeholder="Buscar" onkeyup="display_check()" >
                <table class="footable3 table table-responsive toggle-arrow-tiny" data-page-size="10" data-filter=#filter2>
                    <thead >
                        <tr>
                            <a id="null" class="null" style="display:inline-block; ">
                                <div>
                                    <input style="position:absolute;display:block;margin-top: 15px;margin-left: 10px;" class='check_all' type='checkbox' onclick="select_all()" id="select_all_cheak" />
                                </div>
                            </a>
                            <th></th>
                            <th colspan="1" data-toggle="true" style="clear: right;text-align: end">Id</th>
                            <th>Producto</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th style="width: 100px">Stock Nuevo</th>
                            <th>Precio Nacional </th>
                            <th>Precio Extranjero </th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach($stock_producto as $index => $producto_min)
                        @if($producto_min->stock < $producto_min->producto->stock_minimo || $producto_min->stock == 0)
                        <tr class="gradeX">
                            <td><input type="checkbox" class="case" name="producto_id[]" id="producto_id{{$producto_min->id}}" value="{{$producto_min->id}}" onclick="mostrar_check()" d1|qq></td>
                            <td>{{$id_t2++}}</td>
                            <td>
                                <a href="{{ route('productos.show', $producto_min->producto_id) }}" target="_blank">
                                    {{$producto_min->producto->nombre}}
                                </a>
                            </td>
                            <td style="color: red">{{$producto_min->stock}}</td>
                            <td>{{$producto_min->producto->stock_minimo}}</td>
                            <td style="width: 100px">

                                <input type="number" class="form-table-input"  name="stock_nuevo[]" id="nuevo_stock{{$producto_min->id}}" disabled=""  >
                            </td>
                            <td>{{$moneda_nacional->simbolo}}. {{$precio_nacional[$index] }}</td>
                            <td>{{$moneda_extranjera->simbolo}}. {{$precio_extranjero[$index] }}</td>
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
          <div class="card-body d-flex justify-content-between align-items-center" style="padding-top: 5px;padding-bottom: 5px">
                <input class="btn btn-info" align="left"  id="miBoton" align="left" style="display: none" type="submit" value="PDF" />

                <input type="submit"  class="btn btn-secondary ml-auto" value="Cerrar" data-dismiss="modal"/>
            </div>
        </form>
       {{-- <div class="modal-footer"> --}}
        {{-- <div class="row"> --}}

        {{-- </div> --}}
      {{-- </div> --}}
    </div>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Cantidades y Precios de Productos</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <input type="text" class="form-control form-control-sm m-b-xs" id="filter"
                        placeholder="Buscar">
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="25" data-filter=#filter>
                            <thead>
                                <tr>
                                    <th data-toggle="true">Id</th>
                                    <th>Nombre de Produto</th>
                                    <th>Codigo Orig.</th>
                                    <th>Stock</th>
                                    <th>Precio Nac. Venta</th>
                                    <th>/I.G.V</th>
                                    <th>Precio Ex. Venta</th>
                                    <th>/I.G.V</th>
                                    <th data-hide="all" >Codigo Prod.</th>
                                    <th data-hide="all">Descripcion</th>
                                    <th data-hide="all">Garantia</th>
                                    <th data-hide="all">Marca</th>
                                </tr>
                            </thead>
                            <tbody>

                             @foreach($stock_producto->sortByDesc('updated_at') as $index => $stock_productos)
                                @if($producto_count == 0 )

                                @else
                                <tr class="gradeX">
                                    <td>{{$id_t1++}}</td>
                                    <td>
                                        <a href="{{ route('productos.show', $stock_productos->producto_id) }}" target="_blank">
                                            {{$stock_productos->producto->nombre}}
                                        </a>
                                    </td>
                                    <td >{{$stock_productos->producto->codigo_original}}</td>
                                    @if($stock_productos->stock > 0)
                                        <td>{{$stock_productos->stock}}</td>

                                    {{-- data-all --}}
                                    @else
                                        <td style="color: red">SIN STOCK</td>

                                    @endif

                                    <td>{{$moneda_nacional->simbolo}}. {{$precio_nacional[$index] }}</td>
                                    <td>{{$moneda_nacional->simbolo}}. {{round($precio_nacional[$index] + ($precio_nacional[$index] * ($igv->igv_total/100)),2)}}</td>
                                    <td>{{$moneda_extranjera->simbolo}}. {{$precio_extranjero[$index] }}</td>
                                    <td>{{$moneda_extranjera->simbolo}}. {{round($precio_extranjero[$index] + ($precio_extranjero[$index] * ($igv->igv_total/100)),2)}}</td>
                                    <td >{{$stock_productos->producto->codigo_producto}}</td>
                                    <td>{{$stock_productos->producto->descripcion}} </td>
                                    <td>{{$stock_productos->producto->garantia}} </td>
                                    <td>{{$stock_productos->producto->marcas_i_producto->nombre}}</td>

                                    {{-- data-all --}}

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

<!--
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
-->
<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>


<!-- Page-Level Scripts -->
<script>
    function myFunction() {
        var element = document.getElementById("null footable-sortable");
        element.classList.remove("null footable-sort-indicator");
    }
    function mostrar_check() {
        var arr = $('[name="producto_id[]"]:checked').map(function(){
          return this.value;
        }).get();
        if(arr.length == 0){
            $('#miBoton').hide();
            $('input[type=number]').attr('disabled','true');
            $('input[type=number]').val('');
        }else{

            for (var i = 0 ; i < arr.length; i++) {
                $('#miBoton').show();
                $('#nuevo_stock'+arr[i]).prop('disabled', false);
            };

        }
        var arr2 = $('[name="producto_id[]"]:not(:checked)').map(function(){
          return this.value;
        }).get();
        // console.log(arr2);
        if(arr2.length == 0){
            // $('#miBoton').hide();
            // $('input[type=number]').attr('disabled','true');
            // $('input[type=number]').val('');
        }else{
            for (var i = 0 ; i < arr2.length; i++) {
                // $('#miBoton').hide();
                $('#nuevo_stock'+arr2[i]).prop('disabled', true);
                $('#nuevo_stock'+arr2[i]).prop('value', '');
            };

        }
    }
    function display_check(){
        //Siempre que salgamos de un campo de texto, se chequeará esta función
        // $('#filter2').keyup(function() {
             if($('#filter2').val().length > 0) {
                $('#select_all_cheak').attr('disabled', true);
            }else{
                $('#select_all_cheak').attr('disabled', false);
            }

        // });

    };

</script>
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},

            {extend: 'print',
            customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');

                $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
            }
        }
        ]

    });

    });

</script>
<script>
    $(document).ready(function() {

        $('.footable').footable();
        $('.footable3').footable();

    });

</script>
<script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
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
<script>
    function select_all() {
        $('input[class=case]:checkbox').each(function () {
            if ($('input[class=check_all]:checkbox:checked').length == 0) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }

            var elementos = $('input.check_all');
            var algunoMarcado = elementos.toArray().find(function(elemento) {
             return $(elemento).prop('checked');
            });

          if(algunoMarcado) {
            $('#miBoton').show();
          } else {
            $('#miBoton').hide();
          }

          var arr = $('[name="producto_id[]"]:checked').map(function(){
            return this.value;
            }).get();
            if(arr.length == 0){
                $('#miBoton').hide();
                $('input[type=number]').attr('disabled',true);
                $('input[type=number]').val('');
            }else{
                for (var i = 0 ; i < arr.length; i++) {
                    $('#miBoton').show();
                    $('#nuevo_stock'+arr[i]).prop('disabled', false);
                };
            }
        });


    }
</script>


<script>
    $(document).ready(function(){
        $('#tab-1-tab').addClass('active show');

        $('.dataTables-productos').DataTable({
            pageLength: 15,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

@endsection
