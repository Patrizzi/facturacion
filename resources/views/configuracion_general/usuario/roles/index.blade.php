@extends('layout')
@section('title', 'Roles del Usuarios')
@section('href_accion', route('usuario.lista'))
@section('value_accion', 'Agregar')
@section('button2', 'Atras')
{{-- @section('config', route('Configuracion')) --}}
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
                                        <a href="{{ route('roles.create') }}" class="btn btn-primary"><i
                                                class="fa fa-plus"></i></a>
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
                                            <table class="table table-striped table-bordered dataTables-example-roles"
                                                style="min-width: 982px">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <input type="checkbox" class="i-checks" name="input[]">
                                                        </th>
                                                        <th>Nombre del Rol</th>
                                                        <th>Usuarios Asignados</th>
                                                        <th>Descripcion</th>
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
                                                            <td>
                                                                @if($rol->id == 4)
                                                                    {{$count_perso}}
                                                                @else
                                                                    {{ $rol->users->count() }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $rol->description }}</td>
                                                            <td>
                                                                {{-- <button class="btn btn-primary" data-target=""><i class="fa fa-pencil"></i></button> --}}
                                                                <a
                                                                    @if ($rol->id != 2 && $rol->id != 4 ) class="btn btn-primary"  href="{{ route('roles.edit', $rol->id) }}" @else class="btn btn-primary disabled" href="#" @endif>
                                                                    <i st class="fa fa-pencil"></i>
                                                                </a>
                                                                <a href="#modal-usuarios-roles" class="btn btn-secondary modal_usuarios_rol"
                                                                    data-toggle="modal" title="Usuarios"
                                                                    data-ids="{{ $rol->id }}" data-name="{{ $rol->name }}">
                                                                    <i class="fa fa-user"></i>
                                                                </a>
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

    {{-- @include('configuracion_general.usuario.roles.create') --}}
    <!-- modal - Familias -->
    <div id="modal-usuarios-roles" class="modal fade bd-example-modal-lg" style="display: none;" aria-modal="true"
        data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel6">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel6">Usuarios pertenecientes al Rol: <strong
                            id="rols_name"></strong></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="lista_roles" class="row">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- <style>
        @media (min-width: 992px) {
            .modal-lg {
                max-width: 90%;
            }
        }
    </style> --}}
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

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.dataTables-example-roles').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $('#tab-2-tab').addClass('active');
        });

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

        $('.modal_usuarios_rol').on('click', function() {
            $('#lista_roles').empty();
            let rol_id = $(this).data('ids');
            let rol_nam = $(this).data('name');
            $('#rols_name').html(rol_nam);
            $.ajax({
                type: "post",
                url: "{{ route('pa.getRolesXUserData') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'rol_id': rol_id
                },
                success: function(msg) {
                    let html = '';
                    if (!msg || msg.length === 0) {
                        $('#lista_roles').html('<div class="col-sm-12"><h3 class="text-muted text-center">No hay registros</h3></div>');
                        return;
                    }

                    msg.forEach(function(item) {
                        html += `
                            
                            <div class="col-md-6 mb-12">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body d-flex align-items-center" style="column-gap: 5px ">
                                        <div class="me-3">
                                            <i class="fa fa-user-circle fa-2x text-primary"></i>
                                        </div>

                                        <!-- TEXTO -->
                                        <div>
                                            <h4 class="mb-0">${item.personal.full_name}</h4>
                                            <small class="text-muted">ID: ${item.id}</small>
                                        </div>

                                    </div>
                                </div>
                            </div>
                         `;
                    });

                    $('#lista_roles').html(html);
                }
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
