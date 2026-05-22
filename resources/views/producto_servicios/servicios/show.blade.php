<div id="ModalFormVerServicio" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1200px;">
        <div class="modal-content" style="height: 120% !important">>
            <div class="modal-header d-flex align-items-center">
                <h2 class="model-title" id="TituloProducto"><b style="font-weight: bold;">Ver Servicio</b></h2>
                {{-- <input type="checkbox" class="js-switch-1" checked> --}}
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
                                        <input type="text" class="form-control" readonly value=""
                                            placeholder="Código generado automáticamente" id="show_codigo_servicio"
                                            name="   ">
                                    </div>
                                </div>
                            </div>

                            <!-- Código original -->
                            <div class="col-md-6">
                                <div class="form-group row align-items-center" id="form_group_cod_original">
                                    <label class="col-md-3 col-form-label"><strong>Cod. Orig.</strong></label>
                                    <div class="col-md-9">
                                        <input type="text" name="codigo_original" id="codigo_original_show"
                                            class="form-control" readonly placeholder="Ingresa el código original"
                                            autocomplete="off">
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
                                        <input type="text" class="form-control" placeholder="Nombre del Servicio"
                                            required id="nombre_show" readonly autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- DESCRIPCION --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label class="col-md-2 col-form-label"><strong>Descripción</strong></label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" readonly id="descripcion_show"
                                            placeholder="Ingresa la descripcion">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- FAMILIA Y SUBFAMILIA --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-3"><strong>Familia</strong><span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="" readonly
                                            id="familia_show">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for=""
                                        class="col-form-label col-md-3"><strong>SubFamilia</strong></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" readonly name="" readonly
                                            id="sub_familia_show">
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- MARCA Y DESCUENTO --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-3"><strong>Marca</strong><span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" readonly name="" readonly
                                            id="marca_show">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="" class="col-form-label col-md-3"><strong>Desc.
                                        </strong></label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="number" data-toggle="tooltip" data-placement="top"
                                                title="" class="form-control input_valor_numerico"
                                                value="0" autocomplete="off" required="required" max="100"
                                                step="0.01" id="descuento_show" readonly
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
                        </div>
                        {{-- PRECIO EN DOLARES Y SOLES --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3" for=""><strong>P.
                                            Nacional</strong></label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-addon">{{ $moneda->where('tipo', 'nacional')->pluck('simbolo')->first() }}</span>
                                            </div>
                                            <input type="number" data-toggle="tooltip" data-placement="top"
                                                title="" class="form-control input_valor_numerico"
                                                autocomplete="off" required="required" step="0.01" readonly
                                                id="precio_nacional_show">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3" for=""><strong>P.
                                            Extranjero</strong></label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-addon">{{ $moneda->where('tipo', 'extranjera')->pluck('simbolo')->first() }}</span>
                                            </div>
                                            <input type="number" data-toggle="tooltip" data-placement="top"
                                                title="" class="form-control input_valor_numerico" readonly
                                                autocomplete="off" required="required" step="0.01"
                                                id="precio_extranjero_show">
                                        </div>
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
                                            <input type="text" id="sumando_show"
                                                class="form-control input_valor_numerico" required="required"
                                                value="0" autocomplete="off" readonly>
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="button" id="porcentaje_utilidad_edit"
                                            class="btn btn-block btn-primary">¿En duda con su porcentaje de
                                            utilidad?</button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        {{-- UTILIDAD | PRECIO COMPRA Y VENTA  +IGV --}}
                        <div id="div_ayuda_utilidad_show">
                            <div class="row bg-light m-1 rounded-top rounded-bottom"
                                style="padding-top: 10px;justify-content: center">
                                <div class="col-md-12" style="text-align: center">
                                    <span class="text-center">Calculo aproximado del precio
                                        <strong>({{ $moneda->where('principal', '1')->pluck('simbolo')->first() }})</strong>
                                        y el sistema
                                        calculará
                                        por ud.
                                    </span>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group text-center">
                                        <label for="" class="col-form-label"><b>Precio sin
                                                IGV</b></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon">{{$moneda->where('principal', '1')->pluck('simbolo')->first()}}</span>
                                            </div>
                                            <input type="text" class="border-0 form-control input-s-lg"
                                                id="precio_compra_show" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group text-center">
                                        <label for="" class="col-form-label"><b>Precio de Venta +
                                                IGV</b></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon">{{$moneda->where('principal', '1')->pluck('simbolo')->first()}}</span>
                                            </div>
                                            <input type="text" class="border-0 form-control input-s-lg"
                                                id="precio_venta_show" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        {{-- FECHA Y AFECTACION --}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for=""
                                        class="col-form-label col-md-3"><strong>Fecha</strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly name=""
                                            id="fecha_show" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for=""
                                        class="col-form-label col-md-3"><strong>Afectación</strong></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" readonly id="tipo_afectacion_show"
                                            name="" id="">
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
                                        <div id="fotoIntupShow" class="foto_ver">
                                            <img src="{{ asset('img/logos/imagen-subir1.svg') }}" id="fotoPreviaShow"
                                                alt="" class="img-fluid" style="padding: 10px; width: 30%;">
                                        </div>
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
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .foto_ver {
        width: 100%;
        padding: 10px;
        background-color: #f8f9fa;
        border: 2px solid #ced4da;
        border-radius: 6px;
        text-align: center;
    }
</style>

<script>

    $(document).on('click', '.ver-servicio', function() {
        // console.log("a");
        currentServicioId = $(this).data('id');

        var nombre = $(this).data('nombre');
        var codigo_servicio = $(this).data('codigo_servicio');
        var codigo_original = $(this).data('codigo_original');
        var familia_id = $(this).data('familia_id');
        var subfamilia_id = $(this).data('subfamilia_id');
        var marca_id = $(this).data('marca_id');
        var moneda_id = $(this).data('moneda_id');
        var precio_nacional = $(this).data('precio_nacional');
        var precio_extranjero = $(this).data('precio_extranjero');
        var utilidad = $(this).data('utilidad');
        var descuento = $(this).data('descuento');
        var descripcion = $(this).data('descripcion');
        var foto = $(this).data('foto');
        var tipo_afectacion_id = $(this).data('tipo_afectacion_id');
        var estado_anular = $(this).data('estado_anular');
        var fecha_creacion = $(this).data('fecha_creacion');
        var marca_name = $(this).data('marca_name');
        var familia_name = $(this).data('familia_name');
        var sub_familia_name = $(this).data('subfamilia_name');
        var tipo_afectacion = $(this).data('tipo_afectacion');

        $('#show_codigo_servicio').val(codigo_servicio);
        $('#codigo_original_show').val(codigo_original);
        $('#nombre_show').val(nombre);
        $('#descripcion_show').val(descripcion);
        $('#descuento_show').val(descuento);
        $('#precio_nacional_show').val(precio_nacional);
        $('#precio_extranjero_show').val(precio_extranjero);
        $('#sumando_show').val(utilidad);
        $('#fecha_show').val(fecha_creacion);
        $('#familia_show').val(familia_name);
        $('#marca_show').val(marca_name);
        $('#sub_familia_show').val(sub_familia_name);
        $('#tipo_afectacion_show').val(tipo_afectacion);
        
        $('#fotoPreviaEdit').attr('src', "{{ asset('/archivos/imagenes/servicios') }}/" + foto);
        
        // Precios
        // // let precio_nacional = parseFloat($(this).val()) || 0;
        // let precio_extranjero = precio_nacional / tipo_cambio;
        $('#precio_extranjero_show').val(precio_extranjero.toFixed(2));
        $('#precio_compra_show').val(precio_nacional);

        calcular_precios();


    });
    
    function calcular_precios() {
        var precio_venta = $("#precio_venta_show").val();
        var precio_compra = $("#precio_compra_show").val();

        // if (!isNaN(precio_venta) && !isNaN(precio_compra) && precio_venta !== "" && precio_compra !== "") {
        //     var a1 = parseFloat(precio_venta) * 100;
        //     var a2 = a1 / parseFloat(precio_compra);
        //     var utilidad = a2 - 100;
        //     $("#sumando_show").val(utilidad);
        // } else {
        //     $("#sumando_show").val("");
        // }

        // Precio venta + igv
        var total_venta = precio_compra * 1.18;
        $('#precio_venta_show').val(total_venta)

        // Disparar evento input para que se actualicen cálculos
        $("#precio_nacional_show").trigger("input");
    }
</script>
