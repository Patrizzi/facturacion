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

    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/guia.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <div class="boton-container">

        <button class="botoninicio" onclick="window.location.href='{{ route('sGuias.index') }}'">
            INICIO
        </button>


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

        <div class="Div-agregar">
            <h2 id="titulo-guia-servicio">Guías de Servicio</h2>
            @if (!$buttonDisabled === true)
                <button id="btn-agregar-guia">Agregar Producto</button>


            @endif

            <!-- Modal para agregar productos -->
            <div id="productoModal" class="custom-modal">
                <form id="producto-form" method="POST" action="{{ route('servicio.guia.productos.store', ['guia_id' => $guia->id]) }}">
                    @csrf
                    <div class="custom-modal-content">
                        <div class="custom-modal-header">
                            <h2 class="custom-modal-title">Gestión de Productos</h2>
                        </div>

                        <div class="productos-section">
                            <h3 class="productos-title">PRODUCTOS</h3>

                            <div id="formulario-producto">
                                <div class="producto-row">
                                    <div style="flex: 1;">
                                        <label class="custom-label">Nombre</label>
                                        <input type="text" class="custom-input" id="producto-nombre" name="producto">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="custom-label">Serie</label>
                                        <input type="text" class="custom-input" id="producto-serie" name="serie">
                                    </div>
                                    <div style="flex: 1;">
                                        <label class="custom-label">Observación</label>
                                        <textarea class="custom-input" id="producto-observacion" name="observacion" style="resize: vertical; height: 40px; overflow-y: hidden;"></textarea>
                                    </div>
                                    <div style="align-self: flex-end; margin-bottom: 2px;">
                                        <button type="button" class="add-btn" id="btn-add-producto">+</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenedor para productos agregados -->
                            <div id="productos-agregados" class="productos-agregados-container"></div>
                        </div>

                        <div class="footer-buttons">
                            <button type="button" class="btn-cerrar" id="btn-cerrar">Cerrar</button>
                            <button type="submit" class="btn-guardar" id="btn-guardar">Guardar Cambios</button>
                        </div>
                    </div>
                </form>

            </div>
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
            <div class="acordeon-header" id="acordeon1-trigger-{{ $guia->id }}">
                <div class="guia-texto">{{ $guia->id }} Guía </div>
                <span class="accordion-toggle-btn">+</span>
            </div>

            <!-- contenido del acordeon al darle click -->
            <div class="acordeon-contenido" id="acordeon1-collapse-{{ $guia->id }}">
                <div class="acordeon-contenido-interno">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ITEM</th>
                                    <th>Producto</th>
                                    <th>Serie</th>
                                    <th>Observación</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicioGuiaIngresos as $ingreso)
                                    @foreach($ingreso->detalle_guia_ingreso as $detalle)
                                        <tr>
                                            <td>{{ $detalle->contador }}</td>
                                            <td>{{ $detalle->producto }}</td>
                                            <td>{{ $detalle->serie }}</td>
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
    <div class="Div-agregar">
        <h2 id="titulo-guia-servicio">Guías de Servicio</h2>
        <button id="btn-crear-informe" class="btn btn-primary" disabled>Crear Informe Técnico</button>
    </div>
    <div>
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
            </div>

            <!-- VIÑETA DE SALIDA -->
            <div class="accordion accordion-flush" id="accordionGuiaSalida">
                @if($guia)
                <div class="accordion-item">
                    <div class="acordeon-header" id="acordeon2-trigger-{{ $guia->id }}">
                        <div class="guia-texto">Guía {{ $guia->id }}</div>
                        <span class="accordion-toggle-btn">+</span>
                    </div>

                    <!-- contenido del acordeon al darle click -->
                    <div class="acordeon-contenido" id="acordeon2-collapse-{{ $guia->id }}">
                        <div class="acordeon-contenido-interno">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>SERIE</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>OBSERVACIÓN</th>
                                            <th>FECHA DE INICIO</th>
                                            <th>TÉCNICO</th>
                                            <th>DIAGNÓSTICO</th>
                                            <th>ESTADO</th>
                                            <th>FECHA FINAL</th>
                                            <th>ESTADO DE REPARACIÓN</th>
                                            <th>AÑADIR IMAGEN</th>
                                            <th>ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($servicioGuiaSalidas) && count($servicioGuiaSalidas) > 0)
                                            @foreach ($servicioGuiaSalidas as $salida)
                                                @foreach ($salida->detalle_guia_salida as $detalle_s)
                                                    <tr data-id="{{ $detalle_s->id }}">
                                                        <td>{{ $detalle_s->id }}</td>
                                                        <td>{{ $detalle_s->detalle_guia_ingreso->serie ?? 'Sin dato' }}</td>
                                                        <td>{{ $detalle_s->detalle_guia_ingreso->producto ?? 'Sin dato' }}</td>
                                                        <td>{{ $detalle_s->detalle_guia_ingreso->observacion ?? 'Sin dato' }}</td>
                                                        <td class="fecha-inicio-cell">{{ $detalle_s->fecha_inicio ?? '' }}</td>
                                                        <td class="tecnico-cell" data-original="{{ $detalle_s->user ? $detalle_s->user->personal->nombres . ' ' . $detalle_s->user->personal->apellidos : 'Sin asignar' }}">
                                                            {{ $detalle_s->user ? $detalle_s->user->personal->nombres . ' ' . $detalle_s->user->personal->apellidos : 'Sin asignar' }}
                                                        </td>
                                                        <td class="diagnostico-cell" contenteditable="false">{{ $detalle_s->diagnostico ?? '' }}</td>
                                                        <td>
                                                            @php
                                                                $estadoOS = $detalle_s->estado_os ?? 0;
                                                            @endphp
                                                            <select class="estado-os-select form-select form-select-sm" disabled>
                                                                <option value="0" {{ $estadoOS == 0 ? 'selected' : '' }}>En Revisión</option>
                                                                <option value="1" {{ $estadoOS == 1 ? 'selected' : '' }}>Revisado</option>
                                                            </select>
                                                        </td>
                                                        <td class="fecha-fin-cell">{{ $detalle_s->fecha_fin ?? '' }}</td>
                                                        <div class="modal fade"
                                                            id="modalSubirImagen-{{ $detalle_s->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="modalSubirImagenLabel-{{ $detalle_s->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modalSubirImagenLabel-{{ $detalle_s->id }}">Subir Imagen</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="formSubirImagen-{{ $detalle_s->id }}"
                                                                                action="{{ route('imagenGuiaSalida.image', $detalle_s->id) }}"
                                                                                method="POST"
                                                                                enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="mb-3">
                                                                                <label for="foto-{{ $detalle_s->id }}" class="form-label">Seleccionar Imagen</label>
                                                                                <input type="file"
                                                                                        class="form-control"
                                                                                        id="foto-{{ $detalle_s->id }}"
                                                                                        name="foto"
                                                                                        accept="image/*"
                                                                                        required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="descripcion-{{ $detalle_s->id }}" class="form-label">Descripción</label>
                                                                                <textarea class="form-control"
                                                                                            id="descripcion-{{ $detalle_s->id }}"
                                                                                            name="descripcion"
                                                                                            rows="3"
                                                                                            placeholder="Ingrese una descripción para la imagen"></textarea>
                                                                            </div>
                                                                            <button type="submit" class="btn btn-primary">Subir Imagen</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <td>
                                                            <select class="estado-select form-select form-select-sm" disabled>
                                                                <option value="" disabled {{ is_null($detalle_s->estado_reparacion) ? 'selected' : '' }}>Seleccionar</option>
                                                                <option value="0" {{ $detalle_s->estado_reparacion === 0 ? 'selected' : '' }}>Rechazado</option>
                                                                <option value="1" {{ $detalle_s->estado_reparacion === 1 ? 'selected' : '' }}>Reparado</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                    class="btn btn-primary btn-sm agregar-imagen"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalSubirImagen-{{ $detalle_s->id }}"
                                                                    data-detalle-id="{{ $detalle_s->id }}">
                                                                <i class='bx bxs-cloud-upload'></i> Subir
                                                            </button>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary btn-sm editar-btn">✏️ Editar</button>
                                                            <button class="btn btn-success btn-sm guardar-btn" hidden>💾 Actualizar</button>
                                                            <button class="btn btn-danger btn-sm cancelar-btn" hidden>❌ Cancelar</button>

                                                            @if(isset($imagenesProducto[$detalle_s->id]))
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerImagen-{{ $detalle_s->id }}">
                                                                    👁️ Ver Imagen
                                                                </button>
                                                            @endif

                                                        </td>
                                                    </tr>

                                                    @if(isset($imagenesProducto[$detalle_s->id]))
                                                        @php
                                                            $imagenDetalle = $imagenesProducto[$detalle_s->id];
                                                        @endphp
                                                        <div class="modal fade" id="modalVerImagen-{{ $detalle_s->id }}" tabindex="-1" aria-labelledby="modalVerImagenLabel-{{ $detalle_s->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modalVerImagenLabel-{{ $detalle_s->id }}">Imagen de Detalle</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="{{ asset('storage/' . $imagenDetalle->foto) }}" alt="Imagen" class="img-fluid" style="max-height: 500px;">
                                                                        @if(!empty($imagenDetalle->descripcion))
                                                                            <p class="mt-3">{{ $imagenDetalle->descripcion }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No hay datos disponibles</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <!-- Campos ocultos para el usuario autenticado -->
                                    <input type="hidden" id="orden-servicio" value="{{ $buttonDisabled }}">
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


    <style>
        .up-informe-tecnico {
          display: flex;
          align-items: center;
          justify-content: space-between;
          padding: 10px;
        }

        #titulo-guia-servicio {
          margin: 0;
          font-size: 24px;
        }

        .botones-informe {
          display: flex;
        }

        .botones-informe button {
          padding: 8px 12px;
          font-size: 14px;
          cursor: pointer;
          margin-left: 8px; /* Espacio entre los botones */
        }
      </style>


    <!-- Sección3  - informe tecnico -->
    <div id="seccion3" class="contenido">
        <div class="up-informe-tecnico">
            <h2 id="titulo-guia-servicio">Informe Técnico</h2>
            <div class="botones-informe">
            <button id="btn-descargar">Descargar informe técnico</button>
            <button onclick ="imprimir()" id="btn-imprimir">Imprimir Informe Técnico</button>
            </div>
        </div>
        <div class="contenido-informe-tecnico">
            @if (!empty($servicioGuiaSalidas) && count($servicioGuiaSalidas) > 0)
                @foreach ($servicioGuiaSalidas as $salida)
                    @foreach ($salida->detalle_guia_salida as $detalle_s)
                        <div style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                            <p><strong>Item:</strong> {{ $detalle_s->id }}</p>
                            <p><strong>Serie:</strong> {{ $detalle_s->detalle_guia_ingreso->serie ?? 'Sin dato' }}</p>
                            <p><strong>Descripción:</strong> {{ $detalle_s->detalle_guia_ingreso->producto ?? 'Sin dato' }}</p>
                            <p><strong>Técnico:</strong> {{ $detalle_s->user ? $detalle_s->user->personal->nombres . ' ' . $detalle_s->user->personal->apellidos : 'Sin asignar' }}</p>
                            <p><strong>Diagnóstico:</strong> {{ $detalle_s->diagnostico ?? 'Sin diagnóstico' }}</p>
                            <p><strong>Fecha final:</strong> {{ $detalle_s->fecha_fin ?? 'Sin fecha' }}</p>
                        </div>
                    @endforeach
                @endforeach
            @else
                <p>No hay información disponible para mostrar.</p>
            @endif
        </div>
    </div>


<script>
    function imprimir() {
        window.print();
    }
</script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll("[id^='foto-']").forEach(fileInput => {
                const modalBody = fileInput.closest('.modal-body');
                let previewContainer = modalBody.querySelector('.image-preview');

                if (!previewContainer) {
                    previewContainer = document.createElement('div');
                    previewContainer.className = 'image-preview mt-3';
                    modalBody.appendChild(previewContainer);
                }

                fileInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            previewContainer.innerHTML = `
                                <div class="text-center">
                                    <img src="${e.target.result}"
                                        class="img-fluid rounded"
                                        style="max-height: 400px; object-fit: contain;">
                                </div>
                            `;
                        };

                        reader.readAsDataURL(file);
                    } else {
                        previewContainer.innerHTML = '';
                    }
                });
            });
        });
    </script>

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

        document.addEventListener("DOMContentLoaded", function() {
            // Función para manejar el clic en los acordeones
            function toggleAccordion(triggerId, contentId) {
                const trigger = document.getElementById(triggerId);
                const content = document.getElementById(contentId);
                const toggleBtn = trigger.querySelector('.accordion-toggle-btn');

                trigger.addEventListener('click', function() {
                    const isOpen = content.classList.contains('activo');

                    // Cierra todos los acordeones antes de abrir uno nuevo
                    document.querySelectorAll(".acordeon-contenido").forEach(el => el.classList.remove('activo'));
                    document.querySelectorAll(".accordion-toggle-btn").forEach(el => el.textContent = '+');

                    // Si el acordeón no está abierto, lo abre
                    if (!isOpen) {
                        content.classList.add('activo');
                        toggleBtn.textContent = '-';
                    }
                });
            }

            // Asignar la función de toggle a los acordeones del apartado 1 y 2
            // Para apartado 1
            toggleAccordion('acordeon1-trigger-{{ $guia->id }}', 'acordeon1-collapse-{{ $guia->id }}');

            // Para apartado 2
            toggleAccordion('acordeon2-trigger-{{ $guia->id }}', 'acordeon2-collapse-{{ $guia->id }}');
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



<script>
    $(document).ready(function() {
        // Abrir modal
        $("#btn-agregar-guia").click(function() {
            $("#productoModal").fadeIn(300);
        });

                // Cerrar modal
                $(".custom-close, #btn-cerrar").click(function() {
                    $("#productoModal").fadeOut(200);
                });

                // Cerrar modal haciendo clic fuera del contenido
                $(window).click(function(e) {
                    if ($(e.target).is(".custom-modal")) {
                        $("#productoModal").fadeOut(200);
                    }
                });

                let productoCount = 0;

                // Agregar nuevo producto
                $("#btn-add-producto").click(function() {
                    const nombre = $("#producto-nombre").val();
                    const serie = $("#producto-serie").val();
                    const observacion = $("#producto-observacion").val();

                    if (!nombre || !serie) {
                        alert("Por favor ingrese al menos nombre y serie del producto");
                        return;
                    }

                    const productoId = productoCount++;

                    const productoHTML = `
                        <div class="producto-agregado" id="producto-${productoId}">
                            <div class="producto-info">
                                <p class="producto-nombre"><span class="producto-label">Nombre:</span> ${nombre}</p>
                                <p class="producto-serie"><span class="producto-label">Serie:</span> ${serie}</p>
                                <p class="producto-observacion"><span class="producto-label">Observación:</span> ${observacion}</p>
                                <input type="hidden" name="productos[producto][]" value="${nombre}" class="input-nombre">
                                <input type="hidden" name="productos[serie][]" value="${serie}" class="input-serie">
                                <input type="hidden" name="productos[observacion][]" value="${observacion}" class="input-observacion">
                            </div>
                            <div>
                                <button type="button" class="remove-btn" data-id="producto-${productoId}">X</button>
                            </div>
                        </div>
                    `;

                    $("#productos-agregados").append(productoHTML);

                    if ($(".producto-agregado").length > 3) {
                        $("#productos-agregados").css({"max-height": "300px", "overflow-y": "auto"});
                    }

                    $("#producto-nombre, #producto-serie, #producto-observacion").val('');
                    $("#producto-nombre").focus();
                });

                // Eliminar producto de la lista
                $(document).on('click', '.remove-btn', function() {
                    const productoId = $(this).data('id');
                    $(`#${productoId}`).remove();

                    if ($(".producto-agregado").length <= 3) {
                        $("#productos-agregados").css({"max-height": "", "overflow-y": ""});
                    }
                });

                // Edición inline
                $(document).on('click', '.producto-agregado p', function() {
                    const $this = $(this);
                    const fieldName = $this.attr('class').split(' ')[0];
                    const labelElement = $this.find('.producto-label');
                    const label = labelElement.text();
                    const value = $this.text().replace(label, '').trim();
                    const productoId = $this.closest('.producto-agregado').attr('id');

                    if ($this.find('input, textarea').length > 0) return;

                    let $input;
                    if (fieldName === 'producto-observacion') {
                        // Se agregó el estilo adicional para el textarea
                        const labelWidth = labelElement.outerWidth(); // Medir el ancho de la etiqueta
                        $input = $('<textarea>')
                            .val(value)
                            .addClass('edit-inline')
                            .css({
                                'display': 'inline-block',
                                'vertical-align': 'middle',
                                'width': 'calc(100% - ' + labelWidth + 'px)',
                                'padding': '3px',
                                'border': '1px solid #007bff',
                                'border-radius': '3px',
                                'margin-left': '5px',
                                'resize': 'vertical',
                                'height': '38px', // Mismo alto inicial que los inputs
                                'overflow-y': 'hidden'
                            });
                    } else {
                        $input = $('<input type="text">').val(value);
                    }

                    $this.data('original-content', $this.html());
                    $this.html(labelElement.clone()).append($input);
                    $input.focus();

                    $input.on('blur keypress', function(e) {
                        if (e.type === 'blur' || (e.type === 'keypress' && e.which === 13)) {
                            const newValue = $(this).val();
                            $this.html(`<span class="producto-label">${label}</span> ${newValue}`);

                            // Actualizar todos los inputs ocultos relacionados con el producto
                            const $parent = $(`#${productoId}`);
                            $parent.find(`.input-${fieldName.split('-')[1]}`).val(newValue);
                            e.preventDefault();
                        }
                    });
                });
            });
        </script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Obtener el valor del botón deshabilitado
            let ordenServicioCreada = @json($buttonDisabled ? true : false);
            document.querySelectorAll(".editar-btn").forEach(function(btn) {
                btn.addEventListener("click", function () {
                    let row = this.closest("tr");

                    // Guardar valores originales
                    row.dataset.origEstado = row.querySelector(".estado-select").value;
                    row.dataset.origEstadoOS = row.querySelector(".estado-os-select").value;
                    row.dataset.origDiagnostico = row.querySelector(".diagnostico-cell").innerText;
                    row.dataset.origFechaInicio = row.querySelector(".fecha-inicio-cell").innerText;
                    row.dataset.origFechaFin = row.querySelector(".fecha-fin-cell").innerText;
                    row.dataset.origTecnico = row.querySelector(".tecnico-cell").innerText;

                    // Obtener elementos
                    let estadoSelect = row.querySelector(".estado-select");       // Estado de Reparación
                    let estadoOsSelect = row.querySelector(".estado-os-select"); // Estado
                    let tecnicoCell = row.querySelector(".tecnico-cell");
                    let fechaInicioCell = row.querySelector(".fecha-inicio-cell");
                    let fechaFinCell = row.querySelector(".fecha-fin-cell");
                    let diagnosticoCell = row.querySelector(".diagnostico-cell");

                    let fechaActual = new Date().toISOString().split('T')[0];
                    let userName = document.querySelector("#usuario-nombre").value;

                    // Forzar que la columna diagnostico esté vacía si estado-os-select es "0"
                    // estadoOsSelect.addEventListener("change", function () {
                    //     if (estadoOsSelect.value === "0") {
                    //         diagnosticoCell.innerText = "";
                    //         diagnosticoCell.setAttribute("contenteditable", "false");
                    //     } else {
                    //         if (!ordenServicioCreada) {
                    //             diagnosticoCell.setAttribute("contenteditable", "true");
                    //         }
                    //     }
                    // });

                    // diagnosticoCell.addEventListener("input", function () {
                    //     if (estadoOsSelect.value === "0") {
                    //         diagnosticoCell.innerText = "";
                    //     }
                    // });

                    if (!ordenServicioCreada) {
                        // Solo estado y diagnóstico son editables
                        estadoSelect.setAttribute("disabled", "true");
                        diagnosticoCell.setAttribute("contenteditable", "true");

                        // Otros campos bloqueados
                        estadoOsSelect.removeAttribute("disabled");
                        tecnicoCell.innerText = userName;
                        if (!fechaInicioCell.innerText.trim()) {
                            fechaInicioCell.innerText = fechaActual;
                        }
                        fechaFinCell.innerText = row.dataset.origFechaFin;

                    } else {
                        // Solo técnico, fechas y estado reparación son editables/autocompletables
                        estadoSelect.removeAttribute("disabled");
                        diagnosticoCell.setAttribute("contenteditable", "false");

                        estadoOsSelect.setAttribute("disabled", "true");

                        fechaInicioCell.innerText = row.dataset.origFechaInicio;
                        fechaFinCell.innerText = fechaActual;
                        tecnicoCell.innerText = row.dataset.origTecnico;
                    }

                    // Mostrar botones
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
                    let estadoOsValue = row.querySelector(".estado-os-select").value;
                    let estadoValueRaw = row.querySelector(".estado-select").value;
                    let estadoValue = estadoValueRaw === "" ? null : parseInt(estadoValueRaw);
                    let diagnostico = row.querySelector(".diagnostico-cell").innerText.trim() || null;

                    Swal.fire({
                        title: '¿Está seguro?',
                        text: "¿Desea guardar los cambios?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log("Enviando datos...", {
                                id,
                                estado_reparacion: estadoValue,
                                estado_os: estadoOsValue,
                                diagnostico
                            });

                            axios.post('/actualizar-guia-salida', {
                                id: id,
                                estado_os: parseInt(estadoOsValue),
                                estado_reparacion: estadoValue,
                                diagnostico: diagnostico
                            }, {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => {
                                console.log("Datos guardados correctamente", response.data);

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Guardado!',
                                    text: 'Datos actualizados correctamente.',
                                    confirmButtonText: 'Ir al detalle'
                                }).then(() => {
                                    // Guardamos en localStorage la sección y acordeón deseados
                                    localStorage.setItem('seccionActiva', 'seccion2');
                                    localStorage.setItem('acordeonActivo', 'accordionGuiaSalida');

                                    // Forzamos la recarga modificando la URL con un query parameter único
                                    const baseUrl = window.location.href.split('?')[0];
                                    window.location.href = baseUrl + '?reload=' + new Date().getTime();
                                });
                            })
                            .catch(error => {
                                console.error("Error al guardar:", error);
                                if (error.response) {
                                    Swal.fire('Error', `Error del servidor: ${error.response.status} - ${error.response.data.message || "Error desconocido"}`, 'error');
                                } else if (error.request) {
                                    Swal.fire('Error', 'No se recibió respuesta del servidor. Verifique su conexión a internet.', 'error');
                                } else {
                                    Swal.fire('Error', 'Error al procesar la solicitud: ' + error.message, 'error');
                                }
                            });
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
                    row.querySelector(".fecha-inicio-cell").innerText = row.dataset.origFechaInicio;
                    row.querySelector(".fecha-fin-cell").innerText = row.dataset.origFechaFin;
                    row.querySelector(".estado-os-select").value = row.dataset.origEstadoOS;
                    row.querySelector(".estado-select").value = row.dataset.origEstado;
                    row.querySelector(".diagnostico-cell").innerText = row.dataset.origDiagnostico;

                    // Reaplicar colores
                    aplicarColorEstado(row.querySelector(".estado-select"), 'reparacion');
                    aplicarColorEstado(row.querySelector(".estado-os-select"), 'os');

                    // Deshabilitar la edición
                    row.querySelector(".estado-select").setAttribute("disabled", "true");
                    row.querySelector(".estado-os-select").setAttribute("disabled", "true");
                    row.querySelector(".diagnostico-cell").setAttribute("contenteditable", "false");

                    // Ocultar botones Guardar y Cancelar, mostrar Editar
                    row.querySelector(".guardar-btn").hidden = true;
                    row.querySelector(".cancelar-btn").hidden = true;
                    row.querySelector(".editar-btn").hidden = false;
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Si no hay ninguna sección activa por defecto, activa seccion1
            let seccionActivaDefault = document.querySelector(".contenido.activo");
            if (!seccionActivaDefault) {
                document.getElementById("seccion1").classList.add("activo");
            }

            // Recupera la sección y acordeón a activar desde localStorage
            const seccionActiva = localStorage.getItem('seccionActiva');
            const acordeonActivo = localStorage.getItem('acordeonActivo');

            if (seccionActiva) {
                // Usamos tu función para cambiar la sección
                // Aquí simulamos el clic en el botón correspondiente,
                // suponiendo que el botón tiene un onclick que llama a mostrarSeccion
                const boton = document.querySelector(`.boton[onclick*="mostrarSeccion('${seccionActiva}'"]`);
                if (boton) {
                    mostrarSeccion(seccionActiva, boton);
                } else {
                    // Si no encontramos el botón, forzamos el activo en la sección
                    document.getElementById(seccionActiva).classList.add("activo");
                }
                localStorage.removeItem('seccionActiva');
            }

            if (acordeonActivo) {
                // Aquí, dependiendo de cómo abra el acordeón, puedes simular un clic
                // o agregar la clase que lo muestre. Por ejemplo:
                const acordeon = document.getElementById(acordeonActivo);
                if (acordeon) {
                    // Supongamos que tu sistema abre el acordeón agregando la clase "activo"
                    acordeon.classList.add("activo");
                    // También, si tienes un botón toggle en el header, actualízalo:
                    const header = document.querySelector(`#acordeon-trigger-${acordeonActivo.replace(/\D/g, "")}`);
                    if (header) {
                        const toggleBtn = header.querySelector('.accordion-toggle-btn');
                        if (toggleBtn) {
                            toggleBtn.textContent = '-';
                        }
                    }
                }
                localStorage.removeItem('acordeonActivo');
            }
        });
    </script>
    <script>
        function aplicarColorEstado(select, tipo) {
            select.classList.remove('text-danger', 'text-success', 'text-warning');

            if (select.value === "") return;

            if (tipo === 'reparacion') {
                if (select.value === "0") select.classList.add('text-danger');
                else if (select.value === "1") select.classList.add('text-success');
            }

            if (tipo === 'os') {
                if (select.value === "0") select.classList.add('text-warning');
                else if (select.value === "1") select.classList.add('text-success');
            }
        }

        document.querySelectorAll('.estado-select').forEach(select => {
            aplicarColorEstado(select, 'reparacion');
            select.addEventListener('change', () => aplicarColorEstado(select, 'reparacion'));
        });

        document.querySelectorAll('.estado-os-select').forEach(select => {
            aplicarColorEstado(select, 'os');
            select.addEventListener('change', () => aplicarColorEstado(select, 'os'));
        });
    </script>
@endsection
