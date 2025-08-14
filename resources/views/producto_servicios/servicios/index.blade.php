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
                                    <button class="btn btn-sm btn-primary" id="openUploadModal">
                                        <i class="fa fa-upload text-secondary"
                                            style="cursor: pointer;color: white !important"></i>
                                    </button>
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

                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#NuevoServicio">
                                        <i class="fa fa-plus"></i></button>
                                </ul>
                            </ul>
                            <div class="tabs-content">
                                <div class="tab-pane active show" id="tab-1">
                                    <br>
                                    <div class="search-responsive" style="padding-right: 15px;padding-left: 15px;">
                                        <div class="row">
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

    <div class="modal fade" id="servicio_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
            <div class="modal-content">
                <div class="modal-body" style="padding: 0px;">
                    <div class="ibox-content float-e-margins">
                        <h3 class="font-bold col-lg-12" align="center">
                            ¿Esta Seguro que Deseas Anular el Servicio:<br><span id="serv_nombre"> </span>? <br>
                            <h4 align="center"> <strong>Nota: Una vez Anulado no hay opción de devolver la acción </strong>
                            </h4>
                        </h3>
                        <p align="center">
                        <form action="{{ route('servicios.destroy') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_servicio" id="serv_id_form" value="">
                            <center>
                                <button type="submit" class="btn btn-w-m btn-primary" id="button_anular">Anular</button>
                            </center>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Base para agregar el tab para el los contenidos-->

    {{-- <div class="wrapper wrapper-content animated fadeInRight pt-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                @include('producto_servicios.servicios.shared.tabs')
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <div class="panel-body table-responsive">
                                        <div class="row">
                                            <div class="col-md-5">
                                            </div>
                                            <div class="col-md-5 ">
                                                <div class="input-group">
                                                    <label for="inputBuscar"
                                                        class="col-lg-2 col-form-label "><strong>Buscar:</strong></label>
                                                    <input type="text" id="inputBuscar" class="form-control"
                                                        aria-describedby="passwordHelpInline">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-primary btn-block" id="servicio_buscar"
                                                    type="button">Buscar</button>
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table table-striped dataTables-servicios">
                                            <thead class=" text-md-center">
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Código</th>
                                                    <th>Código original</th>
                                                    <th>Nombre</th>
                                                    <th>Familia</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($servicios as $servicio)
                                                <tr class="gradeX">
                                                    <td>{{$servicio->id}}</td>
                                                    <td>{{$servicio->codigo_servicio}}</td>
                                                    <td>{{$servicio->codigo_original}}</td>
                                                    <td>{{$servicio->nombre}}</td>
                                                    <td>SERVICIOS</td>
                                                    @if ($servicio->estado_anular == 1) <td>Anulado</td>
                                                    @else <td>Activo</td>@endif
                                                    <td>
                                                        @if ($servicio->foto == 'defecto.png' || $servicio->foto == 'servicio.png')
                                                            <img src="{{ asset('/archivos/imagenes/servicios/servicio.png')}}" style="width: 45px;">
                                                        @else
                                                            <img src="{{ asset('/archivos/imagenes/servicios/')}}/{{$servicio->foto}}" style="width: 45px;">
                                                        @endif
                                                    </td>
                                                    <td><center><a href="{{ route('servicios.show', $servicio->id) }}" target="_blank"><button type="button" class="btn btn-s-m btn-primary"><i class="fa fa-eye"></i></button></a></center>

                                                        <center>
                                                            <input type="hidden" name="servicio_id" id="servicio_id" value="{{$servicio->id}}">
                                                            <input type="hidden" name="servicio_nombre_{{$servicio->id}}" id="servicio_nombre_{{$servicio->id}}" value="{{$servicio->nombre}}"/>
                                                            @if ($servicio->estado_anular == 1)
                                                            <button type="button" class="btn btn-s-m btn-secondary">
                                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            </button>
                                                            @else
                                                            <button type="button" class="btn btn-s-m btn-danger" onclick="abrir_modal( {{$servicio->id}} )">
                                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            </button>
                                                            @endif
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
            </div>
        </div>
    </div> --}}
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
            // $('#tab-1').addClass('active')
            var servicios_table = $('.dataTables-example').DataTable({
                pageLength: 15,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_servicios') }}",
                    method: "get",
                    data: function(d) {
                        d.daterange = $('#data_range_filter').val();
                        // d.tipo_coti = $('#select_tipo_coti').val();
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
                            var data = `
                        <div class="dropdown d-inline">
                            <i class="fa fa-ellipsis-h text-secondary" style="cursor:pointer;" id="dropdownMenuIcon1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"></i>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuIcon1">

                                <a class="dropdown-item edit-producto">
                                    Editar
                                </a>
                                <button class="dropdown-item text-danger" onclick="desactivarProducto({{ 0 }}, event)"
                                    style="width: 100%; cursor: pointer;">
                                    Desactivar
                                </button>

                                <form id="formDesactivarProduc{{ 0 }}" action="{{ route('productos.desactivar', 0) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                </form>
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
    </script>

    @include('producto_servicios.servicios.create2')
    @include('producto_servicios.servicios.shared.pie')
@endsection
