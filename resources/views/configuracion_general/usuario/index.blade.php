@extends('layout')
@section('title', 'Usuario')
@section('href_accion', route('usuario.lista'))
@section('value_accion', 'Agregar')
@section('button2', 'Atras')
@section('config', route('Configuracion'))
@section('content')


    <form method="POST" action="{{ route('usuario.asignar_permiso', 1) }}">
        @csrf
        <input type="hidden" name="permisos" id="" value="Superadministrador">
        <input type="submit" class="btn btn-s-m btn-success" value="Activar" />
    </form>

    <div class="wrapper wrapper-content animated fadeInRight" style="padding-bottom: 0px">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de Usuarios del Sistema</h4>
                        <div class="ibox-tools custom">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            @include('configuracion_general.usuario._shared.statistics')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <div class="tabs-scroll-top-comprobantes"></div>
                            <div class="tabs-scroll-bottom">
                                <ul class="nav nav-tabs" role="tablist"
                                    style="align-items: center;border-bottom: 0px !important;">
                                    @include('configuracion_general.usuario._shared.tabs')
                                    <ul class="ml-auto d-flex"
                                        style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                        <button type="button" id="btn-nuevo-usuario" class="btn btn-primary">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </ul>
                                </ul>
                            </div>
                            <div class="tab-content" style="margin-top: -1px">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show"
                                    style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row" style="row-gap: 5px">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter"
                                                        value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}"
                                                        readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" name="" id="select_estado_sunat">
                                                    <option value="" selected>Todos los Roles</option>
                                                    @foreach ($roles as $rol)
                                                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                        <br>{{--  Tabla de Cotizacion Manual   --}}
                                        <div class="scrooll-table-responsive">
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered dataTables-example-boleta"
                                                style="min-width: 982px">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox" class="i-checks" name="input[]">
                                                        </th>
                                                        <th>Nombres y Apellidos</th>
                                                        <th>DNI</th>
                                                        <th>Rol Asignado</th>
                                                        <th>Correo</th>
                                                        <th>Celular</th>
                                                        <th>Almacen</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($usuarios as $id => $usuario)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox">
                                                            </td>
                                                            <td>{{ $usuario->nombre ?? $usuario->personal->full_name }}</td>
                                                            <td>{{ $usuario->personal->numero_documento }}</td>
                                                            <td>{{ $usuario->getRoleNames()->first() }}</td>
                                                            <td>{{ $usuario->email }}</td>
                                                            <td>{{ $usuario->celular ?? $usuario->personal->celular }}</td>
                                                            <td>{{ $usuario->almacen->nombre }}</td>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm"><i
                                                                        class="fa fa-eye"></i></button>
                                                                @if ($usuario->estado == 1)
                                                                    <button class="btn btn-sm btn-primary"><i
                                                                            class="fa fa-check"></i></button>
                                                                @else
                                                                    <button class="btn btn-sm btn-danger"><i
                                                                            class="fa fa-close"></i></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('configuracion_general.usuario.create')


    <div class="wrapper wrapper-content animated fadeInRight">
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
        @if (isset($errores))
            <div>
                <div class="alert alert-danger">
                    <div class="alert-link" href="#">
                        <li style="color: red;">{{ $errores }}</li>
                    </div>
                </div>
            </div>
        @endif






        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Usuarios</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Roles</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="wrapper wrapper-content">
                                    <div class="row animated fadeInDown">
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div class="ibox-content">
                                                    <div class="row">
                                                        <div class="col-sm-12 text-right">
                                                            <a href="{{ route('usuario.lista') }}"
                                                                class="btn btn-primary"><i class="fa fa-plus"> </i></a>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-striped table-bordered table-hover dataTables-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Personal</th>
                                                                    <th>Cargo</th>
                                                                    <th>Correo</th>
                                                                    <th>Celular</th>
                                                                    <th>Almacen Asignado</th>
                                                                    <th>Activo/desactivo</th>
                                                                    <th>Editar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <span hidden>{{ $i = 1 }}</span>
                                                                @foreach ($usuarios as $usuario)
                                                                    <tr class="gradeX">
                                                                        <td>{{ $i++ }}</td>
                                                                        <td>{{ $usuario->personal->nombres }}</td>
                                                                        <td>{{ $usuario->name }}</td>
                                                                        <td>{{ $usuario->email }}</td>
                                                                        <td>{{ $usuario->celular }}</td>
                                                                        <td>{{ $usuario->almacen->nombre }}</td>
                                                                        @if ($usuario->estado == 1)
                                                                            <td>Activo</td>
                                                                        @elseif($usuario->estado == 0)
                                                                            <td>Desactivo</td>
                                                                        @endif
                                                                        @if ($usuario->estado_validacion == 1)
                                                                            <td>
                                                                                <button type="button"
                                                                                    class="btn btn-primary"
                                                                                    data-toggle="modal"
                                                                                    data-target="#exampleModal{{ $usuario->id }}">Editar</button>
                                                                                <i class="fa fa-check"
                                                                                    aria-hidden="true"></i>
                                                                                <div class="modal fade"
                                                                                    id="exampleModal{{ $usuario->id }}"
                                                                                    tabindex="-1" role="dialog"
                                                                                    aria-labelledby="exampleModalLabel"
                                                                                    aria-hidden="true">
                                                                                    <div class="modal-dialog"
                                                                                        role="document">
                                                                                        <div class="modal-content">
                                                                                            <div
                                                                                                style="padding-left: 15px;padding-right: 15px;">
                                                                                                {{-- ccccccccccccccccc --}}
                                                                                                <div class="ibox-content"
                                                                                                    style="padding-left: 0px;padding-right: 0px;"
                                                                                                    align="center">
                                                                                                    <form
                                                                                                        action="{{ route('usuario.update', $usuario->id) }}"
                                                                                                        enctype="multipart/form-data"
                                                                                                        method="post">
                                                                                                        @csrf
                                                                                                        @method('PATCH')
                                                                                                        <img src=" {{ asset('/profile/images/') }}/{{ $usuario->avatar }}"
                                                                                                            style="width: 200px;height: 200px;  border-radius: 5px">
                                                                                                        <p
                                                                                                            style="font-size: 15px">
                                                                                                            {{ $usuario->name }}
                                                                                                        </p>
                                                                                                        <div>
                                                                                                            <div
                                                                                                                class="panel-body">
                                                                                                                <div
                                                                                                                    class="row">
                                                                                                                    <label
                                                                                                                        class="col-sm-3 col-form-label">Correo:</label>
                                                                                                                    <div
                                                                                                                        class="col-sm-9">
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            class="form-control"
                                                                                                                            name="correo"
                                                                                                                            value="{{ $usuario->email }}">
                                                                                                                    </div>

                                                                                                                    <label
                                                                                                                        class="col-sm-3 col-form-label">Almacen
                                                                                                                        Asignado:</label>
                                                                                                                    <div
                                                                                                                        class="col-sm-4">
                                                                                                                        <select
                                                                                                                            class="form-control"
                                                                                                                            name="almacen_id">
                                                                                                                            <option
                                                                                                                                value="{{ $usuario->almacen->id }}">
                                                                                                                                {{ $usuario->almacen->nombre }}
                                                                                                                            </option>
                                                                                                                            <option
                                                                                                                                value=""
                                                                                                                                disabled="">
                                                                                                                                -------------
                                                                                                                            </option>
                                                                                                                            @foreach ($almacen as $almacens)
                                                                                                                                <option
                                                                                                                                    value="{{ $almacens->id }}">
                                                                                                                                    {{ $almacens->nombre }}
                                                                                                                                </option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                    </div>

                                                                                                                    <label
                                                                                                                        class="col-sm-1 col-form-label">Desactivado</label>
                                                                                                                    <div
                                                                                                                        class="col-sm-2">
                                                                                                                        @if ($usuario->estado == 1)
                                                                                                                            <div
                                                                                                                                class="switch-button">
                                                                                                                                <input
                                                                                                                                    type="checkbox"
                                                                                                                                    name="estado"
                                                                                                                                    id="switch-label{{ $usuario->id }}"
                                                                                                                                    class="switch-button__checkbox"
                                                                                                                                    checked="">
                                                                                                                                <label
                                                                                                                                    for="switch-label{{ $usuario->id }}"
                                                                                                                                    class="switch-button__label"></label>
                                                                                                                            </div>
                                                                                                                        @else
                                                                                                                            <div
                                                                                                                                class="switch-button">
                                                                                                                                <input
                                                                                                                                    type="checkbox"
                                                                                                                                    name="estado"
                                                                                                                                    id="aswitch-label{{ $usuario->id }}"
                                                                                                                                    class="switch-button__checkbox">
                                                                                                                                <label
                                                                                                                                    for="aswitch-label{{ $usuario->id }}"
                                                                                                                                    class="switch-button__label"></label>
                                                                                                                            </div>
                                                                                                                        @endif

                                                                                                                    </div>
                                                                                                                    <label
                                                                                                                        class="col-sm-2 col-form-label">Activado:</label>
                                                                                                                    <div
                                                                                                                        class="col-sm-12">
                                                                                                                        {{-- Boton 2do modal --}}
                                                                                                                        <button
                                                                                                                            type="button"
                                                                                                                            class="btn btn-primary"
                                                                                                                            data-toggle="modal"
                                                                                                                            data-target="#2do_modal{{ $usuario->id }}">Guardar</button>
                                                                                                                        <div class="modal fade"
                                                                                                                            id="2do_modal{{ $usuario->id }}"
                                                                                                                            tabindex="-1"
                                                                                                                            role="dialog"
                                                                                                                            aria-labelledby="exampleModalLabel"
                                                                                                                            aria-hidden="true">
                                                                                                                            <div class="modal-dialog"
                                                                                                                                role="document">
                                                                                                                                <div
                                                                                                                                    class="modal-content">
                                                                                                                                    <div
                                                                                                                                        class="modal-header">
                                                                                                                                        <h5 class="modal-title"
                                                                                                                                            id="exampleModalLabel">
                                                                                                                                            Confirmar
                                                                                                                                            Contraseña
                                                                                                                                            para
                                                                                                                                            Realizar
                                                                                                                                            Cambios
                                                                                                                                        </h5>
                                                                                                                                        <button
                                                                                                                                            type="button"
                                                                                                                                            class="close"
                                                                                                                                            data-dismiss="modal"
                                                                                                                                            aria-label="Close">
                                                                                                                                            <span
                                                                                                                                                aria-hidden="true">&times;</span>
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                    <div
                                                                                                                                        style="padding-left: 15px;padding-right: 15px;">
                                                                                                                                        {{-- ccccccccccccccccc --}}
                                                                                                                                        <div class="ibox-content"
                                                                                                                                            style="padding-left: 0px;padding-right: 0px;"
                                                                                                                                            align="center">
                                                                                                                                            <fieldset>
                                                                                                                                                <div>
                                                                                                                                                    <div
                                                                                                                                                        class="panel-body">
                                                                                                                                                        <div
                                                                                                                                                            class="row">
                                                                                                                                                            <label
                                                                                                                                                                class="col-sm-3 col-form-label">Contraseña
                                                                                                                                                                Usuario:</label>
                                                                                                                                                            <div
                                                                                                                                                                class="col-sm-9">
                                                                                                                                                                <input
                                                                                                                                                                    required="required"
                                                                                                                                                                    type="password"
                                                                                                                                                                    class="form-control"
                                                                                                                                                                    name="contrasena_confirmar"
                                                                                                                                                                    placeholder="******"
                                                                                                                                                                    autocomplete="off">
                                                                                                                                                                <input
                                                                                                                                                                    type="text"
                                                                                                                                                                    name="contrasena_adm"
                                                                                                                                                                    value="{{ auth()->user()->password }}"
                                                                                                                                                                    hidden="">
                                                                                                                                                            </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>

                                                                                                                                            </fieldset>
                                                                                                                                            <button
                                                                                                                                                class="btn btn-primary"
                                                                                                                                                type="submit">Guardar</button>
                                                                                                                                            {{--   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <!-- / Modal Create  -->


                                                                                                                        {{--  --}}
                                                                                                                        {{-- <button class="btn btn-primary" type="submit">Grabar</button> --}}
                                                                                                                        <button
                                                                                                                            type="button"
                                                                                                                            class="btn btn-secondary"
                                                                                                                            data-dismiss="modal">Cerrar</button>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </td>
                                                                        @elseif($usuario->estado_validacion == 0)
                                                                            <td>
                                                                                <button type="button"
                                                                                    class="btn btn-primary"
                                                                                    data-toggle="modal"
                                                                                    data-target="#exampleModal{{ $usuario->id }}">Editar</button>
                                                                                <i class="fa fa-times"
                                                                                    aria-hidden="true"></i>
                                                                                <div class="modal fade"
                                                                                    id="exampleModal{{ $usuario->id }}"
                                                                                    tabindex="-1" role="dialog"
                                                                                    aria-labelledby="exampleModalLabel"
                                                                                    aria-hidden="true">
                                                                                    <div class="modal-dialog"
                                                                                        role="document">
                                                                                        <div class="modal-content"
                                                                                            style="width: 550px">
                                                                                            <div
                                                                                                style="padding-left: 15px;padding-right: 15px;">
                                                                                                {{-- ccccccccccccccccc --}}
                                                                                                <div class="ibox-content"
                                                                                                    style="padding-left: 0px;padding-right: 0px;"
                                                                                                    align="center">

                                                                                                    <form
                                                                                                        action="{{ route('usuario.envio_codigo', $usuario->id) }}"
                                                                                                        enctype="multipart/form-data"
                                                                                                        method="post">
                                                                                                        @csrf
                                                                                                        <fieldset>
                                                                                                            <legend
                                                                                                                style="height: 240px;">
                                                                                                                <img src="
                                                                                                    {{ asset('/profile/images/') }}/{{ $usuario->avatar }}"
                                                                                                                    style="width: 200px;height: 200px;border-radius: 5px">
                                                                                                                <br>{{ $usuario->personal->nombres }}
                                                                                                                {{ $usuario->personal->apellidos }}
                                                                                                                <p
                                                                                                                    style="font-size: 15px">
                                                                                                                    {{ $usuario->name }}
                                                                                                                </p>
                                                                                                            </legend>
                                                                                                            <div>
                                                                                                                <div
                                                                                                                    class="panel-body">
                                                                                                                    <div
                                                                                                                        class="row">
                                                                                                                        <label
                                                                                                                            class="col-sm-3 col-form-label">Correo:</label>
                                                                                                                        <div
                                                                                                                            class="col-sm-6">
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                class="form-control"
                                                                                                                                name="correo"
                                                                                                                                value="{{ $usuario->email }}">
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-3"
                                                                                                                            style="padding-bottom: 15px">
                                                                                                                            <input
                                                                                                                                type="submit"
                                                                                                                                name="accion"
                                                                                                                                class="btn btn-s-m btn-info"
                                                                                                                                value="Cambiar Correo">
                                                                                                                        </div>
                                                                                                                        <label
                                                                                                                            class="col-sm-3 col-form-label">Codigo
                                                                                                                            de
                                                                                                                            Confirmacion:</label>
                                                                                                                        <div
                                                                                                                            class="col-sm-3">
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                class="form-control"
                                                                                                                                name="cod_1"
                                                                                                                                maxlength="3">
                                                                                                                        </div>
                                                                                                                        <div
                                                                                                                            class="col-sm-3">
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                class="form-control"
                                                                                                                                name="cod_2"
                                                                                                                                maxlength="3">
                                                                                                                        </div>
                                                                                                                        <div
                                                                                                                            class="col-sm-3">
                                                                                                                            <input
                                                                                                                                type="text"
                                                                                                                                class="form-control"
                                                                                                                                name="cod_3"
                                                                                                                                maxlength="3">
                                                                                                                        </div>

                                                                                                                        <div
                                                                                                                            class="col-sm-12">
                                                                                                                            <p>No
                                                                                                                                me
                                                                                                                                ha
                                                                                                                                llegado
                                                                                                                                el
                                                                                                                                Codigo
                                                                                                                                de
                                                                                                                                confirmacion<input
                                                                                                                                    type="submit"
                                                                                                                                    name="accion"
                                                                                                                                    class="reenviar"
                                                                                                                                    value="Reenviar Codigo"
                                                                                                                                    style="border: none;background: #ff000000;">
                                                                                                                            </p>
                                                                                                                        </div>
                                                                                                                        <div
                                                                                                                            class="col-sm-12">
                                                                                                                            <input
                                                                                                                                type="submit"
                                                                                                                                name="accion"
                                                                                                                                class="btn btn-s-m btn-info"
                                                                                                                                value="Validar">
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
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <div class="wrapper wrapper-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="ibox ">
                                                <div
                                                    class="ibox-header d-flex justify-content-between px-3 align-items-center">
                                                    <div>
                                                        <h2>ROLES</h2>
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-success"
                                                            data-toggle="modal" data-target="#modal_rol">Agregar</button>
                                                        <div class="modal fade" id="modal_rol">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2>Crear nuevo rol</h2>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="POST"
                                                                            action="{{ route('roles.crearRol') }}">
                                                                            @csrf
                                                                            <div class="my-3">
                                                                                <label>Nombre:</label>
                                                                                <input
                                                                                    oninput="handleInputRolChange(event)"
                                                                                    type="text" class="form-control"
                                                                                    placeholder="Ingrese el nombre del rol"
                                                                                    name="nombre" required
                                                                                    autocomplete="off" />
                                                                                <span id="spanRolError"
                                                                                    class="text-danger" hidden></span>
                                                                            </div>
                                                                            <div
                                                                                class="my-3 d-flex justify-content-center align-items-center">
                                                                                <button id="BtnAgregarRol" disabled
                                                                                    class="btn btn-outline-primary"
                                                                                    type="submit">Agregar <i
                                                                                        class="fa fa-save"></i></button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-striped table-bordered table-hover dataTables-example">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Nombre</th>
                                                                    <th>guard_name</th>
                                                                    <th>Editar</th>
                                                                    <th>Gestionar Permisos</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($roles as $rol)
                                                                    <tr class="gradeX">
                                                                        <td>{{ $rol->id }}</td>
                                                                        <td>{{ $rol->name }}</td>
                                                                        <td>{{ $rol->guard_name }}</td>
                                                                        <td><button type="button" class="btn btn-success"
                                                                                data-toggle="modal"
                                                                                data-target="#modal-edit-rol-{{ $rol->id }}">Editar
                                                                                <i class="fa fa-edit"></i></button></td>
                                                                        <td><a class="text-decoration-none btn btn-success"
                                                                                href="{{ route('roles.gestRol', $rol->id) }}">Permisos
                                                                                <i class="fa fa-tasks"></i></a></td>
                                                                    </tr>
                                                                    <div class="modal fade"
                                                                        id="modal-edit-rol-{{ $rol->id }}">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h2>Editar Rol {{ $rol->name }}</h2>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form method="POST"
                                                                                        action="{{ route('roles.editarRol', $rol->id) }}">
                                                                                        @csrf
                                                                                        @method('put')
                                                                                        <div class="my-3">
                                                                                            <label>Nombre:</label>
                                                                                            <input
                                                                                                oninput="handleInputRolChange(event, true,{{ $rol->id }})"
                                                                                                value="{{ $rol->name }}"
                                                                                                type="text"
                                                                                                class="form-control"
                                                                                                placeholder="Ingrese el nombre del rol"
                                                                                                name="nombre" required
                                                                                                autocomplete="off" />
                                                                                            <span
                                                                                                id="spanEditRolError{{ $rol->id }}"
                                                                                                class="text-danger"
                                                                                                hidden></span>
                                                                                        </div>
                                                                                        <div
                                                                                            class="my-3 d-flex justify-content-center align-items-center">
                                                                                            <button
                                                                                                id="BtnEditRol{{ $rol->id }}"
                                                                                                disabled
                                                                                                class="btn btn-outline-primary"
                                                                                                type="submit">Agregar <i
                                                                                                    class="fa fa-save"></i></button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        div.dataTables_length {
            display: none;
        }

        /* El Buscar */
        div.dataTables_filter {
            display: none;
        }

        /* CSV, Excel, PDF, Print */
        div.dt-buttons {
            display: none;
        }

        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999 !important;
            width: 100% !important;
        }

        label.col-sm-2.col-form-label {
            text-align: left;
            font-weight: bold;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            text-align: left;
        }

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

        .select2-container {
            display: inline !important;
        }

        span#select2--container {
            text-align: left;
        }

        .reenviar {
            transition: 0.2s;
            color: #f72f2f
        }

        .reenviar:hover {
            color: #676a6c
        }

        .col-sm-9 {
            padding-bottom: 15px
        }

        .form-control {
            border-radius: 5px
        }

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
            background-color: #1f1f1f66;
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

        .switch-button .switch-button__checkbox:checked+.switch-button__label {
            background-color: #1c84c6;

        }

        .switch-button .switch-button__checkbox:checked+.switch-button__label:before {
            transform: translateX(1rem);
        }
    </style>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">

    <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>

    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>

    {{-- <script src="{{ asset('js/toastr-config.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            $('.dataTables-usu').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });
        //Select2
        $(document).ready(function() {
            $('.multiple_permisos_select').select2();
        });

        $('#btn-nuevo-usuario').on('click', function() {
            $('#create_usuario').modal('show');
        });

        $('.select2-personal').select2({
            placeholder: "Seleccionar Personal"
        });
        // getPersonalData
        $('.select2-personal').on('select2:select', function(e) {
            var data = e.params.data;
            $.ajax({
                type: "post",
                url: "{{ route('pa.getPersonalData') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': data.id,
                },
                success: function(msg) {
                    console.log(msg);
                    if (msg.email != "sincorreo@gmmail.com") {
                        $('#correo').val(msg.email);
                    } else {
                        toastr.warning(
                            "Este usuario no cuenta con un correo válido para crear un usuario",
                            '¡Observación!');
                    }
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            })
        });

        $('.select2-rol').select2({
            placeholder: "Seleccionar Rol del Sistema"
        });

        $('.select2-rol').on('select2:select', function(e) {
            // var palabra = "Personalizado";
            var data = e.params.data;
            var text = data.text;
            if (text.includes("Personalizado")) {
                $('#registrar_terminar').css('display', 'none');
                $('#permisos_terminar').css('display', 'flex');
            } else {
                $('#permisos_terminar').css('display', 'none');
                $('#registrar_terminar').css('display', 'flex');
            }
        });

        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });

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

        $('#registrar_terminar').on('click', function(e){
            var pass1 = $('#password').val();
            var pass2 = $('#password_2').val();
            if(pass1 != pass2){
                toastr.warning("", 'Las contraseñas no son iguales', {
                    timeOut: 3000
                });
                return;
            }
            $('#send_true').click();
        });
        $('#permisos_terminar').on('click', function(e){
            var pass1 = $('#password').val();
            var pass2 = $('#password_2').val();
            if(pass1 != pass2){
                toastr.warning("", 'Las contraseñas no son iguales', {
                    timeOut: 3000
                });
                return;
            }
            $('#send_true').click();
        });
        // //roles existentes
        // const roles = @json($roles);

        // const handleInputRolChange = (e, edit = false, id = null) => {
        //     let inputValue = e.target.value.trim().toLowerCase();
        //     const spanId = edit ? `spanEditRolError${id}` : `spanRolError`;
        //     const btnId = edit ? `BtnEditRol${id}` : `BtnAgregarRol`;
        //     let spanError = document.getElementById(spanId);
        //     let btnAgregar = document.getElementById(btnId);

        //     let error = false;
        //     let mensajeError = '';

        //     if (inputValue == '') {
        //         error = true;
        //         mensajeError = 'El nombre no puede estar vacío.';
        //     } else {
        //         const rolesNames = roles.map(role => role.name.toLowerCase());
        //         if (rolesNames.includes(inputValue)) {
        //             error = true;
        //             mensajeError = 'Ya existe un rol con ese nombre.';
        //         }
        //     }
        //     spanError.textContent = mensajeError
        //     spanError.hidden = !error;
        //     btnAgregar.disabled = error;
        // }

        // // $(document).ready(function(){
        // //     $('.rolTable-example').DataTable({
        // //         pageLength: 25,
        // //         responsive: true,
        // //         dom: '<"html5buttons"B>lTfgitp',
        // //         buttons: []
        // // });
        // // });

        // //roles existentes
        // const roles = @json($roles);

        // const handleInputRolChange = (e, edit = false, id = null) => {
        //     let inputValue = e.target.value.trim().toLowerCase();
        //     const spanId = edit ? `spanEditRolError${id}` : `spanRolError`;
        //     const btnId = edit ? `BtnEditRol${id}` : `BtnAgregarRol`;
        //     let spanError = document.getElementById(spanId);
        //     let btnAgregar = document.getElementById(btnId);

        //     let error = false;
        //     let mensajeError = '';

        //     if (inputValue == '') {
        //         error = true;
        //         mensajeError = 'El nombre no puede estar vacío.';
        //     } else {
        //         const rolesNames = roles.map(role => role.name.toLowerCase());
        //         if (rolesNames.includes(inputValue)) {
        //             error = true;
        //             mensajeError = 'Ya existe un rol con ese nombre.';
        //         }
        //     }
        //     spanError.textContent = mensajeError
        //     spanError.hidden = !error;
        //     btnAgregar.disabled = error;
        // }

        // // $(document).ready(function(){
        // //     $('.rolTable-example').DataTable({
        // //         pageLength: 25,
        // //         responsive: true,
        // //         dom: '<"html5buttons"B>lTfgitp',
        // //         buttons: []
        // // });
        // // });
    </script>
    {{-- <script>
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
    </script> --}}

    {{-- <script>
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
    </script> --}}

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
