<!-- Modal Crear Cliente -->
<div class="modal fade" id="modal_create_cliente" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel" style="font-size: 20px;">
                    <b>Agregar Nuevo Cliente</b>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="margin-top: 0px;padding-top: 10px">
                <!-- Título con ícono -->
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-bottom: 20px;"
                    id="consulta-general">
                    <br>
                    <label for="search"
                        style="color: rgb(0, 0, 0); font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                        Consultar (RUC - DNI)
                    </label>
                    <div style="display: flex; align-items: center;">
                        <input type="text" pattern="\d*" class="fast_add" id="general_cliente"
                            name="general_cliente" required="required" autocomplete="off" maxlength="11"
                            placeholder="Ingrese RUC o DNI" style="margin-right: 10px;">
                        <button class="btn btn-info btn-lg dni_boton_general" id="general_boton_cliente" name="btn"
                            value="cliente" type="button">
                            Buscar
                        </button>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="form_cliente_modal">
                    {{ csrf_field() }}
                    @csrf
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab"
                                aria-controls="tab1" aria-selected="true">1. Datos Personales</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link disabled" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab"
                                aria-controls="tab2" aria-selected="false">2. Información</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link disabled" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab"
                                aria-controls="tab3" aria-selected="false">3. Contacto</a>
                        </li>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                            <!-- Aquí se agrega el contenido del modal -->
                            <div class="col-md-12">
                                <br>
                                <div class="row mb-3">
                                    <!-- DOCUMENTO IDENTIFICACION -->
                                    <div class="col-md-6">
                                        <label for="responsable" class="form-label"><b>Documento
                                                Identificación</b></label>
                                        <select class="fast_add" name="documento_identificacion"
                                            onchange="seleccionado()" id="cliente_doc">
                                            <option value="RUC">RUC</option>
                                            <option value="DNI">DNI</option>
                                            <option value="pasaporte">Pasaporte</option>
                                        </select>
                                    </div>
                                    <!-- NUMERO DE DOCUMENTO -->
                                    <div class="col-md-6">
                                        <label for="direccion" class="form-label"><b>Número de Documento</b></label>
                                        <input type="tel" list="browserdoc" class="fast_add" name="numero_documento"
                                            id="numero_ruc_cli" required="" autocomplete="off" maxlength="11"
                                            onkeypress="return valideKey(event);" aria-required="true">
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <!-- NOMBRE -->
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label"><b>Nombre:</b></label>
                                        <input type="text" name="nombre" class="fast_add required"
                                            id="razon_social_cli" required="required">
                                    </div>
                                    <!-- DIRECCION -->
                                    <div class="col-md-6">
                                        <label for="abreviatura" class="form-label"><b>Dirección:</b></label>
                                        <input type="text" value="Lima" class="fast_add" name="direccion"
                                            id="direccion_cli" required="required" aria-required="true">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <!-- CORREO -->
                                    <div class="col-md-6">
                                        <label for="correo" class="form-label"> <b>Correo:</b></label>
                                        <input value="sincorreo@gmail.com" type="text" class="fast_add"
                                            placeholder="" name="email" autocomplete="off" required="required">
                                    </div>
                                    <!-- DISTRITO -->
                                    <div class="col-md-6">
                                        <label for="distrito" class="form-label">
                                            <b>Distrito:</b>
                                        </label>
                                        <input type="text" value="Lima" class="fast_add" name="ciudad"
                                            id="distrito_cli" required="required" aria-required="true">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <!-- TELEFONO -->
                                    <div class="col-md-6">
                                        <label for="responsable" class="form-label"><b>Teléfono</b></label>
                                        <input value="00000" type="number" class="fast_add valid" name="telefono"
                                            aria-invalid="false">
                                    </div>

                                    <!-- CELULAR -->
                                    <div class="col-md-6">
                                        <label for="direccion" class="form-label"><b>Celular</b></label>
                                        <input value="0000000" type="number" class="fast_add valid" name="celular">
                                    </div>
                                </div>
                                <div class="modal-footer" style="padding: 10px">
                                    <button type="button" id="ant-step-1" class="btn btn-sm btn-secondary"
                                        disabled>Ant.</button>
                                    <button type="button" id="sig-step-1"
                                        class="btn btn-sm btn-primary">Sig.</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                            <br>
                            <!-- MODAL -->
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <!-- CODIGO UBIGEO -->
                                    <div class="col-md-6">
                                        <label for="codigoUbigeo" class="form-label">
                                            <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html"
                                                target="_blank" style="text-decoration: none;">
                                                <i class="fa fa-podcast" aria-hidden="true"></i>
                                            </a>
                                            <b>Cod. Ubigeo:</b>
                                        </label>
                                        <div class="input-group">
                                            <input value="150101" input type="text" class="fast_add"
                                                name="ubigeo" autocomplete="off" required="required" placeholder=""
                                                minlength="6" maxlength="6">
                                        </div>
                                    </div>
                                    <!-- DEPARTAMENTO -->
                                    <div class="col-md-6">
                                        <label for="abreviatura" class="form-label"><b>Departamento:</b></label>
                                        <input value="Lima" type="text" class="fast_add valid"
                                            name="departamento" id="provincia_cli" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <!-- PAIS-->
                                    <div class="col-md-6">
                                        <label for="codigoSunat" class="form-label"> <b>País:</b></label>
                                        <input value="Perú" type="text" class="fast_add valid" name="pais"
                                            aria-invalid="false">
                                    </div>
                                    <!-- ANIVERSARIO -->
                                    <div class="col-md-6">
                                        <label for="codigoUbigeo" class="form-label">
                                            <b>Aniversario:</b>
                                        </label>
                                        <input value="2025-02-15" type="date" class="fast_add valid"
                                            name="aniversario">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <!-- FECHA REGISTRO -->
                                    <div class="col-md-6">
                                        <label for="aniversario" class="form-label"> <b>Fecha Registro:</b></label>
                                        <input value="2025-02-15" type="date" class="fast_add valid"
                                            name="fecha_registro">
                                    </div>
                                    <!-- TIPO CLIENTE -->
                                    <div class="col-md-6">
                                        <label for="tipocliente" class="form-label"><b>Tipo Cliente:</b></label>
                                        <select name="tipo_cliente" class="fast_add select2-responsable"
                                            autocomplete="off" required="required" style="margin-bottom: 0px;">
                                            <option value="1">Cliente Frecuente</option>
                                            <option value="2">Cliente Revendedor</option>
                                            <option value="3">Cliente Vip</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <!-- Vendedor Asignado Por Defecto -->
                                    <div class="col-md-6">
                                        <label for="vendedor" class="form-label"><b>Vendedor Asignado</b></label>
                                        <select name="vendedor_id" class="fast_add select2-vendedor"
                                            autocomplete="off" required="required" style="margin-bottom: 0px;">
                                            <option value="">Sin Vendedor fijo</option>
                                        </select>
                                    </div>

                                    <!-- Forma Pago Defecto -->
                                    <div class="col-md-6">
                                        <label for="direccion" class="form-label"><b>Forma Pago Aut.</b></label>
                                        <select name="forma_pago_id" class="fast_add select2-forma_pago"
                                            autocomplete="off" required="required" style="margin-bottom: 0px;">
                                            <option value="">Sin forma de pago fija</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer" style="padding: 10px">
                                    <button type="button" id="ant-step-2"
                                        class="btn btn-sm btn-secondary">Ant.</button>
                                    <button type="button" id="sig-step-2"
                                        class="btn btn-sm btn-primary">Sig.</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                            <br>
                            <!-- Aquí se agrega el contenido del modal -->
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <!-- NOMBRE -->
                                    <div class="col-md-6">
                                        <label for="Contacto" class="form-label"><b>Nombre:</b></label>
                                        <input value="Contacto" input id="name" name="nombre_contacto"
                                            type="text" class="fast_add  required valid" value="Contacto"
                                            aria-required="true" aria-invalid="false">
                                    </div>
                                    <!-- CARGO -->
                                    <div class="col-md-6">
                                        <label for="cargo" class="form-label"><b>Cargo:</b></label>
                                        <input id="surname" name="cargo_contacto" type="text"
                                            class="fast_add  required" value="Cargo" aria-required="true">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <!-- TELEFONO -->
                                    <div class="col-md-6">
                                        <label for="responsable" class="form-label"><b>Teléfono</b></label>
                                        <input name="telefono_contacto" type="text" class="fast_add  required"
                                            value="0050000" aria-required="true">
                                    </div>
                                    <!-- CELULAR -->
                                    <div class="col-md-6">
                                        <label for="address" class="form-label"><b>Celular</b></label>
                                        <input id="address" name="celular_contacto" type="text"
                                            class="fast_add  required valid" value="951000000" aria-required="true"
                                            aria-invalid="false">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <!-- CORREO-->
                                    <div class="col-md-12">
                                        <label for="correo" class="form-label"> <b>Correo del Contacto:</b></label>
                                        <input value="sincorreo@gmail.com" input type="text" class="fast_add"
                                            placeholder="" name="email_contacto" autocomplete="off"
                                            required="required">
                                    </div>
                                </div>
                                <div class="modal-footer" style="padding: 10px">
                                    <button type="button" id="ant-step-3"
                                        class="btn btn-sm btn-secondary">Ant.</button>
                                    <button type="button" id="save_form"
                                        class="btn btn-sm btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .fast_add {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
        /* margin-right: 30px; */
        width: 100%;
        outline: none;
    }

    #general_cliente {
        min-width: 300px;
    }

    .dni_boton_general {
        background-color: #210abb;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
    }

    .select2-container--default .select2-selection--single,
    .select2-container.select2-container--default {
        width: 100% !important;
    }

    .select2-container.select2-container--default.select2-container--open {
        width: 100% !important;
        z-index: 9999;
    }
</style>

<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script>
    $('#add_cliente').on('click', function(e) {
        e.preventDefault();
        $('#modal_create_cliente').modal('show');
    });
    $("#numero_ruc_cli").change(function() {
        var opt = $('#numero_ruc_cli').val();
        if (opt == " ") {
            $('#numero_ruc_cli').val('');
        }
    });
    $('#general_boton_cliente').on('click', function() {
        var text_cliente = $('#general_cliente').val();
        // console.log(text_cliente.length);
        if (text_cliente.length == 11) {
            var url = "{{ url('clienteruc') }}";
            $.ajax({
                type: 'GET',
                url: url,
                data: 'ruc=' + text_cliente,
                success: function(datos_ruc) {
                    var datos = eval(datos_ruc);
                    if (datos[2] == 'existente') {
                        toastr.warning('' + datos[1] + ' ya existe',
                            'Cliente existente', {
                                timeOut: 3000
                            });
                    } else if (datos_ruc[0] == "sin") {
                        toastr.error('Verifique el número',
                            'Sin registros', {
                                timeOut: 3000
                            });
                    } else {
                        document.getElementById("cliente_doc").options.item(0)
                            .selected = 'selected';
                        $('#numero_ruc_cli').val(datos[0]);
                        $('#razon_social_cli').val(datos[1]);
                        $('#direccion_cli').val(datos[2]);
                        $('#provincia_cli').val(datos[3]);
                        $('#distrito_cli').val(datos[4]);
                        // $('#fechaInscripcion_cli').val(datos[5]);
                        $('#ubigeo').val(datos[5]);
                    }

                }
            });
            return false;
        } else if (text_cliente.length == 8) {
            var url = "{{ url('clientedni') }}";
            $.ajax({
                type: 'GET',
                url: url,
                data: 'dni=' + text_cliente,
                success: function(datos_dni) {
                    var datos = eval(datos_dni);
                    if (datos[2] == 'existente') {
                        toastr.warning('' + datos[1] + ' ya existe.',
                            'Cliente existente', {
                                timeOut: 3000
                            });
                    } else if (datos_dni[0] == "sin") {
                        toastr.error('Verifique el número',
                            'Sin registros', {
                                timeOut: 3000
                            });
                    } else {
                        document.getElementById("cliente_doc").options.item(1)
                            .selected = 'selected';
                        $('#numero_ruc_cli').val(datos[0]);
                        var nombre = datos[1] + ' ' + datos[2] + ' ' + datos[3];
                        $('#razon_social_cli').val(nombre);
                    }
                }
            });
            return false;
        } else {
            toastr.error('Verifique el número',
                'Sin registros', {
                    timeOut: 3000
                });
        }
    });

    function valideKey(evt) {
        // code is the decimal ASCII representation of the pressed key.
        var code = (evt.which) ? evt.which : evt.keyCode;

        if (code == 8) { // backspace.
            return true;
        } else if (code >= 48 && code <= 57) { // is a number.
            return true;
        } else { // other keys.
            return false;
        }
    }
    $(document).ready(function() {
        $(document).on('click', '.nav-link.disabled', function(e) {
            e.preventDefault();
            return false;
        });
        $('#sig-step-1').on('click', function() {
            const camposRequeridos = ['#numero_ruc_cli', '#razon_social_cli'];
            let primerCampoVacio = null;
            camposRequeridos.forEach(function(selector) {
                const campo = $(selector);
                const valor = campo.val();

                if (
                    campo.length &&
                    (
                        valor.trim() === '' || // vacío

                        (
                            selector === '#numero_ruc_cli' &&
                            (
                                valor.includes(' ') || // tiene espacios
                                !/^\d{8}$|^\d{11}$|^\d{12}$/.test(valor) // 8, 11 o 12 dígitos
                            )
                        )
                    ) &&
                    primerCampoVacio === null
                ) {
                    primerCampoVacio = campo;
                }
            });
            if (primerCampoVacio) {
                toastr.error('Por favor, revise los campos llenados.', 'Error', {
                    timeOut: 3000
                });
                primerCampoVacio.focus();
                return false;
            }
            $('#myTab a[href="#tab2"]').removeClass('disabled').tab('show');
            $('#myTab a[href="#tab1"]').addClass('disabled');
        });
        $('#ant-step-1').on('click', function() {
            $('#myTab a[href="#tab1"]').tab('show');
        });
        $('#sig-step-2').on('click', function() {
            $('#myTab a[href="#tab3"]').removeClass('disabled').tab('show');
            $('#myTab a[href="#tab2"]').addClass('disabled');
        });
        $('#ant-step-2').on('click', function() {
            $('#myTab a[href="#tab1"]').removeClass('disabled').tab('show');
        });
        $('#save_form').on('click', function() {
            var datos = $("#form_cliente_modal").serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('agregado_rapido.cliente_store') }}",
                data: datos,
                success: function(data) {
                    toastr.success("El registro se actualizo correctamente",
                        'Actualización de cliente', {
                            timeOut: 3000
                        });
                    // $("#form_cliente_modal").steps("destroy");
                    // llamado_vuelta();
                    $("#table_cliente").DataTable().ajax.reload();
                    $("#form_cliente_modal")[0].reset();
                    $('#modal_create_cliente').modal('hide');
                    $('#myTab a[href="#tab1"]').removeClass('disabled').tab('show');
                    $('#myTab a[href="#tab2"]').addClass('disabled');
                    $('#myTab a[href="#tab3"]').addClass('disabled');
                    $('#general_cliente').val('');
                    $('#numero_ruc_cli').val('');
                    $('#razon_social_cli').val('');
                    $('#direccion_cli').val('Lima');
                    $('#distrito_cli').val('Lima');
                    $('#provincia_cli').val('Lima');
                    $('#ubigeo').val('150101');
                    $('#dni_cliente').val('');
                },
                error: function(error) {
                    toastr.error("Error en el Registro",
                        'Error de Cliente', {
                            timeOut: 3000
                        });
                }
            });
        });
        $('#ant-step-3').on('click', function() {
            $('#myTab a[href="#tab2"]').removeClass('disabled').tab('show');
        });
    });

    function seleccionado() {
        var opt = $('#cliente_doc').val();
        if (opt == "DNI") {
            $('#consulta-ruc').css('display', 'none');
            $('#consulta-dni').css('display', 'block');
            $('#botoncito_cliente').prop('disabled', true);
            $('#dni_cliente').val('');
            // $('#dni_cliente').attr('maxlength', 8);

            $('#direccion_cli').val('Lima');
            $('#distrito_cli').val('Lima');
            $('#razon_social_cli').val('');
            // $('#consulta_s').hide();
        } else if (opt == "pasaporte") {
            $('#botoncito_cliente').prop('disabled', true);
            $('#numero_ruc_cli').val('');
            $('#direccion_cli').val('Lima');
            $('#distrito_cli').val('Lima');
            $('#razon_social_cli').val('');
        } else {
            $('#consulta-dni').css('display', 'none');
            $('#consulta-ruc').css('display', 'block');
            $('#botoncito_cliente').prop('disabled', false);
            $('#ruc_cliente').val('');
            // $('#ruc_cliente').attr('maxlength', 11);
            $('#direccion_cli').val('Lima');
            $('#distrito_cli').val('Lima');
            $('#razon_social_cli').val('');
            // $('#consulta_s').show();
        }
    }

    // Busqueda de Vendedores

    $.ajax({
        url: "{{ route('pa.getPersonalVendedor') }}",
        type: "POST",
        dataType: "json",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(data) {
            var $select = $('.select2-vendedor');

            // Limpiar opciones excepto la primera
            $select.find('option:not(:first)').remove();

            $.each(data, function(index, item) {
                var nombreCompleto = item.personal.personal_l.nombres + ' ' +
                    item.personal.personal_l.apellidos;

                $select.append(
                    $('<option>', {
                        value: item.id,
                        text: nombreCompleto
                    })
                );
            });
        }
    });

    $.ajax({
        url: "{{ route('pa.getFormaPago') }}",
        type: "POST",
        dataType: "json",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(data) {
            var $select = $('.select2-forma_pago');

            // Limpiar opciones excepto la primera
            $select.find('option:not(:first)').remove();

            $.each(data, function(index, item) {
                $select.append(
                    $('<option>', {
                        value: item.id,
                        text: item.nombre
                    })
                );
            });
        }
    });
</script>
