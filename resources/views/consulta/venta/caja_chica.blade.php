@extends('layout')
@section('title', 'Ventas')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('styles')
<style>
.table th {
    background-color: #343a40 !important;
    color: white !important;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
    text-align: center;
}

.badge {
    font-size: 0.75em;
    padding: 0.5em 0.75em;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.table-responsive {
    border-radius: 0.375rem;
    overflow: hidden;
}

.text-success {
    font-weight: 600;
}

.text-danger {
    font-weight: 600;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Encabezado con totales -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="border border-success rounded p-3 text-center">
                                <h5 class="mb-0">Total de Ingresos: <span class="text-success">S/ 0</span></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border border-danger rounded p-3 text-center">
                                <h5 class="mb-0">Total de Egresos: <span class="text-danger">S/ 0</span></h5>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de filtros -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label for="saldo_actual" class="form-label">Saldo Actual:</label>
                                    <input type="text" class="form-control" id="saldo_actual" value="S/ 200.00" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                                    <input type="date" class="form-control" id="fecha_inicio" value="2025-05-28">
                                </div>
                                <div class="col-md-3">
                                    <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                                    <input type="date" class="form-control" id="fecha_fin">
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <!-- Botón inicial: Abrir caja -->
                            <button type="button" class="btn btn-success btn-lg" id="btnAbrirCaja">
                                Abrir caja
                            </button>

                            <!-- Botones cuando la caja está abierta (inicialmente ocultos) -->
                            <div id="botonesAbiertos" style="display: none;">
                                <button type="button" class="btn btn-secondary me-2" id="btnCerrarCaja">
                                    Cerrar caja
                                </button>
                                <button type="button" class="btn btn-primary" id="btnAgregar" data-bs-toggle="modal" data-bs-target="#modalAgregar">
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla (inicialmente oculta) -->
                    <div id="tablaMovimientos" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>NRO. PAGO</th>
                                        <th>FECHA</th>
                                        <th>DNI</th>
                                        <th>NOMBRES</th>
                                        <th>TIPO</th>
                                        <th>INGRESOS</th>
                                        <th>EGRESOS</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Datos de ejemplo -->
                                    <tr>
                                        <td>001</td>
                                        <td>28/05/2025</td>
                                        <td>12345678</td>
                                        <td>Juan Pérez García</td>
                                        <td><span class="badge bg-success">Ingreso</span></td>
                                        <td class="text-success">S/ 150.00</td>
                                        <td>-</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning me-1">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>002</td>
                                        <td>28/05/2025</td>
                                        <td>87654321</td>
                                        <td>María López Rodríguez</td>
                                        <td><span class="badge bg-danger">Egreso</span></td>
                                        <td>-</td>
                                        <td class="text-danger">S/ 75.00</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning me-1">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>003</td>
                                        <td>27/05/2025</td>
                                        <td>11223344</td>
                                        <td>Carlos Mendoza Silva</td>
                                        <td><span class="badge bg-success">Ingreso</span></td>
                                        <td class="text-success">S/ 200.00</td>
                                        <td>-</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning me-1">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
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

<!-- Modal para agregar (placeholder por ahora) -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarLabel">Agregar Movimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Aquí irá el formulario para agregar un nuevo movimiento a la caja chica.</p>
                <!-- Aquí puedes agregar tu formulario más adelante -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnAbrirCaja = document.getElementById('btnAbrirCaja');
        const btnCerrarCaja = document.getElementById('btnCerrarCaja');
        const botonesAbiertos = document.getElementById('botonesAbiertos');
        const tablaMovimientos = document.getElementById('tablaMovimientos');

        // Función para abrir la caja
        btnAbrirCaja.addEventListener('click', function() {
            // Ocultar botón "Abrir caja"
            btnAbrirCaja.style.display = 'none';

            // Mostrar botones "Cerrar caja" y "Agregar"
            botonesAbiertos.style.display = 'block';

            // Mostrar la tabla
            tablaMovimientos.style.display = 'block';

            // Agregar animación suave
            tablaMovimientos.style.opacity = '0';
            setTimeout(function() {
                tablaMovimientos.style.transition = 'opacity 0.3s ease-in-out';
                tablaMovimientos.style.opacity = '1';
            }, 50);
        });

        // Función para cerrar la caja
        btnCerrarCaja.addEventListener('click', function() {
            // Ocultar tabla con animación
            tablaMovimientos.style.transition = 'opacity 0.3s ease-in-out';
            tablaMovimientos.style.opacity = '0';

            setTimeout(function() {
                // Ocultar tabla y botones
                tablaMovimientos.style.display = 'none';
                botonesAbiertos.style.display = 'none';

                // Mostrar botón "Abrir caja"
                btnAbrirCaja.style.display = 'block';

                // Restablecer opacidad para la próxima vez
                tablaMovimientos.style.opacity = '1';
                tablaMovimientos.style.transition = '';
            }, 300);
        });
    });
    </script>
@endsection
