@extends('layout')
@section('title', 'Servicio Técnico')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')

@section("content")
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                            @include('servicio_tecnico._shared.tabs')

                            @if($servicioGuia->estado == 0 || $servicioGuia->estado == 1)
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </ul>
                            @endif
                        </ul>

                        <div class="tabs-content">
                            <div class="tab-pane active show" id="tab-1">
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
                                    <table id="servicio-guias-ingresos" class="table table-striped table-bordered table-hover">
                                        <thead class="bg-white">
                                            <tr>
                                                <th>Equipo</th>
                                                <th>Nro. Serie</th>
                                                <th>Observación</th>
                                                <th>Fecha registrada</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servIngresoEquipos as $equipo)
                                                <tr class="gradeX">
                                                    <td>{{ $equipo->nombre_equipo }}</td>
                                                    <td>{{ $equipo->nro_serie }}</td>
                                                    <td>{{ $equipo->observacion }}</td>
                                                    <td>{{ $equipo->fecha_agregada }}</td>
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

<!-- Scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#servicio-guias-ingresos').DataTable({
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
        $('#tab-1').addClass('active');
        $('.scroll_content').slimscroll({
                height: '450px'
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection
