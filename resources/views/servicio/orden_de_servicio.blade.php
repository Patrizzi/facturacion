@extends('layout')
@section('title', 'Orden de Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/ordenservicio.css') }}">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ropw">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                            @include('servicio._shared.second-tabs')
                            <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                <button class="btn btn-primary" id="btn-agregar-guia" data-toggle="modal" data-target="#productoModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </ul>
                        </ul>
                        <div class="tabs-content">
                            <div class="tab-pane active show" id="tab-3">
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

                                <div class="table-responsive">
                                    <table id="clientesTabla" class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Nro Guía</th>
                                                <th>Cotización</th>
                                                <th>Cliente</th>
                                                <th>Orden Servicio</th>
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($guiasServicios as $guia)
                                                <tr>
                                                    <td>{{ $guia->nro_guia }}</td>
                                                    <td>{{ $guia->cotizacion_manual->cod_cotizacion ?? '-'}}</td>
                                                    <td>{{ $guia->cliente->nombre }}</td>
                                                    <td>{{ $guia->orden_servicio ?? 'No creada' }}</td>
                                                    <td>{{ $guia->fecha }}</td>
                                                    <td>
                                                        @if ($guia->orden_s_creado == 0)
                                                            <form action="{{ route('servicio.OScreate', $guia->id) }}" method="get">
                                                                <button class="btn btn-primary" title="Crear Orden Servicio" data-toggle="tooltip">
                                                                    <i class="fa fa-file-text"></i>
                                                                </button>
                                                            </form>
                                                        @elseif($guia->orden_s_creado == 1)
                                                            <form action="{{ route('servicio.OScreate', $guia->id) }}" method="get">
                                                                <button class="btn btn-primary" title="Ver" data-toggle="tooltip">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- en espera de crear orden servicio --}}
                                                        @if($guia->orden_s_creado == 0)
                                                            <button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Falta crear orden servicio">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>
                                                        {{-- orden servicio creada --}}
                                                        @elseif($guia->orden_s_creado == 1)
                                                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Orden Servicio creada">
                                                                <i class="fa fa-check-circle"></i>
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


<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.dataTables-example').DataTable({
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todo"]
                ],
                pageLength: 10,
                order: [[0, 'desc']],
                language: {
                    lengthMenu: "",
                    search: "",
                    info: "",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    }
                }
            });
            $('.dataTables_filter input').css('display', 'none');
            $('#tab-3').addClass('active');
            $('.scroll_content').slimscroll({
                height: '450px'
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
