<div class="">
    <div class="row" style="align-items: center; justify-content: center">
        @include('layout_cabecera_ventas')
        <div class="col-sm-4 ">
            <div class="form-control ruc" style="height: 125px">
                <center>
                    <h3 style="padding-top:10px ">R.U.C : {{ $empresa->ruc }}</h3>
                    <h2>FACTURA ELECTRÓNICA</h2>
                    <h5> {{ $facturacion->codigo_fac }}</h5>
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
                        <input type="hidden" value="{{ $facturacion->cliente_id }}" id="cliente_id_input">
                        <select class="select2_demo_client" name="cliente_id">
                            <option selected value="{{ $facturacion->cliente->id }}">
                                {{ $facturacion->cliente->nombre }} -
                                {{ $facturacion->cliente->numero_documento }}</option>
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
                                name="ord_compra" value="{{ $facturacion->orden_compra }}" id="">
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
                            <input list="guia_list" class="form-control" name="guia_r" id="guia_remi_input"
                                @if ($facturacion->guia_remision == 0) value="0" @endif autocomplete="off">
                            <datalist id="guia_list">
                                @foreach ($remisiones as $remi_select)
                                    <option value="{{ $remi_select->cod_guia }}"></option>
                                @endforeach
                            </datalist>
                            <span id="lista_gr">
                                @if ($facturacion->guia_remision != 0)
                                    @php
                                        $array = explode(' ', $facturacion->guia_remision);
                                    @endphp
                                    @foreach ($array as $remi)
                                        <a class="item_guia" onclick="remove_item(this)">{{ $remi }}</a>
                                    @endforeach
                                @endif
                            </span>
                            <input type="hidden" name="guia_r" id="guia_save_inp"
                                value="{{ $facturacion->guia_remision }} ">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-2"><strong>Comisionista:</strong></label>
                <div class="col-md-10">
                    @if ($facturacion->comisionista == 0)
                        </span><input type="text" class="form-control" readonly value="Sin Comisión - 0 %">
                        <input type="hidden" name="" id="comisionista" value="0">
                    @else
                        <input type="text" class="form-control" readonly
                            value="{{ $facturacion->select_comisionista->cod_vendedor }} - {{ $facturacion->select_comisionista->personal->personal_l->nombres }} - {{ $facturacion->select_comisionista->comision }} %">
                        <input type="hidden" name="" id="comisionista" value="{{ $facturacion->select_comisionista->comision }}">
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-2"><strong>Vendedor:</strong></label>
                <div class="col-md-10">
                    {{-- <span class="form-control" id="nombre_vendedor">{{ auth()->user()->name }}</span> --}}
                    <input type="text" name="" id="" class="form-control" id="nombre_vendedor"
                        readonly value="{{ $facturacion->user->name }}">
                </div>
            </div>
        </div>

        {{-- 2DA COLUMNA --}}
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-form-label col-md-2"><strong>T. Operación </strong></label>
                <div class="col-md-10">
                    <select class="select2_tipo_op" name="tipo_operacion">
                        @foreach ($tipo_operacion as $t_op)
                            <option id="{{ $t_op->id }}"@if ($facturacion->tipo_operacion_id == $t_op->id)  @endif>
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
                            <select class="form-control" name="forma_pago" id="forma_pago" onchange="seleccionado_fp()"
                                required>
                                @foreach ($forma_pagos as $forma_pago_item)
                                    <option value="{{ $forma_pago_item->id }}"
                                        {{ $facturacion->forma_pago_id == $forma_pago_item->id ? 'selected' : '' }}>
                                        {{ $forma_pago_item->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2" id="credito_pago"
                            @if ($facturacion->forma_pago_id == 1) style="display: none" @endif> {{-- Si es contado, se oculta --}}
                            <button type="button" class='cuota_modal btn btn-info' id="cuota_modal" data-toggle="modal"
                                data-target="#cuotas_modal"><i class="fa fa-dollar"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4"><strong>Moneda:</strong></label>
                        <div class="col-md-8">
                            <select name="" id="" class="form-control" onchange="changeMoney()">
                                <option value="nacional" {{ $moneda->tipo == 'nacional' ? 'selected' : '' }}>Soles
                                </option>
                                <option value="extranjera" {{ $moneda->tipo == 'extranjera' ? 'selected' : '' }}>
                                    Dólares</option>
                            </select>
                            <input type="hidden" name="moneda" id="moneda" class="form-control "
                                value="{{ ucwords($moneda->nombre) }}" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4"><strong>F. Emisión:</strong></label>
                        <div class="col-md-8 pago_first_column">
                            <input type="text" id="" name="" class="form-control"
                                value="{{ $facturacion->fecha_emision }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4"><strong>F. Venc.:</strong></label>
                        <div class="col-md-8">
                            @if ($facturacion->forma_pago_id == 1)
                                {{-- Si es contado --}}
                                <input type="date" class="form-control" id="fecha_vencimiento"
                                    name="fecha_vencimiento" value="{{ $facturacion->fecha_vencimiento_edit }}">
                            @else
                                <input type="date" readonly class="form-control" id="fecha_vencimiento"
                                    name="fecha_vencimiento" value="{{ $facturacion->fecha_vencimiento_edit }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row" style="justify-content: start !important">
                <label class="col-form-label col-md-2"> <strong>Detracción:</strong> </label>
                @if ($detraccion == 'not')
                    {{-- Si NO tiene detracción --}}
                    <div class="col-md-6">
                        <input type="text" readonly class="form-control" value="Desactivado" name=""
                            id="">
                    </div>
                @else
                    <div class="col-md-6">
                        <input type="text" readonly class="form-control" value="Activado" name=""
                            id="">
                    </div>
                    <div class="col-md-2">
                        <a href="" id="button_detracc" data-toggle="modal" data-target="#modal_detraccion"
                            style="margin: auto">
                            <i class="fa fa-question-circle"
                                style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999">\
                            </i>
                        </a>
                    </div>
                    {{-- Modal para la detraccion no editable --}}
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group row">
                <label class="col-form-label col-md-1"><strong>Observación:</strong></label>
                <div class="col-md-11">
                    <textarea class="form-control" name="observacion" id="observacion" autocomplete="off" placeholder="Observación"
                        rows="1">{{ $facturacion->observacion }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <input type="hidden" name="" id="count_articles" value="{{ count($facturacion->registros) - 1 }}">
    <div class="table-responsive">
        <table class="table tables">
            <thead>
                <tr>
                    <th style="vertical-align: middle;width: 50px;">
                        <div>
                            <button type="button" class='addmore btn btn-sm btn-info' style="display: block"><i
                                    class="fa fa-plus-square" aria-hidden="true"></i></button>
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
                @foreach ($facturacion->registros as $i_edit => $registros)
                    <tr>
                        <td>
                            {{-- <input type="hidden" name="elem_delete[]" value="{{$cotizacion_registros->id}}">
                            <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="existente"> --}}
                            <button type="button" class='delete borrar e btn btn-sm btn-danger'> <i
                                    class="fa fa-trash" aria-hidden="true"></i> </button>
                        </td>
                        <td class="td_selected">
                            <select class="monto{{$i_edit}} select2_demo_3 select_change" required="" id="articulo"
                                onchange="ajax({{$i_edit}})" autocomplete="off">
                                @if ($registros->producto->id)
                                    <option
                                        value="{{ $registros->producto->id }} | {{ $registros->producto->codigo_producto }} | {{ $registros->producto->codigo_original }} | {{ $registros->producto->nombre }}">
                                        {{ $registros->producto->id }} | {{ $registros->producto->codigo_producto }} |
                                        {{ $registros->producto->codigo_original }} |
                                        {{ $registros->producto->nombre }}</option>
                                    @php
                                        $stock_actual = $registros->producto->stockAlmacenProducto(
                                            $facturacion->almacen_id,
                                        )->stock;
                                    @endphp
                                @else
                                    <option
                                        value="{{ $registros->servicio->id }} | {{ $registros->servicio->codigo_servicio }} | {{ $registros->servicio->codigo_original }} | {{ $registros->servicio->nombre }}">
                                        {{ $registros->servicio->id }} | {{ $registros->servicio->codigo_servicio }} |
                                        {{ $registros->servicio->codigo_original }} |
                                        {{ $registros->servicio->nombre }}</option>
                                    @php
                                        $stock_actual = 1000;
                                    @endphp
                                @endif
                            </select>
                            <textarea type='text' id='descripcion{{$i_edit}}' name='descripcion_item[]' placeholder="Descripción de Item"
                                class="form-control" autocomplete="off" style="margin-top: 5px;">{{ $registros->descripcion_item }}</textarea>
                            <textarea type='text' id='numero_serie{{$i_edit}}' name='numero_serie[]' class="form-control" autocomplete="off"
                                style="margin-top: 5px;" placeholder="N° de Serie">{{ $registros->numero_serie }}</textarea>
                            <input style="width: 76px" hidden="" type='text' id='tipo_afec{{$i_edit}}'
                                name='tipo_afec[]' readonly="readonly" class="monto{{$i_edit}} form-control"
                                onkeyup="multi({{$i_edit}})" required autocomplete="off" />
                            {{-- <input hidden="hidden" class="celda" name="articulo[]"
                                                    id="input_prod1"> --}}
                            <input hidden="hidden" class="celda input-articulo" name="articulo[]">
                        </td>
                        <td>
                            <input style="min-width: 80px;margin: 0px" type='text' id='stock{{$i_edit}}'
                                readonly="readonly" name='stock[]' class="form-control" required autocomplete="off"
                                value="{{ $stock_actual }}" />
                        </td>
                        <td>
                            <input style="min-width: 80px" type='number' value="{{ $registros->cantidad }}"
                                id='cantidad{{$i_edit}}' name='cantidad[]' max="" min="1"
                                class="monto{{$i_edit}} form-control" onkeyup="multi({{$i_edit}})" required autocomplete="off" />
                        </td>
                        <td>
                            <input style="min-width: 85px" type='text' id='precio{{$i_edit}}' name='precio[]'
                                readonly="readonly" class="monto{{$i_edit}} form-control" onkeyup="multi({{$i_edit}})" required
                                autocomplete="off" value="{{ $registros->precio }}" />
                        </td>
                        <td>
                            <div style="position: relative;">
                                <input class="text_des" type='text' id='descuento{{$i_edit}}' name='descuento[]'
                                    readonly="readonly" class="" required autocomplete="off"
                                    value="{{ $registros->descuento }}" />
                            </div>
                            <div class="div_check">
                                @if ($registros->descuento == 0)
                                    {{-- Si no tiene descuento --}}
                                    <input class="check" type='checkbox' id='check{{$i_edit}}' name='check[]'
                                        onclick="multi({{$i_edit}})" style="" autocomplete="off" />
                                    <input type='hidden' id='check_descuento{{$i_edit}}' name='check_descuento[]'
                                        class="form-control" required>
                                    <input type='hidden' id='promedio_original{{$i_edit}}' name='promedio_original[]'
                                        class="form-control" required>
                                @else
                                    <input class="check" type='checkbox' id='check{{$i_edit}}' name='check[]'
                                        onclick="multi({{$i_edit}})" style="" autocomplete="off" />
                                    <input type='hidden' id='check_descuento{{$i_edit}}' name='check_descuento[]'
                                        class="form-control" required>
                                    <input type='hidden' id='promedio_original{{$i_edit}}' name='promedio_original[]'
                                        class="form-control" required>
                                @endif
                            </div>
                            <input type='hidden' id='check_descuento{{$i_edit}}' name='check_descuento[]'
                                class="form-control" required value="{{ $registros->descuentos }}">
                            <input type='hidden' id='promedio_original{{$i_edit}}' name='promedio_original[]'
                                class="form-control" required value="{{ $registros->promedio_original }}">
                        </td>
                        <td>
                            <input style="min-width: 85px" type='text' id='precio_unitario_descuento{{$i_edit}}'
                                name='precio_unitario_descuento[]' readonly="readonly"
                                class="precio_unitario_descuento{{$i_edit}} form-control" required autocomplete="off"
                                value="{{ $registros->precio_unitario_desc }}" />
                        </td>
                        <input type='hidden' name="comision[]" id='comision{{$i_edit}}' readonly="readonly"
                            class="form-control comision_input" required autocomplete="off" onchange="multi({{$i_edit}})"
                            @if ($facturacion->comisionista == 0) value="0" @else value="{{ $facturacion->select_comisionista->comision }}" @endif />
                        <td>
                            <input style="min-width: 85px" type='text' id='precio_unitario_comision{{$i_edit}}'
                                name='precio_unitario_comision[]' readonly="readonly" class="form-control" required
                                autocomplete="off" value="{{ $registros->precio_unitario_comi * $registros->cantidad }}" />
                        </td>
                        <td>
                            <input style="min-width: 85px" type='text' id='total{{$i_edit}}' name='total'
                                disabled="disabled" class="total form-control" required autocomplete="off"
                                value="{{ $registros->precio_unitario_comi * $registros->cantidad }}" />
                            <input type='text' id='afectacion{{$i_edit}}' name='afectacion' disabled="disabled"
                                class="afectacion form-control" hidden="" required autocomplete="off"
                                value="{{ $registros->precio_unitario_comi * $registros->cantidad }}" />
                        </td>
                        <span id="spTotal"></span>
                    </tr>
                @endforeach
            </tbody>
            <tbody>
                <tr style="background-color: #f5f5f500;" align="center">
                    <td class="text-right" colspan="7"><strong>Subtotal:</strong></td>
                    <td colspan="2">
                        <input id='sub_total' type="text" name="sub_total_sin_igv" readonly class="form-control"
                            required value="{{ $facturacion->sub_total_sin_forma }}" />
                        <input id='subtotal_gravado' type="text" name="subtotal_gravado" readonly
                            class="form-control" required hidden="" value="{{ $facturacion->op_gravada }}" />
                    </td>
                </tr>
                <tr style="background-color: #f5f5f500;" align="center">
                    <td class="text-right" colspan="7"><strong>IGV :</strong></td>
                    <td colspan="2"><input id='igv' type="text" disabled="disabled"
                            class="form-control" required value="{{ $facturacion->igv_sin_forma }}" /></td>
                </tr>
                <tr align="center">
                    <td colspan="7" class="text-right"><strong>Total :</strong></td>
                    <td colspan="2"><input id='total_final' type="text" name="precio_final_igv"
                            readonly="" class="form-control" required
                            value="{{ $facturacion->total_precio_sin_forma }}" /></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="d-flex justify-content-end mt-4">
                    <button data-style="zoom-out" id="boton" name="boton"
                        class="guardar button-lada btn btn-primary btn-outline" type="button">Guardar</button>
                    <button class="btn btn-primary float-right button-lada" style="margin-left: 10px;" type="button"
                        id="finalizar">Guardar y Finalizar</button>
                    <button type="submit" id="button_submit" hidden name="button_submit" value="0"></button>
                </div>
            </div>
        </div>
    </div>
    @include('transaccion.venta.facturacion._shared.modal_cuota_edit')
    @include('transaccion.venta.facturacion._shared.modal_add_product')
</div>
