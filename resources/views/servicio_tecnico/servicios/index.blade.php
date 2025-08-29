@extends('layout')
@section('title', 'Servicio Técnico')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')

@section('content')
<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                            @include('servicio_tecnico._shared.tabs')
                            <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                <form id="form-create-servicio" method="GET" action="{{ route('servicio-guias.create') }}" style="display: none;"></form>
                                <button type="button" class="btn btn-primary" onclick="redirectCreate()">
                                    <i class="fa fa-plus"></i>
                                </button>
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
                                    <table id="servicio-guias-tabla" class="table table-striped table-bordered table-hover">
                                        <thead class="bg-white">
                                            <tr>
                                                <th>Servicio Tec.</th>
                                                <th>Cliente</th>
                                                {{-- <th>Orden de servicio</th> --}}
                                                {{-- <th>Celular</th> --}}
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicioGuias as $guia)
                                                <tr class="gradeX">
                                                    <td>{{ $guia->nro_servicio_guia }}</td>
                                                    <td>{{ $guia->cliente_nombre }}</td>
                                                    {{-- <td>{{ $guia->orden_servicio ?? '-' }}</td> --}}
                                                    {{-- <td>{{ $guia->cliente->celular ?? '-' }}</td> --}}
                                                    <td>{{ $guia->fecha_creacion }}</td>
                                                    <td class="d-flex justify-content-center text-center" style="gap: 5px;">
                                                        <button
                                                            class="btn btn-primary"
                                                            data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title="Ver"
                                                        >
                                                            <i class="fa fa-eye"></i>
                                                       </button>

                                                       {{-- btn para cotizar --}}
                                                       @if($guia->estado == 1)
                                                            {{-- btn en ya diagnosticado(1) --}}
                                                            <button
                                                                class="btn btn-primary"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Cotizar"
                                                            >
                                                                <i class="fa fa-file"></i>
                                                            </button>
                                                       @endif

                                                       @if($guia->estado == 0 || $guia->estado == 1)
                                                            {{-- btn en espera si falta diagnosticar(0) o ya diagnosticado(1) --}}
                                                            <button
                                                                class="btn btn-warning"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="En espera"
                                                            >
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>

                                                        @elseif($guia->estado == 2)
                                                            {{-- btn ya cotizado(2) --}}
                                                            <button
                                                                class="btn btn-info"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Cotizado"
                                                            >
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
        $('#servicio-guias-tabla').DataTable({
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

<script>
    function redirectCreate() {
            const form = document.getElementById("form-create-servicio")
            if(form) {
                form.submit()
            }
        }
</script>
@endsection
