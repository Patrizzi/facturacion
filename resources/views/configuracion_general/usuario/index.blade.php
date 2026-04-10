@extends('layout')
@section('title', 'Usuario')
@section('href_accion', route('usuario.lista'))
@section('value_accion', 'Agregar')
@section('button2', 'Atras')
@section('config', route('Configuracion'))
@section('content')


    {{-- <form method="POST" action="{{ route('usuario.asignar_permiso', 1) }}">
        @csrf
        <input type="hidden" name="permisos" id="" value="Superadministrador">
        <input type="submit" class="btn btn-s-m btn-success" value="Activar" />
    </form> --}}

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
                                            <table class="table table-striped table-bordered dataTables-example-usuarios"
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
                                                        <th>Ver</th>
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
                                                            <td>
                                                                @if($usuario->roles->first()?->type != 1)
                                                                    {{$usuario->getRoleNames()->first()}}
                                                                @else   
                                                                    Personalizado
                                                                @endif
                                                            </td>
                                                            <td>{{ $usuario->email }}</td>
                                                            <td>{{ $usuario->celular ?? $usuario->personal->celular }}</td>
                                                            <td>{{ $usuario->almacen?->nombre ?? 'Todos' }}</td>
                                                            <td>
                                                                @if ($usuario->estado_validacion == 1)
                                                                    <a href="{{ route('usuario.show', $usuario->id) }}"
                                                                        class="btn btn-primary btn-sm">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                @else
                                                                    <a type="button"
                                                                        onclick="modal_codigo({{ $usuario->id }})"
                                                                        id="btn-modal_submit_codigo"
                                                                        class="btn btn-info btn-sm">
                                                                        <i class="fa fa-code" style="color: white"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="#modal_change_password"
                                                                    class="btn btn-info btn-sm change_password_b"
                                                                    data-toggle="modal" title="Cambiar de contraseña"
                                                                    data-ids="{{ $usuario->id }}"
                                                                    data-name="{{ $usuario->personal->full_name }}"
                                                                    @if($usuario->roles->first()?->type != 1)
                                                                        data-rol="{{ $usuario->getRoleNames()->first() }}"
                                                                    @else   
                                                                        data-rol="Personalizado"
                                                                    @endif
                                                                    
                                                                    @if ($usuario->estado_validacion != 1) style="pointer-events: none; display: inline-block;" @endif>
                                                                    <i class="fa fa-key"></i>
                                                                </a>
                                                                @if ($usuario->estado_validacion == 1)
                                                                    {{-- Si está validado  --}}
                                                                    @if ($usuario->estado == 1)
                                                                        <button class="btn btn-info btn-circle btn-sm"
                                                                            title="Activo"><i
                                                                                class="fa fa-check"></i></button>
                                                                    @else
                                                                        <button class="btn btn-danger btn-circle btn-sm"
                                                                            title="Inactivo"><i
                                                                                class="fa fa-times"></i></button>
                                                                    @endif
                                                                @else
                                                                    <button class="btn btn-danger btn-circle btn-sm"
                                                                        title="Desactivado" title="Desactivado"><i
                                                                            class="fa fa-times"></i></button>
                                                                @endif
                                                                {{-- @if ($usuario->estado == 1)
                                                                    <button class="btn btn-info btn-circle btn-sm"
                                                                        title="Activo"><i class="fa fa-check"></i></button>
                                                                @else
                                                                    <button class="btn btn-danger btn-circle btn-sm"
                                                                        title="Inactivo"><i
                                                                            class="fa fa-times"></i></button>
                                                                @endif --}}
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

    <div class="modal fade" id="modal_submit_codigo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 550px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Activar Usuario del Sistema</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="padding-left: 15px;padding-right: 15px;">
                        <form action="{{ route('usuario.validar_cuenta') }}" enctype="multipart/form-data"
                            method="post" class="text-center">
                            @csrf
                            <fieldset>
                                <legend>
                                    <img src="#" id="imagen_codigo"
                                        style="width: 200px;height: 200px;border-radius: 5px">
                                    <br>
                                    <span id="codigo_full_name">A B</span>
                                    <h2 style="font-size: 15px" id="codigo_rol_name">
                                        Nombre
                                    </h2>
                                </legend>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">Correo:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="correo" id="correo_codigo"
                                            value="" required>
                                        <input type="hidden" name="id_user" id="usuario_codigo_id" required>
                                    </div>
                                    <div class="col-sm-3" style="padding-bottom: 15px">
                                        <button type="button" id="cambiar_correo" name="cambiar_correo" disabled
                                            class="btn btn-block btn-s-m btn-info">
                                            Cambiar
                                        </button>
                                    </div>
                                    <label class="col-sm-3 col-form-label">Codigo
                                        de
                                        Confirmacion:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="cod_1" maxlength="3" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="cod_2" maxlength="3" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="cod_3" maxlength="3" required>
                                    </div>

                                    <div class="col-sm-8"
                                        style="vertical-align: middle;display: flex;align-items: center;text-align: center;justify-content: center">
                                        <span>No me ha llegado el Codigo de confirmacion
                                    </div>
                                    <div class="col-sm-4" style="">
                                        <button type="button" class="btn btn-link" style="color: red; text-decoration: outline" id="reenviar_codigo">Reenviar
                                            código</button><span>
                                    </div>
                                    <div class="col-sm-12" style="margin-top: 5px">
                                        <button type="submit" class="btn btn-s-m btn-info btn-block"
                                            style="margin: 0px 5px">Validar</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_change_password" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cambiar de Contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <legend class="text-center">
                        <img src="#" id="imagen_codigo" style="width: 200px;height: 200px;border-radius: 5px">
                        <br>
                        <h2 id="codigo_full_name_password">A B</h2>
                        <small id="rol_name_password">A B</small>
                    </legend>
                    <form action="{{ route('usuario.change_password') }}" method="POST">
                        @method('POST')
                        @csrf
                        <input type="hidden" name="id_user_change" id="id_user_change">
                        <div class="row" id="cambio_contraseña">
                            <label class="col-sm-3 col-form-label">Nueva Contraseña:</label>
                            <div class="col-sm-9" style="padding-bottom: 10px">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="change_password"
                                        id="change_password" autocomplete="off" placeholder="******"
                                        required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-addon toggle-password" onclick="changetogglePassword()">
                                            <i class="fa fa-eye-slash" id="eye-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <label class="col-sm-3 col-form-label">Confirmar Contraseña:</label>
                            <div class="col-sm-9" style="padding-bottom: 10px">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="change_password2"
                                        id="change_password2" autocomplete="off" placeholder="******"
                                        required="required">
                                    <div class="input-group-append">
                                        <span class="input-group-addon toggle-password" onclick="changetogglePassword2()">
                                            <i class="fa fa-eye-slash" id="eye-icon"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3" style="margin-top: 5px">
                                <input type="checkbox" class="form-control" name="enviar_correo" id="enviar_correo">
                            </div>
                            <div class="col-sm-9">
                                <span class="text-bold">¿Enviar al correo del Usuario la nueva contraseña?</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
                            </div>
                        </div>
                    </form>
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
    <style>
        .table-responsive {
            overflow: visible !important;
        }

        select.form-control:not([size]):not([multiple]) {
            height: 100%;
        }

        .nav-tabs.dropdown-menu {
            left: -112px !important;
            /* padding: 10px 5px !important; */
        }

        #DataTables_Table_0_wrapper {
            /* padding-right: 0px; */
        }

        .table {
            width: 100% !important;
        }

        .ibox-content>.row {
            margin: auto;
        }

        .nav-tabs-right {
            margin-left: auto;
        }

        .search-responsive {
            padding-right: 15px;
            padding-left: 15px;
        }

        .tab-pane.active.show {
            border-right: 1px;
            border-left: 1px;
            border-bottom: 1px;
        }

        .btn-link {
            width: 100%;
        }

        /* OCULTANDO LO DE ORGANIZAR*/
        /* Ver (números) */
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

        .dropdown-menu {
            left: 70px;
            padding: 20px 0;
        }

        /* PANTALLA TABLET */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .row>.col-md-6 {
                margin-bottom: 12px;
            }
        }

        .slick-slider {
            margin-bottom: 0px;
        }

        .slick-prev {
            left: 20px;
        }

        .slick-next {
            right: 20px;
        }

        .slick-slider>button {
            z-index: 9999;
        }

        .slick-dots {
            display: none !important;
        }

        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        #DataTables_Table_0_wrapper {
            padding-bottom: 0px;
        }

        .column-actions {
            /* display: inline-flex; */
        }

        .wrapper-hover {
            position: relative;
            display: inline-block;
        }

        .contenedor {
            display: none;
            position: absolute;
            top: -80px;
            left: 20px;
            z-index: 20;
        }

        .wrapper-hover:hover .contenedor {
            display: block;
        }

        .mini-overlay {
            position: relative;
            width: 140px;
            background-color: #fff;
            color: #000;
            font-size: 12px;
            border-radius: 8px;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .info_overlay {
            text-decoration: underline;
            font-weight: bold;
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
            $('.dataTables-example-usuarios').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $('#tab-1-tab').addClass('active');
        });
        //Select2
        $(document).ready(function() {
            $('.multiple_permisos_select').select2();
        });

        $('#btn-nuevo-usuario').on('click', function() {
            $('#create_usuario').modal('show');
        });

        function modal_codigo(id_user) {
            $('#modal_submit_codigo').modal('show');
            $('#usuario_codigo_id').val(id_user);
            $.ajax({
                type: "post",
                url: "{{ route('pa.getUserData') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id_user
                },
                success: function(user) {
                    console.log(user);
                    let base = "{{ asset('/profile/images') }}/";
                    $('#imagen_codigo').attr('src', base + user.avatar);
                    $('#codigo_full_name').html(user.personal.full_name);
                    $('#codigo_rol_name').html(user.roles[0].name);
                    $('#correo_codigo').val(user.email);
                }
            });
        }

        $('#reenviar_codigo').on('click', function(){
            send_codigo_correo();
        });

        function send_codigo_correo(){
            let id_user = $('#usuario_codigo_id').val();
            let correo = $('#correo_codigo').val();
            $.ajax({
                type: "post",
                url: "{{ route('usuario.codigo_nuevo_correo', ['id' => '__ID__']) }}".replace('__ID__',
                    id_user),
                data: {
                    '_token': $('input[name=_token]').val(),
                    'correo': correo
                },
                success: function(response) {

                    // 🔔 Mostrar toastr dinámico
                    if (response.status === 'success') {
                        toastr.success(response.message, '', {
                            timeOut: 3000
                        });
                    } else {
                        toastr.warning(response.message, '', {
                            timeOut: 3000
                        });
                    }

                },
                error: function() {
                    toastr.error('Error en la petición AJAX', '', {
                        timeOut: 3000
                    });
                }
            });
        }
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
            // console.log(data);
            var id_rol = data.id;
            if (id_rol == 4) {
                console.log("Personalizado");
                $('#registrar_terminar').css('display', 'none');
                $('#permisos_terminar').css('display', 'flex');
            } else {
                console.log("Normal");
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

        function changetogglePassword() {
            const passwordInput = document.getElementById("change_password");
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

        function changetogglePassword2() {
            const passwordInput = document.getElementById("change_password2");
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

        $('#registrar_terminar').on('click', function(e) {
            var pass1 = $('#password').val();
            var pass2 = $('#password_2').val();
            if (pass1 != pass2) {
                toastr.warning("", 'Las contraseñas no son iguales', {
                    timeOut: 3000
                });
                return;
            }
            $('#send_true').click();
        });
        $('#permisos_terminar').on('click', function(e) {
            var pass1 = $('#password').val();
            var pass2 = $('#password_2').val();
            if (pass1 != pass2) {
                toastr.warning("", 'Las contraseñas no son iguales', {
                    timeOut: 3000
                });
                return;
            }
            $('#send_true').click();
        });
        $('#correo_codigo').on('keydown', function(){
            $('#cambiar_correo').attr('disabled', false);
        });
        $('#cambiar_correo').on('click', function() {
            send_codigo_correo();
        })

        $('.change_password_b').on('click', function() {
            console.log("a")
            let id_user = $(this).data('ids');
            let rol_name = $(this).data('rol');
            let name_user = $(this).data('name');

            $('#codigo_full_name_password').html(name_user);
            $('#rol_name_password').html(rol_name);
            $('#id_user_change').val(id_user);
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
