<div class="modal fade" id="create_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                    <h2>Agregar Nuevo Usuario</h2>
                    <form action="" enctype="multipart/form-data" method="post">
                        @csrf
                        <fieldset>
                            <legend style="margin-bottom: 10px;">
                                <div id="visorArchivo">
                                    <img src="{{ asset('/img/logos/usuarios.svg') }}" id="previewImg"
                                        style="width: 200px;height: 200px;border-radius: 5px">
                                    <input type="file" id="archivoInput" name="avatar" onchange="return validarExt()" />
                                </div>
                                
                            </legend>
                            <small>(Click para cambiar la imagen)</small>
                            <div>
                                <div class="panel-body">
                                    <div class="row">

                                        <label class="col-sm-2 col-form-label">Personal:</label>
                                        <div class="col-sm-10" style="padding-bottom: 10px">
                                            <select class="select2-personal" name="persona_id" id="persona_id">
                                                <option value="">Seleccionar un Personal Registrado</option>
                                                @foreach ($personal as $persona)
                                                    <option value="{{ $persona->id }}">{{ $persona->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Correo:</label>
                                        <div class="col-sm-10" style="padding-bottom: 10px">
                                            <input type="text" class="form-control" name="correo" id="correo" value=""
                                                required="required" autocomplete="off">
                                        </div>

                                        <label class="col-sm-2 col-form-label">Contraseña:</label>
                                        <div class="col-sm-4" style="padding-bottom: 10px">
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password" id="password"
                                                autocomplete="off" placeholder="******" required="required">
                                                {{-- <input type="password" id="password" autocomplete="current-password"
                                                    required name="password" placeholder="Ingresa tu contraseña"
                                                    class="form-control @error('password') is-invalid @enderror"> --}}
                                                <div class="input-group-append">
                                                    <span class="input-group-addon toggle-password"
                                                        onclick="togglePassword()">
                                                        <i class="fa fa-eye-slash" id="eye-icon"></i>
                                                        <!-- Cambiado a "fa-eye-slash" -->
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 col-form-label">Confirmar:</label>
                                        <div class="col-sm-4" style="padding-bottom: 10px">
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password_2" id="password_2"
                                                autocomplete="off" placeholder="******" required="required">
                                                {{-- <input type="password" class="form-control" name="password" id="password"
                                                    autocomplete="off" placeholder="******" required="required"> --}}
                                                <div class="input-group-append">
                                                    <span class="input-group-addon toggle-password"
                                                        onclick="togglePassword()">
                                                        <i class="fa fa-eye-slash" id="eye-icon2"></i>
                                                        <!-- Cambiado a "fa-eye-slash" -->
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Cargo:</label>
                                        <div class="col-sm-4" style="padding-bottom: 10px">
                                            <select class="select2-personal" name="rol_id" id="rol_id">
                                                @foreach ($roles as $rol)
                                                    <option value="{{ $rol->id }}">{{ $rol->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Asig. Almacen:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="almacen_id">
                                                <option value="todos">Todos</option>
                                                @foreach ($almacen as $almacens)
                                                    <option value="{{ $almacens->id }}">{{ $almacens->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary" type="submit">Registrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
