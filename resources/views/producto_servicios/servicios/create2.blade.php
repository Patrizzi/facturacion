<div id="NuevoServicio" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 900px;">
        <div class="modal-content">
            <form id="form-producto" action="{{ route('productos.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header d-flex align-items-center">
                    <h2 class="model-title" id="TituloProducto"><b style="font-weight: bold;">Nuevo Producto</b></h2>
                    <input type="checkbox" class="js-switch-1" checked>
                </div>
                <div class="modal-body">
                    <div class="scroll_content">
                        <div class="form-label word-style tooltip-demo" style="margin-left: 8px; margin-right: 8px">
                            <!-- Código autogenerado -->
                            <div class="row">
                                <!-- Código -->
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-3 col-form-label"><strong>Código</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" readonly
                                                value=""
                                                placeholder="Código generado automáticamente" id="codigo_producto"
                                                name="   ">
                                            <input type="hidden" id="codigo_producto_display"
                                                value="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Código original -->
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center" id="form_group_cod_original">
                                        <label class="col-md-3 col-form-label"><strong>Cod. Orig.</strong></label>
                                        <div class="col-md-9">
                                            <input type="text" name="codigo_original" id="codigo_original"
                                                class="form-control @error('codigo_original') is-invalid @enderror"
                                                value="{{ old('codigo_original') }}"
                                                placeholder="Ingresa el código original" autocomplete="off">
                                            @error('codigo_original')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- NOMBRE -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-2 col-form-label"><strong>Nombre</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" placeholder="Nombre del Producto"
                                                required name="nombre" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- DESCRIPCION --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-2 col-form-label"><strong>Descripcion</strong></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="descripcion"
                                                name="descripcion" placeholder="Ingresa la descripcion">
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
                                        <div class="col-lg-9">
                                            <select id="marca_id" class="form-control marca_select2" name="marca_id"
                                                required>
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
                                                        autocomplete="off" value="0">
                                                </div>
                                                <div class="col-sm-6" style="padding-left: 0px">
                                                    <select class="form-control" name="unidad_medida" id=""
                                                        style="height: 2.2rem;">
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
                                            <select name="familia_id" id="familia_id_sl" required="required"
                                                class="form-control familia_select2" onchange="list_subfamilia()">
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
                                            <select class="form-control subfamilia_select2" name="sub_familia_id">
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
                                            <input type="number" class="form-control" name="stock_minimo"
                                                min="0" autocomplete="off" value="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Stock
                                                Max.</strong></label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="stock_maximo"
                                                min="0" required autocomplete="off" value="0">
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
                                                    data-original-title="Descuenta internamente, de forma automática">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                            {{-- <input type="number" class="form-control" id ="descuento1"
                                                name="descuento1"> --}}
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
                                                    data-original-title="Forma de Descuento en  Cotizaciones, Facturas">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                            {{-- <input type="number" class="form-control" id="descuento1"
                                                name="descuento2"> --}}
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
                                                    autocomplete="off" max="100" step="0.01">
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
                                            <select name="origen" id="origen" class="form-control" required>
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
                                                <input type="text" id="sumando"
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
                                            <button type="button" id="porcentaje_utilidad"
                                                class="btn btn-block btn-primary">¿En duda con su porcentaje de
                                                utilidad?</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- UTILIDAD | PRECIO COMPRA Y VENTA  +IGV --}}
                            <div id="div_ayuda_utilidad">
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
                                                placeholder="S/." id="precio_compra"
                                                oninput="calcular_utilidad_create()">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de Venta +
                                                    IGV</b></label>
                                            <input type="text" class="border-0 form-control input-s-lg"
                                                placeholder="S/." id="precio_venta"
                                                oninput="calcular_utilidad_create()">
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
                                            <input type="text" id="garantia" name="garantia"
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
                                            <select name="tipo_afectacion" id="tipo_afectacion"
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
                                            <select name="unidad_medida_id" id="unidad_medida_id"
                                                class="form-control unidad_medida_select2">
                                                {{-- @foreach ($unidad_medidas as $unidad)
                                                    <option value="{{ $unidad->id }}">{{ $unidad->medida }}
                                                    </option>
                                                @endforeach --}}
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
                                                id="" value="{{ date('d-m-Y') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- FICHA TECNICA --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-2 col-form-label"><strong>Ficha Técnica</strong></label>
                                        <div class="col-md-10">
                                            <div class="custom-file">
                                                <input id="logo" type="file" class="custom-file-input"
                                                    name="archivo_producto">
                                                <label for="logo" class="custom-file-label">Selecciona</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- IMAGEN --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-2 col-form-label"><strong>Imagen</strong></label>
                                        <div class="col-md-10">
                                            <input type="file" id="archivoInputCreate" name="foto_producto"
                                                onchange="return validarExtCreate()">
                                            <input name="avatar_respaldo" value="defecto_avatar.jpg" hidden>
                                            <div id="visorArchivoCreate" class="d-flex justify-content-center">
                                                <img id="fotoPreviaCreate" name="foto"
                                                    src="{{ asset('img/logos/imagen-subir1.svg') }}"
                                                    class="img-fluid hover-zoom" style="padding: 10px; width: 30%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- DETALLE -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-2 col-form-label"><strong>Detalle</strong></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control"
                                                placeholder="Detalle del Producto" name="detalle" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary ladda-button">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
