@extends('layout')
@section('title', 'Usuario')
@section('href_accion', route('usuario.lista'))
@section('value_accion', 'Agregar')
@section('button2', 'Atras')
@section('config',route('Configuracion'))
@section('content')
<!-- Sección de USUARIO------------------------------------------------------------------------------------------------------------------------- -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <!-- Sección de Proveedor  ------------------------------------------------------------------------------------  -->
                    <div class="tab-pane active">
                        <!-- Título centrado -->
                        <h2 style="text-align: center; margin-bottom: 20px;">USUARIO</h2>
                        <div class="panel-body">
                            <!-- Contenido de Nested Tab 1 -->
                            <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <!-- Barra de búsqueda y botón Buscar -->
                                <div style="flex-grow: 1;">
                                    <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                    <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;background-color:blue">Buscar</button>
                                </div>

                                <!-- Botones Agregar, Actualizar y Descarga -->
                                <div>
                                    <button class="btn btn-success" id="btn-agregar" onclick="toggleForm()" style="margin-right: 10px; background-color:blue">+</button>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID </th>
                                        <th>PERSONAL </th>
                                        <th>CARGO </th>
                                        <th>CORREO</th>
                                        <th>CELULAR</th>
                                        <th>ALMACEN ASIGNADO</th>
                                        <td>ACCIONES</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>01</td>
                                        <td>FABRICIO</td>
                                        <td>PRACTICANTE</td>
                                        <td>SMITELEVELUP632@GMAIL.COM</td>
                                        <td>983719672</td>
                                        <td>GSO@CENTRAL</td>
                                        <td>
                                            <div>
                                                <button type="button" class="btn btn-primary" style="background-color:blue">
                                                    <i class="fa fa-edit" style="font-size: 20px; color:white;"></i></a>
                                                </button>

                                                <button class="btn btn-primary" style="margin-right: 10px; background-color:blue;">
                                                    <div class="infont col-md-3 col-sm-4"><a href="#"><i class="fa fa-refresh" style="font-size: 20px; color:white;"></i></a></div>
                                                </button>
                                                <button class="btn btn-primary btn-circle" type="button" style="background-color:blue"><i class="fa fa-check"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="btn-group">
                                <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                                <button class="btn btn-white">1</button>
                                <button class="btn btn-white  active">2</button>
                                <button class="btn btn-white">3</button>
                                <button class="btn btn-white">4</button>
                                <button type="button" class="btn btn-white" style="background-color:blue; color:white"><i class="fa fa-chevron-right"></i> </button>
                            </div>
                        </div>
                        <!-- Formulario oculto de agregar usuario -->
                        <div id="form-container" class="form-container" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; border: 1px solid #ccc; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); z-index: 1000; width: 1000px;">
                            <div>
                                <div class="button-container" style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                                    <h2 style="background-color: blue; color: white; border: none; border-radius: 5px; padding: 12px 15px; cursor: pointer; flex: 1; text-align: center;">NUEVO USUARIO</h2>
                                </div>

                                <div class="form-fields" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 20px; text-align: left;">
                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="personal" style="width: 100px;">PERSONAL:</label>
                                        <input type="text" id="personal" placeholder="Ingrese nombre personal" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>
                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="CARGO" style="width: 100px;">Cargo:</label>
                                        <input type="text" id="CARGO" placeholder="Ingrese Cargo" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>
                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="correo" style="width: 100px;">CORREO:</label>
                                        <input type="text" id="correo" placeholder="Ingrese Correo" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>
                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="celular" style="width: 100px;">CELULAR:</label>
                                        <input type="text" id="celular" placeholder="Ingrese numero de celular" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>
                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="almacen" style="width: 100px;">ALMACEN:</label>
                                        <input type="text" id="almacen" placeholder="Ingrese almacen" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>
                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <button id="btn-agregar-form" class="blue-button" style="background-color: blue; color: white; border: none; border-radius: 5px; padding: 12px 15px; cursor: pointer; font-size: 15px;">AGREGAR USUARIO</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Formulario oculto para actualizar datos del usuario -->
                        <div id="edit-form-container" class="form-container" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; border: 1px solid #ccc; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); z-index: 1000; width: 600px;">
                            <div>
                                <!-- Encabezado con imagen -->
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <img src="placeholder.jpg" alt="Foto de perfil" style="width: 150px; height: 150px; border-radius: 50%; border: 1px solid #ccc; object-fit: cover;">
                                </div>

                                <!-- Campos del formulario -->
                                <div class="form-fields" style="display: flex; flex-direction: column; gap: 15px; text-align: left;">
                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="cargo" style="width: 150px;">Cargo:</label>
                                        <input type="text" id="cargo" placeholder="Ingrese Cargo" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>

                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="correo" style="width: 150px;">Correo:</label>
                                        <input type="email" id="correo" placeholder="Ingrese Correo" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>

                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="contraseña-actual" style="width: 150px;">Contraseña actual:</label>
                                        <input type="password" id="contraseña-actual" placeholder="Ingrese Contraseña Actual" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>

                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="contraseña-nueva" style="width: 150px;">Contraseña nueva:</label>
                                        <input type="password" id="contraseña-nueva" placeholder="Ingrese Contraseña Nueva" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>

                                    <div style="display: flex; flex-direction: row; align-items: center; gap: 10px;">
                                        <label for="almacen" style="width: 150px;">Almacén asignado:</label>
                                        <input type="text" id="almacen" placeholder="Ingrese Almacén" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                    </div>
                                </div>

                                <!-- Botón guardar cambios -->
                                <div style="text-align: center; margin-top: 30px;">
                                    <button id="btn-guardar-cambios" class="blue-button" style="background-color: blue; color: white; border: none; border-radius: 5px; padding: 12px 20px; cursor: pointer; font-size: 16px;">Guardar cambios</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>












<style>
    .reenviar{transition: 0.2s;color: #f72f2f}
    .reenviar:hover{color: #676a6c}
    .col-sm-9{padding-bottom: 15px}
    .form-control{border-radius: 5px}
    :root {
        --color-button: #fdffff;
    }
    .switch-button {
        display: inline-block;
        /* padding-top: 9px;
        padding-right: 30px; */
        padding: 9px 40px;
    }
    .switch-button .switch-button__checkbox {
        display: none;
    }
    .switch-button .switch-button__label {
        background-color:#1f1f1f66;
        width: 2rem;
        height: 1rem;
        border-radius: 3rem;
        display: inline-block;
        position: relative;
    }
    .switch-button .switch-button__label:before {
        transition: .6s;
        display: block;
        position: absolute;
        width: 1rem;
        height: 1rem;
        background-color: var(--color-button);
        content: '';
        border-radius: 50%;
        box-shadow: inset 0px 0px 0px 1px black;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label {
        background-color: #1c84c6;

    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
        transform: translateX(1rem);
    }
</style>
<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src  ="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
    });
    });

</script>
<script>
    // Mostrar el formulario de agregar usuario
    document.getElementById("btn-agregar").onclick = function() {
        var formContainer = document.getElementById("form-container");
        formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    };
</script>
<script>
    // Mostrar el formulario de editar usuario
    document.getElementById("show-form-button").onclick = function() {
        var formContainer = document.getElementById("edit-form-container");
        formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    };
</script>
@endsection
