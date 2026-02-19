<div class="row">
    <div class="col-lg-12" style="margin-top: -5px">
        <div class="ibox-content p-xl" style="margin-bottom: 20px;padding-bottom: 50px;">
            <form action="{{ route('boleta.update', $boleta->id) }}" enctype="multipart/form-data" id="form_update"
                method="post">
                @csrf
                <div class="row" style="align-items: center;justify-content: center">
                    @include('layout_cabecera_ventas')
                    <div class="col=sm-4">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">R.U.C : {{ $empresa->ruc }}</h3>
                                <h2>BOLETA ELECTRÓNICA</h2>
                                <h5> {{ $boleta->codigo_boleta }}</h5>
                            </center>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row form-label word-style">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="hidden" value="{{ $boleta->cliente_id }}" id="cliente_id_input">
                                    <select class="select2_demo_client" name="cliente_id">
                                        <option selected value="{{ $boleta->cliente->id }}">
                                            {{ $boleta->cliente->nombre }} -
                                            {{ $boleta->cliente->numero_documento }}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente"><i
                                                class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4"><strong>Orden C.:</strong></label>
                                    <div class="col-md-8">
                                        {{-- <input type="text" class="form-control" name="orden_compra" required="" autocomplete="off" value="0"> --}}
                                        <input type="text" class="form-control" style="margin-top: 0px !important"
                                            name="ord_compra" value="{{ $boleta->orden_compra }}" id="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4"><strong>G. Remisión: </strong>
                                        <small class="tooltip-demo"><i class="fa fa-info-circle" data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="Ej: TE01-999  *  Mayusculas y separar solo con espacios en blanco"></i></small></label>
                                    <div class="col-md-8">
                                        <input list="guia_list" class="form-control" name="guia_r"
                                            id="guia_remi_input">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>F. Emisión:</strong></label>
                            <div class="col-md-10 pago_first_column">
                                <input type="text" id="" name="" class="form-control"
                                    value="{{ $boleta->fecha_emision }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Comisionista:</strong></label>
                            <div class="col-md-10">
                                @if ($boleta->comisionista == 0)
                                    <input type="text" class="form-control" readonly value="Sin Comisión - 0 %">
                                    <input type="hidden" name="" id="comisionista" value="0">
                                @else
                                    <input type="text" class="form-control" readonly
                                        value="{{ $boleta->select_comisionista->cod_vendedor }} - {{ $boleta->select_comisionista->personal->personal_l->nombres }} - {{ $boleta->select_comisionista->comision }} %">
                                    <input type="hidden" name="" id="comisionista"
                                        value="{{ $boleta->select_comisionista->comision }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- 2da Columna --}}
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>T. Operación </strong></label>
                            <div class="col-md-10">
                                <select class="select2_tipo_op" name="tipo_operacion">
                                    @foreach ($tipo_operacion as $t_op)
                                        <option
                                            value="{{ $t_op->id }}"@if ($boleta->tipo_operacion_id == $t_op->id) selected @endif>
                                            {{ $t_op->codigo }} - {{ $t_op->informacion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row" style="justify-content: start !important">
                                    <label class="col-form-label col-md-4"><strong>Forma Pago:</strong></label>
                                    <div class="col-md-6 pago_first_column">
                                        <select class="form-control" name="forma_pago" id="forma_pago"
                                            onchange="seleccionado_fp()" required>
                                            @foreach ($forma_pagos as $forma_pago_item)
                                                <option value="{{ $forma_pago_item->id }}"
                                                    {{ $boleta->forma_pago_id == $forma_pago_item->id ? 'selected' : '' }}>
                                                    {{ $forma_pago_item->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="credito_pago"
                                        @if ($boleta->forma_pago_id == 1) style="display: none" @endif>
                                        {{-- Si es contado, se oculta --}}
                                        <button type="button" class='cuota_modal btn btn-info' id="cuota_modal"
                                            data-toggle="modal" data-target="#cuotas_modal"><i
                                                class="fa fa-dollar"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4"><strong>Moneda:</strong></label>
                                    <div class="col-md-8">
                                        <select name="" id="" class="form-control"
                                            onchange="changeMoney()">
                                            @foreach ($monedas_get as $moneda_item)
                                                {{-- @if ($moneda_item->principal != 1) --}}
                                                <option value="{{ $moneda_item->id }}"
                                                    {{ $boleta->moneda_id == $moneda_item->id ? 'selected' : '' }}>
                                                    {{ ucwords($moneda_item->nombre) }}</option>
                                                {{-- @endif --}}
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="moneda" id="moneda" class="form-control "
                                            value="{{ ucwords($boleta->moneda->nombre) }}" readonly="readonly">
                                        <input type="hidden" id="moneda_id" class="form-control" name="moneda_id"
                                            value="{{ $boleta->moneda_id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>F. Venc.:</strong></label>
                            <div class="col-md-10">
                                @if ($boleta->forma_pago_id == 1)
                                    {{-- Si es contado --}}
                                    <input type="date" class="form-control" id="fecha_vencimiento"
                                        name="fecha_vencimiento" value="{{ $boleta->fecha_vencimiento_edit }}">
                                @else
                                    <input type="date" readonly class="form-control" id="fecha_vencimiento"
                                        name="fecha_vencimiento" value="{{ $boleta->fecha_vencimiento_edit }}">
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Vendedor:</strong></label>
                            <div class="col-md-10">
                                {{-- <span class="form-control" id="nombre_vendedor">{{ auth()->user()->name }}</span> --}}
                                <input type="text" name="" id="" class="form-control"
                                    id="nombre_vendedor" readonly value="{{ $boleta->user->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-form-label col-md-1"><strong>Observación:</strong></label>
                            <div class="col-md-11">
                                <textarea class="form-control" name="observacion" id="observacion" autocomplete="off" placeholder="Observación"
                                    rows="1">{{ $boleta->observacion }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <input type="hidden" name="comparador_edicion" id="comparador_edicion" value="0">
                <input type="hidden" name="" id="count_articles"
                    value="{{ count($boleta->registros) - 1 }}">
                <div class="table-responsive">
                    <table class="table tables">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;width: 50px;">
                                    <div>
                                        <button type="button" class='addmore btn btn-sm btn-info'
                                            style="display: none"><i class="fa fa-plus-square"
                                                aria-hidden="true"></i></button>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                        data-target="#add_product_data">
                                        <i class="fa fa-plus-square"></i>
                                    </button>
                                </th>
                                <th>Artículo</th>
                                <th>Stock</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Dcto.</th>
                                <th>P. U. Dcto.</th>
                                <th>P. U. Com.</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($boleta->registros as $i_edit => $registros)
                                <tr>
                                    <td class="td_selected">
                                        <button type="button" class='delete borrar e btn btn-sm btn-danger'> <i
                                                class="fa fa-trash" aria-hidden="true"></i> </button>
                                    </td>
                                    <td class="td_selected">
                                        <select class="monto{{ $i_edit }} select2_demo_3 select_change"
                                            required="" id="articulo" onchange="ajax({{ $i_edit }})"
                                            autocomplete="off">
                                            @if ($registros->producto?->id)
                                                <option
                                                    value="{{ $registros->producto->id }} | {{ $registros->producto->codigo_producto }} | {{ $registros->producto->codigo_original }} | {{ $registros->producto->nombre }}">
                                                    {{ $registros->producto->id }} |
                                                    {{ $registros->producto->codigo_producto }} |
                                                    {{ $registros->producto->codigo_original }} |
                                                    {{ $registros->producto->nombre }}</option>
                                                @php
                                                    $stock_actual = $registros->producto->stockAlmacenProducto(
                                                        $boleta->almacen_id,
                                                    )->stock;
                                                    $input_prod =
                                                        $registros->producto->id .
                                                        ' | ' .
                                                        $registros->producto->codigo_producto .
                                                        ' | ' .
                                                        $registros->producto->codigo_original .
                                                        ' | ' .
                                                        $registros->producto->nombre;
                                                    $afect = explode(
                                                        ' - ',
                                                        $registros->producto->tipo_afec_i_producto->informacion,
                                                    )[0];
                                                @endphp
                                            @else
                                                <option
                                                    value="{{ $registros->servicio->id }} | {{ $registros->servicio->codigo_servicio }} | {{ $registros->servicio->codigo_original }} | {{ $registros->servicio->nombre }}">
                                                    {{ $registros->servicio->id }} |
                                                    {{ $registros->servicio->codigo_servicio }} |
                                                    {{ $registros->servicio->codigo_original }} |
                                                    {{ $registros->servicio->nombre }}</option>
                                                @php
                                                    $stock_actual = 1000;
                                                    $input_prod =
                                                        $registros->servicio->id .
                                                        ' | ' .
                                                        $registros->servicio->codigo_servicio .
                                                        ' | ' .
                                                        $registros->servicio->codigo_original .
                                                        ' | ' .
                                                        $registros->servicio->nombre;
                                                    $afect = explode(
                                                        ' - ',
                                                        $registros->servicio->tipo_afec_i_serv->informacion,
                                                    )[0];
                                                @endphp
                                            @endif
                                        </select>
                                        <textarea type='text' name='descripcion_item[]' placeholder="Descripcion de Item" class="form-control"
                                            autocomplete="off" style="margin-top: 5px;">{{ $registros->descripcion_item }}</textarea>
                                        <textarea id='numero_serie0' name='numero_serie[]' class="form-control" placeholder="N° de Serie"
                                            autocomplete="off" style="margin-top: 5px">{{ $registros->numero_serie }}</textarea>
                                        <input type='text' id='tipo_afec{{ $i_edit }}' name='tipo_afec[]'
                                            readonly="readonly"
                                            class="monto{{ $i_edit }} form-control td-width"
                                            onkeyup="multi({{ $i_edit }})" hidden="" required
                                            autocomplete="off" value="{{ $afect }}" />
                                        <input type="hidden" class="celda" name="articulo[]"
                                            id="input_prod{{ $i_edit }}" value="{{ $input_prod }}">

                                    </td>
                                    <td>
                                        <input type='text' id='stock{{ $i_edit }}' readonly="readonly"
                                            name='stock[]' class="form-control td-width" required autocomplete="off"
                                            value="{{ $stock_actual }}" />
                                    </td>
                                    <td>
                                        <input type='number' id='cantidad{{ $i_edit }}' name='cantidad[]'
                                            max="" min="1" value="{{ $registros->cantidad }}"
                                            class="monto{{ $i_edit }} form-control td-width"
                                            onkeyup="multi({{ $i_edit }})" required autocomplete="off" />
                                    </td>
                                    <td>
                                        <input type='number' id='precio{{ $i_edit }}' name='precio[]'
                                            readonly="readonly" value="{{ $registros->precio }}"
                                            class="monto{{ $i_edit }} form-control td-width"
                                            onkeyup="multi({{ $i_edit }})" required autocomplete="off" />
                                    </td>
                                    <td>
                                        <div style="position: relative; ">
                                            <input class="text_des " type='text'
                                                value="{{ $registros->descuento }}"
                                                id='descuento{{ $i_edit }}' name='descuento[]'
                                                readonly="readonly" required autocomplete="off" />
                                        </div>
                                        <div class="div_check">
                                            @if ($registros->descuento == 0)
                                                {{-- Si no tiene descuento --}}
                                                <input class="check" type='checkbox' id='check{{ $i_edit }}'
                                                    name='check[]' onclick="multi({{ $i_edit }})"
                                                    style="" autocomplete="off" />
                                                <input type='hidden' id='check_descuento{{ $i_edit }}'
                                                    name='check_descuento[]' class="form-control" required
                                                    value="0">
                                            @else
                                                <input class="check" type='checkbox' id='check{{ $i_edit }}'
                                                    name='check[]' onclick="multi({{ $i_edit }})"
                                                    style="" autocomplete="off" />
                                                <input type='hidden' id='check_descuento{{ $i_edit }}'
                                                    name='check_descuento[]' class="form-control" required
                                                    value="{{ $registros->descuento }}">
                                            @endif
                                        </div>
                                        <input type='hidden' id='promedio_original{{ $i_edit }}'
                                            value="{{ $registros->promedio_original }}" name='promedio_original[]'
                                            class="form-control td-width" required>
                                    </td>
                                    <td>
                                        <input type='text' id='precio_unitario_descuento{{ $i_edit }}'
                                            name='precio_unitario_descuento[]' readonly="readonly"
                                            class="precio_unitario_descuento{{ $i_edit }} form-control td-width"
                                            required autocomplete="off"
                                            value="{{ $registros->precio_unitario_desc }}" />
                                    </td>
                                    {{--                                        <td> --}}
                                    <input type='hidden' name="comision" id='comision{{ $i_edit }}'
                                        readonly="readonly" class="form-control td-width comision_input" required
                                        autocomplete="off" onchange="multi({{ $i_edit }})"
                                        @if ($boleta->comisionista == 0 || $boleta->comisionista == null) value="0" @else value="{{ $boleta->select_comisionista->comision }}" @endif />
                                    {{--                                        </td> --}}
                                    <td>
                                        <input type='text' id='precio_unitario_comision{{ $i_edit }}'
                                            readonly="readonly" class="form-control td-width" required
                                            autocomplete="off" value="{{ $registros->precio_unitario_comi }}" />
                                    </td>
                                    <td>
                                        <input type='text' id='total{{ $i_edit }}' name='total'
                                            readonly="readonly" class="total form-control td-width" required
                                            autocomplete="off"
                                            value="{{ $registros->precio_unitario_comi * $registros->cantidad }}" />
                                        <input type='text' id='afectacion{{ $i_edit }}' name='afectacion'
                                            readonly="readonly" class="afectacion form-control td-width"
                                            hidden="" required autocomplete="off"
                                            value="{{ $registros->precio_unitario_comi * $registros->cantidad }}" />

                                    </td>
                                    {{-- <td>
                                        <input type='text' id='precio_unitario_igv{{ $i_edit }}'
                                            name='precio_unitario_igv[]' readonly="readonly"
                                            class="form-control td-width" required autocomplete="off" />
                                    </td> --}}
                                    <span id="spTotal"></span>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr style="background-color: #f5f5f500;">
                                <td colspan="7" class="text-right"><strong>Subtotal:</strong></td>
                                <td colspan="2">
                                    <input id='sub_total' type="text" name="sub_total_sin_igv" readonly
                                        class="form-control" required />
                                    <input id='subtotal_gravado' type="text" name="subtotal_gravado" readonly
                                        class="form-control" required hidden="" />
                                </td>
                            </tr>
                            <tr style="background-color: #f5f5f500;">
                                <td colspan="7" class="text-right"><strong>IGV:</strong></td>
                                <td colspan="2">
                                    <input id='igv' type="text" disabled="disabled" class="form-control"
                                        required />
                                </td>
                            </tr>
                            <tr align="center">
                                <td colspan="7" class="text-right"><strong>Total:</strong></td>
                                <td colspan="2">
                                    <input id='total_final' type="text" name="total_comi" readonly
                                        class="form-control td-width" required />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end mt-4">
                                <button data-style="zoom-out" id="boton" name="boton"
                                    class="guardar button-lada btn btn-primary btn-outline"
                                    type="button">Guardar</button>
                                <button class="btn btn-primary float-right button-lada" style="margin-left: 10px;"
                                    type="button" id="finalizar">Guardar y Finalizar</button>
                                <button type="submit" id="button_submit" hidden name="button_submit"
                                    value="0"></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Modal dentro del Form para que se envien los datos --}}
                @include('transaccion.venta.boleta._shared.modal_cuota_edit')
            </form>
        </div>
    </div>
    @include('transaccion.venta.boleta._shared.modal_add_product')
</div>
