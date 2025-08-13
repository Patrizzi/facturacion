<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
{{-- <link rel="stylesheet" href="{{ 'css/productos/create.css' }}"> --}}

<!-- Modal EditarProducto - 29/05/2025 -->
@include('producto_servicios.productos.edit')
<!-- Fin Modal EditarProducto - 29/05/2025 -->

<!--NuevoProducto - 29/05/2025-->
<div id="NuevoProducto" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static"
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
                                                value="{{ old('codigo_producto', $codigoProdGenerado) }}"
                                                placeholder="Código generado automáticamente">
                                            <input type="hidden" id="codigo_producto_display"
                                                value="{{ old('codigo_producto', $codigoProdGenerado) }}">
                                            <input type="hidden" name="codigo_producto" id="codigo_producto"
                                                value="{{ old('codigo_producto', $codigoProdGenerado) }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Código original -->
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-md-3 col-form-label"><strong>Cod. Orig.</strong><span
                                                class="text-danger">*</span></label>
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
                                        <label class="col-md-2 col-form-label"><strong>Descripcion</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="descripcion"
                                                name="descripcion">
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
                                        <label for="" class="col-form-label col-md-3"><strong>Peso</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-10 col-md-9">
                                            <div class="row">
                                                <div class="col-sm-6" style="padding-right: 0px">
                                                    <input type="number" class="form-control" name="peso"
                                                        required="required" step="0.01" min="0"
                                                        value="2.5" autocomplete="off">
                                                </div>
                                                <div class="col-sm-6" style="padding-left: 0px">
                                                    <select class="form-control" name="unidad_medida" id=""
                                                        style="height: 2.2rem;">
                                                        <option value="Miligramos">Miligramos</option>
                                                        <option value="Gramos">Gramos</option>
                                                        <option value="Kilos">Kilos</option>
                                                        <option value="Toneladas">Toneladas</option>
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
                                            class="col-form-label col-md-3"><strong>SubFamilia</strong><span
                                                class="text-danger">*</span></label>
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
                                                Mín.</strong><span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="stock_minimo"
                                                min="1" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Stock
                                                Max.</strong><span class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="stock_maximo"
                                                min="1" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- DESCUENTO 1 Y DESCUENTO 2 --}}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="" class="col-form-label col-md-3"><strong>Desc.
                                                1</strong><span class="text-danger">*</span></label>
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
                                                2</strong><span class="text-danger">*</span></label>
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
                                                Max.</strong><span class="text-danger">*</span></label>
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
                                            class="col-form-label col-md-3"><strong>Origen</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-11 col-md-9">
                                            <select name="origen" id="origen" class="form-control" required>
                                                <option value="Producto Importado">Producto Importado</option>
                                                <option value="Producto Nacional">Producto Nacional</option>
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
                                            <button class="btn btn-block btn-primary">Calcular</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row bg-light m-1 rounded-top rounded-bottom" style="padding-top: 10px">
                                <div class="col-md-12" style="text-align: center">
                                    <span class="text-center">¿En duda con su porcentaje de
                                        utilidad? Puede colocar su precio venta y el sistema calculará por ud.
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-center">
                                        <label for="" class="col-form-label"><b>Precio de compra<span
                                                    class="text-danger">*</span></b></label>
                                        <input type="text" class="border-0 form-control input-s-lg"
                                            placeholder="S/." id="precio_compra" oninput="calcular_utilidad()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-center">
                                        <label for="" class="col-form-label"><b>Precio de Venta + IGV<span
                                                    class="text-danger">*</span></b></label>
                                        <input type="text" class="border-0 form-control input-s-lg"
                                            placeholder="S/." id="precio_compra" oninput="calcular_utilidad()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fin Modal NuevoProducto - 29/05/2025 -->

<style>
    .form-control {
        border-radius: 5px;
    }

    input#archivoInput {
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

    .fa-question-circle:hover {
        color: blue;
    }

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

    .custom-file-label {
        word-break: break-all;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .custom-file-label::after {
        content: "Sel."
    }

    #visorArchivo {
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

    #visorArchivo img[name="foto"] {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease-in-out;
    }

    .hover-zoom {
        transition: transform 0.3s ease-in-out;
        cursor: pointer;
    }

    .hover-zoom:hover {
        transform: scale(1.2, 1.4);
    }
</style>



{{-- <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script> --}}

{{-- <!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script> --}}

<!-- Switchery -->
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<style>
    .select2.select2-container.select2-container--default {
        width: 100% !important;
        /* height: 100% !important; */
    }

    .select2-container--default .select2-selection--single {
        height: 2.5em;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px !important;
    }

    .custom-file-label {
        word-break: break-all;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .custom-file-label::after {
        content: "Sel.";
    }

    .select2-selection.select2-selection--single {
        text-align: justify !important;
    }

    .select2-container .select2-dropdown {
        z-index: 20000 !important;
    }
</style>

<script>
    $(document).ready(function() {
        var elem = document.querySelector('#edit_estado_id');
        if (elem) {
            var switchery = new Switchery(elem, {
                color: '#2776ea'
            });
            $('<input>').attr({
                type: 'hidden',
                name: 'estado_id',
                value: elem.checked ? '1' : '2'
            }).insertAfter(elem);

            elem.addEventListener('change', function() {
                $('input[name="estado_id"]').val(this.checked ? '1' : '2');
            });
        }

        var elem1 = document.querySelector('.js-switch-1');
        if (elem1) {
            var switchery1 = new Switchery(elem1, {
                color: '#2776ea'
            });
            $('<input>').attr({
                type: 'hidden',
                name: 'estado_producto_store',
                value: elem1.checked ? '1' : '2'
            }).insertAfter(elem1);
            elem1.addEventListener('change', function() {
                $('input[name="estado_producto_store"]').val(this.checked ? '1' : '2');
            });
        }

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>

<script>
    function calcular_utilidad() {
        var precio_venta = document.getElementById("edit_precio_venta").value;
        var precio_compra = document.getElementById("precio_compra").value;

        if (!isNaN(precio_venta) && !isNaN(precio_compra) && precio_venta !== "" && precio_compra !== "") {
            var a1 = parseFloat(precio_venta) * 100;
            var a2 = parseFloat(a1) / parseFloat(precio_compra);
            var utilidad = parseFloat(a2) - 100;
            // document.getElementById("edit_utilidad").value = utilidad.toFixed(2);
            document.getElementById("edit_utilidad").value = utilidad;
        } else {
            document.getElementById("edit_utilidad").value = "";
        }
    }
</script>
{{-- foto --}}
<script type="text/javascript">
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $(document).ready(function() {
        $('.familia_select2').select2({
            placeholder: "Seleccionar"
        });
        $('.subfamilia_select2').select2({
            placeholder: "Seleccionar"
        });
        $('.marca_select2').select2();
        $('.garantia_select2').select2();

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

    //  agrandar la imagen

    function validarExt() {
        var archivoInput = document.getElementById('archivoInput');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpg|.png|.jfif)$/i;

        if (!extPermitidas.exec(archivoRuta)) {
            alert('Asegúrese de haber seleccionado una imagen válida (.jpg, .png, .jfif)');
            archivoInput.value = '';
            return false;
        }

        if (archivoInput.files && archivoInput.files[0]) {
            var visor = new FileReader();
            visor.onload = function(e) {
                var img = document.getElementById('fotoPrevia');
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
            visor.readAsDataURL(archivoInput.files[0]);
        }
    }

    //   function calcular_utilidad(){
    //     var precio_venta = document.getElementById("precio_venta").value;
    //     var precio_compra = document.getElementById("precio_compra").value;

    //     if (!isNaN(precio_venta) || !isNaN(precio_compra) ) {
    //       // var utilidad = (parseFloat(precio_compra)/100) * parseFloat(precio_venta);
    //       var a1 =  parseFloat(precio_venta) * 100;
    //       var a2 = parseFloat(a1) / parseFloat(precio_compra);
    //       var utilidad = parseFloat(a2) - 100;
    //       document.getElementById("sumando").value = utilidad;
    //     }
    //   }

    //VALIDACION DE UTILIDAD PARA QUE NO ACEPTA LETRAS
    $('.input_valor_numerico').on('input', function() {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });
    $('.button_guardar').on('mouseenter', function() {
        var lol = document.querySelectorAll('.input_valor_numerico');
        lol.forEach(element => {
            if (element.val == "" || isNaN(Number(element.value)) == true) {
                element.value = 0;
            }
        });
    });
</script>
<script>
    $(function() {
        $('.marca_select2').select2({
            placeholder: 'Selecciona una marca'
        });

        function actualizarCodigo(marcaId) {
            if (!marcaId) {
                $('#codigo_producto_display, #codigo_producto').val('');
                return;
            }
            $.post(
                '{{ route('productos.generateCodigoProducto') }}', {
                    _token: '{{ csrf_token() }}',
                    marca_id: marcaId
                }
            ).done(function(res) {
                $('#codigo_producto_display').val(res.codigo_producto);
                $('#codigo_producto').val(res.codigo_producto);
            }).fail(function(err) {
                // console.error('no pudo generar el código', err);
            });
        }

        $('#marca_id')
            .on('change select2:select', function() {
                actualizarCodigo($(this).val());
            })
            .trigger('change');
    });
</script>
