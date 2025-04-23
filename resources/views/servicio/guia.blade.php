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
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/ordenservicioinfocliente.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <div>
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
        <button id="btnInformeTecnico" class="btn-agregar-guia"> Crear Informe Técnico </button>



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
                        <button class="btn btn-primary btn-sm ver-os-btn" id="ver-os-btn">Ver Orden de Servicio</button>
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
                                                        {{-- Modal Subir Imagen --}}
                                                        {{-- <div class="modal fade"
                                                            id="modalSubirImagen-{{ $detalle_s->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="modalSubirImagenLabel-{{ $detalle_s->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                                <div class="modal-content shadow-lg border-0 rounded-4">
                                                                    <div class="modal-header bg-primary text-white rounded-top-4">
                                                                        <h3 class="modal-title fw-semibold" id="modalSubirImagenLabel-{{ $detalle_s->id }}">
                                                                            📷 Subir Imagen del Detalle
                                                                        </h3>
                                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body p-4">
                                                                        <form action="{{ route('imagenGuiaSalida.image', $detalle_s->id) }}"
                                                                            method="POST"
                                                                            enctype="multipart/form-data"
                                                                            class="needs-validation"
                                                                            novalidate
                                                                            oninput="document.getElementById('btnSubirImagen-{{ $detalle_s->id }}').disabled = !this.checkValidity()">
                                                                          @csrf

                                                                          <div class="mb-4">
                                                                              <label for="foto-{{ $detalle_s->id }}" class="form-label fw-semibold">
                                                                                  🖼️ Imagen (<small>jpg, jpeg, png, webp</small>)
                                                                              </label>
                                                                              <input type="file"
                                                                                     class="form-control form-control-lg"
                                                                                     id="foto-{{ $detalle_s->id }}"
                                                                                     name="foto"
                                                                                     accept=".jpg,.jpeg,.png,.webp"
                                                                                     required>
                                                                          </div>

                                                                          <div class="mb-4">
                                                                              <label for="descripcion-{{ $detalle_s->id }}" class="form-label fw-semibold">
                                                                                  📝 Descripción
                                                                              </label>
                                                                              <textarea class="form-control"
                                                                                        id="descripcion-{{ $detalle_s->id }}"
                                                                                        name="descripcion"
                                                                                        rows="3"
                                                                                        required
                                                                                        placeholder="Describe esta imagen..."></textarea>
                                                                          </div>

                                                                          <div class="text-center">
                                                                              <button type="submit"
                                                                                      class="btn btn-success px-4 py-2"
                                                                                      id="btnSubirImagen-{{ $detalle_s->id }}"
                                                                                      >
                                                                                  <i class="bi bi-upload me-1"></i> Subir Imagen
                                                                              </button>
                                                                          </div>
                                                                      </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div id="modalSubirImagen-{{ $detalle_s->id }}" class="modal fade" tabindex="-1" aria-labelledby="modalSubirImagenLabel-{{ $detalle_s->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                              <div class="modal-content shadow-lg border-0 rounded-4">
                                                                <div class="modal-header bg-primary text-white rounded-top-4">
                                                                  <h3 class="modal-title fw-semibold" id="modalSubirImagenLabel-{{ $detalle_s->id }}">📷 Subir Imagen del Detalle</h3>
                                                                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body p-4">
                                                                  <div class="mb-4">
                                                                    <label for="foto-{{ $detalle_s->id }}" class="form-label fw-semibold">🖼️ Imagen</label>
                                                                    <input type="file" class="form-control form-control-lg" id="foto-{{ $detalle_s->id }}" accept=".jpg,.jpeg,.png,.webp" required>
                                                                  </div>

                                                                  <div class="mb-4">
                                                                    <label for="descripcion-{{ $detalle_s->id }}" class="form-label fw-semibold">📝 Descripción</label>
                                                                    <textarea class="form-control" id="descripcion-{{ $detalle_s->id }}" rows="3" required placeholder="Describe esta imagen..."></textarea>
                                                                  </div>

                                                                  <div class="text-center">
                                                                    <button class="btn btn-success px-4 py-2" onclick="subirImagen({{ $detalle_s->id }})">
                                                                      <i class="bi bi-upload me-1"></i> Subir Imagen
                                                                    </button>
                                                                  </div>
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
                                                    {{-- Modal Ver Imagen --}}
                                                    @if(isset($imagenesProducto[$detalle_s->id]))
                                                        @php $img = $imagenesProducto[$detalle_s->id]; @endphp
                                                        <div class="modal fade"
                                                            id="modalVerImagen-{{ $detalle_s->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="modalVerImagenLabel-{{ $detalle_s->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                <div class="modal-content shadow-sm">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modalVerImagenLabel-{{ $detalle_s->id }}">
                                                                            Imagen de Detalle
                                                                        </h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        <img src="{{ asset($img->foto) }}"
                                                                            alt="Imagen"
                                                                            class="img-fluid rounded"
                                                                            style="max-height:500px;">
                                                                        @if($img->descripcion)
                                                                            <p class="mt-3">{{ $img->descripcion }}</p>
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
        {{-- Mostrar Orden de servicio --}}
        <div id="panel-OS" class="panel-OS">
            <div class="contenido-OS">
                <h1>Orden de servicio</h1>
                <div class="products">
                    <h2>Productos</h2>
                    <ul class="product-list">
                        @foreach ($servicioGuiaSalidas as $salida)
                            @foreach ($salida->detalle_guia_salida as $detalle_s)
                                <li class="product-item">
                                    <h3>{{ $detalle_s->detalle_guia_ingreso->producto ?? 'Sin dato' }}</h3>
                                    <p class="short-description">{{ $detalle_s->descripcion_os ?? 'Sin dato' }}</p>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección3  - informe tecnico -->
    <div id="seccion3" class="contenido">
        <div id="informeTecnico" class="contenido" style="display: none;" >
        <div class="Contendortecnico">
            <!-- Contenedor izquierdo -->
            <div class="contenedor-izquierda">
                <!-- Botón para mostrar productos -->
                <button class="boton-seleccionar" onclick="mostrarProductos()">Seleccionar Producto</button>

                <!-- Lista desplegable de productos -->
                <div class="productos" id="productos" style="display: none;">
                    <ul>
                        @if (!empty($servicioGuiaSalidas) && count($servicioGuiaSalidas) > 0)
                        @foreach ($servicioGuiaSalidas as $salida)
                            @foreach ($salida->detalle_guia_salida as $detalle_s)
                                @php
                                    $id = $detalle_s->id ?? '';
                                    $producto = $detalle_s->detalle_guia_ingreso->producto ?? '';
                                    $serie = $detalle_s->detalle_guia_ingreso->serie ?? '';
                                    $observacion = $detalle_s->detalle_guia_ingreso->observacion ?? '';
                                    $diagnostico = $detalle_s->diagnostico ?? '';
                                    $imagen = $imagenesProducto[$detalle_s->id]->foto ?? '';
                                    $descripcion = $imagenesProducto[$detalle_s->id]->descripcion ?? '';
                                    $tecnico = $detalle_s->user
                                        ? $detalle_s->user->personal->nombres . ' ' . $detalle_s->user->personal->apellidos
                                        : '';
                                    $imagenUrl = $imagen ? asset('storage/' . $imagen) : '';

                                    $jsonData = json_encode([
                                        'id' => $id,
                                        'producto' => $producto,
                                        'serie' => $serie,
                                        'observacion' => $observacion,
                                        'diagnostico' => $diagnostico,
                                        'descripcion' => $descripcion,
                                        'imagenUrl' => $imagenUrl,
                                        'tecnico' => $tecnico
                                    ]);
                                @endphp

                                <li onclick='mostrarDetallesProducto({!! $jsonData !!})'>
                                    {{ $producto }}
                                </li>
                            @endforeach
                        @endforeach
                    @else
                        <li>No hay productos disponibles</li>
                    @endif
                    </ul>
                </div>

                <!-- Imagen y descripción -->
                <div class="contenedor-interno" id="contenedor-imagen" style="text-align: center;">
                    <img id="imagen-producto" src="" alt="Imagen del producto"
                        class="img-fluid"
                        style="max-height: 300px; width: auto; object-fit: contain; border: 1px solid #ccc; padding: 5px;">
                </div>

                <div id="contenedor-descripcion" style="text-align: center;">
                    <p>Descripción:</p>
                    <div>
                        <input class="contenedordescripcion" type="text" id="descripcion_os" placeholder="Escribe la descripción" readonly style="text-align: center;">
                    </div>
                </div>
            </div>

            <!-- Contenedor derecho -->
            <div class="contenedor-derecha">
                <div>Item:</div>
                <div><input type="text" id="item" placeholder="Escribe el item" readonly></div>

                <div>Producto:</div>
                <div><input type="text" id="producto" placeholder="Escribe el producto" readonly></div>

                <div>Serie:</div>
                <div><input type="text" id="serie" placeholder="Escribe la serie" readonly></div>

                <div>Observación:</div>
                <div><input type="text" id="observacion" placeholder="Escribe la observación" readonly></div>

                <div>Diagnóstico:</div>
                <div><input type="text" id="diagnostico" placeholder="Escribe el diagnóstico" readonly></div>

                <div>Técnico Responsable:</div>
                <div><input type="text" id="tecnico" placeholder="Escribe el técnico responsable" readonly></div>


                <div class="botones">

                    <button>
                        <a href="{{ route('servicio.pdf.download', ['guia_id' => $guia->id]) }}" id="btn-descargar-pdf">
                        </i> Descargar PDF
                        </a>
                    </button>
                    <button onclick="imprimirPDF()" id="btn-imprimir-pdf">
                       </i> Imprimir PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
 </div>
</div>

<script>
    // Muestra automáticamente el contenido al cargar la página
    window.addEventListener('DOMContentLoaded', () => {
        crearInformeTecnico();
    });

    function crearInformeTecnico() {
        // Muestra el acordeón
        const acordeon = document.getElementById("accordionGuiaSalida");
        if (acordeon) {
            acordeon.style.display = 'block';
        }

        // Muestra la sección de informe técnico
        const informeTecnico = document.getElementById("informeTecnico");
        if (informeTecnico) {
            informeTecnico.style.display = 'block';
        }
    }

    function mostrarProductos() {
        const productos = document.getElementById('productos');
        if (productos) {
            productos.style.display = (productos.style.display === 'none' || productos.style.display === '') ? 'block' : 'none';
        }
    }

    function mostrarDetallesProducto(data) {
        // Campos de texto
        document.getElementById("item").value = data.id;
        document.getElementById("producto").value = data.producto;
        document.getElementById("serie").value = data.serie;
        document.getElementById("observacion").value = data.observacion;
        document.getElementById("diagnostico").value = data.diagnostico;
        document.getElementById("tecnico").value = data.tecnico;

        // Imagen
        const contenedorImagen = document.getElementById("contenedor-imagen");
        const imagenElement = document.getElementById("imagen-producto");

        if (data.imagenUrl) {
            imagenElement.src = data.imagenUrl;
            contenedorImagen.style.display = 'block';
        } else {
            imagenElement.src = '';
            contenedorImagen.style.display = 'none';
        }

        // Descripción
        const contenedorDescripcion = document.getElementById("contenedor-descripcion");
        const descripcionInput = document.getElementById("descripcion_os");

        if (data.descripcion && data.descripcion.trim() !== '') {
            descripcionInput.value = data.descripcion;
            contenedorDescripcion.style.display = 'block';
        } else {
            descripcionInput.value = '';
            contenedorDescripcion.style.display = 'none';
        }

        // Oculta la lista
        const productos = document.getElementById('productos');
        if (productos) {
            productos.style.display = 'none';
        }
    }

    function descargarPDF() {
        alert('Función para descargar PDF (implementa con jsPDF o similar)');
    }

    function imprimir() {
        window.print();
    }
</script>

{{-- script para la funcion de imprimir --}}
<script>
    var printIframe;

    function imprimirPDF() {
        if (printIframe) {
            document.body.removeChild(printIframe);
        }

        printIframe = document.createElement('iframe');
        printIframe.style.position = 'fixed';
        printIframe.style.right = '0';
        printIframe.style.bottom = '0';
        printIframe.style.width = '0';
        printIframe.style.height = '0';
        printIframe.style.border = '0';
        printIframe.src = "{{ route('ver.pdf', ['guia_id' => $guia->id]) }}";

        document.body.appendChild(printIframe);

        printIframe.onload = function() {
            try {
                printIframe.focus();
                printIframe.contentWindow.print();
            } catch (e) {
                console.error("Error al imprimir:", e);
                alert("Hubo un problema al imprimir. Por favor, intente nuevamente.");
            }
        };
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
        function mostrarModalEditar(selectElement) {
          const accion = selectElement.value;
          if (accion) {
            console.log(`Acción seleccionada: ${accion}`);
            selectElement.selectedIndex = 0; // Resetear el select
          }
        }

        document.addEventListener("DOMContentLoaded", function() {
            function toggleAccordion(triggerId, contentId) {
                const trigger = document.getElementById(triggerId);
                const content = document.getElementById(contentId);
                const toggleBtn = trigger.querySelector('.accordion-toggle-btn');

                trigger.addEventListener('click', function() {
                    const isOpen = content.classList.contains('activo');

                    document.querySelectorAll(".acordeon-contenido").forEach(el => el.classList.remove('activo'));
                    document.querySelectorAll(".accordion-toggle-btn").forEach(el => el.textContent = '+');

                    if (!isOpen) {
                        content.classList.add('activo');
                        toggleBtn.textContent = '-';
                    }
                });
            }

            toggleAccordion('acordeon1-trigger-{{ $guia->id }}', 'acordeon1-collapse-{{ $guia->id }}');

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
                    let estadoSelect = row.querySelector(".estado-select");
                    let estadoOsSelect = row.querySelector(".estado-os-select");
                    let tecnicoCell = row.querySelector(".tecnico-cell");
                    let fechaInicioCell = row.querySelector(".fecha-inicio-cell");
                    let fechaFinCell = row.querySelector(".fecha-fin-cell");
                    let diagnosticoCell = row.querySelector(".diagnostico-cell");

                    let fechaActual = new Date().toISOString().split('T')[0];
                    let userName = document.querySelector("#usuario-nombre").value;

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
                                    localStorage.setItem('seccionActiva', 'seccion2');
                                    localStorage.setItem('acordeonActivo', 'acordeon2-collapse-{{ $guia->id }}');

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
                const boton = document.querySelector(`.boton[onclick*="mostrarSeccion('${seccionActiva}'"]`);
                if (boton) {
                    mostrarSeccion(seccionActiva, boton);
                } else {
                    document.getElementById(seccionActiva).classList.add("activo");
                }
                localStorage.removeItem('seccionActiva');
            }

            if (acordeonActivo) {
                const content = document.getElementById(acordeonActivo);
                if (content) {
                    content.classList.add('activo');

                    const header = content.previousElementSibling;
                    if (header && header.classList.contains('acordeon-header')) {
                        const toggleBtn = header.querySelector('.accordion-toggle-btn');
                        if (toggleBtn) {
                            toggleBtn.textContent = '−';
                        }
                    }
                }
                localStorage.removeItem('acordeonActivo');
            }
        });

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

        const panelOS = document.getElementById('panel-OS');
        const btnVerOS = document.querySelector('.ver-os-btn');

        // Mostrar panel al hacer clic en el botón
        btnVerOS.addEventListener('click', (e) => {
            e.stopPropagation();
            panelOS.classList.add('mostrar');
        });

        // Ocultar panel si se hace clic fuera de él
        document.addEventListener('click', (e) => {
            if (!panelOS.contains(e.target) && !btnVerOS.contains(e.target)) {
                panelOS.classList.remove('mostrar');
            }
        });
    </script>

<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>

    {{-- Scripts combinados para validación y alertas --}}
    {{-- @once
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Validación Bootstrap + Swal warning
      document.querySelectorAll('form.needs-validation').forEach(form => {
        form.addEventListener('submit', e => {
          if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            form.classList.add('was-validated');
          }
        });
      });

      // Swal error (no recarga)
      @if(session('error'))
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '{{ session('error') }}',
          confirmButtonColor: '#d33'
        });
      @endif

      // Swal success (recarga solo al OK)
      @if(session('success'))
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: '{{ session('success') }}',
          confirmButtonColor: '#3085d6'
        }).then(() => {
          localStorage.setItem("seccionActiva", "seccion2");
          localStorage.setItem("acordeonActivo", "acordeon2-collapse-{{ $guia->id }}");
          const url = new URL(window.location);
          url.searchParams.set("reload", Date.now());
          window.location.href = url;
        });
      @endif
    });
    </script>
    @endonce --}}
    @once
<script>
async function subirImagen(detalleId) {
  const fileInput = document.getElementById(`foto-${detalleId}`);
  const descInput = document.getElementById(`descripcion-${detalleId}`);

  const file = fileInput.files[0];
  const descripcion = descInput.value.trim();

  // Validación previa
  if (!file || !descripcion) {
    Swal.fire({
      icon: 'warning',
      title: 'Formulario incompleto',
      text: 'Debes seleccionar una imagen y escribir la descripción.',
      confirmButtonColor: '#d33'
    });
    return;
  }

  const formData = new FormData();
  formData.append('foto', file);
  formData.append('descripcion', descripcion);
  formData.append('_token', '{{ csrf_token() }}');

  try {
    const response = await fetch(`{{ url('/imagen-guia-salida') }}/${detalleId}`, {
      method: 'POST',
      body: formData
    });

    const result = await response.json();

    if (result.success) {
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: result.message,
        confirmButtonColor: '#3085d6'
      }).then(() => {
        location.reload();
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: result.message || 'Ocurrió un error al subir la imagen.',
        confirmButtonColor: '#d33'
      });
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error inesperado',
      text: error.message,
      confirmButtonColor: '#d33'
    });
  }
}
</script>
@endonce



@endsection
