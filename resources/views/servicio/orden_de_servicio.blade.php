@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/ordenservicio.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="ordenboton-ordencontainer">

    <button class="ordenboton" onclick="mostrarSeccion('seccion1', this)">
        Guias sin OS
    </button>

    <button class="ordenboton" onclick="mostrarSeccion('seccion2', this)">
        Guias con OS
    </button>
</div>

    <!-- Sección 2 - Guías con orden de salida -->
    <div id="seccion1" class="ordencontenido">

        <table id="clientesTabla" class="table table-bordered dataTables-example">
            <thead>
                <tr>
                    <th>NRO GUIA</th>
                    <th>COTIZACIÓN</th>
                    <th>CLIENTE</th>
                    <th>ORDEN DE SERVICIO</th>
                    <th>FECHA</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guiasCotizadas as $guia)
                    <tr>
                        <td>{{ $guia->nro_guia }}</td>
                        <td>{{ $guia->cotizacion_manual->cod_cotizacion ?? '-'}}</td>
                        <td>{{ $guia->cliente->nombre }}</td>
                        <td>{{ $guia->orden_servicio ?? 'No creada' }}</td>
                        <td>{{ $guia->fecha }}</td>
                        <td>
                            @if (!$guia->orden_s_creado)
                                <form action="{{ route('servicio.OScreate', $guia->id) }}" method="get">
                                    <button class="btn-ver-guia">Crear Orden</button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Sección 3 - Guía listas -->
    <div id="seccion2" class="ordencontenido">
        <table id="clientesTabla" class="table table-bordered dataTables-example">
            <thead>
                <tr>
                    <th>NRO GUIA</th>
                    <th>COTIZACIÓN</th>
                    <th>CLIENTE</th>
                    <th>ORDEN DE SERVICIO</th>
                    <th>FECHA</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guiasConOs as $guia)
                    <tr>
                        <td>{{ $guia->nro_guia }}</td>
                        <td>{{ $guia->cotizacion_manual->cod_cotizacion ?? '-'}}</td>
                        <td>{{ $guia->cliente->nombre }}</td>
                        <td>{{ $guia->orden_servicio ?? 'No creada' }}</td>
                        <td>{{ $guia->fecha }}</td>
                        <td>
                            <form action="{{ route('servicio.OScreate', $guia->id) }}" method="get">
                                <button class="btn-ver-guia">Ver Orden</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>

@endsection
@section('scripts')
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function mostrarSeccion(id, boton) {
            document.querySelectorAll('.ordencontenido').forEach(seccion => {
                seccion.classList.remove('activo');
            });

            document.getElementById(id).classList.add('activo');

            document.querySelectorAll('.ordenboton').forEach(b => {
                b.classList.remove('activo');
            });

            boton.classList.add('activo');
        }

        document.addEventListener("DOMContentLoaded", function () {
            let seccionActiva = document.querySelector(".ordencontenido.activo");
            if (!seccionActiva) {
                document.getElementById("seccion1").classList.add("activo");
            }
        });


        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector(".ordenboton").classList.add("activo");
        });

        function mostrarModalEditar(select) {
            if (select.value === "editar") {
                var modal = new bootstrap.Modal(document.getElementById('modalEditar'));
                modal.show();
                select.value = "Seleccione";
            }
        }
    </script>

    <script>
        $(document).ready(function () {
        $('.dataTables-example').DataTable({
            dom: '<"top"lf>rt<"bottom"ip><"clear">',
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Todo"]
            ],
            pageLength: 10,
            order: [[0, 'desc']], // Ordenar por la primera columna (NRO GUIA) en DESC
            // Si quieres ordenar por FECHA (columna 4), sería: order: [[4, 'desc']]
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                search: "Buscar:",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                paginate: {
                    previous: "Anterior",
                    next: "Siguiente"
                }
            }
        });
        $('.dataTables_filter input').css('width', '330px');

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#cliente-select').select2({
                placeholder: "Buscar cliente...",
                allowClear: true,
            });
        });
    </script>

@endsection

