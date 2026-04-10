@extends('layout')
@section('title', 'Usuario')
@section('href_accion', route('usuario.lista'))
@section('value_accion', 'Agregar')
@section('button2', 'Atras')
@section('config', route('Configuracion'))
@section('content')

    <div class="wrapper wrapper-content animated fadeInRight" style="padding-bottom: 0px">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Crear un Rol y asignar Permisos</h4>
                        <div class="ibox-tools custom">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-sm-3 text-center">
                                    <img src="{{ asset('/img/logos/usuarios.svg') }}" style="width: 200px" alt="">
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="col-form-label"><strong>Nombre del Rol</strong></label>
                                        <input type="text" class="form-control" name="name" id="">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><strong>Descripcion</strong></label>
                                        <input type="text" class="form-control" value=""
                                            name="descripcion" id="descripcion">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Guardar</button>
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
                                                        <input type="checkbox" name=""
                                                            id="forcheck_{{ $i }}" class=""
                                                            onclick="check_modulo(this,`{{ $modulo }}`)">
                                                        <label for="forcheck_{{ $i }}"
                                                            style="margin-bottom: 0px;margin">
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
                                                                                <input type="checkbox" name="permissions[]"
                                                                                    value="{{ $prefijo }}"
                                                                                    class="modulo_{{ $modulo }}"
                                                                                    onclick="check_submodulo(this,`{{ $modulo }}`,`{{ $prefijo }}`)">
                                                                                <span style="margin-left: 5px">
                                                                                    <h4 style="margin: 0px">
                                                                                        {{ Str::title($prefijo) }}</h4>
                                                                                </span>
                                                                                <div>
                                                                                    <span>
                                                                                        <a id="modulo_arrow"
                                                                                            onclick="abrir_modulo(this,{{ $i }})">
                                                                                            <i
                                                                                                class="fa fa-toggle-down"></i>
                                                                                        </a>
                                                                                    </span>
                                                                                </div>
                                                                            </label>
                                                                            <!-- NIVEL 3: ACCIONES -->
                                                                            <div style="margin-left: 15px ;display: none;"
                                                                                id="div_{{ $i }}">
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
                                                                                            <span style="display: flex;">
                                                                                                <input type="checkbox"
                                                                                                    name="permissions[]"
                                                                                                    value="{{ $permiso->id }}"
                                                                                                    class="modulo_{{ $modulo }} permisos_{{ $prefijo }}">
                                                                                                {{ Str::of($accion)->replace('_', ' ')->title() }}
                                                                                            </span>
                                                                                            <div class="tooltip-demo"
                                                                                                style="display: contents">
                                                                                                <button type="button"
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script>
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

        function check_modulo(check, modulo) {
            // console.log(modulo);
            // var permisos = document.querySelectorAll('input.'+modulo);
            // console.log(permisos[0]);
            // $(`input.`+modulo).prop('checked', true).trigger('change');

            $(`input.modulo_` + modulo).each(function() {
                $(this)
                    .prop('checked', !$(this).prop('checked'))
                    .trigger('change');
            });
        }

        function check_submodulo(check, modulo, submodulo) {
            // console.log(`input.modulo_`+modulo+`_permisos_`+submodulo);
            // var permisos = document.querySelectorAll('input.'+submodulo);
            $(`input.modulo_` + modulo + `.permisos_` + submodulo).each(function() {
                $(this)
                    .prop('checked', !$(this).prop('checked'))
                    .trigger('change');
            });
        }
    </script>
@endsection
