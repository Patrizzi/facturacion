@extends('layout')

@section('title', 'Pagos de Nota de Venta')
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Sin Pagar</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Pagados</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Cliente</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active show">
                            <div class="panel-body">
                                <br>
                                <hr>
                                <div class="row" style="margin-right: 5px">
                                    <div class="col-sm-3 text-right">
                                        <div class="form-group row" style="margin-left: 15px">
                                            <label class="col-sm-3 col-form-label">Estado:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        value="01-01-2024  31-01-2024" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_fechas()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group row" style="margin-left: 15px">
                                            <label class="col-sm-3 col-form-label">Cliente:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select class="select2_demo_client" name="cliente" id="cliente"
                                                        required=""></select>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_select()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group row" style="margin-left: 15px">
                                            <label class="col-sm-3 col-form-label">Estado:</label>
                                            <div class="col-sm-9">
                                                <select class="select_2_estado" name="" id="select_estado">
                                                    <option value="">Seleccionar una opción</option>
                                                    <option value="sin">Sin Pagar</option>
                                                    <option value="parcial">Pagado Parcial</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group row" style="margin-left: 15px">
                                            <label class="col-sm-3 col-form-label font-weight-bold ">Tipo:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group" style="align-items: center">
                                                    Contado: &nbsp;<input type="checkbox" class="form-control tipo_check"
                                                        name="" id="contad_check">&nbsp;&nbsp;
                                                    Credito: &nbsp;<input type="checkbox" class="form-control tipo_check"
                                                        name="" id="credit_check">
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_select_estado()" style="visibility: hidden">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1 text-right">
                                        <button class="btn btn-primary" type="button" id="pago_lote_total" disabled>Pagar
                                            Lote</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th >Item</th>
                                                <th>Pagar</th>
                                                <th>Estado</th>
                                                <th style="width: 140px !important">N° NV</th>
                                                <th>Cliente</th>
                                                <th>Fecha de Emision</th>
                                                <th>Tipo de Pago</th>
                                                <th>Monto Total</th>
                                                {{-- <th>Total</th> --}}
                                                <th>Adelantado</th>
                                                <th>Detalles</th>
                                                <th>Pagar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nota_venta->where('estado_pago', '!=' , 2) as $index => $n_v)
                                                <tr>
                                                    <td>{{$n_v->id}}</td>
                                                    <td>
                                                        <input type="checkbox" name=""
                                                            id="check_{{ $n_v->id }}"
                                                            class="form-control check_only check_lost_{{ $index }} {{ $n_v->moneda->nombre }}"
                                                            onclick="check_lote({{ $index }})">
                                                    </td>
                                                    <td class="tooltip-demo">
                                                        <center>
                                                            @if ($n_v->estado_pago == 1)
                                                                <button id="parcial" disabled class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pagado Parcial"> <i class="fa fa-exclamation-circle"></i> </button>
                                                            @endif
                                                            @if ($n_v->estado_pago == 0)
                                                                <button id="nulo" disabled class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Sin Pago"> <i class="fa fa-times"></i> </button>
                                                            @endif
                                                        </center>
                                                    </td>
                                                    <td>
                                                        {{$n_v->cod_nota_venta}}
                                                        <input type="hidden" value="{{$n_v->cod_nota_venta}}" id="serie_comp_{{$n_v->id}}">
                                                        <input type="hidden" value="{{$n_v->moneda->simbolo}}" id="simbolo_precio_{{$n_v->id}}">
                                                    </td>
                                                    <td>
                                                        {{$n_v->cliente->nombre}}
                                                    </td>
                                                    <td>
                                                        {{Carbon\Carbon::parse($n_v->fecha_emision)->format('d-m-Y')}}
                                                    </td>
                                                    <td>
                                                        @if ($n_v->formato_pago == 1)
                                                            Contado
                                                        @else
                                                            Credito
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{$n_v->moneda->simbolo}} 
                                                        <span hidden>{{ $tot = round($totales[$index],2)}}</span> 
                                                        
                                                        {{number_format(round($totales[$index],2),2)}}
                                                    </td>
                                                    <td> {{$n_v->moneda->simbolo}}
                                                        @if ($n_v->estado_pago == 1)
                                                            <span hidden>{{ $exists = $adelantos->where('nota_ven_id', $n_v->id)->first()}}</span>
                                                            <span hidden>{{ $exists_pre = round($exists->precio_adelanto,2)}}</span>
                                                            {{number_format( $exists_pre,2)}}
                                                        @else
                                                            <span hidden>{{$exists_pre = 0.00 }}</span>
                                                            0.00
                                                        @endif
                                                        <input type="hidden" value="{{number_format(round($tot - $exists_pre,2),2)}}" id="total_{{$n_v->id}}">
                                                        <input type="hidden" value="{{round($tot - $exists_pre,2)}}" id="monto_sin_format_{{$n_v->id}}">
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('pagos.show_nota_venta', $n_v->cod_nota_venta) }}">Detalles</a>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Seleccionar</button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" class="btn btn-primary" onclick="pago_n_venta( {{ $n_v->id }})" >Pagar</a></li>
                                                                <li><a class="dropdown-item" class="btn btn-primary" data-toggle="modal" data-target="#myModal5" onclick="pago_adelanto({{$n_v->id}},'full',{{$n_v->id}})">Adelantar</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <div class="row" style="margin-right: 5px">
                                    <div class="col-sm-4">
                                        <div class="form-group row" style="margin-left: 15px">
                                            <label class="col-sm-3 col-form-label">Cliente:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select class="select2_demo_client_2" name="cliente_2" id="cliente_2"
                                                        required=""></select>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_select_2()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row" style="margin-left: 15px">
                                            <label class="col-sm-3 col-form-label">Ultima Fecha de Pago:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange2"
                                                        value="01-01-2024  31-01-2024" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_fechas_2()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 text-right">
                                        <button class="btn btn-primary" type="button" id="pago_lote_total"
                                            disabled>Pagar
                                            Lote</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-examaple-2">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Estado</th>
                                                <th>N° Nota de Venta</th>
                                                <th>Cliente</th>
                                                <th>Tipo</th>
                                                <th>Total Pagado</th>
                                                <th>Fecha de Pago</th>
                                                <th>Detalles</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nota_venta->where('estado_pago', 2) as $index => $n_v2)
                                                <tr>
                                                    <td>{{$n_v2->id}}</td>
                                                    <td>
                                                        <button id="cancelado" class="btn btn-primary"
                                                            disabled><strong>PAGADO</strong></button>
                                                    </td>
                                                    <td>
                                                        {{$n_v2->cod_nota_venta}}
                                                    </td>
                                                    <td>
                                                        {{$n_v2->cliente->nombre}}
                                                    </td>
                                                    <td>
                                                        @if ($n_v->formato_pago == 1)
                                                            Contado
                                                        @else
                                                            Credito
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{$n_v->moneda->simbolo}}  {{number_format(round($totales[$index],2),2)}}
                                                    </td>
                                                    <td>
                                                        {{Carbon\Carbon::parse($compr_pago->where('nota_venta_id', $n_v2->id)->pluck('fecha_registro')->first())->format('d-m-Y')}}
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('pagos.show_nota_venta', $n_v2->cod_nota_venta) }}">Detalles</a>
                                                    </td>
                                                </tr>                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-3" class="tab-pane">
                            <div class="panel-body">
                                <div class="row" style="margin-right: 5px">
                                    <div class="col-sm-4">
                                        <div class="form-group row" style="margin-left: 15px">
                                            {{-- <label class="col-sm-3 col-form-label">Cliente:</label> --}}
                                            <div class="col-sm-9">
                                                {{-- <div class="input-group">
                                                    <select class="select2_demo_client_2" name="cliente" id="cliente_2"
                                                        required=""></select>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_select_2()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">

                                    </div>
                                    <div class="col-sm-4 text-right">
                                        <button class="btn btn-primary" type="button" id="pago_lote_total"
                                            disabled>Pagar
                                            Lote</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-examaple-3">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th style="width: 150px">Cliente</th>
                                                <th>Documento</th>
                                                <th>Nota V. Creadas</th>
                                                <th>Nota V. Pagadas completas</th>
                                                <th>Monto Soles Pagados de Nota V. Completas</th>
                                                {{-- <th style="width: 63px !important">T.C Promedio</th> --}}
                                                <th>Monto Dolares Pagados de Nota V. Completas</th>
                                                <th>Detalles</th>
                                                {{-- <th>Cliente</th>
                                                <th>Total Pagado</th>
                                                <th>Ultima Fecha de Pago</th>
                                                <th>Detalles</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($clientes as $index3 => $clie)
                                            <div style="display: none">
                                                {{ $simbolo_mon_sol = 'S/.' }}
                                                {{ $simbolo_mon_dol = '$' }}
                                            </div>
                                                <tr>
                                                    <td>{{$clie->id}}</td>
                                                    <td>{{ $clie->nombre }}</td>
                                                    <td>{{ $clie->numero_documento }}</td>
                                                    <td>{{ $clie->cantidad_nota_v }}</td>
                                                    <td>
                                                        {{ $nota_venta->where('cliente_id', $clie->id)->where('estado_pago', 2)->count()}}
                                                    </td>
                                                    <td>
                                                        {{ $simbolo_mon_sol }} {{ $var_precio_tot[$index3]['tot'] }}
                                                    </td>
                                                    <td>
                                                        {{ $simbolo_mon_dol }} {{ $var_precio_tot[$index3]['tot_dol'] }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('pagos.show_cliente_nota_v', $clie->numero_documento) }}"
                                                            class="btn btn-secondary">Ver Detalles</a>
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
        </div>
    </div>

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
                    <form action="{{ route('pagos.store_n_venta') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tipo_comprobante" value="nota_venta">
                        <div class="display: none" id="ids_divs_n_venta">

                        </div>
                        <input type="hidden" value="{{ $fecha_hoy }}" name="" id="fecha_value_php">
                        <div class="cabeza_facturas">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h3 class="text-center">N° de Nota de V.</h3>
                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Cuotas por Nota de V.</h3>
                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Total x Cuotas</h3>
                                </div>
                            </div>
                            <div id="div_n_venta">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="" id="numero_fac">
                                    </div>
                                    <div class="col-sm-4 div_select">
                                        <select id="sel" class="select_2_multipl select2-selection--multiple"
                                            name="select_cuotas[]" multiple="multiple">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="" id="total_cuotas">
                                    </div>
                                </div>
                            </div>
                            <hr style="margin: 0px 5px">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <label class="col-form-label text-right">Total:</label>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group select-group" id="tot_simbolo">

                                    </div>
                                </div>
                            </div>
                        </div>
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


    


    <style>
        .pago_m {
            display: none;
        }

        .pago_m.m_pago_1 {
            display: flex;
        }
        #view_all {
            display: none;
        }

        .view_pagos {
            display: none;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .select2.select2-container.select2-container--default {
            width: calc(100% - 46px) !important;
        }

        .select2-selection.select2-selection--single {
            height: 100%;
        }

        .select2-container.select2-container--default.select2-container--open {
            z-index: 3200;
        }

        .div_select>.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        label.col-form-label {
            font-weight: bold;
        }

        .input-group.col-sm-4 {
            height: fit-content;
        }

        .input-group-text {
            width: 40px;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .col-sm-9>.select2.select2-container.select2-container--default {
            width: 100% !important;
        }
        i.fa.fa-arrow-right.icon.icon-arrow-right.glyphicon.glyphicon-arrow-right {
            color: black;
            display: none;
        }

        .next.available::after {
            content: ">>";
        }

        i.fa.fa-arrow-left.icon.icon-arrow-left.glyphicon.glyphicon-arrow-left {
            color: black;
            display: none;
        }

        .prev.available::after {
            content: "<<";
        }
        .form-control.tipo_check{
            width: 20px;
        }
    </style>
    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script> 
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>

    <link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
    <!-- Switchery -->
    <script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>
    
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    @include('cobranzas.nota_venta.adelanto')
    <script>
        $(document).ready(function() {
            $('input[name="daterange"]').daterangepicker({
                    "locale": {
                        "format": "DD-MM-YYYY",
                        "separator": " | ",
                        "applyLabel": "Guardar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },
                function(start, end, label) {
                    var startDate = start.format('DD-MM-YYYY');
                    var endDate = end.format('DD-MM-YYYY');
                    var dates = [];
                    var currentDate = new Date(start);

                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    console.log(dateRangeString);
                    table.column(5).search(dateRangeString, true, false).draw();
                }
            );
            $('input[name="daterange2"]').daterangepicker({
                    "locale": {
                        "format": "DD-MM-YYYY",
                        "separator": " | ",
                        "applyLabel": "Guardar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    }
                },
                function(start, end, label) {
                    var startDate = start.format('DD-MM-YYYY');
                    var endDate = end.format('DD-MM-YYYY');
                    var dates = [];
                    var currentDate = new Date(start);

                    while (currentDate <= end) {
                        var day = ('0' + currentDate.getDate()).slice(-2);
                        var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                        var year = currentDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;
                        dates.push(formattedDate);

                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    var dateRangeString = dates.join('|');
                    // console.log(dateRangeString);
                    table2.column(6).search(dateRangeString, true, false).draw();
                }
            );
        });
        function limpiar_fechas(){
            var table_lp = $('.dataTables-example').DataTable();
            table_lp.column(5).search('').draw();
        }
        function limpiar_fechas_2(){
            var table_lp_2 = $('.dataTables-examaple-2').DataTable();
            table_lp_2.column(6).search('').draw();
        }
        var tipo_coti = 3;
        $(".select2_demo_client").select2({
            placeholder: "Seleccionar Cliente",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    var tipo_coti = $('[name="tipo_coti"]:checked').val();
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_coti: tipo_coti
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.nombre,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };
                        })
                    };
                },
                cache: true
            }
        });
        $(".select2_demo_client_2").select2({
            placeholder: "Seleccionar Cliente",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    var tipo_coti = $('[name="tipo_coti"]:checked').val();
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_coti: tipo_coti
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.nombre,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    </script>
    <script>
        $(".select_2_multipl").select2();
        $('.select_2_estado').select2();

        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 20,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bAutoWidth: true, 
                buttons: []
            });
            $(document).on('change', '#select_estado', function(event) {
                var nombre = $("#select_estado option:selected").val();
                table.column(2).search(nombre).draw();
            });
            $(document).on('change', '#cliente', function(event) {
                var nombre_2 = $("#cliente option:selected").val();
                table.column(4).search(nombre_2).draw();
            });
        });

        function limpiar_select() {
            // console.log('a');
            var table_lp = $('.dataTables-example').DataTable();
            table_lp.column(4).search('').draw();
            $('#cliente').val(null).trigger('change');

        }

        $(document).ready(function() {
            table2 = $('.dataTables-examaple-2').DataTable({
                pageLength: 20,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $(document).on('change', '#cliente_2', function(event) {
                var nombre2 = $("#cliente_2 option:selected").val();
                table2.column(3).search(nombre2).draw();
            });
        });

        function limpiar_select_2() {
            // console.log('a');
            var table2_2l = $('.dataTables-examaple-2').DataTable();
            table2_2l.column(3).search('').draw();
            $('#cliente_2').val(null).trigger('change');

        }
        $(document).ready(function() {
            table3 = $('.dataTables-examaple-3').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });
        // PAGO INDIVIDUAL
        function pago_n_venta(n_factura) {
            // console.log('a');
            $('#div_n_venta').empty();
            $('#tot_simbolo').empty();
            $('#ids_divs_n_venta').empty();
            $('#todo_pago').modal('show');

            var only_id_fact = `
                <input type="hidden" name="id_n_venta[]" id="id_factura_` + n_factura + `" value="` + n_factura + `">
            `;
            $('#ids_divs_n_venta').append(only_id_fact);
            var ids_array = [n_factura];
            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax_n_venta') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'ids_facturas': ids_array
                },
                success: function(msg) {
                    // console.log(msg)
                    msg.forEach(function(row, index) {
                        // console.log(row.cuotas_array); 
                        // cod_factura
                        var data = `
                            <div class="row">
                                <label></label>
                                <div class="col-sm-4">
                                    <label class="form-control">` + row.n_venta_cod +
                            `</label>
                                    <input class="form-control" type="hidden" name="numero_n_venta[]" id="numero_fac_` +
                            index + `" value="` + row.n_venta_cod + `">
                                </div>
                                <div class="col-sm-4 div_select">
                                    <select placeholder="Seleccionar Cuotas" id="sel_` + index +
                            `" class="select_2_multipl_` + index +
                            ` select2-selection--multiple" name="cuotas_precio_` + row.n_venta_cod +
                            `[]" multiple="multiple" onchangue="select_2_(` + index + `)" required>
                                        ` + row.cuotas_array.map(function(bar) {
                                if (bar.estado == 0) {
                                    return '<option value="' + bar.id_cuota + '_' + bar.monto +
                                        '">' +
                                        'N°-' + bar.cuota_n + ': ' + bar.monto + '</option>'
                                }
                            }) + `
                                    </select>
                                </div>
                                <div class="input-group col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">` + row.n_venta_simbolo + `</span>
                                    </div>
                                    <label class="form-control" id="lbl_tot_` + index + `">0</label>
                                    <input class="form-control" type="hidden" name="tot_cuotas[]" id="total_cuotas_` +
                            index + `">
                                </div>
                            </div>
                        `;
                        $('#div_n_venta').append(data);

                        var data_2 =
                            `<hr><div class="input-group-prepend"><label class="form-control disabled" id="simbolor_label" style="margin: 0px">` +
                            row.n_venta_simbolo +
                            `</label></div><label class='form-control disabled' id='tota_totas'></label>`;
                        $('#tot_simbolo').append(data_2);

                        $(`.select_2_multipl_` + index + ``).select2({
                            placeholder: "Seleccionar Cuotas"
                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:select', function(e) {
                            var data = e.params.data;
                            // console.log(data)
                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            console.log(data_cuota);

                            var math_total = Math.round((parseFloat(data_cuota) + parseFloat(
                                ant)) * 100) / 100;
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            // TOTAL DE TOTALES
                            var tota_tot = $('#tota_totas').html();
                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            //TODO O NADA
                            var igual = $("#simbolor_label").html();

                            if (igual == row.n_venta_simbolo) {
                                var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(
                                    data_cuota)) * 100) / 100;
                            } else {
                                if (row.factura_moneda == "soles" && igual ==
                                    '$') { //DE DOLAR A SOL
                                    var new_val = parseFloat(data_cuota) / tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('a');
                                } else { // DE SOL A DOLAR
                                    var new_val = parseFloat(data_cuota) * tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('b');
                                }
                            }
                            // console.log(tot_math);
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);

                            console.log(data.id);
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');

                            var cuota_array = `
                                <input class="input_check" type="hidden" name="id_cuota[]" value="` + ids_arry[0] +
                                `" id='cuota_` + ids_arry[0] + `'>
                            `;
                            $('#ids_divs_n_venta').append(cuota_array);

                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:unselect', function(e) {
                            var data = e.params.data;
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');
                            console.log(ids_arry);
                            $(`#cuota_` + ids_arry[0] + ``).remove();

                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            var math_total = Math.round((parseFloat(ant) - parseFloat(
                                data_cuota)) * 100) / 100;
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            var tota_tot = $('#tota_totas').html();

                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            var tot_math = Math.round((parseFloat(tota_tot) - parseFloat(
                                data_cuota)) * 100) / 100;
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);
                        });
                    });

                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
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
            // console.log(fecha);
            $('.fecha_hoy').val(fecha);
        }
        $('#efectivo_pago').on('keyup', function() {
            var pago = this.value;
            var total = $('#tota_totas').text();
            var vuelto = parseFloat(this.value) - parseFloat(total);
            $('#efectivo_vuelto').val(Math.round(vuelto * 100) / 100);
        })

        // PAGO MULTIPLE

        function check_lote(num) {
            //separado por nombre de moneda
            var elemento = document.getElementsByClassName(`check_lost_` + num);
            var list_clas = elemento[0].className;
            let array_class = list_clas.split(' ');

            var id_cuot = elemento[0].getAttribute('id');
            let id_one = id_cuot.split('_');
            console.log('1')
            if (elemento[0].checked) {
                console.log(elemento[0])
                var only_id_fact = `
                    <input type="hidden" name="id_n_venta[]" id="id_factura_` + id_one[1] + `" value="` + id_one[1] +
                    `">`;
                $('#ids_divs_n_venta').append(only_id_fact);
            } else {
                $(`#id_factura_` + id_one[1] + ``).remove();
                console.log('2')
            }
            console.log('3')
            var count_check = document.querySelectorAll('.check_only');
            let checkboxesDesactivados = 0;
            // Recorrer los checkboxes y contar los desactivados
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
                var class_check = checkbox.className;
                let class_global = class_check.split(' ');
                if (class_global[3] != array_class[3]) {
                    checkbox.disabled = true;
                }

            });
            if (checkboxesDesactivados > 0) {
                $('#pago_lote_total').attr('disabled', false);
            } else {
                count_check.forEach(function(checkbox) {
                    checkbox.disabled = false;
                });
                $('#pago_lote_total').attr('disabled', true);
            }
        }
        $('#pago_lote_total').on('click', function() {

            $('#div_n_venta').empty();
            $('#tot_simbolo').empty();

            var count_check = document.querySelectorAll('.check_only');

            var arr = new Array();
            var arr = [];
            count_check.forEach(function(checkbox) {

                if (checkbox.checked) {

                    var id_cuot = checkbox.id;
                    let id_one = id_cuot.split('_');

                    arr.push(id_one[1]);
                }

            });
            pago_lote_total(arr);

        });

        function pago_lote_total(n_factura) {
            console.log(n_factura);
            // console.log(n_factura)
            $('#todo_pago').modal('show');
            // console.log('a');
            $('#div_n_venta').empty();
            $('#tot_simbolo').empty();
            // $('#ids_divs_n_venta').empty();
            $('#todo_pago').modal('show');

            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax_n_venta') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'ids_facturas': n_factura
                },
                success: function(msg) {
                    // console.log(msg[0])
                    msg.forEach(function(row, index) {
                        // console.log(row.cuotas_array); 
                        // cod_factura
                        var data = `
                            <div class="row">
                                <label></label>
                                <div class="col-sm-4">
                                    <label class="form-control">` + row.n_venta_cod +
                            `</label>
                                    <input class="form-control" type="hidden" name="numero_n_venta[]" id="numero_fac_` +
                            index + `" value="` + row.n_venta_cod + `">
                                </div>
                                <div class="col-sm-4 div_select">
                                    <select placeholder="Seleccionar Cuotas" id="sel_` + index +
                            `" class="select_2_multipl_` + index +
                            ` select2-selection--multiple" name="cuotas_precio_` + row.n_venta_cod +
                            `[]" multiple="multiple" onchangue="select_2_(` + index + `)" required>
                                        ` + row.cuotas_array.map(function(bar) {
                                if (bar.estado == 0) {
                                    return '<option value="' + bar.id_cuota + '_' + bar.monto +
                                        '">' +
                                        'N°-' + bar.cuota_n + ': ' + bar.monto + '</option>'
                                }
                            }) + `
                                    </select>
                                </div>
                                <div class="input-group col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">` + row.n_venta_simbolo + `</span>
                                    </div>
                                    <label class="form-control" id="lbl_tot_` + index + `">0</label>
                                    <input class="form-control" type="hidden" name="tot_cuotas[]" id="total_cuotas_` +
                            index + `">
                                </div>
                            </div>
                        `;
                        $('#div_n_venta').append(data);

                        $(`.select_2_multipl_` + index + ``).select2({
                            placeholder: "Seleccionar Cuotas"
                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:select', function(e) {
                            var data = e.params.data;
                            // console.log(data)
                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            console.log(data_cuota);

                            var math_total = Math.round((parseFloat(data_cuota) + parseFloat(
                                ant)) * 100) / 100;
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            // TOTAL DE TOTALES
                            var tota_tot = $('#tota_totas').html();
                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            //TODO O NADA
                            var igual = $("#simbolor_label").html();

                            if (igual == row.n_venta_simbolo) {
                                var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(
                                    data_cuota)) * 100) / 100;
                            } else {
                                if (row.factura_moneda == "soles" && igual ==
                                    '$') { //DE DOLAR A SOL
                                    var new_val = parseFloat(data_cuota) / tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('a');
                                } else { // DE SOL A DOLAR
                                    var new_val = parseFloat(data_cuota) * tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('b');
                                }
                            }
                            // console.log(tot_math);
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);

                            console.log(data.id);
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');

                            var cuota_array = `
                                <input class="input_check" type="hidden" name="id_cuota[]" value="` + ids_arry[0] +
                                `" id='cuota_` + ids_arry[0] + `'>
                            `;
                            $('#ids_divs_n_venta').append(cuota_array);

                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:unselect', function(e) {
                            var data = e.params.data;
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');
                            console.log(ids_arry);
                            $(`#cuota_` + ids_arry[0] + ``).remove();

                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            var math_total = Math.round((parseFloat(ant) - parseFloat(
                                data_cuota)) * 100) / 100;
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            var tota_tot = $('#tota_totas').html();

                            // console.log(tota_tot);
                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            var tot_math = Math.round((parseFloat(tota_tot) - parseFloat(
                                data_cuota)) * 100) / 100;
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);
                        });
                    });
                    var data_2 =
                        `<hr><div class="input-group-prepend"><label class="form-control disabled" id="simbolor_label" style="margin: 0px">` +
                        msg[0].n_venta_simbolo +
                        `</label></div><label class='form-control disabled' id='tota_totas'></label>`;
                    $('#tot_simbolo').append(data_2);
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }
        $('#contad_check').on('click', function() {
            var count_check = document.querySelectorAll('.tipo_check');
            let checkboxesDesactivados = 0;
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
            });
            if (checkboxesDesactivados == 0 || checkboxesDesactivados == 2) {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(6).search('credito|contado', true, false).draw();
            } else {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(6).search('contado', true, false).draw();
            }


        });
        $('#credit_check').on('click', function() {
            var count_check = document.querySelectorAll('.tipo_check');
            let checkboxesDesactivados = 0;

            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
            });
            if (checkboxesDesactivados == 0 || checkboxesDesactivados == 2) {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(6).search('credito|contado', true, false).draw();
            } else {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(6).search('credito', true, false).draw();
            }
        });
    </script>
@endsection
