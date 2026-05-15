<div id="ModalFormVerProducto" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="VerTituloProducto">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 1200px;">
        <div class="modal-content" style="height: 120% !important">
            <form action="">
                @csrf
                <div class="modal-header d-flex align-items-center">
                    <h2 class="model-title" id="VerTituloProducto"><b><span id="codigo_header_show"></span></b></h2>
                    <span class="label label-plain" id="estado_ver">Activo</span>
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
                                            <input type="text" class="form-control" id="ver_codigo" value=""
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Cod.
                                                Orig.</strong><span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="ver_codigo_original"
                                                value="" readonly>
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
                                            <input type="text" class="form-control" id="ver_nombre" readonly>
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
                                            <input type="text" class="form-control" id="ver_descripcion" readonly>
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
                                            <input type="text" readonly class="form-control" value=""
                                                name="" id="ver_marca">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Peso</strong></label>
                                        <div class="col-sm-10 col-md-9">
                                            <input type="text" readonly class="form-control" value=""
                                                name="" id="ver_peso_unidad">
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
                                            <input type="text" class="form-control" readonly id="ver_familia">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>SubFamilia</strong></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" readonly id="ver_subfamilia">
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
                                            <input type="number" class="form-control" id="ver_stock_minimo"
                                                name="stock_minimo" min="0" autocomplete="off" readonly
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
                                                id="ver_stock_maximo" min="0" required autocomplete="off"
                                                value="0" readonly>
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
                                                    required="required" max="100" step="0.01" readonly
                                                    id="ver_descuento_1"
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
                                                    id="ver_descuento_2" readonly
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
                                                    autocomplete="off" max="100" step="0.01" readonly
                                                    id="ver_descuento_max">
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
                                            <input type="text" class="form-control" readonly id="ver_origen" >
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
                                                <input type="text" class="form-control input_valor_numerico" readonly id="ver_utilidad" >
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    {{-- <div class="form-group row">
                                        <div class="col-md-12">
                                            <button type="button" id="porcentaje_utilidad_ver"
                                                class="btn btn-block btn-primary" >¿En duda con su porcentaje de
                                                utilidad?</button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            {{-- UTILIDAD | PRECIO COMPRA Y VENTA  +IGV --}}
                            <div id="div_ayuda_utilidad_ver">
                                <div class="row bg-light m-1 rounded-top rounded-bottom"
                                    style="padding-top: 10px;justify-content: center">
                                    <div class="col-md-12" style="text-align: center">
                                        <span class="text-center">Calculo aproximado del precio</del>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de
                                                    compra</b></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">S/.</span>
                                                </div>
                                                <input type="text" class="border-0 form-control input-s-lg"
                                                    id="ver_precio_compra" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de Venta +
                                                    IGV</b></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">S/.</span>
                                                </div>
                                                <input type="text" class="border-0 form-control input-s-lg"
                                                id="ver_precio_venta" readonly
                                                oninput="calcular_utilidad_ver()">
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- GARANTIA Y AFECTACION --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Garantía</strong></label>
                                        <div class="col-md-9">
                                            <input type="text" id="ver_garantia" name="garantia"
                                                class="form-control" required="required" value="" readonly
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Afectación</strong></label>
                                        <div class="col-md-9">
                                            <input type="text" readonly class="form-control" name="" id="ver_tipo_afectacion">
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
                                            <input type="text"  class="form-control" name="" readonly  id="ver_unidad_medida">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Creación</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly name=""
                                                id="ver_fecha" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- FICHA TECNICA (Esto se ve en la misma tabla) --}}
                            {{-- IMAGEN --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-2 col-form-label"><strong>Imagen</strong></label>
                                        <div class="col-md-10">
                                            <div id="fotoIntupShow" class="foto_ver">
                                                <img src="{{ asset('img/logos/imagen-subir1.svg') }}" id="fotoPreviaShow" alt="" class="img-fluid" style="padding: 10px; width: 30%;">
                                            </div>
                                            {{-- <input type="file" id="fotoIntupEdit" name="foto_ver"
                                                onchange="return validarExtEdit()"> --}}
                                            {{-- <input name="avatar_respaldo" value="defecto_avatar.jpg" hidden> --}}
                                            {{-- <div id="visorArchivoEdit" class="d-flex justify-content-center">
                                                <img id="fotoPreviaEdit" name="foto_verar"
                                                    src="{{ asset('img/logos/imagen-subir1.svg') }}"
                                                    class="img-fluid hover-zoom" style="padding: 10px; width: 30%;">
                                            </div> --}}
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
                                                id="ver_detalle" name="detalle"
                                                autocomplete="off" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .foto_ver{
        width: 100%;
        padding: 10px;
        background-color: #f8f9fa;
        border: 2px solid #ced4da;
        border-radius: 6px;
        text-align: center;
    }
</style>