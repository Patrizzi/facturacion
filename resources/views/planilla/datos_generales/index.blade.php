@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal')
@section('breadcrumb2', 'Personal')
@section('href_accion', route('personal.create'))
@section('value_accion', 'Agregar')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">+
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
                                        <a href="{{route('personal.create')}}" class="btn btn-success">
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
                                                    <td>Usuario</td>
                                                    <td>Ver</td>
                                                    {{-- <td>Acciones</td> --}}
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

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>N° Documento</th>
                                        <th>Celular</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                        <th>Foto</th>
                                        <th>Ver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($personales as $index => $personal)
                                        <tr class="gradeX">
                                            <td>{{ $index }}</td>
                                            <td>{{ $personal->nombres }}</td>
                                            <td>{{ $personal->apellidos }}</td>
                                            <td>{{ $personal->numero_documento }}</td>
                                            <td>{{ $personal->celular }}</td>
                                            <td>{{ $personal->email }}</td>
                                            <td>{{ $personal->estado_trabajador_laboral }}</td>
                                            <td><img src="
                                                        {{ asset('/profile/images/') }}/{{ $personal->foto }}"
                                                    style="width: 45px;">
                                            </td>
                                            <td>
                                                <center><a href="{{ route('personal.show', $personal->id) }}"><button
                                                            type="button" class="btn btn-s-m btn-primary">VER</button></a>
                                                </center>
                                            </td>
                                                    <td><center><a href="{{ route('personal.edit', $personal->id) }}" ><button type="button" class="btn btn-s-m btn-success">Editar</button></a></center></td>
     <td>
                                                        <center>
                                                            <form action="{{ route('personal.destroy', $personal->id)}}" method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-s-m btn-danger">Eliminar</button>
                                                            </form>
                                                        </center>
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

    <style>
        .table {
            width: 100% !important;
            border-collapse: collapse;
        }
    </style>

    @include('planilla._shared.js_shared')

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('#tab-1-tab').addClass('active');
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
                        d.estado = 1
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
                    }, {
                        // 'width': '0.5vmax',
                        'targets': [8],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url = '{{ route('personal.show', ':id') }}';
                            url = url.replace(':id', full[0]);
                            return `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a> `;
                        }
                    },
                    {   // 'width': '0.5vmax',
                        'targets': [9],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url = '{{ route('personal.show', ':id') }}';
                            url = url.replace(':id', full[0]);
                            return `<a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a> `;
                        }
                    }
                    // {
                    //     'targets': [9],
                    //     'orderable': false,
                    //     'render': function(data, type, full, meta) {
                    //         var url = '{{ route('personal.edit', ':id') }}';
                    //         url = url.replace(':id', full[0]);
                    //         return `<a href="${url}">
                //                     <button type0="button" class="btn btn-success">
                //                         <i class="fa fa-edit"></i>
                //                     </button>`;
                    //     }
                    // }
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
            // $('.dataTables-personal').DataTable({
            //     pageLength: 5,
            //     responsive: true,
            //     dom: '<"html5buttons"B>lTfgitp',
            //     buttons: []
            // });
        });
    </script>
@endsection
