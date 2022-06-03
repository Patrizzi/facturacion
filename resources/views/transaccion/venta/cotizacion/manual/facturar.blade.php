@extends('layout')
@section('title', 'Cotizacion Manual Facturar')
@section('breadcrumb', 'Cotizacion Manual Facturar')
@section('breadcrumb2', 'Cotizacion Manual Facturar')
@section('href_accion', back())
@section('value_accion', 'Inicio')

{{-- @section('button2', 'Nueva Cotización') --}}
{{-- @section('config', route('cotizacion_manual.create')) --}}

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <form action="{{route('cotizacion_manual.facturar_store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
    @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <div class="row">
                        @include('layout_cabecera_ventas')
                        <div class="col-sm-4 ">
                            <div class="form-control ruc" style="height: 125px">
                                <center>
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2>FACTURA ELECTRÓNICA</h2>
                                    <input type="text" value="{{$cotizacion->id}}" name="id_cotizador" hidden="hidden">
                                    <p>{{$factura_numero}}</p>
                                    {{-- <input type="text" value="{{$cotizacion->comisionista_id}}" name="id_comisionista" hidden="hidden"> --}}
                                </center>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6" align="center">
                            <div align="center">
                                <div class="row">
                                    <div class="col-sm-2"><strong>Cliente:</strong></div>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="" value="  {{$cotizacion->cliente->nombre}}" readonly></div>
                                    <br>
                                    <div class="col-sm-2"><strong>R.U.C:</strong></div>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="" value="  {{$cotizacion->cliente->numero_documento}}" readonly></div>
                                    <br>
                                    <div class="col-sm-2"><strong>Dirección:</strong></div>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="" value="  {{$cotizacion->cliente->direccion}}" readonly></div>
                                    <br>
                                    <div class="col-sm-2"><strong>Condiciones de Pago:</strong></div>
                                    <div class="col-sm-3" id="colum-col">
                                        <select class="form-control" name="forma_pago"  id ="forma_pago" onchange="seleccionado_fp()">
                                            <option value="{{$cotizacion->forma_pago->id}}">{{$cotizacion->forma_pago->nombre}}</option>
                                            <option disabled>--------------------</option>
                                            @foreach($forma_pagos as $forma_pago)
                                                <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@stop