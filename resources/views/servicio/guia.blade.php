@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styleguia.css') }}">

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <div class="boton-container">
        <button class="boton activo" onclick="mostrarSeccion('seccion1', this)">
            <span class="numero1">1</span> Guía de Ingreso
        </button>

        <button class="boton" onclick="mostrarSeccion('seccion2', this)">
            <span class="numero2">2</span> Guía de Salida
        </button>
        <button class="boton" onclick="mostrarSeccion('seccion3', this)">
            <span class="numero3">3</span> Informe tecnico
        </button>
    </div>

    <!-- Sección 1 - Guía de Ingreso -->
    <div id="seccion1" class="contenido activo">
        <div class="wrappercontenedor">
            <!-- Contenedor izquierdo -->
            <div class="containercontenedor">
                <h2 class="container-titlecontenedor">Cliente</h2>
                <div class="input-groupcontenedor">
                    <label for="dni" class="input-labelcontenedor">DNI/RUC:</label>
                    <input type="number" id="dni" name="dni" class="input-fieldcontenedor" value="{{ $cliente->numero_documento ?? '' }}" readonly>
                    <label for="nombre" class="input-labelcontenedor">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="input-fieldcontenedor" value="{{ $cliente->nombre ?? '' }}" readonly>
                </div>
                <div class="input-groupcontenedor">
                    <label for="direccion" class="input-labelcontenedor">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="input-fieldcontenedor full-widthcontenedor" value="{{ $cliente->direccion ?? '' }}" readonly>
                </div>
                <div class="input-groupcontenedor">
                    <label for="contacto" class="input-labelcontenedor">Contacto:</label>
                    <input type="text" id="contacto" name="contacto" class="input-fieldcontenedor" value="{{ $cliente->email ?? '' }}" readonly>
                    <label for="telefono" class="input-labelcontenedor">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono" class="input-fieldcontenedor" value="{{ $cliente->telefono ?? '' }}" readonly>
                </div>
            </div>

        <!-- Contenedor derecho -->
        <div class="containercontenedor3">
            <h2 class="container-titlecontenedor">Datos Generales</h2>

            <div class="input-groupcontenedor">
                <label for="recepcionista" class="input-labelcontenedor">Recepcionista:</label>
                <input type="text" id="recepcionista" name="recepcionista" class="input-fieldcontenedor" value="{{ $recepcionista ?? 'No asignado' }}" readonly>

                <label for="fecha_ingreso" class="input-labelcontenedor">Fecha Ingreso:</label>
                <input type="date" id="fecha_ingreso" name="fecha_ingreso" value="{{ $fechaIngreso ? \Carbon\Carbon::parse($fechaIngreso)->format('Y-m-d') : '' }}" readonly>

            </div>
        </div>
    </div>
    <div class="accordion accordion-flush" id="accordionGuia">
        @forelse($ordenesServicio as $orden => $guias)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse{{ $orden }}"
                        aria-expanded="false"
                        aria-controls="flush-collapse{{ $orden }}">
                        Orden de Servicio #{{ $orden }}
                    </button>
                </h2>
                <div id="flush-collapse{{ $orden }}" class="accordion-collapse collapse" data-bs-parent="#accordionGuia">
                    <div class="accordion-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ITEM</th>
                                    <th>Serie</th>
                                    <th>Descripción</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guias as $guia)
                                    <tr>
                                        <td>{{ $guia->id }}</td>
                                        <td>{{ $guia->numero_serie }}</td>
                                        <td>{{ $guia->nombre_equipo }}</td>
                                        <td>{{ $guia->descripcion_problema }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning text-center">No hay garantías disponibles para este cliente.</div>
        @endforelse
    </div>
</div>

<!-- Sección 2 - Guía de Salida -->
<div id="seccion2" class="contenido">
    <div >
        <!-- CLIENTES -->
        <div class="wrappercontenedor">
            <!-- Contenedor izquierdo -->
            <div class="containercontenedor1" style="align-self: flex-start;">
                <h2 class="container-titlecontenedor">Cliente</h2>
                <div class="input-groupcontenedor">
                    <label for="dni" class="input-labelcontenedor">DNI/RUC:</label>
                    <input type="number" id="dni" name="dni" class="input-fieldcontenedor" value="{{ $cliente->numero_documento ?? '' }}" readonly>
                    <label for="nombre" class="input-labelcontenedor">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="input-fieldcontenedor" value="{{ $cliente->nombre ?? '' }}" readonly>
                </div>
                <div class="input-groupcontenedor">
                    <label for="direccion" class="input-labelcontenedor">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="input-fieldcontenedor full-widthcontenedor" value="{{ $cliente->direccion ?? '' }}" readonly>
                </div>
                <div class="input-groupcontenedor">
                    <label for="contacto" class="input-labelcontenedor">Contacto:</label>
                    <input type="text" id="contacto" name="contacto" class="input-fieldcontenedor" value="{{ $cliente->email ?? '' }}" readonly>
                    <label for="telefono" class="input-labelcontenedor">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono" class="input-fieldcontenedor" value="{{ $cliente->telefono ?? '' }}" readonly>
                </div>
            </div>
                <!-- Contenedor derecho -->
                <div class="containercontenedor2" style="align-self: flex-end;">
                    <h2 class="container-titlecontenedor">Datos Generales</h2>
                    <div class="input-groupcontenedor">
                        <label for="recepcionista" class="input-labelcontenedor">Recepcionista:</label>
                        <input type="text" id="recepcionista" name="recepcionista" class="input-fieldcontenedor"
                            value="{{ optional($datos_generales?->personal_laborales)->nombres ?? '-' }}
                                   {{ optional($datos_generales?->personal_laborales)->apellidos ?? '-' }}"
                            readonly>
                        <label for="fecha_ingreso" class="input-labelcontenedor">Fecha Ingreso:</label>
                        <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="input-fieldcontenedor"
                            value="{{ optional($datos_generales)->created_at?->format('Y-m-d') ?? '-' }}"
                            readonly>
                    </div>
                </div>
                <button class="crearbtn">CREAR</button>
            </div>

            <!-- VIÑETA DE SALIDA -->
            <div class="accordion accordion-flush" id="accordionFlushExample3">
                <button class="bton1">Más</button>

                @foreach($registros as $registro)
                    @if (empty($registro->garantia_egreso_i))
                    @continue
                    @endif
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse{{ $registro->id }}"
                                aria-expanded="false"
                                aria-controls="flush-collapse{{ $registro->id }}">
                                GUIA {{ optional($registro->garantia_egreso_i)->id }}
                                <span class="accordion-toggle-btn">+</span> <!-- "+" al final del botón -->
                            </button>
                        </h2>
                        <div id="flush-collapse{{ $registro->id }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample3">
                            <div class="accordion-body">
                                <!-- BÚSQUEDA DE PRODUCTOS -->
                                <div class="search-container">
                                    <form class="search-form" action="index.php?ruta=store/buscar_productos" method="POST">
                                        <div class="input-group">
                                            <input type="search" class="form-control search-input" name="search"
                                                placeholder="Buscar Producto" required>
                                            <button class="btn btn-primary search-btn" type="submit">
                                                <i class="bi bi-search">Buscar</i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- TABLA DE REGISTROS -->
                                <div class="table-responsive">
                                    <div class="table-container table-bordered dataTables-example">
                                        <table class="table table-striped table-hover">
                                            <thead class="text-black">
                                                <tr>
                                                    <th>ITEM</th>
                                                    <th>SERIE</th>
                                                    <th>DESCRIPCIÓN</th>
                                                    <th>OBSERVACIÓN</th>
                                                    <th>TÉCNICO</th>
                                                    <th>FECHA</th>
                                                    <th>DIAGNÓSTICO</th>
                                                    <th>ESTADO DE APROBACIÓN</th>
                                                    <th>ESTADO DE REPARACIÓN</th>
                                                    <th>RECOMENDACIONES</th>
                                                    <th>AÑADIR IMAGEN</th>
                                                    <th>ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ optional($registro->garantia_egreso_i)->id ?? '-' }}</td>
                                                    <td>{{ $registro->numero_serie ?? '-' }}</td>
                                                    <td>{{ optional($registro->garantia_egreso_i)->descripcion_problema ?? '-' }}</td>
                                                    <td>{{ optional($registro->garantia_egreso_i)->diagnostico_solucion ?? '-' }}</td>
                                                    <td>{{ optional($registro->personal_laborales)->nombres ?? '-' }}</td>
                                                    <td>{{ $registro->fecha ?? '-' }}</td>
                                                    <td>{{ optional($registro->garantia_egreso_i)->diagnostico_solucion ?? '-' }}</td>
                                                    <td class="fw-bold
                                                        @if($registro->egresado == 1) text-success
                                                        @else text-danger
                                                        @endif">
                                                        {{ $registro->egresado == 1 ? "Aprobado" : "Rechazado" }}
                                                    </td>
                                                    <td class="fw-bold
                                                        @if(optional($registro->garantia_egreso_i)->estado == 1) text-success
                                                        @else text-danger
                                                        @endif">
                                                        {{ optional($registro->garantia_egreso_i)->estado == 1 ? "Reparado" : "En revisión" }}
                                                    </td>
                                                    <td>{{ optional($registro->garantia_egreso_i)->recomendaciones ?? '-' }}</td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class='bx bxs-cloud-upload'></i> Subir
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <select class="form-select form-select-sm" onchange="mostrarModalEditar(this)">
                                                            <option selected disabled>Seleccione</option>
                                                            <option value="ver">👁️ Ver</option>
                                                            <option value="eliminar">🗑️ Eliminar</option>
                                                            <option value="editar">✏️ Editar</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sección3  - informe tecnico -->
    <div id="seccion3" class="contenido">
        <div>
            <!-- CLIENTES -->
            <div class="wrappercontenedor">
                <!-- Contenedor izquierdo -->
                <div class="containercontenedor1" style="align-self: flex-start;">
                    <h2 class="container-titlecontenedor">Cliente</h2>
                    <div class="input-groupcontenedor">
                        <label for="dni" class="input-labelcontenedor">DNI/RUC:</label>
                        <input type="number" id="dni" name="dni" class="input-fieldcontenedor" placeholder="Ingrese DNI/RUC" required>
                        <label for="nombre" class="input-labelcontenedor">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="input-fieldcontenedor" placeholder="Ingrese Nombre" required>
                    </div>
                    <div class="input-groupcontenedor full-widthcontenedor">
                        <label for="direccion" class="input-labelcontenedor">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" class="input-fieldcontenedor full-widthcontenedor" placeholder="Ingrese Dirección" required>
                    </div>
                    <div class="input-groupcontenedor">
                        <label for="contacto" class="input-labelcontenedor">Contacto:</label>
                        <input type="text" id="contacto" name="contacto" class="input-fieldcontenedor" placeholder="Ingrese Contacto" required>
                        <label for="telefono" class="input-labelcontenedor">Teléfono:</label>
                        <input type="number" id="telefono" name="telefono" class="input-fieldcontenedor" placeholder="Ingrese Teléfono" required>
                    </div>
                    <div class="input-groupcontenedor full-widthcontenedor">
                        <label for="sucursal" class="input-labelcontenedor">Sucursal:</label>
                        <input type="text" id="sucursal" name="sucursal" class="input-fieldcontenedor full-widthcontenedor" placeholder="Ingrese Sucursal" required>
                    </div>
                </div>

                <!-- Contenedor derecho -->
                <div class="containercontenedor2" style="align-self: flex-end;">
                    <h2 class="container-titlecontenedor">Datos Generales</h2>
                    <div class="input-groupcontenedor">
                        <label for="recepcionista" class="input-labelcontenedor">Recepcionista:</label>
                        <input type="text" id="recepcionista" name="recepcionista" class="input-fieldcontenedor" placeholder="Ingrese Recepcionista" required>
                        <label for="fecha_ingreso" class="input-labelcontenedor">Fecha Ingreso:</label>
                        <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="input-fieldcontenedor" required>
                    </div>
                    <div class="input-groupcontenedor">
                        <label for="orden_servicio" class="input-labelcontenedor">Orden de servicio:</label>
                        <input type="text" id="orden_servicio" name="orden_servicio" class="input-fieldcontenedor" placeholder="Ingrese Orden" required>
                        <label for="fecha_estimada" class="input-labelcontenedor">Fecha Estimada:</label>
                        <input type="date" id="fecha_estimada" name="fecha_estimada" class="input-fieldcontenedor" required>
                    </div>
                </div>

                <button class="crearbtn2">CREAR</button>
            </div>

            <!-- VIÑETA DE tecnico -->
            <div class="accordion accordion-flush" id="accordionFlushExample3">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOnetecnico1" aria-expanded="false" aria-controls="flush-collapseOnetecnico1">
                            GUIA
                            <span class="accordion-toggle-btn">+</span> <!-- "+" al final del botón -->
                        </button>
                    </h2>
                    <div id="flush-collapseOnetecnico1" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExampletecnico1">
                        <div class="accordion-body">
                            <!-- BÚSQUEDA DE PRODUCTOS -->
                            <div class="search-container">
                                <form class="search-form" action="index.php?ruta=store/buscar_productos" method="POST">
                                    <div class="input-group">
                                        <input type="search" class="form-control search-input" name="search" placeholder="Buscar Producto" required>
                                        <button class="btn btn-primary search-btn" type="submit">
                                            <i class="bi bi-search">Buscar</i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- TABLA DE REGISTROS -->
                            <div class="table-container table-bordered dataTables-example">
                                <table class="table">
                                    <thead class="text-black">
                                        <tr>
                                            <th>ITEM</th>
                                            <th>SERIE</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>OBSERVACIÓN</th>
                                            <th>FECHA</th>
                                            <th>DIAGNÓSTICO</th>
                                            <th>ESTADO DE APROBACIÓN</th>
                                            <th>TÉCNICO DE REPARACIÓN</th>
                                            <th>ESTADO DE REPARACIÓN</th>
                                            <th>RECOMENDACIONES</th>
                                            <th>AÑADIR IMAGEN</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>001</td>
                                            <td>SN-2024X001</td>
                                            <td>Laptop Dell Inspiron 15</td>
                                            <td>La pantalla parpadea intermitentemente</td>
                                            <td>2025-02-12</td>
                                            <td>Falla en la conexión del cable flex de la pantalla</td>
                                            <td>Aprobado</td>
                                            <td>Pedro Gómez</td>
                                            <td>Reparado</td>
                                            <td>Reemplazo del cable flex y prueba de estabilidad</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm">
                                                    <i class='bx bxs-cloud-upload'></i> Subir
                                                </button>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm" onchange="mostrarModalEditar(this)">
                                                    <option selected disabled>Seleccione</option>
                                                    <option value="ver">👁️ Ver</option>
                                                    <option value="eliminar">🗑️ Eliminar</option>
                                                    <option value="editar">✏️ Editar</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal al seleccionar la opcion de editar en accione --}}
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Estado de aprobacion</th>
                                <th>Técnico de reparacion</th>
                                <th>Estado de reparacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" value=""></td>
                                <td><input type="text" class="form-control" value=""></td>
                                <td><input type="text" class="form-control" value=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarSeccion(id, boton) {
            document.querySelectorAll('.contenido').forEach(seccion => {
                seccion.classList.remove('activo');
            });

            document.getElementById(id).classList.add('activo');

            document.querySelectorAll('.boton').forEach(b => {
                b.classList.remove('activo');
            });

            boton.classList.add('activo');
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector(".boton").classList.add("activo");
        });

        function mostrarModalEditar(select) {
            if (select.value === "editar") {
                var modal = new bootstrap.Modal(document.getElementById('modalEditar'));
                modal.show();
                select.value = "Seleccione"; // Reiniciar el select después de abrir el modal
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
