@extends('layout')

@section('title', 'Cobros')
@section('content')
    <h1>{{ $cod_fact }}</h1>
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
                                                {{-- <label class="col-form-label">{{ $factura->cliente->nombre }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ $factura->cliente->nombre }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label
                                                class="col-sm-3 col-form-label"><strong>{{ strtoupper($factura->cliente->documento_identificacion) }}:</strong></label>
                                            <div class="col-sm-9">
                                                {{-- <label class="col-form-label">{{ $factura->cliente->nombre }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ $factura->cliente->numero_documento }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><strong>Telefono</strong></label>
                                            <div class="col-sm-9">
                                                {{-- <label class="col-form-label">{{ $factura->cliente->celular }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ $factura->cliente->celular }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"><strong>Email:</strong></label>
                                            <div class="col-sm-9">
                                                {{-- <label class="col-form-label">{{ $factura->cliente->email }}</label> --}}
                                                <input type="text" class="form-control"
                                                    value="{{ $factura->cliente->email }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-control">
                                    <h2 class="text-center"><strong>Datos de Comprobante</strong></h2>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label"><strong>Código:</strong></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" value="{{ $cod_fact }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label"><strong>Moneda</strong></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control"
                                                        value="{{ strtoupper($factura->moneda->nombre) }}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label"><strong>N° Cuotas:</strong></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control"
                                                        value="{{ $fact_cuotas->count() }}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label"><strong>Interes Porcentual :</strong></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" value=" " readonly>
                                                    <small>Dependiendo del cliente? / depender de un monto fijo? / </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label"><strong>Monto Total:</strong></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control"
                                                        value="{{ $factura->moneda->simbolo }} {{ $sum_total = number_format($fact_cuotas->sum('monto'), 2) }}"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label"><strong>Monto Pagado</strong></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" value="{{ $factura->moneda->simbolo }} {{ $pago_total = number_format($fact_cuotas->where('estado',1)->sum('monto'), 2) }}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label"><strong>Monto Deuda:</strong></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" value="{{ $factura->moneda->simbolo }} {{number_format($sum_total - $pago_total,2)}}" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label"><strong>Interes:</strong></label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" value="{{ $factura->moneda->simbolo }} {{number_format($sum_total - $pago_total,2)}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group row justify-content-center">
                                                <button class="btn btn-secondary">Descargar Detalle de Cuota</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="ibox-content" style="width: 100% !important">
                                <div class="row">
                                    <div class="col-sm-4">

                                    </div>
                                    <div class="col-sm-4">

                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control form-control-sm m-b-xs" id="filter"
                                            placeholder="Search in table">
                                    </div>
                                </div>
                                <br>
                                <table class="footable table table-stripped table-bordered table-hover toggle-arrow-tiny"
                                    data-page-size="8" data-filter="#filter">
                                    {{-- <table class="table table-striped table-bordered table-hover dataTables-example"> --}}

                                    <thead>
                                        <tr>
                                            <th data-sort-ignore="true" style="width: 50px;text-align: center">Pago Lote
                                            </th>
                                            <th>Id</th>
                                            <th style="width: 25px">Estado</th>
                                            <th>N° Cuota | MONTO</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Vencimiento</th>
                                            <th data-hide="all">Dias de retraso</th>
                                            {{-- <th data-hide="all">Interes de Retraso</th> --}}
                                            <th>Metodo de Pago</th>
                                            <th>Fecha de Pago</th>
                                            <th style="width: 170px">Pagar</th>
                                            {{-- <th>P</th> --}}
                                            {{-- <th>Pagar Lote</th> --}}
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fact_cuotas as $index => $fc_cuota)
                                            <tr>
                                                <td><input type="checkbox" name="" id=""></td>
                                                <td>{{ $fc_cuota->id }}</td>
                                                <td>
                                                    @if ($fc_cuota->estado == 0)
                                                        <button id="pendiente" class="btn btn-primary"
                                                            disabled><strong>PENDIENTE</strong></button>
                                                        <input type="hidden" name=""
                                                            id="estado_{{ $fc_cuota->id }}" value="PENDIENTE">
                                                    @elseif($fc_cuota->estado == 1)
                                                        <button id="pagado" class="btn btn-primary"
                                                            disabled><strong>PAGADO</strong></button>
                                                        <input type="hidden" name=""
                                                            id="estado_{{ $fc_cuota->id }}" value="PAGADO">
                                                    @else
                                                        <button id="retrasado" class="btn btn-primary"
                                                            disabled><strong>RETRASADO</strong></button>
                                                        <input type="hidden" name=""
                                                            id="estado_{{ $fc_cuota->id }}" value="RETRASADO">
                                                    @endif
                                                </td>
                                                <td>
                                                    Cuota N° {{ $fc_cuota->numero_cuota }} |
                                                    {{ $factura->moneda->simbolo }}
                                                    {{ number_format($fc_cuota->monto, 2) }}
                                                    <input type="hidden" name="" id="numero_{{ $fc_cuota->id }}"
                                                        value="{{ $fc_cuota->numero_cuota }}">
                                                    <input type="hidden" name="" id="monto_{{ $fc_cuota->id }}"
                                                        value="{{ $factura->moneda->simbolo }} {{ $fc_cuota->monto }}">
                                                    <input type="hidden" name="" id="total_{{ $fc_cuota->id }}"
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
                                                    {{-- @if () --}}
                                                        {{ Carbon\Carbon::parse($fc_cuota->fecha_pago)->format('d/m/Y') }}
                                                    {{-- @else --}}
                                                        
                                                    {{-- @endif --}}
                                                    <input type="hidden" name=""
                                                        id="fecha_ven_{{ $fc_cuota->id }}"
                                                        value="{{ $fc_cuota->fecha_pago }}">
                                                </td>
                                                <td>
                                                    @if ($fc_cuota->estado == 0)
                                                        @if ($fecha_hoy > $fc_cuota->fecha_pago)
                                                            <strong>{{ Carbon\Carbon::parse($fc_cuota->fecha_pago)->diffInDays(Carbon\Carbon::parse($fecha_hoy)) }}</strong>
                                                        @elseif($fecha_hoy == $fc_cuota->fecha_pago)
                                                            <strong>Ultimo dia de pago</strong>
                                                        @endif
                                                    @else
                                                        <strong>{{ Carbon\Carbon::parse($fc_cuota->fecha_pago)->diffInDays(Carbon\Carbon::parse($pagos[$index]->fecha_registros)) }}</strong>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    @if ($fc_cuota->estado == 0)
                                                        <strong>Sin Pago</strong>
                                                    @else
                                                        <strong>Acsá va pago de new tabla</strong>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    @if ($fc_cuota->estado == 0)
                                                        <strong>Sin Pago</strong>
                                                    @else
                                                        <strong>{{ strtoupper($pagos[$index]->tipo_pago) }}</strong>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($fc_cuota->estado == 0)
                                                        <strong>PENDIENTE</strong>
                                                    @elseif($fc_cuota->estado == 1)
                                                        <strong>{{ Carbon\Carbon::parse($pagos[$index]->fecha_registro)->format('d/m/Y') }}</strong>
                                                    @else
                                                        <strong>RETRASADO</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($fc_cuota->estado == 1)
                                                        <button class="btn btn-primary" id="pago" disabled>Pagar</button>
                                                        {{-- <button class="btn btn-primary" disabled>Adelanto</button> --}}
                                                    @else
                                                        <button class="btn btn-primary" id="pago"
                                                            onclick="modal_pagos({{ $fc_cuota->id }})" >Pagar</button>
                                                        {{-- <button class="btn btn-primary">Adelanto</button> --}}
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    {{-- MODAL DE VER DETALLES  --}}
                                                    @if ($fc_cuota->estado != 1)
                                                        <button class="btn btn-primary" disabled>Ver detalles</button>
                                                    @else
                                                        <button class="btn btn-primary"
                                                        onclick="detalle_cuota({{ $fc_cuota->id }})">Ver detalles</button>
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
                        <div class="row">
                            <div class="col-sm-4">
                                <h3 class="text-center">Cuota N° | Monto</h3>
                                <p class="text-center"><label id="cuota_n"></label> | <label id="monto_n"></label>
                                </p>
                                <input type="hidden" name="" id="monto_value">
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
                    </div>
                    <form action="{{ route('pagados.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_factura" id="id_factura" value="{{ $factura->id }}">
                        <input type="hidden" name="id_cuota" id="id_cuota_select" value="">
                        <input type="hidden" name="numero_factura[]" id="cod_factura" value="{{ $cod_fact }}">
                        <input type="hidden" name="tot_cuotas[]" id="total_cuota" value="">
                        <input type="hidden" name="cuotas_precio_{{ $cod_fact }}[]" id="cuota_precio"
                            value="">

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
    {{--! AGREGAR ADELANTO --}}



    
    {{--! VER DETALLE PAGO --}}
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
                    <h1 id="id_cuota"></h1>
                    <div class="row">
                        <div class="col-sm-4">
                            <h3 class="text-center">N° de Cuota</h3>
                            <input type="text" class="form-control" name="" id="" readonly>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="text-center">Monto</h3>
                            <input type="text" class="form-control" name="" id="" readonly>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="text-center">Estado</h3>
                            <input type="text" class="form-control" name="" id=""readonly>
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
        #view_all{
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
        .view_pagos{
            display: none;
        }
        .text-area-false{
            display: block;
            width: 100%; /* Ajusta el ancho deseado */
            height: 80px; /* Ajusta la altura deseada */
            padding: 8px;
            border: 1px solid #e5e6e7;
            overflow: auto;
            background-color: white;
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
            $('#todo_pago').modal('show');
            //se abre modal, llamado de ajax para chapar el detalle de cuota? 
            var numero = $(`#numero_` + value).val();
            var monto = $(`#monto_` + value).val();
            var vencimiento = $(`#fecha_ven_` + value).val();
            var estado = $(`#estado_` + value).val();
            var total_c = $(`#total_` + value).val();
            $('#cuota_n').html(numero);
            $('#monto_n').html(monto);
            $('#monto_value').html(total_c);
            $('#fecha_ven').html(vencimiento);
            $('#estado_n').html(estado);
            $('#efectivo_pago').attr('min', total_c);
            // var id_cuota = $(`#estado_`+value).val();
            $('#id_cuota_select').val(value);
            $('#total_cuota').val(total_c);
            $(`#cuota_precio`).val(value + '_' + total_c);
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
            var total = $('#monto_value').text();
            console.log(total);
            var vuelto = parseFloat(this.value) - parseFloat(total);
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
                success: function (msg) {
                    $('#body_pago_detail').append(msg['html_end']);
                    // alert(msg);
                    // console.log(msg);
                    // console.log(msg);

                    // switch (msg.tipo_pago ==") {
                    //     case valor1:
                    //         //Declaraciones ejecutadas cuando el resultado de expresión coincide con el valor1
                    //     [break;]
                    //     case valor2:
                    //         //Declaraciones ejecutadas cuando el resultado de expresión coincide con el valor2
                    //     [break;]
                    //     case valorN:
                    //         //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                    //     [break;]
                    // }
                    // if (msg.tipo_pago == "cheque") {
                    //     $('#view_all').css('display', none);
                    //     $('.view_cheque').css('display', block);
                    //     console.log('a');
                    // }
                    // if (msg.tipo_pago == "tarjeta") {
                    //     $('#view_all').css('display',none);
                    //     $('.view_tarjeta').css('display', block);
                    //     console.log('b');
                    // }
                    // if (msg.tipo_pago == "efectivo") {
                    //     $('#view_all').css('display',none);
                    //     $('.view_efectivo').css('display', block);
                    //     console.log('c');
                    // }
                    // if (msg.tipo_pago == "transferencia") {
                    //     $('#view_all').css('display',none);
                    //     $('.view_transferencia').css('display', block);
                    //     console.log('d');
                    // }
                }
            });
        }
        // $('#detalle_pago')
            $('#detalle_pago').on('hidden.bs.modal', function (e) {
                $('#body_pago_detail').empty();
            })
    </script>
@endsection
