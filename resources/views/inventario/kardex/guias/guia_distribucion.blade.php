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
            <form action="{{ route('kardex-entrada-Distribucion.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                @csrf
            <input type="hidden" name="past1" id="" value="view_store">
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
                                    <h2>GUÍA DE REMISIÓN</h2>
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
                        <label class="col-sm-2 col-form-label" >Almacén Emisor:</label>
                        <div class="col-sm-4">
                            <input type="text" value="{{$almacen_principal->nombre}} - {{$almacen_principal->direccion}}" readonly="" class="form-control" name="almacen_emisor" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" >Tipo de Transporte:</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="tipo_transporte" autocomplete="off" onchange="test(this)" id="select_id" required>
                                <option value="">Escoge el tipo de Transporte</option>
                                <option value="1">Transporte Público</option>
                                <option value="2">Transaporte Privado</option>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label" >Almacén Receptor:</label>
                        <div class="col-sm-4">
                            <input type="text" readonly="" class="form-control" value="{{$llegada}}" name="llegada" required="required">
                        </div>
                        <div style="display: none">
                            <input type="hidden" name="punto_partida" value="{{$punto_partida}}" id="">
                            <input type="hidden" name="punto_llegada" value="{{$llegada}}" id="">
                            <input type="hidden" name="almacen" value="{{$almacen_receptor->id}} \ {{$almacen_receptor->nombre}}" id="">
                        </div>
                    </div>
                    <div class="form-group row" id="transporte_publico" hidden="hidden">
                        <div class="col-sm-12">
                            <div class="row" >
                                <label class="col-sm-2 col-form-label">Vehículo Público:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="vehiculo_publico" autocomplete="off" id="vehiculo_publico">
                                        <option value="">Ningún Vehículo</option>
                                        @foreach($transporte_publico as $transporte_publicos)
                                        <option value="{{$transporte_publicos->id}}">{{$transporte_publicos->nombre}} /{{$transporte_publicos->ruc}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="transporte_privado" hidden="hidden">
                        <div class="col-sm-12" >
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Vehículo Privado:</label>
                                <div class="col-sm-4">
                                    <select class="form-control " name="vehiculo" autocomplete="off" id="vehiculo_privado">
                                        <option value="">Ningún Vehículo</option>
                                        @foreach($vehiculo as $vehiculos)
                                        <option value="{{$vehiculos->id}}">{{$vehiculos->placa}} /{{$vehiculos->marca}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-2 col-form-label">Conductor:</label>
                                <div class="col-sm-4">
                                    <select class="form-control " name="conductor" autocomplete="off" id="conductor">
                                        <option value="">Ningún Conductor</option>
                                            @foreach($personal as $ersonals)
                                                <option disabled="disabled">------------------------------</option>
                                                <option value="{{$ersonals->id}}">{{$ersonals->nombres}} </option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-4 col-form-label" >Fecha Emisión:</label>
                                <div class="col-sm-8" style="margin-bottom: 15px ">
                                    <input type="text" value="{{$fecha_emision}}" readonly="" class="form-control" name="fec_emision" required="required">
                                </div>
                                <label class="col-sm-4 col-form-label" >Fecha Entrega:</label>
                                <div class="col-sm-8" >
                                    <input type="date" name="fecha_entrega" class="form-control" id="" required >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-4 col-form-label" >Observaciones:</label>
                                <div class="col-sm-8">
                                    <textarea name="observacion" class="form-control" id="" style="height: 89px" placeholder="...">{{$observacion}}</textarea>
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
                                    <th>Número Series</th>
                                    <th>Peso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $item => $articulo)
                                <tr>
                                    <td><button class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                    <td><input type="hidden" value="{{$articulo->id}}" name="registro_opt[]" id="">{{$articulo->codigo_original}} - {{$articulo->nombre}}</td>
                                    <td><input type="hidden" name="stock[]" value="{{$stock[$item]->stock}}">{{$stock[$item]->stock}}</td>
                                    <td><input type="hidden" name="unidades[]" value="{{$unidad[$item]}}" id="">{{$unidad[$item]}}</td>
                                    <td><input type="hidden" name="cantidad[]" id="" value="{{$cantidad[$item]}}">{{$cantidad[$item]}}</td>
                                    <td><input type="hidden" name="total[]" value="{{$tot[$item] =  $unidad[$item] * $cantidad[$item]}}">{{$tot[$item] =  $unidad[$item] * $cantidad[$item]}}</td>
                                    <td><textarea class="form-control" name="n_series[]" id="" required ></textarea></td>
                                    <td><input type="hidden" name="peso_tot[]" value="{{$peso[$item] * $tot[$item]}}">{{$peso[$item] * $tot[$item]}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" align="right">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                            {{-- <button class="btn btn-secondary">Guardar y Finalizar</button> --}}
                        </div>
                    </div>
                </div>
            </form>
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
<script>
    function test(a) {
        var x = (a.value || a.options[a.selectedIndex].value);  //crossbrowser solution =)
        if (x ==2)/*Transaporte Privado*/
        {
            document.getElementById("transporte_privado").removeAttribute("hidden");
            document.getElementById("transporte_publico").setAttribute("hidden", "hidden");

            document.getElementById("vehiculo_privado").setAttribute("required", "required");
            document.getElementById("conductor").setAttribute("required", "required");
            document.getElementById("vehiculo_publico").removeAttribute("required");


        }
        if(x==0)/*Sin Transporte*/
        {
            document.getElementById("transporte_privado").setAttribute("hidden", "hidden");
            document.getElementById("transporte_publico").setAttribute("hidden", "hidden");

            document.getElementById("vehiculo_publico").removeAttribute("required");
            document.getElementById("vehiculo_privado").removeAttribute("required");
            document.getElementById("conductor").removeAttribute("required");


        }
        if(x==1)/*Transporte Público*/
        {
            document.getElementById("transporte_publico").removeAttribute("hidden");
            document.getElementById("transporte_privado").setAttribute("hidden", "hidden");

            document.getElementById("vehiculo_publico").setAttribute("required", "required");
            document.getElementById("vehiculo_privado").removeAttribute("required");
            document.getElementById("conductor").removeAttribute("required");
        }
    }
    function delete_guion(string){//solo letras y numeros
        return string.replace(/-/g, "");
    }
</script>
@endsection
