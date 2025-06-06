@extends('layout')
@section('title', 'Ventas')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/caja-chica/caja_chica.css') }}">
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
                        <input type="text" class="form-control" value="{{ $saldoActual->saldo_actual ?? '0.00'  }}" readonly>
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
                        <button class="btn-filtar" style="width: 100%;">Filtrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$caja || ($caja && $caja->estado == 0))
        <div class="justify-content-end mb-3 gap-2" id="cajaCerrada">
            <form method="POST" action="{{ route('abrir.caja') }}" id="formAbrirCaja">
                @csrf
                <button
                    type="submit"
                    class="btn-abrirCaja"
                >
                    Abrir caja
                </button>
            </form>
        </div>
    @else
        {{-- Caja abierta (oculta al inicio) --}}
        <div id="cajaAbierta">
            <div class="justify-content-end mb-3 gap-2" id="botones-cajaAbierta">
                <form method="POST" action="{{ route('cerrar.caja') }}">
                    @csrf
                    <button type="submit" class="btn-cerrarCaja">Cerrar Caja</button>
                </form>

                <button class="btn-agregar" onclick="mostrarOpcionesAgregar()">
                    Agregar
                </button>
            </div>

            {{-- Fila de opciones que aparece al hacer click en Agregar --}}
            <div class="justify-content-end mb-3 gap-2" id="opcionesAgregar" style="display: none;">
                <button class="btn-agregar-personal" onclick="openModal('modalTransaccion')">
                    Recargar
                </button>
                <button class="btn-pagar-personal" onclick="openModal('modalPagoColaborador')">
                    Pagar
                </button>
            </div>

            {{-- Tabla que solo aparece cuando la caja está abierta --}}
            <div id="tablaTransacciones">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NRO. PAGO</th>
                                <th>FECHA</th>
                                <th>DNI</th>
                                <th>NOMBRES</th>
                                <th>TIPO</th>
                                <th>Monto</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($transacciones as $transaccion)
                                <tr>
                                    <td>{{ $transaccion->nro_pago }}</td>
                                    <td><span class="badge bg-warning">{{ $transaccion->fecha }}</span></td>
                                    <td>{{ $transaccion->dni ?? '-' }}</td>
                                    <td class="text-start">{{ $transaccion->nombres }}</td>
                                    <td><span class="badge bg-info">{{ $transaccion->tipoTransaccion->nombre }}</span></td>
                                    <td>S/ {{ $transaccion->monto }}</td>
                                    <td>
                                        <button class="btn-ver" onclick="">
                                            Ver
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal para Registrar Transacción -->
<div class="modal" id="modalTransaccion">
    <div class="modal-dialog modal-dialog-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🧾 Nueva Transacción</h5>
                <button type="button" class="btn-close" onclick="closeModal('modalTransaccion')"></button>
            </div>
            <form method="POST" id="formTransaccion" action="{{ route('deposito.store') }}">
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
                        <input type="text" class="form-control form-control-lg" name="nombres" placeholder="Nombres completos" value="{{ old('nombres') }}">
                        <button class="btn btn-outline-secondary" type="button">
                            <span class="icon-filter"></span>
                        </button>
                        <input type="text" class="form-control form-control-lg" name="dni" placeholder="DNI" value="{{ old('dni') }}">
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label class="form-label text-muted small">Tipo de Transacción</label>
                    <!-- Campo hidden para enviar el ID -->
                    <input type="hidden" name="tipo_transaccion_id" value="{{ $deposito->id }}">
                    <!-- Campo visible solo para mostrar el nombre -->
                    <input type="text" class="form-control" value="{{ $deposito->nombre }}" readonly>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label class="form-label text-muted small">Monto</label>
                    <div class="input-group">
                        <span class="input-group-text">S/</span>
                        <input type="number" class="form-control form-control-lg @error('monto') is-invalid @enderror"
                               step="0.01" placeholder="0.00" name="monto" value="{{ old('monto') }}" required>
                    </div>
                    @error('monto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label class="form-label text-muted small">Descripción</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Detalle o concepto"
                           name="descripcion" value="{{ old('descripcion') }}">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label class="form-label text-muted small">Observaciones</label>
                    <textarea class="form-control form-control-lg" rows="2" placeholder="Observaciones adicionales..."
                              name="observaciones">{{ old('observaciones') }}</textarea>
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

<!-- Modal para Pago -->
<div class="modal" id="modalPagoColaborador">
    <div class="modal-dialog modal-dialog-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">💸 Pago</h5>
                <button type="button" class="btn-close" onclick="closeModal('modalPagoColaborador')"></button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="{{ route('pago.store') }}">
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
                                <input type="text" class="form-control @error('nombres') is-invalid @enderror"
                                    name="nombres" value="{{ old('nombres') }}" required>
                                @error('nombres')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label small text-muted">DNI:</label>
                                <input type="text" class="form-control @error('dni') is-invalid @enderror"
                                    name="dni" value="{{ old('dni') }}" required>
                                @error('dni')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Descripción:</label>
                                <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                                    name="descripcion" value="{{ old('descripcion') }}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Tipo de Transacción:</label>
                                <select class="form-control form-control-lg form-select @error('tipo_transaccion_id') is-invalid @enderror"
                                        name="tipo_transaccion_id" required>
                                    <option value="" disabled selected>Seleccionar tipo de pago</option>
                                    @foreach ($tipoTransacciones as $tipoTransaccion)
                                        <option value="{{ $tipoTransaccion->id }}"
                                                {{ old('tipo_transaccion_id') == $tipoTransaccion->id ? 'selected' : '' }}>
                                            {{ $tipoTransaccion->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Método de Pago:</label>
                                <div class="row g-2">
                                    @foreach (['Yape', 'Plin', 'Transferencia', 'Efectivo'] as $metodo)
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="metodo_pago"
                                                value="{{ $metodo }}" id="metodo_{{ $metodo }}"
                                                {{ old('metodo_pago') == $metodo ? 'checked' : '' }}>
                                            <label class="btn btn-outline-dark w-100" for="metodo_{{ $metodo }}">
                                                {{ $metodo }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label small text-muted">Nro. Operación:</label>
                                <input type="text" class="form-control @error('nro_operacion') is-invalid @enderror"
                                    name="nro_operacion" value="{{ old('nro_operacion') }}">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label small text-muted">Monto:</label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number" step="0.01" class="form-control @error('monto') is-invalid @enderror"
                                        name="monto" value="{{ old('monto') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Comprobante:</label>
                                <input type="file" class="form-control @error('comprobante') is-invalid @enderror"
                                    name="comprobante" accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Observaciones:</label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror"
                                        rows="2" name="observaciones">{{ old('observaciones') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" onclick="closeModal('modalPagoColaborador')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <span class="icon-check"></span> Confirmar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

    <script>

    // Nueva función para mostrar las opciones de agregar
    function mostrarOpcionesAgregar() {
        const opcionesAgregar = document.getElementById('opcionesAgregar');

        // Alternar la visibilidad de las opciones
        if (opcionesAgregar.style.display === 'none' || opcionesAgregar.style.display === '') {
            opcionesAgregar.style.display = 'flex';
        } else {
            opcionesAgregar.style.display = 'none';
        }
    }

    // Funciones para manejar modales
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
        document.body.style.overflow = 'hidden';

        // Ocultar opciones de agregar cuando se abra un modal
        document.getElementById('opcionesAgregar').style.display = 'none';
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


    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metodoPagoInputs = document.querySelectorAll('input[name="metodo_pago"]');
            const nroOperacionDiv = document.querySelector('input[name="nro_operacion"]').closest('.form-group');
            const comprobanteDiv = document.querySelector('input[name="comprobante"]').closest('.form-group');

            metodoPagoInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value === 'Efectivo') {
                        nroOperacionDiv.style.display = 'none';
                        comprobanteDiv.style.display = 'none';
                        document.querySelector('input[name="nro_operacion"]').value = '';
                        document.querySelector('input[name="comprobante"]').value = '';
                    } else {
                        nroOperacionDiv.style.display = 'block';
                        comprobanteDiv.style.display = 'block';
                    }
                });
            });

            const checkedMethod = document.querySelector('input[name="metodo_pago"]:checked');
            if (checkedMethod && checkedMethod.value === 'Efectivo') {
                nroOperacionDiv.style.display = 'none';
                comprobanteDiv.style.display = 'none';
            }
        });
</script>
@endsection
