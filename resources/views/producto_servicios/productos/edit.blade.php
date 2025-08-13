<div id="EditProducto" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header d-flex align-items-center">
                    <h2 class="model-title" id="TituloProducto"><b>Editar Producto</b></h2>
                    @if(isset($producto))
                    <input type="checkbox" class="js-switch" id="edit_estado_id" name="edit_estado_id"
                        {{ $producto->estado_id == 1 ? 'checked' : '' }}>
                    @endif
                </div>
                <div class="modal-body p-3">
                    <div class="scroll_content p-4">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-sm-2 col-lg-1">Nombre<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10  col-lg-11">
                                <input type="text" class="form-control" id="edit_nombre" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Código<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" id="edit_codigo" value=""
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-3">Cod. Original<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="edit_codigo_original"
                                            value="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Marca<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        {{-- <select class="form-control" id="edit_marca">
                                            <option value="Lenovo">Lenovo</option>
                                            <option value="LG">LG</option>
                                            <option value="Samsung">Samsung</option>
                                        </select> --}}
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
                                    <label for="" class="col-form-label col-sm-2 col-md-12 col-lg-3">Peso<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10 col-md-12 col-lg-9">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" id="edit_peso_cantidad"
                                                    step="0.01" min="0" value="" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="peso_unidad" id="edit_peso_unidad">
                                                    <option value="Kilos">Kilos</option>
                                                    <option value="Litros">Litros</option>
                                                    <option value="Gramos">Gramos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-sm-2 col-md-3">Origen<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10 col-md-9">
                                        {{--  <select name="" class="form-control" id="edit_origen" >
                                            <option value="">Producto Importado</option>
                                            <option value="">Producto Importado</option>
                                        </select> --}}
                                        <input type="text" class="form-control" id="edit_origen" value=""
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-sm-2 col-md-3">Stock<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10 col-md-9">
                                        <input type="number" class="form-control" id="edit_stock" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- stock min y max --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Stock Mínimo<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id ="edit_stock_minimo"
                                            min="1" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Stock Máximo<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id="edit_stock_maximo"
                                            min="1" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- descuento 1 y 2 --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Descuento 1<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id ="edit_descuento_1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Descuento 2<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id="edit_descuento_2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- descuento max y utilidad --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Descuento Max.<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id ="edit_descuento_max">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-4">Utilidad<span class="text-danger">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="number" class="form-control" id ="edit_utilidad">
                                    </div>

                                    <style>.fa-question-circle:hover{color: blue;}</style>
                                    <div class="col-lg-8">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" id="sumando" class="form-control input_valor_numerico" name="utilidad" required="required" value="{{$producto->utilidad}}">
                                        </div>
                                    </div>

                                </div>
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-3 col-lg-2">Unidad<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-9 col-lg-10">
                                        {{-- <select name="" id="edit_unidad" class="form-control">
                                            <option value="NIU">(NIU) Unidad</option>
                                            <option value="Unidad">Unidad</option>
                                        </select> --}}
                                        <select name="" id="edit_unidad_medida" class="form-control" required>
                                            @foreach ($unidad_medidas as $unidad)
                                                <option value="{{ $unidad->id }}">{{ $unidad->medida }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-3">Garantía<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="edit_garantia" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-lg-2">Familia<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        {{--  <select name="" id="" class="form-control">
                                            <option value="">Familia</option>
                                            <option value="">Familia</option>
                                        </select> --}}
                                        <select name="" id="edit_familia" class="form-control familia_select2"
                                            required>
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
                                    <label for="" class="col-form-label col-lg-3">SubFamilia<span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        {{-- <select name="" id="" class="form-control">
                                            <option value="">SubFamilia</option>
                                            <option value="">SubFamilia</option>
                                        </select> --}}
                                        <select name="" id="edit_subfamilia"
                                            class="form-control subfamilia_select2" required>
                                            @foreach ($subfamilias as $subfamilia)
                                                <option value="{{ $subfamilia->id }}">{{ $subfamilia->descripcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-2">
                                <label for="" class="col-form-label">Precio de Venta<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-12 col-lg-10">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="input-group m-b">
                                            <div class="input-group-prepend">
                                                <select name="" id="" class="btn btn-white">
                                                    <option value="">S/.</option>
                                                    <option value="">$</option>
                                                </select>
                                            </div>
                                            <input type="number" class="form-control" id="edit_precio_venta"
                                                min="0.01" step="0.01" oninput="calcular_utilidad()">
                                        </div>
                                    </div>
                                    <div class="col-md-2"><i class="fa fa-question-circle"></i></div>
                                </div>
                                <div class="row m-1 bg-light d-flex align-items-center rounded-top rounded-bottom">
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de compra<span
                                                        class="text-danger">*</span></b></label>
                                            <input type="text" class="border-0 form-control input-s-lg"
                                                placeholder="S/." id="edit_precio_compra" oninput="calcular_utilidad()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            {{-- <label for="" class="col-form-label"><b>Utilidad %</b></label>
                                            <input type="text" class="form-control input-s-lg" data-mask="99.99 %" placeholder="%" id="edit_utilidad"> --}}
                                            <label for="" class="col-form-label"><b>Utilidad %</b></label>
                                            <input type="text" class="form-control input-s-lg" placeholder="%"
                                                id="edit_utilidad">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Utilidad S/.</b></label>
                                            <input type="text" class="form-control input-s-lg"
                                                data-mask=" S/. 999,999,999.99" placeholder="S/.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group row mt-3">
                            <label for="" class="col-form-label col-md-2">Impuesto</label>
                            <div class="col-md-10">
                                <input type="number" class="form-control" value="IGV (18.00%)" min="0.01" step="0.01">
                            </div>
                        </div> --}}
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
                                    <img id="fotoPrevia" name="foto_editar  "
                                        src="{{ asset('img/logos/imagen-subir1.svg') }}" class="img-fluid hover-zoom"
                                        style="padding: 10px; width: 30%;">
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
                        <div class="form-group row">
                            <label for="" class="col-form-label col-md-3 col-lg-2">Descripción</label>
                            <div class="col-md-9 col-lg-10">
                                <input type="text" class="form-control" id="edit_descripcion">
                            </div>
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
