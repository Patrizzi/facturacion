<div class="row">
    <div class="col-lg-12" style="margin-top: -5px">
        <div class="ibox-content p-xl" style="margin-bottom: 20px; padding-bottom: 50px">
            <form action="{{ route('remision_m.update', $guia_remision_m->id) }}" method="POST"
                enctype="multipart/form-data" id="form_update">
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
                            <h2 style="font-size: 19px">GUÍA REMISION ELECTRÓNICA</h2>
                            <h5>{{ $guia_remision_m->cod_guia }} </h5>
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
                                    <div class="input-group">
                                        <select class="select2_demo_client" name="cliente" id="cliente" required=""
                                            onchange="change_cli()">
                                            <option value="{{ $guia_remision_m->cliente->id }}" selected>
                                                {{ $guia_remision_m->cliente->nombre }}</option>
                                        </select>
                                        <div class="input-group-append">
                                            <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente"><i
                                                    class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Almacén:</strong></label>
                            <div class="col-md-10">
                                <select class="select2_demo_almacen" name="almacen" autocomplete="off"
                                    onchange="test(this)" id="almacen" required>
                                    @foreach ($almacen as $almacens)
                                        <option value="{{ $almacens->id }}"
                                            @if ($guia_remision_m->almacen_id == $almacens->id) selected @endif>{{ $almacens->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4"><strong>F. Emis.:</strong></label>
                                    <div class="col-md-8">
                                        <input type="text" style="font-size: 12px" name="fecha_emision"
                                            class="form-control" value="{{ $guia_remision_m->fecha_emision }}"
                                            readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">F.Entrega:</label>
                                    <div class="col-md-8">
                                        <input type="date" name="fecha_entrega" class="form-control"
                                            required="required" value="{{ $guia_remision_m->fecha_entrega }}">
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
                                            autocomplete="off" value="{{ $guia_remision_m->sucursal_cliente }}">
                                        <datalist id="sucursal_list">
                                            {{-- <option value=""></option> --}}
                                        </datalist>
                                        <input id="postal_input" class="form-control" name="postal_input"
                                            style="width: 25%" data-toggle="tooltip" data-placement="top"
                                            title="Codigo Ubigeo" required onkeyup="this.value=NumText(this.value)"
                                            maxlength="6" minlength="6"
                                            value="{{ $guia_remision_m->cod_postal_cliente }}">
                                        <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html"
                                            target="_blank" style="margin: auto"><i class="fa fa-question-circle"
                                                style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999"></i></a>
                                    </div>
                                    <input type="hidden" name="" id="input_suc_array" value="{{$guia_remision_m->sucursal_cliente }},">
                                    <input type="hidden" name="" id="input_post_array" value="{{$guia_remision_m->cod_postal_cliente }},">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2"><strong>Motivo T.:</strong></label>
                            <div class="col-md-10">
                                <select name="motivo_traslado" class="form-control">
                                    @foreach ($motivo_traslado as $motivo_traslad)
                                        <option id="{{ $motivo_traslad->nombre }}"
                                            @if ($guia_remision_m->motivo_traslado == $motivo_traslad->nombre) selected @endif>
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
                                    <option value="1" @if ($guia_remision_m->tipo_transporte == 1) selected @endif>Transporte
                                        Público</option>
                                    <option value="2" @if ($guia_remision_m->tipo_transporte == 2) selected @endif>
                                        Transaporte Privado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row" id="transporte_publico"
                            @if ($guia_remision_m->tipo_transporte != 1) hidden="hidden" @endif>
                            <label class="col-form-label col-md-1"><strong>V. Público:</strong></label>
                            <div class="col-md-11">
                                <select class="form-control" name="vehiculo_publico" autocomplete="off"
                                    id="vehiculo_publico">
                                    <option value="">Ningún Vehículo</option>
                                    @foreach ($transporte_publico as $transporte_publicos)
                                        <option value="{{ $transporte_publicos->id }}"
                                            @if ($guia_remision_m->vehiculo_publico == $transporte_publicos->id) selected @endif>
                                            {{ $transporte_publicos->nombre }} /{{ $transporte_publicos->ruc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" id="transporte_privado"
                            @if ($guia_remision_m->tipo_transporte != 2) hidden="hidden" @endif>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>V. Privado:</strong></label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="vehiculo" autocomplete="off"
                                            id="vehiculo_privado">
                                            <option value="">Ningún Vehículo</option>
                                            @foreach ($vehiculo as $vehiculos)
                                                <option value="{{ $vehiculos->id }}"
                                                    @if ($guia_remision_m->vehiculo_id == $vehiculos->id) selected @endif>
                                                    {{ $vehiculos->placa }}
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
                                                <option value="{{ $ersonals->id }}"
                                                    @if ($guia_remision_m->conductor_id == $ersonals->id) selected @endif>
                                                    {{ $ersonals->nombres }}
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
                                <textarea name="observacion" class="form-control" rows="1s">{{ $guia_remision_m->observacion }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
                </div>
                {{-- <div class="col-md-12"> --}}
                    <div class="table-responsive">
                        <table class="table tables " id="table-edit-remision">
                            <thead>
                                <tr>
                                    <th style="width: 10px">
                                        <button type="button" class='addmore btn btn-sm btn-success'> <i
                                                class="fa fa-plus-square" aria-hidden="true"></i> </button>
                                    </th>
                                    <th style="width: 600px">Artículo</th>
                                    <th style="width: 100px">Cantidad</th>
                                    <th style="width: 100px">Numero de Serie</th>
                                    <th style="width: 100px">Peso U. (KGM)</th>
                                    <th style="width: 100px">Peso T. (KGM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guia_remision_m->registros_m as $f => $registros)
                                    <tr>
                                        <td>
                                            <button type="button" class='delete borrar e btn btn-sm btn-danger'><i
                                                    class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                        <td class="td_selected">
                                            <select class="select2_demo_productos" name="articulo[]" id="articulo"
                                                style="width: 100%;" onchange="ajax({{$f}})" required>
                                                <option
                                                    value="{{ $registros->producto->id . ' | ' . $registros->producto->codigo_producto . ' | ' . $registros->producto->codigo_original . ' | ' . $registros->producto->nombre }}">
                                                    {{ $registros->producto->id . ' | ' . $registros->producto->codigo_producto . ' | ' . $registros->producto->codigo_original . ' | ' . $registros->producto->nombre }}
                                                </option>
                                            </select>
                                            <textarea class="form-control" name="descripcion[]" placeholder="Detalle del Producto" id=""
                                                rows="1" style="margin-top: 5px">{{ $registros->descripcion }}</textarea>
                                        </td>
                                        <td>
                                            <input style="min-width: 100px" type="text" name="cantidad[]"
                                                id="cantidad{{$f}}" class="form-control" required
                                                value="{{ $registros->cantidad }}"
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                onkeyup="peso_view_p({{$f}});sum_total()">
                                        </td>
                                        <td>
                                            <textarea style="min-width: 250px" name="serie[]" id="n_serie{{$f}}" class="form-control prod_text"
                                                placeholder="Numero de Serie">{{ $registros->numero_serie }}</textarea>
                                        </td>
                                        <td>
                                            <div class="input-group" style="min-width: 140px">
                                                <input type="text" name="peso[]" id="peso{{$f}}"
                                                    class="form-control" required step="0.01"
                                                    onkeypress="return event.charCode >= 46 && event.charCode <= 57"
                                                    onkeyup="peso_view_p({{$f}});sum_total()"
                                                    value="{{ $registros->peso }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-addon">KG</span>
                                                </div>
                                                <input style="min-width: 100px" type="hidden" name="peso_view"
                                                    id="peso_view{{$f}}" onkeyup="sum_total()" {{ $registros->peso }}>
                                                <input style="min-width: 100px" type="hidden" name="peso_ori"
                                                    id="peso_ori{{$f}}" onkeyup="sum_total()"
                                                    value="{{ $registros->peso }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group" style="min-width: 130px">
                                                <input type="text" name="peso_tot[]" step="0.01" disabled
                                                    id="peso_tot{{$f}}" class="form-control" required
                                                    onkeypress="return event.charCode >= 46 && event.charCode <= 57"
                                                    onkeyup="sum_total()"
                                                    value="{{ $registros->peso * $registros->cantidad }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-addon">KG</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button data-style="zoom-out" id="guardar" name="boton"
                            class="guardar button-lada-guardar btn btn-primary btn-outline"
                            type="button">Guardar</button>
                        <button class="btn btn-primary float-right button-lada-finalizar" style="margin-left: 10px;"
                            type="button" id="finalizar">Guardar y
                            Finalizar</button>

                        <button type="submit" id="button_submit" hidden name="button_submit"
                            value="0"></button>
                    </div>
                {{-- </div> --}}
            </form>
        </div>

    </div>
</div>
