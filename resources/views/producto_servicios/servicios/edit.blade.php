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
                                        <label class="col-md-2 col-form-label"><strong>Descripción</strong></label>
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
                                                class="form-control familia_select2" onchange="edit_list_subfamilia()">
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
                                                id="fecha_edit" value="">
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
                            id="update_servicio">Guardar</button>
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

    input#archivoInputEdit {
        position: absolute;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        width: 100%;
        /*height:100%;*/
        opacity: 0;
        padding: 30px;
    }

    #visorArchivoEdit {
        width: 100%;
        height: auto;
        min-height: 250px;
        padding: 10px;
        background-color: #f8f9fa;
        border: 2px solid #ced4da;
        border-radius: 6px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;

    }

    #visorArchivoEdit img[name="foto"] {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease-in-out;
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

    function edit_list_subfamilia() {
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

        $('#edit_codigo_servicio').val(codigo_servicio);
        $('#codigo_original_Edit').val(codigo_original);
        $('#nombre_Edit').val(nombre);
        $('#descripcion_Edit').val(descripcion);
        $('#descuento_Edit').val(descuento);
        $('#precio_nacional_Edit').val(precio_nacional);
        $('#precio_extranjero_Edit').val(precio_extranjero);
        $('#sumando_Edit').val(utilidad);
        $('#fecha_edit').val(fecha_creacion);

        $('#fotoPreviaEdit').attr('src', "{{ asset('/archivos/imagenes/servicios') }}/" + foto);
        // $('#link_archivo').attr('download', archivo);


        if (marca_id) {
            $('#marca_id_Edit').val(marca_id).trigger('change');
        } else {
            $('#marca_id_Edit').val(marca_id);
        }
        if (familia_id) {
            $('#familia_id_Edit').val(familia_id).trigger('change');
            var subfamiliaSelect = $('#subfamilia_Edit');
            edit_list_subfamilia();
            if (subfamilia_id) {
                $('#subfamilia_Edit').val(subfamilia_id).trigger('change');
            }
        } else {
            $('#familia_id_Edit').val(familia_id);
        }

        if (tipo_afectacion_id) {
            $('#tipo_afectacion_Edit').val(tipo_afectacion_id).trigger('change');
        }

    });

    $('#update_servicio').on('click', function(e) {
        e.preventDefault();
        var form = $('#form-servicio-edit')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        var estadoValue = $('input[name="estado_id"]').val()
        // e.preventDefault();
        var formData = new FormData();
        formData.append('codigo_servicio', $('#edit_codigo_servicio').val());
        formData.append('nombre', $('#nombre_Edit').val());
        formData.append('descripcion', $('#descripcion_Edit').val());
        formData.append('descuento', $('#descuento_Edit').val());
        formData.append('precio_nacional', $('#precio_nacional_Edit').val());
        formData.append('precio_extranjero', $('#precio_extranjero_Edit').val());
        formData.append('utilidad', $('#sumando_Edit').val());
        formData.append('tipo_afectacion_id', $('#tipo_afectacion_Edit').val());
        formData.append('familia_id', $('#familia_id_Edit').val());
        formData.append('subfamilia_id', $('#subfamilia_Edit').val());
        formData.append('marca_id', $('#marca_id_Edit').val());
        // formData.append('codigo', $('#codigo_original_Edit').val());

        if ($('#archivoInputEdit')[0].files.length > 0) {
            formData.append('foto', $('#archivoInputEdit')[0].files[0]);
        }
        var submitBtn = $(this);
        submitBtn.prop('disabled', true).val('Guardando...');
        const servicioUpdate = "{{ route('servicios.update', ':id') }}";
        $.ajax({
            url: servicioUpdate.replace(':id', currentServicioId),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(
                        'Se actualizó el servicio correctamente'
                    );
                    $('.dataTables-example').DataTable().ajax.reload();
                    $('#EditServicio').modal('hide');
                    // location.reload();
                }
            },
            error: function(xhr) {
                var errorMessage = 'Error al actualizar el producto';

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

    $('#EditServicio').on('hidden.bs.modal', function() {
        currentServicioId = null;
        $('#EditServicio form')[0].reset();
    });
</script>
