@extends('layout')
@section('title', 'Kardex Distribucion')
@if (count($almacen) == 1)
    @section('value_accion', '#')
    @section('href_accion', '#')
@else
    @section('value_accion', 'Agregar')
    @section('href_accion', route('kardex-entrada-Distribucion.create'))
@endif

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        @if (session('repite'))
            <div class="alert alert-danger">
                {{ session('repite') }}
            </div>
        @endif
        <div class="wrapper wrapper-content animated fadeInRight" style="padding-bottom: 0px">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                            <div class="ibox-tools custom">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row" style="justify-content: center">
                                {{-- @include('transaccion.comprobantes._shared.statistics') --}}
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
                                <ul class="nav nav-tabs" role="tablist"
                                    style="align-items: center;border-bottom: 0px !important;">
                                    @include('inventario.kardex.entrada.distribucion_producto.shared.tabs')
                                     <ul class="ml-auto d-flex"
                                        style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                        {{-- ALMACEN --}}
                                        @can('kardex_distribucion.crear')
                                            <a href="{{ route('kardex-entrada-Distribucion.create') }}"
                                            class="btn btn-primary" id="nuevo_servicio">
                                                <i class="fa fa-plus"></i>
                                            <a>
                                        @endcan
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-download"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button type="button" onclick="exportarTodo(event)" class="dropdown-item">
                                                    <i class="fa fa-file-pdf"></i> Exportar Todo
                                                </button>
                                                <button type="button" id="exportSelected" class="dropdown-item">
                                                    <i class="fa fa-file-pdf-o"></i> Exportar Selecionados
                                                </button>
                                            </div>
                                        </div>
                                        <form id="formExportProdAll" action="{{ route('export.excel') }}" method="GET"
                                            style="display: none;">
                                        </form>
                                    </ul>
                                </ul>
                                <div class="tab-content" style="margin-top: -2px">
                                    <div class="tab-pane active show" id="tab-1" style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                        <br>
                                        <div class="search-responsive" style="padding-right: 15px;padding-left: 15px;">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="daterange"
                                                            id="data_range_filter" value="" readonly="readonly" />
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-secondary"
                                                                id="revert_select">
                                                                <i class="fa fa-history"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-lg-3 col-md-6 col-sm-12">
                                            <select class="form-control" name="" id="estado_anular">
                                                <option value="" selected>Todos los servicios</option>
                                                <option value="0">Activos</option>
                                                <option value="1">Anulados</option>
                                            </select>
                                        </div> --}}
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <input type="search" class="form-control" placeholder="Buscar:"
                                                        id="search_all_column">
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <button type="button" class="btn btn-block btn-primary"
                                                        id="filter_buttons">Buscar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example">
                                                <thead>
                                                    <tr>
                                                        {{-- <th></th> --}}
                                                        <th>ID</th>
                                                        <th>Codigo</th>
                                                        <th>Fecha de Distribución</th>
                                                        <th>Cantidad de Productos</th>
                                                        <th>Cantidad Distribuida</th>
                                                        <th>Almacen</th>
                                                        <th>Guia de Remision</th>
                                                        <th>@can('kardex_distribucion.ver') Ver @endcan</th>
                                                        <th>Estado</th>
                                                        {{-- <th>Anular</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody><span hidden="hidden">{{ $i = 1 }}</span>
                                                    @foreach ($kardex_distribucion as $index => $kardex_distribuciones)
                                                        <tr class="gradeX">
                                                            {{-- <td></td> --}}
                                                            <td> {{ $i++ }}</td>
                                                            <td>{{ $kardex_distribuciones->codigo_guia }}</td>
                                                            <td>{{ $kardex_distribuciones->created_at->format('d/m/Y') }}
                                                            </td>
                                                            <td>{{ $cantidad_prod[$index] }} @if ($cantidad_prod[$index] > 1)
                                                                    productos
                                                                @else
                                                                    producto
                                                                @endif
                                                            </td>
                                                            <td>{{ $cantidad_tot[$index] }} items </td>
                                                            <td>{{ $kardex_distribuciones->almacen->nombre }}</td>
                                                            <td>{{ $kardex_distribuciones->cod_guia_remisio }}</td>
                                                            <td>
                                                                @can('kardex_distribucion.ver')
                                                                    <a href="{{ route('kardex-entrada-Distribucion.show', $kardex_distribuciones->id) }}">
                                                                        <button type="button" class="btn btn-info">
                                                                            <i class="fa fa-eye"></i>
                                                                        </button>
                                                                    </a>
                                                                @endcan
                                                            </td>
                                                            {{-- <td><button class="btn btn-secondary">Anular</button></td> --}}
                                                            <td>
                                                                <button type="button"
                                                                    class="btn  btn-circle  btn-success btn-ls">
                                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                                </button>
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
            max-width: 17%;
            /*270*/
            max-height: 50%;
            /*400*/
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

        /* .btn-circle {
            width: 25px;
            height: 25px;
            padding: 3px 0;
        } */

        .icon-estado {
            text-align: center;
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
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }]
            });

            $('#tab-1').addClass('active');
            $('.scroll_content').slimscroll({
                height: '450px'
            });
        });
    </script>
@endsection
