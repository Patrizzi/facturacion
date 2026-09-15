<form action="{{ route('cotizacion.update', $cotizacion->id) }}" method="post" enctype="multipart/form-data"
    id="coti_update">
    @csrf
    <div class="row form-label word-style">
        <div class="col-md-6">
            {{-- Cliente --}}
            <div class="form-group row">
                <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                <div class="col-md-10">
                    <input type="hidden" name="" id="cliente_id" value="{{ $cotizacion->cliente->id }}">
                    <select class="select2_demo_client" name="cliente" id="cliente" required="">
                        <option selected value="{{ $cotizacion->cliente->id }}">{{ $cotizacion->cliente->nombre }} -
                            {{ $cotizacion->cliente->numero_documento }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6" align="center">
            <div class="form-control ">
                <div class="row input_small">
                    <div class="col-sm-4">
                        <strong>Señor(es)</strong>
                    </div>
                    <div class="col-sm-8">
                        <input type="hidden" name="" id="cliente_id" value="{{ $cotizacion->cliente->id }}">
                        <select class="select2_demo_client" name="cliente" id="cliente" required="">
                            <option selected value="{{ $cotizacion->cliente->id }}">{{ $cotizacion->cliente->nombre }} -
                                {{ $cotizacion->cliente->numero_documento }}</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <strong>Forma de Pago:</strong>
                    </div>
                    <div class="col-sm-8">
                        <select class="form-control" name="forma_pago" required="required">
                            @foreach ($forma_pagos as $forma_pago)
                                <option value="{{ $forma_pago->id }}" @if ($cotizacion->forma_pago_id == $forma_pago->id) selected @endif>
                                    {{ $forma_pago->nombre }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <strong>Garantia:</strong>
                    </div>
                    <div class="col-sm-8">
                        <select class="form-control" name="garantia">
                            @foreach ($garantia as $garantias)
                                <option value="{{ $garantias->descripcion }}"
                                    @if ($cotizacion->garantia == $garantias->descripcion) selected @endif>{{ $garantias->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6" align="center" style="padding-bottom: 15px">
            <div class="form-control ">
                <div class="row input_small">
                    <div class="col-sm-4">
                        <strong>Validez:</strong>
                    </div>
                    <div class="col-sm-8">
                        <select class="form-control" name="validez" required="required">
                            @foreach ($validez as $validezz)
                                <option value="{{ $validezz->descripcion }}"
                                    @if ($cotizacion->validez == $validezz->descripcion) selected @endif>{{ $validezz->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <strong>Tipo de Moneda:</strong>
                    </div>
                    <div class="col-sm-8">
                        <input class="form-control" readonly type="text" name="" id=""
                            value="{{ $cotizacion->moneda->nombre }}">
                    </div>
                    <div class="col-sm-4">
                        <strong>Comisionista:</strong>
                    </div>
                    <div class="col-sm-8">
                        @if (isset($cotizacion->comisionista->cod_vendedor))
                            <input class="form-control" readonly type="text" id=""
                                value="{{ $cotizacion->comisionista->cod_vendedor }} - {{ $cotizacion->comisionista->personal->personal_l->nombres }} - {{ $cotizacion->comisionista->comision }}%">
                        @else
                            <input class="form-control" readonly type="text" id=""
                                value="Sin Comisionista - 0">
                        @endif
                    </div>

                    <!-- Sección de Renovación -->
                    <div class="col-sm-4"
                        style="margin-top: 15px; display: flex; align-items: center; justify-content: flex-start; padding-right: 15px; padding-left: 55px;">
                        <div class="switch-container">
                            <strong>Renovación:</strong>
                            <label class="switch">
                                <input type="checkbox" id="estado_renovacion" name="estado_renovacion" value="1">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-8" style="margin-top: 15px;">
                        <div id="renovacion_container" style="display: none;">
                            <div class="row" style="margin: 0;">
                                <div class="col-sm-7" style="padding-left: 0;">
                                    <label style="font-size:11px; color:#676a6c; margin-bottom:3px;">Nueva Fecha de
                                        Renovación</label>
                                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento"
                                        class="form-control form-control-sm"
                                        min="{{ $renovacion ? $renovacion->fecha_vencimiento->format('Y-m-d') : now()->addDay()->format('Y-m-d') }}">
                                    <span id="dias_restantes_preview"
                                        style="font-size:11px; margin-top:3px; display:block;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br style="padding-bottom: 5px">
        <div class="col-sm-12">
            <div class="form-control">
                <strong>Observaciones</strong>
                <textarea class="form-control" name="observacion" id="">{{ $cotizacion->observacion }}</textarea>
            </div>
        </div>
    </div>
    <table cellspacing="0" class="table table-responsive" id="inp_s">
        <thead>
            <tr>
                <th><button class="addmore btn btn-success" type="button"><i class="fa fa-plus"></i></button></th>
                <th>Item</th>
                <th>Stock</th>
                <th>Cantidad</th>
                <th>Precio </th>
                <th>Descuento</th>
                <th>Precio U Desc</th>
                <th>Precio U Com</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody class="tables">
            @foreach ($cotizacion_registro as $cotizacion_registros)
                <tr>
                    <td>
                        <input type="hidden" name="elem_delete[]" value="{{ $cotizacion_registros->id }}">
                        <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="existente">
                        <button type="button" class="btn btn-danger borrar e "><i class="fa fa-trash"></i></button>
                    </td>
                    <td>
                        <select class="monto0 select2_demo_3 select_change limp_select" required=""
                            id="articulo{{ $h }}" autocomplete="off"
                            onchange="ajax({{ $h }})">
                            @if (isset($cotizacion_registros->producto->id))
                                <option
                                    value="{{ $cotizacion_registros->producto->id }} | {{ $cotizacion_registros->producto->codigo_producto }} | {{ $cotizacion_registros->producto->codigo_original }} | {{ $cotizacion_registros->producto->nombre }}">
                                    {{ $cotizacion_registros->producto->id }} |
                                    {{ $cotizacion_registros->producto->codigo_producto }} |
                                    {{ $cotizacion_registros->producto->codigo_original }} |
                                    {{ $cotizacion_registros->producto->nombre }}</option>
                            @else
                                <option
                                    value="{{ $cotizacion_registros->servicio->id }} | {{ $cotizacion_registros->servicio->codigo_servicio }} | {{ $cotizacion_registros->servicio->codigo_original }} | {{ $cotizacion_registros->servicio->nombre }}">
                                    {{ $cotizacion_registros->servicio->id }} |
                                    {{ $cotizacion_registros->servicio->codigo_servicio }} |
                                    {{ $cotizacion_registros->servicio->codigo_original }} |
                                    {{ $cotizacion_registros->servicio->nombre }}</option>
                            @endif
                        </select>
                        <textarea type='text' id='descripcion{{ $h }}' name='descripcion_item[]'
                            placeholder="Descripción de Item" class="form-control limp_txt" autocomplete="off" style="margin-top: 5px;">{{ $cotizacion_registros->descripcion_item }}</textarea>
                    </td>
                    <td>
                        <input type="text" class="form-control limp" name="stock"
                            id="stock{{ $h }}"
                            value="@if ($cotizacion_registros->stock != null) {{ $cotizacion_registros->stock }} @else 100 @endif"
                            readonly>
                    </td>
                    <td>
                        <input type="number" name="cantidad[]" id="cantidad{{ $h }}"
                            class="form-control limp" onkeyup="multi({{ $h }})"
                            value="{{ $cotizacion_registros->cantidad }}" max="{{ $cotizacion_registros->stock }}">
                    </td>
                    <td>
                        <input type="text" name="precio[]" id="precio{{ $h }}"
                            class="form-control limp" value="{{ $cotizacion_registros->precio }}" readonly>
                    </td>
                    <td>
                        @if (isset($cotizacion_registros->producto->descuento2))
                            <div style="position: relative;">
                                <input class="text_des limp" type='text' id='descuento{{ $h }}'
                                    name='descuento[]' readonly="readonly"
                                    value="{{ $cotizacion_registros->producto->descuento2 }}" required
                                    autocomplete="off" />
                            </div>
                            <div class="div_check">
                                @if ($cotizacion_registros->descuento > 0)
                                    <input class="check" type='checkbox' id='check{{ $h }}'
                                        name='check[]' onclick="multi({{ $h }})" style=""
                                        autocomplete="off" checked />
                                    <input type='hidden' id='check_descuento{{ $h }}'
                                        name='check_descuento[]' class="form-control limp" required
                                        value="{{ $cotizacion_registros->producto->descuento2 }}">
                                @else
                                    <input class="check" type='checkbox' id='check{{ $h }}'
                                        name='check[]' onclick="multi({{ $h }})" style=""
                                        autocomplete="off" />
                                    <input type='hidden' id='check_descuento{{ $h }}'
                                        name='check_descuento[]' class="form-control limp" required value="0">
                                @endif
                            </div>

                            <input style="width: 76px" hidden="" type='text'
                                id='tipo_afec{{ $h }}' name='tipo_afec[]' readonly="readonly"
                                class="monto0 form-control limp" onkeyup="multi({{ $h }})" required
                                autocomplete="off"
                                value="{{ strtok($cotizacion_registros->producto->tipo_afec_i_producto->informacion, ' ') }}" />
                            <input class="celda" name="articulo[]" id="input_prod{{ $h }}"
                                value="{{ $cotizacion_registros->producto->id }} | {{ $cotizacion_registros->producto->codigo_producto }} | {{ $cotizacion_registros->producto->codigo_original }} | {{ $cotizacion_registros->producto->nombre }}"
                                class="limp" hidden>
                        @else
                            <div style="position: relative;">
                                <input class="text_des limp" type='text' id='descuento{{ $h }}'
                                    name='descuento[]' readonly="readonly"
                                    value="{{ $cotizacion_registros->servicio->descuento }}" required
                                    autocomplete="off" />

                            </div>
                            <div class="div_check">
                                @if ($cotizacion_registros->descuento > 0)
                                    <input class="check" type='checkbox' id='check{{ $h }}'
                                        name='check[]' onclick="multi({{ $h }})" style=""
                                        autocomplete="off" checked />
                                    <input type='hidden' id='check_descuento{{ $h }}'
                                        name='check_descuento[]' class="form-control limp" required
                                        value="{{ $cotizacion_registros->descuento }}">
                                @else
                                    <input class="check" type='checkbox' id='check{{ $h }}'
                                        name='check[]' onclick="multi({{ $h }})" style=""
                                        autocomplete="off" />
                                    <input type='hidden' id='check_descuento{{ $h }}'
                                        name='check_descuento[]' class="form-control limp" required value="0">
                                @endif
                            </div>

                            <input style="width: 76px" hidden="" type='text'
                                id='tipo_afec{{ $h }}' name='tipo_afec[]' readonly="readonly"
                                class="monto0 form-control limp" onkeyup="multi({{ $h }})" required
                                autocomplete="off"
                                value="{{ strtok($cotizacion_registros->servicio->tipo_afec_i_serv->informacion, ' ') }}" />
                            <input class="celda" name="articulo[]" id="input_prod{{ $h }}"
                                value="{{ $cotizacion_registros->servicio->id }} | {{ $cotizacion_registros->servicio->codigo_servicio }} | {{ $cotizacion_registros->servicio->codigo_original }} | {{ $cotizacion_registros->servicio->nombre }}"
                                class="limp" hidden>
                        @endif
                        <input type='hidden' id='promedio_original{{ $h }}' name='promedio_original[]'
                            class="form-control limp" required
                            value="{{ $cotizacion_registros->promedio_original }}">
                    </td>
                    <td>
                        <input type="text" readonly name="precio_unitario_descuento[]"
                            id="precio_unitario_descuento{{ $h }}" class="form-control limp"
                            value="{{ $cotizacion_registros->precio_unitario_desc }}">
                    </td>
                    <td>

                        @if (isset($cotizacion->comisionista->cod_vendedor))
                            <input style="width: 76px" type='hidden' name="comision[]"
                                id='comision{{ $h }}' readonly="readonly" class="form-control" required
                                autocomplete="off" value="{{ $cotizacion->comisionista->comision }}" />
                        @else
                            <input style="width: 76px" type='hidden' name="comision[]"
                                id='comision{{ $h }}' readonly="readonly" class="form-control" required
                                autocomplete="off" value="0" />
                        @endif
                        <input type="text" readonly name="precio_unitario_comision[]"
                            id="precio_unitario_comision{{ $h }}" class="form-control limp"
                            value="{{ $cotizacion_registros->precio_unitario_comi }}">
                    </td>
                    <td>
                        <input type="text" name="total_inp" id="total{{ $h }}" readonly
                            class="form-control limp"
                            value="{{ $cotizacion_registros->cantidad * $cotizacion_registros->precio_unitario_comi }}">
                        <input type='text' id='afectacion{{ $h }}' style="width: 76px"
                            name='afectacion' disabled="disabled" class="afectacion form-control limp"
                            hidden="" required autocomplete="off"
                            value="{{ $cotizacion_registros->precio_unitario_comi }}" />
                        {{-- <input style="width: 76px" type='text' id='precio_unitario_igv{{$h}}' name='precio_unitario_igv[]' readonly="readonly" class="form-control" required autocomplete="off" /> --}}
                    </td>
                </tr>
                <span hidden>{{ $h++ }}</span>
                <span
                    hidden>{{ $sume = $cotizacion_registros->precio_unitario_comi * $cotizacion_registros->cantidad + $sume }}</span>
            @endforeach
        </tbody>
        <tfooter>
            <tr>
                <td colspan="3" rowspan="3">
                    <h3 align="left" class="h3-total" id="left_h3">
                        <?php
                        // $v = new NumeroALetras();
                        // $letra = $v->toInvoice($end, 2);
                        // $end_final_point=strstr($end2, '.', false);
                        // $end_final=str_replace('.', '',$end_final_point);
                        ?>
                        Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $cotizacion->moneda->nombre }}
                    </h3>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>Subtotal:</td>
                <td colspan="2">
                    <input id='subtotal_gravado' disabled="disabled" hidden="" class="form-control limp_txt"
                        required value="{{ $sub_total }}" />
                    <input type="text" id="sub_total" name="sub_total" disabled class="form-control limp_txt"
                        value="{{ $sub_total }}">
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Igv:</td>
                <td colspan="2">
                    <input type="text" id="igv_input" name="igv_input" disabled class="form-control limp_txt"
                        value="{{ number_format(round($igv_p, 2), 2) }}">
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Total:</td>
                <td colspan="2">
                    <input type="text" id="total_final" name="total_final" disabled class="form-control limp_txt"
                        value="{{ number_format(round($end, 2), 2) }}">
                </td>
            </tr>
        </tfooter>
    </table>
    <br>
    <div class="col-sm-12" align="right">
        <button data-style="zoom-out" class="guardar ladda-button btn btn-primary btn-outline"
            type="submit">Guardar</button>
        <button class="btn btn-primary  demo3 float-right" style="margin-left: 10px;" type="button">Guardar y
            Finalizar</button>
        <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden=""
            data-style="zoom-out">
        </button>
    </div>
</form>
