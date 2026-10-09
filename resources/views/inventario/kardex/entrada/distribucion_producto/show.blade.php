@extends('layout')
@section('title', 'Ver')
@section('href_accion', route('kardex-entrada-Distribucion.index') )
@section('value_accion', 'Atras')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">
                <div class="tabs-container">
                    @if ($guia_r_traslado != [0])
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Kardex Distribucion</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">Guia de Remision</a></li>
                        </ul>
                    @endif 
                    {{-- <div class="tabs-menu-body"> --}}
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div @if($guia_r_traslado != [0]) class="panel-body" @endif>    
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <address class="col-sm-8">
                                                <h5>Distribuido:</h5>
                                                <i class=" fa fa-user">:</i><strong > {{$mi_empresa->nombre}}</strong><br>
                                                De:</i> {{$almacen->nombre}}<br>
                                            Al:</i> {{$kardex_entradas->almacen->nombre}}
                                            </address>
                                        </div>
                                        <div class="col-sm-4" align="right">
                                            <div class="form-control ruc" >
                                                <center>
                                                    <h3 style="padding-top:10px ">RUC : {{$mi_empresa->ruc}}</h3>
                                                    <h2>GUIA DE DISTRIBUCION </h2>
                                                    <h4 class="text-navy">{{$kardex_entradas->codigo_guia}}</h4>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive m-t">
                                        <table class="table invoice-table" >
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th style="text-align: left;">Nombre/Descripcion</th>
                                                    <th>Unidad</th>
                                                    <th>Cantidad</th>
                                                    <th>Cantidad Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($kardex_entradas_registros as $kardex_entradas_registro)
                                                <tr>
                                                    <td>  {{$kardex_entradas_registro->producto->codigo_producto}}</td>
                                                    <td style="text-align: left;">
                                                        {{$kardex_entradas_registro->producto->nombre}}/{{$kardex_entradas_registro->producto->codigo_original}} {{$kardex_entradas_registro->producto->descripcion}}
                                                    </td>
                                                    <td >{{$kardex_entradas_registro->cantidad_inicial}}</td>
                                                    <td >{{$kardex_entradas_registro->unidad}}</td>
                                                    <td >{{$kardex_entradas_registro->unidad_cantidad}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if ($guia_r_tras_reg !== [0,0])
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12" align="right">
                                            <a href="{{route('kardex-distribucion.print',$kardex_entradas->id)}}" class="btn btn-warning"><i class="fa fa-print"></i></a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4 text-left" align="left">
                                            <address class="col-sm-4" align="left">
                                                <img src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" alt="" width="300px">
                                            </address>
                                        </div>
                                        <div class="col-sm-4">
                                        </div>
                                        <div class="col-sm-4 ">
                                            <div class="form-control" align="center" style="height: auto;">
                                                <h3 style="padding-top:10px ">R.U.C {{$mi_empresa->ruc}}</h3>
                                                <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>
                                                <h5>{{$guia_r_traslado->cod_guia}} </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" align="center" style="padding-bottom: 5px">
                                        <div class="col-sm-6" align="center">
                                            <div class="form-control"><h3>Domicilio De Partida</h3>
                                                <div align="left" style="font-size: 13px">
                                                    <p>{{$guia_r_traslado->almc_emisor->nombre}}</p>
                                                    <p>{{$guia_r_traslado->almc_emisor->direccion}} - {{$guia_r_traslado->almc_emisor->cod_postal}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" align="center" >
                                            <div class="form-control" ><h3>Domicilio De Llegada</h3>
                                                <div align="left" style="font-size: 13px">
                                                    <p>{{$guia_r_traslado->almc_receptor->nombre}}</p>
                                                    <p>{{$guia_r_traslado->almc_receptor->direccion}} - {{$guia_r_traslado->almc_receptor->cod_postal}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" align="center" style="padding-bottom: 5px">
                                        <div class="col-sm-6" align="center">
                                            <div class="form-control"><h3>Datos de Transporte</h3>
                                                <div align="left" style="font-size: 13px">
                                                    @if ($guia_r_traslado->tipo_transporte == 1)
                                                        <b>Empresa:</b> {{$guia_r_traslado->vehiculo_publicos->nombre}}<br>
                                                        <b>Ruc: </b> {{$guia_r_traslado->vehiculo_publicos->ruc}}<br>
                                                        <b>Nota:</b>Esta Empresa es Publica
                                                    @else
                                                        @if(isset($guia_r_traslado->vehiculo_id))
                                                            <b>Placa del Vehiculo : </b>{{$guia_r_traslado->vehiculo->placa}}<br>
                                                            <b>Marca del Vehiculo : </b>{{$guia_r_traslado->vehiculo->marca}}<br>
                                                            <b>Conductor : </b>{{$guia_r_traslado->personal->nombres}}
                                                        @else
                                                            <b>Placa del Vehiculo : </b>No Hay Vehiculo<br>
                                                            <b>Marca del Vehiculo : </b>No Hay Vehiculo<br>
                                                            <b>Conductor : </b> No Hay Conductor
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-control">
                                                <h3>Datos de Envío</h3>
                                                <div align="left" style="font-size: 13px">
                                                    <b>Fecha de Emision</b> {{$guia_r_traslado->fecha_emision}} <br><br>
                                                    <b>Fecha de Traslado</b> {{$guia_r_traslado->fecha_entrega}} 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Codigo Producto </th>
                                                    <th>Marca / Descripcion</th>
                                                    <th>Unid.Medida</th>
                                                    <th>Cantidad</th>
                                                    <th>Peso</th>
                                                </tr>
                                            </thead>
                                            <span hidden>{{$z=1}}</span>
                                            <tbody>
                                                @foreach ($guia_r_tras_reg as $guia_reg)
                                                    <tr>
                                                        <td>{{$z++}}</td>
                                                        <td>{{$guia_reg->producto->codigo_original}}</td>
                                                        <td>{{$guia_reg->producto->marcas_i_producto->nombre}} / {{$guia_reg->producto->nombre}} <strong>N/S: </strong>{{$guia_reg->numero_serie}}
                                                        <br>
                                                        {{$guia_reg->descripcion}}
                                                        </td>
                                                        <td>{{$guia_reg->producto->unidad_i_producto->medida}}</td>
                                                        <td>{{$guia_reg->cantidad}}</td>
                                                        <td>{{$guia_reg->producto->peso}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>



<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@endsection
