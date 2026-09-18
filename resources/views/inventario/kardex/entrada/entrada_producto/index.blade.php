@extends('layout')

@section('title', 'Kardex Entrada')
@section('breadcrumb', 'Entrada')
@section('breadcrumb2', 'Entrada')
@section('href_accion', route('kardex-entrada.create'))
@section('value_accion', 'Agregar')

@section('content')
    {{-- Almacen Principal - Oficina Arequipa --}}

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
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <div class="tabs-scroll-top-comprobantes"></div>
                            <div class="tabs-scroll-bottom">
                                <ul class="nav nav-tabs" role="tablist"
                                    style="align-items: center;border-bottom: 0px !important;">
                                    @include('inventario.kardex.entrada.entrada_producto.shared.tabs')
                                    {{-- Almacen --}}
                                    <ul class="ml-auto d-flex"
                                        style="gap: 10px; align-items: center;z-index: 20;position: fixed;right: 40px">
                                        {{-- ALMACEN --}}
                                        @can('kardex_entrada.crear')
                                            <a href="{{ route('kardex-entrada.create') }}" class="btn btn-primary"
                                                id="nuevo_servicio">
                                                <i class="fa fa-plus"></i>
                                            </a>
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
                            </div>
                            <div class="tab-content" style="margin-top: -2px">
                                <div role="tabpanel" id="tab-1" class="tab-pane active show"
                                    style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br>
                                    <div class="search-responsive" style="padding-right: 15px;padding-left: 15px;">
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
                                                <select class="form-control" name="" id="estado_anular">
                                                    <option value="" selected>Todos los Estados</option>
                                                    <option value="0">En Circualción</option>
                                                    <option value="1">Pendientes</option>
                                                    <option value="2">Anulados</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="scrooll-table-responsive">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>Motivo</th>
                                                    <th>Provedor</th>
                                                    <th>Fecha Subida</th>
                                                    <th>N° de G. Remisión</th>
                                                    <th>N° de Factura</th>
                                                    <th>
                                                        @can('kardex_entrada.ver')
                                                            Ver
                                                        @endcan
                                                    </th>
                                                    <th> @can('kardex_entrada.ver')
                                                            Acciones
                                                        @endcan
                                                    </th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody><span hidden="hidden">{{ $i = 0 }}</span>
                                                @if (isset($primer_registro))
                                                    <tr class="gradeX">
                                                        <td>{{ $i = 1 }}</td>
                                                        <td>{{ $primer_registro->codigo_guia }}</td>
                                                        <td>{{ $primer_registro->codigo_guia }}</td>
                                                        <td>{{ $primer_registro->codigo_guia }}</td>
                                                        <td>{{ $primer_registro->created_at->format('d/m/Y') }}</td>
                                                        <td>{{ $primer_registro->codigo_guia }}</td>
                                                        <td>{{ $primer_registro->codigo_guia }}</td>
                                                        <td>
                                                            @can('kardex_entrada.ver')
                                                                <a
                                                                    href="{{ route('kardex-entrada.show', $primer_registro->id) }}">
                                                                    <button type="button" class="btn btn-sm btn-primary"><i
                                                                            class="fa fa-eye"></i></button>
                                                                </a>
                                                            @endcan
                                                        </td>

                                                        <td>
                                                            @can('kardex_entrada.anular')
                                                                <button type="button" class="btn btn-s-m btn-secondary">
                                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                </button>
                                                            @endcan
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-info btn-circle btn-ls"
                                                                title="Guia en Circulacion">
                                                                <i class="fa fa-history"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @foreach ($kardex_entradas as $value => $kardex_entrada)
                                                    <tr class="gradeX">
                                                        <td> {{ $kardex_entrada->id }}</td>
                                                        <td>{{ $kardex_entrada->codigo_guia }}</td>
                                                        <td>{{ $kardex_entrada->motivo->nombre }}</td>
                                                        <td>{{ $kardex_entrada->provedor->empresa }}</td>
                                                        <td>{{ $kardex_entrada->created_at->format('d/m/Y') }}</td>
                                                        <td>{{ $kardex_entrada->guia_remision }}</td>
                                                        <td>{{ $kardex_entrada->factura }}</td>
                                                        <td>
                                                            @can('kardex_entrada.ver')
                                                                <a
                                                                    href="{{ route('kardex-entrada.show', $kardex_entrada->id) }}">
                                                                    <button type="button" class="btn btn-primary"><i
                                                                            class="fa fa-eye"></i></button>
                                                                </a>
                                                            @endcan
                                                        </td>
                                                        <td>
                                                            @can('kardex_entrada.anular')
                                                                @if ($array_final[$value] == 1)
                                                                    @if ($kardex_entrada->estado == 1)
                                                                        <button type="button" class="btn btn-danger"
                                                                            title="Anular"
                                                                            onclick="abrir_modal( {{ $kardex_entrada->id }} )">
                                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                        </button>
                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-secondary" disabled>
                                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                        </button>
                                                                    @endif
                                                                @else
                                                                    <button class="btn btn-secondary" disabled><i
                                                                            class="fa fa-trash-o"
                                                                            aria-hidden="true"></i></button>
                                                                @endif
                                                            @endcan
                                                        </td>
                                                        <td>
                                                            @if ($array_final[$value] == 1)
                                                                @if ($kardex_entrada->estado == 1)
                                                                    <input type="hidden"
                                                                        name="kardex_nombre_{{ $kardex_entrada->id }}"
                                                                        id="kardex_nombre_{{ $kardex_entrada->id }}"
                                                                        value="{{ $kardex_entrada->codigo_guia }}" />
                                                                    <button class="btn btn-default btn-circle btn-ls"
                                                                        title="Guia En Espera">
                                                                        <i class="fa fa-clock-o"></i>
                                                                    </button>
                                                                @else
                                                                    <button class="btn btn-danger btn-circle btn-ls"
                                                                        title="Guia Anulada">
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                @endif
                                                            @else
                                                                <button class="btn btn-info btn-circle btn-ls"
                                                                    title="Guia en Circulacion">
                                                                    <i class="fa fa-history"></i>
                                                                </button>
                                                            @endif
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

    {{-- <form action="{{ route('kardex-entrada.destroy', $kardex_entrada->id)}}" method="POST">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-s-m btn-info">Anular </button>
</form> --}}
    <!-- Modal Universal Para Anulacion de Kardexs -->
    <div class="modal fade" id="servicio_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
            <div class="modal-content">
                <div class="modal-body" style="padding: 0px;">
                    <div class="ibox-content float-e-margins">
                        <h3 class="font-bold col-lg-12" align="center">
                            ¿Está seguro que desea anular el kardex entrada con guía N°:<br><span id="kardex_nombre">
                            </span>? <br>
                            <h4 align="center"> <strong>Nota: Una vez anulado no hay opción de devolver la acción
                                </strong></h4>
                        </h3>
                        <p align="center">
                        <form action="{{ route('kardex-entrada.destroy') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_kardex" id="kardex_id_form" value="">
                            <center>
                                <button type="submit" class="btn btn-w-m btn-primary">Anular</button>
                            </center>
                        </form>
                        </p>
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
                order: [
                    [0, 'desc']
                ],
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

            $('#tab-1-tab').addClass('active');
            $('.scroll_content').slimscroll({
                height: '450px'
            });
        });

        function abrir_modal(a) {
            var nombre = document.getElementById(`kardex_nombre_${a}`).value;
            document.getElementById(`kardex_nombre`).innerHTML = nombre;
            document.getElementById(`kardex_id_form`).value = a;
            $('#servicio_modal').modal('show');
        }
    </script>
@endsection
