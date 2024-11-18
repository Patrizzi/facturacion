@extends('layout')

@section('title', 'Categoría')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('content')
@section('button2', 'Atrás')
@section('config',route('Configuracion'))

<!-- Modal Create  -->
@if($errors->any())
<div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
    <a class="alert-link" href="#">
        @foreach ($errors->all() as $error)
        <li class="error" style="color: red">{{ $error }}</li>
        @endforeach
    </a>
</div>
@endif
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('categoria.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                        @csrf
                        <div>
                            <div class="panel-body" >
                                <div class="row">
                                    <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/categoria.svg')}}" width="100px"></div>
                                    <label class="col-sm-2 col-form-label">Descripción:</label>
                                    <div class="col-sm-10"> <input type="text" class="form-control" name="descripcion" required> </div>
                                </div>
                            </div>
                        </div>
                        <button class="ladda-button btn btn-primary" type="submit" id="boton">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- / Modal Create  -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">

                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr class="gradeX">
                                    <td>@if($categoria->estado==0) <i class="fa fa-circle" style="color: green;"></i>@else
                                       <i class="fa fa-circle"></i>@endif {{$categoria->id}}</td>
                                       <td>{{$categoria->codigo}}</td>
                                       <td>{{$categoria->descripcion}}</td>
                                       <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$categoria->id}}"><i class="fa fa-edit"></i></button>
                                        <div class="modal fade" id="exampleModal{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{ route('categoria.update',$categoria->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                             <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/categoria.svg')}}" width="100px"></div>
                                                                             <label class="col-sm-3 col-form-label">Descripcion:</label>
                                                                             <div class="col-sm-9">
                                                                                <input type="text" class="form-control" readonly="readonly" value="{{$categoria->descripcion}}">
                                                                            </div>
                                                                            @if($conteo > 1 || $categoria->estado==1 )
                                                                            <div class="col-sm-12" align="center" style="padding-top: 10px">
                                                                             <input type="checkbox" class="js-switch_{{$categoria->id}}" name="estado"  @if($categoria->estado==0) checked="" @endif />
                                                                         </div>
                                                                         @endif
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </fieldset>
                                                         <button class="ladda-button btn btn-primary" type="submit" >Grabar</button>
                                                     </form>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <!-- / Modal Create  -->

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

<tbody>
    {{--Base para agregar el tab para el los contenidos--}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: green;">&#9632; </span> CATEGORIA
                                    {{-- link del tab 1 --}}
                                </a>
                            </li>
                            <li class="ml-auto">
                                <div class="btn-group mx-2">
                                    <div class="col-auto">
                                        <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                    <!-- Botón para abrir el modal -->
                                    <div class="btn-group mx-0"> <!-- Cambia mx-2 a mx-0 -->
                                        <button type="button" class="btn btn-default btn-sm bg-primary" style="color: white;" data-bs-toggle="modal" data-bs-target="#myModal">Agregar</button>                                    </div>
                                </div>
                            </li>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel"  style="color: blue; font-size: 18px; font-weight: bold;">Agregar nueva categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 mb-3">
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <img src="http://127.0.0.1:8000/img/logos/categoria.svg" width="100px" style="margin-right: 10px;">
                                <label for="descripcion" class="form-label" style="color: rgb(0, 0, 0); font-size: 18px; font-weight: bold;">Descripción:</label>
                            </div>
                            <textarea class="form-control" id="descripcion" rows="1" style="margin-top: 10px;"></textarea> <!-- Agrega margen superior -->
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Bootstrap CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                            </li>
                            </ul>

<!-- Tablas y su contenido -->
<div class="tab-content">
    <div role="tabpanel" id="tab-1" class="tab-pane active show">
        <div class="panel-body">
            <!-- CONTENIDO DENTRO DEL TAB  -->
            <table class="table table-striped text-md-center">
                <thead>
                    <tr>
                        <th><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                        <th >ID</th>
                        <th >Código</th>
                        <th >Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                    <td>1</td>
                    <td>0001</td>
                    <td>PRODUCTOS</td>
                    <td>
                        <!-- Botón para abrir el modal -->
                    <div><a href="#"
                           style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                           data-bs-toggle="modal"
                           data-bs-target="#modaluno"> <!-- Cambiado a modaluno -->
                            <i class="fa fa-edit" style="color:white;"></i>
                        </a>
                        <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                            <i class="fa fa-check" style="color:white;"></i>
                        </button></div>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="modaluno" tabindex="-1" aria-labelledby="modalunoLabel" aria-hidden="true"> <!-- Cambiado a modaluno -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalunoLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar Categoría</h5> <!-- Cambiado a "Editar Categoría" -->
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mb-3">
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img src="http://127.0.0.1:8000/img/logos/categoria.svg" width="100px" style="margin-right: 10px;">
                                            <label for="descripcion" class="form-label" style="color: rgb(0, 0, 0); font-size: 18px; font-weight: bold;">Descripción:</label>
                                        </div>
                                        <textarea class="form-control" id="descripcion" rows="1" style="margin-top: 10px;"></textarea> <!-- Agrega margen superior -->
                                    </div>
                                    <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="position: relative;">
                                            <label>
                                                <input type="checkbox" id="toggleSwitch">
                                                Activar/Desactivar
                                            </label>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </td>
        </tr>
    <tr>
                    <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                    <td>2</td>
                    <td>0002</td>
                    <td>GARANTIAS</td>
                    <td>
                        <div><a href="#"
                           style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                           data-bs-toggle="modal"
                           data-bs-target="#modaldos"> <!-- Cambiado a modaldos -->
                            <i class="fa fa-edit" style="color:white;"></i>
                        </a>
                        <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                            <i class="fa fa-check" style="color:white;"></i>
                        </button></div>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="modaldos" tabindex="-1" aria-labelledby="modaldosLabel" aria-hidden="true"> <!-- Cambiado a modaldos -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modaldosLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar Categoría</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mb-3">
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img src="http://127.0.0.1:8000/img/logos/categoria.svg" width="100px" style="margin-right: 10px;">
                                            <label for="descripcion" class="form-label" style="color: rgb(0, 0, 0); font-size: 18px; font-weight: bold;">Descripción:</label>
                                        </div>
                                        <textarea class="form-control" id="descripcion" rows="1" style="margin-top: 10px;"></textarea> <!-- Agrega margen superior -->
                                    </div>
                                    <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="position: relative;">
                                            <label>
                                                <input type="checkbox" id="toggleSwitch">
                                                Activar/Desactivar
                                            </label>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
                    <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                    <td>3</td>
                    <td>0001</td>
                    <td>SERVICIOS</td>
                    <td>
                        <div><a href="#"
                           style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                           data-bs-toggle="modal"
                           data-bs-target="#modaldos"> <!-- Cambiado a modaldos -->
                            <i class="fa fa-edit" style="color:white;"></i>
                        </a>

                        <button style="display:inline-block; padding:10px; background-color:red; border-radius:66px; border:none; cursor:pointer;">
                            <i class="fa fa-arrows-alt" style="color:white;"></i>
                        </button></div>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="modaltres" tabindex="-1" aria-labelledby="modaltresLabel" aria-hidden="true"> <!-- Cambiado a modaltres -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modaltresLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar categoría</h5> <!-- Cambiado a "Editar categoría" -->
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mb-3">
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img src="http://127.0.0.1:8000/img/logos/categoria.svg" width="100px" style="margin-right: 10px;">
                                            <label for="descripcion" class="form-label" style="color: rgb(0, 0, 0); font-size: 18px; font-weight: bold;">Descripción:</label>
                                        </div>
                                        <textarea class="form-control" id="descripcion" rows="1" style="margin-top: 10px;"></textarea> <!-- Agrega margen superior -->
                                    </div>
                                    <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="position: relative;">
                                            <label>
                                                <input type="checkbox" id="toggleSwitch">
                                                Activar/Desactivar
                                            </label>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </tbody>
        </table>


        </div>
    </div>
    <div role="tabpanel" id="tab-2" class="tab-pane">
        <div class="panel-body">
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</tbody>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Agregar - Factura</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- c3 Charts -->
    <link href="css/plugins/c3/c3.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


</head>
<body>


            <!--TODO SOBRE LA VISTA -->
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Vista de Agregar - Boleta</h2>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h3><strong> Datos del cliente</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row ">
                                    <div class="col-sm-12">
                                            <div style="margin: auto 50px">
                                                <div class="form-group row">
                                                <label class="col-sm-4 col-form-label"><strong>Cliente:</strong></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control">
                                                        <option value="">Seleccione un cliente</option>
                                                        <option value="">ARTHRO MEDS SPORT S.A.C | 20603185197</option>
                                                        <option value="">BOX PARTS SOCIEDAD ANONIMA CERRADA | 20605675523</option>
                                                        <option value="">CELESTE DEL CARMEN UGARTE HUACCHILLO | 72875303</option>
                                                        <option value="">RAUL EDUARDO RODRIGUEZ SALAZAR | 09892148</option>
                                                        <option value="">ABRAHAN JOSUE GONZALES FERNANDEZ | 76652408</option>
                                                        <!-- Agrega más opciones según sea necesario -->
                                                    </select>
                                                </div>
                                            </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-4 col-form-label"><strong>RUC:</strong></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" placeholder="Ingrese el RUC">
                                                        </div>
                                                </div>   
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-6">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h3><strong> Datos del Vendedor</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row ">
                                    <div class="col-sm-12">
                                            <div style="margin: auto 50px">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label"><strong>Vendedor:</strong></label>
                                                    <div class="col-sm-8">
                                                        <p class="form-control">Administrador</p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-sm-4 col-form-label"><strong>Contacto:</strong></label>
                                                    <div class="col-sm-8">
                                                        <p class="form-control">987654320</p>
                                                    </div>
                                                </div>   
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


               <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading text-center">
                                <h3><strong>Datos de la Venta</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row col-lg-12">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Orden de Compra:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Guía de Remisión:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Comisionista:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Forma de pago:</strong></label>
                                            <div class="col-sm-7">
                                                <select class="form-control">
                                                    <option>Seleccione</option>
                                                    <option>Contado</option>
                                                    <option>Crédito</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Observación:</strong></label>
                                            <div class="col-sm-7">
                                                <textarea id="Observación" name="Observación" class="form-control" autocomplete="off" placeholder="Observación" style="margin-top: 5px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Fecha de Inicio:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" value="2024-11-06" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Fecha de Vencimiento:</strong></label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control" value="2024-11-06" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Moneda:</strong></label>
                                            <div class="col-sm-7">
                                                <select class="form-control">
                                                    <option>Seleccione</option>
                                                    <option>Soles</option>
                                                    <option>Dolares</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Tipo de Operación:</strong></label>
                                            <div class="col-sm-7">
                                                <select class="form-control">
                                                    <option>Seleccione</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-5 col-form-label"><strong>Detracción:</strong></label>
                                            <div class="col-sm-7">
                                                <select class="form-control">
                                                    <option>Seleccione</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--TABLA DE AGREGAR--> 
                                    <div class="table-responsive">
                                        <table cellspacing="0" class="table tables">
                                            <thead>
                                                <tr style="background-color: #3366cc; color: white; text-align: center;">
                                                    <th>Acción</th>
                                                    <th style="width: 300px;">Artículo</th>
                                                    <th>Stock</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Dcto</th>
                                                    <th>PU. Dcto.</th>
                                                    <th>PU. Com.</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="addmore btn btn-success">
                                                            <i class="fa fa-plus-square" aria-hidden="true"></i> 
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <select id="Nombre" name="Nombre" class="form-control" autocomplete="off"  style="margin-top: 5px;"><option>Seleccione Articulo</option></select>
                                                        <textarea id="Descripcion" name="Descripcion" class="form-control" autocomplete="off" placeholder="Descripción de Item" style="margin-top: 5px;"></textarea>
                                                        <textarea id="Serie" name="Serie" class="form-control" autocomplete="off" placeholder="Número de Serie" style="margin-top: 5px;"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="stock0" disabled name="stock[]" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="number" id="cantidad0" name="cantidad[]" min="1" class="monto0 form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio0" name="precio[]" disabled class="monto0 form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="descuento" name="descuento" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio_unitario_descuento0" name="precio_unitario_descuento[]" disabled class="precio_unitario_descuento0 form-control" required autocomplete="off" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio_unitario_comision0" disabled class="form-control" required autocomplete="off" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="total0" name="total" disabled class="total form-control" required autocomplete="off" />
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                   <!--TABLA DE ELIMINAR--> 
                                    <div class="table-responsive">
                                        <table cellspacing="0" class="table tables">
                                            <thead>
                                                <tr style="background-color: #3366cc; color: white; text-align: center;">
                                                    <th>Acción</th>
                                                    <th style="width: 300px;">Artículo</th>
                                                    <th>Stock</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Dcto</th>
                                                    <th>PU. Dcto.</th>
                                                    <th>PU. Com.</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-danger">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <select id="Nombre" name="Nombre" class="form-control" autocomplete="off"  style="margin-top: 5px;"><option>Seleccione Articulo</option></select>
                                                        <textarea id="Descripcion" name="Descripcion" class="form-control" autocomplete="off" placeholder="Descripción de Item" style="margin-top: 5px;"></textarea>
                                                        <textarea id="Serie" name="Serie" class="form-control" autocomplete="off" placeholder="Número de Serie" style="margin-top: 5px;"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="stock0" disabled name="stock[]" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="number" id="cantidad0" name="cantidad[]" min="1" class="monto0 form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio0" name="precio[]" disabled class="monto0 form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="descuento" name="descuento" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio_unitario_descuento0" name="precio_unitario_descuento[]" disabled class="precio_unitario_descuento0 form-control" required autocomplete="off" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="precio_unitario_comision0" disabled class="form-control" required autocomplete="off" />
                                                    </td>
                                                    <td>
                                                        <input type="text" id="total0" name="total" disabled class="total form-control" required autocomplete="off" />
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr >
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><strong>Subtotal:</strong></td>
                                                    <td colspan="2">
                                                    <input  id="subtotal"  type="text" disabled class="form-control" required="">
</td>
                                                </tr>
                                                <tr >
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><strong>IGV:</strong></td>
                                                    <td colspan="2">
                                                        <input  id="igv"  type="text" disabled class="form-control" required=""></td>
                                                </tr>
                                                <tr >
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><strong>Total:</strong></td>
                                                    <td colspan="2">
                                                    <input  id="total_final"  type="text" disabled class="form-control" required=""></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-cloud-upload" aria-hidden="true"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>       
                </div>
            </div>
        
    </div>
</div>
    
    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- d3 and c3 charts -->
    <script src="js/plugins/d3/d3.min.js"></script>
    <script src="js/plugins/c3/c3.min.js"></script>
</body>
</html>

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

<!-- Switchery -->
<link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>
@foreach($categorias as $categoria)
<script>
    var elem_2 = document.querySelector('.js-switch_{{$categoria->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@foreach($categorias as $categoria)
<script>
    var elem_2 = document.querySelector('.js-switch_vehiculo{{$categoria->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

@endsection

