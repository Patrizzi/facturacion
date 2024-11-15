@extends('layout')
@section('title', 'productos')
@section('atributo_actu', 'hidden')
@section('value_accion', 'Agregar')
@section('href_accion', route('productos.create'))
@section('content')

<!--
<div class="wrapper wrapper-content animated fadeInRight">
    @if (session('anulacion'))
    <div class="alert alert-danger">
        {{ session('anulacion') }}
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example " id="table_prod">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Nombre</th>
                                    <th>Código Producto</th>
                                    <th>Código Original</th>
                                    {{-- <th>Familia</th> --}}
                                    <th>Marca</th>
                                    <th>Estado</th>
                                    <th>Afectación</th>
                                    <th>Foto</th>
                                    <th>Ver</th>
                                    <th>Anular</th>
                                </tr>
                            </thead>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
-->

<!--Código actual 14/11/2024-->
<div class="wrapper wrapper-content animated fadeInRight pb-0">
	<div class="row">
		<div class="col-lg-8">
            <div class="ibox ">
                <div class="ibox-title">
                    <!-- Acá iria el titulo -->
                    <h4>Productos</h4>
                </div>
                <div class="ibox-content align-content-center">
                    <div class="row d-flex justify-content-around px-4 text-center">

                        <div class="col-auto">
                            <div class="border border-primary rounded-circle d-flex justify-content-center align-items-cente circle-size">
                                <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                            </div><br>
                            <h4>Sin stock</h4>
                            <p>2 documentos</p>
                            <p class="text-danger"><b>Total</b></p>
                        </div>
                        <div class="col-auto">
                            <div class="border border-warning rounded-circle d-flex justify-content-center align-items-center circle-size">
                                <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                            </div><br>
                            <h4>Stock mínimo</h4>
                            <p>6 documentos</p>
                            <p class="text-danger"><b>Total</b></p>
                        </div>
                        <div class="col-auto">
                            <div class="border border-success rounded-circle d-flex justify-content-center align-items-center circle-size">
                                <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                            </div><br>
                            <h4>Stock mayor a 10</h4>
                            <p>4 documentos</p>
                            <p class="text-danger"><b>Total</b></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-content align-content-center">
                    <div class="row">
                        <div class="col-md-5 bg-success rounded-start-3 border border-end text-center d-flex justify-content-center align-items-center p-4 fs-4">PRODUCTO MÁS PEDIDO</div>
                        <div class="col-md-7 bg-success rounded-end-3 border border-start d-flex justify-content-center align-items-center p-4">
                            <img src="../Inspina/img/router2.jpeg" class="rounded-4 img-size" alt="Router">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Base para agregar el tab para el los contenidos-->

<div class="wrapper wrapper-content animated fadeInRight pt-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: white; background-color: blue;" class="px-1">2</span> Sin stock

                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-2"><span style="color: white; background-color: orange;" class="px-1">6</span> Stock mínimo

                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-3"><span style="color: white; background-color: green;" class="px-1">4</span> Stock mayor a 10

                                </a>
                            </li>
                            <li class="ml-auto align-content-center">
                                <div class="btn-group">
                                    <button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>
                                    <ul class="dropdown-menu">
                                        <p class="pl-3"><b>Almacenes:</b></p>
                                        <li><a class="dropdown-item" href="#">Oficina Arequipa</a></li>
                                        <li><a class="dropdown-item" href="#">Galería Centro Lima</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <div class="col-md-12 d-flex justify-content-md-start align-content-center row-cols-12">
                                    <div class="col-md-auto">
                                        <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                </div>
                            </li>
                            <!--
                            <li>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" type="button" class="btn btn-primary btn-sm mx-3"><i class="fa fa-cloud-download"></i></button>
                                    <ul class="dropdown-menu p-1">
                                        <li><a class="dropdown-item" href="#">PDF</a></li>
                                        <li><a class="dropdown-item" href="#">Excel</a></li>
                                        <li><a class="dropdown-item" href="#">Word</a></li>
                                        <li><a class="dropdown-item" href="#">CSV</a></li>
                                    </ul>
                                </div>
                            </li>-->
                        </ul>

                        <!-- Buscar
                        <div class="py-2 d-flex align-items-center row-cols-12 pt-4 border-left border-right border-secondary-subtle" style="margin-left: 0.1px; margin-right: 0.1px;">
                            <div class="col-md-7 d-flex justify-content-md-start row-cols-12 py-2">
                                <div class="col-md-auto">
                                    <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                </div>
                            </div>
                        </div>-->


                        <!-- Tablas y su contenido -->
                        <div class="tab-content">

                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                <th>Item</th>
                                                <th>Nombre</th>
                                                <th>Código producto</th>
                                                <th>Código original</th>
                                                <th>Marca</th>
                                                <th>Afectación</th>
                                                <th>Foto</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>1</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>2</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                <th>Item</th>
                                                <th>Nombre</th>
                                                <th>Código producto</th>
                                                <th>Código original</th>
                                                <th>Marca</th>
                                                <th>Afectación</th>
                                                <th>Foto</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>5</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>6</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>7</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>8</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>13</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>14</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                <th>Item</th>
                                                <th>Nombre</th>
                                                <th>Código producto</th>
                                                <th>Código original</th>
                                                <th>Marca</th>
                                                <th>Afectación</th>
                                                <th>Foto</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>9</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>10</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>11</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td><input type="checkbox" class="i-checks" name="input[]"></td>-->
                                                <td>12</td>
                                                <td>Antivirus Bitdefender Total Security 1PC</td>
                                                <td>BT-000001</td>
                                                <td>BT-000001</td>
                                                <td>Bitdefender</td>
                                                <td>Gravado-Operación Orenosa</td>
                                                <td></td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="" class="px-3"><i class="fa fa-trash text-danger"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="btn-group btn-group-toggle mt-4" data-toggle="buttons">
                            <label class="btn btn-sm btn-white ">
                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Anterior
                            </label>
                            <label class="btn btn-sm btn-white active">
                                <input type="radio" name="options" id="option2" autocomplete="off"> 1
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option3" autocomplete="off"> 2
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option4" autocomplete="off"> 3
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option5" autocomplete="off"> 4
                            </label>
                            <label class="btn btn-sm btn-white">
                                <input type="radio" name="options" id="option6" autocomplete="off"> Siguiente
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .img-size{
       min-height: 237px;
       min-width: 237px;
       max-height: 237px;
       max-width: 237px;
    }
    .circle-size{
        min-height: 110px;
        min-width: 110px;
    }
</style>
<!--Fin código actual-->



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

<script>
    $(document).ready(function(){
        $('#table_prod').DataTable({
            "serverSide":true,
            "ajax":"{{url('api/productos')}}",
            "columns":[
            {data : 'prod_id'},
            {data : 'prod_nomnre'},
            {data : 'codigo_producto'},
            {data : 'codigo_original'},
            // {data : 'familia_desc'},
            {data : 'nombre_marca'},
            {data : 'estado_nom'},
            {data : 'afectacion_info'},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var imagen_act = '';
                    imagen_act += '<img src="{{ asset('/archivos/imagenes/productos/')}}/:foto" style="width: 45px;" />';
                    return imagen_act.replace(/:foto/g, data.foto);
                }
            },
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<a href="{{ route('productos.show',':id') }}" target="_blank"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a>';
                    return actions.replace(/:id/g, data.prod_id);
                }
            },
            {
                data: null,
                name: '',
                sortable: false,
                searchable: false,
                render: function (data) {
                    if(data.estado_anular == 1){
                        data: null;
                        var actions = '';
                        actions +=
                        '<button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#:id"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
                        '<div class="modal fade" id=":id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
                        '<div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">'+
                        '<div class="modal-content" >'+
                        '<div class="modal-body" style="padding: 0px;">'+
                        '<div class="ibox-content float-e-margins">'+
                        '<h3 class="font-bold col-lg-12" align="center">'+
                        '¿Esta Seguro que Deseas Anular el Producto: :id".?<br>'+
                        '<h4 align="center"> <strong>Nota: Una vez Anulado no hay opción de devolver la acción </strong></h4>'+
                        '</h3><p align="center"><form action="{{ route('productos.destroy',':id')}}" method="POST">'+
                        '@csrf @method('delete')'+

                        '<center><button type="submit" class="btn btn-w-m btn-primary">Anular</button></form>'+
                        '</p></div></div></div></div></div>';
                        return actions.replace(/:id/g, data.prod_id);
                    }else{
                        var actions2 = '';
                        data: 'id';
                        actions2 += '<a href="#"><span class="btn btn-secondary" ><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>';
                        return actions2.replace(/:id/g, data.prod_id);
                    }

                }
            }
            ]
        });
    });

</script>





<!-- Page-Level Scripts


<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({

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

-->

@endsection
