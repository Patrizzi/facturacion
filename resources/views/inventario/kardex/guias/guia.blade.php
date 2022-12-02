@extends('layout')
@section('title', 'kardex Distribucion')
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
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <div class="form-group row">
                    <div class="col-sm-4 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img src="{{asset('img/logos/')}}//{{$empresa->foto}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <div class="form-control ruc" style="height:125px">
                            <center>
                                <h3 style="padding-top:10px">{{$empresa->ruc}}</h3>
                                <h2>GUIA DE REMISION</h2>
                                <h5>{{$codigo_guia}}</h5>
                            </center>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" >Motivo Traslado:</label>
                    <div class="col-sm-4">
                        <input type="text" value="{{$motivo}}"  readonly="" class="form-control" name="motivo" required="required">
                    </div>
                    <label class="col-sm-2 col-form-label" >Almacen Emisor:</label>
                    <div class="col-sm-4">
                        <input type="text" value="{{$almacen_principal->nombre}} - {{$almacen_principal->direccion}}" readonly="" class="form-control" name="motivo" required="required">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" >Tipo de Transporte:</label>
                    <div class="col-sm-4">
                        <select name="transporte" id="" class="form-control">
                            <option value="">Escoge el tipo de Transporte</option>
                            <option value="Transporte Privado">Transporte Privado</option>
                            <option value="Transporte Publico">Transporte Publico</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label" >Almacen Receptor:</label>
                    <div class="col-sm-4">
                        <input type="text" readonly="" class="form-control" value="{{$almacen_receptor->nombre}} - {{$almacen_principal->direccion}}" name="almacen_receptor" required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <label class="col-sm-4 col-form-label" >Fecha Emision:</label>
                            <div class="col-sm-8" style="margin-bottom: 15px ">
                                <input type="text" value="{{$fecha_emision}}" readonly="" class="form-control" name="motivo" required="required">
                            </div>
                            <label class="col-sm-4 col-form-label" >Fecha Entrega:</label>
                            <div class="col-sm-8" >
                                <input type="date" name="" class="form-control" id="" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <label class="col-sm-4 col-form-label" >Observaciones:</label>
                            <div class="col-sm-8">
                                <textarea name="" class="form-control" id="" style="height: 89px" placeholder="...">{{$observacion}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table cellspacing="0" class="table table-striped " width="100%">
                        <thead>
                            <tr>
                                <th><button class="btn btn-danger"><i class="fa fa-trash"></i></button></th>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Unidad</th>
                                <th>Cantidad</th>
                                <th>Cantidad Total</th>
                                <th>Numero Series</th>
                                <th>Peso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $item => $articulo)
                            <tr>
                                <td><button class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                <td>{{$articulo->codigo_original}} - {{$articulo->nombre}}  </td>
                                <td>{{$stock[$item]->stock}}</td>
                                <td>{{$unidad[$item]}}</td>
                                <td>{{$cantidad[$item]}}</td>
                                <td>{{$tot[$item] =  $unidad[$item] * $cantidad[$item]}}</td>
                                <td><textarea class="form-control" name="" id="" ></textarea></td>
                                <td>{{$peso[$item] * $tot[$item]}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-12" align="right">
                        <button class="btn btn-primary">Guardar</button>
                        <button class="btn btn-secondary">Guardar y Finalizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .form-control{
        border-radius: 5px;
    }
</style>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
@endsection