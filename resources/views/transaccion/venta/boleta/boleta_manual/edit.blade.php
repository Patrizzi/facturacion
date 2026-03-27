<div class="row">
    <div class="col-lg-12" style="margin-top: -5px">
        <div class="ibox-content p-xl" style="margin-bottom: 20px;padding-bottom: 50px;">
            <form action="{{ route('boleta_manual.update', $boleta->id) }}" enctype="multipart/form-data" id="form_update"
                method="post">
                @csrf
                <div class="row" style="align-items: center;justify-content: center">
                    @include('layout_cabecera_ventas')
                    <div class="col-sm-4">
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
                <div class="row word-style">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <select class="select2_demo_client" name="cliente" id="cliente" required=""
                                        value="{{ old('nombre') }}">
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
                                        <input type="text" class="form-control" name="orden_compra"
                                            value="{{ $boleta->orden_compra ?? 0 }}" />

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4"><strong>G. Remisión:</strong></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="guia_r" id="guia_save_inp"
                                            value="{{ $boleta->remi ?? 0 }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4"><strong>F. Emis.:</strong></label>
                                    <div class="col-md-8">
                                        <input type="text" id="fecha_emision" name="fecha_emision"
                                            class="form-control" value="{{ $boleta->fecha_emision }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row" id="data_1">
                                    <label class="col-form-label col-md-4"><strong>F. Venci.</strong></label>
                                    <div class="col-md-8 input-group date">
                                        <span class="input-group-addon" style="display: none">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        @if ($boleta->forma_pago_id == 1)
                                            {{-- Si es contado --}}
                                            <input type="date" class="form-control" id="fecha_vencimiento"
                                                name="fecha_vencimiento" value="{{ $boleta->fecha_vencimiento_edit }}">
                                        @else
                                            <input type="date" disabled class="form-control" id="fecha_vencimiento"
                                                name="fecha_vencimiento" value="{{ $boleta->fecha_vencimiento_edit }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                                <label class="col-form-label col-md-2"><strong>Comisionista:</strong></label>
                                <div class="col-md-10">
                                    <select name="comisionista" id="comisionista" class="select2_demo_comisionista"
                                        onchange="comision()">
                                        <option value="Sin Comisión - 0 %">Sin Comisión - 0 %</option>
                                        @foreach ($p_venta as $comisionista)
                                            <option id="{{ $comisionista->id }}">{{ $comisionista->cod_vendedor }} -
                                                {{ $comisionista->personal->personal_l->nombres }} -
                                                <span style="color: red">{{ $comisionista->comision }} %</span>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>T. Operación </strong></label>
                            <div class="col-md-10">
                                <select class="form-control select2_operacion" name="tipo_operacion">
                                    @foreach ($tipo_operacion as $index => $t_op)
                                        <option value="{{ $t_op->id }}"
                                            @if ($index == 0) selected @endif>
                                            {{ $t_op->codigo }} - {{ $t_op->informacion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2 "><strong>Almacén:</strong></label>
                            <div class="col-sm-10">
                                <select class="select2_demo_almacen" name="almacen_id_selec" required=""
                                    onchange="codigo_numero()">
                                    @foreach ($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}"@if ($boleta->almacen_id == $almacen->id)  @endif>
                                            {{ $almacen->nombre }} - {{ $almacen->abreviatura }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row" style="justify-content: normal;">
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
                                        <button type="button" class='cuota_modal btn btn-info' id="cuota_modal"
                                            data-toggle="modal" data-target="#cuotas_modal"><i
                                                class="fa fa-calendar"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4"><strong>Moneda:</strong></label>
                                    <div class="col-md-8">
                                        <select name="" id="" class="form-control"
                                            onchange="changeMoney()">
                                            <option value="nacional"
                                                {{ $moneda->tipo == 'nacional' ? 'selected' : '' }}>
                                                Soles</option>
                                            <option value="extranjera"
                                                {{ $moneda->tipo == 'extranjera' ? 'selected' : '' }}>Dólares</option>
                                        </select>
                                        <input type="hidden" name="moneda" id="moneda" class="form-control "
                                            value="{{ ucwords($moneda->nombre) }}" readonly="readonly">
                                        <input type="hidden" id="moneda_id" class="form-control" name="moneda_id"
                                            value="{{ $boleta->moneda_id }}">
                                    </div>
                                </div>
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
                    <div class="col-md-12">
                        <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
                        <input type="hidden" name="almacen" id="almacen_id" class="form-control "
                            value="{{ $sucursal->id }}" readonly="readonly">
                        <input type="hidden" id="moneda_id" class="form-control " value="{{ $moneda->id }}">
                    </div>
                    <input type="hidden" name="" id="count_articles" value="{{ count($boleta->registros_m) - 1 }}">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table cellspacing="0" class="table tables">
                                <thead>
                                    <tr>
                                        <th>
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
                                        <th>Cantidad</th>
                                        <th>P. Sugerido</th>
                                        <th>P U. S/IGV </th>
                                        <th>P. U. IGV.</th>
                                        <th>Total IGV.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($boleta->registros_m as $i_edit => $registros)
                                        <tr>
                                            <td>
                                                <button type="button" class='delete borrar e btn btn-sm btn-danger'>
                                                    <i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="monto{{ $i_edit }} select2_demo_3 select_change"
                                                    required=""
                                                    @if ($i_edit == 0) id="articulo" @else id="articulo{{ $i_edit }}" @endif
                                                    onchange="ajax({{ $i_edit }})" autocomplete="off">
                                                    @if ($registros->producto?->id)
                                                        <option
                                                            value="{{ $registros->producto->id }} | {{ $registros->producto->codigo_producto }} | {{ $registros->producto->codigo_original }} | {{ $registros->producto->nombre }}"
                                                            selected>
                                                            {{ $registros->producto->id }} |
                                                            {{ $registros->producto->codigo_producto }} |
                                                            {{ $registros->producto->codigo_original }} |
                                                            {{ $registros->producto->nombre }}</option>
                                                        @php
                                                            $input_prod =
                                                                $registros->producto->id .' | ' .$registros->producto->codigo_producto .' | ' .$registros->producto->codigo_original .' | ' .$registros->producto->nombre;
                                                            $afect = explode(
                                                                ' - ',
                                                                $registros->producto->tipo_afec_i_producto->informacion,
                                                            )[0];
                                                        @endphp
                                                    @else
                                                        <option
                                                            value="{{ $registros->servicio->id }} | {{ $registros->servicio->codigo_servicio }} | {{ $registros->servicio->codigo_original }} | {{ $registros->servicio->nombre }}"
                                                            selected>
                                                            {{ $registros->servicio->id }} |
                                                            {{ $registros->servicio->codigo_servicio }} |
                                                            {{ $registros->servicio->codigo_original }} |
                                                            {{ $registros->servicio->nombre }}</option>
                                                        @php
                                                            $input_prod =
                                                                $registros->servicio->id.' | ' .$registros->servicio->codigo_servicio .' | ' .$registros->servicio->codigo_original .' | ' .$registros->servicio->nombre;
                                                            $afect = explode(
                                                                ' - ',
                                                                $registros->servicio->tipo_afec_i_serv->informacion,
                                                            )[0];
                                                        @endphp
                                                    @endif
                                                </select>
                                                <textarea type='text' {{-- id='descripcion0' --}} name='descripcion_item[]' class="form-control" autocomplete="off"
                                                    style="margin-top: 5px;">{{ $registros->descripcion }}</textarea>
                                                <textarea type='text' id='numero_serie{{ $i_edit }}' name='numero_serie[]' class="form-control"
                                                    autocomplete="off" style="margin-top: 5px;" placeholder="N° de Serie">{{ $registros->numero_serie }}</textarea>
                                                <input style="min-width: 100px" hidden="" type='text'
                                                    id='tipo_afec{{ $i_edit }}' name='tipo_afec[]'
                                                    readonly="readonly" class="monto{{ $i_edit }} form-control"
                                                    onkeyup="multi({{ $i_edit }})" autocomplete="off"
                                                    value="{{ $afect }}" />
                                                <input type="hidden" class="celda" name="articulo[]"
                                                    id="input_prod{{ $i_edit }}" value="{{ $input_prod }}">
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='text'
                                                    id='cantidad{{ $i_edit }}' name='cantidad[]'
                                                    max="" class="monto{{ $i_edit }} form-control inp"
                                                    onkeyup="multi({{ $i_edit }})" required autocomplete="off"
                                                    value="{{ $registros->cantidad }}" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='text'
                                                    id='precio_oficial{{ $i_edit }}' name='precio_oficial[]'
                                                    ondblclick="copy({{ $i_edit }})"
                                                    class="precio_oficial{{ $i_edit }} form-control inp"
                                                    required readonly data-toggle="tooltip" data-placement="top"
                                                    title="Doble click (Copiar)"
                                                    value="{{ $registros->precio_sugerido }}" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' step="0.0000000000000001"
                                                    id='precio{{ $i_edit }}' name='precio[]'
                                                    class="monto{{ $i_edit }} form-control inp"
                                                    onkeyup="multi_s_igv({{ $i_edit }}),multi({{ $i_edit }})"
                                                    required autocomplete="off" value="{{ $registros->precio }}" />
                                                <input hidden type='text'
                                                    id='precio_s_igv_float{{ $i_edit }}'
                                                    name='precio_s_igv_float' class="precio_s_igv_float form-control"
                                                    onkeyup="multi_s_igv({{ $i_edit }}),multi({{ $i_edit }})"
                                                    required autocomplete="off" value="{{ $registros->precio }}" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' step="0.0000000000000001"
                                                    id='precio_c_igv{{ $i_edit }}' name='precio_c_igv[]'
                                                    class="precio_c_igv monto{{ $i_edit }} form-control inp"
                                                    onkeyup="multi_c_igv({{ $i_edit }}),multi({{ $i_edit }})"
                                                    required autocomplete="off"
                                                    value="{{ round($registros->precio_igv, 2) }}" />
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='number' id='total{{ $i_edit }}'
                                                    name='total' disabled="disabled" class="total form-control inp"
                                                    required autocomplete="off"
                                                    value="{{ round($registros->precio_igv * $registros->cantidad, 2) }}" />
                                            </td>
                                            <span id="spTotal"></span>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr style="background-color: #f5f5f500;" align="right">
                                        <td colspan="5"><strong>Subtotal :</strong></td>
                                        <td colspan="2">
                                            <input id='sub_total' type="number" name="sub_total_sin_igv" readonly
                                                class="form-control inp" required
                                                value="{{ $boleta->sub_total_precio_sin_forma }}" />
                                            <input id='subtotal_gravado' type="text" name="subtotal_gravado"
                                                readonly class="form-control inp" required hidden=""
                                                value="{{ $boleta->op_gravada }}" />
                                        </td>
                                    </tr>
                                    <tr style="background-color: #f5f5f500;" align="right">
                                        <td colspan="5"><strong>IGV :</strong></td>
                                        <td colspan="2">
                                            <input id='igv' type="number" disabled="disabled"
                                                class="form-control inp" required
                                                value="{{ $boleta->igv_sin_forma }}" />
                                        </td>
                                    </tr>
                                    <tr align="right">
                                        <td colspan="5"><strong>Total :</strong></td>
                                        <td colspan="2"><input id='total_final' type="number" name="costo_total"
                                                readonly="readonly" class="form-control inp" required
                                                value="{{ $boleta->total_precio_sin_forma }}" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end mt-4">
                            {{-- <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary button-ladda" id="boton" name="boton">Guardar</button>
                                </div> --}}
                            <button data-style="zoom-out" id="boton" name="boton"
                                class="guardar button-lada btn btn-primary btn-outline"
                                type="button">Guardar</button>
                            <button data-style="zoom-out" class="btn btn-primary float-right button-lada"
                                style="margin-left: 10px;" type="button" id="finalizar">Guardar y Finalizar</button>
                            <button type="submit" id="button_submit" hidden name="button_submit"
                                value="0"></button>
                        </div>
                    </div>
                </div>
                {{-- Modal dentro del Form para que se envien los datos de cuotas --}}
                @include('transaccion.venta.boleta._shared.modal_cuota_edit')
            </form>
        </div>
    </div>
    @include('transaccion.venta.boleta._shared.modal_add_product')
</div>
