<div class="row">
    <div class="col-lg-12" style="margin-top: -5px">
        <div class="ibox-content p-xl" style="margin-bottom: 20px; padding-bottom: 50px">
            <form action="{{route('guia_remision.update', $guia_remision->id)}}" method="POST" enctype="multipart/form-data" id="forma_update">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img src="{{ asset('img/logos/') }}/{{ $empresa->foto }}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{ $empresa->ruc }}</h3>
                            <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>
                            <h5>{{ $guia_remision->cod_guia }} </h5>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <select class="select2_demo_client" name="cliente" id="cliente" required=""
                                        onchange="change_cli()">
                                        <option value="{{ $guia_remision->cliente->id }}" selected>
                                            {{ $guia_remision->cliente->nombre }}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente"><i
                                                class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Almacén:</strong></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control"
                                    value="{{ $guia_remision->almacen->nombre }} - {{ $guia_remision->almacen->abreviatura }}"
                                    readonly ="" id="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4"><strong>F. Emis.:</strong></label>
                                    <div class="col-md-8">
                                        <input type="text" style="font-size: 12px" name="fecha_emision"
                                            class="form-control" value="{{ $guia_remision->fecha_emision }}" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">F.Entrega:</label>
                                    <div class="col-md-8">
                                        <input type="date" name="fecha_entrega" class="form-control"
                                            required="required" value="{{ $guia_remision->fecha_entrega }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Sucursal:</strong></label>
                            <div class="col-md-10">
                                <div class="tooltip-demo">
                                    <div class="input-group-prepend" style="column-gap: 10px">
                                        <input list="sucursal_list" id="sucursal_input" name="sucursal_cli"
                                            data-toggle="tooltip" class="form-control" data-placement="top"
                                            title="Sucursal" required onchange="select_sucursal()" style="width: 65%"
                                            autocomplete="off" value="{{ $guia_remision->sucursal_cliente }}">
                                        <datalist id="sucursal_list">
                                            {{-- <option value=""></option> --}}
                                        </datalist>
                                        <input id="postal_input" class="form-control" name="postal_input"
                                            style="width: 25%" data-toggle="tooltip" data-placement="top"
                                            title="Codigo Ubigeo" required maxlength="6" minlength="6"
                                            value="{{ $guia_remision->cod_postal_cliente }}"
                                            onkeyup="this.value=NumText(this.value)">
                                        <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html"
                                            target="_blank" style="margin: auto"><i class="fa fa-question-circle"
                                                style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999"></i></a>
                                    </div>
                                    <input type="hidden" name="" id="input_suc_array">
                                    <input type="hidden" name="" id="input_post_array">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Motivo T.:</strong></label>
                            <div class="col-md-10">
                                <select name="motivo_traslado" class="form-control">
                                    @foreach ($motivo_traslado as $motivo_traslad)
                                        <option id="{{ $motivo_traslad->nombre }}"
                                            @if ($guia_remision->motivo_traslado == $motivo_traslad->nombre) selected @endif>
                                            {{ $motivo_traslad->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Transporte asignado  (PÚBLICO )* --}}
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Transporte:</strong></label>
                            <div class="col-md-10">
                                <select class="form-control" name="tipo_transporte" autocomplete="off"
                                    onchange="test(this)" id="select_id" required>
                                    <option value="">Escoge el tipo de transporte</option>
                                    {{-- <option value="0">Sin Transporte</option> --}}
                                    <option value="1" @if ($guia_remision->tipo_transporte == 1) selected @endif>Transporte
                                        Público</option>
                                    <option value="2" @if ($guia_remision->tipo_transporte == 2) selected @endif>
                                        Transaporte Privado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row" id="transporte_publico"
                            @if ($guia_remision->tipo_transporte != 1) hidden="hidden" @endif>
                            <label class="col-form-label col-md-1"><strong>V. Público:</strong></label>
                            <div class="col-md-11">
                                <select class="form-control" name="vehiculo_publico" autocomplete="off"
                                    id="vehiculo_publico">
                                    <option value="">Ningún Vehículo</option>
                                    @foreach ($transporte_publico as $transporte_publicos)
                                        <option value="{{ $transporte_publicos->id }}"
                                            @if ($guia_remision->vehiculo_publico == $transporte_publicos->id) selected @endif>
                                            {{ $transporte_publicos->nombre }} /{{ $transporte_publicos->ruc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" id="transporte_privado"
                            @if ($guia_remision->tipo_transporte != 2) hidden="hidden" @endif>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>V. Privado:</strong></label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="vehiculo" autocomplete="off"
                                            id="vehiculo_privado">
                                            <option value="">Ningún Vehículo</option>
                                            @foreach ($vehiculo as $vehiculos)
                                                <option value="{{ $vehiculos->id }}" @if($guia_remision->vehiculo_id == $vehiculos->id) selected @endif>{{ $vehiculos->placa }}
                                                    /{{ $vehiculos->marca }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Conductor:</strong></label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="conductor" autocomplete="off"
                                            id="conductor">
                                            <option value="">Ningún Conductor</option>
                                            @foreach ($personal as $ersonals)
                                                <option disabled="disabled">------------------------------</option>
                                                <option value="{{ $ersonals->id }}" @if($guia_remision->conductor_id == $ersonals->id) selected @endif>{{ $ersonals->nombres }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-form-label col-md-1"><strong>Observación:</strong></label>
                            <div class="col-md-11">
                                <textarea name="observacion" class="form-control" rows="1s">{{ $guia_remision->observacion }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table " id="table-edit-remision">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">
                                            {{-- <input class='check_all' type='checkbox'
                                                        onclick="select_all()" /> --}}
                                            <button type="button" class='addmore btn btn-sm btn-success'> <i
                                                    class="fa fa-plus-square" aria-hidden="true"></i> </button>
                                        </th>
                                        <th style="width: 600px">Artículo</th>
                                        <th style="width: 100px">Stock</th>
                                        <th style="width: 100px">Cantidad</th>
                                        <th style="width: 500px">Números Series</th>
                                        <th style="width: 100px">Peso (KGM)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($guia_registro as $index => $registros_g)
                                        <tr>
                                            <td>
                                                {{-- <input type='checkbox' class="case"> --}}
                                                <button type="button" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                            <td class="td_selected">
                                                <select class="select2_demo_productos" name="articulo[]"
                                                    @if ($index == 0) id="articulo" @else id="articulo{{ $index }}" @endif
                                                    style="width: 100%;" onchange="ajax({{ $index }});"
                                                    required>
                                                    <option value="{{ $registros_g->producto->id . ' | ' . $registros_g->producto->codigo_producto . ' | ' . $registros_g->producto->codigo_original . ' | ' . $registros_g->producto->nombre }}">{{ $registros_g->producto->id . ' | ' . $registros_g->producto->codigo_producto . ' | ' . $registros_g->producto->codigo_original . ' | ' . $registros_g->producto->nombre }}</option>
                                                </select>
                                                <textarea class="form-control" name="descripcion[]" placeholder="Detalle del Producto" id=""
                                                    rows="1" style="margin-top: 5px">{{ $registros_g->descripcion }}</textarea>
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" type='text'
                                                    id='stock{{ $index }}' readonly="readonly" name='stock[]'
                                                    class="form-control" required autocomplete="off"
                                                    value="{{ $registros_g->producto->stockAlmacenProducto($guia_remision->almacen->id)->stock }}" />
                                            </td>
                                            <td class="tooltip-demo">
                                                <input style="min-width: 100px" type='text'
                                                    id='cantidad{{ $index }}' name='cantidad[]'
                                                    max="" class="monto{{ $index }} form-control"
                                                    required autocomplete="off" data-placement="top"
                                                    title="No se puede procesar productos con stock '0'"
                                                    onchange="peso_cantidad({{ $index }})"
                                                    value="{{ $registros_g->cantidad }}" />
                                            </td>
                                            <td>
                                                <textarea style="min-width: 250px" name="series[]" id="series{{ $index }}" class="form-control prod_text"
                                                    placeholder="escanear N/S">{{ $registros_g->numero_serie }}</textarea>
                                            </td>
                                            <td>
                                                <input style="min-width: 100px" id='peso{{ $index }}'
                                                    name='peso[]' type="text" class="form-control"
                                                    value="{{ $registros_g->peso }}" readonly="readonly">
                                                <input type="hidden" id="peso_base{{ $index }}" value="{{explode(' ',$registros_g->producto->peso)[0]}}">
                                            </td>

                                            <span id="spTotal"></span>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button data-style="zoom-out" id="guardar" name="boton"
                                class="guardar button-lada-guardar btn btn-primary btn-outline"
                                type="button">Guardar</button>
                            <button class="btn btn-primary float-right button-lada-finalizar"
                                style="margin-left: 10px;" type="button" id="finalizar">Guardar y
                                Finalizar</button>

                            <button type="submit" id="button_submit" hidden name="button_submit"
                                value="0"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
