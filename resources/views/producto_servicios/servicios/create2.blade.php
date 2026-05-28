<div id="NuevoServicio" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1100px;">
        <div class="modal-content">
            <form id="form-servicio" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header d-flex align-items-center">
                    <h2 class="model-title" id="TituloProducto"><b style="font-weight: bold;">Nuevo Servicio</b></h2>
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
                                                placeholder="Código generado automáticamente" id="codigo_servicio"
                                                name="" value="">
                                            <input type="hidden" id="codigo_producto_display" value="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Código original -->
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center" id="form_group_cod_original">
                                        <label class="col-md-3 col-form-label"><strong>Cod. Orig.</strong></label>
                                        <div class="col-md-9">
                                            <input type="text" name="codigo_original" id="codigo_original_create"
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
                                            <input type="text" class="form-control" placeholder="Nombre del Servicio"
                                                required id="nombre_create" autocomplete="off">
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
                                            <input type="text" class="form-control" id="descripcion_create"
                                                placeholder="Ingresa la descripcion">
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
                                            <select id="familia_id_create" required="required"
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
                                            <select class="form-control subfamilia_select2" id="subfamilia_create">
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
                            {{-- MARCA Y DESCUENTO --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Marca</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <select id="marca_id_create" class="form-control marca_select2" required
                                                style="z-index: 9999999;width: 10px !important;">>
                                                @foreach ($marcas as $marca)
                                                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                                @endforeach
                                            </select>
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
                                                    value="0" autocomplete="off" required="required"
                                                    max="100" step="0.01" id="descuento_create"
                                                    data-original-title="Descuento Adicional">
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
                                                    title="" class="form-control input_valor_numerico "
                                                    autocomplete="off" required="required" step="0.01"
                                                    id="precio_nacional_create">
                                                @if ($moneda->where('principal', '1')->where('tipo', 'nacional')->count())
                                                    <div class="input-group-addon" style="padding: 0px; !important">
                                                        <div class="tooltip-demo">
                                                            <i class="fa fa-check-circle text-success"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                style="padding: 10px; !important"
                                                                data-original-title="Moneda Principal del Sistema"></i>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="precio_principal">
                                                    <script>
                                                        var moneda_principal = "nacional";
                                                    </script>
                                                @endif
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
                                                    title="" class="form-control input_valor_numerico"
                                                    autocomplete="off" required="required" step="0.01"
                                                    id="precio_extranjero_create">
                                                @if ($moneda->where('principal', '1')->where('tipo', 'extranjera')->count())
                                                    <div class="input-group-addon" style="padding: 0px; !important">
                                                        <div class="tooltip-demo">
                                                            <i class="fa fa-check-circle text-success"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                style="padding: 10px; !important"
                                                                data-original-title="Moneda Princial del Sistema"></i>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="precio_principal">
                                                    <script>
                                                        var moneda_principal = "extranjera";
                                                    </script>
                                                @endif
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
                                                <input type="text" id="sumando_create"
                                                    class="form-control input_valor_numerico" required="required"
                                                    value="0" autocomplete="off">
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
                                        <span class="text-center">Puede colocar su precio venta
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
                                            <input type="text" class="border-0 form-control input-s-lg"
                                                placeholder="{{ $moneda->where('principal', '1')->pluck('simbolo')->first() }}"
                                                id="precio_compra_create">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de Venta +
                                                    IGV</b></label>
                                            <input type="text" class="border-0 form-control input-s-lg"
                                                placeholder="{{ $moneda->where('principal', '1')->pluck('simbolo')->first() }}"
                                                id="precio_venta_create">
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
                                                id="" value="{{ date('d-m-Y') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for=""
                                            class="col-form-label col-md-3"><strong>Afectación</strong></label>
                                        <div class="col-md-9">
                                            <select id="tipo_afectacion_create"
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
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary ladda-button"
                            id="store_servicio">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .select2.select2-container.select2-container--default {
        width: 100% !important;
        height: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        height: 100% !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px !important;
    }

    #div_ayuda_utilidad {
        display: none;
    }

    .select2-container .select2-dropdown {
        z-index: 20000 !important;
    }

    .tooltip {
        z-index: 100000000;
    }
</style>
{{-- {{$tipo_cambio->fecha}} --}}
<script>
    $(document).ready(function() {
        console.log(moneda_principal);
        $('.familia_select2').select2({
            placeholder: "Seleccionar"
        });
        $('.subfamilia_select2').select2({
            placeholder: "Seleccionar"
        });
        $('.marca_select2').select2();
        // $('.garantia_select2').select2();
        // $('.unidad_medida_select2').select2();
        $('.afectacion_select2').select2();
    });

    function list_subfamilia() {
        var family = $('.familia_select2').val();
        $('.subfamilia_select2').val(null).trigger('change');

        // console.log(family);
        $('.subfamilia_select2').select2({
            placeholder: "Seleccionar",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('subfamilia.search_ajax') }}",
                dataType: 'json',
                type: "POST",
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        familia_id: family
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.descripcion,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    }
    $('#porcentaje_utilidad').on('click', function(e) {
        $('#div_ayuda_utilidad').toggle();
    })

    function validarExtCreate() {
        var archivoInputCreate = document.getElementById('archivoInputCreate');
        var archivoRutaCreate = archivoInputCreate.value;
        var extPermitidasCreate = /(.jpg|.png|.jfif)$/i;

        if (!extPermitidasCreate.exec(archivoRutaCreate)) {
            alert('Asegúrese de haber seleccionado una imagen válida (.jpg, .png, .jfif)');
            archivoInputCreate.value = '';
            return false;
        }

        if (archivoInputCreate.files && archivoInputCreate.files[0]) {
            var visor = new FileReader();
            visor.onload = function(e) {
                var img = document.getElementById('fotoPreviaCreate');
                img.onload = function() {
                    const esHorizontal = img.naturalWidth > img.naturalHeight;

                    if (esHorizontal) {
                        // Si es horizontal, se ajusta a mayor ancho
                        img.style.width = "70%";
                        img.style.height = "auto";
                    } else {
                        // Si es vertical, se prioriza altura
                        img.style.height = "250px";
                        img.style.width = "auto";
                    }
                };
                img.src = e.target.result;
            };
            visor.readAsDataURL(archivoInputCreate.files[0]);
        }
    }

    $('#store_servicio').on('click', function(e) {
        e.preventDefault();
        var form = $('#form-servicio')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        // e.preventDefault();
        var formData = new FormData();
        formData.append('codigo', $('#codigo_original_create').val());
        formData.append('nombre', $('#nombre_create').val());
        formData.append('descripcion', $('#descripcion_create').val());
        formData.append('familia_id', $('#familia_id_create').val());
        formData.append('subfamilia_id', $('#subfamilia_create').val());
        formData.append('marca_id', $('#marca_id_create').val());
        formData.append('precio_nacional', $('#precio_nacional_create').val());
        formData.append('precio_extranjero', $('#precio_extranjero_create').val());
        formData.append('utilidad', $('#sumando_create').val());
        formData.append('afectacion_id', $('#tipo_afectacion_create').val());
        if ($('#archivoInputCreate')[0].files.length > 0) {
            formData.append('foto', $('#archivoInputCreate')[0].files[0]);
        }
        var submitBtn = $(this);
        submitBtn.prop('disabled', true).val('Guardando...');

        $.ajax({
            url: `{{ route('servicios.store') }}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#NuevoServicio').modal('hide');
                    form.reset();
                    $('#familia_id_create').val(null).trigger('change');
                    $('.dataTables-example').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                var errorMessage = 'Error al crear el servicio';

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorList = [];

                    for (var field in errors) {
                        errorList.push(errors[field][0]);
                    }

                    errorMessage += ':\n' + errorList.join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += ': ' + xhr.responseJSON.message;
                }

                // Mostrar el error al usuario
                alert(errorMessage);
            },
            complete: function() {
                submitBtn.prop('disabled', false).val('Guardar');
            }
        });
    });

    var tipo_cambio = parseFloat(`{{ $tipo_cambio->paralelo }}`) || 1;
    var igv_create = `{{ $igv->igv_total }}`;

    function calcular_precios_create() {
        if (moneda_principal == "nacional") {
            var precio_principal = $('#precio_nacional_create').val();
        } else {
            var precio_principal = $('#precio_extranjero_create').val();
        }
        const descuento = parseFloat($("#descuento_create").val()) || 0;
        const utilidad = parseFloat($("#sumando_create").val()) || 0;
        const igv = parseFloat(igv_create) || 0;

        let precio_compra = parseFloat(precio_principal) || 0;
        precio_compra = precio_compra + (precio_compra * (utilidad / 100));
        $('#precio_compra_create').val(precio_compra.toFixed(2));
        // + IGV
        const total_venta =
            precio_compra + (precio_compra * (igv / 100));
        $('#precio_venta_create').val(total_venta.toFixed(2));
        // Disparar evento input para que se actualicen cálculos
    }

    $('#precio_nacional_create').on('input', function() {
        if (actualizando) return;
        actualizando = true;
        let nacional = parseFloat($(this).val()) || 0;
        let extranjero = nacional / tipo_cambio;
        // actualizar extranjero
        $('#precio_extranjero_create').val(
            extranjero.toFixed(2)
        );
        // actualizar principal
        if (moneda_principal === 'nacional') {
            $('#precio_principal').val(nacional.toFixed(2));
        } else {
            $('#precio_principal').val(extranjero.toFixed(2));
        }
        actualizando = false;
        calcular_precios_create();
    });

    $('#precio_extranjero_create').on('input', function() {
        if (actualizando) return;
        actualizando = true;
        let extranjero = parseFloat($(this).val()) || 0;
        let nacional = extranjero * tipo_cambio;
        // actualizar nacional
        $('#precio_nacional_create').val(
            nacional.toFixed(2)
        );
        // actualizar principal
        if (moneda_principal === 'nacional') {
            $('#precio_principal').val(nacional.toFixed(2));
        } else {
            $('#precio_principal').val(extranjero.toFixed(2));
        }
        actualizando = false;
        calcular_precios_create();
    });
    $('#sumando_create').on('input', function() {
        calcular_precios_create();
    });

    function calcular_utilidad_create() {

        const precioPrincipal =
            parseFloat($('#precio_principal').val()) || 0;
        const precioCompra =
            parseFloat($('#precio_compra_create').val()) || 0;

        if (precioPrincipal <= 0 || precioCompra <= 0) {
            $('#sumando_create').val('');
            return;
        }
        const utilidad =
            ((precioCompra - precioPrincipal) / precioPrincipal) * 100;

        $('#sumando_create').val(
            utilidad.toFixed(2)
        );
    }
    $('#precio_compra_create').on('input', function() {

        if (actualizando) return;

        actualizando = true;

        const precioCompra =
            parseFloat($(this).val()) || 0;

        const igv =
            parseFloat(igv_create) || 0;

        // calcular venta
        const precioVenta =
            precioCompra + (precioCompra * (igv / 100));

        $('#precio_venta_create').val(
            precioVenta.toFixed(2)
        );

        calcular_utilidad_create();

        actualizando = false;

    });
    $('#precio_venta_create').on('input', function() {

        if (actualizando) return;

        actualizando = true;

        const precioVenta =
            parseFloat($(this).val()) || 0;

        const igv =
            parseFloat(igv_create) || 0;

        // quitar IGV
        const precioCompra =
            precioVenta / (1 + (igv / 100));

        $('#precio_compra_create').val(
            precioCompra.toFixed(2)
        );

        calcular_utilidad_create();

        actualizando = false;

    });
</script>
