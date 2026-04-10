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
                        <form action="{{ route('roles.update', $rol->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-3 text-center">
                                    <img src="{{ asset('/img/logos/usuarios.svg') }}" style="width: 200px" alt="">
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="col-form-label"><strong>Nombre del Rol</strong></label>
                                        <input type="text" class="form-control" name="name" id=""
                                            value="{{ $rol->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><strong>Descripcion</strong></label>
                                        <input type="text" class="form-control" value="{{$rol->descripcion}}"
                                            name="descripcion" id="descripcion" >
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                                </div>
                            </div>
                            <hr>
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
                                                    <div class="checkbox checkbox-primary" style="padding-left: 0px">
                                                        <input type="checkbox" class="check-modulo"
                                                            id="modulo_{{ $moduloSlug }}"
                                                            data-modulo="{{ $moduloSlug }}"
                                                            onclick="check_modulo(this, '{{ $moduloSlug }}')">

                                                        <label for="modulo_{{ $moduloSlug }}" style="margin-bottom: 0px;">
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
                                                                    $uniqueId = $moduloSlug . '_' . $prefijoSlug;
                                                                @endphp

                                                                <div class="col-6" style="margin-bottom:10px">

                                                                    <div
                                                                        style="display:flex; justify-content:space-between; align-items:center">
                                                                        <div style="display:flex; align-items:center">
                                                                            <input type="checkbox"
                                                                                class="check-prefijo modulo_{{ $moduloSlug }}"
                                                                                data-modulo="{{ $moduloSlug }}"
                                                                                data-prefijo="{{ $prefijoSlug }}"
                                                                                onclick="check_submodulo(this, '{{ $moduloSlug }}', '{{ $prefijoSlug }}')"
                                                                                id="prefijo_{{ $uniqueId }}">

                                                                            <label for="prefijo_{{ $uniqueId }}"
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
                                                                                    explode('.', $permiso->name)[1] ??
                                                                                    '';
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

    <script>
        $(document).ready(function() {
            actualizar_prefijos();
            actualizar_modulos();
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
@endsection
