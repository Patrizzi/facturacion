@extends('layout')

@section('title', 'Garantia')
@section('breadcrumb', 'Guia de ingreso')
@section('breadcrumb2', 'Garantia')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/index.css') }}">
<!-- modal -->
<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Agregar</h3>
                        <p>Selecciona marca a agregar</p>
                        <form action="{{ route('garantia_guia_ingreso.create')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Marca:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control m-b" name="marca">
                                            @foreach($marcas as $marca)
                                            <option value="{{$marca->id}}" >{{$marca->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Grabar</strong></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight pb-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title" style="display: flex; align-items: center;">
                    <span>RESUMEN DE SEPTIEMBRE DEL 2024</span>
                </div>

                <div class="ibox-content">
                    {{-- Acá iria el tema del contenido --}}
                    <div class="card-group">
                        <div class="card p-3" style="border: none;">
                            <div class="d-flex justify-content-center align-items-center card-img-top">
                                <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 3rem;">
                                    <i class="bi bi-cloud-arrow-down-fill text-white"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" style="font-size: 18px">Guia de Ingreso</h5>
                                <p class="card-text" style="font-size: 14px">5 Documentos</p>
                                <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                        <div class="card p-3" style="border: none;">
                            <div class="d-flex justify-content-center align-items-center card-img-top">
                                <div class="bg-success rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 3rem;">
                                    <i class="bi bi-cloud-check-fill text-white"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" style="font-size: 18px">Guia de Egreso</h5>
                                <p class="card-text" style="font-size: 14px">3 Documentos</p>
                                <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                        <div class="card p-3" style="border: none;">
                            <div class="d-flex justify-content-center align-items-center card-img-top">
                                <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 80px; height: 80px; font-size: 3rem;">
                                    <i class="bi bi-clipboard2-data-fill text-white"></i>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" style="font-size: 18px">Guia de Informe Tecnico</h5>
                                <p class="card-text" style="font-size: 14px">8 Documentos</p>
                                <p class="card-text"><small class="text-body-secondary" style="font-size: 12px">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight pt-0">
    @if (session('repite'))
    <div class="alert alert-danger">
        {{ session('repite') }}
    </div>
    @endif
    @if($errors->any())
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


    <!--Base para agregar el tab para el los contenidos-->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <!--
                            <ul class="nav nav-underline">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">
                                        <span class=" badge badge-pill badge-success">1</span> Guia de ingreso
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span class=" badge badge-pill badge-warning">2</span> Guia de egreso
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <span class=" badge badge-pill badge-warning">3 </span> Informe Técnico
                                    </a>
                                </li>
                            </ul>
                        -->
                        <ul class="nav nav-tabs d-flex justify-content-between align-items-center" role="tablist">
                            @include('transaccion\garantias\tabs')
                        </ul>

                        <div class="tab-content">
                            <div class="d-flex justify-content-md-start row mx-3 mt-4">
                                <div class="input-group col-md-4 mx-5">
                                    <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                    <input class="form-control" type="text" name="daterange2"
                                        value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                            <i class="fa fa-history"></i>
                                        </button>
                                    </span>
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                                            <i class="fa fa-eraser"></i>
                                        </button>
                                    </span>
                                </div>

                                <div class="row g-3 col-md-5">
                                    <div class="col-auto">
                                        <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  1-->
                                    <div class="table-responsive">
                                        <table class="table table-striped dataTables-example2">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <th>ID</th>
                                                    <th>Orden Servicio</th>
                                                    <th>Marca</th>
                                                    <th>Fecha</th>
                                                    <th>Motivo</th>
                                                    <th>Asuntos</th>
                                                    <th>Cliente</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($garantias_guias_ingresos as $garantias_guias_ingreso)
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <td>{{$garantias_guias_ingreso->id}} </td>
                                                    <td>{{$garantias_guias_ingreso->orden_servicio}}</td>
                                                    <td>{{$garantias_guias_ingreso->marcas_i->nombre}}</td>
                                                    <td>{{$garantias_guias_ingreso->fecha}} </td>
                                                    <td>{{$garantias_guias_ingreso->motivo}}</td>
                                                    <td>{{$garantias_guias_ingreso->asunto}} </td>
                                                    <td>{{$garantias_guias_ingreso->clientes_i->nombre}} / {{$garantias_guias_ingreso->clientes_i->empresa}}</td>
                                                    <td class="d-flex justify-content-between">
                                                        <a href="{{ route('garantia_guia_ingreso.show', $garantias_guias_ingreso->id) }}">
                                                            <button type="button" class="btn btn-primary"><i class="fa fa-eye" style="color:white;"></i></button>
                                                        </a>

                                                        @if($garantias_guias_ingreso->estado==1)
                                                            <button class="btn btn-info" style="border-color: #28a745; background-color:#28a745;">
                                                                <i class="fa fa-check" style="color:white;"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    {{-- CONTENIDO DENTRO DEL TAB  2 --}}
                                </div>
                            </div>
                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    {{-- CONTENIDO DENTRO DEL TAB  3 --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="table-responsive">

                                <table class="table table-striped table-bordered table-hover dataTables-example" id="table_productos" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Orden servicio</th>
                                            <th>Marca</th>
                                            <th>fecha</th>
                                            <th>Motivo</th>
                                            <th>Asunto</th>
                                            <th>Cliente</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div> --}}

<div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab-1">Guias de Ingreso</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-2">Guia de Egreso</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-3">Informe Tecnico</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-4">Solicitud de Servicio</a>
                                </li>
                            </ul>
                            <br>
                            <div class="tab-content">
                                <!-- Contenido de Tab 1 -->
                                <div role="tabpanel" id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <!-- Contenido de Nested Tab 1 -->
                                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                            <!-- Barra de búsqueda y botón Buscar -->
                                            <div style="flex-grow: 1;">
                                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                            </div>
                                            <!-- Botones Agregar, Actualizar y Descarga -->
                                            <div>
                                                <button class="btn btn-success" style="margin-right: 10px;">Agregar</button>
                                                <button class="btn btn-primary" style="margin-right: 10px;">Actualizar</button>
                                                <!-- Botón de Descarga con menú desplegable -->
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Descarga
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Copy</a>
                                                        <a class="dropdown-item" href="#">CSV</a>
                                                        <a class="dropdown-item" href="#">Excel</a>
                                                        <a class="dropdown-item" href="#">PDF</a>
                                                        <a class="dropdown-item" href="#">Print</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID </th>
                                                        <th>NOMBRE </th>
                                                        <th>APELLIDO </th>
                                                        <th>N° DOCUMENTO</th>
                                                        <th>CELULAR</th>
                                                        <th>CORREO</th>
                                                        <td>ACCIONES</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="checkbox" checked class="i-checks" name="input[]"></td>
                                                        <td>01</td>
                                                        <td>Carlos Daniel</td>
                                                        <td>Roman Berru</td>
                                                        <td>73588510</td>
                                                        <td>936292675</td>
                                                        <td>danielrberru@gmail.com</td>
                                                        <td>
                                                            <div>
                                                                <a href="#" class="check-link" style="font-size: 25px;"><i class="fa fa-check-square"></i></a>
                                                                <button class="btn btn-xs btn-primary  toggle-row"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- Fila oculta -->
                                                    <tr class="details-row" style="display: none;">
                                                        <td colspan="8">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <!-- Primera columna - Cliente -->
                                                                    <div class="col-6 pe-3">
                                                                        <p class="text-white text-center fw-bold p-2" style="background-color: #007bff;">CLIENTE</p>
                                                                        <div class="row mb-1 align-items-center">
                                                                            <label class="col-2 col-form-label text-start pe-1">DNI</label>
                                                                            <div class="col-3"><input type="text" class="form-control form-control-sm"></div>
                                                                            <label class="col-2 col-form-label text-start pe-1">Nombre</label>
                                                                            <div class="col-5"><input type="text" class="form-control form-control-sm"></div>
                                                                        </div>
                                                                        <div class="row mb-1 align-items-center">
                                                                            <label class="col-2 col-form-label text-start pe-1">Dirección</label>
                                                                            <div class="col-10"><input type="text" class="form-control form-control-sm"></div>
                                                                        </div>
                                                                        <div class="row mb-1 align-items-center">
                                                                            <label class="col-2 col-form-label text-start pe-1">Contacto</label>
                                                                            <div class="col-3"><input type="text" class="form-control form-control-sm"></div>
                                                                            <label class="col-2 col-form-label text-start pe-1">Teléfono</label>
                                                                            <div class="col-5"><input type="text" class="form-control form-control-sm"></div>
                                                                        </div>
                                                                        <div class="row mb-1 align-items-center">
                                                                            <label class="col-2 col-form-label text-start pe-1">Sucursal</label>
                                                                            <div class="col-10"><input type="text" class="form-control form-control-sm"></div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Segunda columna - Datos Generales -->
                                                                    <div class="col-6 ps-3">
                                                                        <p class="text-white text-center fw-bold p-2" style="background-color: #007bff;">DATOS GENERALES</p>
                                                                        <div class="row mb-1 align-items-center">
                                                                            <label class="col-3 col-form-label text-start pe-1">Recepcionista</label>
                                                                            <div class="col-3"><input type="text" class="form-control form-control-sm"></div>
                                                                            <label class="col-3 col-form-label text-start pe-1">Fecha de ingreso</label>
                                                                            <div class="col-3"><input type="date" class="form-control form-control-sm"></div>
                                                                        </div>
                                                                        <div class="row mb-1 align-items-center">
                                                                            <label class="col-3 col-form-label text-start pe-1">Orden de servicio</label>
                                                                            <div class="col-3"><input type="text" class="form-control form-control-sm"></div>
                                                                            <label class="col-3 col-form-label text-start pe-1">Fecha estimada</label>
                                                                            <div class="col-3"><input type="date" class="form-control form-control-sm"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Segunda fila vacía -->
                                                                <div class="row mt-3">
                                                                    <div class="col-12 text-center">
                                                                        <div class="panel-body">
                                                                            <div class="search-bar d-flex justify-content-between align-items-center mb-3">
                                                                                <div class="flex-grow-1">
                                                                                    <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                                                    <button class="btn btn-primary ms-2">Buscar</button>
                                                                                </div>
                                                                                <div>
                                                                                    <button class="btn btn-success me-2">Agregar</button>
                                                                                    <button class="btn btn-primary me-2">Actualizar</button>
                                                                                    <div class="btn-group">
                                                                                        <button class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">Descarga</button>
                                                                                        <ul class="dropdown-menu">
                                                                                            <li><a class="dropdown-item" href="#">Copy</a></li>
                                                                                            <li><a class="dropdown-item" href="#">CSV</a></li>
                                                                                            <li><a class="dropdown-item" href="#">Excel</a></li>
                                                                                            <li><a class="dropdown-item" href="#">PDF</a></li>
                                                                                            <li><a class="dropdown-item" href="#">Print</a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="table-responsive">
                                                                                <table class="table table-striped table-bordered w-100">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>ID</th>
                                                                                            <th>SERIE</th>
                                                                                            <th>DESCRIPCION</th>
                                                                                            <th>OBSERVACION</th>
                                                                                            <th>TEC. REVISION</th>
                                                                                            <th>FECHA</th>
                                                                                            <th>DIAGNOSTICO</th>
                                                                                            <th>ESTADO</th>
                                                                                            <th>TEC. REPARAR</th>
                                                                                            <th>FECHA</th>
                                                                                            <th>EST. REPARACION</th>
                                                                                            <th>RECOMENDACIONES</th>
                                                                                            <th>Edit</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>01</td>
                                                                                            <td>LKDO</td>
                                                                                            <td>Laptop mojada</td>
                                                                                            <td>El tecnico observo agua en el equipo</td>
                                                                                            <td>Marlo</td>
                                                                                            <td>hoy</td>
                                                                                            <td>Equipo mojado</td>
                                                                                            <td>Aceptado</td>
                                                                                            <td>NULL</td>
                                                                                            <td>NULL</td>
                                                                                            <td>NULL</td>
                                                                                            <td>NULL</td>
                                                                                            <td>
                                                                                                <div>
                                                                                                    <button class="btn btn-xs btn-primary  toggle-row"><i class="fa fa-plus"></i></button>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <!-- Fila oculta -->
                                                                                        <tr class="details-row" style="display: none;">
                                                                                            <td colspan="8">
                                                                                                <div class="update-servicio-content">

                                                                                                    <div class="row mb-3 first-fila-service-content">
                                                                                                        <div class="input-diagnostico-content sevice-col">
                                                                                                            <label>Diagnóstico</label>
                                                                                                            <input type="text" class="form-control form-control-sm"/>
                                                                                                        </div>
                                                                                                        <div class="select-estado-content sevice-col">
                                                                                                            <label>Estado</label>
                                                                                                            <select id="" class="form-control form-control-sm">
                                                                                                                <option value="1">Aceptado</option>
                                                                                                                <option value="2">Rechazado</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <div class="input-reparar-content sevice-col">
                                                                                                            <label>Tec. Reparar</label>
                                                                                                            <input type="text" value="{{ auth()->user()->name }}" class="form-control form-control-sm" readonly/>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="row mb-3 second-fila-service-content">
                                                                                                        <div class="input-reparacion-content sevice-col">
                                                                                                            <label>Est. Reparación</label>
                                                                                                            <input type="text" value="NULL" class="form-control form-control-sm" readonly/>
                                                                                                        </div>

                                                                                                        <div class="text-recomendaciones-content sevice-col">
                                                                                                            <label>Recomendaciones</label>
                                                                                                            <textarea type="text" class="recomendaciones-service form-control form-control-sm" >.......</textarea>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>02</td>
                                                                                            <td>MJYL</td>
                                                                                            <td>Monitor con mancha</td>
                                                                                            <td>El tecnico obervo varias fallas</td>
                                                                                            <td>Brissssssila</td>
                                                                                            <td>hoy</td>
                                                                                            <td>Equipo dañado</td>
                                                                                            <td>Rechazado</td>
                                                                                            <td>NULL</td>
                                                                                            <td>NULL</td>
                                                                                            <td>NULL</td>
                                                                                            <td>NULL</td>
                                                                                            <td>sdawd</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>03</td>
                                                                                            <td>FYUL</td>
                                                                                            <td>trx 3060</td>
                                                                                            <td>Tecnico observo ventilacion rota</td>
                                                                                            <td>Daniel</td>
                                                                                            <td>hoy</td>
                                                                                            <td>Equipo dañado</td>
                                                                                            <td>Rechazado</td>
                                                                                            <td>NULL</td>
                                                                                            <td>NULL</td>
                                                                                            <td>NULL</td>
                                                                                            <td>NULL</td>
                                                                                            <td>sdawd</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" checked class="i-checks" name="input[]"></td>
                                                        <td>02</td>
                                                        <td>Christopher Javier</td>
                                                        <td>Huaman Guevara</td>
                                                        <td>74894537</td>
                                                        <td>934361536</td>
                                                        <td>christojhg@gmail.com</td>
                                                        <td>
                                                            <div>
                                                                <a href="#" class="check-link" style="font-size: 25px;"><i class="fa fa-check-square"></i></a>
                                                                <button class="btn btn-xs btn-primary  toggle-row"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- Fila oculta -->
                                                    <tr class="details-row" style="display: none;">
                                                        <td colspan="8">
                                                            <div style="display: flex;">
                                                                <!-- Columna 1: Imagen -->
                                                                <div style="flex: 4; padding: 10px; text-align: center;">
                                                                    <img src="https://via.placeholder.com/100" alt="Foto" style="max-width: 100%; height: auto;">
                                                                </div>
                                                                <!-- Columna 2: Datos -->
                                                                <div style="flex: 8; padding: 10px;">
                                                                    <table class="table table-bordered">
                                                                        <tr>
                                                                            <th>Detalle 1</th>
                                                                            <td>Valor 1</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Detalle 2</th>
                                                                            <td>Valor 2</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Detalle 3</th>
                                                                            <td>Valor 3</td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <br>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                                            <button class="btn btn-white">1</button>
                                            <button class="btn btn-white  active">2</button>
                                            <button class="btn btn-white">3</button>
                                            <button class="btn btn-white">4</button>
                                            <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenido de Tab 2 -->
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                   <div class="row">
                                    <div class="col-lg-12">
                                        <div class="ibox ">
                                            <div class="ibox-content">
                                                <div >
                                                    <table class="table table-striped table-bordered table-hover dataTables-example" id="table_egreso" style="width: 100%;" >
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Orden servicio</th>
                                                                <th>Marca</th>
                                                                <th>fecha</th>
                                                                <th>Motivo</th>
                                                                <th>Asunto</th>
                                                                <th>Cliente</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                </div>
                                <!-- Contenido de Tab 3 -->
                                <div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <!-- CONTENIDO DENTRO DEL TAB 3 -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="ibox ">
                                            <div class="ibox-content">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover dataTables-example" id="table_informe_tec" style="width: 100%;">

                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Orden servicio</th>
                                                                <th>Marca</th>
                                                                <th>fecha</th>
                                                                <th>Motivo</th>
                                                                <th>Asunto</th>
                                                                <th>Cliente</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <!-- Contenido de Tab 4 -->
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <!-- CONTENIDO DENTRO DEL TAB 4 -->
                                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                            <!-- Barra de búsqueda y botón Buscar -->
                                            <div style="flex-grow: 1;">
                                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                            </div>
                                            <!-- Botones Agregar, Actualizar y Descarga -->
                                            <div>
                                                <button class="btn btn-success" style="margin-right: 10px;">Agregar</button>
                                                <button class="btn btn-primary" style="margin-right: 10px;">Actualizar</button>
                                                <!-- Botón de Descarga con menú desplegable -->
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Descarga
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Copy</a>
                                                        <a class="dropdown-item" href="#">CSV</a>
                                                        <a class="dropdown-item" href="#">Excel</a>
                                                        <a class="dropdown-item" href="#">PDF</a>
                                                        <a class="dropdown-item" href="#">Print</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>ID </th>
                                                    <th>Nº GUIA </th>
                                                    <th>T. SERVICIO </th>
                                                    <th>RUC/DNI</th>
                                                    <th>CLIENTE</th>
                                                    <th>F. EMISION</th>
                                                    <td>ACCIONES</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                                    <td>01</td>
                                                    <td>GE001-00000001</td>
                                                    <td>COMPRAS LOCALES</td>
                                                    <td>72816344</td>
                                                    <td>INVERSIONAES MC</td>
                                                    <td>29/15/2025</td>
                                                    <td>
                                                        <div>
                                                            <button style="padding: 5px 5px; background-color: #007bff;border: none; border-radius: 5px;">
                                                                <div class="infont col-md-3 col-sm-4"><a href="#"><i class="fa fa-eye" style="color: white; font-size: 20px;"></i></a></div>
                                                            </button>
                                                            <button style="padding: 5PX 5px; background-color: RED; border: none; border-radius: 5px;">
                                                                <div class="infont col-md-3 col-sm-4"><a href="#"><i class="fa fa-trash-o" style="color: white; font-size: 20px;"></i></a></div>
                                                            </button>
                                                        </div>
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

<!-- check -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>

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

<script>
    $(document).ready(function(){
        $('#tab-1').addClass('active show');

        table = $('.dataTables-example2').DataTable({
            pageLength: 8,
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
        $('input[name="daterange2"]').daterangepicker({

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
                    table2.column(4).search(dateRangeString, true, false).draw();
                }
            );
        });
        function limpiar_select(){
            table2.column(4).search("").draw();
        }
        function revert_select() {
            table2.column(4).search(`{{ date('m-Y') }}`).draw();
        }
</script>
{{--
<script >
    $(document).ready(function(){
        $('#table_productos').DataTable({
        // "order": [[ 1, "desc" ]],
        "serverSide":true,
        "ajax":"{{url('api/garantia_ingreso')}}",
        "columns":[
        {data : 'gar_ing_id'},
        {data : 'orden_servicio'},
        {data : 'nombre_marca'},
        {data : 'fecha'},
        {data : 'motivo'},
        {data : 'asunto'},
        {data : 'cliente_nom',},
        {
            name: '',
            data: null,
            sortable: false,
            searchable: false,
            render: function (data) {
                var actions = '';
                actions += '<center><a href="{{ route('garantia_guia_ingreso.show', ':id') }}"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a></center>';
                return actions.replace(/:id/g, data.gar_ing_id);
            }
        },
        {
            // data: 'anulacion'
            name: '',
            data: null,
            sortable: false,
            searchable: false,
            render: function (data) {
                if(data.estado_ga_ing == 1 && data.egresado == 0){
                    var actions1 = '';
                    actions1 += '<center><a data-toggle="modal" class="btn btn-warning btn-circle btn-ls" href="#modal-form:id"><i class="fa fa-trash-o"></i></a></center>'+
                    '<div id="modal-form:id" class="modal fade" aria-hidden="true">'+
                    '<div class="modal-dialog">'+
                    '<div class="modal-content">'+
                    '<div class="modal-body">'+
                    '<div class="row" align="center">'+
                    '<div class="col-sm-12 b-r"><h3 class="m-t-none m-b">¿Seguro que desea anular esta guia?</h3>'+
                    '<p>Esta guia se anulara inmediatamente. Esta acción no se puede deshacer</p>'+
                    '<form action=" {{ route('garantia_guia_ingreso.update', ':id') }} "  enctype="multipart/form-data" method="post">'+
                    '@csrf @method('PATCH')'+
                    '<center><button type="submit" class="btn btn-w-m btn-danger">Anular</button></center>'+
                    '</form>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                    return actions1.replace(/:id/g, data.gar_ing_id);
                }else if(data.egresado == 1){
                    var actions2 = '';
                    data: 'id';
                    actions2 += '<center><button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></center>';
                    return actions2.replace(/:id/g, data.gar_ing_id);/*PROCESADO*/
                }else if(data.estado_ga_ing == 0 && data.egresado == 0){
                    var actions2 = '';
                    data: 'id';
                    actions2 += '<center><button class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle"></i></button></center>';
                    return actions2.replace(/:id/g, data.gar_ing_id);/*ANULADO*/
                }else if(data.estado_ga_ing == 2 && data.egresado == 0){
                    var actions2 = '';
                    data: 'id';
                    actions2 += '<center><button style="background: gray;" class="btn btn-circle btn-ls"><i style="color: white;" class="fa fa-history"></i></button></center>';
                    return actions2.replace(/:id/g, data.gar_ing_id);/*FUERA DE FUNCION*/
                }
            }
        },
        ]
    });
    });
</script> --}}

<script>
    $(document).ready(function() {

        $('.footable').footable();
        $('.footable2').footable();

    });

</script>
<!-- Despliegue de la tabla para editar -->
<script>
    // Selecciona todos los botones con la clase toggle-row
    document.querySelectorAll('.toggle-row').forEach((button) => {
        button.addEventListener('click', () => {
            // Encuentra la fila oculta siguiente a la fila actual
            const detailsRow = button.closest('tr').nextElementSibling;

            // Alterna la visibilidad de la fila
            if (detailsRow.style.display === 'none') {
                detailsRow.style.display = 'table-row';
            } else {
                detailsRow.style.display = 'none';
            }
        });
    });
</script>


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
    $('#table_egreso').DataTable({
        // "order": [[ 1, "desc" ]],
        "serverSide":true,
        "ajax":"{{url('api/garantia_egreso')}}",
        "columns":[
            {data : 'egreso_id'},
            {data : 'orden_servicio'},
            {data : 'nombre_marca'},
            {data : 'fecha'},
            {data : 'motivo'},
            {data : 'asunto'},
            {data : 'cliente_nom'},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<center><a href="{{ route('garantia_guia_egreso.show', ':id') }}"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a></center>';
                    return actions.replace(/:id/g, data.egreso_id);
                }
             }
        ]
    });
});

</script>


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
$(document).ready(function(){
    $('#table_informe_tec').DataTable({
        // "order": [[ 1, "desc" ]],
        "serverSide":true,
        "ajax":"{{url('api/informe_tecnico')}}",
        "columns":[
            {data : 'inf_tec_id'},
            {data : 'orden_servicio'},
            {data : 'nombre_marca'},
            {data : 'fecha'},
            {data : 'motivo'},
            {data : 'asunto'},
            {data : 'cliente_nom'},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<center><a href="{{ route('garantia_informe_tecnico.show', ':id') }}"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a></center>';
                    return actions.replace(/:id/g, data.inf_tec_id);
                }
            },
        ]
    });
});

</script>

@endsection
