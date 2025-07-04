<!-- Modal Crear Cliente -->
<div class="modal fade" id="modal_create_cliente" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel" style="font-size: 20px;">
                        <b>Agregar Nuevo Cliente</b>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="margin-top: 0px;">
                    <!-- Título con ícono -->
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; margin-bottom: 20px;"
                        id="consulta-general">
                        <form>
                            {{ csrf_field() }}
                            <br>
                            <label for="search"
                                style="color: rgb(0, 0, 0); font-size: 20px; font-weight: bold; margin-bottom: 10px;">
                                Consultar (RUC - DNI)
                            </label>
                            <div style="display: flex; align-items: center;">
                                <input type="text" pattern="\d*" class="fast_add" id="general_cliente"
                                    name="general_cliente" required="required" autocomplete="off" maxlength="11"
                                    placeholder="Ingrese RUC o DNI" style="margin-right: 10px;">
                                <button class="btn btn-info btn-lg dni_boton_general" id="general_boton_cliente"
                                    name="btn" value="cliente" type="button">
                                    Buscar
                                </button>
                            </div>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab"
                                aria-controls="tab1" aria-selected="true">1. Datos Personales</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab"
                                aria-controls="tab2" aria-selected="false">2. Información</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab"
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
                                        {{-- <select name="responsable" required class="form-control m-b select2-responsable"
                                            autocomplete="off" required="required" style="margin-bottom: 0px;">
                                            <option value=""></option>
                                            <option value="1">RUC</option>
                                            <option value="2">DNI</option>
                                            <option value="3">Pasaporte</option>
                                        </select> --}}
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
                                        <label for="direccion" class="form-label"><b>Nombre:</b></label>
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
                                        <input value="sincorreo@gmail.com" input type="text" class="fast_add"
                                            placeholder="" name="direccion" autocomplete="off" required="required">
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
                                            name="aniversario">
                                    </div>
                                    <!-- TIPO CLIENTE -->
                                    <div class="col-md-6">
                                        <label for="tipocliente" class="form-label"><b>Tipo Cliente:</b></label>
                                        <select name="responsable" required class="fast_add select2-responsable"
                                            autocomplete="off" required="required" style="margin-bottom: 0px;">
                                            <option value=""></option>
                                            <option value="1">Cliente Frecuente</option>
                                            <option value="2">Cliente Revendedor</option>
                                            <option value="3">Cliente Vip</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer" style="padding: 10px">
                                    <button type="button" id="ant-step-1"
                                        class="btn btn-sm btn-secondary">Ant.</button>
                                    <button type="button" id="sig-step-1"
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
                                        <label for="direccion" class="form-label"><b>Celular</b></label>
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
                                            placeholder="" name="direccion" autocomplete="off" required="required">
                                    </div>
                                </div>
                                <div class="modal-footer" style="padding: 10px">
                                    <button type="button" id="ant-step-1"
                                        class="btn btn-sm btn-secondary">Ant.</button>
                                    <button type="submit" id="sig-step-1"
                                        class="btn btn-sm btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div> --}}
                    </div>
                </div>
            </form>
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
</style>
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
                        var nombre = datos[2] + ' ' + datos[3] + ' ' + datos[4];
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
</script>
