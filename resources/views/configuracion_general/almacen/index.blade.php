@extends('layout')
@section('title', 'Almacén')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('button2', 'Inicio')
@section('config',route('Configuracion'))

@section('content')

    <!-- Modal Create  -->
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-left: 450px;">
            <div class="modal-content" style="width: 702px;">
                <div style="padding-left: 15px;padding-right: 15px;">
                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center" onsubmit="return valida(this)">
                        <form action="{{route('almacen.store')}}"  enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group  row">
                                <div class="col-sm-12" style="padding-bottom: 15px">
                                    <img src="{{asset('img/logos/almacen.svg')}}" width="100px">
                                </div>
                                <label class="col-sm-2 col-form-label">Nombre:</label>
                                <div class="col-sm-4">
                                    <input type="text" placeholder="Almacén" class="form-control" required="required" name="nombre" autocomplete="off" >
                                </div>
                                <br>
                                <label class="col-sm-2 col-form-label">Abreviatura:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="abreviatura" autocomplete="off" required="required" placeholder="ALM.">
                                </div>
                                <label class="col-sm-2 col-form-label">Responsable:</label>
                                <div class="col-sm-4">
                                    <select name="responsable" required  class="form-control m-b" autocomplete="off" required="required" style="margin-bottom: 0px;">
                                        @foreach($personal as $personals)
                                        <option value="{{$personals->id}}" > {{$personals->nombres}} {{$personals->apellidos}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Código Sunat:</label>
                                <div class="col-sm-4">
                                    <input  type="number" class="form-control" name="cod_sunat" autocomplete="off" required="required" placeholder="Numero de sucursal">
                                </div>
                                <label class="col-sm-2 col-form-label">Dirección:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Av. , Calle, Ciudad" name="direccion" autocomplete="off" required="required">
                                </div>
                                <label class="col-sm-2 col-form-label">Cod. Ubigeo: <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html"  target="_blank" style="margin: auto" ><i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999" ></i></a></label>
                                <div class="col-sm-4">
                                    <input type="text"  class="form-control" name="ubigeo" autocomplete="off" required="required" value="150101" minlength="6" maxlength="6">
                                </div>
                                <label class="col-sm-2 col-form-label">Descripción:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="descripcion" autocomplete="off" required="required">Almacen ...</textarea>
                                </div>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div class="col-sm-12">
                                    <p class="form-control"  style="background: #57b59738;text-align: left;font-family: fangsong;"><b>Nota:</b>Los campos siguientes es el numero de registro que se continuara en el sistema.</p>
                                </div>
                                <div class="col-lg-4 ">
                                    <label class="col-sm-12 col-form-label">Cod.Facturación:</label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">F00 &nbsp;</span>
                                        </div>
                                        <input type="text" value="" class="form-control write_button" name="serie_factura" autocomplete="off"  required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">- 000</span>
                                        </div>
                                        <input type="text" value="" required name="cod_fac" class="form-control write_button">
                                    </div>
                                </div>
                                <div class="col-lg-4 ">
                                    <label class="col-sm-12 col-form-label">Cod.Boleta:</label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">B00 &nbsp;</span>
                                        </div>
                                        <input type="text" value="" class="form-control write_button" name="serie_boleta" autocomplete="off"  required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">- 000</span>
                                        </div>
                                        <input type="text" value="" required name="cod_bol" class="form-control write_button">
                                    </div>
                                </div>
                                <div class="col-lg-4 ">
                                    <label class="col-sm-12 col-form-label">Cod.Guía R.:</label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">T00 &nbsp;</span>
                                        </div>
                                        <input type="text" value="" class="form-control write_button" name="serie_remision" autocomplete="off"  required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">- 000</span>
                                        </div>
                                        <input type="text" value="" required name="cod_guia" class="form-control write_button">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="col-sm-12 col-form-label">Cod. Nota Crédito Factura:</label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">FF0 &nbsp;</span>
                                        </div>
                                        <input type="text" value="" class="form-control write_button" name="serie_credito" autocomplete="off"  required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">- 000</span>
                                        </div>
                                        <input type="text" value="" required name="cod_credito" class="form-control write_button">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="col-sm-12 col-form-label">Cod. Nota Crédito Boleta:</label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">BB0 &nbsp;</span>
                                        </div>
                                        <input type="text" value="" class="form-control write_button" name="serie_credito_b" autocomplete="off" required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">- 000</span>
                                        </div>
                                        <input type="text" value="" required name="cod_credito_b" class="form-control write_button">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="col-sm-12 col-form-label">Cod. Nota Débito:</label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">F00 &nbsp;</span>
                                        </div>
                                        <input type="text" value="" class="form-control write_button" name="serie_debito" autocomplete="off" required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">- 000</span>
                                        </div>
                                        <input type="text" value="" required name="cod_debito" class="form-control write_button">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="col-sm-12 col-form-label">Cod. Factura manual:</label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">FA0 &nbsp;</span>
                                        </div>
                                        <input type="text" value="" class="form-control write_button" name="serie_boleta_m" autocomplete="off" required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">- 000</span>
                                        </div>
                                        <input type="text" value="" required name="cod_boleta_m" class="form-control write_button">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="col-sm-12 col-form-label">Cod. Boleta manual:</label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">BA0 &nbsp;</span>
                                        </div>
                                        <input type="text" value="" class="form-control write_button" name="serie_factura_m" autocomplete="off" required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">- 000</span>
                                        </div>
                                        <input type="text" value="" required name="cod_factura_m" class="form-control write_button">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="col-sm-12 col-form-label">Cod. Guia Remision manual:</label>
                                    <div class="input-group m-b">
                                        <div class="input-group-prepend">
                                            <span class="input-group-addon">TA0 &nbsp;</span>
                                        </div>
                                        <input type="text" value="" class="form-control write_button" name="serie_remision_m" autocomplete="off" required="required">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">- 000</span>
                                        </div>
                                        <input type="text" value="" required name="cod_remision_m" class="form-control write_button">
                                    </div>
                                </div>-
                            </div>
                            <button class="btn btn-primary" type="submit" name="action" id="boton">Guardar</button>
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
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Abreviatura</th>
                                        <th>Dirección</th>
                                        <th>Responsable</th>
                                        <th>Descripción</th>
                                        <th>Activo/Desactivo</th>
                                        <th></th>
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
                                        <td>@if($almacen->estado==0)Activo @elseif($almacen->estado==1)Desactivo @endif</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$almacen->id}}"><i class="fa fa-edit"></i></button>
                                            <div class="modal fade" id="exampleModal{{$almacen->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document"style="margin-left: 450px;">
                                                    <div class="modal-content" style="width: 702px;">
                                                        <div style="padding-left: 15px;padding-right: 15px;">
                                                            <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                                                                <form action="{{route('almacen.update',$almacen->id)}}"  enctype="multipart/form-data" method="post">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="form-group  row">
                                                                        <div class="col-sm-12" style="padding-bottom: 15px">
                                                                            <img src="{{asset('img/logos/almacen.svg')}}" width="100px">
                                                                        </div>
                                                                        <label class="col-sm-2 col-form-label">Nombre:</label>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control" name="nombre" value="{{$almacen->nombre}}">
                                                                        </div>
                                                                        <label class="col-sm-2 col-form-label">Abreviatura:</label>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control" name="abreviatura" value="{{$almacen->abreviatura}}">
                                                                        </div>
                                                                        <label class="col-sm-2 col-form-label">Responsable:</label>
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control" name="responsable">
                                                                                <option value="{{$almacen->personal->id}}">{{$almacen->personal->nombres}}</option>
                                                                                <option disabled="disabled">----------------------------</option>
                                                                                @foreach($personal as $personals)
                                                                                <option value="{{$personals->id}}">{{$personals->nombres}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <label class="col-sm-2 col-form-label">Código Sunat:</label>
                                                                        <div class="col-sm-4">
                                                                            <input style="padding-right: 0;padding-left:  7px"  type="text" class="form-control"  value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_sunat')->first()}}" name="cod_sunat">
                                                                        </div>
                                                                        <label class="col-sm-2 col-form-label">Dirección:</label>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control" name="direccion" value="{{$almacen->direccion}}">
                                                                        </div>
                                                                        <label class="col-sm-2">Cod. Ubigeo: <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html"  target="_blank" style="margin: auto" ><i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999" ></i></a></label>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" name="ubigeo" class="form-control" value="{{$almacen->cod_postal}}" maxlength="6" minlength="6">
                                                                        </div>
                                                                        <label class="col-sm-2 col-form-label">Descripción:</label>
                                                                        <div class="col-sm-6">
                                                                            <textarea class="form-control" name="descripcion" autocomplete="off" required="required" >{{$almacen->descripcion}}</textarea>
                                                                        </div>
                                                                        <label class="col-sm-2 col-form-label" style="vertical-align: middle;margin-top: auto;margin-bottom: auto">Activo/desactivo:</label>
                                                                        <div class="col-sm-1" style="vertical-align: middle;margin-top: auto;margin-bottom: auto">
                                                                            @if($almacen->estado == 0)
                                                                                @if($conteo_almacen == 1)
                                                                                <div class="switch-button">
                                                                                    <input type="text" name="estado" value="on" hidden="hidden">
                                                                                    <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked  disabled="disabled" />
                                                                                </div>
                                                                                @elseif($conteo_almacen >1)
                                                                                <div class="switch-button">
                                                                                    <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked   />
                                                                                </div>
                                                                                @endif
                                                                            @elseif($almacen->estado == 1)
                                                                                <div class="switch-button">
                                                                                    <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" />
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group  row">
                                                                        <div class="col-lg-4 ">
                                                                            <label class="col-sm-12 col-form-label">Cod.Facturación:</label>
                                                                            <div class="input-group m-b">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-addon">F00 &nbsp;</span>
                                                                                </div>
                                                                                @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura')->first()))
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_factura')->first()}}" class="form-control" name="serie_factura" autocomplete="off" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura')->first()}}" name="cod_fac" class="form-control ">
                                                                                @else
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_factura')->first()}}" class="form-control" name="serie_factura" autocomplete="off" readonly="" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="" readonly name="cod_fac" class="form-control ">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 ">
                                                                            <label class="col-sm-12 col-form-label">Cod.Boleta:</label>
                                                                            <div class="input-group m-b">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-addon">B00 &nbsp;</span>
                                                                                </div>
                                                                                @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta')->first()))
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_boleta')->first()}}" class="form-control" name="serie_boleta" autocomplete="off" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta')->first()}}" name="cod_bol" class="form-control ">
                                                                                @else
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_boleta')->first()}}" class="form-control" name="serie_boleta" autocomplete="off" readonly="" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="" readonly name="cod_bol" class="form-control ">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 ">
                                                                            <label class="col-sm-12 col-form-label">Cod.Guía R.:</label>
                                                                            <div class="input-group m-b">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-addon">T00 &nbsp;</span>
                                                                                </div>
                                                                                @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision')->first()))
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_remision')->first()}}" class="form-control" name="serie_remision" autocomplete="off" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision')->first()}}" name="cod_guia" class="form-control ">
                                                                                @else
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_remision')->first()}}" class="form-control" name="serie_remision" autocomplete="off" readonly="" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="" readonly name="cod_guia" class="form-control ">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row"> 
                                                                        <div class="col-lg-4">
                                                                            <label class="col-sm-12 col-form-label">Cod. Nota Crédito Factura:</label>
                                                                            <div class="input-group m-b">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-addon">FF0 &nbsp;</span>
                                                                                </div>
                                                                                @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito')->first()))
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_credito')->first()}}" class="form-control" name="serie_credito" autocomplete="off" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito')->first()}}" name="cod_credito" class="form-control ">
                                                                                @else
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_credito')->first()}}" class="form-control" name="serie_credito" autocomplete="off" readonly="" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="" readonly name="cod_credito" class="form-control ">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <label class="col-sm-12 col-form-label">Cod. Nota Crédito Boleta:</label>
                                                                            <div class="input-group m-b">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-addon">BB0 &nbsp;</span>
                                                                                </div>
                                                                                @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito_b')->first()))
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_credito_b')->first()}}" class="form-control" name="serie_credito_b" autocomplete="off" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito_b')->first()}}" name="cod_credito_b" class="form-control ">
                                                                                @else
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_credito_b')->first()}}" class="form-control" name="serie_credito_b" autocomplete="off" readonly="" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="" readonly name="cod_credito" class="form-control ">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <label class="col-sm-12 col-form-label">Cod. Nota Débito:</label>
                                                                            <div class="input-group m-b">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-addon">F00 &nbsp;</span>
                                                                                </div>
                                                                                @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_debito')->first()))
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_debito')->first()}}" class="form-control" name="serie_debito" autocomplete="off" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_debito')->first()}}" name="cod_debito" class="form-control ">
                                                                                @else
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_debito')->first()}}" class="form-control" name="serie_debito" autocomplete="off" readonly="" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="" readonly name="cod_debito" class="form-control ">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row"> 
                                                                        
                                                                        <div class="col-lg-4">
                                                                            <label class="col-sm-12 col-form-label">Cod. Factura manual:</label>
                                                                            <div class="input-group m-b">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-addon">FA0 &nbsp;</span>
                                                                                </div>
                                                                                @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura_m')->first()))
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_factura_m')->first()}}" class="form-control" name="serie_factura_m" autocomplete="off" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura_m')->first()}}" name="cod_factura_m" class="form-control ">
                                                                                @else
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_factura_m')->first()}}" class="form-control" name="serie_factura_m" autocomplete="off" readonly="" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="" readonly name="cod_factura_m" class="form-control ">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <label class="col-sm-12 col-form-label">Cod. Boleta manual:</label>
                                                                            <div class="input-group m-b">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-addon">BA0 &nbsp;</span>
                                                                                </div>
                                                                                @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta_m')->first()))
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_boleta_m')->first()}}" class="form-control" name="serie_boleta_m" autocomplete="off" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta_m')->first()}}" name="cod_boleta_m" class="form-control ">
                                                                                @else
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_boleta_m')->first()}}" class="form-control" name="serie_boleta_m" autocomplete="off" readonly="" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="" readonly name="cod_boleta_m" class="form-control ">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <label class="col-sm-12 col-form-label">Cod. Guia Remision manual:</label>
                                                                            <div class="input-group m-b">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-addon">TA0 &nbsp;</span>
                                                                                </div>
                                                                                @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision_m')->first()))
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_remision_m')->first()}}" class="form-control" name="serie_remision_m" autocomplete="off" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision_m')->first()}}" name="cod_remision_m" class="form-control ">
                                                                                @else
                                                                                    <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_remision_m')->first()}}" class="form-control" name="serie_remision_m" autocomplete="off" readonly="" required="required">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-addon">- 000</span>
                                                                                    </div>
                                                                                    <input type="text" value="" readonly name="cod_boleta_m" class="form-control ">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-primary" type="submit" name="action">Guardar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

    <style>
        .form-control{
            margin-top: 6px;
        }
        .input-group-append{
            margin-top: 6px;
        }
        .input-group-prepend{
            margin-top: 6px;
        }
    </style>

    <tbody>


    <!-- Modal CREAR ALMACEN FLAVIA-->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Added 'modal-lg' for a larger size -->
            <div class="modal-content">
                <!-- Formulario de Almacén -->
                <form action="{{route('almacen.store')}}"  enctype="multipart/form-data" method="post">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel" style="color: blue; font-size: 18px; font-weight: bold;">Agregar nuevo Almacén</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" style="color: blue; font-size: 20px; padding: 0; margin: 0; border: none; background: none;">
                            <strong>x</strong>
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
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                <!-- Aquí se agrega el contenido del modal -->
                                <div class="col-md-12 mb-3">
                                    <!-- Título con ícono -->
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAABLFBMVEX///8AAACMuvr5qktXW3rp6eoxZaPBdiv/65aRwP//rk3j4+NZXX3t7e1undwrYJ4ePWOebDA9UW2Drupvb29kZGQOEhgmJibFxcY5PFCLXyrMgDHJey1TV3QMDRFUcJfklz+OVyDFxMxNUGs4SmMlLUy9gTnqoEffmEM3JhBZPRtCPSf/9JzbyoEuMEETExPn1YiuoGZ6SxulpaW7usIuLi7W1te0tLSKiopLS0sgICF4eHg7OztGXn5UVFenpq0YHjKcxPuvaydISEiUlJRefaiFse0tPFFwlcheXWF+VibMiz0hFwqweDVYdZ1lhrWWilgdJzUVHCYoU4YVK0WenaQeICxAQllLRSzDs3M1MR8lIhZfVzh+dEqdkVwcEwlqSCBgQh1YispCLRQGFCSvAAAKZklEQVR4nO2da2PixhWGESzeSFTO2oDNOlk73aQGs66xQ83N4HRrDNisr2k39Sbpetv//x8qaYQuM2ekQYyumfcTlkYwj87MeecicC4nJCQklC3VepVqpVeLuxphqdgbSEiDXinuyoSg2rnk1EXGAqmOtyVcg3Ex7mpxU6dC4CFVsxHI9imFT9d2O+7qrarSGYbUOm1hR846cVdyBXXPMZp+u6N2yKNdNe6aBlLJMgcrWjVVLRaLqtrBI5tG+6jhgdpuFw2+osFYJHpnvxt3lZeR2sbDV61ZeAvIWmUX66KpsQ/CHE7HHYwPMXbGeCDTYR99rNbn3SKJZ0IWiawzTL59VN0trweFzxXIXtrsw5U92tTweQbyItFZxxELPLsYMVOhg7Xk20fJ8uwrM7u0SxBKu9/qt6ETJcI+zhOUddSxngaNV8ViqS8B5mB2ObPyUOfUAlnFGKVxMsY6C3Oo5Mxa12oQQLF75aj7FZBgIfuoxB/I9tCqTceqKdAIibqDJqndBzyQw3acgXSPLzt4fT3anyFaW06MfXQvXPXog8ag55ChRNMQzkddfNQwjME+iJnDoAMQ6j6AR8StFuwpsdtHDb/Jp5C3a8G4wMo93E3uHrBjFxT7wEPfjyzrGObgko85WNqcyXJelssj/ATFPoj1nUjsg5g5DBmT4sNlWc4jyZPLI+wszT7wQIY9+1CJpsNqbJuz/ILPYMzPNrESSbAPYlmJuXXtlZ14i0DeYlNgamvHy1XCsQ8ia9AGmHiYp3d5ks9glGc/4IGk2AcxjeS+eEWYAzXLY/d7d7QO45mQ5b0trPK0N8ZcZ5erfRDLSrRbjZvI0d3Eiw/1yLspdtUFYD2gfXAaB6hj3LNZzWGkm4O/YraP4OZw6xs+ByRpH+fdEjiC52sf3MyBgZHZPohhfHD7IFammWeukDkwQJaZ7QP/wED20cXDRxs+4uGb3jH1PpCRtI8BY047XTLrlPA5WqvCZg5bo3JgPjOQo0c8QHAgz/B19SXso3aFXQtP44pt/EZO/c2BgTG4fZwzBTK4OWyymQMDo7wenn0Aew5g+Lp4mB8uOYTPAZm/xKeR0O7AsvZBmkOVcU6ztDmwMJL2AQaS3T6iNgcGyPItPmhdwT5Ic+hC70XubE559T6QUZ7hWWcAdhtf+2hj2WXAuD70OAopfA5I0j7gypH2YW/UqdjM7yJKc2BgnBD2AW5qafaBg5j9UXUHkHWddrPMPbtQGfPE7KN1xmIfLYTo7IE0c8AniA+XkeEtIJntw5kphjqgY22wCmYXDjMHPoyM9qE6Z3LjnL2lCW5IA+awFZY5MECy24fVpzSbWMDCQz/SHGIIn4MxT9gHpWMtmmY3Z3bNcULMgQESsg8gPCZiJYce/GzhJbTwxWQO/gLsQzc4nAA11G2zG1Zc5/WGjNvnKN7m6RZgHwPcPlSzdQKESTAHf8nrr/DG2nfZh0WItVI9fKQ5hDj0DKz1tbWf/4nVdNvhB1YrdWUat5cYerxNQHaBtP712tra
                                        168I+zA93c40lluo0MxBGiWueS5kEGp6hVfZWJBXbbewH2Lq41svuvaSCkgn1HRhJxL3qC0zhLaMGRQUOqlXSxlhjZjnG8FEsyfc+rSWnMsVU0ZY0gagRBYZqOAMGK1xlNJHSCwV9u0VKXsV47RtPmydSkKt6dl20HI/btw9084Me/YS1WqEMqmlSwQi1APZG+oovrtuqxDKs9EPuEZ3riJ3QInZUp9FJWTVCoTyLZTWtMGDLWLV3tDtMh8WJ+EErL4kzezaUUos8ylxEs4o9b+0nom69L0HySYs+9afdg/KKSGU4V42dRTB5+hIo7T0w3yeeAxIr/7EUWAC3IStvaU+I15CwOwwu/MvkWzCKCQIBaEgjF+CUBAKwvglCAXhMoRyflIOQxPPHYXoCOXZaPq4FYYep15LN1ERymV4qsdLU+rOV0SEMm22zk+0MEZDGAEgdfEmohhGAEhbgYuEkLIgw1vw8k0khNbCaP9KV4WzrG3OCfThkRCavbD101tdHZW3auaGEdgToyCU91CZ8VtEiD+WtLLUrkclIiFEzwq2/oYIS9wJix0UxM2YCQfhEZYGglAQ8iFEgG+L3HOpmhDC3XOkKn9d7SaCMHwJQkEoCAWhNEDaDkHJIPwDOL4gFISCUBAKQn6EmZ09tf71k6Eaf3WTQRi+BKEgFIRZJVTRhV6Pz6ecMIe+e+L1bPmC8O9IR6/5K8y1tlxHv857+9BcTfwL0vd/4q4XoRLmct1Lz191JAhfcNebkAlz7734BKEgFISCkA8h+L0PS+/dhG/09J5QwlL7DNzcIr4Eicn8YYot9ODex49Hv7zgy8iLkPgpuhX0C1dEPoQq/V8XBNERT0Q+hPgvtawqnlHkQljjDCjt8gPkQ0j7/5LBxTGIXAiJn4xYWRx7IhdCdP5aKeBSDowz7w6/cuuv6IoNxxXKNy8NJZlwZyXCAiL8NmWEBUEoCAWhIBSEglAQCkIvwkDL2yki/Lj89sTR6+/B9Y+EEgbTLjTpyhShJL0mETNGCEydoyI8tiC1F4fhEX6MifDk3a//fjIZ7z/9+ttJaITSm1gIkX7XA3j8yXEkDEJiXyBCQunT8eGJqzZ0wut6w9YcHfvPsaUn83qj1Pwfhn5MAKHU+s19v+mEzvdSGujYid2Vj9GRfb2U8h268M9JIMTFRlggCBe52CAsIMKXglAQBiNUmibLhx2b68B6vZ8Bwht0qllXGp9NrOeCso9eterOsukkLCg7izNK4dkodaO/ruuxbc1dF6SUUEv1GzcNdELZbzafF6/nG/t1d/m0EhYURXG8tP5wHE47IbMYCBeILsfPEOHv9ydfGYxP9/fZJNTUejo8PH5n/ZlBQkm6f3L8kUlClwShIEw+4U1WCOsf0MHFyFYy/5YaWSE0x+/P9Q108rqAXjyjQvHOLfzERKiNaA+kA61JKvMPqG0q86b0ecM8GyOhUpjve6vhuMSDULtTBeNuKEpjXlAcB+IlVOaSr5pshC5WXPER1v0BnQ9SsRECio1wMZP31gdrni8Ik0eY/VbKlGm+2MVTSMjNLRTFuYthS0mB4zvL0vct5otRGq6sjEs9+rOxHpl6wsWqMqTnbBBuZJ6QOj00O2KiMw3bDik1iM/GeX6ExWUJlcbNhrduHIwebtGAr56DbkH7pjPwJbr3/0WAP5t3jApIc3yPFLHQ5zoDIbUpFADCFXS+LCHTqO2ZZdQGTJkcR7kRevw/R5CQJYRsI+/69f9AfYHWaYJrSAdcZW5xwNBK6VvlDZ6EXt+vBAn9NvGRNnxbqVdbuCbdIqgGHQ9AWqZpNL3fVL/GLh7E8b9wIzxTvQDpc4u6nxjmFl6tfYckrAb4afpe25sv7JG3Qm0KKE25CYN949xP4RIWChtNUDt1IJemk3AZx08nobcEoSAUhIIwW4Qr6ZtvDS3/Xt+9NC6MgLDpM6H30Y9Iy7/XDrqwGT5hMiQIBSGsVtxYDtFXBFdRO24sW9VQAHO5XtxgC1VCAszl+P9IdTCFBigkJBS3/g8iz4pzwL8w+gAAAABJRU5ErkJggg==" width="100px" style="margin-right: 10px;">
                                        <label for="descripcion1" class="form-label" style="color: rgb(0, 0, 0); font-size: 22px; font-weight: bold;">
                                            Almacén
                                        </label>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Nombre -->
                                        <div class="col-md-6">
                                            <label for="nombreAlmacen" class="form-label"><b>Nombre:</b></label>
                                            <input type="text" placeholder="Almacén" class="form-control" required="required" name="nombre" autocomplete="off">
                                        </div>
                                        <!-- Responsable -->
                                        <div class="col-md-6">
                                            <label for="responsable" class="form-label"><b>Responsable:</b></label>
                                            <select name="responsable" required  class="form-control m-b" autocomplete="off" required="required" style="margin-bottom: 0px;">
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
                                            <input type="text" class="form-control" placeholder="Av. , Calle, Ciudad" name="direccion" autocomplete="off" required="required">
                                        </div>
                                        <!-- Abreviatura -->
                                        <div class="col-md-6">
                                            <label for="abreviatura" class="form-label"><b>Abreviatura:</b></label>
                                            <input type="text" class="form-control" name="abreviatura" autocomplete="off" required="required" placeholder="ALM.">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Código Sunat -->
                                        <div class="col-md-6">
                                            <label for="codigoSunat" class="form-label"> <b>Código Sunat:</b></label>
                                            <input  type="number" class="form-control" name="cod_sunat" autocomplete="off" required="required" placeholder="Numero de sucursal">
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
                                                <input type="text"  class="form-control" name="ubigeo" autocomplete="off" required="required" value="150101" minlength="6" maxlength="6">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Descripción -->
                                        <div class="col-md-6">
                                            <label for="descripcion" class="form-label"><b>Descripción:</b></label>
                                            <textarea class="form-control" name="descripcion" autocomplete="off" required="required">Almacen ...</textarea>
                                        </div>
                                        <!-- Nota -->
                                        <div class="col-md-6 d-flex align-items-start"> <!-- Changed to align-items-start for better alignment -->
                                            <div class="alert alert-primary mb-0 mt-3" role="alert"> <!-- Added margin-top for spacing -->
                                                Nota: Los campos siguientes es el número de registro que se continuará en el sistema.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                <!-- Sección de codificación de documentos -->
                                <div class="col-md-12 mb-3">
                                    <!-- Centrado de la imagen y el texto de descripción -->
                                    <div style="display: flex; justify-content: center; align-items: center;">
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRUkvtg9L1oBVOoWUMqrwmLVo4Fc4QF5xoNsg&s" width="100px" style="margin-right: 10px;">
                                        <label for="descripcion2" class="form-label" style="color: rgb(0, 0, 0); font-size: 22px; font-weight: bold;">Sunat:</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row mb-3">
                                        <!-- Cod. Facturación -->
                                        <div class="col-md-4">
                                            <label for="codFacturacion" class="form-label"><b>Cod.Facturación:</b></label>
                                            <div class="input-group m-b">
                                                <input type="text" class="form-control input-blanco" value="F00" readonly>
                                                <input type="text" value="" class="form-control write_button" name="serie_factura" autocomplete="off"  required="required">
                                                <input type="text" class="form-control input-blanco" value="-000" readonly>
                                                <input type="text" value="" required name="cod_fac" class="form-control write_button">
                                            </div>

                                        </div>
                                        <!-- Cod. Boleta -->
                                        <div class="col-md-4">
                                            <label for="codBoleta" class="form-label"><b>Cod.Boleta:</b></label>
                                            <div class="input-group m-b">
                                                <input type="text" class="form-control input-blanco" value="B00" readonly>
                                                <input type="text" value="" class="form-control write_button" name="serie_boleta" autocomplete="off"  required="required">
                                                <input type="text" class="form-control input-blanco" value="-000" readonly>
                                                <input type="text" value="" required name="cod_bol" class="form-control write_button">
                                            </div>
                                        </div>
                                        <!-- Cod. Guía R -->
                                        <div class="col-md-4">
                                            <label for="codGuia" class="form-label"><b>Cod.Guía Remisión:</b></label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control input-blanco" value="T00" readonly>
                                                <input type="text" value="" class="form-control write_button" name="serie_remision" autocomplete="off"  required="required">
                                                <input type="text" class="form-control input-blanco" value="-000" readonly>
                                                <input type="text" value="" required name="cod_guia" class="form-control write_button">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- Cod. Nota Crédito Factura -->
                                        <div class="col-md-4">
                                            <label for="codNotaCreditoFactura" class="form-label"><b>Cod. Nota Crédito Factura:</b></label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control input-blanco" value="FF0" readonly>
                                                <input type="text" value="" class="form-control write_button" name="serie_credito" autocomplete="off"  required="required">
                                                <input type="text" class="form-control input-blanco" value="-000" readonly>
                                                <input type="text" value="" required name="cod_credito" class="form-control write_button">
                                            </div>
                                        </div>
                                        <!-- Cod. Nota Crédito Boleta -->
                                        <div class="col-md-4">
                                            <label for="codNotaCreditoBoleta" class="form-label"><b>Cod. Nota Crédito Boleta:</b></label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control input-blanco" value="BB0" readonly>
                                                <input type="text" value="" class="form-control write_button" name="serie_credito_b" autocomplete="off" required="required">
                                                <input type="text" class="form-control input-blanco" value="-000" readonly>
                                                <input type="text" value="" required name="cod_credito_b" class="form-control write_button">
                                            </div>
                                        </div>
                                        <!-- Cod. Nota Débito -->
                                        <div class="col-md-4">
                                            <label for="codNotaDebito" class="form-label"><b>Cod. Nota Débito:</b></label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control input-blanco" value="F00" readonly>
                                                <input type="text" value="" class="form-control write_button" name="serie_debito" autocomplete="off" required="required">
                                                <input type="text" class="form-control input-blanco" value="-000" readonly>
                                                <input type="text" value="" required name="cod_debito" class="form-control write_button">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <!-- Cod. Factura Manual -->
                                        <div class="col-md-4">
                                            <label for="codFacturaManual" class="form-label"><b>Cod. Factura manual:</b></label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control input-blanco" value="FA0" readonly>
                                                <input type="text" value="" class="form-control write_button" name="serie_boleta_m" autocomplete="off" required="required">
                                                <input type="text" class="form-control input-blanco" value="-000" readonly>
                                                <input type="text" value="" required name="cod_boleta_m" class="form-control write_button">
                                            </div>
                                        </div>
                                        <!-- Cod. Boleta Manual -->
                                        <div class="col-md-4">
                                            <label for="codBoletaManual" class="form-label"><b>Cod. Boleta manual:</b></label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control input-blanco" value="BA0" readonly>
                                                <input type="text" value="" class="form-control write_button" name="serie_factura_m" autocomplete="off" required="required">
                                                <input type="text" class="form-control input-blanco" value="-000" readonly>
                                                <input type="text" value="" required name="cod_factura_m" class="form-control write_button">
                                            </div>
                                        </div>
                                        <!-- Cod. Guía Remisión Manual -->
                                        <div class="col-md-4">
                                            <label for="codGuiaManual" class="form-label"><b>Cod. Guía Remisión manual:</b></label>
                                            <div class="d-flex">
                                                <input type="text" class="form-control input-blanco" value="TA0" readonly>
                                                <input type="text" value="" class="form-control write_button" name="serie_remision_m" autocomplete="off" required="required">
                                                <input type="text" class="form-control input-blanco" value="-000" readonly>
                                                <input type="text" value="" required name="cod_remision_m" class="form-control write_button">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" style="background-color: blue;">Guardar cambios</button>
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
                <div class="ibox ">
                    <div class="ibox-content" onsubmit="return valida(this)">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li>
                                    <a class="nav-link active show" data-toggle="tab" href=""><span style="color: green;">&#9632; </span> ALMACÉN
                                        {{-- link del tab 1 --}}
                                    </a>
                                </li>
                                <li class="ml-auto mb-2">
                                    <div class="row mx-2"> <!-- Usamos row para la distribución -->
                                        <!-- Input de búsqueda -->
                                        <div class="col-md-8 mb-2"> <!-- Ocupa más espacio -->
                                            <input type="search" class="form-control" placeholder="Buscar:" id="search_all_column">
                                        </div>

                                        <!-- Botón para agregar -->
                                        <div class="col-md-4 mb-2 "> <!-- Alineado a la derecha -->
                                            <button type="button" class="btn btn-success w-100" style="background-color: blue;" data-toggle="modal" data-target="#myModal">Agregar</button>
                                        </div>
                                    </div>
                                </li>    
                            </ul>
                        
                            <!-- Tablas y su contenido -->
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <div class="panel-body">
                                        <!-- CONTENIDO DENTRO DEL TAB  -->
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nombre</th>
                                                        <th>Abreviatura</th>
                                                        <th>Descripción</th>
                                                        <th>Responsable</th>
                                                        <th>Dirección</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($almacenes as $almacen)
                                                    <tr class="gradeX">
                                                        <td>{{$almacen->id}}</td>
                                                        <td>{{$almacen->nombre}}</td>
                                                        <td>{{$almacen->abreviatura}}</td>
                                                        <td>{{$almacen->descripcion}}</td>
                                                        <td>{{$almacen->personal->nombres}} {{$almacen->personal->apellidos}}</td>
                                                        <td>{{$almacen->direccion}}</td>
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
                                                    
                                                <!-- Modal DOS -->
                                                <div class="modal fade" id="editaralmacen{{$almacen->id}}" tabindex="-1" aria-labelledby="editaralmacenLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg"> <!-- Added 'modal-lg' for a larger size -->
                                                        <form action="{{route('almacen.update',$almacen->id)}}"  enctype="multipart/form-data" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editaralmacenLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar el almacén</h5>
                                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                            
                                                                <div class="modal-body">
                                                                    <!-- Nav tabs -->
                                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                        <li class="nav-item" role="presentation">
                                                                            <a class="nav-link active" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="true">Información General</a>
                                                                        </li>
                                                                        <li class="nav-item" role="presentation">
                                                                            <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Información de la Sunat</a>
                                                                        </li>
                                                                    </ul>
                                                                    <!-- Tab content -->
                                                                    <div class="tab-content mt-3" id="myTabContent">
                                                                        <div class="tab-pane fade show active" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                                                            <!-- Aquí se agrega el contenido del modal -->
                                                                            <div class="col-md-12 mb-3">
                                                                                <!-- Título con ícono -->
                                                                                <div style="display: flex; justify-content: center; align-items: center;">
                                                                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAABLFBMVEX///8AAACMuvr5qktXW3rp6eoxZaPBdiv/65aRwP//rk3j4+NZXX3t7e1undwrYJ4ePWOebDA9UW2Drupvb29kZGQOEhgmJibFxcY5PFCLXyrMgDHJey1TV3QMDRFUcJfklz+OVyDFxMxNUGs4SmMlLUy9gTnqoEffmEM3JhBZPRtCPSf/9JzbyoEuMEETExPn1YiuoGZ6SxulpaW7usIuLi7W1te0tLSKiopLS0sgICF4eHg7OztGXn5UVFenpq0YHjKcxPuvaydISEiUlJRefaiFse0tPFFwlcheXWF+VibMiz0hFwqweDVYdZ1lhrWWilgdJzUVHCYoU4YVK0WenaQeICxAQllLRSzDs3M1MR8lIhZfVzh+dEqdkVwcEwlqSCBgQh1YispCLRQGFCSvAAAKZklEQVR4nO2da2PixhWGESzeSFTO2oDNOlk73aQGs66xQ83N4HRrDNisr2k39Sbpetv//x8qaYQuM2ekQYyumfcTlkYwj87MeecicC4nJCQklC3VepVqpVeLuxphqdgbSEiDXinuyoSg2rnk1EXGAqmOtyVcg3Ex7mpxU6dC4CFVsxHI9imFT9d2O+7qrarSGYbUOm1hR846cVdyBXXPMZp+u6N2yKNdNe6aBlLJMgcrWjVVLRaLqtrBI5tG+6jhgdpuFw2+osFYJHpnvxt3lZeR2sbDV61ZeAvIWmUX66KpsQ/CHE7HHYwPMXbGeCDTYR99rNbn3SKJZ0IWiawzTL59VN0trweFzxXIXtrsw5U92tTweQbyItFZxxELPLsYMVOhg7Xk20fJ8uwrM7u0SxBKu9/qt6ETJcI+zhOUddSxngaNV8ViqS8B5mB2ObPyUOfUAlnFGKVxMsY6C3Oo5Mxa12oQQLF75aj7FZBgIfuoxB/I9tCqTceqKdAIibqDJqndBzyQw3acgXSPLzt4fT3anyFaW06MfXQvXPXog8ag55ChRNMQzkddfNQwjME+iJnDoAMQ6j6AR8StFuwpsdtHDb/Jp5C3a8G4wMo93E3uHrBjFxT7wEPfjyzrGObgko85WNqcyXJelssj/ATFPoj1nUjsg5g5DBmT4sNlWc4jyZPLI+wszT7wQIY9+1CJpsNqbJuz/ILPYMzPNrESSbAPYlmJuXXtlZ14i0DeYlNgamvHy1XCsQ8ia9AGmHiYp3d5ks9glGc/4IGk2AcxjeS+eEWYAzXLY/d7d7QO45mQ5b0trPK0N8ZcZ5erfRDLSrRbjZvI0d3Eiw/1yLspdtUFYD2gfXAaB6hj3LNZzWGkm4O/YraP4OZw6xs+ByRpH+fdEjiC52sf3MyBgZHZPohhfHD7IFammWeukDkwQJaZ7QP/wED20cXDRxs+4uGb3jH1PpCRtI8BY047XTLrlPA5WqvCZg5bo3JgPjOQo0c8QHAgz/B19SXso3aFXQtP44pt/EZO/c2BgTG4fZwzBTK4OWyymQMDo7wenn0Aew5g+Lp4mB8uOYTPAZm/xKeR0O7AsvZBmkOVcU6ztDmwMJL2AQaS3T6iNgcGyPItPmhdwT5Ic+hC70XubE559T6QUZ7hWWcAdhtf+2hj2WXAuD70OAopfA5I0j7gypH2YW/UqdjM7yJKc2BgnBD2AW5qafaBg5j9UXUHkHWddrPMPbtQGfPE7KN1xmIfLYTo7IE0c8AniA+XkeEtIJntw5kphjqgY22wCmYXDjMHPoyM9qE6Z3LjnL2lCW5IA+awFZY5MECy24fVpzSbWMDCQz/SHGIIn4MxT9gHpWMtmmY3Z3bNcULMgQESsg8gPCZiJYce/GzhJbTwxWQO/gLsQzc4nAA11G2zG1Zc5/WGjNvnKN7m6RZgHwPcPlSzdQKESTAHf8nrr/DG2nfZh0WItVI9fKQ5hDj0DKz1tbWf/4nVdNvhB1YrdWUat5cYerxNQHaBtP712tra
                                                                                    168I+zA93c40lluo0MxBGiWueS5kEGp6hVfZWJBXbbewH2Lq41svuvaSCkgn1HRhJxL3qC0zhLaMGRQUOqlXSxlhjZjnG8FEsyfc+rSWnMsVU0ZY0gagRBYZqOAMGK1xlNJHSCwV9u0VKXsV47RtPmydSkKt6dl20HI/btw9084Me/YS1WqEMqmlSwQi1APZG+oovrtuqxDKs9EPuEZ3riJ3QInZUp9FJWTVCoTyLZTWtMGDLWLV3tDtMh8WJ+EErL4kzezaUUos8ylxEs4o9b+0nom69L0HySYs+9afdg/KKSGU4V42dRTB5+hIo7T0w3yeeAxIr/7EUWAC3IStvaU+I15CwOwwu/MvkWzCKCQIBaEgjF+CUBAKwvglCAXhMoRyflIOQxPPHYXoCOXZaPq4FYYep15LN1ERymV4qsdLU+rOV0SEMm22zk+0MEZDGAEgdfEmohhGAEhbgYuEkLIgw1vw8k0khNbCaP9KV4WzrG3OCfThkRCavbD101tdHZW3auaGEdgToyCU91CZ8VtEiD+WtLLUrkclIiFEzwq2/oYIS9wJix0UxM2YCQfhEZYGglAQ8iFEgG+L3HOpmhDC3XOkKn9d7SaCMHwJQkEoCAWhNEDaDkHJIPwDOL4gFISCUBAKQn6EmZ09tf71k6Eaf3WTQRi+BKEgFIRZJVTRhV6Pz6ecMIe+e+L1bPmC8O9IR6/5K8y1tlxHv857+9BcTfwL0vd/4q4XoRLmct1Lz191JAhfcNebkAlz7734BKEgFISCkA8h+L0PS+/dhG/09J5QwlL7DNzcIr4Eicn8YYot9ODex49Hv7zgy8iLkPgpuhX0C1dEPoQq/V8XBNERT0Q+hPgvtawqnlHkQljjDCjt8gPkQ0j7/5LBxTGIXAiJn4xYWRx7IhdCdP5aKeBSDowz7w6/cuuv6IoNxxXKNy8NJZlwZyXCAiL8NmWEBUEoCAWhIBSEglAQCkIvwkDL2yki/Lj89sTR6+/B9Y+EEgbTLjTpyhShJL0mETNGCEydoyI8tiC1F4fhEX6MifDk3a//fjIZ7z/9+ttJaITSm1gIkX7XA3j8yXEkDEJiXyBCQunT8eGJqzZ0wut6w9YcHfvPsaUn83qj1Pwfhn5MAKHU+s19v+mEzvdSGujYid2Vj9GRfb2U8h268M9JIMTFRlggCBe52CAsIMKXglAQBiNUmibLhx2b68B6vZ8Bwht0qllXGp9NrOeCso9eterOsukkLCg7izNK4dkodaO/ruuxbc1dF6SUUEv1GzcNdELZbzafF6/nG/t1d/m0EhYURXG8tP5wHE47IbMYCBeILsfPEOHv9ydfGYxP9/fZJNTUejo8PH5n/ZlBQkm6f3L8kUlClwShIEw+4U1WCOsf0MHFyFYy/5YaWSE0x+/P9Q108rqAXjyjQvHOLfzERKiNaA+kA61JKvMPqG0q86b0ecM8GyOhUpjve6vhuMSDULtTBeNuKEpjXlAcB+IlVOaSr5pshC5WXPER1v0BnQ9SsRECio1wMZP31gdrni8Ik0eY/VbKlGm+2MVTSMjNLRTFuYthS0mB4zvL0vct5otRGq6sjEs9+rOxHpl6wsWqMqTnbBBuZJ6QOj00O2KiMw3bDik1iM/GeX6ExWUJlcbNhrduHIwebtGAr56DbkH7pjPwJbr3/0WAP5t3jApIc3yPFLHQ5zoDIbUpFADCFXS+LCHTqO2ZZdQGTJkcR7kRevw/R5CQJYRsI+/69f9AfYHWaYJrSAdcZW5xwNBK6VvlDZ6EXt+vBAn9NvGRNnxbqVdbuCbdIqgGHQ9AWqZpNL3fVL/GLh7E8b9wIzxTvQDpc4u6nxjmFl6tfYckrAb4afpe25sv7JG3Qm0KKE25CYN949xP4RIWChtNUDt1IJemk3AZx08nobcEoSAUhIIwW4Qr6ZtvDS3/Xt+9NC6MgLDpM6H30Y9Iy7/XDrqwGT5hMiQIBSGsVtxYDtFXBFdRO24sW9VQAHO5XtxgC1VCAszl+P9IdTCFBigkJBS3/g8iz4pzwL8w+gAAAABJRU5ErkJggg==" width="100px" style="margin-right: 10px;">
                                                                                    <label for="descripcion1" class="form-label" style="color: rgb(0, 0, 0); font-size: 22px; font-weight: bold;">
                                                                                        Almacén
                                                                                    </label>
                                                                                </div>
                                                                                <!-- Formulario de Almacén -->
                                                                                <div class="row mb-3">
                                                                                    <!-- Nombre -->
                                                                                    <div class="col-md-6">
                                                                                        <label for="nombreAlmacen" class="form-label"><b>Nombre:</b></label>
                                                                                        <input type="text" class="form-control" name="nombre" value="{{$almacen->nombre}}">
                                                                                    </div>
                                                                                    <!-- Responsable -->
                                                                                    <div class="col-md-6">
                                                                                        <label for="responsable" class="form-label"><b>Responsable:</b></label>
                                                                                        <select class="form-control" name="responsable">
                                                                                            <option value="{{$almacen->personal->id}}">{{$almacen->personal->nombres}}</option>
                                                                                            <option disabled="disabled">----------------------------</option>
                                                                                            @foreach($personal as $personals)
                                                                                            <option value="{{$personals->id}}">{{$personals->nombres}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <!-- Dirección -->
                                                                                    <div class="col-md-6">
                                                                                        <label for="direccion" class="form-label"><b>Dirección:</b></label>
                                                                                        <input type="text" class="form-control" name="direccion" value="{{$almacen->direccion}}">
                                                                                    </div>
                                                                                    <!-- Abreviatura -->
                                                                                    <div class="col-md-6">
                                                                                        <label for="abreviatura" class="form-label"><b>Abreviatura:</b></label>
                                                                                        <input type="text" class="form-control" name="abreviatura" value="{{$almacen->abreviatura}}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <!-- Código Sunat -->
                                                                                    <div class="col-md-6">
                                                                                        <label for="codigoSunat" class="form-label"><b>Código Sunat:</b></label>
                                                                                        <input style="padding-right: 0;padding-left:  7px"  type="text" class="form-control"  value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_sunat')->first()}}" name="cod_sunat">
                                                                                    </div>
                                                                                    <!-- Cod. Ubigeo -->
                                                                                    <div class="col-md-6">
                                                                                        <label for="codigoUbigeo" class="form-label">
                                                                                            <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html" target="_blank" style="text-decoration: none;">
                                                                                                <i class="fa fa-podcast" aria-hidden="true"></i>
                                                                                            </a><b>Cod. Ubigeo:</b>
                                                                                        </label>
                                                                                        <div class="input-group">
                                                                                            <input type="text" name="ubigeo" class="form-control" value="{{$almacen->cod_postal}}" maxlength="6" minlength="6">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <!-- Descripción -->
                                                                                    <div class="col-md-6">
                                                                                        <label for="descripcion" class="form-label"><b>Descripción:</b></label>
                                                                                        <textarea class="form-control" name="descripcion" autocomplete="off" required="required" >{{$almacen->descripcion}}</textarea>
                                                                                    </div>
                                                                                    <div class="col-md-6 d-flex align-items-center">
                                                                                        <label for="activo" class="form-label me-2" style="font-size: 20px;">
                                                                                            Activo/desactivo:
                                                                                        </label>
                                                                                        <div class="col-sm-1" style="vertical-align: middle;margin-top: auto;margin-bottom: auto">
                                                                                            @if($almacen->estado == 0)
                                                                                                @if($conteo_almacen == 1)
                                                                                                <div class="switch-button">
                                                                                                    <input type="text" name="estado" value="on" hidden="hidden">
                                                                                                    <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked  disabled="disabled" />
                                                                                                </div>
                                                                                                @elseif($conteo_almacen >1)
                                                                                                <div class="switch-button">
                                                                                                    <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" checked   />
                                                                                                </div>
                                                                                                @endif
                                                                                            @elseif($almacen->estado == 1)
                                                                                                <div class="switch-button">
                                                                                                    <input type="checkbox" name="estado" class="js-switch{{$almacen->id}}" />
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Botón Guardar en el modal -->
                                                                            </div>
                                                                        </div>
                                                                
                                                                        <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                                                                            <!-- Sección de codificación de documentos -->
                                                                            <div class="col-md-12 mb-3">
                                                                                <!-- Centrado de la imagen y el texto de descripción -->
                                                                                <div style="display: flex; justify-content: center; align-items: center;">
                                                                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRUkvtg9L1oBVOoWUMqrwmLVo4Fc4QF5xoNsg&s" width="100px" style="margin-right: 10px;">
                                                                                    <label for="descripcion2" class="form-label" style="color: rgb(0, 0, 0); font-size: 22px; font-weight: bold;">Sunat:</label>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Formulario de codificación dentro de la ventana 2 -->
                                                                            <div class="col-md-12">
                                                                                <div class="row mb-3">
                                                                                    <!-- Cod. Facturación -->
                                                                                    <div class="col-md-4">
                                                                                        <label for="codFacturacion" class="form-label"><b>Cod.Facturación:</b></label>
                                                                                        <div class="input-group m-b">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-addon">F00 &nbsp;</span>
                                                                                            </div>
                                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura')->first()))
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_factura')->first()}}" class="form-control" name="serie_factura" autocomplete="off" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura')->first()}}" name="cod_fac" class="form-control ">
                                                                                            @else
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_factura')->first()}}" class="form-control" name="serie_factura" autocomplete="off" readonly="" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="" readonly name="cod_fac" class="form-control ">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Cod. Boleta -->
                                                                                    <div class="col-md-4">
                                                                                        <label for="codBoleta" class="form-label"><b>Cod.Boleta:</b></label>
                                                                                        <div class="input-group m-b">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-addon">B00 &nbsp;</span>
                                                                                            </div>
                                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta')->first()))
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_boleta')->first()}}" class="form-control" name="serie_boleta" autocomplete="off" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta')->first()}}" name="cod_bol" class="form-control ">
                                                                                            @else
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_boleta')->first()}}" class="form-control" name="serie_boleta" autocomplete="off" readonly="" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="" readonly name="cod_bol" class="form-control ">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Cod. Guía R -->
                                                                                    <div class="col-md-4">
                                                                                        <label for="codGuia" class="form-label"><b>Cod.Guía Remisión:</b></label>
                                                                                        <div class="input-group m-b">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-addon">T00 &nbsp;</span>
                                                                                            </div>
                                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision')->first()))
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_remision')->first()}}" class="form-control" name="serie_remision" autocomplete="off" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision')->first()}}" name="cod_guia" class="form-control ">
                                                                                            @else
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_remision')->first()}}" class="form-control" name="serie_remision" autocomplete="off" readonly="" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="" readonly name="cod_guia" class="form-control ">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row mb-3">
                                                                                    <!-- Cod. Nota Crédito Factura -->
                                                                                    <div class="col-md-4">
                                                                                        <label for="codNotaCreditoFactura" class="form-label"><b>Cod. Nota Crédito Factura:</b></label>
                                                                                        <div class="input-group m-b">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-addon">FF0 &nbsp;</span>
                                                                                            </div>
                                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito')->first()))
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_credito')->first()}}" class="form-control" name="serie_credito" autocomplete="off" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito')->first()}}" name="cod_credito" class="form-control ">
                                                                                            @else
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_credito')->first()}}" class="form-control" name="serie_credito" autocomplete="off" readonly="" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="" readonly name="cod_credito" class="form-control ">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Cod. Nota Crédito Boleta -->
                                                                                    <div class="col-md-4">
                                                                                        <label for="codNotaCreditoBoleta" class="form-label"><b>Cod. Nota Crédito Boleta:</b></label>
                                                                                        <div class="input-group m-b">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-addon">BB0 &nbsp;</span>
                                                                                            </div>
                                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito_b')->first()))
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_credito_b')->first()}}" class="form-control" name="serie_credito_b" autocomplete="off" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_credito_b')->first()}}" name="cod_credito_b" class="form-control ">
                                                                                            @else
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_credito_b')->first()}}" class="form-control" name="serie_credito_b" autocomplete="off" readonly="" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="" readonly name="cod_credito" class="form-control ">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Cod. Nota Débito -->
                                                                                    <div class="col-md-4">
                                                                                        <label for="codNotaDebito" class="form-label"><b>Cod. Nota Débito:</b></label>
                                                                                        <div class="input-group m-b">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-addon">F00 &nbsp;</span>
                                                                                            </div>
                                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_debito')->first()))
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_debito')->first()}}" class="form-control" name="serie_debito" autocomplete="off" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_nota_debito')->first()}}" name="cod_debito" class="form-control ">
                                                                                            @else
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_nota_debito')->first()}}" class="form-control" name="serie_debito" autocomplete="off" readonly="" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="" readonly name="cod_debito" class="form-control ">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <!-- Cod. Factura Manual -->
                                                                                    <div class="col-md-4">
                                                                                        <label for="codFacturaManual" class="form-label"><b>Cod. Factura manual:</b></label>
                                                                                        <div class="input-group m-b">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-addon">FA0 &nbsp;</span>
                                                                                            </div>
                                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura_m')->first()))
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_factura_m')->first()}}" class="form-control" name="serie_factura_m" autocomplete="off" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_factura_m')->first()}}" name="cod_factura_m" class="form-control ">
                                                                                            @else
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_factura_m')->first()}}" class="form-control" name="serie_factura_m" autocomplete="off" readonly="" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="" readonly name="cod_factura_m" class="form-control ">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Cod. Boleta Manual -->
                                                                                    <div class="col-md-4">
                                                                                        <label for="codBoletaManual" class="form-label"><b>Cod. Boleta manual:</b></label>
                                                                                        <div class="input-group m-b">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-addon">BA0 &nbsp;</span>
                                                                                            </div>
                                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta_m')->first()))
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_boleta_m')->first()}}" class="form-control" name="serie_boleta_m" autocomplete="off" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_boleta_m')->first()}}" name="cod_boleta_m" class="form-control ">
                                                                                            @else
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_boleta_m')->first()}}" class="form-control" name="serie_boleta_m" autocomplete="off" readonly="" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="" readonly name="cod_boleta_m" class="form-control ">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Cod. Guía Remisión Manual -->
                                                                                    <div class="col-md-4">
                                                                                        <label for="codGuiaManual" class="form-label"><b>Cod. Guía Remisión manual:</b></label>
                                                                                        <div class="input-group m-b">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-addon">TA0 &nbsp;</span>
                                                                                            </div>
                                                                                            @if(is_numeric($cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision_m')->first()))
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_remision_m')->first()}}" class="form-control" name="serie_remision_m" autocomplete="off" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('cod_remision_m')->first()}}" name="cod_remision_m" class="form-control ">
                                                                                            @else
                                                                                                <input type="text" value="{{$cod_guia_almacen->where('almacen_id',$almacen->id)->pluck('serie_remision_m')->first()}}" class="form-control" name="serie_remision_m" autocomplete="off" readonly="" required="required">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-addon">- 000</span>
                                                                                                </div>
                                                                                                <input type="text" value="" readonly name="cod_boleta_m" class="form-control ">
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="d-flex justify-content-center">
                                                                                    <button class="btn btn-primary" type="submit" name="action" id="boton" style="background-color: blue;">Guardar</button>
                                                                                </div> 
                                                                            </div> 
                                                                        </div> 
                                                                    </div> 
                                                                </div> 
                                                            
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button type="submit" class="btn btn-primary" nmae="action" style="background-color: blue;">Guardar</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        
                                                    </div> 
                                                </div> 
                                                @endforeach
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


    <!-- FIN FLAVIA-->   

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

    @foreach($almacenes as $almacen)
    <!-- Switchery -->
    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script>
        var elem{{$almacen->id}} = document.querySelector('.js-switch{{$almacen->id}}');
        var switchery = new Switchery(elem{{$almacen->id}}, { color: '#4cc0f7' });
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
