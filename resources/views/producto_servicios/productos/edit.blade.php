<div id="EditProducto" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 900px;">>
        <div class="modal-content">
            <form action="">
                @csrf
                <div class="modal-header d-flex align-items-center">
                    <h2 class="model-title" id="TituloProducto"><b>Editar Producto <span id="codigo_header"></span></b>
                    </h2>
                    @if (isset($producto))
                        <input type="checkbox" class="js-switch" id="edit_estado_id" name="edit_estado_id"
                            {{ $producto->estado_id == 1 ? 'checked' : '' }}>
                    @endif
                </div>
                <div class="modal-body">
                    <div class="scroll_content">
                        <div class="form-label word-style tooltip-demo" style="margin-left: 8px; margin-right: 8px">
                            {{-- CODIGO Y CODIGO ORIGINAL --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Código</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="edit_codigo" value=""
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Cod.
                                                Orig.</strong><span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="edit_codigo_original"
                                                value="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- NOMBRE --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-2"><strong>Nombre</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="edit_nombre" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- DESCRIPCION --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3 col-lg-2"><strong>Descripción</strong></label>
                                        <div class="col-md-9 col-lg-10">
                                            <input type="text" class="form-control" id="edit_descripcion">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- MARCA Y PESO --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Marca</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <select class="form-control marca_select2" id="edit_marca" required>
                                                @foreach ($marcas as $marca)
                                                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Peso</strong></label>
                                        <div class="col-sm-10 col-md-9">
                                            <div class="row">
                                                <div class="col-sm-6" style="padding-right: 0px">
                                                    <input type="number" class="form-control" name="peso"
                                                        required="required" step="0.01" min="0"
                                                        id="edit_peso_cantidad" autocomplete="off" value="0">
                                                </div>
                                                <div class="col-sm-6" style="padding-left: 0px">
                                                    <select class="form-control" name="peso_unidad"
                                                        id="edit_peso_unidad" style="height: 2.2rem;">
                                                        <option value="Miligramos">Miligramos</option>
                                                        <option value="Gramos">Gramos</option>
                                                        <option value="Kilos">Kilos</option>
                                                        <option value="Toneladas">Toneladas</option>
                                                        <option value="Litros">Litros</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- FAMILIA Y SUBFAMILIA --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Familia</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <select name="" id="edit_familia"
                                                class="form-control familia_select2" required
                                                onchange="edit_list_subfamilia()">
                                                <option value=""></option>
                                                @foreach ($familias as $familia)
                                                    <option value="{{ $familia->id }}">{{ $familia->descripcion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>SubFamilia</strong></label>
                                        <div class="col-md-9">
                                            <select name="" id="edit_subfamilia"
                                                class="form-control subfamilia_select2">
                                                @foreach ($subfamilias as $subfamilia)
                                                    <option value="{{ $subfamilia->id }}">
                                                        {{ $subfamilia->descripcion }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- STOCK MINIMO Y MAXIMO --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Stock
                                                Mín.</strong></label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="edit_stock_minimo"
                                                name="stock_minimo" min="0" autocomplete="off"
                                                value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Stock
                                                Max.</strong></label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="stock_maximo"
                                                id="edit_stock_maximo" min="0" required autocomplete="off"
                                                value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- DESCUENTO 1 Y DESCUENTO 2 --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Desc.
                                                1</strong></label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="number" data-toggle="tooltip" data-placement="top"
                                                    title="" class="form-control input_valor_numerico"
                                                    name="descuento1" value="0" autocomplete="off"
                                                    required="required" max="100" step="0.01"
                                                    id="edit_descuento_1"
                                                    data-original-title="Descuenta internamente, de forma automática">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Desc.
                                                2</strong></label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="number" class="form-control input_valor_numerico"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    name="descuento2" required="required" value="0"
                                                    autocomplete="off" max="100" step="0.01"
                                                    id="edit_descuento_2"
                                                    data-original-title="Forma de Descuento en  Cotizaciones, Facturas">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- DESCUENTO MAXIMO Y ORIGEN --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Desc.
                                                Max.</strong></label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control input_valor_numerico"
                                                    name="descuento_maximo" required="required" value="0"
                                                    autocomplete="off" max="100" step="0.01"
                                                    id="edit_descuento_max">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="origen"
                                            class="col-form-label col-md-3"><strong>Origen</strong></label>
                                        <div class="col-sm-11 col-md-9">
                                            <select name="origen" id="edit_origen" class="form-control" required>
                                                <option value="Producto Nacional">Producto Nacional</option>
                                                <option value="Producto Importado">Producto Importado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- UTILIDAD --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Utilidad</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="text" id="edit_utilidad"
                                                    class="form-control input_valor_numerico" name="utilidad"
                                                    required="required" value="0" autocomplete="off">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button type="button" id="porcentaje_utilidad_edit"
                                                class="btn btn-block btn-primary">¿En duda con su porcentaje de
                                                utilidad?</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- UTILIDAD | PRECIO COMPRA Y VENTA  +IGV --}}
                            <div id="div_ayuda_utilidad_edit">
                                <div class="row bg-light m-1 rounded-top rounded-bottom"
                                    style="padding-top: 10px;justify-content: center">
                                    <div class="col-md-12" style="text-align: center">
                                        <span class="text-center">Puede colocar su precio venta y el sistema calculará
                                            por ud.
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de
                                                    compra</b></label>
                                            <input type="text" class="border-0 form-control input-s-lg"
                                                placeholder="S/." id="edit_precio_compra"
                                                oninput="calcular_utilidad_edit()">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de Venta +
                                                    IGV</b></label>
                                            <input type="text" class="border-0 form-control input-s-lg"
                                                placeholder="S/." id="edit_precio_venta"
                                                oninput="calcular_utilidad_edit()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- GARANTIA Y AFECTACION --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Garantia</strong></label>
                                        <div class="col-md-9">
                                            <input type="text" id="edit_garantia" name="garantia"
                                                class="form-control" required="required" value="12 meses"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Afectación</strong></label>
                                        <div class="col-md-9">
                                            <select name="tipo_afectacion" id="edit_tipo_afectacion"
                                                class="form-control afectacion_select2">
                                                @foreach ($tipo_afectacion as $afectacion)
                                                    <option value="{{ $afectacion->id }}">
                                                        {{ $afectacion->informacion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- UD MEDIDA Y FECHA --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Ud
                                                Medida</strong></label>
                                        <div class="col-md-9">
                                            <select name="unidad_medida_id" id="edit_unidad_medida"
                                                class="form-control unidad_medida_select2">
                                                @foreach ($unidad_medidas as $unidad)
                                                    <option value="{{ $unidad->id }}">{{ $unidad->medida }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Fecha</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly name=""
                                                id="edit_fecha" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-form-label col-md-2">Ficha</label>
                                <div class="col-md-10">
                                    <div class="custom-file">
                                        <input id="logo" type="file" class="custom-file-input">
                                        <label for="logo" class="custom-file-label">Selecciona</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center">
                                <label for="" class="col-form-label col-md-2">Imagen</label>
                                <div class="col-md-9 bg-light align-items-right">
                                    <input type="file" id="archivoInput" name="avatar"
                                        onchange="return validarExt()">
                                    <input name="avatar_respaldo" value="defecto_avatar.jpg" hidden>
                                    <div id="visorArchivo" class="d-flex justify-content-center">
                                        <img id="fotoPrevia" name="foto_editar"
                                            src="{{ asset('img/logos/imagen-subir1.svg') }}"
                                            class="img-fluid hover-zoom" style="padding: 10px; width: 30%;">
                                    </div>
                                </div>
                            </div>
                            <!--
                                <div id="visorArchivo">
                                    <img style="padding: 20px; width: 50%;" class="img-fluid" src="{{ asset('img/logos/categoria.svg') }}">
                                </div>
                                -->
                            <!--
                            <div class="col-md-4">
                                <h2>Subir Imagen</h2>
                            </div>
                            -->

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary ml-3" value="Guardar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
