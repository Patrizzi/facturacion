@extends('layout')
@section('title', 'Ventas')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('styles')
<style>
* {
    box-sizing: border-box;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Layout Grid */
.row {
    display: flex;
    flex-wrap: wrap;
    margin: -10px;
}

.col-6 {
    flex: 0 0 50%;
    padding: 10px;
}

.col-3 {
    flex: 0 0 25%;
    padding: 10px;
}

.col-12 {
    flex: 0 0 100%;
    padding: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .col-6, .col-3 {
        flex: 0 0 100%;
    }
}

/* Cards y Contenedores */
.summary-card {
    border: 2px solid;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    font-weight: bold;
    margin-bottom: 20px;
}

.summary-card.success {
    border-color: #28a745;
    color: #28a745;
    background-color: #f8fff9;
}

.summary-card.danger {
    border-color: #dc3545;
    color: #dc3545;
    background-color: #fff8f8;
}

.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    overflow: hidden;
}

.card-body {
    padding: 20px;
}

/* Formularios */
.form-group {
    margin-bottom: 15px;
}

.form-label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #333;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #0077b6;
    box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.1);
}

.form-control[readonly] {
    background-color: #f8f9fa;
    cursor: not-allowed;
}

.form-control-lg {
    padding: 12px 15px;
    font-size: 16px;
    border-radius: 8px;
}

.form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M10.293 3.293 6 7.586 1.707 3.293A1 1 0 0 0 .293 4.707l5 5a1 1 0 0 0 1.414 0l5-5a1 1 0 1 0-1.414-1.414z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 12px;
    padding-right: 40px;
    appearance: none;
}

.input-group {
    display: flex;
    align-items: stretch;
}

.input-group .form-control {
    border-radius: 0;
    border-right: none;
}

.input-group .form-control:first-child {
    border-radius: 6px 0 0 6px;
}

.input-group .form-control:last-child {
    border-radius: 0 6px 6px 0;
    border-right: 1px solid #ddd;
}

.input-group-text {
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    padding: 10px 12px;
    border-radius: 0;
    font-size: 14px;
    color: #666;
}

.input-group .input-group-text:first-child {
    border-radius: 6px 0 0 6px;
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

/* Botones */
.btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 500;
    text-align: center;
    text-decoration: none;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    line-height: 1.5;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn-primary {
    background-color: #0077b6;
    color: white;
}

.btn-primary:hover {
    background-color: #023e8a;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-success:hover {
    background-color: #1e7e34;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #c82333;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #545b62;
}

.btn-outline-dark {
    background-color: transparent;
    color: #333;
    border: 1px solid #333;
}

.btn-outline-dark:hover {
    background-color: #333;
    color: white;
}

.btn-outline-secondary {
    background-color: transparent;
    color: #6c757d;
    border: 1px solid #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.btn-lg {
    padding: 12px 24px;
    font-size: 16px;
}

/* Utilidades de espaciado */
.mb-3 { margin-bottom: 1rem; }
.mb-4 { margin-bottom: 1.5rem; }
.py-4 { padding: 1.5rem 0; }
.px-4 { padding: 0 1.5rem; }
.py-3 { padding: 1rem 0; }
.px-5 { padding: 0 3rem; }
.gap-2 { gap: 0.5rem; }

/* Utilidades de flex */
.d-flex {
    display: flex;
}

.justify-content-end {
    justify-content: flex-end;
}

.justify-content-center {
    justify-content: center;
}

.align-items-end {
    align-items: flex-end;
}

.flex-wrap {
    flex-wrap: wrap;
}

.flex-fill {
    flex: 1;
}

/* Utilidades de texto */
.text-center {
    text-align: center;
}

.text-start {
    text-align: left;
}

.fw-bold {
    font-weight: bold;
}

.text-muted {
    color: #6c757d;
}

.text-dark {
    color: #333;
}

.small {
    font-size: 0.875rem;
}

/* Tabla */
.table-responsive {
    overflow-x: auto;
    margin-top: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table th,
.table td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #dee2e6;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #333;
    border-bottom: 2px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.table .text-start {
    text-align: left;
}

/* Badges */
.badge {
    display: inline-block;
    padding: 4px 8px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 4px;
    text-transform: uppercase;
}

.badge.bg-warning {
    background-color: #ffc107;
    color: #333;
}

.badge.bg-info {
    background-color: #17a2b8;
    color: white;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    backdrop-filter: blur(2px);
}

.modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-dialog {
    max-width: 800px;
    width: 90%;
    max-height: 90vh;
    margin: 20px;
}

.modal-dialog-lg {
    max-width: 900px;
}

.modal-content {
    background-color: white;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    overflow: hidden;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: white;
}

.modal-title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.modal-body {
    padding: 24px;
    background-color: #f8f9fa;
    flex: 1;
    overflow-y: auto;
}

.modal-footer {
    padding: 20px 24px;
    border-top: 1px solid #dee2e6;
    background-color: white;
    display: flex;
    justify-content: center;
    gap: 12px;
}

.btn-close {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #999;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-close:hover {
    color: #333;
}

.btn-close::before {
    content: "×";
    font-size: 24px;
    line-height: 1;
}

/* Grid del modal */
.modal .row {
    margin: -12px;
}

.modal .col-3,
.modal .col-4,
.modal .col-5,
.modal .col-6,
.modal .col-8,
.modal .col-12 {
    padding: 12px;
}

.modal .col-3 { flex: 0 0 25%; }
.modal .col-4 { flex: 0 0 33.333333%; }
.modal .col-5 { flex: 0 0 41.666667%; }
.modal .col-6 { flex: 0 0 50%; }
.modal .col-8 { flex: 0 0 66.666667%; }
.modal .col-12 { flex: 0 0 100%; }

@media (max-width: 768px) {
    .modal .col-3,
    .modal .col-4,
    .modal .col-5,
    .modal .col-6,
    .modal .col-8 {
        flex: 0 0 100%;
    }
}

/* Responsive para la tabla */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 12px;
    }

    .table th,
    .table td {
        padding: 8px 4px;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 10px;
    }
}

/* Estados de carga y hover */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

.table tbody tr {
    transition: background-color 0.2s ease;
}

/* Iconos simulados con Unicode */
.icon-check::before { content: "✓"; margin-right: 5px; }
.icon-close::before { content: "×"; margin-right: 5px; }
.icon-filter::before { content: "⚙"; }

/* Animaciones */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.modal.show .modal-content {
    animation: fadeIn 0.2s ease-out;
}
</style>
@endsection

@section('content')
<div class="container py-4">

    <div class="row mb-3">
        <div class="col-6">
            <div class="summary-card success">
                Total de Ingresos: S/ 0
            </div>
        </div>
        <div class="col-6">
            <div class="summary-card danger">
                Total de Egresos: S/ 0
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label fw-bold">Saldo Actual:</label>
                        <input type="text" class="form-control" value="S/ 200.00" readonly>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Fecha Inicio:</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Fecha Fin:</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <button class="btn btn-primary" style="width: 100%;">Filtrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Caja cerrada --}}
    <div class="d-flex justify-content-end mb-3 gap-2" id="cajaAbierta">
        <button class="btn btn-danger">Abrir caja</button>
    </div>

    {{-- Caja abierta --}}
    <div class="d-flex justify-content-end mb-3 gap-2" id="cajaCerrada">
        <button class="btn btn-danger">Cerrar Caja</button>
        <button class="btn btn-success" onclick="openModal('modalTransaccion')">
            Agregar
        </button>
    </div>

    <div class="table-responsive">  
        <table class="table">
            <thead>
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
                @php
                    $colaboradores = [
                        ['dni' => '71342814', 'nombre' => 'Pedro Jesus Becerra Mucha', 'egresos' => 20],
                        ['dni' => '72803513', 'nombre' => 'Marlo Samaniego Calderon', 'egresos' => 30],
                        ['dni' => '75401580', 'nombre' => 'Jerremi Aron Chancan Labajos', 'egresos' => 30],
                        ['dni' => '76510989', 'nombre' => 'Oscar Jean Mario Arias Camasca', 'egresos' => 20],
                    ];
                @endphp
                @foreach ($colaboradores as $colaborador)
                    <tr>
                        <td>N/A</td>
                        <td><span class="badge bg-warning">Pendiente</span></td>
                        <td>{{ $colaborador['dni'] }}</td>
                        <td class="text-start">{{ $colaborador['nombre'] }}</td>
                        <td><span class="badge bg-info">Personal</span></td>
                        <td>0</td>
                        <td>{{ $colaborador['egresos'] }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="openModal('modalPagoColaborador')">
                                Pagar
                            </button>
                            <button class="btn btn-danger btn-sm">Anular</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para Registrar Transacción -->
<div class="modal" id="modalTransaccion">
    <div class="modal-dialog modal-dialog-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🧾 Nueva Transacción</h5>
                <button type="button" class="btn-close" onclick="closeModal('modalTransaccion')"></button>
            </div>
            <form method="POST" id="formTransaccion">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-muted small">Fecha</label>
                                <input type="date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="form-group">
                                <label class="form-label text-muted small">Nombre y DNI</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Nombres completos">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <span class="icon-filter"></span>
                                    </button>
                                    <input type="text" class="form-control form-control-lg" placeholder="DNI">
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-muted small">Tipo de Transacción</label>
                                <select class="form-control form-control-lg form-select">
                                    <option selected disabled>Seleccionar tipo</option>
                                    <option value="ingreso">Ingreso</option>
                                    <option value="egreso">Egreso</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-muted small">Monto</label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number" class="form-control form-control-lg" step="0.01" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-muted small">Descripción</label>
                                <input type="text" class="form-control form-control-lg" placeholder="Detalle o concepto">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label text-muted small">Observaciones</label>
                                <textarea class="form-control form-control-lg" rows="2" placeholder="Observaciones adicionales..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-lg btn-primary px-5">
                        <span class="icon-check"></span>Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Pago a Colaborador -->
<div class="modal" id="modalPagoColaborador">
    <div class="modal-dialog modal-dialog-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">💸 Pago a Colaborador</h5>
                <button type="button" class="btn-close" onclick="closeModal('modalPagoColaborador')"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label small text-muted">Fecha:</label>
                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                        </div>

                        <div class="col-5">
                            <div class="form-group">
                                <label class="form-label small text-muted">Nombres:</label>
                                <input type="text" class="form-control" value="Pedro Jesus Becerra Mucha" readonly>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label small text-muted">DNI:</label>
                                <input type="text" class="form-control" value="71342814" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Descripción:</label>
                                <input type="text" class="form-control" value="Pasaje" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Tipo:</label>
                                <input type="text" class="form-control" value="Colaborador" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Método de Pago:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (['Yape', 'Plin', 'Transferencia', 'Efectivo'] as $metodo)
                                        <button type="button" class="btn btn-outline-dark flex-fill">{{ $metodo }}</button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label small text-muted">Nro. Operación:</label>
                                <input type="text" class="form-control" placeholder="Opcional">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label small text-muted">Monto:</label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="text" class="form-control" value="20.00" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Comprobante:</label>
                                <input type="file" class="form-control">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Observaciones:</label>
                                <textarea class="form-control" rows="2" placeholder="Opcional"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" onclick="closeModal('modalPagoColaborador')">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <span class="icon-check"></span> Confirmar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Funciones para manejar modales
function openModal(modalId) {
    document.getElementById(modalId).classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        e.target.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
});

// Manejar selección de método de pago
document.addEventListener('DOMContentLoaded', function() {
    const paymentButtons = document.querySelectorAll('#modalPagoColaborador .btn-outline-dark');

    paymentButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remover selección anterior
            paymentButtons.forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-dark');
            });

            // Seleccionar el botón actual
            this.classList.remove('btn-outline-dark');
            this.classList.add('btn-primary');
        });
    });
});
</script>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
@endsection

@section('scripts')
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
