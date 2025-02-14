@extends('layout')
@section('title', 'productos')
@section('atributo_actu', 'hidden')
@section('value_accion', 'Agregar')
@section('href_accion', route('productos.create'))
@section('content')

<!--Código actual 14/11/2024-->
<div class="wrapper wrapper-content animated fadeInRight pb-0">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content align-content-center">
                    <div class="row d-flex justify-content-around text-center">

                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-center">
                                <div id="pie"></div><!--Azul, plomo y blanco-->
                            </div>
                            <br>
                            <a href="#"><h4>Productos: 134</h4></a>
                            <p class="text-danger"><b>Total</b></p>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-center">
                                <div id="pie2"></div>
                            </div>
                            <br>
                            <a href="{{ route('servicios.index') }}"><h4>Servicios: 28</h4></a>
                            <p class="text-danger"><b>Total</b></p>
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
                            @include('producto_servicios\tabs2')
                        </ul>


                        <!-- Tablas y su contenido -->
                        <div class="tab-content">

                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB -->
                                    <table class="table table-striped text-md-center dataTables-example2" id="table_prodac" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <!--<th><input type="checkbox" checked class="i-checks" name="input[]"></th>-->
                                                <th>Item</th>
                                                <th>Nombre</th>
                                                <th>Código producto</th>
                                                <th>Código original</th>
                                                <th>Familia</th>
                                                <th>Marca</th>
                                                <th>Afectación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>

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
<!--/ Código Gaby-->


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

<!-- d3 and c3 charts -->
<script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
<script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>

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

        //Poner cantidad en vez de porcentaje - backend
        c3.generate({
            bindto: '#pie',
            data:{
                columns: [
                    ['Activos', 70],
                    ['Inactivos', 20],
                    ['Anulados', 10]
                ],
                colors:{
                    Activos: '#4d7ef7',
                    Inactivos: '#b3b3b3',
                    Anulados: '#e9e9e9'
                },
                type : 'pie'
            }
        });
        c3.generate({
            bindto: '#pie2',
            data:{
                columns: [
                    ['Activos', 60],
                    ['Inactivos', 80]
                ],
                colors:{
                    Activos: '#1ab394',
                    Inactivos: '#b4e5de'
                },
                type : 'pie'
            }
        });
    });

</script>

<script>
    $(document).ready(function(){
        $('#tab-1-tab').addClass('active show');

        $('#table_prodac').DataTable({
            "serverSide":true,
            "ajax":"{{url('api/productos')}}",
            "columns":[
            {data : 'prod_id'},
            {data : 'prod_nomnre'},
            {data : 'codigo_producto'},
            {data : 'codigo_original'},
            {data : 'familia_desc'},
            {data : 'nombre_marca'},
            {data : 'afectacion_info'},

            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';

                        // Botón del estado
                        actions += '<button type="button" class="btn btn-info">' +'<i class="fa fa-check"></i>'+ '</button>';

                        // Botón de "Ver producto"
                        actions += '<a class="px-3 href="{{ route('productos.show',':id') }}" target="_blank">' +
                                '<button type="button" class="btn btn-success">' +
                                '<i class="fa fa-eye"></i>' +
                                '</button></a>';

                        // Botón de "Anular producto" o acción deshabilitada
                        if (data.estado_anular == 1) {
                            actions += '<button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#:id">' +
                                    '<i class="fa fa-trash-o" aria-hidden="true"></i>' +
                                    '</button>' +
                                    '<div class="modal fade" id=":id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' +
                                    '<div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">' +
                                    '<div class="modal-content">' +
                                    '<div class="modal-body" style="padding: 0px;">' +
                                    '<div class="ibox-content float-e-margins">' +
                                    '<h3 class="font-bold col-lg-12" align="center">' +
                                    '¿Esta Seguro que Deseas Anular el Producto: :id"?<br>' +
                                    '<h4 align="center"><strong>Nota: Una vez Anulado no hay opción de devolver la acción</strong></h4>' +
                                    '</h3>' +
                                    '<p align="center">' +
                                    '<form action="{{ route('productos.destroy',':id')}}" method="POST">' +
                                    '@csrf @method('delete')'+
                                    '<center><button type="submit" class="btn btn-w-m btn-primary">Anular</button></form>' +
                                    '</p></div></div></div></div></div>';
                        } else {
                            actions += '<a href="#">' +
                                    '<span class="btn btn-secondary">' +
                                    '<i class="fa fa-times-circle" aria-hidden="true"></i>' +
                                    '</span></a>';
                        }

                        // Reemplazar ":id" con el valor real de data.prod_id
                        return actions.replace(/:id/g, data.prod_id);
                    }
                }
            ]
        });


    });

</script>

<script>
    $(document).ready(function(){
        $('#table_prodin').DataTable({
            "serverSide":true,
            "ajax":"{{url('api/productos-inactivo')}}",
            "columns":[
            {data : 'prod_id'},
            {data : 'prod_nomnre'},
            {data : 'codigo_producto'},
            {data : 'codigo_original'},
            {data : 'familia_desc'},
            {data : 'nombre_marca'},
            {data : 'afectacion_info'},

            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';

                        // Botón del estado
                        actions += '<button type="button" class="btn btn-danger">' +'<i class="fa fa-times"></i>'+ '</button>';

                        // Botón de "Ver producto"
                        actions += '<a  class="px-3" href="{{ route('productos.show',':id') }}" target="_blank">' +
                    '<button type="button" class="btn btn-success">' +
                                '<i class="fa fa-eye"></i>' +
                                '</button></a>';

                        // Botón de "Anular producto" o acción deshabilitada
                        if (data.estado_anular == 1) {
                            actions += '<button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#:id">' +
                                    '<i class="fa fa-trash-o" aria-hidden="true"></i>' +
                                    '</button>' +
                                    '<div class="modal fade" id=":id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' +
                                    '<div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">' +
                                    '<div class="modal-content">' +
                                    '<div class="modal-body" style="padding: 0px;">' +
                                    '<div class="ibox-content float-e-margins">' +
                                    '<h3 class="font-bold col-lg-12" align="center">' +
                                    '¿Esta Seguro que Deseas Anular el Producto: :id"?<br>' +
                                    '<h4 align="center"><strong>Nota: Una vez Anulado no hay opción de devolver la acción</strong></h4>' +
                                    '</h3>' +
                                    '<p align="center">' +
                                    '<form action="{{ route('productos.destroy',':id')}}" method="POST">' +
                                    '@csrf @method('delete')'+
                                    '<center><button type="submit" class="btn btn-w-m btn-primary">Anular</button></form>' +
                                    '</p></div></div></div></div></div>';
                        } else {
                            actions += '<a href="#">' +
                                    '<span class="btn btn-secondary">' +
                                    '<i class="fa fa-times-circle" aria-hidden="true"></i>' +
                                    '</span></a>';
                        }

                        // Reemplazar ":id" con el valor real de data.prod_id
                        return actions.replace(/:id/g, data.prod_id);
                    }
                }
            ]
        });


    });

</script>


<script>
    $(document).ready(function(){
        $('#table_prodan').DataTable({
            "serverSide":true,
            "ajax":"{{url('api/productos-anular')}}",
            "columns":[
            {data : 'prod_id'},
            {data : 'prod_nomnre'},
            {data : 'codigo_producto'},
            {data : 'codigo_original'},
             {data : 'familia_desc'},
            {data : 'nombre_marca'},
            {data : 'afectacion_info'},

            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';


                        // Botón de "Ver producto"
                        actions += '<a  class="px-3" href="{{ route('productos.show',':id') }}" target="_blank">' +
                                '<button type="button" class="btn btn-success">' +
                                '<i class="fa fa-eye"></i>' +
                                '</button></a>';

                        // Botón de "Anular producto" o acción deshabilitada
                        if (data.estado_anular == 1) {
                            actions += '<button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#:id">' +
                                    '<i class="fa fa-trash-o" aria-hidden="true"></i>' +
                                    '</button>' +
                                    '<div class="modal fade" id=":id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' +
                                    '<div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">' +
                                    '<div class="modal-content">' +
                                    '<div class="modal-body" style="padding: 0px;">' +
                                    '<div class="ibox-content float-e-margins">' +
                                    '<h3 class="font-bold col-lg-12" align="center">' +
                                    '¿Esta Seguro que Deseas Anular el Producto: :id"?<br>' +
                                    '<h4 align="center"><strong>Nota: Una vez Anulado no hay opción de devolver la acción</strong></h4>' +
                                    '</h3>' +
                                    '<p align="center">' +
                                    '<form action="{{ route('productos.destroy',':id')}}" method="POST">' +
                                    '@csrf @method('delete')'+
                                    '<center><button type="submit" class="btn btn-w-m btn-primary">Anular</button></form>' +
                                    '</p></div></div></div></div></div>';
                        } else {
                            actions += '<a href="#">' +
                                    '<span class="btn btn-secondary">' +
                                    '<i class="fa fa-times-circle" aria-hidden="true"></i>' +
                                    '</span></a>';
                        }

                        // Reemplazar ":id" con el valor real de data.prod_id
                        return actions.replace(/:id/g, data.prod_id);
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
