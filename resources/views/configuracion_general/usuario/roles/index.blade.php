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
                                        <a href="{{route('roles.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i></a>
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
                                                    {{-- @foreach ($roles as $rol)
                                                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                                    @endforeach --}}
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
                                                        <th>Nombre del Rol</th>
                                                        <th>Usuarios Asignados</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roles as $id => $rol)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox">
                                                            </td>
                                                            <td>{{ $rol->name }}</td>
                                                            <td></td>
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

    {{-- @include('configuracion_general.usuario.roles.create') --}}

    <style>
        @media (min-width: 992px) {
            .modal-lg {
                max-width: 90%;
            }
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
