<div class="row">
    <div class="col-lg-12" style="margin-top: -5px;">
        <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
            <form action="{{ route('facturacion_manual.update', $facturacion->id) }}" enctype="multipart/form-data"
                id="form_update" method="post">
                @csrf
                <div class="row" style="align-items: center; justify-content: center">
                    @include('layout_cabecera_ventas')
                    <div class="col-sm-4">
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
                                                    <a class="item_guia"
                                                        onclick="remove_item(this)">{{ $remi }}</a>
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
                            <label class="col-sm-2 col-form-label"><strong>Vendedor:</strong></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="personal" disabled required="required"
                                    value="{{ $facturacion->user->name }}">
                            </div>
                        </div>
                        <!-- Detracción -->
                        <div class="form-group row" style="justify-content: start !important">
                            <label class="col-form-label col-md-2"> <strong>Detracción:</strong> </label>
                            <div class="col-sm-8">
                                <select class="form-control" id="detraccion" name="detraccion_value" @if($facturacion->detracciones == null) disabled @endif>
                                    <option value="0" @if($facturacion->detracciones == null) selected @endif>Desactiva</option>
                                    <option value="1" @if($facturacion->detracciones != null) selected @endif>Activa</option>
                                </select>
                            </div>
                            <div class="col-sm-2" style="display: flex">
                                <a href="" id="button_detracc" data-toggle="modal"
                                    @if ( $facturacion->detracciones != null) data-target="#modal_detraccion"  @else data-target="#" @endif style="margin: auto"><i
                                        class="fa fa-question-circle"
                                        style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- {{$facturacion->tipo_operacion_id}} --}}
                    {{-- 2DA COLUMNA --}}
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>T. Operación </strong></label>
                            <div class="col-md-10">
                                <select class="select2_tipo_op  " name="tipo_operacion">
                                    @foreach ($tipo_operacion as $t_op)
                                        <option value="{{ $t_op->id }}" @if ($facturacion->tipo_operacion_id  == $t_op->id) selected      @endif>
                                            {{ $t_op->codigo }} - {{ $t_op->informacion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Almacen </strong></label>
                            <div class="col-md-10">
                                <select class="select2_tipo_almacen" name="almacen" id="almacen_id">
                                    @foreach ($almacen as $alm_sel)
                                        <option value="{{ $alm_sel->id }}"@if ($facturacion->almacen_id == $alm_sel->id)  @endif>
                                            {{ $alm_sel->nombre }} - {{ $alm_sel->abreviatura }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Forma de Pago y Moneda -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row" style="justify-content: normal;">
                                    <label class="col-form-label col-md-4"><strong>Forma Pago:</strong></label>
                                    <div class="col-md-6 pago_first_column">
                                        <select class="form-control" name="forma_pago" id="forma_pago"
                                            onchange="seleccionado_fp()" required>
                                            @foreach ($forma_pagos as $forma_pago_item)
                                                <option value="{{ $forma_pago_item->id }}"
                                                    {{ $facturacion->forma_pago_id == $forma_pago_item->id ? 'selected' : '' }}>
                                                    {{ $forma_pago_item->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="credito_pago"
                                        @if ($facturacion->forma_pago_id == 1) style="display: none" @endif>
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
                                            value="{{ $facturacion->moneda_id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fechas -->
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
                            {{-- <input type="text" value="{{$f acturacion->cambio}}" name="tipo_cambio" id="tipo_cambio"> --}}
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4"><strong>F. Venc.:</strong></label>
                                    <div class="col-md-8">
                                        @if ($facturacion->forma_pago_id == 1)
                                            {{-- Si es contado --}}
                                            <input type="date" class="form-control" id="fecha_vencimiento"
                                                name="fecha_vencimiento"
                                                value="{{ $facturacion->fecha_vencimiento_edit }}">
                                        @else
                                            <input type="date" disabled class="form-control"
                                                id="fecha_vencimiento" name="fecha_vencimiento"
                                                value="{{ $facturacion->fecha_vencimiento_edit }}">
                                        @endif
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
                                    rows="1">{{ $facturacion->observacion }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <input type="hidden" name="comparador_edicion" id="comparador_edicion" value="0">
                <input type="hidden" name="" id="count_articles"
                    value="{{ count($facturacion->registros_m) - 1 }}">
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
                                <th>Cantidad</th>
                                <th>P. Sugerido</th>
                                <th>Precio s/igv</th>
                                <th>Precio c/igv</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturacion->registros_m as $i_edit => $registros)
                                <tr>
                                    <td>
                                        <button type="button" class='delete borrar e btn btn-sm btn-danger'> <i
                                                class="fa fa-trash" aria-hidden="true"></i> </button>
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
                                                    $precio_sug = $registros->producto->stockAlmacenProducto(
                                                        $facturacion->almacen_id,
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
                                                    value="{{ $registros->servicio->id }} | {{ $registros->servicio->codigo_servicio }} | {{ $registros->servicio->codigo_original }} | {{ $registros->servicio->nombre }}"
                                                    selected>
                                                    {{ $registros->servicio->id }} |
                                                    {{ $registros->servicio->codigo_servicio }} |
                                                    {{ $registros->servicio->codigo_original }} |
                                                    {{ $registros->servicio->nombre }}</option>
                                                @php
                                                    $precio_sug = 1000;
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
                                        <textarea type='text' {{-- id='descripcion0' --}} name='descripcion_item[]' class="form-control" autocomplete="off"
                                            style="margin-top: 5px;">{{ $registros->descripcion_item }}</textarea>
                                        <textarea type='text' id='numero_serie{{ $i_edit }}' name='numero_serie[]' class="form-control"
                                            autocomplete="off" style="margin-top: 5px;" placeholder="N° de Serie">{{ $registros->numero_serie }}</textarea>
                                        <input style="min-width: 100px" hidden="" type='text'
                                            id='tipo_afec{{ $i_edit }}' name='tipo_afec[]' readonly="readonly"
                                            class="monto{{ $i_edit }} form-control"
                                            onkeyup="multi({{ $i_edit }})" autocomplete="off" />
                                        <input type="hidden" class="celda input-articulo" name="articulo[]"
                                            id="input_prod{{ $i_edit }}" value="{{ $input_prod }}">
                                    </td>
                                    <td>
                                        <input style="min-width: 100px" type='text'
                                            id='cantidad{{ $i_edit }}' name='cantidad[]' max=""
                                            class="monto{{ $i_edit }} form-control inp"
                                            onkeyup="multi({{ $i_edit }})" required autocomplete="off"
                                            value="{{ $registros->cantidad }}" />
                                    </td>
                                    <td>
                                        <input style="min-width: 100px" type='text'
                                            id='precio_oficial{{ $i_edit }}' name='precio_oficial[]'
                                            ondblclick="copy({{ $i_edit }})"
                                            class="precio_oficial{{ $i_edit }} form-control inp" required
                                            readonly data-toggle="tooltip" data-placement="top"
                                            title="Doble click (Copiar)" value="{{ $registros->precio_sugerido }}" />
                                    </td>
                                    <td>
                                        <input style="min-width: 100px" type='number' step="0.0000000000000001"
                                            id='precio{{ $i_edit }}' name='precio[]'
                                            class="monto{{ $i_edit }} form-control inp"
                                            onkeyup="multi_s_igv({{ $i_edit }}),multi({{ $i_edit }})"
                                            required autocomplete="off" value="{{ round($registros->precio, 8) }}" />
                                        <input type='text' hidden id='precio_s_igv_float{{ $i_edit }}'
                                            name='precio_s_igv_float' class="monto{{ $i_edit }} form-control"
                                            onkeyup="multi_s_igv({{ $i_edit }}),multi({{ $i_edit }})"
                                            required autocomplete="off" value="{{round($registros->precio * $registros->cantidad, 8)}}" />
                                    </td>
                                    <td>
                                        <input style="min-width: 100px" type='number' step="0.0000000000000001"
                                            id='precio_c_igv{{ $i_edit }}' name='precio_c_igv[]'
                                            class="precio_c_igv monto{{ $i_edit }} form-control inp"
                                            onkeyup="multi_c_igv({{ $i_edit }}),multi({{ $i_edit }})"
                                            required autocomplete="off"
                                            value="{{ round($registros->precio_igv_edit, 8) }}" />
                                    </td>
                                    <td>
                                        <input style="min-width: 100px" type='number' id='total{{ $i_edit }}'
                                            name='total' disabled="disabled" class="total form-control inp"
                                            required
                                            value="{{ round($registros->precio_igv_edit * $registros->cantidad, 8) }}"
                                            autocomplete="off" />
                                    </td>
                                    <span id="spTotal"></span>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr style="background-color: #f5f5f500;" align="center">
                                <td colspan="5" class="text-right align-middle" ><strong>Subtotal :</strong></td>
                                <td colspan="2">
                                    <input id='sub_total_view' type="number" name="" readonly
                                        class="form-control inp" required value="{{ number_format(round($facturacion->sub_total_precio_sin_forma, 2), 2) }}" />
                                    <input type="hidden" name="sub_total_sin_igv" id="sub_total" value="{{ $facturacion->sub_total_precio_sin_forma }}">
                                    <input id='subtotal_gravado' type="hidden" name="subtotal_gravado" readonly
                                        class="form-control inp" required  value="{{ $facturacion->op_gravada }}"/>
                                </td>
                            </tr>
                            <tr style="background-color: #f5f5f500;" align="center">
                                <td colspan="5" class="text-right align-middle"><strong>IGV :</strong></td>
                                <td colspan="2">
                                    <input id='igv_view' type="number" disabled="disabled"
                                        class="form-control inp" required value="{{number_format(round($facturacion->igv_sin_forma,2),2)}}" />
                                    <input type="hidden"  name="igv" id="igv" value="{{$facturacion->igv_sin_forma}}">
                                </td>
                            </tr>
                            <tr align="center">
                                <td colspan="5" class="text-right align-middle"><strong>Total :</strong></td>
                                <td colspan="2">
                                    <input id='total_final_view' type="number" name=""
                                        readonly="readonly" class="form-control inp" required value="{{number_format(round($facturacion->total_precio_sin_forma,2),2)}}" />
                                    <input type="hidden" name="costo_total" id="total_final" value="{{$facturacion->total_precio_sin_forma}}">    
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
                                    class="guardar button-ladda btn btn-primary btn-outline"
                                    type="button">Guardar</button>
                                <button class="btn btn-primary float-right button-ladda" style="margin-left: 10px;"
                                    type="button" id="finalizar">Guardar y Finalizar</button>
                                <button type="submit" id="button_submit" hidden name="button_submit"
                                    value="0"></button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Modal dentro del Form para que se envien los datos de cuotas --}}
                @include('transaccion.venta.facturacion._shared.modal_cuota_edit')
                {{-- Modal dentro del Form para que se envien los datos de DETRACCION --}}
                @include('transaccion.venta.facturacion._shared._edit_modal_detraccion')
            </form>
        </div>
    </div>
</div>

@include('transaccion.venta.facturacion.facturacion_manual._shared.modal_add_product')
