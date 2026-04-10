@extends('layout')
@section('title', 'Configuraion de Usuario')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')

@section('content')
    @if ($errors->any())
        <div style="padding-top: 20px;">
            <div class="alert alert-danger">
                <a class="alert-link" href="#">
                    @foreach ($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </a>
            </div>
        </div>
    @endif
    <div class="wrapper wrapper-content">
        <div class="animated fadeInRight">
            <form action="{{ route('usuario.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4>Información de usuario</h4>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <div
                                            style="margin-bottom: 10px;display:flex;align-items: center;justify-content: center;">
                                            <div id="visorArchivo">
                                                <img src="{{ asset('/img/logos/usuarios.svg') }}" id="previewImg"
                                                    style="width: 200px;height: 200px;border-radius: 5px">
                                                <input type="file" id="archivoInput" name="avatar"
                                                    onchange="return validarExt()" />
                                            </div>
                                        </div>
                                        <small>(Click para cambiar la imagen)</small>
                                    </div>
                                    <div class="col-md-9" style="height: 100%">
                                        <h1 class="text-center"><strong>{{ $user->personal->full_name }}</strong></h1>
                                        <br>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label"><strong>Nombre de
                                                    Usuario:</strong></label>
                                            <div class="col-sm-4" style="padding-bottom: 10px">
                                                <input type="text" class="form-control" value="{{ $user->name }}"
                                                    name="user_name" id="">
                                            </div>
                                            <label class="col-sm-2 col-form-label"><strong>Correo de
                                                    Acceso:</strong></label>
                                            <div class="col-sm-4" style="padding-bottom: 10px">
                                                <input type="text" class="form-control" name="correo" id="correo"
                                                    value="{{ $user->email_user ?? $user->email }}" required="required"
                                                    autocomplete="off">
                                            </div>
                                            <label class="col-sm-2 col-form-label"><strong>Nombre Legal:</strong></label>
                                            <div class="col-sm-4" style="padding-bottom: 10px">
                                                <input type="text" class="form-control"
                                                    value="{{ $user->nombre ?? $user->personal->full_name }}"
                                                    name="nombre_legal" id="">
                                            </div>
                                            <label class="col-sm-2 col-form-label"><strong>Correo Legal:</strong></label>
                                            <div class="col-sm-4" style="padding-bottom: 10px">
                                                <input type="text" class="form-control" name="correo_legal"
                                                    id="correo_legal" value="{{ $user->email_user }}" autocomplete="off">
                                            </div>

                                            <label class="col-sm-2 col-form-label"><strong>Celular:</strong></label>
                                            <div class="col-sm-4" style="padding-bottom: 10px">
                                                <input type="text" class="form-control"
                                                    value="{{ $user->celular ?? $user->personal->celular }}" name="celular"
                                                    id="celular">
                                            </div>
                                            <label class="col-sm-2 col-form-label"><strong>Asig. Almacen:</strong></label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="almacen_id" id="almacen_id">
                                                    <option value="todos">Todos</option>
                                                    @foreach ($almacen as $almacens)
                                                        <option value="{{ $almacens->id }}"
                                                            @if ($user->almacen_id == $almacens->id) selected @endif>
                                                            {{ $almacens->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label class="col-sm-2 col-form-label"><strong>Rol Actual:</strong></label>
                                            <div class="col-sm-4" style="padding-bottom: 10px">
                                                {{-- <input type="text" class="form-control" value="{{$user->getRoleNames()->first()}}"
                                                    name="" id="" readonly> --}}
                                                <select name="rol_actual" id="rol_actual" class="form-control">
                                                    @foreach ($roles as $rol)
                                                        <option value="{{ $rol->id }}"
                                                            @if ($rol->name == $user->getRoleNames()->first() || $user->roles->first()?->type == 1) selected @endif>
                                                            {{ $rol->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label class="col-sm-2 col-form-label"><strong>Estado:</strong></label>
                                            <div class="col-sm-4"
                                                style="display: flex;align-items: center;column-gap: 17px;">
                                                <small>Desactivado</small>
                                                <div class="switch-button">
                                                    <input type="checkbox" name="estado" id="switch-label2"
                                                        class="switch-button__checkbox"
                                                        @if ($user->estado == 1) checked="" @endif>
                                                    <label for="switch-label2" class="switch-button__label"></label>
                                                </div>
                                                <small>Activo</small>
                                            </div>
                                            <div class="col-sm-12" id="div_button_save"
                                                @if ($user->roles->first()?->type == 1) style="display: none" @endif>
                                                <button type="submit" class="btn btn-primary btn-block"
                                                    style="width: 50%;margin: auto;margin-top: 8px">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- {{$user->roles->first()?->type}} --}}
                                <div id="rol_personalizado" @if ($user->roles->first()?->type != 1) style="display: none" @endif>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3>Permisos del Sistema</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @php $i = 0; @endphp
                                        @foreach ($permisos as $modulo => $prefijos)
                                            @php
                                                $moduloSlug = Str::slug($modulo);
                                            @endphp
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="panel-group">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="display: flex">
                                                            <div class="checkbox checkbox-primary"
                                                                style="padding-left: 0px">
                                                                <input type="checkbox" class="check-modulo"
                                                                    id="modulo_{{ $moduloSlug }}"
                                                                    data-modulo="{{ $moduloSlug }}"
                                                                    onclick="check_modulo(this, '{{ $moduloSlug }}')">

                                                                <label for="modulo_{{ $moduloSlug }}"
                                                                    style="margin-bottom: 0px;">
                                                                    <h5 class="panel-title"
                                                                        style="margin-bottom: 0px;font-size:15px">
                                                                        <a data-toggle="collapse"
                                                                            href="#collapse-modulo-{{ $moduloSlug }}">
                                                                            {{ Str::of($modulo)->replace('_', ' ')->title() }}
                                                                        </a>
                                                                    </h5>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div id="collapse-modulo-{{ $moduloSlug }}"
                                                            class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <div class="row">
                                                                    @foreach ($prefijos as $prefijo => $listaPermisos)
                                                                        @php
                                                                            $prefijoSlug = Str::slug($prefijo);
                                                                            $uniqueId =
                                                                                $moduloSlug . '_' . $prefijoSlug;
                                                                        @endphp

                                                                        <div class="col-6" style="margin-bottom:10px">

                                                                            <div
                                                                                style="display:flex; justify-content:space-between; align-items:center">
                                                                                <div
                                                                                    style="display:flex; align-items:center">
                                                                                    <input type="checkbox"
                                                                                        class="check-prefijo modulo_{{ $moduloSlug }}"
                                                                                        data-modulo="{{ $moduloSlug }}"
                                                                                        data-prefijo="{{ $prefijoSlug }}"
                                                                                        onclick="check_submodulo(this, '{{ $moduloSlug }}', '{{ $prefijoSlug }}')"
                                                                                        id="prefijo_{{ $uniqueId }}">

                                                                                    <label
                                                                                        for="prefijo_{{ $uniqueId }}"
                                                                                        style="margin-left:5px; margin-bottom:0">
                                                                                        <strong>
                                                                                            {{ Str::title($prefijo) }}
                                                                                        </strong>
                                                                                    </label>
                                                                                </div>

                                                                                <a class="modulo_arrow"
                                                                                    onclick="abrir_modulo(this, '{{ $uniqueId }}')">
                                                                                    <i class="fa fa-toggle-down"></i>
                                                                                </a>
                                                                            </div>

                                                                            <div id="div_{{ $uniqueId }}"
                                                                                style="margin-left:15px; display:none;">

                                                                                @foreach ($listaPermisos as $permiso)
                                                                                    @php
                                                                                        $accion =
                                                                                            explode(
                                                                                                '.',
                                                                                                $permiso->name,
                                                                                            )[1] ?? '';
                                                                                    @endphp

                                                                                    <div
                                                                                        style="display:flex; justify-content:space-between; align-items:center; margin-bottom:3px;">

                                                                                        <div
                                                                                            style="display:flex; align-items:center">

                                                                                            <input type="checkbox"
                                                                                                name="permissions[]"
                                                                                                value="{{ $permiso->name }}"
                                                                                                class="check-permiso modulo_{{ $moduloSlug }} permisos_{{ $prefijoSlug }}"
                                                                                                data-modulo="{{ $moduloSlug }}"
                                                                                                data-prefijo="{{ $prefijoSlug }}"
                                                                                                id="permiso_{{ $permiso->id }}"
                                                                                                {{ in_array($permiso->name, $permisosRol) ? 'checked' : '' }}>

                                                                                            <label
                                                                                                for="permiso_{{ $permiso->id }}"
                                                                                                style="margin-left:5px; margin-bottom:0">
                                                                                                {{ Str::of($accion)->replace('_', ' ')->title() }}
                                                                                            </label>
                                                                                        </div>

                                                                                        @if ($permiso->description)
                                                                                            <button type="button"
                                                                                                class="btn btn-link btn-xs"
                                                                                                data-toggle="tooltip"
                                                                                                title="{{ $permiso->description }}">
                                                                                                <i class="fa fa-info-circle"
                                                                                                    style="font-size:10px"></i>
                                                                                            </button>
                                                                                        @endif

                                                                                    </div>
                                                                                @endforeach

                                                                            </div>

                                                                            <hr style="margin:8px 0">

                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <button style="margin-top: 5px" type="submit"
                                                class="btn btn-primary btn-block">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="animated fadeInRight">
                <div class="row">
                    <div class="col-md-6">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4>Datos Personales del Usuario</h4>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Tipo de Documento</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->documento_identificacion }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_n_documento"><strong>Número de Documento</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_n_documento"
                                                value="{{ $user->personal->numero_documento }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_fecha_nacimiento"><strong>Fecha de
                                                    Nacimiento</strong></label>
                                            <input type="text" readonly class="form-control"
                                                id="personal_fecha_nacimiento"
                                                value="{{ $user->personal->fecha_nacimiento }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_genero"><strong>Género</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_genero"
                                                value="{{ $user->personal->genero }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_celular"><strong>Celular</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_celular"
                                                value="{{ $user->personal->celular }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_telefono"><strong>Telefono</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_telefono"
                                                value="{{ $user->personal->telefono }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_correo"><strong>Correo</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_correo"
                                                value="{{ $user->personal->correo }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_direccion"><strong>Direccion</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_direccion"
                                                value="{{ $user->personal->direccion }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_n_educativo"><strong>Nivel Educativo</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_n_educativo"
                                                value="{{ $user->personal->nivel_educativo }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_carrera"><strong>Carrera Profesional</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_carrera"
                                                value="{{ $user->personal->profesion }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_estado_civil"><strong>Estado Civil</strong></label>
                                            <input type="text" readonly class="form-control"
                                                id="personal_estado_civil" value="{{ $user->personal->estado_civil }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_licencia"><strong>Licencia de Conducir</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_licencia"
                                                value="{{ $user->personal->licencia }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4>Datos Laborales del Usuario</h4>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="laboral_area"><strong>Área</strong></label>
                                            <input type="text" readonly class="form-control" id="laboral_area"
                                                value="{{ $user->personal->datos_laborales->departamento_area }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Cargo</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->cargo }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Tipo de Trabajador</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->tipo_trabajador }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Sede</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->sede }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Turno</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->turno }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Salario</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->salario }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Fecha Vinculacion</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->fecha_vinculacion }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Fecha Retiro</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->fecha_retiro ?? '-- -- --' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Banco abonado</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->banco_renumeracion }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Numero de Cuenta</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->numero_cuenta }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Seguro de Salud</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->afiliacion_salud }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Tipo Contrato</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->tipo_contrato }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="personal_tipo_doc"><strong>Regimen Pensionario</strong></label>
                                            <input type="text" readonly class="form-control" id="personal_tipo_doc"
                                                value="{{ $user->personal->datos_laborales->regimen_pensionario }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            {{-- <form action="{{ route('usuario.update', auth()->user()->id) }}" enctype="multipart/form-data"
                method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-4">
                        <div class="ibox ">
                            <div>
                                <div class="ibox-content no-padding border-left-right">

                                    <input type="file" id="archivoInput" name="avatar"
                                        onchange="return validarExt()" />
                                    <input name="avatar_respaldo" value="{{ auth()->user()->avatar }}" hidden />
                                    <div id="visorArchivo">
                                        <img style="padding: 51px;" class="img-fluid"
                                            src="{{ asset('/profile/images/') }}/{{ auth()->user()->avatar }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Datos Usuario</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="ibox-content profile-content">
                                    <h5>Nombre:</h5>
                                    <h4><input type="text" class="form-control" value="{{ auth()->user()->nombre }}"
                                            required name="nombre"></h4>
                                    <h5>Correo:</h5>
                                    <h4><input type="text" class="form-control"
                                            value="{{ auth()->user()->email_user }}" required name="email_user"></h4>
                                    <h5>Celular:</h5>
                                    <h4><input type="text" class="form-control" value="{{ auth()->user()->celular }}"
                                            required name="celular"></h4>
                                    <h5>Contraseña:</h5>
                                    <h4><input type="password" class="form-control" id="div" name="password"
                                            required readonly placeholder="************"></h4>
                                </div><input type="hidden" name="btn" value="user" hidden>
                                <button class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form> --}}

        </div>
    </div>
    <style>
        #visorArchivo {
            position: relative;
            width: 200px;
            /* aquí defines el tamaño */
            height: 200px;
            overflow: hidden;
            /* opcional, por seguridad */
        }

        #visorArchivo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* evita deformación */
            display: block;
        }

        #archivoInput {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            /* toma exactamente el tamaño del contenedor */
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .col-lg-3 {
            margin-bottom: 25px;
        }

        .sub_permisos {
            margin-right: 5px;
        }

        .checkbox label::before {
            margin-top: 5px;
        }

        .checkbox-primary input[type="checkbox"]:checked+label::after,
        .checkbox-primary input[type="radio"]:checked+label::after {
            margin-top: 7px;
        }

        .switch-button {
            display: inline-block;
            /* padding-top: 9px;
                                padding-right: 30px; */
        }

        .switch-button .switch-button__checkbox {
            display: none;
        }

        .switch-button .switch-button__label {
            background-color: #1f1f1f66;
            width: 3rem;
            height: 1rem;
            border-radius: 3rem;
            display: inline-block;
            position: relative;
            margin-bottom: 0px;
        }

        .switch-button .switch-button__label:before {
            transition: .6s;
            display: block;
            position: absolute;
            width: 1rem;
            height: 1rem;
            background-color: white;
            content: '';
            border-radius: 50%;
            box-shadow: inset 0px 0px 0px 1px black;
        }

        .switch-button .switch-button__checkbox:checked+.switch-button__label {
            background-color: #1c84c6;
        }

        .switch-button .switch-button__checkbox:checked+.switch-button__label:before {
            transform: translateX(2rem);
        }
    </style>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            actualizar_prefijos();
            actualizar_modulos();
        });

        $(document).ready(function() {
            $("#div").dblclick(function() {
                var readonly = document.getElementById("div").hasAttribute("readonly");
                // alert(readonly);
                if (readonly == true) {
                    document.getElementById("div").removeAttribute("readonly");
                }
                if (readonly == false) {
                    document.getElementById("div").value = "";
                    document.getElementById("div").setAttribute("readonly", "");
                }
            });
        });

        function check_modulo(el, modulo) {
            let estado = el.checked;

            let hijos = $(`.modulo_${modulo}:not(.check-modulo)`);
            hijos.prop('checked', estado);

            actualizar_prefijos();
            actualizar_modulos();
        }

        function check_submodulo(el, modulo, prefijo) {
            let estado = el.checked;

            let hijos = $(`.modulo_${modulo}.permisos_${prefijo}`);
            hijos.prop('checked', estado);

            actualizar_prefijos();
            actualizar_modulos();
        }

        function actualizar_prefijos() {
            $('.check-prefijo').each(function() {

                let modulo = $(this).data('modulo');
                let prefijo = $(this).data('prefijo');

                let hijos = $(`.modulo_${modulo}.permisos_${prefijo}`);

                let total = hijos.length;
                let checked = hijos.filter(':checked').length;

                if (checked === total && total > 0) {
                    this.checked = true;
                    this.indeterminate = false;
                } else if (checked > 0) {
                    this.checked = false;
                    this.indeterminate = true;
                } else {
                    this.checked = false;
                    this.indeterminate = false;
                }
            });
        }

        function actualizar_modulos() {
            $('.check-modulo').each(function() {

                let modulo = $(this).data('modulo');

                let hijos = $(`.modulo_${modulo}:not(.check-modulo)`);

                let total = hijos.length;
                let checked = hijos.filter(':checked').length;

                if (checked === total && total > 0) {
                    this.checked = true;
                    this.indeterminate = false;
                } else if (checked > 0) {
                    this.checked = false;
                    this.indeterminate = true;
                } else {
                    this.checked = false;
                    this.indeterminate = false;
                }
            });
        }
        function abrir_modulo(icon, item) {
            let div = document.getElementById(`div_${item}`);

            if (div.style.display === 'none' || div.style.display === '') {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
            }

            // obtener el icono dentro del <a>
            let son = icon.querySelector('i');

            // cambiar icono
            son.classList.toggle('fa-toggle-down');
            son.classList.toggle('fa-toggle-up');
        }
        $('input[type="checkbox"]').on('change', function() {
            actualizar_prefijos();
            actualizar_modulos();
        });
    </script>
    <script>
        function validarExt() {
            var archivoInput = document.getElementById('archivoInput');
            var archivo = archivoInput.files[0];

            if (!archivo) return;

            var extPermitidas = /(\.jpg|\.jpeg|\.png|\.jfif)$/i;

            if (!extPermitidas.exec(archivo.name)) {
                alert('Asegúrate de seleccionar una imagen válida');
                archivoInput.value = '';
                return false;
            }

            var lector = new FileReader();

            lector.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
            };

            lector.readAsDataURL(archivo);
        }

        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }

        function togglePassword2() {
            const passwordInput = document.getElementById("password_2");
            const eyeIcon = document.getElementById("eye-icon2");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }

        

        // function check_modulo(check, modulo) {
        //     let estado = $(check).prop('checked');

        //     $(`input.modulo_` + modulo).prop('checked', estado);
        // }

        // function check_submodulo(check, modulo, submodulo) {
        //     let estado = $(check).prop('checked');

        //     $(`input.modulo_` + modulo + `.permisos_` + submodulo)
        //         .prop('checked', estado);

        //     validar_modulo(modulo);
        // }

        // function validar_modulo(modulo) {
        //     let total = $(`.modulo_` + modulo + `.permisos_ind`).length;
        //     let checked = $(`.modulo_` + modulo + `.permisos_ind:checked`).length;

        //     // checkbox del módulo (nivel 1)
        //     let moduloCheck = $(`input[onclick="check_modulo(this,\`${modulo}\`)"]`);

        //     moduloCheck.prop('checked', total === checked);
        // }

        // function select_predef(id_rol) {
        //     $('input[type="checkbox"]').prop('checked', false);
        //     console.log(id_rol);
        //     if (id_rol == 2) {
        //         // Seleccionar todas los permisos
        //         $('input[type="checkbox"]').prop('checked', true);
        //     } else {
        //         // Llamado para el 
        //         $.ajax({
        //             type: "post",
        //             url: "{{ route('pa.getPermissionxRolData') }}",
        //             data: {
        //                 '_token': $('input[name=_token]').val(),
        //                 'id_rol': id_rol
        //             },
        //             success: function(permisos) {
        //                 console.log(permisos);
        //                 permisos.forEach(id => {
        //                     $(`#` + id).prop('checked', true);
        //                 });
        //             }
        //         });
        //     }
        // }
        // $(document).on('change', '.permisos_ind', function() {
        //     let clases = $(this).attr('class');

        //     let modulo = clases.match(/modulo_([^\s]+)/)[1];

        //     validar_modulo(modulo);
        // });

        // Cambio de Rol a persanlizado
        $('#rol_actual').on('change', function() {
            var valor = $(this).val();
            if (valor == 4) {
                $('#rol_personalizado').css('display', 'block');
                $('#div_button_save').css('display', 'none');
            } else {
                $('#rol_personalizado').css('display', 'none');
                $('#div_button_save').css('display', 'block');
            }
        });
    </script>
    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}", '', {
                    timeOut: 3000
                });
            @endif
        });
    </script>
@endsection
