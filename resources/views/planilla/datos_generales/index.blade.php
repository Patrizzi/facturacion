@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal')
@section('breadcrumb2', 'Personal')
@section('href_accion', route('personal.create'))
@section('value_accion', 'Agregar')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            {{-- <!-- @include('transaccion.comprobantes._shared.statistics') --> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                @include('planilla._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    @can('personal.listar')
                                        <a href="{{ route('personal.create') }}" class="btn btn-success">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    @endcan
                                </ul>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-5" class="tab-pane active show">
                                    <br>
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter" value="" readonly="readonly" />
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
                                                <select class="form-control" name="" id="select_tipo_coti">
                                                    <option value="" selected>Todos</option>
                                                    <option value="Activo">Activo</option>
                                                    <option value="Desactivado">Desactivado</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-personal">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Nombre y Apellidos</th>
                                                    <th>N° Documento</th>
                                                    <th>Correo</th>
                                                    <th>Celular</th>
                                                    <th>Fecha de Vinculación</th>
                                                    <th>Cargo Ocupacional</th>
                                                    <td>@can('personal.ver') Ver @endcan</td>
                                                    <td>@can('personal.estado')Acciones @endcan</td>
                                                    <td>Informacion</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach ($personales as $index => $personal)
                                                    <tr>
                                                        <td><input type="checkbox" checked class="i-checks"
                                                                name="input[]"></td>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $personal->nombres }}</td>
                                                        <td>{{ $personal->apellidos }}</td>
                                                        <td>{{ $personal->numero_documento }}</td>
                                                        <td>{{ $personal->celular }}</td>
                                                        <td>{{ $personal->email }}</td>
                                                        <td><button type="button" class="btn btn-info"><i
                                                                    class="fa fa-check-circle"></i></button>
                                                            <button type="button" class="btn btn-success"><i
                                                                    class="fa fa-sort-down"></i></button></td>
                                                    </tr>
                                                @endforeach --}}
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
    {{-- Modal para Desactivar el personal --}}
    <div id="modal-anular" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" align="center">
                        <div class="col-sm-12 b-r">
                            <h3 class="m-t-none m-b">¿Seguro que desea anular el Personal&nbsp;<strong><span
                                        id="valor_ind_elim"></span></strong>?</h3>
                            <p>Este personal está registrado como usuario en el sistema o como personal de Venta, se va a desactivar el Personal</p>
                            <form id="formulario_anular" action=" {{ route('personal.desactivar_pe', ':id') }} "
                                enctype="multipart/form-data" method="post">
                                @csrf @method('POST')
                                <center><button type="submit" class="btn btn-w-m btn-danger">Anular</button></center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal para ELIMINAR un personal --}}
    <div id="modal-eliminar" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" align="center">
                        <div class="col-sm-12 b-r">
                            <h3 class="m-t-none m-b">¿Seguro que desea eliminar el Personal&nbsp;<strong><span
                                        id="valor_ind"></span></strong>?</h3>
                            <p>El usuario será eliminado del sistema</p>
                            <form id="formulario_eliminar" action=" {{ route('personal.destroy', ':id') }} "
                                enctype="multipart/form-data" method="post">
                                @csrf @method('DELETE')
                                <center><button type="submit" class="btn btn-w-m btn-danger">Eliminar</button></center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table {
            width: 100% !important;
            border-collapse: collapse;
        }
    </style>

    @include('planilla._shared.js_shared')

    <!-- Page-Level Scripts -->
    <script>
        function eliminar_pers(id, valor) {
            console.log(id);
            let form = document.getElementById('formulario_eliminar');
            let action = form.getAttribute('action');
            action = action.replace(':id', id);
            form.setAttribute('action', action);
            $('#valor_ind_elim').text(valor);
            $('#modal-eliminar').modal('show');
        }

        function desactivar_user(id, valor) {
            console.log(id);
            let form = document.getElementById('formulario_anular');
            let action = form.getAttribute('action');
            action = action.replace(':id', id);
            form.setAttribute('action', action);
            $('#valor_ind').text(valor);
            $('#modal-anular').modal('show');
        }

        // Hacer la función global
        window.desactivar_user = desactivar_user;
        window.eliminar_pers = eliminar_pers;

        $(document).ready(function() {
            $('#tab-1-tab').addClass('active');
            var permiso_ver = false;
            var permiso_estado = false;
            var table = $('.dataTables-personal').DataTable({
                "serverSide": true,
                "processing": false,
                "searching": false,
                "ajax": {
                    "url": "{{ route('api.get_personal') }}",
                    "type": "get",
                    data: function(d) {
                        // d._token = "{{ csrf_token() }}";
                        d.daterange = $('#data_range_filter').val();
                        d.value = $('#search_all_column').val();
                        d.estado = $('#select_tipo_coti').val();
                    },
                    dataSrc: function(json) {
                        permiso_ver = json.permiso_ver;
                        permiso_estado = json.permiso_estado;
                        return json.data;
                    }
                },
                "columnDefs": [{
                        'width': '1vmax',
                        'targets': [0],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            return '<input type="checkbox" name="select_row" value="' + full[2] +
                                '" class="i-checks-boleta">';
                        }
                    },
                    { // 'width': '0.5vmax',
                        'targets': [8],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url = '{{ route('personal.show', ':id') }}';
                            url = url.replace(':id', full[0]);
                            var button_view = ``;
                            if (permiso_ver) {
                                button_view += `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>`;
                            }
                            return button_view;
                        }
                    },
                    {
                        'targets': [9],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var button = ``;
                            if(permiso_estado){
                                if(full[11] != "Activo"){
                                    var attr_dis =  `disabled`;
                                }
                                if (full[10] || full[12] == 1) {
                                    button += `<a data-toggle="modal" class="btn btn-danger `+ attr_dis +`"  onclick="desactivar_user(` +
                                        full[0] + `, '` + full[2] +
                                        `')"><i class="fa fa-trash-o" style="color:white;font-size: 110%"></i></a>`;
                                } else {
                                    button += `<a data-toggle="modal" class="btn btn-danger `+ attr_dis +`"  onclick="eliminar_pers(` +
                                        full[0] + `, '` + full[2] +
                                        `')"><i class="fa fa-trash-o" style="color:white;font-size: 110%"></i></a>`;
                                }
                            }

                            return button;
                        }
                    },
                    {
                        // 'width': '0.5vmax',
                        'targets': [10],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url = '{{ route('personal.show', ':id') }}';
                            url = url.replace(':id', full[0]);
                            // Estado de Usario Registrado
                            var buttons = ``;
                            if (full[11] == "Activo") {
                                buttons += `
                                    <button type="button" class="btn btn-circle btn-info" title="Activo" disabled>
                                        <i class="fa fa-check"></i>
                                    </button>`;
                            } else {
                                buttons += `
                                    <button type="button" class="btn btn-circle btn-danger" title="Anulado" disabled>
                                        <i class="fa fa-times"></i>
                                    </button>`;
                            }
                            if (full[10]) {
                                buttons += `
                                    <button type="button" class="btn btn-circle btn-info" title="Usuario Creado" disabled>
                                        <i class="fa fa-user"></i>
                                    </button>`;
                            } else {
                                buttons += `
                                    <button type="button" class="btn btn-circle btn-danger" disabled>
                                        <i class="fa fa-user"></i>
                                    </button>`;
                            }
                            if (full[12] == 1) {
                                buttons += `
                                    <button type="button" class="btn btn-circle btn-info" title="Personal de Venta Activo" disabled>
                                        <i class="fa fa-reply-all"></i>
                                    </button>`;
                            } else {
                                buttons += `
                                    <button type="button" class="btn btn-circle btn-danger"  disabled>
                                        <i class="fa fa-reply-all"></i>
                                    </button>`;
                            }
                            return buttons;
                        }
                    }
                ],
                drawCallback: function() {
                    // $('[data-toggle="tooltip"]').tooltip();
                    // $('.i-checks-boleta').iCheck({
                    //     checkboxClass: 'icheckbox_square-green',
                    //     radioClass: 'iradio_square-green',
                    // });
                }
            });
            $('input[name="daterange"]').daterangepicker({
                "locale": {
                    "separator": " | ",
                    "applyLabel": "Guardar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                }
            });
            $(`#filter_buttons`).on('click', function() {
                table.ajax.reload();
            });
            $('#revert_select').on('click', function() {
                console.log("Revertir selección de fecha");
                $('#data_range_filter').val("");
                table.ajax.reload();
            });
        });
    </script>
    <!-- Despliegue de la tabla para editar -->
    {{-- <script>
        // Selecciona todos los botones con la clase toggle-row
        document.querySelectorAll('.toggle-row').forEach((button) => {
            button.addEventListener('click', () => {
                // Encuentra la fila oculta siguiente a la fila actual
                const detailsRow = button.closest('tr').nextElementSibling;

                // Alterna la visibilidad de la fila
                if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                    detailsRow.style.display = 'table-row';
                    // Cambia el ícono al caret-up
                    button.innerHTML = '<i class="fa fa-caret-up"></i>';
                } else {
                    detailsRow.style.display = 'none';
                    // Cambia el ícono al sort-down
                    button.innerHTML = '<i class="fa fa-sort-down"></i>';
                }
            });
        });
    </script> --}}

    {{-- <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            const agregarRow = document.getElementById('agregarRow');
            if (agregarRow.style.display === 'none' || agregarRow.style.display === '') {
                agregarRow.style.display = 'table-row'; // Muestra la vista
            } else {
                agregarRow.style.display = 'none'; // Oculta la vista
            }
        });
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
