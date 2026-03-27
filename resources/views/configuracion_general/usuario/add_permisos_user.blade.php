@extends('layout')
@section('title', auth()->user()->personal->nombres)
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
                                <div class="col-md-9">
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Personal:</label>
                                        <div class="col-sm-4" style="padding-bottom: 10px">
                                            <input type="text" class="form-control" value="{{ $personal->full_name }}"
                                                name="" id="">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Correo:</label>
                                        <div class="col-sm-4" style="padding-bottom: 10px">
                                            <input type="text" class="form-control" name="correo" id="correo"
                                                value="{{$datos->correo}}" required="required" autocomplete="off">
                                        </div>

                                        <label class="col-sm-2 col-form-label">Contraseña:</label>
                                        <div class="col-sm-4" style="padding-bottom: 10px">
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password" id="password"
                                                    autocomplete="off" placeholder="******" required="required"
                                                    value="{{ $datos->password }}">
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
                                                <input type="password" class="form-control" name="password_2"
                                                    value="{{ $datos->password_2 }}" id="password_2" autocomplete="off"
                                                    placeholder="******" required="required">
                                                {{-- <input type="password" class="form-control" name="password" id="password"
                                                    autocomplete="off" placeholder="******" required="required"> --}}
                                                <div class="input-group-append">
                                                    <span class="input-group-addon toggle-password"
                                                        onclick="togglePassword2()">
                                                        <i class="fa fa-eye-slash" id="eye-icon2"></i>
                                                        <!-- Cambiado a "fa-eye-slash" -->
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Rol:</label>
                                        <div class="col-sm-4" style="padding-bottom: 10px">
                                            <input type="text" class="form-control" value="{{ $rol->name }}"
                                                name="" id="" readonly>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           {{-- <div class="checkbox checkbox-primary">
                <input id="checkbox2" type="checkbox" >
                <label for="checkbox2">
                    Primary
                </label>
            </div> --}}
            <div class="animated fadeInRight">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h4>Permisos Personalizado del Usuario</h4>
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
                                    <div class="col-sm-12" style="">
                                        <p>Seleccione un Rol predefinido para seleccionar Permisos Automaticamente</p>
                                        @foreach ($roles as $rol)
                                            <button class="btn btn-primary btn-outline">{{$rol->name}}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    @php $i = 0; @endphp
                                    @foreach ($permisos as $modulo => $prefijos)
                                        @php $moduloSlug = Str::slug($modulo); @endphp
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="panel-group" id="modulo-{{ $moduloSlug }}">
                                                <!-- NIVEL 1: MODULO -->
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" style="display: flex">
                                                        <div class="checkbox checkbox-primary" style="padding-left: 0px">
                                                            <input type="checkbox" name="" id="forcheck_{{$i}}" class="" onclick="check_modulo(this,`{{$modulo}}`)">
                                                            <label for="forcheck_{{$i}}" style="margin-bottom: 0px;margin">
                                                                <h5 class="panel-title" style="margin-bottom: 0px;font-size:15px">
                                                                    <a data-toggle="collapse"
                                                                        href="#collapse-modulo-{{ $moduloSlug }}">
                                                                        {{ Str::of($modulo)->replace('_', ' ')->title() }}
                                                                    </a>
                                                                </h5>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div id="collapse-modulo-{{ $moduloSlug }}"
                                                        class="panel-collapse collapse show">
                                                        <div class="panel-body">
                                                            <!-- NIVEL 2: PREFIJOS -->
                                                            <div class="panel-group" id="prefijo-{{ $moduloSlug }}">
                                                                <div class="row">
                                                                    @foreach ($prefijos as $prefijo => $listaPermisos)
                                                                        {{-- {{ $i }} --}}
                                                                        @php $prefijoSlug = Str::slug($prefijo); @endphp
                                                                        <div class="col-6"
                                                                            style="margin-bottom: 5px;display: flex;flex-direction: column;justify-content: space-between;"
                                                                            id="lista_permisos">
                                                                            <div>
                                                                                <label for=""
                                                                                    style="display: flex;margin-bottom: 2px;justify-content: space-between;">
                                                                                    <input type="checkbox"
                                                                                        name="permissions[]"
                                                                                        value="{{ $prefijo }}" class="modulo_{{$modulo}}" onclick="check_submodulo(this,`{{$modulo}}`,`{{$prefijo}}`)">
                                                                                        <span
                                                                                            style="margin-left: 5px"><h4 style="margin: 0px">{{ Str::title($prefijo) }}</h4>
                                                                                        </span>
                                                                                    <div>
                                                                                        <span>
                                                                                            <a id="modulo_arrow" onclick="abrir_modulo(this,{{$i}})">
                                                                                                <i class="fa fa-toggle-down" ></i>
                                                                                            </a>
                                                                                        </span>
                                                                                    </div>
                                                                                </label>
                                                                                <!-- NIVEL 3: ACCIONES -->
                                                                                <div style="margin-left: 15px ;display: none;" id="div_{{$i}}">
                                                                                    @foreach ($listaPermisos as $permiso)
                                                                                        @php
                                                                                            $accion =
                                                                                                explode(
                                                                                                    '.',
                                                                                                    $permiso->name,
                                                                                                )[1] ?? '';
                                                                                        @endphp
                                                                                        <div class="">
                                                                                            <span
                                                                                                style="display: flex;align-items: center;justify-content: space-between;">
                                                                                                <span
                                                                                                    style="display: flex;">
                                                                                                    <input type="checkbox"
                                                                                                        name="permissions[]"
                                                                                                        value="{{ $permiso->id }}"
                                                                                                        class="modulo_{{$modulo}} permisos_{{$prefijo}}">
                                                                                                    {{ Str::of($accion)->replace('_', ' ')->title() }}
                                                                                                </span>
                                                                                                <div class="tooltip-demo"
                                                                                                    style="display: contents">
                                                                                                    <button
                                                                                                        class="btn btn-link btn-xs"
                                                                                                        data-toggle="tooltip"
                                                                                                        data-placement="bottom"
                                                                                                        title="{{ $permiso->description }}">
                                                                                                        <i style="font-size: 9px"
                                                                                                            class="fa fa-info-circle"></i>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </span>

                                                                                            {{-- @if ($permiso->description)
                                                                                                <small
                                                                                                    class="text-muted d-block">
                                                                                                    {{ $permiso->description }}
                                                                                                </small>
                                                                                            @endif --}}
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                            <hr style="margin:5px 0px">
                                                                        </div>
                                                                        @php $i++; @endphp
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <form action="{{ route('usuario.update', auth()->user()->id) }}" enctype="multipart/form-data"
                method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-4">
                        <div class="ibox ">
                            <div>
                                <div class="ibox-content no-padding border-left-right">
                                    {{-- <img  class="img-fluid" src="{{ asset('/profile/images/')}}/{{auth()->user()->avatar}}" > --}}

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
            </form>

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
        .checkbox label::before{
            margin-top: 5px;
        }
        .checkbox-primary input[type="checkbox"]:checked + label::after, .checkbox-primary input[type="radio"]:checked + label::after{
            margin-top: 7px;
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
    {{-- <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }} "></script> --}}

    <script>
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

        function abrir_modulo(icon,item){
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
        function check_modulo(check,modulo){
            // console.log(modulo);
            // var permisos = document.querySelectorAll('input.'+modulo);
            // console.log(permisos[0]);
            // $(`input.`+modulo).prop('checked', true).trigger('change');

            $(`input.modulo_`+modulo).each(function () {
                $(this)
                    .prop('checked', !$(this).prop('checked'))
                    .trigger('change');
            });
        }
        function check_submodulo(check,modulo,submodulo){
            // console.log(`input.modulo_`+modulo+`_permisos_`+submodulo);
            // var permisos = document.querySelectorAll('input.'+submodulo);
            $(`input.modulo_`+modulo+`.permisos_`+submodulo).each(function () {
                $(this)
                    .prop('checked', !$(this).prop('checked'))
                    .trigger('change');
            });
        }
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
@endsection
