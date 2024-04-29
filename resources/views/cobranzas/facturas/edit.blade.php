@extends('layout')

@section('title', 'Registros '.$cod_fact)
@section('content')
    <input type="hidden" name="" id="tipo_comprobante_view" value="factura">
    <input type="hidden" name="" id="serie_comp" value="{{$cod_fact}}">
    <input type="hidden" name="" id="simbolo_precio" value="{{$factura->moneda->simbolo}}">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-control">
                                    <h2 class="text-center"><strong>Datos Cliente</strong></h2>
                                    <br>
                                    <div style="margin: auto 10px">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><strong>Nombre:</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control">{{ $factura->cliente->nombre }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="col-sm-3 col-form-label"><strong>{{ strtoupper($factura->cliente->documento_identificacion) }}:</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control">{{ $factura->cliente->numero_documento }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><strong>Telefono</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control">{{ $factura->cliente->celular }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><strong>Email:</strong></label>
                                            <div class="col-sm-9">
                                                <p class="form-control">{{ $factura->cliente->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-control">
                                    <h2 class="text-center"><strong>Datos de Comprobante</strong></h2>
                                    <br>
                                     @if ($factura->forma_pago_id == 2) {{-- CREDITO --}}
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Código:</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{ $cod_fact }}</p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Moneda</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{ strtoupper($factura->moneda->nombre) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>N°
                                                            Cuotas:</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{ $fact_cuotas->count() }}</p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Estado:</strong></label>
                                                    <div class="col-sm-7">
                                                        @if ($factura->estado_pago == 0)
                                                            <button class="btn btn-danger btn-block" disabled><i class="fa fa-times"></i>&nbsp;&nbsp;Sin Pago</button>
                                                        @endif
                                                        @if ($factura->estado_pago == 1)
                                                            <button class="btn btn-warning btn-block" disabled><i class="fa fa-warning"></i>&nbsp;&nbsp;Adelantado</button>
                                                        @endif
                                                        @if ($factura->estado_pago == 2)
                                                            <button class="btn btn-primary btn-block" disabled><i class="fa fa-check"></i>&nbsp;&nbsp;Pagado</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto Total:</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{ $factura->moneda->simbolo }}
                                                            <span hidden>{{ $sum_total = $fact_cuotas->sum('monto')}}</span>
                                                            {{number_format($sum_total, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto | Adelanto</strong></label>
                                                    <div class="col-sm-7"> {{-- SUMA DE MONTO + ADELANTE --}}
                                                        <p class="form-control">{{ $factura->moneda->simbolo }}
                                                            @if($factura->estado_pago ==  2) {{--  PAGO TOTAL --}}
                                                                {{ $pago_total = number_format($fact_cuotas->sum('montos'),2)}}
                                                            @else {{--  PARCIAL O SIN PAGO  --}}
                                                                @php
                                                                    $precio_adel = 0.00;
                                                                    if(isset($adelantos)){
                                                                        $precio_adel = $adelantos->precio_adelanto;
                                                                    }
                                                                @endphp
                                                                <span hidden>{{ $pago_total = $fact_cuotas->where('estado', 2)->sum('monto') + $precio_adel }}</span>
                                                                {{number_format( $pago_total ,2)}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto
                                                            Deuda:</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{ $factura->moneda->simbolo }} {{ number_format($sum_total -  $pago_total,2) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row justify-content-center">
                                                    <a class="btn btn-secondary" href="{{ route('pagos.print_cuotas', $factura->id) }}" target="_blank">Descargar Detalle de Cuota</a>
                                                </div>
                                                <div class="form-group row justify-content-center">
                                                    <a class="btn btn-secondary" href="{{ route('facturacion_manual.show', $factura->id) }}" target="_blank">Ver Factura</a>
                                                </div>
                                            </div>

                                        </div>
                                    @else {{-- CONTADO --}}
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Código:</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{ $cod_fact }}</p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Moneda</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{ strtoupper($factura->moneda->nombre) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Tipo de
                                                            Pago:</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">Contado</p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Estado:</strong></label>
                                                    <div class="col-sm-7">
                                                        @if ($factura->estado_pago == 0)
                                                        <button class="btn btn-danger btn-block" disabled><i class="fa fa-times"></i>&nbsp;&nbsp;Sin Pago</button>
                                                        @endif
                                                        @if ($factura->estado_pago == 1)
                                                            <button class="btn btn-warning btn-block" disabled><i class="fa fa-warning"></i>&nbsp;&nbsp;Adelantado</button>
                                                        @endif
                                                        @if ($factura->estado_pago == 2)
                                                            <button class="btn btn-primary btn-block" disabled><i class="fa fa-check"></i>&nbsp;&nbsp;Pagado</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                {{-- Aqui va el pago --}}
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto
                                                            Total:</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{ $factura->moneda->simbolo }}
                                                            <span
                                                                hidden>{{ $subtotal = $factura->op_gravada + $factura->op_inafecta + $factura->op_exonerada }}
                                                                {{ $tot = round($subtotal + ($factura->op_gravada * $igv->renta) / 100, 2)}}
                                                            </span>
                                                            {{ number_format($tot, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto
                                                            Pagado: </strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control"> {{$factura->moneda->simbolo}}
                                                            @if ($factura->estado_pago == 2) {{-- Pagado Total  --}}
                                                                {{ number_format( $tot, 2) }}
                                                                <span hidden>{{$pago_total = $tot, 2}}</span>
                                                            @endif
                                                            @if ($factura->estado_pago == 1) {{-- Pagado Parcial --}}
                                                                <span hidden>{{ $pago_total = $adelantos->precio_adelanto }}</span>
                                                                {{number_format($pago_total, 2) }}
                                                            @endif
                                                            @if($factura->estado_pago == 0) {{-- SIN PAGO --}}
                                                                <span hidden>{{ $pago_total = 0 }}</span>
                                                                {{number_format($pago_total,  2) }}                                                              
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto faltante</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{$factura->moneda->simbolo}}
                                                            <span hidden>{{$tot_pagar = round($tot - $pago_total,2)}}</span>
                                                            {{number_format($tot_pagar,2)}}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-5 col-form-label">
                                                        <strong>Fecha de Pago</strong>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">
                                                            @if($factura->estado_pago == 2)
                                                                {{ Carbon\Carbon::parse($pagos->pluck('fecha_registro')->first())->format('d-m-Y') }}
                                                            @endif
                                                            @if($factura->estado_pago == 1)
                                                                {{ Carbon\Carbon::parse($adelantos->fecha_registro)->format('d-m-Y') }}
                                                            @endif
                                                            @if($factura->estado_pago == 0)
                                                                <i>Sin Pago</i>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row justify-content-center">
                                                    <a class="btn btn-secondary"
                                                        href="{{ route('pagos.print_cuotas', $factura->id) }}"
                                                        target="_blank">Descargar Detalle de Cuota</a>
                                                </div>
                                                <div class="form-group row justify-content-center">
                                                    <a class="btn btn-secondary"
                                                        href="{{ route('facturacion.show', $factura->id) }}"
                                                        target="_blank">Ver Factura</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        {{-- {{=}} --}}
                        <div class="row">
                            <div class="ibox-content" style="width: 100% !important">
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @if ($factura->forma_pago_id == 1) {{-- CONTADO --}}
                                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Cuotas</a>
                                            </li>
                                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">Adelantos</a>
                                            </li>
                                        @else
                                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Cuotas y Adelantos</a>
                                            </li>
                                        @endif
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                                                <br>
                                                @if ($factura->forma_pago_id == 2)
                                                    <div class="row">
                                                
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control form-control-sm m-b-xs" id="filter"
                                                                placeholder="Search in table">
                                                        </div>
                                                        <div class="col-sm-4">

                                                        </div>
                                                        <div class="col-sm-4 text-right">
                                                            @if ($fact_cuotas->where('facturacion_id', $factura->id)->where('estado', 1)->count() != $fact_cuotas->count())
                                                                <button class="btn btn-secondary pago_all_lote" id="pago_lote" disabled>Pagar
                                                                    en
                                                                    Lote</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <br>
                                            
                                                    <table
                                                        class="footable table table-stripped table-bordered table-hover toggle-arrow-tiny"
                                                        data-page-size="8" data-filter="#filter">
                                                        <thead>
                                                            <tr>
                                                                <th data-sort-ignore="true"
                                                                    style="width: 50px;text-align: center">Ver más
                                                                </th>
                                                                @if ($fact_cuotas->where('facturacion_id', $factura->id)->where('estado', 1)->count() != $fact_cuotas->count())
                                                                    <th data-sort-ignore="true">Pagar</th>
                                                                @endif
                                                                <th style="width: 25px" data-sort-ignore="true">Estado</th>
                                                                <th style="width: 25px" data-sort-ignore="true">Adelantado</th>
                                                                <th>N° Cuota </th>
                                                                <th>Monto Tot</th>
                                                                <th>Monto Canc.</th>
                                                                <th>Fecha Inicio</th>
                                                                <th>Fecha Ven.</th>
                                                                <th data-hide="all" style="display: none !important;">Dias de Restraso:
                                                                </th>
                                                                <th data-hide="all">Adelantos Registrados</th>
                                                                <th>Fecha de Pago</th>
                                                                <th data-sort-ignore="true" style="width: 170px">Pagar | Adelantar</th>
                                                                <th data-sort-ignore="true"> Detalle</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($fact_cuotas as $index => $fc_cuota)
                                                                <tr>
                                                                    <td>

                                                                    </td>
                                                                    @if ($fact_cuotas->where('facturacion_id', $factura->id)->where('estado', 1)->count() != $fact_cuotas->count())
                                                                        <td>
                                                                            @if ($fc_cuota->estado == 0)
                                                                                <input type="checkbox" name=""
                                                                                    id="check_{{ $fc_cuota->id }}"
                                                                                    class="form-control check_only"
                                                                                    onclick="check_lote({{ $index }})">
                                                                            @endif
                                                                        </td>
                                                                    @endif

                                                                    <td>
                                                                        @if ($fc_cuota->estado == 0)
                                                                            <button class="btn btn-danger btn-sm btn-circle" disabled>
                                                                                <i class="fa fa-times"></i>
                                                                            </button>
                                                                            <input type="hidden" name="" id="estado_{{ $fc_cuota->id }}" value="PENDIENTE">
                                                                        @elseif($fc_cuota->estado == 1)
                                                                            <button class="btn btn-warning btn-sm btn-circle" disabled>
                                                                                <i class="fa fa-warning"></i>
                                                                            </button>
                                                                            <input type="hidden" name="" id="estado_{{ $fc_cuota->id }}" value="PAGADO">
                                                                        @else
                                                                            <button class="btn btn-primary btn-sm btn-circle" disabled>
                                                                                <i class="fa fa-check"></i>
                                                                            </button>
                                                                            <input type="hidden" name="" id="estado_{{ $fc_cuota->id }}" value="RETRASADO">
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{-- Acá va el adelanto / estados --}}
                                                                        @if (is_object($adelantos_reg))
                                                                            @if ($adelantos_reg->where('cuota_cred_id', $fc_cuota->id)->count() != 0)
                                                                                <button class="btn btn-primary btn-sm btn-circle" disabled>
                                                                                    <i class="fa fa-check"></i>
                                                                                </button>
                                                                            @else
                                                                                <button class="btn btn-danger btn-sm btn-circle" disabled>
                                                                                <i class="fa fa-times"></i>
                                                                            </button>
                                                                            @endif
                                                                        @else
                                                                            <button class="btn btn-danger btn-sm btn-circle" disabled>
                                                                                <i class="fa fa-times"></i>
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                    <td>Cuota N° <span id="cuota_view_n_{{ $fc_cuota->id }}">{{ $fc_cuota->numero_cuota }}</span> <span hidden id="n_cuota_{{ $fc_cuota->id }}">{{ $fc_cuota->id }}</span></td>
                                                                    <td>
                                                                        {{ $factura->moneda->simbolo }}
                                                                        <span style="display: none">{{$tot = 0 }}</span>
                                                                        {{-- {{$adelantos_reg}} --}}
                                                                        @if (is_object($adelantos_reg))
                                                                            @if ($adelantos_reg->where('cuota_cred_id', $fc_cuota->id)->count() != 0)
                                                                                <span style="display: none">{{$tot = $adelantos_reg->where('cuota_cred_id', $fc_cuota->id)->sum('montos_input')}}</span>    
                                                                            @endif
                                                                        @endif
                                                                        {{ $tot_monto =  number_format($fc_cuota->monto - $tot, 2)}} 
                                                                        <input type="hidden" name="" id="numero_{{ $fc_cuota->id }}" value="{{ $fc_cuota->numero_cuota }}">
                                                                        <input type="hidden" name="" id="monto_{{ $fc_cuota->id }}" value="{{ $factura->moneda->simbolo }} {{ $tot_monto }}">
                                                                        <input type="hidden" name="" id="monto_sin_format_{{ $fc_cuota->id }}" value="{{ round($fc_cuota->monto - $tot,2) }}">
                                                                        <input type="hidden" name="" id="total_{{ $fc_cuota->id }}" value="{{ $tot_monto }}">
                                                                    </td>
                                                                    <td>
                                                                        {{ $factura->moneda->simbolo }}
                                                                        @if ($fc_cuota->estado == 2)
                                                                            {{number_format($fc_cuota->monto,2)}}
                                                                        @else
                                                                            {{number_format($tot,2)}}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($index == 0)
                                                                            {{ Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}
                                                                        @else
                                                                            {{ Carbon\Carbon::parse($fact_cuotas[$index - 1]->fecha_pago)->format('d/m/Y') }}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse($fc_cuota->fecha_pago)->format('d/m/Y') }}
                                                                        <input type="hidden" name=""
                                                                            id="fecha_ven_{{ $fc_cuota->id }}"
                                                                            value="{{ $fc_cuota->fecha_pago }}">
                                                                    </td>
                                                                    <td>
                                                                        @if ($fc_cuota->estado == 2)
                                                                            @if ($pagos_reg[$index]->fecha_pago == $fc_cuota->fecha_pago)
                                                                                Se pagó el mismo día
                                                                            @elseif(Carbon\Carbon::parse($fc_cuota->fecha_pago)->diffInDays($pagos_reg[$index]->fecha_pago) > 0)
                                                                                Se pagó a tiempo
                                                                            @else
                                                                                Tiene {{ Carbon\Carbon::parse($fc_cuota->fecha_pago)->diffInDays($pagos_reg[$index]->fecha_pago) }}
                                                                                días de Retraso
                                                                            @endif
                                                                        @else
                                                                            Aun no ha sido pagado 
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if (is_object($adelantos_reg))
                                                                            <hr>
                                                                            @if($adelantos_reg->where('cuota_cred_id', $fc_cuota->id)->count() != 0)
                                                                                <h4><strong>Informe de Adelantos:</strong></h4>
                                                                                <div class="table_div_adelantos">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-1"><strong>Id</strong></div>
                                                                                        <div class="col-sm-2"><strong>Metodo de Pago</strong></div>
                                                                                        <div class="col-sm-2"><strong>Monto</strong></div>
                                                                                        <div class="col-sm-2"><strong>Fecha</strong></div>
                                                                                        <div class="col-sm-3"><strong>Detalles</strong></div>
                                                                                        <div class="col-sm-2"><strong>Comprobante</strong></div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        @if (is_object($adelantos_reg))
                                                                                            @foreach ($adelantos_reg->where('cuota_cred_id', $fc_cuota->id ) as $a => $adl_reg)
                                                                                                <div class="col-sm-1">
                                                                                                    {{$a+1}}
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                    <span class="text-right">
                                                                                                        {{ ucfirst($adl_reg->tipo_pago) }}
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div class="col-sm-2">{{$factura->moneda->simbolo}} {{number_format($adl_reg->montos_input,2)}}</div>
                                                                                                <div class="col-sm-2">{{Carbon\Carbon::parse($adl_reg->fechas_input)->format('d-m-Y')}}</div>
                                                                                                <div class="col-sm-3"><button type="button" class="btn btn-primary btn-sm" id="view_detail_adelanto" onclick="search_adelantos({{$adl_reg->id}})" ><i class="fa fa-eye"></i></button></div>
                                                                                                <div class="col-sm-2">
                                                                                                    {{-- <button type="button" class="btn btn-secondary btn-sm" id=""><i class="fa fa-download"></i></button> --}}
                                                                                                    <a class="btn btn-secondary btn-sm" href="{{route('adelantos.comprobantes_pdf', $adl_reg->id)}}"><i class="fa fa-download"></i></a>
                                                                                                </div>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($fc_cuota->estado == 0)
                                                                            <strong>PENDIENTE</strong>
                                                                        @elseif($fc_cuota->estado == 1)
                                                                            <strong>{{ Carbon\Carbon::parse($pagos_reg[$index]->fecha_pago)->format('d/m/Y') }}</strong>
                                                                        @else
                                                                            <strong>RETRASADO</strong>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" @if ($fc_cuota->estado == 2) disabled @endif>Seleccionar</button>
                                                                        <ul class="dropdown-menu">
                                                                            <li><a class="dropdown-item" class="btn btn-primary" @if ($fc_cuota->estado != 2)  onclick="modal_pagos( {{ $fc_cuota->id }},'credito')" @endif>Pagar</a></li>
                                                                            <li><a class="dropdown-item" class="btn btn-primary" @if ($fc_cuota->estado != 2) data-toggle="modal" data-target="#myModal5"   onclick="pago_adelanto({{$factura->id}},'only',{{$fc_cuota->id}})" @endif>Adelantar</a></li>
                                                                        </ul>
                                                                    </td>
                                                                    <td>
                                                                        {{-- MODAL DE VER DETALLES  --}}
                                                                        @if ($fc_cuota->estado != 1)
                                                                            <button class="btn btn-primary" disabled>Ver detalles</button>
                                                                        @else
                                                                            <button class="btn btn-primary"
                                                                                onclick="detalle_cuota({{ $fc_cuota->id }})">Ver
                                                                                detalles</button>
                                                                            <input type="hidden" name="" id="">
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="11">
                                                                    <ul class="pagination float-left"></ul>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                @else
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <h3>Informacion del Pago</h3>
                                                        </div>
                                                        <div class="col-sm-6 text-right">
                                                            @if ($factura->estado_pago != 2)
                                                                <button class="btn btn-primary" id="pago" onclick="modal_pagos({{$factura->id}},'contado')">Pagar</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row contado_pago">
                                                        <div class="col-sm-3">
                                                            <div class="form-control">
                                                                <p><strong>Tipo de Pago:</strong></p>
                                                                <hr>
                                                                @if ($factura->estado_pago == 2)
                                                                    <h3 class="text-right">{{ucfirst($pagos->pluck('tipo_pago')->first())}}</h3>
                                                                @else
                                                                    <i>Aun no ha pago registrado</i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @switch($pagos->pluck('tipo_pago')->first())
                                                            @case('cheque')
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Número de Cheque</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{$pagos_deta[0]->numero_input}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha de Cobro</strong><hr>
                                                                        {{-- <p class="text-right">{{$pagos_deta[0]->}}</p> --}}
                                                                        <p class="text-right">{{Carbon\Carbon::parse($pagos_deta[0]->fechas_input)->format('d-m-Y')}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Banco Emisor</strong><hr>
                                                                        <p class="text-right">{{$pagos_deta[0]->bancos_input}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Beneficiario</strong><hr>
                                                                        <p class="text-right">{{$pagos_deta[0]->persona_input}}</p>
                                                                    </div>
                                                                </div>
                                                                @if (is_object($adelantos_reg))
                                                                    <div class="col-sm-3">
                                                                        <div class="form-control">
                                                                            <strong>Monto total Adelantado:</strong>
                                                                            <hr>
                                                                            <p class="text-right">
                                                                                {{$factura->moneda->simbolo}} {{number_format(round($adelantos_reg->sum('montos_input'),2),2)}}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Monto Pagado</strong><hr>
                                                                        <p class="text-right">{{ $factura->moneda->simbolo }} {{number_format($pagos_deta[0]->montos_input,2)}}</p>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>N° de Cuenta</strong><hr>
                                                                        <p class="text-right">{{$pagos_deta[0]->adicional_input}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha de Emision</strong><hr>
                                                                        <p class="text-right">{{Carbon\Carbon::parse($pagos_deta[0]->fecha_emision_input)->format('d-m-Y')}}</p>
                                                                    </div>
                                                                </div>
                                                                @break
                                                            @case("tarjeta")
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Titular de la Tarjeta</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{$pagos_deta[0]->persona_input}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Banco</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{$pagos_deta[0]->bancos_input}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{Carbon\Carbon::parse($pagos_deta[0]->fechas_input)->format('d-m-Y')}}</p>
                                                                    </div>
                                                                </div>
                                                                @if (is_object($adelantos_reg))
                                                                    <div class="col-sm-3">
                                                                        <div class="form-control">
                                                                            <strong>Monto total Adelantado:</strong>
                                                                            <hr>
                                                                            <p class="text-right">
                                                                                {{$factura->moneda->simbolo}} {{number_format(round($adelantos_reg->sum('montos_input'),2),2)}}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @break
                                                            @case("efectivo")
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Persona que Cancela</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{$pagos_deta[0]->persona_input}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{Carbon\Carbon::parse($pagos_deta[0]->fechas_input)->format('d-m-Y')}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Monto de Pago</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{$factura->moneda->simbolo}} {{number_format($pagos_deta[0]->montos_input,2)}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Vuelto</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{$factura->moneda->simbolo}} {{$pagos_deta[0]->adicional_input}}</p>
                                                                    </div>
                                                                </div>
                                                                @break
                                                            @case("transferencia")
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Titular</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{$pagos_deta[0]->persona_input}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{Carbon\Carbon::parse($pagos_deta[0]->fechas_input)->format('d-m-Y')}}</p>
                                                                    </div>
                                                                </div>
                                                                @if (is_object($adelantos_reg))
                                                                    <div class="col-sm-3">
                                                                        <div class="form-control">
                                                                            <strong>Monto total Adelantado:</strong>
                                                                            <hr>
                                                                            <p class="text-right">
                                                                                {{$factura->moneda->simbolo}} {{number_format(round($adelantos_reg->sum('montos_input'),2),2)}}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @break
                                                            @default
                                                        @endswitch
                                                        @if ($factura->estado_pago == 2)
                                                            <div class="col-sm-3">
                                                                <div class="form-control">
                                                                    <strong>Comprobante</strong><hr>
                                                                    @if (isset($pagos_deta[0]->file_input))
                                                                        <p class="text-right">
                                                                            <a class=" btn btn-secondary btn-sm" href="{{asset('archivos/pagos_sistema/' . $pagos_deta[0]->file_input)}}" download="{{$pagos_deta[0]->file_input}}">Descargar&nbsp;<i class="fa fa-download"></i></a>
                                                                        </p>
                                                                    @else
                                                                        <p class="text-right"><i>Sin Comprobante</i></p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6" style="height: 100% !important;">
                                                                <div class="form-control">
                                                                    <strong>Notas Adicionales</strong><hr>
                                                                    @if (isset($pagos_deta[0]->notas_adicionales))
                                                                        <p class="text-right">{{$pagos_deta[0]->notas_adicionales}}</p>
                                                                    @else
                                                                        <p class="text-right"><i>Sin Notas Adicionales</i></p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div role="tabpanel" id="tab-2" class="tab-pane">
                                            <div class="panel-body">
                                                <input type="hidden" name="" id="monto_contado" value="{{ number_format($tot_pagar,2) }}">
                                                <input type="hidden" name="" id="simbolo_monto" value="{{ $factura->moneda->simbolo }}">
                                                <input type="hidden" name="" id="fecha_vencimiento" value="{{ Carbon\Carbon::parse($factura->fecha_vencimiento)->format('d-m-Y') }}">
                                                <input type="hidden" name="" id="monto_sin_format_0" value="{{ $tot_pagar}}">
                                                <input type="hidden" name="" id="total_0" value="{{ $tot_pagar }}">
                                                <span hidden id="n_cuota_0">0</span>
                                                <span hidden id="cuota_view_n_0">1</span>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <h3>Informacion de Adelantos</h3>
                                                    </div>
                                                    <div class="col-sm-6 text-right" >
                                                        @if ($factura->estado_pago != 2)
                                                            <button class="btn btn-primary" id="adelantos_0"  data-toggle="modal" data-target="#myModal5" onclick="pago_adelanto({{$factura->id}},'only','0')">Adelantar</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover dataTables-examaple">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>METODO PAGO</th>
                                                                {{-- <th>CUOTA ASOCIADA</th> --}}
                                                                <th>MONTO DE ADELANTO</th>
                                                                <th>FECHA DE ADELANTO</th>
                                                                <th>VER DETALLES</th>
                                                                <th>VER COMPROBANTE</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (is_object($adelantos_reg))
                                                                @foreach ($adelantos_reg as $index =>  $adl_reg)
                                                                    <tr>
                                                                        <td>{{$index+1}}</td>
                                                                        <td>
                                                                            <p class="text-left">
                                                                                {{ ucfirst($adl_reg->tipo_pago) }}
                                                                            </p>
                                                                        </td>
                                                                        <td>{{$factura->moneda->simbolo}} {{number_format($adl_reg->montos_input,2)}}</td>
                                                                        <td>{{Carbon\Carbon::parse($adl_reg->fechas_input)->format('d-m-Y')}}</td>
                                                                        <td>
                                                                            <div class="col-sm-2"><button type="button" class="btn btn-primary btn-sm" id="view_detail_adelanto" onclick="search_adelantos({{$adl_reg->id}})" ><i class="fa fa-eye"></i></button></div>
                                                                        </td>
                                                                        <td>
                                                                            <a class="btn btn-secondary btn-sm" href="{{route('adelantos.comprobantes_pdf', $adl_reg->id)}}"><i class="fa fa-download"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
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
    
    {{-- ! AGREGAR ADELANTO --}}




    {{-- ! VER DETALLE PAGO --}}
    <div class="modal fade bd-example-modal-lg" id="detalle_pago" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle de Cuota N° {1} | {p}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <h1 id="id_cuota"></h1> --}}
                    <div class="row">
                        <div class="col-sm-4">
                            <h3 class="text-center">N° de Cuota</h3>
                            {{-- <input type="text" class="form-control" name="" id="n_cuota_header" readonly> --}}
                            <p class="form-control text-center" id="n_cuota_header">Cuota N° </p>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="text-center">Monto</h3>
                            {{-- <input type="text" class="form-control" name="" id="monto_cuota_header" readonly> --}}
                            <p class="form-control text-center" id="monto_cuota_header">Cuota N° </p>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="text-center">Estado</h3>
                            {{-- <input type="text" class="form-control" name="" id="estado_cuota_header" readonly> --}}
                            <p class="form-control text-center" id="estado_cuota_header">Cuota N° </p>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <div class="tabs-container">
                        <div class="tabs-left" id="body_pago_detail">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .form-control {
            border-radius: 5px;
        }

        .pago_m {
            display: none;
        }

        .pago_m.m_pago_1 {
            display: flex;
        }

        #pendiente {
            background-color: rgb(169, 169, 0);
            border-color: rgb(169, 169, 0);
            margin: 0px;
            color: white;
            cursor: auto;
            width: 100%;
        }

        #retrasado {
            /* color: rgb(177, 0, 0); */
            background-color: rgb(177, 0, 0);
            border-color: rgb(177, 0, 0);
            margin: 0px;
            color: white;
            cursor: auto;
            width: 100%;
        }

        #pagado {
            /* color: rgb(0, 199, 0); */
            background-color: rgb(0, 199, 0);
            border-color: rgb(0, 199, 0);
            margin: 0px;
            width: 100%;
            color: white;
            cursor: auto;
        }

        #view_all {
            display: none;
        }

        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            vertical-align: middle;
        }

        .view_pagos {
            display: none;
        }

        .text-area-false {
            display: block;
            width: 100%;
            /* Ajusta el ancho deseado */
            height: 80px;
            /* Ajusta la altura deseada */
            padding: 8px;
            border: 1px solid #e5e6e7;
            overflow: auto;
            background-color: white;
        }

        p.form-control {
            margin-bottom: 0px;
        }

        p {
            margin-bottom: 0px;
        }

        .footable-row-detail-name {
            display: none;
        }

        .footable-row-detail-value {
            width: 50vw;
        }

        hr {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .contado_pago>* {
            margin-top: 10px;
        }
        .footable-row-detail-inner{
            width: 100%;
        }
        .table_div_adelantos{
            margin-right: 15px;
            margin-left: 15px;
        }
        .table_div_adelantos > div > div{
            border: 1px solid #dee2e6;
            padding: 5px 15px;
        }
        /* .table-mini{
            font-size: 10px;
        }
        .table-mini > thead > tr > th{ 
            padding: 5px 15px;
            vertical-align: middle;
            font-weight: bold;
        }
        .table-mini > tbody > tr > td{
            padding: 5px 15px;
        } */
        .select2.select2-container.select2-container--default{
            width: 100% !important;
        }
        span.select2-container.select2-container--default.select2-container--open{
            z-index: 99999 !important;
        }
    </style>
    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>

    <link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
    <!-- Switchery -->
    <script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    @include('cobranzas.pago_contado')
    @include('cobranzas.adelanto_view')
    @include('cobranzas.adelanto')
    
    <script>
        var elem_2 = document.querySelector('.js-switch-pago');
        var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $('.dataTables-examaple').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $('.footable').footable();
         
            $('#select_banco_pagos').select2({
                placeholder: "Seleccionar",
            });
            $('#select_cuenta_pago').select2({
                placeholder: "Seleccionar",
            });
            
            $('#select_banco_transf_pag').select2({
                placeholder: "Seleccionar",
            });
            $('#select_cuenta_adl_pag').select2({
                placeholder: "Seleccionar",
            });
            $('#id_factura').attr('name', 'id_factura[]');
            $('#cod_factura').attr('name', 'numero_factura[]');
        });
        function changue_bancos_pagos(){
            // $("#select_banco_adl").attr('disabled', false);
            console.log('a');
            var id_banc = $("#select_banco_pagos").val();
            $('#select_cuenta_pago').select2({
                placeholder: "Seleccionar",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{route('bancos.registros_search')}}",
                    dataType: 'json',
                    type: "POST",
                    data: function (params) {
                        return {
                            '_token': $('input[name=_token]').val(),
                            'id_bancos': id_banc
                        };
                    },
                    processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.tipo_cuenta+' - '+item.nombre_cuenta,
                            };
                        })
                    };
                    },
                    cache: true
                }
            });
        }
        function changue_bancos_pago_tr(){
            // $("#select_banco_adl").attr('disabled', false);
            console.log('a');
            var id_banc = $("#select_banco_transf_pag").val();
            $('#select_cuenta_adl_pag').select2({
                placeholder: "Seleccionar",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{route('bancos.registros_search')}}",
                    dataType: 'json',
                    type: "POST",
                    data: function (params) {
                        return {
                            '_token': $('input[name=_token]').val(),
                            'id_bancos': id_banc
                        };
                    },
                    processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.tipo_cuenta+' - '+item.nombre_cuenta,
                            };
                        })
                    };
                    },
                    cache: true
                }
            });
        }
    </script>
    <script>
        function detalle_cuota(item) {
            $('#detalle_pago').modal('show');
            $('#id_cuota').html(item);

            var data = item;
            $.ajax({
                type: "post",
                url: "{{ route('pagos.show_cuota') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'data': item,
                },
                success: function(msg) {
                    var numero = $(`#numero_` + item).val();
                    var monto = $(`#monto_` + item).val();
                    // var vencimiento = $(`#fecha_ven_` + item).val();
                    var estado = $(`#estado_` + item).val();
                    $('#n_cuota_header').html(`Cuota N° ` + numero);
                    $('#monto_cuota_header').html(monto);
                    $('#estado_cuota_header').html(estado);
                    $('#body_pago_detail').append(msg['html_end']);
                }
            });
        }
        // $('#detalle_pago')
        $('#detalle_pago').on('hidden.bs.modal', function(e) {
            $('#body_pago_detail').empty();
        });

        function check_lote(num) {
            var count_check = document.querySelectorAll('.check_only');
            let checkboxesDesactivados = 0;

            // Recorrer los checkboxes y contar los desactivados
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
            });
            // console.log(checkboxesDesactivados);
            if (checkboxesDesactivados > 0) {
                $('#pago_lote').attr('disabled', false);
            } else {
                $('#pago_lote').attr('disabled', true);
            }
        }

        function modal_pagos_lote(value) {
            $('#only_pago').css('display', 'none');
            $('#lote_pago').css('display', 'block');

            $('#todo_pago').modal('show');

            // for (let index = 0; index < array.length; index++) {
            var numero = $(`#numero_` + value).val();
            var monto = $(`#monto_` + value).val();
            var vencimiento = $(`#fecha_ven_` + value).val();
            var estado = $(`#estado_` + value).val();
            var total_c = $(`#total_` + value).val();
            console.log(total_c)
            var html = `
                    <div class="lote_pago_sect">
                        <div class="row">
                            <div class="col-sm-4">
                                <h3 class="text-center">Cuota N°: ` + numero + `</h3>
                                <h3 class="text-center">Monto: ` + monto + `</h3>
                                <input class="monto_total" type="hidden" name="" id="monto_value" value="` + total_c + `">
                            </div>
                            <div class="col-sm-4">
                                <h3 class="text-center">Fecha de Vencimiento</h3>
                                <p class="text-center"><label id="fecha_ven">` + vencimiento + `</label></p>
                            </div>
                            <div class="col-sm-4">
                                <h3 class="text-center">Estado</h3>
                                <p class="text-center"><label id="estado_n">` + estado + `</label></p>
                            </div>
                        </div>
                        <hr>
                    </div>`;
            $('#lote_pago').append(html);
            var ids = `
                    <input class="input_check" type="hidden" name="id_cuota[]" value="` + value + `">
                    <input type="hidden" name="cuotas_precio_{{ $cod_fact }}[]" id="cuota_precio_` + value +
                `" value="` + value + '_' + total_c + `" class="cuota_prec_fact">
                `;
            $('#ids_divs_factura').append(ids);

        }
        $('#pago_lote').on('click', function() {
            $('.lote_pago_sect').remove();
            $('.input_check').remove();
            $('.cuota_prec_fact').remove();
            var total_c = 0;
            var count_check = document.querySelectorAll('.check_only');
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    var id_cuot = checkbox.id;
                    let id_one = id_cuot.match(/\d+/g);
                    modal_pagos_lote(id_one[0]);
                    total_c += parseFloat($(`#total_` + id_one[0]).val());
                    // $(`#cuota_precio`+id_one[0]+``).val(id_one[0] + '_' + total_c);
                }
            });
            $('#efectivo_pago').attr('min', total_c);
            $('#total_cuota').val(total_c);

        });
    </script>
@endsection
