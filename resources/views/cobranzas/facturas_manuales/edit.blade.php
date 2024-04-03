@extends('layout')

@section('title', 'Registros ' . $cod_fact)
@section('content')
    {{-- <h1>{{ $cod_fact }}</h1> --}}
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
                                    @if ($factura->forma_pago_id == 2)
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
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto
                                                            Total:</strong></label>
                                                    <div class="col-sm-7">
                                                        {{-- @if ($fact_cuotas->sum('monto') != 0) --}}
                                                        <p class="form-control">{{ $factura->moneda->simbolo }}
                                                            {{ $sum_total = number_format($fact_cuotas->sum('monto'), 2) }}
                                                        </p>
                                                        {{-- @else
                                                            <p class="form-control">{{ $factura->moneda->simbolo }} {{ $sum_total = 0}}</p>
                                                        @endif --}}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto
                                                            Pagado</strong></label>
                                                    <div class="col-sm-7">
                                                        @if ($fact_cuotas->where('estado', 1)->sum('monto') != 0)
                                                            <p class="form-control">{{ $factura->moneda->simbolo }}
                                                                {{ $pago_total = number_format($fact_cuotas->where('estado', 1)->sum('monto'), 2) }}
                                                            </p>
                                                        @else
                                                            <p class="form-control">{{ $factura->moneda->simbolo }}
                                                                {{ $pago_total = 0 }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto
                                                            Deuda:</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">{{ $factura->moneda->simbolo }}
                                                            {{ number_format($fact_cuotas->sum('monto') - $fact_cuotas->where('estado', 1)->sum('monto'), 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Interes:</strong></label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">
                                                            {{ $factura->moneda->simbolo }} {{number_format($sum_total - $pago_total,2)}}
                                                        </p>
                                                    </div>
                                                </div> --}}
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group row justify-content-center">
                                                    {{-- <button class="btn btn-secondary">Descargar Detalle de Cuota</button> --}}
                                                    <a class="btn btn-secondary"
                                                        href="{{ route('pagos.print_cuotas', $factura->id) }}"
                                                        target="_blank">Descargar Detalle de Cuota</a>
                                                </div>
                                            </div>

                                        </div>
                                    @else
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
                                                            </span>
                                                            {{ number_format(round($subtotal + ($factura->op_gravada * $igv->renta) / 100, 2), 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-5 col-form-label"><strong>Monto
                                                            Pagado: </strong></label>
                                                    <div class="col-sm-7">
                                                        @if ($factura->estado_pago == 2)
                                                            <p class="form-control">{{ $factura->moneda->simbolo }}
                                                                {{ number_format(round($subtotal + ($factura->op_gravada * $igv->renta) / 100, 2), 2) }}
                                                            </p>
                                                        @else
                                                            <p class="form-control">{{ $factura->moneda->simbolo }}
                                                                {{ $pago_total = 0.0 }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-5 col-form-label">
                                                        <strong>Fecha de Pago</strong>
                                                    </label>
                                                    <div class="col-sm-7">
                                                        <p class="form-control">
                                                            @if ($factura->estado_pago == 1)
                                                                Sin Pago
                                                            @else
                                                                {{ Carbon\Carbon::parse($pagos->pluck('fecha_registro')->first())->format('d-m-Y') }}
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
                                                        href="{{ route('facturacion_manual.show', $factura->id) }}"
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
                                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Cuotas</a>
                                        </li>
                                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Adelantos</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                                                <br>
                                                @if ($factura->forma_pago_id == 2)
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <input type="text"
                                                                class="form-control form-control-sm m-b-xs" id="filter"
                                                                placeholder="Search in table">
                                                        </div>
                                                        <div class="col-sm-8 text-right">
                                                            @if ($fact_cuotas->where('facturacion_id', $factura->id)->where('estado', 1)->count() != $fact_cuotas->count())
                                                                <button class="btn btn-secondary pago_all_lote"
                                                                    id="pago_lote" disabled>Pagar
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
                                                                    <th data-sort-ignore="true">Pago Lote</th>
                                                                @endif
                                                                <th style="width: 25px">Estado</th>
                                                                <th>N° Cuota </th>
                                                                <th>MONTO</th>
                                                                <th>Fecha Inicio</th>
                                                                <th>Fecha Vencimiento</th>
                                                                <th data-hide="all" style="display: none !important;">Dias
                                                                    de
                                                                    Restraso:
                                                                </th>
                                                                {{-- <th data-hide="all"></th> --}}
                                                                <th>Metodo de Pago</th>
                                                                <th>Fecha de Pago</th>
                                                                <th data-sort-ignore="true" style="width: 170px">Pagar | Adelantar
                                                                </th>
                                                                {{-- <th>P</th> --}}
                                                                {{-- <th>Pagar Lote</th> --}}
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
                                                                            <button id="pendiente" class="btn btn-primary"
                                                                                disabled><strong>PENDIENTE</strong></button>
                                                                            <input type="hidden" name=""
                                                                                id="estado_{{ $fc_cuota->id }}"
                                                                                value="PENDIENTE">
                                                                        @elseif($fc_cuota->estado == 1)
                                                                            <button id="pagado" class="btn btn-primary"
                                                                                disabled><strong>PAGADO</strong></button>
                                                                            <input type="hidden" name=""
                                                                                id="estado_{{ $fc_cuota->id }}"
                                                                                value="PAGADO">
                                                                        @else
                                                                            <button id="retrasado" class="btn btn-primary"
                                                                                disabled><strong>RETRASADO</strong></button>
                                                                            <input type="hidden" name=""
                                                                                id="estado_{{ $fc_cuota->id }}"
                                                                                value="RETRASADO">
                                                                        @endif
                                                                    </td>
                                                                    <td>Cuota N° {{ $fc_cuota->numero_cuota }}</td>
                                                                    <td>
                                                                        {{ $factura->moneda->simbolo }}
                                                                        {{ number_format($fc_cuota->monto, 2) }}
                                                                        <input type="hidden" name=""
                                                                            id="numero_{{ $fc_cuota->id }}"
                                                                            value="{{ $fc_cuota->numero_cuota }}">
                                                                        <input type="hidden" name=""
                                                                            id="monto_{{ $fc_cuota->id }}"
                                                                            value="{{ $factura->moneda->simbolo }} {{ $fc_cuota->monto }}">
                                                                        <input type="hidden" name=""
                                                                            id="total_{{ $fc_cuota->id }}"
                                                                            value="{{ $fc_cuota->monto }}">
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
                                                                        @if ($fc_cuota->estado == 1)
                                                                            @if ($pagos_reg[$index]->fecha_pago == $fc_cuota->fecha_pago)
                                                                                Se pagó el mismo día
                                                                            @elseif(Carbon\Carbon::parse($fc_cuota->fecha_pago)->diffInDays($pagos_reg[$index]->fecha_pago) > 0)
                                                                                Se pagó a tiempo
                                                                            @else
                                                                                Tiene
                                                                                {{ Carbon\Carbon::parse($fc_cuota->fecha_pago)->diffInDays($pagos_reg[$index]->fecha_pago) }}
                                                                                días de Retraso
                                                                            @endif
                                                                        @else
                                                                            Aun no ha sido pagado
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if (isset($pagos_reg[$index]))
                                                                            <strong>{{ strtoupper($pagos_reg[$index]->comprobante_pago->tipo_pago) }}</strong>
                                                                        @else
                                                                            <strong>Sin Pago</strong>
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
                                                                        @if ($fc_cuota->estado == 1)
                                                                            <button class="btn btn-primary" id="pago"
                                                                                disabled>Pagar</button>
                                                                        @else
                                                                            <button class="btn btn-primary" id="pago"
                                                                                onclick="modal_pagos({{ $fc_cuota->id }})">Pagar</button>
                                                                        @endif
                                                                        {{-- <div class="btn-group">
                                                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Seleccionar</button>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a class="dropdown-item" href="#">Pagar</a></li>
                                                                                <li><a class="dropdown-item" href="#" class="font-bold">Another action</a></li>
                                                                            </ul>
                                                                        </div> --}}
                                                                    </td>
                                                                    <td>
                                                                        {{-- MODAL DE VER DETALLES  --}}
                                                                        @if ($fc_cuota->estado != 1)
                                                                            <button class="btn btn-primary" disabled>Ver
                                                                                detalles</button>
                                                                        @else
                                                                            <button class="btn btn-primary"
                                                                                onclick="detalle_cuota({{ $fc_cuota->id }})">Ver
                                                                                detalles</button>
                                                                            <input type="hidden" name=""
                                                                                id="">
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
                                                    <h3>Informacion del Pago</h3>
                                                    <div class="row contado_pago">
                                                        <div class="col-sm-3">
                                                            <div class="form-control">
                                                                <p><strong>Tipo de Pago:</strong></p>
                                                                <hr>
                                                                @if ($factura->estado_pago != 0)
                                                                    <h3 class="text-right">
                                                                        {{ ucfirst($pagos->pluck('tipo_pago')->first()) }}
                                                                    </h3>
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
                                                                        <p class="text-right">{{ $pagos_deta[0]->numero_input }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha de Cobro</strong>
                                                                        <hr>
                                                                        {{-- <p class="text-right">{{$pagos_deta[0]->}}</p> --}}
                                                                        <p class="text-right">
                                                                            {{ Carbon\Carbon::parse($pagos_deta[0]->fechas_input)->format('d-m-Y') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Banco Emisor</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{ $pagos_deta[0]->bancos_input }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Beneficiario</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{ $pagos_deta[0]->persona_input }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Monto Pagado</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{ $factura->moneda->simbolo }}
                                                                            {{ number_format($pagos_deta[0]->montos_input, 2) }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>N° de Cuenta</strong>
                                                                        <hr>
                                                                        <p class="text-right">
                                                                            {{ $pagos_deta[0]->adicional_input }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha de Emision</strong>
                                                                        <hr>
                                                                        <p class="text-right">
                                                                            {{ Carbon\Carbon::parse($pagos_deta[0]->fecha_emision_input)->format('d-m-Y') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @break

                                                            @case('tarjeta')
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Titular de la Tarjeta</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{ $pagos_deta[0]->persona_input }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Banco</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{ $pagos_deta[0]->bancos_input }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha</strong>
                                                                        <hr>
                                                                        <p class="text-right">
                                                                            {{ Carbon\Carbon::parse($pagos_deta[0]->fechas_input)->format('d-m-Y') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @break

                                                            @case('efectivo')
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Persona que Cancela</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{ $pagos_deta[0]->persona_input }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha</strong>
                                                                        <hr>
                                                                        <p class="text-right">
                                                                            {{ Carbon\Carbon::parse($pagos_deta[0]->fechas_input)->format('d-m-Y') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Monto de Pago</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{ $factura->moneda->simbolo }}
                                                                            {{ number_format($pagos_deta[0]->montos_input, 2) }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Vuelto</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{ $factura->moneda->simbolo }}
                                                                            {{ $pagos_deta[0]->adicional_input }}</p>
                                                                    </div>
                                                                </div>
                                                            @break

                                                            @case('transferencia')
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Titular</strong>
                                                                        <hr>
                                                                        <p class="text-right">{{ $pagos_deta[0]->persona_input }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-control">
                                                                        <strong>Fecha</strong>
                                                                        <hr>
                                                                        <p class="text-right">
                                                                            {{ Carbon\Carbon::parse($pagos_deta[0]->fechas_input)->format('d-m-Y') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @break

                                                            @default
                                                        @endswitch
                                                        @if ($factura->estado_pago != 0)
                                                            <div class="col-sm-3">
                                                                <div class="form-control">
                                                                    <strong>Comprobante</strong>
                                                                    <hr>
                                                                    @if (isset($pagos_deta[0]->file_input))
                                                                        <p class="text-right">
                                                                            <a class=" btn btn-secondary btn-sm"
                                                                                href="{{ asset('archivos/pagos_sistema/' . $pagos_deta[0]->file_input) }}"
                                                                                download="{{ $pagos_deta[0]->file_input }}">Descargar&nbsp;<i
                                                                                    class="fa fa-download"></i></a>
                                                                        </p>
                                                                    @else
                                                                        <p class="text-right"><i>Sin Comprobante</i></p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6" style="height: 100% !important;">
                                                                <div class="form-control">
                                                                    <strong>Notas Adicionales</strong>
                                                                    <hr>
                                                                    @if (isset($pagos_deta[0]->notas_adicionales))
                                                                        <p class="text-right">
                                                                            {{ $pagos_deta[0]->notas_adicionales }}</p>
                                                                    @else
                                                                        <p class="text-right"><i>Sin Notas Adicionales</i>
                                                                        </p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="tabpanel" id="tab-2" class="tab-pane">
                                            <div class="panel-body">

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
    {{-- AGREGAR PAGO / POSIBILIDAD DE REUTILIZAR --}}
    <div class="modal fade bd-example-modal-lg" id="todo_pago" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="metodo_pago_header">
                        <div id="only_pago">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h3 class="text-center">Cuota N° | Monto</h3>
                                    <p class="text-center"><label id="cuota_n"></label> | <label
                                            id="monto_n"></label>
                                    </p>
                                    <input class="monto_total" type="hidden" name="" id="monto_value"
                                        value="0">
                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Fecha de Vencimiento</h3>
                                    <p class="text-center"><label id="fecha_ven"></label></p>
                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Estado</h3>
                                    <p class="text-center"><label id="estado_n"></label></p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div id="lote_pago">

                        </div>
                    </div>
                    <form action="{{ route('pagados.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_factura" id="id_factura[]" value="{{ $factura->id }}">
                        <div class="display: none" id="ids_divs_factura">

                        </div>
                        <input type="hidden" name="numero_factura[]" id="cod_factura" value="{{ $cod_fact }}">
                        <input type="hidden" name="tot_cuotas[]" id="total_cuota" value="">
                        {{-- <input type="hidden" name="cuotas_precio_{{ $cod_fact }}[]" id="cuota_precio"value=""> --}}

                        <input type="hidden" value="{{ $fecha_hoy }}" name="" id="fecha_value_php">
                        {{-- <input class="form-control" type="hidden" name="numero_factura[]" id="numero_fac_`+index+`" value="`+row.factura_cod+`"> --}}
                        <div class="metodo_pago">
                            <input type="hidden" name="input_pago" id="input_pago" value="1">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h3 class="text-center">Metodos de Pago</h3>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_1"
                                            class="btn btn-block btn-primary btn_pago_selec active" id="bm_pago_1"
                                            onclick="select_pago(1)">Cheque</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_2"
                                            class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_2"
                                            onclick="select_pago(2)">Tarjeta</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_3"
                                            class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_3"
                                            onclick="select_pago(3)">Efectivo</button>
                                    </div>
                                    <br>
                                    <div class="col-lg-12">
                                        <button type="button" value="btn_pago_4"
                                            class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_4"
                                            onclick="select_pago(4)">Transferencia</button>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row pago_m m_pago_1"> {{-- Metodo de Pago 1 - CHEQUE --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Numero de Cheque</label>
                                                <input type="text" id="" name="cheque_name" value=""
                                                    placeholder="Numero de Cheque"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha de Cobro</label>
                                                <input type="date" id="" name="cheque_fecha_cobro"
                                                    value="{{ $fecha_hoy }}" placeholder="Fecha de Cobro"
                                                    class="form-control pago_class_1 class_pago fecha_hoy" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Banco Emisor</label>
                                                {{-- <input type="text" id="" name="cheque_banco_emisor" value="" placeholder="Banco Emisor" class="form-control pago_class_1 class_pago" required> --}}
                                                <select class="form-control pago_class_1 class_pago"
                                                    name="cheque_banco_emisor" id="" required>
                                                    <option value="">Seleccionar Banco</option>
                                                    <option value="BCP">BCP</option>
                                                    <option value="INTERBANK">INTERBANK</option>
                                                    <option value="BBVA">BBVA</option>
                                                    <option value="SCOTIABANK">SCOTIABANK</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Beneficiario</label>
                                                <input type="text" id="" name="cheque_beneficiario"
                                                    value="" placeholder="Beneficiario"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Monto</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                    </div>
                                                    <input type="number" id="cheque_monto" name="cheque_monto"
                                                        value="" placeholder="Monto"
                                                        class="form-control pago_class_1 class_pago" required
                                                        step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">N° de Cuenta</label>
                                                <input type="text" value="" name="cheque_n_cuenta"
                                                    placeholder="N° de Cuenta"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha de Emision</label>
                                                <input type="date" value="{{ $fecha_hoy }}"
                                                    name="cheque_fecha_emision" placeholder="Fecha de Emision"
                                                    class="form-control pago_class_1 class_pago" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Comprobante
                                                    <small>(opcional)</small></label>
                                                <input type="file" name="cheque_file" id=""
                                                    class="form-control pago_class_1 class_pago file_input">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- {{$fecha_hoy}} --}}
                                    <div class="row pago_m m_pago_2"> {{-- Metodo de Pago 2 - TARJETA --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Titular de la Tajeta</label>
                                                <input type="text" id="" name="tarjeta_titular"
                                                    value="" placeholder="Titular de la Tajeta"
                                                    class="form-control pago_class_2 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Banco</label>
                                                <select class="form-control pago_class_2 class_pago" name="tarjeta_banco"
                                                    id="">
                                                    <option value="">Seleccionar Banco</option>
                                                    <option value="BCP">BCP</option>
                                                    <option value="INTERBANK">INTERBANK</option>
                                                    <option value="BBVA">BBVA</option>
                                                    <option value="SCOTIABANK">SCOTIABANK</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha</label>
                                                <input type="date" value="{{ $fecha_hoy }}"
                                                    class="form-control pago_class_2 class_pago fecha_hoy"
                                                    name="tarjeta_fecha" id="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Comprobante</label>
                                                <input type="file"
                                                    class="form-control pago_class_2 class_pago file_input"
                                                    name="tarjeta_file" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pago_m m_pago_3"> {{-- Metodo de Pago 3 - EFECTIVO --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Persona que Cancela</label>
                                                <input type="text" id="" name="efectivo_persona"
                                                    value="" placeholder="Titular"
                                                    class="form-control pago_class_3 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha</label>
                                                <input type="date" name="fecha_efectivo"
                                                    class="form-control pago_class_3 class_pago fecha_hoy" id=""
                                                    value="{{ $fecha_hoy }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Monto de Pago</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago">S/</span>
                                                    </div>
                                                    <input type="number" name="monto_pago_efectivo" id="efectivo_pago"
                                                        class="form-control pago_class_3 class_pago" placeholder=""
                                                        step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Vuelto</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                    </div>
                                                    <input type="text" name="monto_vuelto" id="efectivo_vuelto"
                                                        class="form-control pago_class_3 class_pago" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pago_m m_pago_4"> {{-- Metodo de Pago 4 - TRANSFERENCIA --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Titular</label>
                                                <input type="text" id="" name="transferencia_titular"
                                                    value="" placeholder="Titular"
                                                    class="form-control pago_class_4 class_pago">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Fecha</label>
                                                <input type="date"
                                                    class="form-control pago_class_4 class_pago fecha_hoy"
                                                    name="transferencia_fecha" id=""
                                                    value="{{ $fecha_hoy }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Comprobante</label>
                                                <input type="file"
                                                    class="form-control pago_class_4 class_pago file_input"
                                                    name="transferencia_comprobante" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> {{--  NOTAS PARA TODOS --}}
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-form-label">Notas Adicionales</label>
                                                <textarea class="form-control" name="notas_adicionales" id="" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
    </style>
    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $('.footable').footable();
        });
    </script>
    <script>
        function modal_pagos(value) {
            $('.input_check').remove();
            $('.cuota_prec_fact').remove();
            $('#lote_pago').css('display', 'none');
            $('#only_pago').css('display', 'block');

            $('#todo_pago').modal('show');
            //se abre modal, llamado de ajax para chapar el detalle de cuota? 
            var numero = $(`#numero_` + value).val();
            var monto = $(`#monto_` + value).val();
            var vencimiento = $(`#fecha_ven_` + value).val();
            var estado = $(`#estado_` + value).val();
            var total_c = $(`#total_` + value).val();
            var ids = `
                <input class="input_check" type="hidden" name="id_cuota[]" value="` + value + `">
                <input type="hidden" name="cuotas_precio_{{ $cod_fact }}[]" id="cuota_precio_` + value +
                `" value="` + value + '_' + total_c + `" class="cuota_prec_fact">
            `;
            $('#ids_divs_factura').append(ids);

            // console.log(total_c);
            // var ids = `
        //     <input class="input_check" type="hidden" name="id_cuota[]" value="`+value+`">
        //     <input type="hidden" name="cuotas_precio_{{ $cod_fact }}[]" id="cuota_precio" value="`+value + '_' + total_c+`" class="cuota_prec_fact">
        // `;
            // $('#ids_divs_factura').append(ids);

            console.log(total_c);
            $('#cuota_n').html(numero);
            $('#monto_n').html(monto);
            $('#monto_value').val(total_c);
            $('#fecha_ven').html(vencimiento);
            $('#estado_n').html(estado);
            $('#efectivo_pago').attr('min', total_c);
            // var id_cuota = $(`#estado_`+value).val();
            $('#id_cuota_select').val(value);
            console.log('a: ' + total_c)
            $('#total_cuota').val(total_c);
            // $(`#cuota_precio`).val(value + '_' + total_c);
            // $('#cuota_precio').val(total_c);

            // cuotas_precio_

        }

        function select_pago(item) {
            $('.pago_m').css('display', 'none');
            $(`.m_pago_` + item).css('display', 'flex');

            $('.class_pago').attr('required', false);
            // $('.class_pago').val('');
            $(`.pago_class_` + item).attr('required', true);
            $(`.file_input`).attr('required', false);



            $('.btn_pago_selec').removeClass("active");
            $(`#bm_pago_` + item).addClass("active");
            $('#input_pago').val(item);

            var fecha = $('#fecha_value_php').val();
            console.log(fecha);
            $('.fecha_hoy').val(fecha);

        }
        $('#efectivo_pago').on('keyup', function() {
            var pago = this.value;
            // var total = $('.monto_total').text();
            var total_monto = $('[class="monto_total"]');
            var tot_mont = 0;

            total_monto.each(function() {
                tot_mont += parseFloat($(this).val());
            });
            console.log(total_monto);
            var vuelto = parseFloat(this.value) - parseFloat(tot_mont);
            $('#efectivo_vuelto').val(Math.round(vuelto * 100) / 100);
        })

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
