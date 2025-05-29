@extends('layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@section('content')
<div class="container py-4">

    <div class="row text-center mb-3">
        <div class="col-md-6">
            <div class="border border-success rounded p-2 text-success fw-bold">
                Total de Ingresos: S/ 0
            </div>
        </div>
        <div class="col-md-6">
            <div class="border border-danger rounded p-2 text-danger fw-bold">
                Total de Egresos: S/ 0
            </div>
        </div>
    </div>

    <div class="card shadow-sm rounded mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Saldo Actual:</label>
                    <input type="text" class="form-control bg-light" value="S/ 200.00" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Inicio:</label>
                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Fin:</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="d-flex justify-content-end mb-3 gap-2">
        <button class="btn btn-danger">Cerrar Caja</button>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTransaccion">
            Agregar
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="table-light">
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
                        <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                        <td>{{ $colaborador['dni'] }}</td>
                        <td class="text-start">{{ $colaborador['nombre'] }}</td>
                        <td><span class="badge bg-info text-dark">Colaborador</span></td>
                        <td>0</td>
                        <td>{{ $colaborador['egresos'] }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPagoColaborador">
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
<!-- Modal Rediseñado para Registrar Transacción -->
<div class="modal fade" id="modalTransaccion" tabindex="-1" aria-labelledby="modalTransaccionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-bottom-0 bg-white">
        <h5 class="modal-title text-dark fw-bold" id="modalTransaccionLabel">🧾 Nueva Transacción</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form method="POST" id="formTransaccion">
        @csrf
        <div class="modal-body px-4 py-3 bg-light">
          <div class="row g-4">

            <div class="col-md-4">
              <label class="form-label text-muted small">Fecha</label>
              <input type="date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}" readonly>
            </div>

            <div class="col-md-8">
              <label class="form-label text-muted small">Nombre y DNI</label>
              <div class="input-group">
                <input type="text" class="form-control form-control-lg" placeholder="Nombres completos">
                <button class="btn btn-outline-secondary" type="button">
                  <i class="bi bi-filter"></i>
                </button>
                <input type="text" class="form-control form-control-lg" placeholder="DNI">
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label text-muted small">Tipo de Transacción</label>
              <select class="form-select form-select-lg">
                <option selected disabled>Seleccionar tipo</option>
                <option value="ingreso">Ingreso</option>
                <option value="egreso">Egreso</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label text-muted small">Monto</label>
              <div class="input-group">
                <span class="input-group-text">S/</span>
                <input type="number" class="form-control form-control-lg" step="0.01" placeholder="0.00">
              </div>
            </div>

            <div class="col-md-12">
              <label class="form-label text-muted small">Descripción</label>
              <input type="text" class="form-control form-control-lg" placeholder="Detalle o concepto">
            </div>

            <div class="col-md-12">
              <label class="form-label text-muted small">Observaciones</label>
              <textarea class="form-control form-control-lg" rows="2" placeholder="Observaciones adicionales..."></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0 bg-white justify-content-center">
          <button type="submit" class="btn btn-lg btn-primary px-5">
            <i class="bi bi-check-circle me-2"></i>Registrar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Rediseñado para Pago a Colaborador -->
<div class="modal fade" id="modalPagoColaborador" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <div class="modal-header border-bottom-0 bg-white">
        <h5 class="modal-title text-dark fw-bold" id="modalPagoLabel">💸 Pago a Colaborador</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body px-4 py-3 bg-light">
          <div class="row g-4">

            <div class="col-md-3">
              <label class="form-label small text-muted">Fecha:</label>
              <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
            </div>

            <div class="col-md-5">
              <label class="form-label small text-muted">Nombres:</label>
              <input type="text" class="form-control" value="Pedro Jesus Becerra Mucha" readonly>
            </div>

            <div class="col-md-4">
              <label class="form-label small text-muted">DNI:</label>
              <input type="text" class="form-control" value="71342814" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label small text-muted">Descripción:</label>
              <input type="text" class="form-control" value="Pasaje" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label small text-muted">Tipo:</label>
              <input type="text" class="form-control" value="Colaborador" readonly>
            </div>

            <div class="col-md-6">
              <label class="form-label small text-muted">Método de Pago:</label>
              <div class="d-flex flex-wrap gap-2">
                @foreach (['Yape', 'Plin', 'Transferencia', 'Efectivo'] as $metodo)
                  <button type="button" class="btn btn-outline-dark flex-fill">{{ $metodo }}</button>
                @endforeach
              </div>
            </div>

            <div class="col-md-3">
              <label class="form-label small text-muted">Nro. Operación:</label>
              <input type="text" class="form-control" placeholder="Opcional">
            </div>

            <div class="col-md-3">
              <label class="form-label small text-muted">Monto:</label>
              <div class="input-group">
                <span class="input-group-text">S/</span>
                <input type="text" class="form-control" value="20.00" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label small text-muted">Comprobante:</label>
              <input type="file" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label small text-muted">Observaciones:</label>
              <textarea class="form-control" rows="2" placeholder="Opcional"></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-white border-top-0 justify-content-center">
          <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-check-circle me-1"></i> Confirmar Pago
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.bg-teal {
  background-color: #20c997;
}
.modal-content {
  border-radius: 16px;
}
.btn-outline-dark {
  border-radius: 8px;
}
input[readonly] {
  background-color: #f8f9fa;
}
</style>



<style>
.modal-content {
    border-radius: 16px;
}
.form-control-lg {
    border-radius: 10px;
}
.btn-primary {
    background-color: #0077b6;
    border-color: #0077b6;
}
.btn-primary:hover {
    background-color: #023e8a;
}
</style>


@endsection


