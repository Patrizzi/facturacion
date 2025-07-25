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
                            {{-- @include('transaccion\comprobantes\_shared\statistics') --}}
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
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                @include('planilla\_shared\tabs')
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
                                            {{-- <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" name="" id="select_tipo_coti">
                                                    <option value="" selected>Todos los comprobantes</option>
                                                    <option value="factura">Factura</option>
                                                    <option value="factura_manual">factura Manual</option>
                                                    <option value="boleta">Boleta</option>
                                                    <option value="boleta_manual">Boleta Manual</option>
                                                </select>
                                            </div> --}}
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
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
                                                    <th><input type="checkbox" checked class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Nombre y Apellidos</th>
                                                    <th>N° Documento</th>
                                                    <th>Correo</th>
                                                    <th>Celular</th>
                                                    <th>Fecha de Inicio</th>
                                                    <th>Cargo Ocupacional</th>
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

    <style>
        .table {
            width: 100% !important;
            border-collapse: collapse;
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

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('#tab-2-tab').addClass('active');
            var table = $('.dataTables-personal').DataTable({
                "serverSide": true,
                "processing": false,
                // ""
                "ajax": {
                    "url": "{{ route('api.get_personal') }}",
                    "type": "get",
                    data: function(d) {
                        // d._token = "{{ csrf_token() }}";
                        d.daterange = $('#data_range_filter').val();
                        d.estado = 0
                    }
                },
                "columnDefs": [{
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
            // });




            // $('.dataTables-personal').DataTable({
            //     pageLength: 25,
            //     responsive: true,
            //     dom: '<"html5buttons"B>lTfgitp',
            //     buttons: [{
            //             extend: 'copy'
            //         },
            //         {
            //             extend: 'csv'
            //         },
            //         {
            //             extend: 'excel',
            //             title: 'ExampleFile'
            //         },
            //         {
            //             extend: 'pdf',
            //             title: 'ExampleFile'
            //         },

            //         {
            //             extend: 'print',
            //             customize: function(win) {
            //                 $(win.document.body).addClass('white-bg');
            //                 $(win.document.body).css('font-size', '10px');

            //                 $(win.document.body).find('table')
            //                     .addClass('compact')
            //                     .css('font-size', 'inherit');
            //             }
            //         }
            //     ]

            // });

        });
    </script>
    <!-- Despliegue de la tabla para editar -->
    <script>
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
    </script>

    <script>
        document.getElementById('toggleButton').addEventListener('click', function() {
            const agregarRow = document.getElementById('agregarRow');
            if (agregarRow.style.display === 'none' || agregarRow.style.display === '') {
                agregarRow.style.display = 'table-row'; // Muestra la vista
            } else {
                agregarRow.style.display = 'none'; // Oculta la vista
            }
        });
    </script>

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