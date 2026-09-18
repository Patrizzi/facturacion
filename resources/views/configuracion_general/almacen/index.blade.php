@extends('layout')
@section('title', 'Almacén')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('button2', 'Inicio')
{{-- @section('config',route('Configuracion')) --}}

@section('content')
    @if($errors->any())
        <div style="padding-top: 10px">
            <div class="alert alert-danger">
                <a class="alert-link" href="#">
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </a>
            </div>
        </div>
    @endif

    @if (session('campo'))
        <div class="alert alert-success">
            {{ session('campo') }}
        </div>
    @endif

    <!-- Modal CREAR ALMACEN -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Added 'modal-lg' for a larger size -->
            <div class="modal-content">
                <!-- Formulario de Almacén -->
                <form action="{{route('almacen.store')}}"  enctype="multipart/form-data" method="post" id="form_almacen_store">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel" style="">Agregar nuevo Almacén</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Información General</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Información de la Sunat</a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class="tab-content mt-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel" >
                                <!-- Aquí se agrega el contenido del modal -->
                                <div class="col-md-12 mb-3">
                                    <!-- Título con ícono -->
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                        <img src="{{asset('img/icons/almacen.svg')}}" width="100px" style="margin-right: 10px;">
                                        <label for="descripcion1" class="form-label" style="color: rgb(0, 0, 0); font-size: 22px; font-weight: bold;margin-bottom: 0px !important">
                                            Almacén
                                        </label>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Nombre -->
                                        <div class="col-md-6">
                                            <label for="nombreAlmacen" class="form-label"><b>Nombre:</b></label>
                                            <input type="text" placeholder="Almacén" class="form-control" required="required" name="nombre" autocomplete="off" id="almacen_nombre">
                                        </div>
                                        <!-- Responsable -->
                                        <div class="col-md-6">
                                            <label for="responsable" class="form-label"><b>Responsable:</b></label>
                                            <select name="responsable" required  class="form-control m-b select2-responsable" id="select2-responsable" autocomplete="off" required="required" style="margin-bottom: 0px;">
                                                <option value=""></option>
                                                @foreach($personal as $personals)
                                                    <option value="{{$personals->id}}" > {{$personals->nombres}} {{$personals->apellidos}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Dirección -->
                                        <div class="col-md-6">
                                            <label for="direccion" class="form-label"><b>Dirección:</b></label>
                                            <input type="text" class="form-control" placeholder="Av. , Calle, Ciudad" name="direccion" autocomplete="off" required="required" id="almacen_direccion">
                                        </div>
                                        <!-- Abreviatura -->
                                        <div class="col-md-6">
                                            <label for="abreviatura" class="form-label"><b>Abreviatura:</b></label>
                                            <input type="text" class="form-control" name="abreviatura" autocomplete="off" required="required" placeholder="ALM." id="almacen_abreviatura">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Código Sunat -->
                                        <div class="col-md-6">
                                            <label for="codigoSunat" class="form-label"> <b>Código Sunat:</b></label>
                                            <input  type="number" class="form-control" name="cod_sunat" autocomplete="off" required="required" placeholder="Numero de sucursal" id="almacen_sunat">
                                        </div>
                                        <!-- Cod. Ubigeo -->
                                        <div class="col-md-6">
                                            <label for="codigoUbigeo" class="form-label">
                                                <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html" target="_blank" style="text-decoration: none;">
                                                    <i class="fa fa-podcast" aria-hidden="true"></i>
                                                </a>
                                                <b>Cod. Ubigeo:</b>
                                            </label>
                                            <div class="input-group">
                                                <input type="text"  class="form-control" name="ubigeo" autocomplete="off" required="required" placeholder="150101" minlength="6" maxlength="6" id="almacen_ubigeo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Descripción -->
                                        <div class="col-md-12">
                                            <label for="descripcion" class="form-label"><b>Descripción:</b></label>
                                            <textarea class="form-control" name="descripcion" autocomplete="off" required="required" placeholder="Descripcion del Almacen" id="descripcion_almacen"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                <!-- Sección de codificación de documentos -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <!-- Centrado de la imagen y el texto de descripción -->
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img src="{{asset('sunat.png')}}" width="100px" style="margin-right: 10px;">
                                            <label for="descripcion2" class="form-label" style="color: rgb(0, 0, 0); font-size: 22px; font-weight: bold;">Sunat</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="alert alert-primary mb-0 mt-3" role="alert"> <!-- Added margin-top for spacing -->
                                            Nota: Los campos siguientes son los correlativos iniciales para los comprobantes.
                                        </div>
                                    </div>
                                    <input type="hidden" name="" id="valid_tab_1" value="" required>
                                </div>
                                <div class="col-md-12">
                                    <div class="row mb-3">
                                        <!-- Cod. Facturación -->
                                        <div class="col-md-4">
                                            <h4 class="text-center"><strong>Factura</strong></h4>
                                            <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                <label for="new_serie_factura" class="form-label"><b>Serie:</b></label>
                                                <label for="new_correlativo_factura" class="form-label"><b>Correlativo:</b></label>
                                            </div>
                                            <div class="input-group m-b" style="margin-bottom: 0px">
                                                <div class="input-group m-b" style="margin-bottom: 0px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;F&nbsp;</span>
                                                    </div>
                                                    <input type="text" class="form-control write_button" name="serie_factura" id="new_serie_factura" autocomplete="off" maxlength="3" placeholder="001">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                    </div>
                                                    <input type="text" id="new_correlativo_factura" name="cod_fac" class="form-control write_button" max="8" placeholder="000" >
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cod. Boleta -->
                                        <div class="col-md-4">
                                            <h4 class="form-label text-center"><strong>Boleta</strong></h4>
                                            <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                <label for="new_serie_boleta" class="form-label"><b>Serie:</b></label>
                                                <label for="new_correlativo_boleta" class="form-label"><b>Correlativo:</b></label>
                                            </div>
                                            <div class="input-group m-b" style="margin-bottom: 0px">
                                                <div class="input-group m-b" style="margin-bottom: 0px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;B&nbsp;</span>
                                                    </div>
                                                    <input type="text" class="form-control write_button" name="serie_boleta" id="new_serie_boleta" autocomplete="off" maxlength="3" placeholder="001">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                    </div>
                                                    <input type="text" name="cod_bol" id="new_correlativo_boleta" class="form-control write_button" max="8" placeholder="000" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cod. Guía R -->
                                        <div class="col-md-4">
                                            <h4 class="form-label text-center"><strong>Guía Remision</strong></h4>
                                            <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                <label for="serie_remision" class="form-label"><b>Serie:</b></label>
                                                <label for="correlativo_remision" class="form-label"><b>Correlativo:</b></label>
                                            </div>
                                            <div class="input-group m-b" style="margin-bottom: 0px">
                                                <div class="input-group m-b" style="margin-bottom: 0px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;T&nbsp;</span>
                                                    </div>
                                                    <input type="text" class="form-control write_button" name="serie_remision" id="serie_remision" autocomplete="off" maxlength="3" placeholder="001">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                    </div>
                                                    <input type="text" name="cod_guia" class="form-control write_button" id="correlativo_remision" max="8" placeholder="000" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <!-- Cod. Factura Manual -->
                                        <div class="col-md-4">
                                            <h4 class="form-label text-center"><strong>Factura Manual</strong></h4>
                                            <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                <label for="new_serie_factura_m" class="form-label"><b>Serie:</b></label>
                                                <label for="new_correlativo_factura_m" class="form-label"><b>Correlativo:</b></label>
                                            </div>
                                            <div class="input-group m-b" style="margin-bottom: 0px">
                                                <div class="input-group m-b" style="margin-bottom: 0px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;FA&nbsp;</span>
                                                    </div>
                                                    <input type="text" class="form-control write_button" name="serie_factura_m" id="new_serie_factura_m" autocomplete="off" maxlength="2" placeholder="01">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                    </div>
                                                    <input type="text" name="cod_factura_m" id="new_correlativo_factura_m" class="form-control write_button" max="8" placeholder="000" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cod. Boleta Manual -->
                                        <div class="col-md-4">
                                            <h4 class="form-label text-center"><strong>Boleta Manual</strong></h4>
                                            <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                <label for="new_serie_boleta_m" class="form-label"><b>Serie:</b></label>
                                                <label for="new_correlativo_boleta_m" class="form-label"><b>Correlativo:</b></label>
                                            </div>
                                            <div class="input-group m-b" style="margin-bottom: 0px">
                                                <div class="input-group m-b" style="margin-bottom: 0px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;BA&nbsp;</span>
                                                    </div>
                                                    <input type="text" class="form-control write_button" name="serie_boleta_m" id="new_serie_boleta_m" autocomplete="off" maxlength="2" placeholder="01">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                    </div>
                                                    <input type="text" name="cod_boleta_m" id="new_correlativo_boleta_m" class="form-control write_button" max="8" placeholder="000" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cod. Guía Remisión Manual -->
                                        <div class="col-md-4">
                                            <h4 class="form-label text-center"><strong>Guia de Remision Manual</strong></h4>
                                            <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                <label for="new_serie_remision_m" class="form-label"><b>Serie:</b></label>
                                                <label for="new_correlativo_remision_m" class="form-label"><b>Correlativo:</b></label>
                                            </div>
                                            <div class="input-group m-b" style="margin-bottom: 0px">
                                                <div class="input-group m-b" style="margin-bottom: 0px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;TA&nbsp;</span>
                                                    </div>
                                                    <input type="text" class="form-control write_button" name="serie_remision_m" id="new_serie_remision_m" autocomplete="off" maxlength="2" placeholder="01">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                    </div>
                                                    <input type="text" name="cod_remision_m" id="new_correlativo_remision_m" class="form-control write_button" max="8" placeholder="000" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3">
                                        <!-- Cod. Nota Crédito Factura -->
                                        <div class="col-md-4">
                                            <h4 class="form-label text-center"><strong>Nota de Crédito - Factura:</strong></h4>
                                            <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                <label for="new_serie_cred_factura" class="form-label"><b>Serie:</b></label>
                                                <label for="new_correlativo_cred_factura" class="form-label"><b>Correlativo:</b></label>
                                            </div>
                                            <div class="input-group m-b" style="margin-bottom: 0px">
                                                <div class="input-group m-b" style="margin-bottom: 0px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;FF&nbsp;</span>
                                                    </div>
                                                    <input type="text" class="form-control write_button" name="serie_credito" id="new_serie_cred_factura" autocomplete="off" maxlength="2" placeholder="01">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                    </div>
                                                    <input type="text" name="cod_credito" id="new_correlativo_cred_factura" class="form-control write_button" max="8" placeholder="000" autocomplete="off" >
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cod. Nota Crédito Boleta -->
                                        <div class="col-md-4">
                                            <h4 class="form-label text-center"><strong>Nota de Crédito - Boleta:</strong></h4>
                                            <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                <label for="new_serie_cred_boleta" class="form-label"><b>Serie:</b></label>
                                                <label for="new_correlativo_cred_boleta" class="form-label"><b>Correlativo:</b></label>
                                            </div>
                                            <div class="input-group m-b" style="margin-bottom: 0px">
                                                <div class="input-group m-b" style="margin-bottom: 0px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;BB&nbsp;</span>
                                                    </div>
                                                    <input type="text" class="form-control write_button" name="serie_credito_b" id="new_serie_cred_boleta" autocomplete="off" maxlength="2" placeholder="01">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                    </div>
                                                    <input type="text" name="cod_credito_b" id="new_correlativo_cred_boleta" class="form-control write_button" max="8" placeholder="000" autocomplete="off" >
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Cod. Nota Débito -->
                                        <div class="col-md-4">
                                            <h4 class="form-label text-center"><strong>Nota de Débito:</strong></h4>
                                            <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                <label for="new_serie_debito" class="form-label"><b>Serie:</b></label>
                                                <label for="new_correlativo_debito" class="form-label"><b>Correlativo:</b></label>
                                            </div>
                                            <div class="input-group m-b" style="margin-bottom: 0px">
                                                <div class="input-group m-b" style="margin-bottom: 0px">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;TA&nbsp;</span>
                                                    </div>
                                                    <input type="text" class="form-control write_button" name="serie_debito" id="new_serie_debito" autocomplete="off" maxlength="2" placeholder="01">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                    </div>
                                                    <input type="text" name="cod_debito" id="new_correlativo_debito" class="form-control write_button" max="8" placeholder="000" autocomplete="off" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="button_save_almacen" class="btn btn-primary" style="">Siguiente</button>
                        <button type="button" id="button_save_sunat" class="btn btn-primary" style="display: none" >Guardar</button>
                        <button type="submit" id="submit_sunat" class="btn btn-primary" style="display: none" >Guardar</button>
                    </div>
                </form>
                <!-- Fin del contenido modal -->
            </div>
        </div>
    </div>
    <!-- FIN Modal PRIMERO-->

    {{--Base para agregar el tab para el los contenidos--}}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox" >
                    <div class="ibox-content" style="padding:10px">
                        <div class="row mx-2" > <!-- Usamos row para la distribución -->
                            <div class="col-md-8" style="display: flex;align-items: center">
                                <span style="color: green;margin: 0px 8px">&#9632; </span>
                                <h4 style="margin: 0px 5px">Almacen</h4>
                            </div>
                            <!-- Botón para agregar -->
                            <div class="col-md-4 mb-1 text-right" style="margin-bottom: 0px !important"> <!-- Alineado a la derecha -->
                                <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row" style="align-items: center;padding: 0px 20px">
                            <div class="col-sm-7">

                            </div>
                            <div class="col-sm-4">
                                <input type="search" class="form-control" placeholder="Buscar:" id="search_all_column" autocomplete="off">
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Abreviatura</th>
                                        <th>Dirección</th>
                                        <th>Responsable</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($almacenes as $almacen)
                                    <tr class="gradeX">
                                        <td>{{$almacen->id}}</td>
                                        <td>{{$almacen->nombre}}</td>
                                        <td>{{$almacen->abreviatura}}</td>
                                        <td>{{$almacen->direccion}}</td>
                                        <td>{{$almacen->personal->nombres}} {{$almacen->personal->apellidos}}</td>
                                        <td>{{$almacen->descripcion}}</td>
                                        <td>
                                            @if($almacen->estado==0)
                                            <button type="submit" class="btn btn-info"><i  class=" fa fa-check"></i></button>
                                            @elseif($almacen->estado==1)
                                            <button type="button" class="btn btn-default"><i class="fa fa-times-rectangle"></i></button>
                                            @endif
                                            <!-- Botón para abrir el modal -->
                                            <button class="btn btn-success" data-toggle="modal" data-target="#editaralmacen{{$almacen->id}}"><i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal DOS -->
    @foreach($almacenes as $index => $almacen)
        <div class="modal fade" id="editaralmacen{{$almacen->id}}" tabindex="-1" aria-labelledby="editaralmacenLabel">
            <div class="modal-dialog modal-lg"> <!-- Added 'modal-lg' for a larger size -->
                <form action="{{route('almacen.update', $almacen->id)}}"  enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editaralmacenLabel" style="">Editar el almacén</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                        </div>

                        <div class="modal-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="tab3-tab" data-toggle="tab" href="#tab_{{$index}}_general" role="tab" aria-controls="tab3" aria-selected="true">Información General</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab_{{$index}}_sunat" role="tab" aria-controls="tab4" aria-selected="false">Información de la Sunat</a>
                                </li>
                            </ul>
                            <!-- Tab content -->
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab_{{$index}}_general" role="tabpanel" aria-labelledby="tab3-tab">
                                    <!-- Aquí se agrega el contenido del modal -->
                                    <div class="col-md-12 mb-3">
                                        <!-- Título con ícono -->
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img src="{{ asset('img/icons/almacen.svg')}}" width="100px" style="margin-right: 10px;">
                                            <label for="descripcion1" class="form-label" style="color: rgb(0, 0, 0); font-size: 22px; font-weight: bold;">
                                                Almacén
                                            </label>
                                        </div>
                                        <!-- Formulario de Almacén -->
                                        <div class="row mb-3">
                                            <!-- Nombre -->
                                            <div class="col-md-6">
                                                <label for="nombreAlmacen" class="form-label"><b>Nombre:</b></label>
                                                <input type="text" class="form-control" name="nombre" value="{{$almacen->nombre}}" autocomplete="off">
                                            </div>
                                            <!-- Responsable -->
                                            <div class="col-md-6">
                                                <label for="responsable" class="form-label"><b>Responsable:</b></label>
                                                <select class="form-control select2_edit_responsable" name="responsable">
                                                    @foreach($personal as $personals)
                                                        <option value="{{$personals->id}}" @if($personals->id == $almacen->personal_id) selected @endif>{{$personals->nombres}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <!-- Dirección -->
                                            <div class="col-md-6">
                                                <label for="direccion" class="form-label"><b>Dirección:</b></label>
                                                <input type="text" class="form-control" name="direccion" value="{{$almacen->direccion}}" autocomplete="off">
                                            </div>
                                            <!-- Abreviatura -->
                                            <div class="col-md-6">
                                                <label for="abreviatura" class="form-label"><b>Abreviatura:</b></label>
                                                <input type="text" class="form-control" name="abreviatura" value="{{$almacen->abreviatura}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <!-- Código Sunat -->
                                            <div class="col-md-6">
                                                <label for="codigoSunat" class="form-label"><b>Código Sunat:</b></label>
                                                <input style="padding-right: 0;padding-left:  7px"  type="text" class="form-control"  value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_sunat')->first()}}" name="cod_sunat" autocomplete="off">
                                            </div>
                                            <!-- Cod. Ubigeo -->
                                            <div class="col-md-6">
                                                <label for="codigoUbigeo" class="form-label">
                                                    <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html" target="_blank" style="text-decoration: none;">
                                                        <i class="fa fa-podcast" aria-hidden="true"></i>
                                                    </a><b>Cod. Ubigeo:</b>
                                                </label>
                                                <div class="input-group">
                                                    <input type="text" name="ubigeo" class="form-control" value="{{$almacen->cod_postal}}" maxlength="6" minlength="6" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <!-- Descripción -->
                                            <div class="col-md-8">
                                                <label for="descripcion" class="form-label"><b>Descripción:</b></label>
                                                <textarea class="form-control" name="descripcion" autocomplete="off" required="required" >{{$almacen->descripcion}}</textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="estado" class="form-label">
                                                    <b>Estado:</b>
                                                </label>
                                                <div class="input-group">
                                                    @if($almacen->estado == 0)
                                                        @if($conteo_almacen == 1)
                                                        <div class="switch-button">
                                                            <input type="text" name="estado" value="on" hidden="hidden" autocomplete="off">
                                                            <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked  disabled="disabled" autocomplete="off"/>
                                                        </div>
                                                        @elseif($conteo_almacen >1)
                                                        <div class="switch-button">
                                                            <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked  autocomplete="off"/>
                                                        </div>
                                                        @endif
                                                    @elseif($almacen->estado == 1)
                                                        <div class="switch-button">
                                                            <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" autocomplete="off"/>
                                                        </div>
                                                    @endif
                                                </div>
                                                {{-- <div class="col-sm-1" style="vertical-align: middle;margin-top: auto;margin-bottom: auto">
                                                    @if($almacen->estado == 0)
                                                        @if($conteo_almacen == 1)
                                                        <div class="switch-button">
                                                            <input type="text" name="estado" value="on" hidden="hidden" autocomplete="off">
                                                            <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked  disabled="disabled" autocomplete="off"/>
                                                        </div>
                                                        @elseif($conteo_almacen >1)
                                                        <div class="switch-button">
                                                            <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked   autocomplete="off"/>
                                                        </div>
                                                        @endif
                                                    @elseif($almacen->estado == 1)
                                                        <div class="switch-button">
                                                            <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" autocomplete="off"/>
                                                        </div>
                                                    @endif
                                                </div> --}}
                                            </div>
                                        </div>
                                        <!-- Botón Guardar en el modal -->
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab_{{$index}}_sunat" role="tabpanel" aria-labelledby="tab4-tab">
                                    <!-- Sección de codificación de documentos -->
                                    <div class="col-md-12 mb-3">
                                        <!-- Centrado de la imagen y el texto de descripción -->
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRUkvtg9L1oBVOoWUMqrwmLVo4Fc4QF5xoNsg&s" width="100px" style="margin-right: 10px;">
                                            <label for="descripcion2" class="form-label" style="color: rgb(0, 0, 0); font-size: 22px; font-weight: bold;">Sunat:</label>
                                        </div>
                                    </div>
                                    <!-- Formulario de codificación dentro de la ventana 2 -->
                                    @php
                                        $codigo_sunat = $cod_guia_almacen->where('almacen_id', $almacen->id)->first();
                                    @endphp
                                    <div class="col-md-12">
                                        <div class="row mb-3">
                                            <!-- Cod. Facturación -->
                                            <div class="col-md-4" style="padding-right: 13px; padding-left: 13px">
                                                <h4 class="form-label text-center"><strong>Factura</strong></h4>
                                                <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                    <label for="edit_serie_factura" class="form-label"><b>Serie:</b></label>
                                                    <label for="edit_correlativo_factura" class="form-label"><b>Correlativo:</b></label>
                                                </div>
                                                <div class="input-group m-b" style="margin-bottom: 0px;justify-content: center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;F&nbsp;</span>
                                                    </div>
                                                    @if (is_numeric($codigo_sunat->cod_factura))
                                                        <input type="text" class="form-control" name="serie_factura" id="edit_serie_factura" autocomplete="off" maxlength="3" placeholder="001" value="{{$codigo_sunat->serie_factura}}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <input type="text" id="edit_correlativo_factura" name="cod_fac" class="form-control" max="8" placeholder="000" value="{{$codigo_sunat->cod_factura}}" autocomplete="off">
                                                    @else
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon form-control">{{$codigo_sunat->search_last_fact($almacen->id)['serie']}}</span>
                                                        </div>
                                                        <div class="input-group-prepend height-control">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon form-control">{{$codigo_sunat->search_last_fact($almacen->id)['correlativo']}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Cod. Boleta -->
                                            <div class="col-md-4" style="padding-right: 13px; padding-left: 13px">
                                                <h4 class="form-label text-center"><strong>Boleta</strong></h4>
                                                <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                    <label for="edit_serie_boleta" class="form-label"><b>Serie:</b></label>
                                                    <label for="edit_correlativo_boleta" class="form-label"><b>Correlativo:</b></label>
                                                </div>
                                                <div class="input-group m-b" style="margin-bottom: 0px;justify-content: center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;B&nbsp;</span>
                                                    </div>
                                                    @if (is_numeric($codigo_sunat->cod_boleta))
                                                        <input type="text" class="form-control write_button" name="serie_boleta" id="edit_serie_boleta" autocomplete="off" maxlength="3" placeholder="001" value="{{$codigo_sunat->serie_boleta}}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <input type="text" id="edit_correlativo_boleta" name="cod_bol" class="form-control write_button" max="8" placeholder="000" value="{{$codigo_sunat->cod_boleta}}" autocomplete="off">
                                                    @else
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_bol($almacen->id)['serie']}}</span>
                                                        </div>
                                                        <div class="input-group-prepend height-control">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_bol($almacen->id)['correlativo']}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Cod. Guía R -->
                                            <div class="col-md-4" style="padding-right: 13px; padding-left: 13px">
                                                <h4 class="form-label text-center"><strong>Guía Remisión</strong></h4>
                                                <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                    <label for="edit_serie_remision" class="form-label"><b>Serie:</b></label>
                                                    <label for="edit_correlativo_remision" class="form-label"><b>Correlativo:</b></label>
                                                </div>
                                                <div class="input-group m-b" style="margin-bottom: 0px;justify-content: center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;T&nbsp;</span>
                                                    </div>
                                                    @if (is_numeric($codigo_sunat->cod_remision))
                                                        <input type="text" class="form-control write_button" name="serie_remision" id="edit_serie_remision" autocomplete="off" maxlength="3" placeholder="001" value="{{$codigo_sunat->serie_remision}}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <input type="text" id="edit_correlativo_remision" name="cod_guia" class="form-control write_button" max="8" placeholder="000" value="{{$codigo_sunat->cod_remision}}" autocomplete="off">
                                                    @else
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_remision($almacen->id)['serie']}}</span>
                                                        </div>
                                                        <div class="input-group-prepend height-control">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_remision($almacen->id)['correlativo']}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <!-- Cod. Factura Manual -->
                                            <div class="col-md-4" style="padding-right: 13px; padding-left: 13px">
                                                <h4 class="form-label text-center"><strong>Factura Manual</strong></h4>
                                                <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                    <label for="edit_serie_factura_m" class="form-label"><b>Serie:</b></label>
                                                    <label for="edit_correlativo_factura_m" class="form-label"><b>Correlativo:</b></label>
                                                </div>
                                                <div class="input-group m-b" style="margin-bottom: 0px;justify-content: center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;FA&nbsp;</span>
                                                    </div>
                                                    @if (is_numeric($codigo_sunat->cod_factura_m))
                                                        <input type="text" class="form-control write_button" name="serie_factura_m" id="edit_serie_factura_m" autocomplete="off" maxlength="3" placeholder="001" value="{{$codigo_sunat->serie_factura_m}}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <input type="text" id="edit_correlativo_factura_m" name="cod_factura_m" class="form-control write_button" max="8" placeholder="000" value="{{$codigo_sunat->cod_factura_m}}" autocomplete="off">
                                                    @else
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_factura_m($almacen->id)['serie'] ?? '0'}}</span>
                                                        </div>
                                                        <div class="input-group-prepend height-control">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_factura_m($almacen->id)['correlativo'] ?? '0'}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Cod. Boleta Manual -->
                                            <div class="col-md-4" style="padding-right: 13px; padding-left: 13px">
                                                <h4 class="form-label text-center"><strong>Boleta Manual</strong></h4>
                                                <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                    <label for="edit_serie_boleta_m" class="form-label"><b>Serie:</b></label>
                                                    <label for="edit_correlativo_boleta_m" class="form-label"><b>Correlativo:</b></label>
                                                </div>
                                                <div class="input-group m-b" style="margin-bottom: 0px;justify-content: center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;BA&nbsp;</span>
                                                    </div>
                                                    @if (is_numeric($codigo_sunat->cod_boleta_m))
                                                        <input type="text" class="form-control write_button" name="serie_boleta_m" id="edit_serie_boleta_m" autocomplete="off" maxlength="3" placeholder="001" value="{{$codigo_sunat->serie_boleta_m}}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <input type="text" id="edit_correlativo_boleta_m" name="cod_boleta_m" class="form-control write_button" max="8" placeholder="000" value="{{$codigo_sunat->cod_boleta_m}}" autocomplete="off">
                                                    @else
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_boleta_m($almacen->id)['serie']}}</span>
                                                        </div>
                                                        <div class="input-group-prepend height-control">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_boleta_m($almacen->id)['correlativo']}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Cod. Guía Remisión Manual -->
                                            <div class="col-md-4" style="padding-right: 13px; padding-left: 13px">
                                                <h4 class="form-label text-center"><strong>Guia Remision Manual</strong></h4>
                                                <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                    <label for="edit_serie_boleta_m" class="form-label"><b>Serie:</b></label>
                                                    <label for="edit_correlativo_boleta_m" class="form-label"><b>Correlativo:</b></label>
                                                </div>
                                                <div class="input-group m-b" style="margin-bottom: 0px;justify-content: center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;BA&nbsp;</span>
                                                    </div>
                                                    @if (is_numeric($codigo_sunat->cod_remision_m))
                                                        <input type="text" class="form-control write_button" name="serie_remision_m" id="edit_serie_boleta_m" autocomplete="off" maxlength="3" placeholder="001" value="{{$codigo_sunat->serie_remision_m}}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <input type="text" id="edit_correlativo_boleta_m" name="cod_remision_m" class="form-control write_button" max="8" placeholder="000" value="{{$codigo_sunat->cod_remision_m}}" autocomplete="off">
                                                    @else
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_remision_m($almacen->id)['serie']}}</span>
                                                        </div>
                                                        <div class="input-group-prepend height-control">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_remision_m($almacen->id)['correlativo']}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <!-- Cod. Nota Crédito Factura -->
                                            <div class="col-md-4" style="padding-right: 13px; padding-left: 13px">
                                                <h4 class="form-label text-center"><strong>Nota de Credito Factura</strong></h4>
                                                <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                    <label for="edit_serie_credito_f" class="form-label"><b>Serie:</b></label>
                                                    <label for="edit_correlativo_credito_f" class="form-label"><b>Correlativo:</b></label>
                                                </div>
                                                <div class="input-group m-b" style="margin-bottom: 0px;justify-content: center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;FF&nbsp;</span>
                                                    </div>
                                                    @if (is_numeric($codigo_sunat->cod_nota_credito))
                                                        <input type="text" class="form-control write_button" name="serie_credito" id="edit_serie_credito_f" autocomplete="off" maxlength="3" placeholder="001" value="{{$codigo_sunat->serie_nota_credito}}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <input type="text" id="edit_correlativo_credito_f" name="cod_credito" class="form-control write_button" max="8" placeholder="000" value="{{$codigo_sunat->cod_nota_credito}}" autocomplete="off">
                                                    @else
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_credito_f($almacen->id)['serie']}}</span>
                                                        </div>
                                                        <div class="input-group-prepend height-control">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_credito_f($almacen->id)['correlativo']}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                        <!-- Cod. Nota Crédito Boleta -->
                                            <div class="col-md-4" style="padding-right: 13px; padding-left: 13px">
                                                <h4 class="form-label text-center"><strong>Nota de Boleta Factura</strong></h4>
                                                <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                    <label for="edit_serie_credito_b" class="form-label"><b>Serie:</b></label>
                                                    <label for="edit_correlativo_credito_b" class="form-label"><b>Correlativo:</b></label>
                                                </div>
                                                <div class="input-group m-b" style="margin-bottom: 0px;justify-content: center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;BB&nbsp;</span>
                                                    </div>
                                                    @if (is_numeric($codigo_sunat->cod_nota_credito_b))
                                                        <input type="text" class="form-control write_button" name="serie_credito_b" id="edit_serie_credito_b" autocomplete="off" maxlength="3" placeholder="001" value="{{$codigo_sunat->serie_nota_credito_b}}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <input type="text" id="edit_correlativo_credito_b" name="cod_credito_b" class="form-control write_button" max="8" placeholder="000" value="{{$codigo_sunat->cod_nota_credito_b}}" autocomplete="off">
                                                    @else
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_credito_b($almacen->id)['serie']}}</span>
                                                        </div>
                                                        <div class="input-group-prepend height-control">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_credito_b($almacen->id)['correlativo']}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Cod. Nota Débito -->
                                            <div class="col-md-4" style="padding-right: 13px; padding-left: 13px">
                                                <h4 class="form-label text-center"><strong>Nota de Debito</strong></h4>
                                                <div class="input-group m-b" style="justify-content: space-between;margin-bottom: 0px">
                                                    <label for="edit_serie_debito" class="form-label"><b>Serie:</b></label>
                                                    <label for="edit_correlativo_debito" class="form-label"><b>Correlativo:</b></label>
                                                </div>
                                                <div class="input-group m-b" style="margin-bottom: 0px;justify-content: center">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">&nbsp;BB&nbsp;</span>
                                                    </div>
                                                    @if (is_numeric($codigo_sunat->cod_nota_debito))
                                                        <input type="text" class="form-control write_button" name="serie_debito" id="edit_serie_debito" autocomplete="off" maxlength="3" placeholder="001" value="{{$codigo_sunat->serie_nota_debito}}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <input type="text" id="edit_correlativo_debito" name="cod_debito" class="form-control write_button" max="8" placeholder="000" value="{{$codigo_sunat->cod_nota_debito}}" autocomplete="off">
                                                    @else
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_debito($almacen->id)['serie']}}</span>
                                                        </div>
                                                        <div class="input-group-prepend height-control">
                                                            <span class="input-group-addon">&nbsp;-&nbsp;</span>
                                                        </div>
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">{{$codigo_sunat->search_last_debito($almacen->id)['correlativo']}}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" nmae="action" style="">Guardar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    @endforeach

    <!-- FIN -->

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
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 12px;
        }
        .select2-container--default .select2-selection--single {
            border: none;
        }
        span.select2.select2-container.select2-container--default{
            width: 100%!important;
            background-color: #FFFFFF;
            background-image: none;
            border-radius: 1px;
            display: block;
            padding: 3px 12px;
            border: 1px solid #e5e6e7;
        }
        span.select2-container.select2-container--default.select2-container--open{
            z-index: 999999;
        }
        .height-control{
            height: calc(1.6em + 0.75rem + 2px);
        }
        </style>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    @foreach($almacenes as $almacen)
    <style>
        .switchery > span {
            margin-left: 25px;
            line-height: 28px;
            font-family: tahoma;
            color: white;
        }
    </style>
    <script>
        var elem{{$almacen->id}} = document.querySelector('.js-switch{{$almacen->id}}');
        var switchery = new Switchery(elem{{$almacen->id}}, { color: '#4cc0f7' });

        $(".js-switch{{$almacen->id}}").siblings(".switchery").css("width", "100px")
        .prepend("<span>Activo</span>").find("small").css("left", "70px");

        elem{{$almacen->id}}.onchange = function() {
            $(".switchery").find("span").toggle();
        };

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
        $(".select2-responsable").select2({
            placeholder: "Seleccionar Responsable",
        });
        $(".select2_edit_responsable").select2({
            placeholder: "Seleccionar Responsable",
        });

    </script>
    <script>
        $('#button_save_almacen').on('click', function(){
            var form = $('#form_almacen_store')[0];
            if (!form.checkValidity()) {
                return form.reportValidity();
            }
            $('#button_save_almacen').css('display', 'none');
            $('#button_save_sunat').css('display', 'block');
            $('#tab2-tab').click();
            $('#valid_tab_1').val("1");
        });
        $('#button_save_sunat').on('click', function(){
            // 
            // submit_form
            var form = $('#form_almacen_store')[0];
            if (!form.checkValidity()) {
                var nombre = $.trim($('#almacen_nombre').val());
                var responsable = $('#select2-responsable').val();
                var direccion = $.trim($('#almacen_direccion').val());
                var abreviatura = $.trim($('#almacen_abreviatura').val());
                var sunat = $.trim($('#almacen_sunat').val());
                var ubigeo = $.trim($('#almacen_ubigeo').val());
                var descripcion = $.trim($('#descripcion_almacen').val());
                var responsableValido = responsable && (Array.isArray(responsable) ? responsable.length > 0 : $.trim(responsable) !== "");
                if (responsableValido && direccion && abreviatura && sunat && ubigeo && descripcion)  {
                    $('#valid_tab_1').val("1");
                }else{
                    // $('#valid_tab_1').val("")
                    form.reportValidity();
                    $('#tab1-tab').click();
                }
                return;
            }
            $('#submit_sunat').click();
            console.log("a");
        });
    </script>
@endsection
