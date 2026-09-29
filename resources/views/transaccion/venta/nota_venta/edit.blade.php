    <form action="{{ route('nota_venta.update', $nota_venta->id) }}" method="post" id="nota_vent_update">
        @csrf
        <div class="row form-label word-style">
            <div class="col-md-6">
                {{-- Cliente --}}
                <div class="form-group row">
                    <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                    <div class="col-md-10">
                        <input type="hidden" name="" id="cliente_id" value="{{ $nota_venta->cliente->id }}">
                        <select class="select2_demo_client" name="cliente" id="cliente" required="">
                            <option selected value="{{ $nota_venta->cliente->id }}">{{ $nota_venta->cliente->nombre }}
                                - {{ $nota_venta->cliente->numero_documento }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"><strong>Fecha Emisión:</strong></label>
                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="text" name="fecha_emision" class="form-control" value="{{ date('d-m-Y') }}"
                                readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"><strong>Moneda:</strong></label>
                    <div class="col-md-10">
                        <select name="moneda" class="form-control" required id="moneda_id" onchange="changeMoney()" readonly>
                            @foreach ($monedas as $moneda)
                                <option value="{{ $moneda->id }}"@if ($moneda->id == $nota_venta->moneda_id) selected @endif>
                                    {{ $moneda->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"><strong>Almacén:</strong></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" value="{{ $nota_venta->almacen->nombre }}" disabled>
                        <input type="text" class="form-control" value="{{ $nota_venta->almacen->id }}" name="almacen"
                            hidden>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"><strong>Forma Pago:</strong></label>
                    <div class="col-md-10">
                        <select class="form-control" name="forma_pago" required="required">
                            @foreach ($forma_pagos as $forma_pago)
                                <option value="{{ $forma_pago->id }}" @if($nota_venta->forma_pago == $forma_pago->id) selected @endif>{{ $forma_pago->nombre }}
                                </option>
                            @endforeach
                            <select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"><strong>Garantía:</strong></label>
                    <div class="col-md-10">
                        <select class="form-control" name="garantia">
                            <option selected value="{{$nota_venta->garantia}}">{{$nota_venta->garantia}}</option>
                            @foreach ($garantia as $garantias)
                                <option value="{{ $garantias->descripcion }}">
                                    {{ $garantias->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-md-1 col-form-label"><strong>Obervacion:</strong></label>
                    <div class="col-md-11">
                        <textarea class="form-control" name="observacion" id="observacion" rows="1" placeholder="Ingrese una observación">{{ $nota_venta->observacion }}</textarea>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table tables" id="inp_s">
                    <thead>
                        <tr>
                            <th style="width: 10px;">
                                <div>
                                    <button type="button" style="display: none" class='addmore btn btn-sm btn-success'>
                                        <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary btn-outline" data-toggle="modal"
                                    data-target="#add_product_data" id="add_new_product">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </th>
                            <th class="row_articulo">Artículo</th>
                            <th style="width: 8%;">Cantidad</th>
                            <th>P. Sugerido</th>
                            <th>P.Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <input type="hidden" name="" id="count_articles" value="{{ $nota_venta_re->count() + 1 }}">
                    <tbody>
                        @foreach ($nota_venta_re as $nota_venta_reg)
                            <tr>
                                <td>
                                    <button class="btn btn-sm btn-primary delete borrar e"><i class="fa fa-trash"></i></button>
                                </td>
                                <td>
                                    <select class="select2_demo_3 select_change form-control" name="articulo[]"
                                        id="article_text{{ $h }}" onchange="ajax({{ $h }})">
                                        <option value="{{ $nota_venta_reg->producto }}">{{ $nota_venta_reg->producto }}
                                        </option>
                                    </select>
                                    <textarea style="margin-top: 5px" name="article_descripcion[]" id="" class="form-control"
                                        placeholder="Descripcion del artículo" rows="1">{{ $nota_venta_reg->descripcion }}</textarea>
                                    <input type="hidden" class="celda" id="input_prod{{ $h }}" value="{{ $nota_venta_reg->producto }}">
                                    <input type="hidden" id="tipo_articulo_{{$h}}" value="product"></input>
                                </td>
                                <input type="hidden" name="elem_delete[]" value="{{ $nota_venta_reg->id }}">
                                <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="existente">
                                <td><input type="text" value="{{ $nota_venta_reg->cantidad }}"
                                        class="cantidad{{ $h }} form-control limp"
                                        id="cantidad{{ $h }}" name="cantidad[]"
                                        onkeyup="multi({{ $h }})"></td>
                                <td><input type="text" class="form-control" readonly
                                        id="precio_sugerido{{ $h }}" ondblclick="copy({{ $h }})">
                                </td>
                                <td><input type="text"
                                        value="{{ $nota_venta_reg->precio_nacional }}"
                                        class="precio{{ $h }} form-control limp"
                                        id="precio{{ $h }}" name="precio[]"
                                        onkeyup="multi({{ $h }})"></td>
                                <td><input type="text"
                                        value="{{ $nota_venta_reg->cantidad * $nota_venta_reg->precio_nacional }}"
                                        class="form-control limp" name="total" id="total{{ $h }}" readonly>
                                </td>
                            </tr>
                            <span hidden>{{ $h++ }}</span>
                        @endforeach
                    </tbody>
                    <tbody>
                        <tr class="text-center">
                            <td colspan="4"></td>
                            <td><strong>Total:</strong></td>
                            <td>
                                <input id='total_final_view' name="costo_total" readonly="readonly"
                                    class="form-control" required value="{{$end}}" />
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
        </div>
    </form>

    @include('transaccion.venta._shared.modal_add_producto')
