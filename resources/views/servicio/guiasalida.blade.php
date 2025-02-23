@extends('layout')
{{-- <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script> --}}
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="tabs-container">
        @include('servicio._shared.tabs')
        <div class="container mt-4">
            <h2 class="text-center mb-4">GUÍA DE SALIDA</h2>
            <!-- CLIENTES -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card p-2 mb-4">
                        <h3 class="mb-3">CLIENTES</h3>
                        <form>
                            <div class="row mb-2">
                                <div class="col-md-6 d-flex align-items-center">
                                    <label class="form-label me-2" style="width: 80px;">DNI/RUC:</label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <label class="form-label me-2" style="width: 80px;">Nombre:</label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-2" style="width: 100px;">Dirección:</label>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6 d-flex align-items-center">
                                    <label class="form-label me-2" style="width: 80px;">Contacto:</label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <label class="form-label me-2" style="width: 80px;">Teléfono:</label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-2" style="width: 100px;">Ciudad:</label>
                                <input type="text" class="form-control" readonly>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- DATOS GENERALES -->
                <div class="col-md-6">
                    <div class="card p-2 mb-4">
                        <h3 class="mb-3">DATOS GENERALES</h3>
                        <form>
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-2" style="width: 150px;">Recepcionista:</label>
<<<<<<< HEAD
                                <input type="text" class="form-control" readonly>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-2" style="width: 150px;">Fecha de ingreso:</label>
                                <input type="date" class="form-control" readonly>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-2" style="width: 150px;">Orden de servicio:</label>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-2" style="width: 150px;">Fecha estimada:</label>
                                <input type="date" class="form-control" readonly>
=======
                                <input type="text" class="form-control" value="{{ optional($personal->first())->nombres }} {{ optional($personal->first())->apellidos }}" readonly>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-2" style="width: 150px;">Fecha de ingreso:</label>
                                <input type="date" class="form-control" value="{{ optional($datos_ingreso->first())->created_at?->format('Y-m-d') }}" readonly>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-2" style="width: 150px;">Orden de servicio:</label>
                                <input type="text" class="form-control" value="{{ optional($datos_ingreso->first())->orden_servicio }}" readonly>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-2" style="width: 150px;">Fecha estimada:</label>
                                <input type="date" class="form-control" value="{{ optional($datos_ingreso->first())->updated_at?->format('Y-m-d') }}" readonly>
>>>>>>> 39fcd56b (Vita conexion de la tabla con base de datos)
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- BÚSQUEDA DE PRODUCTOS -->
            <div class="card shadow-sm p-3 mt-4">
                <form class="d-flex" role="search" action="index.php?ruta=store/buscar_productos" method="POST">
                    <div class="input-group">
                        <input type="search" class="form-control" name="search" placeholder="Buscar Producto"required>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>

            <!-- TABLA DE REGISTROS -->
            <div class="card shadow-sm p-3 mt-4">
                <div class="table-responsive mt-1">
                    <table class="table table-striped table-bordered text-center table-hover shadow-sm rounded w-100">
                        <thead class="text-black">
                            <tr>
                                +<th>ITEM</th>
                                <th>SERIE</th>
                                +<th>DESCRIPCIÓN</th>
                                <th>OBSERVACIÓN</th>
                                ++<th>TÉCNICO DE DIAGNÓSTICO</th>
                                +<th>FECHA</th>
                                +<th>DIAGNÓSTICO</th>
                                +<th>ESTADO DE APROBACIÓN</th>
                                <th>TÉCNICO DE REPARACIÓN</th>
                                +<th>ESTADO DE REPARACIÓN</th>
                                +<th>RECOMENDACIONES</th>
                                <th>AÑADIR IMAGEN</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($registros as $registro)
                                @if (empty($registro->id))
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $registro->id ?? '-' }}</td>
                                    <td>-</td>
                                    <td>{{ $registro->descripcion_problema ?? '-' }}</td>
                                    <td>{{ $registro->diagnostico_solucion ?? '-' }}</td>
                                    <td>{{ $registro->personal_laborales->nombres ?? '-' }}</td>
                                    <td>{{ $registro->fecha ?? '-' }}</td>
                                    <td>{{ $registro->diagnostico_solucion ?? '-' }}</td>
                                    <td class="fw-bold
                                        @if($registro->estado == 1) text-success
                                        @else text-danger
                                        @endif">
                                        {{ $registro->estado == 1 ? 'Aprobado' : 'Rechazado' }}
                                    </td>
                                    <td>{{ $registro->recomendaciones ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">
                                            <i class="bi bi-upload"></i> Subir
                                        </button>
                                    </td>
                                    <td>
                                        <select class="form-select form-select-sm">
                                            <option value="view">Ver</option>
                                            <option value="delete">Eliminar</option>
                                            <option value="edit">Editar</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- <tr>
                                <td>001</td>
                                <td>SN-2024X001</td>
                                <td>Laptop Dell Inspiron 15</td>
                                <td>La pantalla parpadea intermitentemente</td>
                                <td>Juan Pérez</td>
                                <td>2025-02-12</td>
                                <td>Falla en la conexión del cable flex de la pantalla</td>
                                <td class="fw-bold text-success">Aprobado</td>
                                <td>Pedro Gómez</td>
                                <td class="fw-bold text-success">Reparado</td>
                                <td>Reemplazo del cable flex y prueba de estabilidad</td>
                                <td><button class="btn btn-primary btn-sm">
                                    <i class="bi bi-upload"></i> Subir</button></td>
                                <td>
                                    <select class="form-select form-select-sm">
                                        <option>Ver</option>
                                        <option>Eliminar</option>
                                        <option>Editar</option>
                                    </select>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
