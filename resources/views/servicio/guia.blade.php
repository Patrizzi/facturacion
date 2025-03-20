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
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/guia.css') }}">

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
        <div class="contenedordelboton">
            <button class="crear-btn">Crear</button>
        </div>

        <div class="wrappercontenedor">
            <!-- Contenedor izquierdo -->
            <div class="containercontenedor">
                <h2 class="container-titlecontenedor">Cliente</h2>

                <div class="input-groupcontenedor">
                    <label for="dni" class="input-labelcontenedor">DNI/RUC:</label>
                    <input type="text" id="dni" name="dni" class="input-fieldcontenedor"
                           value="{{ $guia->cliente->numero_documento ?? 'No disponible' }}" readonly>

                    <label for="nombre" class="input-labelcontenedor">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="input-fieldcontenedor"
                           value="{{ $guia->cliente->nombre ?? 'No disponible' }}" readonly>
                </div>

                <div class="input-groupcontenedor">
                    <label for="direccion" class="input-labelcontenedor">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="input-fieldcontenedor full-widthcontenedor"
                           value="{{ $guia->cliente->direccion ?? 'No disponible' }}" readonly>
                </div>

                <div class="input-groupcontenedor">
                    <label for="contacto" class="input-labelcontenedor">Email:</label>
                    <input type="email" id="contacto" name="contacto" class="input-fieldcontenedor"
                           value="{{ $guia->cliente->email ?? 'No disponible' }}" readonly>

                    <label for="telefono" class="input-labelcontenedor">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono" class="input-fieldcontenedor"
                           value="{{ $guia->cliente->telefono ?? 'No disponible' }}" readonly>
                </div>
            </div>




        <!-- Contenedor derecho -->
        <div class="containercontenedor" style="align-self: flex-end;">
            <h2 class="container-titlecontenedor">Datos Generales</h2>

            <div class="input-groupcontenedor">
                <label for="recepcionista" class="input-labelcontenedor">Recepcionista:</label>
                <input type="text" id="recepcionista" name="recepcionista" class="input-fieldcontenedor"
                       value="{{ $guia->recepcionista ?? 'No asignado' }}" readonly>

                <label for="fecha_ingreso" class="input-labelcontenedor">Fecha Ingreso:</label>
                <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="input-fieldcontenedor"
                       value="{{ isset($guia->created_at) ? \Carbon\Carbon::parse($guia->created_at)->format('Y-m-d') : 'No disponible' }}" readonly>
            </div>

            <div class="input-groupcontenedor">
                <label for="orden_servicio" class="input-labelcontenedor">Orden de servicio:</label>
                <input type="text" id="orden_servicio" name="orden_servicio" class="input-fieldcontenedor"
                       value="{{ $guia->orden_servicio ?? 'No asignado' }}" readonly>
            </div>
        </div>

    </div>

    <div class="accordion accordion-flush" id="accordionGuia">
        @if($guia)
            <div class="accordion-item">
                <div class="acordeon-header" id="acordeon-trigger-{{ $guia->id }}">
                    <div class="guia-texto">Guía {{ $guia->id }}</div>

                    <span class="accordion-toggle-btn">+</span>
                </div>

                <div class="acordeon-contenido" id="flush-collapse{{ $guia->id }}">
                    <div class="acordeon-contenido-interno">
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
                                @foreach($servicioGuiaIngresos as $ingreso)
                                    @foreach($ingreso->detalle_guia_ingreso as $detalle)
                                        <tr>
                                            <td>{{ $detalle->id }}</td>
                                            <td>{{ $detalle->serie }}</td>
                                            <td>{{ $detalle->producto }}</td>
                                            <td>{{ $detalle->observacion }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach

                                @if($servicioGuiaIngresos->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">No hay productos en esta guía.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <p class="text-danger">No se encontró la guía solicitada.</p>
        @endif
    </div>


</div>

<!-- Sección 2 - Guía de Salida -->
<div id="seccion2" class="contenido">
    <div >
        <!-- CLIENTES -->
        <div class="wrappercontenedor">
            <!-- Contenedor izquierdo -->
            <div class="containercontenedor">
                <h2 class="container-titlecontenedor">Cliente</h2>

                <div class="input-groupcontenedor">
                    <label for="dni" class="input-labelcontenedor">DNI/RUC:</label>
                    <input type="text" id="dni" name="dni" class="input-fieldcontenedor"
                           value="{{ $guia->cliente->numero_documento ?? 'No disponible' }}" readonly>

                    <label for="nombre" class="input-labelcontenedor">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="input-fieldcontenedor"
                           value="{{ $guia->cliente->nombre ?? 'No disponible' }}" readonly>
                </div>

                <div class="input-groupcontenedor">
                    <label for="direccion" class="input-labelcontenedor">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="input-fieldcontenedor full-widthcontenedor"
                           value="{{ $guia->cliente->direccion ?? 'No disponible' }}" readonly>
                </div>

                <div class="input-groupcontenedor">
                    <label for="contacto" class="input-labelcontenedor">Email:</label>
                    <input type="email" id="contacto" name="contacto" class="input-fieldcontenedor"
                           value="{{ $guia->cliente->email ?? 'No disponible' }}" readonly>

                    <label for="telefono" class="input-labelcontenedor">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono" class="input-fieldcontenedor"
                           value="{{ $guia->cliente->telefono ?? 'No disponible' }}" readonly>
                </div>
            </div>
                <!-- Contenedor derecho -->
                <div class="containercontenedor" style="align-self: flex-end;">
                    <h2 class="container-titlecontenedor">Datos Generales</h2>

                    <div class="input-groupcontenedor">
                        <label for="recepcionista" class="input-labelcontenedor">Recepcionista:</label>
                        <input type="text" id="recepcionista" name="recepcionista" class="input-fieldcontenedor"
                               value="{{ $guia->recepcionista ?? 'No asignado' }}" readonly>

                        <label for="fecha_ingreso" class="input-labelcontenedor">Fecha Ingreso:</label>
                        <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="input-fieldcontenedor"
                               value="{{ isset($guia->created_at) ? \Carbon\Carbon::parse($guia->created_at)->format('Y-m-d') : 'No disponible' }}" readonly>
                    </div>

                    <div class="input-groupcontenedor">
                        <label for="orden_servicio" class="input-labelcontenedor">Orden de servicio:</label>
                        <input type="text" id="orden_servicio" name="orden_servicio" class="input-fieldcontenedor"
                               value="{{ $guia->orden_servicio ?? 'No asignado' }}" readonly>
                    </div>
                </div>
                {{-- <button class="crearbtn">CREAR</button> --}}
            </div>

            <!-- VIÑETA DE SALIDA -->
            {{-- <div class="accordion accordion-flush" id="accordionGuiaSalida">
                @if($guia)
                    <div class="accordion-item">
                        <div class="acordeon-header" id="acordeon-trigger-{{ $guia->id }}">
                            <div class="guia-texto">Guía {{ $guia->id }}</div>
                            <span class="accordion-toggle-btn">+</span>
                        </div>

                        <!-- TABLA DE REGISTROS -->
                        <div class="acordeon-contenido" id="flush-collapse-salida-{{ $guia->id }}">
                            <div class="acordeon-contenido-interno">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>SERIE</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>OBSERVACIÓN</th>
                                            <th>TÉCNICO</th>
                                            <th>FECHA</th>
                                            <th>DIAGNÓSTICO</th>
                                            <th>ESTADO DE REPARACIÓN</th>
                                            <th>RECOMENDACIONES</th>
                                            <th>AÑADIR IMAGEN</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($servicioGuiaSalidas->isNotEmpty())
                                            @foreach ($servicioGuiaSalidas as $salida)
                                                @foreach ($salida->detalle_guia_salida as $detalle_s)
                                                    <tr>
                                                        <td>{{ $detalle_s->id }}</td> {{-- Item
                                                        <td>{{ $detalle_s->serie }}</td> {{-- Serie
                                                        <td>{{ $detalle_s->producto }}</td> {{-- Descripción Producto
                                                        <td>{{ $detalle_s->observacion }}</td> {{-- Observación
                                                        <td>{{ $detalle_s->tecnico ?? '-' }}</td> {{-- Técnico
                                                        <td>{{ $detalle_s->fecha ?? '-' }}</td> {{-- Fecha
                                                        <td>{{ $detalle_s->diagnostico ?? '-' }}</td> {{-- Diagnóstico
                                                        <td class="fw-bold">
                                                            {{ $detalle_s->estado === 'Reparado' ? "Reparado" : "En revisión" }} {{-- Estado
                                                        </td>
                                                        <td>{{ $detalle_s->recomendacion ?? '-' }}</td> {{-- Recomendación
                                                        <td>
                                                            <button class="btn btn-primary btn-sm">
                                                                <i class='bx bxs-cloud-upload'></i> Subir {{-- Imagen
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <select class="form-select form-select-sm" onchange="mostrarModalEditar(this)">
                                                                <option selected disabled>Seleccione</option>
                                                                <option value="ver">👁️Ver</option>
                                                                <option value="eliminar">🗑️Eliminar</option>
                                                                <option value="editar">✏️Editar</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="11" class="text-center">No hay productos en esta guía.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-danger">No se encontró la guía solicitada.</p>
                @endif
            </div> --}}
            <div class="accordion accordion-flush" id="accordionGuiaSalida">
                @if($guia)
                    <div class="accordion-item">
                        <div class="acordeon-header" id="acordeon-trigger-{{ $guia->id }}">
                            <div class="guia-texto">Guía {{ $guia->id }}</div>
                            <span class="accordion-toggle-btn">+</span>
                        </div>

                        <!-- TABLA DE REGISTROS -->
                        <div class="acordeon-contenido" id="flush-collapse-salida-{{ $guia->id }}">
                            <div class="acordeon-contenido-interno">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>SERIE</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>OBSERVACIÓN</th>
                                            <th>TÉCNICO</th>
                                            <th>FECHA</th>
                                            <th>DIAGNÓSTICO</th>
                                            <th>ESTADO DE REPARACIÓN</th>
                                            <th>RECOMENDACIONES</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($servicioGuiaSalidas as $salida)
                                            @foreach ($salida->detalle_guia_salida as $detalle_s)
                                                <tr data-id="{{ $detalle_s->id }}">
                                                    <td>{{ $detalle_s->id }}</td>
                                                    <td>{{ $detalle_s->serie }}</td>
                                                    <td>{{ $detalle_s->producto }}</td>
                                                    <td>{{ $detalle_s->observacion }}</td>
                                                    <td class="tecnico-cell" data-original="{{ $detalle_s->user ? $detalle_s->user->personal->nombres . ' ' . $detalle_s->user->personal->apellidos : 'Sin asignar' }}">
                                                        {{ $detalle_s->user ? $detalle_s->user->personal->nombres . ' ' . $detalle_s->user->personal->apellidos : 'Sin asignar' }}
                                                    </td>
                                                    <td class="fecha-cell">{{ $detalle_s->fecha_reparacion ?? '' }}</td>
                                                    <td class="diagnostico-cell" contenteditable="false">{{ $detalle_s->diagnostico ?? '' }}</td>
                                                    <td>
                                                        <select class="estado-select form-select form-select-sm" disabled>
                                                            <option value="en_revision" {{ ($detalle_s->estado === 'en_revision' || is_null($detalle_s->estado)) ? 'selected' : '' }}>
                                                                En Revisión
                                                            </option>
                                                            <option value="revisado" {{ $detalle_s->estado === 'revisado' ? 'selected' : '' }}>
                                                                Revisado
                                                            </option>
                                                            <option value="rechazado" {{ $detalle_s->estado === 'rechazado' ? 'selected' : '' }}>
                                                                Rechazado
                                                            </option>
                                                            <option value="reparado" {{ $detalle_s->estado === 'reparado' ? 'selected' : '' }}>
                                                                Reparado
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td class="recomendaciones-cell" contenteditable="false">{{ $detalle_s->recomendaciones ?? '' }}</td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm editar-btn">✏️ Editar</button>
                                                        <button class="btn btn-success btn-sm guardar-btn" hidden>💾 Guardar</button>
                                                        <button class="btn btn-danger btn-sm cancelar-btn" hidden>❌ Cancelar</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    <!-- Campos ocultos para el usuario autenticado -->
                                    <input type="hidden" id="guia-id" value="{{ $guia->id }}">
                                    <input type="hidden" id="usuario-autenticado" value="{{ Auth::user()->id }}">
                                    <input type="hidden" id="usuario-nombre" value="{{ Auth::user()->personal->nombres . ' ' . Auth::user()->personal->apellidos }}">
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-danger">No se encontró la guía solicitada.</p>
                @endif
            </div>
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

                {{-- <button class="crearbtn2">CREAR</button> --}}
            </div>

            <!-- VIÑETA DE tecnico -->
            <div class="accordion" id="accordionInformeTecnico">
                <div class="accordion-item">
                    <div class="acordeon-header" id="acordeon-trigger-tecnico">
                        <div class="guia-texto">Guía</div>
                        <span class="accordion-toggle-btn">+</span>
                    </div>

                    <div class="acordeon-contenido" id="flush-collapse-tecnico">
                        <div class="acordeon-contenido-interno">
                            {{--  <!-- BÚSQUEDA DE PRODUCTOS -->
                            <div class="search-container">
                                <form class="search-form" action="index.php?ruta=store/buscar_productos" method="POST">
                                    <div class="input-group">
                                        <input type="search" class="form-control search-input" name="search" placeholder="Buscar Producto" required>
                                        <button class="btn btn-primary search-btn" type="submit">
                                            <i class="bi bi-search">Buscar</i>
                                        </button>
                                    </div>
                                </form>
                            </div>--}}

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
        // Función para mostrar modal (placeholder para la función mencionada en el código original)
        function mostrarModalEditar(selectElement) {
          const accion = selectElement.value;
          if (accion) {
            console.log(`Acción seleccionada: ${accion}`);
            // Aquí iría el código para manejar cada acción
            selectElement.selectedIndex = 0; // Resetear el select
          }
        }

        // Seleccionar elementos del DOM
        const acordeonTriggers = document.querySelectorAll('.acordeon-header');


        // Añadir evento de clic a cada trigger
        acordeonTriggers.forEach(trigger => {
          const id = trigger.id.split('-').pop();
          const contenido = document.getElementById(`flush-collapse${id}`);

          const acordeonTriggers = document.querySelectorAll('.acordeon-header');

          acordeonTriggers.forEach(trigger => {
                trigger.addEventListener('click', function () {
                    const id = this.id.split('-').pop();
                    const contenido = document.getElementById(`flush-collapse-salida-${id}`);

                    contenido.classList.toggle('activo');
                    const toggleBtn = this.querySelector('.accordion-toggle-btn');
                    toggleBtn.textContent = contenido.classList.contains('activo') ? '-' : '+';
                });
            });

          trigger.addEventListener('click', function(event) {
            // Evitar que el clic en el botón abra/cierre el acordeón
            if (event.target.classList.contains('boton')) {
              console.log('Botón Más pulsado');
            } else {
              // Alternar el acordeón
              contenido.classList.toggle('activo');

              // Cambiar el signo + a - y viceversa
              const toggleBtn = this.querySelector('.accordion-toggle-btn');
              toggleBtn.textContent = contenido.classList.contains('activo') ? '-' : '+';
            }
          });
        });
      </script>
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

        // Activar la sección correcta si se recarga la página
        document.addEventListener("DOMContentLoaded", function () {
            let seccionActiva = document.querySelector(".contenido.activo");
            if (!seccionActiva) {
                document.getElementById("seccion1").classList.add("activo");
            }
        });


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

    {{--  script para el acordeon del informe tecnico--}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const acordeonTrigger = document.getElementById("acordeon-trigger-tecnico");
            const acordeonContenido = document.getElementById("flush-collapse-tecnico");

            acordeonTrigger.addEventListener("click", function () {
                const isOpen = acordeonContenido.classList.contains("activo");

                // Cierra todos los acordeones antes de abrir uno nuevo
                document.querySelectorAll(".acordeon-contenido").forEach(el => el.classList.remove("activo"));
                document.querySelectorAll(".accordion-toggle-btn").forEach(el => el.textContent = "+");

                if (!isOpen) {
                    acordeonContenido.classList.add("activo");
                    acordeonTrigger.querySelector(".accordion-toggle-btn").textContent = "-";
                }
            });
        });
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Evento para "Editar"
            document.querySelectorAll(".editar-btn").forEach(function(btn) {
                btn.addEventListener("click", function () {
                    let row = this.closest("tr");

                    // Guardar valores originales para restaurar si se cancela
                    row.dataset.origEstado = row.querySelector(".estado-select").value;
                    row.dataset.origRecomendaciones = row.querySelector(".recomendaciones-cell").innerText;
                    row.dataset.origDiagnostico = row.querySelector(".diagnostico-cell").innerText;
                    row.dataset.origFecha = row.querySelector(".fecha-cell").innerText;
                    row.dataset.origTecnico = row.querySelector(".tecnico-cell").innerText;

                    // Obtener elementos
                    let estadoSelect = row.querySelector(".estado-select");
                    let tecnicoCell = row.querySelector(".tecnico-cell");
                    let fechaCell = row.querySelector(".fecha-cell");
                    let diagnosticoCell = row.querySelector(".diagnostico-cell");
                    let recomendacionesCell = row.querySelector(".recomendaciones-cell");

                    // Si aprobado es "0" (Rechazado), limpiar todos los campos y mantener estado en "en_revision"
                    $(".estado-select").on("change", function() {
                        let row = $(this).closest("tr");
                        let recomendacionCell = row.find(".recomendaciones-cell");

                        if ($(this).val() === "rechazado") {
                            recomendacionCell.attr("contenteditable", "false").text("-");
                        } else {
                            recomendacionCell.attr("contenteditable", "true");
                        }
                    });

                    // Asignar la fecha actual a la celda de fecha
                    let fechaActual = new Date().toISOString().split('T')[0];
                    fechaCell.innerText = fechaActual;

                    // Mostrar el usuario autenticado en la columna técnico solo al editar
                    let userName = document.querySelector("#usuario-nombre").value;
                    tecnicoCell.innerText = userName;

                    // Habilitar edición en las columnas necesarias
                    estadoSelect.removeAttribute("disabled");
                    diagnosticoCell.setAttribute("contenteditable", "true");
                    recomendacionesCell.setAttribute("contenteditable", "true");

                    // Mostrar botones Guardar y Cancelar, ocultar Editar
                    row.querySelector(".guardar-btn").hidden = false;
                    row.querySelector(".cancelar-btn").hidden = false;
                    this.hidden = true;
                });
            });

            // Evento para "Guardar"
            document.querySelectorAll(".guardar-btn").forEach(function (btn) {
                btn.addEventListener("click", function () {
                    let row = this.closest("tr");
                    let id = row.dataset.id;
                    let estadoValue = row.querySelector(".estado-select").value;
                    let recomendaciones = row.querySelector(".recomendaciones-cell").innerText.trim() || null; // Evita enviar cadena vacía

                    // Confirmación antes de guardar
                    if (!confirm("¿Está seguro de que desea actualizar los cambios?")) {
                        return;
                    }

                    // Mostrar en consola los datos que se enviarán
                    console.log("Enviando datos...", { id, estado: estadoValue, recomendaciones });

                    axios.post('/actualizar-guia-salida', {
                        id: id,
                        estado: estadoValue,
                        recomendaciones: recomendaciones
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log("Datos guardados correctamente", response.data);

                        // Verificar si el elemento guia-id existe antes de redirigir
                        let guiaIdElement = document.querySelector("#guia-id");
                        if (guiaIdElement) {
                            let guiaId = guiaIdElement.value;
                            window.location.href = `/servicio-guia/cliente/${guiaId}`;
                        } else {
                            alert("Datos actualizados correctamente. La página se actualizará.");
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error("Error al guardar:", error);

                        if (error.response) {
                            // El servidor respondió con un código de estado diferente a 2xx
                            alert(`Error del servidor: ${error.response.status} - ${error.response.data.message || "Error desconocido"}`);
                        } else if (error.request) {
                            // La solicitud fue hecha pero no hubo respuesta del servidor
                            alert("No se recibió respuesta del servidor. Verifique su conexión a internet.");
                        } else {
                            // Error en la configuración de la solicitud
                            alert("Error al procesar la solicitud: " + error.message);
                        }
                    });
                });
            });


            // Evento para "Cancelar"
            document.querySelectorAll(".cancelar-btn").forEach(function(btn) {
                btn.addEventListener("click", function () {
                    let row = this.closest("tr");

                    // Restaurar valores originales sin eliminar los select ni otros elementos
                    row.querySelector(".tecnico-cell").innerText = row.dataset.origTecnico;
                    row.querySelector(".fecha-cell").innerText = row.dataset.origFecha;
                    row.querySelector(".estado-select").value = row.dataset.origEstado;
                    row.querySelector(".recomendaciones-cell").innerText = row.dataset.origRecomendaciones;
                    row.querySelector(".diagnostico-cell").innerText = row.dataset.origDiagnostico;

                    // Deshabilitar la edición
                    row.querySelector(".estado-select").setAttribute("disabled", "true");
                    row.querySelector(".estado-select").setAttribute("disabled", "true");
                    row.querySelector(".diagnostico-cell").setAttribute("contenteditable", "false");
                    row.querySelector(".recomendaciones-cell").setAttribute("contenteditable", "false");

                    // Ocultar botones Guardar y Cancelar, mostrar Editar
                    row.querySelector(".guardar-btn").hidden = true;
                    row.querySelector(".cancelar-btn").hidden = true;
                    row.querySelector(".editar-btn").hidden = false;
                });
            });
        });
        </script>

@endsection
vi
