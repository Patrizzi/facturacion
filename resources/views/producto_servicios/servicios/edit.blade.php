<div id="EditServicio" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
    data-keyboard="false" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 900px;">
        <div class="modal-content">
            <form id="form-servicio-edit" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header d-flex align-items-center">
                    <h2 class="model-title" id="TituloProducto"><b style="font-weight: bold;">Editar Servicio</b></h2>
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
                                                placeholder="Código generado automáticamente" id="edit_codigo_servicio"
                                                name="   ">
                                            <input type="hidden" id="codigo_producto_display" value="">
                                        </div>
                                    </div>
                                </div>

                                <!-- Código original -->
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center" id="form_group_cod_original">
                                        <label class="col-md-3 col-form-label"><strong>Cod. Orig.</strong></label>
                                        <div class="col-md-9">
                                            <input type="text" name="codigo_original" id="codigo_original_Edit"
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
                                                required id="nombre_Edit" autocomplete="off">
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
                                            <input type="text" class="form-control" id="descripcion_Edit"
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
                                            <select id="familia_id_Edit" required="required"
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
                                            <select class="form-control subfamilia_select2" id="subfamilia_Edit">
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
                                            <select id="marca_id_Edit" class="form-control marca_select2" required>
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
                                                    max="100" step="0.01" id="descuento_Edit"
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
                                                    autocomplete="off" required="required" step="0.01"
                                                    id="precio_nacional_Edit">
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
                                                    id="precio_extranjero_Edit">
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
                                                <input type="text" id="sumando_Edit"
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
                                                placeholder="{{ $moneda->where('tipo', 'nacional')->pluck('simbolo')->first() }}"
                                                id="precio_compra_Edit" oninput="calcular_utilidad_Edit()">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group text-center">
                                            <label for="" class="col-form-label"><b>Precio de Venta +
                                                    IGV</b></label>
                                            <input type="text" class="border-0 form-control input-s-lg"
                                                placeholder="{{ $moneda->where('tipo', 'nacional')->pluck('simbolo')->first() }}"
                                                id="precio_venta_Edit" oninput="calcular_utilidad_Edit()">
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
                                            <select id="tipo_afectacion_Edit" class="form-control afectacion_select2">
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
                                            <input type="file" id="archivoInputEdit" name="foto_producto"
                                                onchange="return validarExtEdit()">
                                            <input name="avatar_respaldo" value="defecto_avatar.jpg" hidden>
                                            <div id="visorArchivoEdit" class="d-flex justify-content-center">
                                                <img id="fotoPreviaEdit" name="foto"
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

    #div_ayuda_utilidad_edit {
        display: none;
    }

    .select2-container .select2-dropdown {
        z-index: 20000 !important;
    }
</style>
{{-- {{$tipo_cambio->fecha}} --}}
<script>
    $(document).ready(function() {
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
    $('#porcentaje_utilidad_edit').on('click', function(e) {
        $('#div_ayuda_utilidad_edit').toggle();
    })

    function calcular_utilidad_Edit() {
        var precio_venta = $("#precio_venta_Edit").val();
        var precio_compra = $("#precio_compra_Edit").val();

        if (!isNaN(precio_venta) && !isNaN(precio_compra) && precio_venta !== "" && precio_compra !== "") {
            var a1 = parseFloat(precio_venta) * 100;
            var a2 = a1 / parseFloat(precio_compra);
            var utilidad = a2 - 100;
            console.log(utilidad);
            $("#sumando_Edit").val(utilidad);
        } else {
            $("#sumando_Edit").val("");
        }

        $("#precio_nacional_Edit").val(precio_compra);

        // Disparar evento input para que se actualicen cálculos
        $("#precio_nacional_Edit").trigger("input");
    }

    function validarExtEdit() {
        var archivoInputEdit = document.getElementById('archivoInputEdit');
        var archivoRutaEdit = archivoInputEdit.value;
        var extPermitidasEdit = /(.jpg|.png|.jfif)$/i;

        if (!extPermitidasEdit.exec(archivoRutaEdit)) {
            alert('Asegúrese de haber seleccionado una imagen válida (.jpg, .png, .jfif)');
            archivoInputEdit.value = '';
            return false;
        }

        if (archivoInputEdit.files && archivoInputEdit.files[0]) {
            var visor = new FileReader();
            visor.onload = function(e) {
                var img = document.getElementById('fotoPreviaEdit');
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
            visor.readAsDataURL(archivoInputEdit.files[0]);
        }
    }

    // let tipo_cambio = parseFloat(`{{ $tipo_cambio->paralelo }}`) || 1;

    // Cuando cambia el precio nacional → calculamos el extranjero
    $('#precio_nacional_Edit').on('input', function() {
        let precio_nacional = parseFloat($(this).val()) || 0;
        let precio_extranjero = precio_nacional / tipo_cambio;
        $('#precio_extranjero_Edit').val(precio_extranjero.toFixed(2));
        $('#precio_compra_Edit').val(precio_nacional);
    });

    // Cuando cambia el precio extranjero → calculamos el nacional
    $('#precio_extranjero_Edit').on('input', function() {
        let precio_extranjero = parseFloat($(this).val()) || 0;
        let precio_nacional = precio_extranjero * tipo_cambio;
        $('#precio_nacional_Edit').val(precio_nacional.toFixed(2));
        $('#precio_compra_Edit').val(precio_nacional.toFixed(2));
    });

    $(document).on('click', '.edit-servicio', function() {
        currentProductId = $(this).data('id');

        var nombre = $(this).data('nombre');
        var codigo = $(this).data('codigo');
        var codigo_original = $(this).data('codigo_original');
        var marca = $(this).data('marca');
        var marca_id = $(this).data('marca_id');
        var origen = $(this).data('origen');
        var peso_cantidad = $(this).data('peso_cantidad');
        var peso_unidad = $(this).data('peso_unidad');
        // var stock = $(this).data('stock');
        var stock_minimo = $(this).data('stock_minimo');
        var stock_maximo = $(this).data('stock_maximo');
        var descuento_1 = $(this).data('descuento_1');
        var descuento_2 = $(this).data('descuento_2');
        var descuento_max = $(this).data('descuento_max');
        var utilidad = $(this).data('utilidad');
        var unidad_medida = $(this).data('unidad_medida');
        var unidad_medida_id = $(this).data('unidad_medida_id');
        var precio_venta = $(this).data('precio_venta');
        var precio_compra = $(this).data('precio_compra');
        var afectacion = $(this).data('afectacion');
        var garantia = $(this).data('garantia');
        var familia = $(this).data('familia');
        var familia_id = $(this).data('familia_id');
        var subfamilia = $(this).data('subfamilia');
        var subfamilia_id = $(this).data('subfamilia_id');
        var descripcion = $(this).data('descripcion');
        var fecha = $(this).data('fecha');
        var estado_id = $(this).data('estado_id');
        var archivo = $(this).data('archivo');
        var foto = $(this).data('foto');

        $('#edit_nombre').val(nombre);
        $('#edit_codigo').val(codigo);
        $('#edit_codigo_original').val(codigo_original);
        $('#edit_origen').val(origen);
        $('#edit_peso_cantidad').val(peso_cantidad);
        $('#edit_peso_unidad').val(peso_unidad);
        // $('#edit_stock').val(stock);
        $('#edit_stock_minimo').val(stock_minimo);
        $('#edit_stock_maximo').val(stock_maximo);
        $('#edit_descuento_1').val(descuento_1);
        $('#edit_descuento_2').val(descuento_2);
        $('#edit_descuento_max').val(descuento_max);
        $('#edit_utilidad').val(utilidad);
        $('#edit_precio_compra').val(precio_compra);
        $('#edit_afectacion').val(afectacion);
        $('#edit_precio_venta').val(precio_venta);
        $('#edit_garantia').val(garantia);
        $('#edit_descripcion').val(descripcion);
        $('#edit_fecha').val(fecha);
        $('#edit_estado_id').val(estado_id);
        // $('#ficha_tecnica_edit').val(archivo);
        $('.value-input-file').html(archivo);
        $('#link_archivo').attr('href', "{{ asset('archivos/productos/fichas') }}/" + archivo);
        $('#link_archivo').attr('download', archivo);
        // $('#fotoPreviaEdit').html(foto);
        // $("#foo").attr("src", foto);
        $('#fotoPreviaEdit').attr('src', "{{ asset('archivos/imagenes/productos') }}/" + foto);
        // $('#link_archivo').attr('download', archivo);


        if (marca_id) {
            $('#edit_marca').val(marca_id).trigger('change');
        } else {
            $('#edit_marca').val(marca);
        }

        if (unidad_medida_id) {
            $('#edit_unidad_medida').val(unidad_medida_id).trigger('change');
        } else {
            $('#edit_unidad_medida').val(unidad_medida);
        }

        if (familia_id) {
            $('#edit_familia').val(familia_id).trigger('change');

            var subfamiliaSelect = $('#edit_subfamilia');
            // subfamiliaSelect.empty();
            edit_list_subfamilia();
            // var subfamiliasFiltradas = todasLasSubfamilias.filter(function(subfamilia) {
            //     return subfamilia.id_familia == familia_id;
            // });

            // subfamiliasFiltradas.forEach(function(subfamilia) {
            //     subfamiliaSelect.append('<option value="' + subfamilia.id + '">' +
            //         subfamilia.descripcion + '</option>');
            // });

            if (subfamilia_id) {
                $('#edit_subfamilia').val(subfamilia_id).trigger('change');
            }
        } else {
            $('#edit_familia').val(familia);
        }

        if (afectacion) {
            $('#edit_tipo_afectacion').val(afectacion).trigger('change');
        }

        if (archivo) {
            $('#col-dw-ficha').css('display', 'flex');
            $('#col-dw-ficha').addClass('col-md-1 justify-content-center');
            $('#col-ficha').removeClass('col-md-10');
            $('#col-ficha').addClass('col-md-9');
        } else {
            $('#col-ficha').removeClass('col-md-9');
            $('#col-ficha').addClass('col-md-10');
            $('#col-dw-ficha').css('display', 'none');
        }
    });

    $('#store_servicio').on('click', function(e) {
        e.preventDefault();
        var form = $('#form-servicio')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        // e.preventDefault();
        var formData = new FormData();
        formData.append('codigo', $('#codigo_original_Edit').val());
        formData.append('nombre', $('#nombre_Edit').val());
        formData.append('descripcion', $('#descripcion_Edit').val());
        formData.append('familia_id', $('#familia_id_Edit').val());
        formData.append('subfamilia_id', $('#subfamilia_Edit').val());
        formData.append('marca_id', $('#marca_id_Edit').val());
        formData.append('precio_nacional', $('#precio_nacional_Edit').val());
        formData.append('precio_extranjero', $('#precio_extranjero_Edit').val());
        formData.append('utilidad', $('#sumando_Edit').val());
        formData.append('afectacion_id', $('#tipo_afectacion_Edit').val());
        if ($('#archivoInputEdit')[0].files.length > 0) {
            formData.append('foto', $('#archivoInputEdit')[0].files[0]);
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
                    $('#familia_id_Edit').val(null).trigger('change');
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
</script>
