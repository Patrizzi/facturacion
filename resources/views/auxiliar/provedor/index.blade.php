@extends('layout')
@section('title', 'Provedor')
@section('breadcrumb', 'Provedor')
@section('breadcrumb2', 'Provedor')

@section('data-toggle', 'modal')
@section('href_accion', '#ModalProvedor')
@section('value_accion', 'Agregar')

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
@section('content')
    @if ($errors->any())
        <div style="padding-top: 20px;">
            <div class="alert alert-danger">
                <a class="alert-link" href="#">
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </a>
            </div>
        </div>
    @endif


    {{-- <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            @include('auxiliar.provedor._shared.statics')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                <div class="nav nav-custom">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('provedor.index') }}" id="tab-1-tab">
                                            <span class="badge badge-success"
                                                style="background-color : var(--primary);">0</span>
                                            Proveedores
                                        </a>
                                    </li>
                                </div>
                                {{-- Almacen --}}
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    {{-- ALMACEN --}}
                                    <button class="btn btn-success" data-toggle="modal" href="#nuevoProveedorModal">
                                        <i class="fa fa-plus"></i>

                                    </button>
                                    <button class="btn btn-success" type="button">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter" {{-- value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" --}} readonly="readonly" />
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
                                                    <option value="boleta">Boleta</option>
                                                    <option value="nota_venta">Nota de Venta</option>
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
                                    <br>{{--  Tabla de Cotizacion Manual   --}}
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>RUC</th>
                                                    <th>Empresa</th>
                                                    <th>Dirección</th>
                                                    <th>Teléfono</th>
                                                    <th>Correo</th>
                                                    <th>Contacto</th>
                                                    {{-- <th>Edig</th> --}}
                                                    <th style="width: 0.5vmax !important">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

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

    {{-- MODAL EDITAR --}}
    <div class="modal fade" id="editar_proveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditProveedor">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id">
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label fw-bold">N°
                                Ruc:</strong>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="ruc_prov" name="ruc"
                                        placeholder="Ingrese el RUC del Proveedor" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="btn-validar-ruc-editar">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label fw-bold">Empresa:</strong>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="razon_social_prov_edit" name="nombre"
                                    placeholder="Ingrese Nombre de la Empresa">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label fw-bold">Dirección:</strong>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="direccion_prov_edit" name="direccion"
                                    placeholder="Ingrese la Dirección">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label fw-bold">Teléfono:</strong>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="telefono" name="telefonos"
                                    placeholder="Ingrese el número de Teléfono">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label fw-bold">Correo:</strong>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="correo" name="correo"
                                    placeholder="Ingrese el Correo">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label fw-bold">Contacto:</strong>
                            <div class="col-sm-10">
                                <input type="text" name="contacto_provedor" id="" class="form-control"
                                    placeholder="Ingrese el nombre del contacto">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label fw-bold">Celular:</strong>
                            <div class="col-sm-10">
                                <input type="text" name="celular_provedor" id="" class="form-control"
                                    placeholder="Ingrese el celular del contacto">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label fw-bold">Correo:</strong>
                            <div class="col-sm-10">
                                <input type="email" name="email_provedor" id="" class="form-control"
                                    placeholder="Ingrese el correo del contacto">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label fw-bold">Observación:</strong>
                            <div class="col-sm-10">
                                <input type="text" name="observacion" id="" class="form-control"
                                    placeholder="Ingrese una observación">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="edit_actualizar">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        <style>select.form-control:not([size]):not([multiple]) {
            height: 100%;
        }

        .dropdown-menu {
            left: 70px;
            padding: 20px 0;
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
            /* Esto empuja el tab hacia la derecha */
        }

        .search-responsive {
            padding-right: 15px;
            padding-left: 15px;
        }

        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
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

        /* PANTALLA TABLET */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .row>.col-md-6 {
                margin-bottom: 12px;
            }
        }
    </style>

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
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Jquery Validate -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>

    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
    {{-- @include('layout_agregado_rapido') --}}
    {{-- scritp de modal agregar --}}
    <script>
        $(document).ready(function() {
            var proveedor_table = $('.dataTables-example').DataTable({
                "pageLength": 15,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_proveedor') }}",
                    method: "get",
                    data: function(d) {
                        d.daterange = $('#data_range_filter').val();
                        d.value = $('#search_all_column').val();
                    },
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
                    {
                        'targets': [1],
                        'orderable': false
                    },
                    {
                        'targets': [2],
                        'orderable': false
                    },
                    {
                        'width': '20%',
                        'targets': [3],
                        'orderable': false
                    },
                    {
                        'width': '30%',
                        'targets': [4],
                        'orderable': false
                    },
                    {
                        'targets': [5],
                        'orderable': false
                    },
                    {
                        'targets': [6],
                        'orderable': false
                    },
                    {
                        'targets': [7],
                        'orderable': false
                    },
                    {
                        // 'width': '4vmax',
                        'targets': [8],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            if (full[9] == '1') {
                                return `
                                <div class="tooltip-demo">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar_proveedor" onclick="editar(` +
                                    full[0] + `)"> <i class="fa fa-pencil"></i> </button>
                                    <button type="button" class="btn btn-info" onclick="estado(` + full[0] + `,` +
                                    full[9] + `)"><i class="fa fa-check" ></i></button>
                                </div>`;
                            } else {
                                // var
                                return `
                                <div class="tooltip-demo">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editar_proveedor" onclick="editar(` +
                                    full[0] + `)"> <i class="fa fa-eye"></i> </button>
                                    <button type="button" class="btn btn-danger" onclick="estado(` + full[0] + `,` +
                                    full[9] + `)"><i class="fa fa-times"></i></button>
                                </div>`;
                            }
                        }
                    }
                ],
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
                proveedor_table.ajax.reload();
            });
        });

        function editar(id) {
            $('#formEditProveedor')[0].reset();
            var url = "{{ route('provedor.edit', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    console.log(data);
                    $('#formEditProveedor').find('input[id="id"]').val(data.id);
                    $('#formEditProveedor').find('input[name="ruc"]').val(data.ruc);
                    $('#formEditProveedor').find('input[name="nombre"]').val(data.empresa);
                    $('#formEditProveedor').find('input[name="direccion"]').val(data.direccion);
                    $('#formEditProveedor').find('input[name="telefonos"]').val(data.telefonos);
                    $('#formEditProveedor').find('input[name="correo"]').val(data.email);
                    $('#formEditProveedor').find('input[name="contacto_provedor"]').val(data.contacto_provedor);
                    $('#formEditProveedor').find('input[name="celular_provedor"]').val(data.celular_provedor);
                    $('#formEditProveedor').find('input[name="email_provedor"]').val(data.email_provedor);
                    $('#formEditProveedor').find('input[name="observacion"]').val(data.observacion);
                    $('#editar_proveedor').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Error al cargar los datos del proveedor.');
                }
            });
        }

        function estado(id, estado) {
            var url = "{{ route('provedor.estado', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    estado: estado
                },
                success: function(response) {
                    $('.dataTables-example').DataTable().ajax.reload();
                    toastr.success("Estado actualizado correctamente.", 'Éxito', {
                        timeOut: 3000
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                    toastr.error("Error al actualizar el estado.", 'Error', {
                        timeOut: 3000
                    });
                }
            });
        }
        $('#edit_actualizar').on('click', function(e) {
            e.preventDefault();
            var formData = $('#formEditProveedor').serialize();
            var id = $('#formEditProveedor').find('input[name="id"]').val();
            var url = "{{ route('provedor.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                data: formData,
                success: function(response) {
                    console.log(response);
                    $('#editar_proveedor').modal('hide');
                    $('.dataTables-example').DataTable().ajax.reload();
                    toastr.success("Proveedor actualizado correctamente.", 'Éxito', {
                        timeOut: 3000
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Error al actualizar el proveedor. Por favor, inténtelo de nuevo.');
                }
            });
        });

        $('#btn-validar-ruc-editar').on('click', function() {
        var ruc = $('#ruc_prov').val();
        if (ruc) {
            $.ajax({
                url: '{{ url('provedorruc') }}',
                type: 'GET',
                data: {
                    ruc: ruc
                },
                success: function(data) {
                    console.log(data);
                    if (data.length > 0) {
                        $('#razon_social_prov_edit').val(data[1]);
                        $('#direccion_prov_edit').val(data[2]);
                    } else {
                        toastr.error("No se encontró información para el RUC proporcionado.",
                            'Verifique el RUC', {
                                timeOut: 3000
                            });
                    }
                },
                error: function() {
                    toastr.error("Error al validar el RUC.",
                        'Verifique el RUC', {
                            timeOut: 3000
                        });
                }
            });
        } else {
            toastr.warning("Por favor, ingrese un RUC válido.",
                'Verifique el RUC', {
                    timeOut: 3000
                });
        }
    });
    </script>
    @include('auxiliar.provedor._shared.create_modal')
@endsection
