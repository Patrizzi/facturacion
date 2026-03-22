<form action="{{ route('cotizacion_manual.update', $cotizacion->id) }}" method="post" id="coti_man_update">
    @csrf
    <div class="row form-label word-style">
        <div class="col-md-6">
            <!-- Cliente -->
            <div class="form-group row">
                <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                <div class="col-md-10">
                    <input type="hidden" name="" id="cliente_id" value="{{ $cotizacion->cliente->id }}">
                    <select class="select2_demo_client" name="cliente" id="cliente" required="">
                        <option selected value="{{ $cotizacion->cliente->id }}">{{ $cotizacion->cliente->nombre }}
                            - {{ $cotizacion->cliente->numero_documento }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4"><strong>Fecha Emisión:</strong></label>
                        <div class="col-md-8">
                            <input type="text" name="fecha_emision" class="form-control"
                                value="{{ $cotizacion->fecha_emision_edit }}" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4"><strong>Validez:</strong></label>
                        <div class="col-md-8">
                            <select class="form-control" name="validez" required="required">
                                @foreach ($validez as $validezz)
                                    <option value="{{ $validezz->descripcion }}"
                                        @if ($cotizacion->validez == $validezz->descripcion) selected @endif>{{ $validezz->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-2"><strong>Almacén:</strong></label>
                <div class="col-md-10">
                    <input type="text" class="form-control" readonly
                        value="{{ $cotizacion->almacen->nombre }} - {{ $cotizacion->almacen->abreviatura }}"
                        name="" id="">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-form-label col-md-2"><strong>T. Operación:</strong></label>
                <div class="col-md-10">
                    <select class="form-control select2_tipo_op" name="tipo_operacion">
                        @foreach ($tipo_operacion as $t_op)
                            <option id="{{ $t_op->id }}" @if ($cotizacion->tipo_operacion_id == $t_op->id) selected @endif>
                                {{ $t_op->codigo }} -
                                {{ $t_op->informacion }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4"><strong>Tipo:</strong></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" readonly value="{{ $cotizacion->tipo_label }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4"><strong>Moneda:</strong></label>
                        <div class="col-md-8">
                            <select class="form-control select2_moneda" name="moneda" required="required" onchange="changeMoney()">
                                @foreach ($moneda as $monedas)
                                    <option value="{{ $monedas->nombre }}"
                                        @if ($cotizacion->moneda_id == $monedas->id) selected @endif>
                                        {{ ucfirst($monedas->nombre) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4"><strong>Forma Pago:</strong></label>
                        <div class="col-md-8">
                            <select class="form-control" name="forma_pago" required="required">
                                @foreach ($forma_pagos as $forma_pago)
                                    <option value="{{ $forma_pago->id }}"
                                        @if ($cotizacion->forma_pago_id == $forma_pago->id) selected @endif>
                                        {{ $forma_pago->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4"><strong>Garantía:</strong></label>
                        <div class="col-md-8">
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
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-form-label col-md-2"><strong>Observación:</strong></label>
                <div class="col-md-10">
                    <textarea class="form-control" name="observacion" id="observacion" rows="1" placeholder="Ingrese una observación">{{ $cotizacion->observacion }}</textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="col-form-label col-md-2"><strong>Renovación:</strong></label>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="switch-container">
                                <label class="switch">
                                    <input type="checkbox" id="estado_renovacion" name="estado_renovacion" value="1">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div id="renovacion_container" style="display: none;">
                                <div class="row" style="margin: 0;">
                                    <div class="col-sm-6" style="padding-left: 0;">
                                        <input
                                            type="date"
                                            id="fecha_vencimiento"
                                            name="fecha_vencimiento"
                                            class="form-control form-control-sm"
                                            min="{{ $renovacion ? $renovacion->fecha_vencimiento->format('Y-m-d') : now()->addDay()->format('Y-m-d') }}"
                                        >
                                        <span id="dias_restantes_preview" style="font-size:11px; margin-top:3px; display:block;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table tables" id="inp_s">
            <thead>
                <tr>
                    <th style="width: 10px;"><button type="button" class='addmore btn btn-sm btn-success'> <i class="fa fa-plus-square"
                                aria-hidden="true"></i> </button>&nbsp;</th>
                    <th class="row_articulo">Artículo</th>
                    <th>Cantidad</th>
                    <th>P. Sugerido</th>
                    <th>P. s/Igv</th>
                    <th>P. c/Igv</th>
                    <th>Total IGV</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cotizacion_m_reg as $cotizacion_m_regs)
                    <tr>
                        <td>
                            <button class="btn btn-sm btn-danger delete borrar e"><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                            <input type="hidden" name="elem_delete[]" value="{{ $cotizacion_m_regs->id }}">
                            <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="existente">
                            <select class="select2_demo_3 select_change" required=""
                                id="articulo{{ $h }}"
                                onchange="inputs_campos({{ $h }}),ajax({{ $h }})"
                                autocomplete="off">
                                @if (isset($cotizacion_m_regs->producto->id))
                                    <option
                                        value="{{ $cotizacion_m_regs->producto->id }} | {{ $cotizacion_m_regs->producto->codigo_producto }} | {{ $cotizacion_m_regs->producto->codigo_original }} | {{ $cotizacion_m_regs->producto->nombre }}">
                                        {{ $cotizacion_m_regs->producto->id }} |
                                        {{ $cotizacion_m_regs->producto->codigo_producto }} |
                                        {{ $cotizacion_m_regs->producto->codigo_original }} |
                                        {{ $cotizacion_m_regs->producto->nombre }}</option>
                                    @php
                                        if($cotizacion->moneda_id == 1 ){
                                            $precio_sug = $cotizacion_m_regs->producto->calcularPreciosSugerido()['precio_nacional'];
                                        }else{
                                            $precio_sug = $cotizacion_m_regs->producto->calcularPreciosSugerido()['precio_extranjero'];
                                        }
                                        $afect = explode(
                                            ' - ',
                                            $cotizacion_m_regs->producto->tipo_afec_i_producto->informacion,
                                        )[0];
                                    @endphp
                                @else
                                    <option
                                        value="{{ $cotizacion_m_regs->servicio->id }} | {{ $cotizacion_m_regs->servicio->codigo_servicio }} | {{ $cotizacion_m_regs->servicio->codigo_original }} | {{ $cotizacion_m_regs->servicio->nombre }}">
                                        {{ $cotizacion_m_regs->servicio->id }} |
                                        {{ $cotizacion_m_regs->servicio->codigo_servicio }} |
                                        {{ $cotizacion_m_regs->servicio->codigo_original }} |
                                        {{ $cotizacion_m_regs->servicio->nombre }}</option>
                                    @php
                                        $precio_sug = 1000;
                                        $afect = explode(
                                            ' - ',
                                            $cotizacion_m_regs->servicio->tipo_afec_i_serv->informacion,
                                        )[0];
                                    @endphp
                                @endif
                            </select>
                            {{--{{$cotizacion->moneda_id}} --}}
                            <textarea type='text' id='descripcion0' name='descripcion_item[]' placeholder="Descripción de Item"
                                class="form-control txt-limp" autocomplete="off" style="margin-top: 5px;">{{ $cotizacion_m_regs->descripcion_item }}</textarea>
                            <input hidden="hidden" class="celda" name="articulo[]"
                                id="input_prod{{ $h }}">
                        </td>
                        <td>
                            <input type='number' min="1"
                                id='cantidad{{ $h }}' name='cantidad[]' max=""
                                class="cantidad monto0 form-control" onkeyup="multi({{ $h }})" required
                                autocomplete="off" value="{{ $cotizacion_m_regs->cantidad }}" />
                        </td>
                        <td>
                            <input type='text' id='precio_oficial{{ $h }}'
                                name='precio_oficial[]' ondblclick="copy({{ $h }})"
                                class="precio_oficial{{ $h }} p_inp form-control inp" required readonly
                                data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" value="{{$precio_sug}}" />
                        </td>
                        <td>
                            <input type='text' id='precio_s_igv{{ $h }}'
                                name='precio_s_igv[]' class="precio_s_igv form-control"
                                onkeyup="multi_s_igv({{ $h }}),multi({{ $h }})" required
                                autocomplete="off" value="{{ round($cotizacion_m_regs->precio , 8) }}" maxlength="15" />
                            <input hidden type='text' id='precio_s_igv_float{{ $h }}'
                                name='precio_s_igv_float' class=" form-control precio_s_igv_float"
                                onkeyup="multi_s_igv({{ $h }}),multi({{ $h }})" required
                                autocomplete="off"
                                value="{{ $cotizacion_m_regs->precio * $cotizacion_m_regs->cantidad }}" />
                        </td>
                        <td>

                            <input type='text' id='precio_c_igv{{ $h }}'
                                name='precio_c_igv[]' class="precio_c_igv monto0 form-control"
                                onkeyup="multi_c_igv({{ $h }}),multi({{ $h }})" required
                                autocomplete="off" value="{{ round($cotizacion_m_regs->precio * $igv_1, 8) }}"
                                maxlength="15" />
                            <span hidden {{ $p_igv = $cotizacion_m_regs->precio * $igv_1 }}></span>
                        </td>
                        <td>
                            <input type='text' id='total{{ $h }}' name='total'
                                disabled="disabled" class="total form-control " required autocomplete="off"
                                value="{{ $cotizacion_m_regs->cantidad * $p_igv }}" />
                        </td>

                    </tr>
                    <span hidden>{{ $h++ }}</span>
                @endforeach
            </tbody>
            <tbody id="left_h3">
                <input id='sub_total' hidden /></td>
                <input id='total' hidden /></td>
                <tr>
                    <td colspan="4"></td>
                    <td style="vertical-align: middle"><strong>Subtotal: </strong></td>
                    <td colspan="2">
                        <input type="text" id='subtotal_view' name="" readonly="readonly"
                            class=" form-control" required value="{{ number_format(round($sub_total, 2),2) }}" />
                        <input type="hidden" name="subtotal" id="subtotal" class="subtotal" value="{{$sub_total}}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td style="vertical-align: middle"><strong>Igv:</strong></td>
                    <td colspan="2" >
                        <input type="text" id='igv_view' name="" readonly="readonly"
                            class=" form-control" required value="{{ number_format(round($igv, 2),2) }}" />
                        <input type="hidden" name="igv" id="igv"  class="igv" value="{{$igv}}">
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td style="vertical-align: middle"><strong>Total :</strong></td>
                    <td colspan="2">
                        <input type="text" id='total_final_view' name="" readonly="readonly"
                            class="form-control" required value="{{ number_format( round($end, 2),2) }}" />
                        <input type="hidden" name="total_final" id="total_final" class="total_final" value="{{$end}}">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
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
