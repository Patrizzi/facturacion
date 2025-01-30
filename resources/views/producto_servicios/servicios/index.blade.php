@extends('layout')
@section('atributo_actu', 'hidden')
@section('title', 'Servicios')
@section('value_accion', 'Agregar')
@section('href_accion', route('servicios.create'))

@section('content')

<!--    <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                            <tr>
                                <th>COD. GENERAL</th> En comentario. No se muestra este dato
                                
                                <th>N° Registro</th>
                                <th>Código Servicio</th>
                                <th>Código Original</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Foto</th>
                                <th>Ver</th>
                                <th>Anular</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($servicios as $servicio)
                         <tr class="gradeX">
                            <td>{{$servicio->id}}</td>
                            <td>{{$servicio->codigo_servicio}}</td>
                            <td>{{$servicio->codigo_original}}</td>
                            <td>{{$servicio->nombre}}</td>
                            <td>SERVICIOS</td>
                            @if($servicio->estado_anular==1) <td>Anulado</td>
                            @else <td>Activo</td>@endif
                            <td>
                                @if($servicio->foto == "defecto.png" || $servicio->foto == "servicio.png" )
                                    <img src="{{ asset('/archivos/imagenes/servicios/servicio.png')}}" style="width: 45px;">
                                @else
                                    <img src="{{ asset('/archivos/imagenes/servicios/')}}/{{$servicio->foto}}" style="width: 45px;">
                                @endif
                            </td>
                            <td><center><a href="{{ route('servicios.show', $servicio->id) }}" target="_blank"><button type="button" class="btn btn-s-m btn-primary"><i class="fa fa-eye"></i></button></a></center></td>
                            <td>
                                <center>
                                    {{-- <input type="hidden" name="servicio_id" id="servicio_id" value="{{$servicio->id}}"> --}}
                                    <input type="hidden" name="servicio_nombre_{{$servicio->id}}" id="servicio_nombre_{{$servicio->id}}" value="{{$servicio->nombre}}"/>
                                    @if($servicio->estado_anular == 1)
                                    <button type="button" class="btn btn-s-m btn-secondary">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-s-m btn-danger" onclick="abrir_modal( {{$servicio->id}} )">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                    @endif
                                </center>
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

<div class="modal fade" id="servicio_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
        <div class="modal-content" >
            <div class="modal-body" style="padding: 0px;">
                <div class="ibox-content float-e-margins">
                        <h3 class="font-bold col-lg-12" align="center">
                            ¿Esta Seguro que Deseas Anular el Servicio:<br><span id="serv_nombre"> </span>? <br>
                            <h4 align="center"> <strong>Nota: Una vez Anulado no hay opción de devolver la acción </strong></h4>
                        </h3>
                    <p align="center">
                        <form action="{{ route('servicios.destroy')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id_servicio" id="serv_id_form" value="">
                            <center>
                                <button type="submit" class="btn btn-w-m btn-primary">Anular</button>
                            </center>
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<!--Inicio del código actual (14/11/2024)-->
<div class="wrapper wrapper-content animated fadeInRight pb-0">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
                <!--
                <div class="ibox-title">
                    <h4>Servicios</h4>
                </div>-->
                <div class="ibox-content align-content-center">
                    <div class="row d-flex justify-content-xl-around justify-content-md-around justify-content-lg-between text-center">

                        <div class="col-6"><!--
                            <div class="border border-primary rounded-circle d-flex justify-content-center align-items-cente circle-size">
                                <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                            </div>-->
                            <div class="d-flex align-items-center justify-content-center">
                                <div id="pie"></div><!--Azul, plomo y blanco-->
                            </div>
                            <br>
                            <a href="{{ route('productos.index') }}"><h4>Productos: 134</h4></a>
                            <p class="text-danger"><b>Total</b></p>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-center">
                                <div id="pie2"></div>
                            </div>
                            <br>
                            <a href="#"><h4>Servicios: 28</h4></a>
                            <p class="text-danger"><b>Total</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Servicio más pedido
        <div class="col-xl-4 col-lg-5">
            <div class="ibox">
                <div class="ibox-content  align-content-center cont-size">
                    <div class="row mx-md-1">
                        <div class="col-md-5 bg-success rounded-left border border-end d-flex justify-content-center align-items-center p-4">
                           <h3 class="text-center fs-4">SERVICIO MÁS PEDIDO</h3>
                        </div>
                        <div class="col-md-7 bg-success rounded-right border border-start d-flex justify-content-center align-items-center p-4">
                            <img src="..." class="rounded-4 img-size" alt="Router">
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
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
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: white; background-color: blue;" class="px-1">12</span> Servicios Activos

                                </a>
                            </li>
                            <li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-2"><span style="color: white; background-color: green;" class="px-1">3</span> Servicios Inactivos

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
                                    <table class="table table-striped text-md-center dataTables-servicios">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Código</th>
                                                <th>Código original</th>
                                                <th>Nombre</th>
                                                <th>Familia</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($servicios as $servicio)
                                                @if($servicio->estado_anular != 1) <!-- Activos -->
                                                <tr>
                                                    <td>{{$servicio->id}}</td>
                                                    <td>{{$servicio->codigo_servicio}}</td>
                                                    <td>{{$servicio->codigo_original}}</td>
                                                    <td>{{$servicio->nombre}}</td>
                                                    <td>{{$servicio->familia->descripcion}}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-info btn-s-m">
                                                            <i class="fa fa-check text-white"></i>
                                                        </button>

                                                        <a href="{{ route('servicios.show', $servicio->id) }}" target="_blank" class="btn btn-success btn-s-m">
                                                            <i class="fa fa-eye"></i>
                                                        </a>

                                                        <button type="button" class="btn btn-danger btn-s-m" onclick="abrir_modal({{ $servicio->id }})">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body table-responsive">
                                    <table class="table table-striped text-md-center dataTables-servicios2">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Código</th>
                                                <th>Código original</th>
                                                <th>Nombre</th>
                                                <th>Familia</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($servicios as $servicio)
                                                @if($servicio->estado_anular == 1) <!--Inactivos -->
                                                <tr>
                                                    <td>{{$servicio->id}}</td>
                                                    <td>{{$servicio->codigo_servicio}}</td>
                                                    <td>{{$servicio->codigo_original}}</td>
                                                    <td>{{$servicio->nombre}}</td>
                                                    <td>{{$servicio->familia->descripcion}}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-s-m">
                                                            <i class="fa fa-times"></i>
                                                        </button>

                                                        <a href="{{ route('servicios.show', $servicio->id) }}" target="_blank" class="btn btn-success btn-s-m">
                                                            <i class="fa fa-eye"></i>
                                                        </a>

                                                        <button type="button" class="btn btn-secondary btn-s-m">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endif
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

<style>
    .cont-size{
        min-height: 320px;
    }

    .img-size{
        min-height: 200px;
        min-width: 200px;
        max-height: 200px;
        max-width: 200px;
    }
    @media (max-width: 1440px){
        .img-size{
            min-height: 200px;
            min-width: 200px;
            max-height: 200px;
            max-width: 200px;
        }
        .cont-size{
            min-height: 320px;
        }
    }
    @media (max-width: 1024px){
        .img-size{
            min-height: 120px;
            min-width: 120px;
            max-height: 120px;
            max-width: 120px;
        }
    }
    @media (max-width: 768px){
        .cont-size{
            min-height: 200px;
        }
    }

</style>

<!--Fin del código actual-->


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

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });

        //Poner cantidad en vez de porcentaje-backend
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
                    ['Inactivos', 80],
                    ['data3', 80]
                ],
                colors:{
                    Activos: '#1ab394',
                    Inactivos: '#BABABA',
                    data3: '#b4e5de'
                },
                type : 'pie'
            }
        });
    });
    function abrir_modal(a){
        // var nomb_id = 'servicio_nombre_'+id;
        var nombre = document.getElementById(`servicio_nombre_${a}`).value;
        document.getElementById(`serv_nombre`).innerHTML = nombre;
        document.getElementById(`serv_id_form`).value = a;
        // console.log(nombre);

        $('#servicio_modal').modal('show');

    }
</script>

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
        /* Tamaño de los botones del index */
        .tam{
        min-width: 150px;
        min-height: 150px;*/
        }
</style>

<script>
    $(document).ready(function(){
        $('.dataTables-servicios').DataTable({
            pageLength: 16,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.dataTables-servicios2').DataTable({
            pageLength: 15,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>
@endsection
