@extends('layout')

@section('title', 'Cliente')
@section('breadcrumb', 'Cliente')
@section('breadcrumb2', 'Cliente')
@section('data-toggle', 'modal')
@section('href_accion', '#ModalCliente')
@section('value_accion', 'Agregar')
@extends('layout_agregado_rapido')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@section('content')
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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 13px" id="table_cliente" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Nro Documento</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                          {{--   <tbody>
                                @foreach($clientes as $cliente)
                                <tr class="gradeX">
                                    <td>{{$cliente->id}}</td>
                                    <td>{{$cliente->nombre}}</td>
                                    <td>{{$cliente->documento_identificacion}}</td>
                                    <td>{{$cliente->numero_documento}}</td>
                                    <td>{{$cliente->email}}</td>
                                    <td>{{$cliente->celular}}</td>
                                    <td><center><a href="{{ route('cliente.show', $cliente->id) }}" target="_blank"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>
                                </tr>

                                @endforeach
                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{--Base para agregar el tab para el los contenidos--}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">          
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: green;">&#9632; </span> Cliente
                                </a>
                            </li>
                        <!-- Modal Crear Cliente -->
                            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel" style="color: blue; font-size: 20px;">
                                                    <b>Agregar Nuevo Cliente</b>
                                                </h5>                    
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Nav tabs -->
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab"
                                                        aria-controls="tab1" aria-selected="true">1. Datos Personales</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab"
                                                        aria-controls="tab2" aria-selected="false">2. Información</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab"
                                                        aria-controls="tab3" aria-selected="false">3. Contacto</a>
                                                    </li>
                                                </ul>
                                                <!-- Tab content -->
                                                <div class="tab-content mt-3" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                                        <!-- Aquí se agrega el contenido del modal -->
                                                        <div class="col-md-12 mb-3">
                                                            <!-- Título con ícono -->
                                                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-bottom: 20px;">
                                                                <label for="search" style="color: rgb(0, 0, 0); font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                                                                    Consultar (RUC - DNI)
                                                                </label>
                                                                <div style="display: flex; align-items: center;">
                                                                    <input type="text" id="search" name="search" placeholder="Ingrese RUC o DNI" style="padding: 10px; border: 1px solid #ccc; border-radius: 20px; margin-right: 30px; width: 300px; outline: none;">
                                                                    <button style="background-color: #210abb; color: white; padding: 8px 16px; border: none; border-radius: 20px; cursor: pointer;">
                                                                        Buscar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <!-- DOCUMENTO IDENTIFICACION -->
                                                                <div class="col-md-6">
                                                                    <label for="responsable" class="form-label"><b>Documento Identificación</b></label>
                                                                    <select name="responsable" required class="form-control m-b select2-responsable"
                                                                            autocomplete="off" required="required" style="margin-bottom: 0px;">
                                                                        <option value=""></option>
                                                                        <option value="1">RUC</option>
                                                                        <option value="2">DNI</option>
                                                                        <option value="3">Pasaporte</option>
                                                                    </select>
                                                                </div>
                                                                <!-- NUMERO DE DOCUMENTO -->
                                                                <div class="col-md-6">
                                                                    <label for="direccion" class="form-label"><b>Número de Documento</b></label>
                                                                    <input type="tel" list="browserdoc" class="fast_add form-control m-b-0" name="numero_documento" id="numero_ruc_cli" required="" autocomplete="off" maxlength="11" onkeypress="return valideKey(event);" aria-required="true">
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="row mb-3">
                                                                <!-- NOMBRE -->
                                                                <div class="col-md-6">
                                                                    <label for="direccion" class="form-label"><b>Nombre:</b></label>
                                                                    <input type="text" class="form-control" placeholder=""
                                                                        name="direccion" autocomplete="off" required="required">
                                                                </div>
                                                                <!-- DIRECCION -->
                                                                <div class="col-md-6">
                                                                    <label for="abreviatura" class="form-label"><b>Dirección:</b></label>
                                                                    <input type="text" value="Lima" class="fast_add form-control" name="direccion" id="direccion_cli" required="required" aria-required="true">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <!-- CORREO -->
                                                                <div class="col-md-6">
                                                                    <label for="correo" class="form-label"> <b>Correo:</b></label>
                                                                    <input value="sincorreo@gmail.com" input type="text" class="form-control" placeholder=""
                                                                    name="direccion" autocomplete="off" required="required">
                                                                </div>
                                                                <!-- DISTRITO -->
                                                                <div class="col-md-6">
                                                                    <label for="distrito" class="form-label">
                                                                        <b>Distrito:</b>
                                                                    </label>
                                                                    <input type="text" value="Lima" class="fast_add form-control" name="ciudad" id="distrito_cli" required="required" aria-required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                                        <!-- Sección de codificación de documentos -->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-bottom: 20px;">
                                                                    <label for="search" style="color: rgb(0, 0, 0); font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                                                                        Consultar (RUC - DNI)
                                                                    </label>
                                                                    <div style="display: flex; align-items: center;">
                                                                        <input type="text" id="search" name="search" placeholder="Ingrese RUC o DNI" style="padding: 10px; border: 1px solid #ccc; border-radius: 20px; margin-right: 30px; width: 300px; outline: none;">
                                                                        <button style="background-color: #210abb; color: white; padding: 8px 16px; border: none; border-radius: 20px; cursor: pointer;">
                                                                            Buscar
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                            
                                                        <!-- MODAL -->
                                                        <div class="col-md-12 mb-3">
                                                            <div class="row mb-3">
                                                                <!-- TELEFONO -->
                                                                <div class="col-md-6">
                                                                    <label for="responsable" class="form-label"><b>Teléfono</b></label>
                                                                    <input value="00000" type="number" class="fast_add form-control valid" name="telefono" aria-invalid="false">
                                                                </div>
                                                                
                                                                <!-- CELULAR -->
                                                                <div class="col-md-6">
                                                                    <label for="direccion" class="form-label"><b>Celular</b></label>
                                                                    <input value="0000000" type="number" class="fast_add form-control valid" name="celular">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <!-- CODIGO UBIGEO -->
                                                                <div class="col-md-6">
                                                                    <label for="codigoUbigeo" class="form-label">
                                                                        <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html"
                                                                        target="_blank" style="text-decoration: none;">
                                                                            <i class="fa fa-podcast" aria-hidden="true"></i>
                                                                        </a>
                                                                        <b>Cod. Ubigeo:</b>
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <input value="150101" input type="text" class="form-control" name="ubigeo" autocomplete="off"
                                                                            required="required" placeholder="" minlength="6" maxlength="6">
                                                                    </div>
                                                                </div>
                                                                <!-- DEPARTAMENTO -->
                                                                <div class="col-md-6">
                                                                    <label for="abreviatura" class="form-label"><b>Departamento:</b></label>
                                                                    <input value="Lima" type="text" class="fast_add form-control valid" name="departamento" id="provincia_cli" aria-invalid="false">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <!-- PAIS-->
                                                                <div class="col-md-6">
                                                                    <label for="codigoSunat" class="form-label"> <b>País:</b></label>
                                                                    <input value="Perú" type="text" class="fast_add form-control valid" name="pais" aria-invalid="false">
                                                                </div>
                                                                <!-- ANIVERSARIO -->
                                                                <div class="col-md-6">
                                                                    <label for="codigoUbigeo" class="form-label">
                                                                        <b>Aniversario:</b>
                                                                    </label>
                                                                    <input value="2025-02-15" type="date" class="fast_add form-control valid" name="aniversario">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <!-- FECHA REGISTRO -->
                                                                <div class="col-md-6">
                                                                    <label for="aniversario" class="form-label"> <b>Fecha Registro:</b></label>
                                                                    <input value="2025-02-15" type="date" class="fast_add form-control valid" name="aniversario">
                                                                </div>
                                                                <!-- TIPO CLIENTE -->
                                                                <div class="col-md-6">
                                                                    <label for="tipocliente" class="form-label"><b>Tipo Cliente:</b></label>
                                                                    <select name="responsable" required class="form-control m-b select2-responsable"
                                                                            autocomplete="off" required="required" style="margin-bottom: 0px;">
                                                                        <option value=""></option>
                                                                        <option value="1">Cliente Frecuente</option>
                                                                        <option value="2">Cliente Revendedor</option>
                                                                        <option value="3">Cliente Vip</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                                        <!-- Sección de codificación de documentos -->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-bottom: 20px;">
                                                                    <label for="search" style="color: rgb(0, 0, 0); font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                                                                        Consultar (RUC - DNI)
                                                                    </label>
                                                                    <div style="display: flex; align-items: center;">
                                                                        <input type="text" id="search" name="search" placeholder="Ingrese RUC o DNI" style="padding: 10px; border: 1px solid #ccc; border-radius: 20px; margin-right: 30px; width: 300px; outline: none;">
                                                                        <button style="background-color: #210abb; color: white; padding: 8px 16px; border: none; border-radius: 20px; cursor: pointer;">
                                                                            Buscar
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Aquí se agrega el contenido del modal -->
                                                        <div class="col-md-12 mb-3">
                                                            <div class="row mb-3">
                                                                <!-- NOMBRE -->
                                                                <div class="col-md-6">
                                                                    <label for="Contacto" class="form-label"><b>Nombre:</b></label>
                                                                    <input value="Contacto" input id="name" name="nombre_contacto" type="text" class="fast_add form-control required valid" value="Contacto" aria-required="true" aria-invalid="false">
                                                                </div>
                                                                <!-- CARGO -->
                                                                <div class="col-md-6">
                                                                    <label for="cargo" class="form-label"><b>Cargo:</b></label>
                                                                    <input id="surname" name="cargo_contacto" type="text" class="fast_add form-control required" value="Cargo" aria-required="true">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <!-- TELEFONO -->
                                                                <div class="col-md-6">
                                                                    <label for="responsable" class="form-label"><b>Teléfono</b></label>
                                                                    <input name="telefono_contacto" type="text" class="fast_add form-control required" value="0050000" aria-required="true">
                                                                </div>
                                                                <!-- CELULAR -->
                                                                    <div class="col-md-6">
                                                                        <label for="direccion" class="form-label"><b>Celular</b></label>
                                                                        <input id="address" name="celular_contacto" type="text" class="fast_add form-control required valid" value="951000000" aria-required="true" aria-invalid="false">
                                                                </div>
                                                            </div>
                                                            <!-- CORREO-->
                                                            <div class="col-md-12">
                                                                <label for="correo" class="form-label"> <b>Correo:</b></label>
                                                                <input value="sincorreo@gmail.com" input type="text" class="form-control" placeholder=""
                                                                name="direccion" autocomplete="off" required="required">
                                                            </div>
                                                        </div>
                                                    </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </ul>
                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-9 mb-2">
                                            <div class="input-group">
                                                <input type="search" id="search" class="form-control" placeholder="Buscar...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" style="background-color: blue; border-color:blue;">Buscar</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2 d-flex justify-content-end">
                                            <button type="button" class="btn btn-default btn-sm" style="background-color: #210abb; color: white; padding: 10px 16px; font-size: 13px; border-radius: 5px; margin-right: 5px;" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-plus-square"></i>
                                            </button>
                                            
                                            <div class="dropdown">
                                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #808080; color: white; font-size: 13px; padding: 5px 10px;">
                                                    <i class="fa fa-download"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">PDF</a>
                                                    <a class="dropdown-item" href="#">XML</a>
                                                    <a class="dropdown-item" href="#">Excel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                        <div class="panel-body">
                                            <!-- CONTENIDO DENTRO DEL TAB  -->
                                            <table class="table table-striped table-hover text-md-center">
                                                <thead>
                                                    <tr>
                                                        <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>
                                                        <th>ID</th>
                                                        <th>Nombre</th>
                                                        <th>Tipo Documento</th>
                                                        <th>Nro Documento</th>
                                                        <th>Correo</th>
                                                        <th>Celular</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></td>
                                                        <td>1</td>
                                                        <td>Sr soluciones sac</td>
                                                        <td>RUC</td>
                                                        <td>20545122551</td>
                                                        <td>julioflores@srsc.com</td>
                                                        <td>946201443</td>
                                                        <td>
                                                            <!-- Botón para abrir el modal -->
                                                            <button class="btn btn-success" data-toggle="modal" data-target="#verModal">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-info" style="background-color:green; border-color:green;">
                                                                <i class="fa fa-check" style="color:white;"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></td>
                                                        <td>2</td>
                                                        <td>Flaviaaaa</td>
                                                        <td>Dni</td>
                                                        <td>78941250</td>
                                                        <td>Flav@sewqe.com</td>
                                                        <td>986450312</td>
                                                        <td>
                                                            <!-- Botón para abrir el modal -->
                                                            <button class="btn btn-success" data-toggle="modal" data-target="#verModal">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            <button class="btn btn-info" style="background-color:green; border-color:green;">
                                                                <i class="fa fa-check" style="color:white;"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- Modal de Ver (Contacto y Sucursal)-->
                                            <div class="modal fade" id="verModal" tabindex="-1" role="dialog" aria-labelledby="verModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document" style="max-width: 90%; max-height: 90%; margin: 1rem auto;">
                                                    <div class="modal-content" style="height: auto; display: flex; flex-direction: column;">
                                                        <div class="modal-header" style="background-color: #0d47a1; color: white;">
                                                            <h5 class="modal-title" id="verModalLabel" style="text-align: center; font-size: 1rem;">Ver de Daniel Roman</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true" style="color: white; font-size: 1.5rem;">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body" style="padding: 30px; flex: 1;">
                                                            <!-- Pestañas -->
                                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                                <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom: 0;">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" id="contacto-tab" data-toggle="tab" href="#contacto" role="tab" aria-controls="contacto" aria-selected="true">Contacto</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" id="sucursal-tab" data-toggle="tab" href="#sucursal" role="tab" aria-controls="sucursal" aria-selected="false">Sucursal</a>
                                                                    </li>
                                                                </ul>
                                                                <button type="button" class="btn btn-primary" style="line-height: normal;">
                                                                    <i class="fa fa-pencil-square-o" style="color: white;"></i>
                                                                </button>
                                                            </div>
                                                            <div class="tab-content mt-2" id="myTabContent">
                                                                <div class="tab-pane fade show active" id="contacto" role="tabpanel" aria-labelledby="contacto-tab">
                                                                    <div style="display: flex; align-items: center;">
                                                                        <div class="input-group" style="max-width: 1200px;">
                                                                            <input type="search" id="search" class="form-control" placeholder="Buscar..." style="width: 80%;"> 
                                                                            <div class="input-group-append">
                                                                                <button class="btn btn-primary" type="button" style="background-color: blue; border-color: blue;">Buscar</button>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="btn btn-primary" style="margin-left: auto; line-height: normal;">
                                                                            <i class="fa fa-plus-square" style="color: white;"></i>
                                                                        </button>
                                                                    </div>
                                                                    <!-- Tabla Contactos -->
                                                                    <table class="table table-striped table-hover mt-2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Tipo Documento</th>
                                                                                <th>Nro Documento</th>
                                                                                <th>Correo</th>
                                                                                <th>Celular</th>
                                                                                <th>Estado</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>DNI</td>
                                                                                <td>71483609</td>
                                                                                <td>julioflores@srsc.com</td>
                                                                                <td>998321228</td>
                                                                                <td>
                                                                                    <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                                                                                        <i class="fa fa-check" style="color:white;"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Pasaporte</td>
                                                                                <td>35483610</td>
                                                                                <td>Flav@sewqe.com</td>
                                                                                <td>986790521</td>
                                                                                <td>
                                                                                    <button style="display:inline-block; padding:10px; background-color:red; border-radius:66px; border:none; cursor:pointer;">
                                                                                        <i class="fa fa-arrows-alt" style="color:white;"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="tab-pane fade" id="sucursal" role="tabpanel" aria-labelledby="sucursal-tab">
                                                                    <div style="display: flex; align-items: center;">
                                                                        <div class="input-group" style="max-width: 1200px;">
                                                                            <input type="search" id="search" class="form-control" placeholder="Buscar..." style="width: 80%;"> 
                                                                            <div class="input-group-append">
                                                                                <button class="btn btn-primary" type="button" style="background-color: blue; border-color: blue;">Buscar</button>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <button type="button" class="btn btn-primary" style="margin-left: auto; line-height: normal;">
                                                                            <i class="fa fa-plus-square" style="color: white;"></i>
                                                                        </button>
                                                                    </div>                       
                                                                    <table class="table table-striped table-hover mt-2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Nombre</th>
                                                                                <th>Cargo</th>
                                                                                <th>Dirección</th>
                                                                                <th>Código Ubigeo</th>
                                                                                <th>Acciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>MELINA</td>
                                                                                <td>Sucursal</td>
                                                                                <td>mz c</td>
                                                                                <td>1652</td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary" style="line-height: normal;">
                                                                                        <i class="fa fa-pencil-square-o" style="color: white;"></i>
                                                                                    </button>
                                                                                    <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                                                                                        <i class="fa fa-check" style="color:white;"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>ANTIVIRUS BITDEFENDER TOTAL SECURITY 1PC</td>
                                                                                <td>Secretaria</td>
                                                                                <td>mc b</td>
                                                                                <td>98736</td>
                                                                                <td>
                                                                                    <button type="button" class="btn btn-primary" style="line-height: normal;">
                                                                                        <i class="fa fa-pencil-square-o" style="color: white;"></i>
                                                                                    </button>
                                                                                    <button style="display:inline-block; padding:10px; background-color:red; border-radius:66px; border:none; cursor:pointer;">
                                                                                        <i class="fa fa-arrows-alt" style="color:white;"></i>
                                                                                    </button>
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
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

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

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
{{-- scritp de modal agregar --}}

    <!-- Page-Level Scripts -->
<script>
$(document).ready(function(){
    $('#table_cliente').DataTable({
        "serverSide":true,
        "ajax":"{{url('api/clientes')}}",
        "columns":[
            {data : 'id'},
            {data : 'nombre'},
            {data : 'documento_identificacion'},
            {data : 'numero_documento'},
            {data : 'email'},
            {data : 'celular'},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<a href="{{ route('cliente.show',':id') }}" target="_blank"><span class="btn btn-success" >VER</span></a>';
                    return actions.replace(/:id/g, data.id);
                }
            }
        ]
    });
});

</script>
    @endsection
