@extends('layout')

@section('title', 'Comprobantes | Factura')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            @include('transaccion\comprobantes\_shared\statistics')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                @include('transaccion\comprobantes\_shared\tabs')
                                {{-- Almacen --}}
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    {{-- ALMACEN --}}
                                    @if (auth()->user()->name == 'Administrador'){{-- Condicional por tipo de user  --}}
                                        <span class="dropdown">
                                            <button class="btn btn-success dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                                <span style="margin-left:12px;"><b>Almacenes:</b></span>
                                                @foreach ($almacen as $almacens)
                                                    <li>
                                                        <form action="{{ route('cotizacion.create_factura') }}"
                                                            enctype="multipart/form-data" method="post">
                                                            @csrf
                                                            <input type="text" value="{{ $almacens->id }}"
                                                                hidden="hidden" name="almacen">
                                                            <button class="btn btn-w-m btn-link"
                                                                type="submit">{{ $almacens->nombre }}</button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </span>
                                    @else
                                        <form action="{{ route('cotizacion.create_boleta') }}" enctype="multipart/form-data"
                                            method="post" class="tooltip-demo">
                                            @csrf
                                            <input type="text" value="{{ auth()->user()->almacen_id }}" hidden="hidden"
                                                name="almacen">
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <button class="btn btn-success" type="button">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>

                            </ul>
                            <div class="tab-content">
                                <!-- Boleta-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('transaccion\comprobantes\_shared\js_shared')
@endsection
