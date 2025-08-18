@extends('layout')
@section('atributo_actu', 'hidden')
@section('title', 'Servicios')
@section('value_accion', 'Agregar')
@section('href_accion', route('servicios.create'))

@section('content')
    <!--Inicio del código actual (14/11/2024)-->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row d-flex justify-content-center">
                            @include('producto_servicios.servicios.shared.stadistics')
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
                                @include('producto_servicios.servicios.shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
            
                                    <div class="btn btn-sm btn-primary dropdown" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa fa-download text-secondary"
                                            style="cursor: pointer;color: white !important"></i>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <button class="dropdown-item" onclick="exportarTodo(event)"
                                                style="width: 100%;">
                                                <i class="fa fa-file-excel mr-2"></i>
                                                Exportar Todo
                                            </button>
                                            <button class="dropdown-item" id="exportSelected" style="width: 100%;">
                                                <i class="fa fa-file-pdf mr-2"></i>
                                                Exportar Selecionados
                                            </button>
                                        </div>
                                    </div>

                                    {{-- forms ocultos exportar productos --}}
                                    <form id="formExportProdAll" action="{{ route('export.excel') }}" method="GET"
                                        style="display: none;"></form>

                                </ul>
                            </ul>
                            <div class="tabs-content">
                                <div class="tab-pane active show" id="tab-2">
                                    <br>
                                    <div class="search-responsive" style="padding-right: 15px;padding-left: 15px;">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter"
                                                        value=""
                                                        readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                {{-- <select class="form-control" name="" id="select_tipo_coti">
                                                    <option value="" selected>Todos los comprobantes</option>
                                                    <option value="factura">Factura</option>
                                                    <option value="boleta">Boleta</option>
                                                    <option value="nota_venta">Nota de Venta</option>
                                                </select> --}}
                                            </div>
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
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Código Servicio</th>
                                                    <th>Código Original</th>
                                                    <th>Nombre</th>
                                                    <th>Familia</th>
                                                    <th>P. Venta (
                                                        <strong>{{ $moneda->where('tipo', 'nacional')->pluck('simbolo')->first() }}</strong>
                                                        )
                                                    </th>
                                                    <th>P. Venta (
                                                        <strong>{{ $moneda->where('tipo', 'extranjera')->pluck('simbolo')->first() }}</strong>
                                                        )
                                                    </th>
                                                    <th><i class="fa fa-sliders" style="cursor: pointer;"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"></th>
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
    <style>
        .table {
            width: 100% !important;
        }

        .nav-link.active,
        .nav.nav-tabs>.nav-custom {
            /* border-bottom: none; */
        }

        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        .pie-md {
            max-width: 17%; //270
            max-height: 50%; //400
        }

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

        /* Tamaño de los botones del index */
        .tam {
            min-width: 150px;
            min-height: 150px;
            */
        }

        input#fotoIntupEdit,
        input#archivoInputCreate {
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            width: 100%;
            /*height:100%;*/
            opacity: 0;
            padding: 30px;
        }

        #visorArchivoEdit,
        #visorArchivoCreate {
            width: 100%;
            height: auto;
            min-height: 250px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 2px solid #ced4da;
            border-radius: 6px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        #visorArchivoEdit img[name="foto"],
        #visorArchivoCreate img[name="foto"] {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease-in-out;
        }
    </style>


    <!--Fin del código actual-->


    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <!-- d3 and c3 charts -->
    <script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('#tab-2').addClass('active');
            $('.scroll_content').slimscroll({
                height: '450px'
            })
            const destroyBaseUrl = "{{ url('servicios_destroy') }}";
            // $('#tab-1').addClass('active')
            var servicios_table = $('.dataTables-example').DataTable({
                pageLength: 15,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_servicios') }}",
                    method: "get",
                    data: function(d) {
                        d.daterange = $('#data_range_filter').val();
                        d.estado_anular = 1;
                        d.value = $('#search_all_column').val();
                    }
                },
                "columnDefs": [{
                        'width': '1vmax',
                        'targets': [0],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            return '<input type="checkbox" name="select_row" value="' + full[
                                    2] +
                                '" class="i-checks-boleta">';
                        }
                    },
                    {
                        'targets': [7],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var data =
                                `
                        <div class="dropdown d-inline">
                            <i class="fa fa-ellipsis-h text-secondary" style="cursor:pointer;" id="dropdownMenuIcon1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"></i>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIcon1">

                                <a class="dropdown-item edit-servicio"  data-toggle="modal" href="#EditServicio" data-id="` +
                                full[8]['id'] +
                                `" data-codigo_servicio="` + full[8]['codigo_servicio'] +
                                `" data-codigo_original="` + full[8]['codigo_original'] +
                                `" data-familia_id="` + full[8]['familia_id'] +
                                `" data-subfamilia_id="` + full[8]['subfamilia_id'] +
                                `" data-marca_id="` + full[8]['marca_id'] +
                                `" data-moneda_id="` + full[8]['moneda_id'] +
                                `" data-nombre="` + full[8]['nombre'] +
                                `" data-precio_nacional="` + full[8]['precio_nacional_float'] +
                                `" data-precio_extranjero="` + full[8]['precio_extranjero_float'] +
                                `" data-utilidad="` + full[8]['utilidad'] +
                                `" data-descuento="` + full[8]['descuento'] +
                                `" data-descripcion="` + full[8]['descripcion'] +
                                `" data-foto="` + full[8]['foto'] +
                                `" data-tipo_afectacion_id="` + full[8]['tipo_afectacion_id'] +
                                `" data-estado_anular="` + full[8]['estado_anular'] +
                                `" data-fecha_creacion="` + full[8]['fecha_creacion'] + `"> +
                                    Editar
                                </a>

                            </div>
                        </div>`;
                            return data;
                        }
                    }
                ]
            });
        });

        function abrir_modal(a) {
            // var nomb_id = 'servicio_nombre_'+id;
            var nombre = document.getElementById(`servicio_nombre_${a}`).value;
            document.getElementById(`serv_nombre`).innerHTML = nombre;
            document.getElementById(`serv_id_form`).value = a;
            // console.log(nombre);

            $('#servicio_modal').modal('show');

        }

        $('#nuevo_servicio').on('click', function() {
            $.ajax({
                url: "{{ route('servicio.generar_codigo') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#codigo_servicio').val(response);
                }
            });
        });

        function desactivarserivicio(id, e) {
            e.preventDefault()
            const form = document.getElementById('formDesactivarServ' + id)
            if (form) {
                form.submit()
            }
        }
    </script>

    @include('producto_servicios.servicios.create2')
    @include('producto_servicios.servicios.edit')
    @include('producto_servicios.servicios.shared.pie')
@endsection
