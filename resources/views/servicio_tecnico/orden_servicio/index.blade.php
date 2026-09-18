@extends('layout')
@section('title', 'Orden de Servicio Técnico')
@section('href_accion', route('servicio-guias.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')

@section('content')
<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                            @include('servicio_tecnico._shared.tabs')
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
                                    <table id="orden-servicio-guias-tabla" class="table table-striped table-bordered table-hover">
                                        <thead class="bg-white">
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Servicio Tec.</th>
                                                <th>Orden Servicio</th>
                                                <th>Fecha Registrada</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicioGuias as $guia)
                                                <tr class="gradeX">
                                                    <td>{{ $guia->cliente_nombre }}</td>
                                                    <td>{{ $guia->nro_servicio_guia }}</td>
                                                    <td>{{ $guia->orden_servicio ?? 'No creada' }}</td>
                                                    <td>{{ $guia->fecha_creacion }}</td>
                                                    <td class="d-flex justify-content-center" style="gap: 5px;">
                                                        <form id="form-os-{{ $guia->id }}" action="{{ route('servicio-guias.crear-ordenServ', $guia->id) }}" method="POST" style="display: none;">@csrf @method('PATCH')</form>
                                                        <button
                                                            class="btn btn-primary"
                                                            onclick="crearOS({{ $guia->id }})"
                                                        >
                                                            Crear Orden
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
<script src="{{ asset('js/toastr-config.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#orden-servicio-guias-tabla').DataTable({
            dom: '<"top"lf>rt<"bottom"ip><"clear">',
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Todo"]
            ],
            pageLength: 10,
            order: [],
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

<script>
    // Variable para controlar el envío
    var procesandoOrdenServicio = false;

    function crearOS(servicioGuiaId) {
        // Prevenir múltiples clicks
        if (procesandoOrdenServicio) {
            return false;
        }

        procesandoOrdenServicio = true;

        // Buscar el botón que activó la función y deshabilitarlo
        const button = event.target.closest('button');
        if (button) {
            button.disabled = true;
            button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Procesando...';
        }

        const form = document.getElementById(`form-os-${servicioGuiaId}`);
        if (form) {
            // Mostrar mensaje informativo
            toastr.info("Creando orden de servicio...", '', {
                timeOut: 2000
            });

            // Enviar formulario después de un pequeño delay
            setTimeout(() => {
                form.submit();
            }, 500);
        } else {
            // Si hay error, resetear estado
            procesandoOrdenServicio = false;
            if (button) {
                button.disabled = false;
                button.innerHTML = 'Crear Orden';
            }
            toastr.error('Error: Formulario no encontrado', '', {
                timeOut: 3000
            });
        }
    }

    // Resetear el estado cuando la página se recarga (por si acaso)
    $(document).ready(function() {
        procesandoOrdenServicio = false;
    });
</script>
<script>
    $(document).ready(function () {
        @if(session('success'))
            toastr.success("{{ session('success') }}", '', {
                timeOut: 3000
            });
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}", '', {
                timeOut: 3000
            });
        @endif

        @if(session('warning'))
            toastr.warning("{{ session('warning') }}", '', {
                timeOut: 3000
            });
        @endif

        @if(session('info'))
            toastr.info("{{ session('info') }}", '', {
                timeOut: 3000
            });
        @endif
    });
</script>
@endsection
