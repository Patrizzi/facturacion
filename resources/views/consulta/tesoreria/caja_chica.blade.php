@extends('layout')
@section('title', 'Tesorería')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/caja-chica/caja_chica.css') }}">
@endsection

@section('content')

@if(session('success') || session('error') || session('warning'))
    <div id="toast" class="toast
        {{ session('success') ? 'success' : '' }}
        {{ session('error') ? 'error' : '' }}
        {{ session('warning') ? 'warning' : '' }}">

        <span class="toast-icon">
            @if(session('success')) ✔️ @endif
            @if(session('error')) ❌ @endif
            @if(session('warning')) ⚠️ @endif
        </span>

        <p style="margin: 0; flex: 1;">
            {{ session('success') ?? session('error') ?? session('warning') }}
        </p>

        <button class="toast-close" onclick="document.getElementById('toast').classList.remove('show')">&times;</button>
    </div>
@endif



<div class="container py-4">

    {{-- 1. SUMMARY CARDS --}}
    <div class="row mb-3">
        <div class="col-6">
            <div class="summary-card success">
                Total de Ingresos: S/ <span id="totalIngresos">0.00</span>
            </div>
        </div>
        <div class="col-6">
            <div class="summary-card danger">
                Total de Egresos: S/ <span id="totalEgresos">0.00</span>
            </div>
        </div>
    </div>

    {{-- 2. FILTROS --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label fw-bold">Saldo Actual:</label>
                        <input type="text" class="form-control" value="{{ $saldoActual->saldo_actual ?? '0.00' }}" readonly>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Fecha Inicio:</label>
                        <input type="date" id="fechaInicio" class="form-control">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="form-label">Fecha Fin:</label>
                        <input type="date" id="fechaFin" class="form-control">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                      <button type="button" id="btnFiltrar" class="btn-filtar" style="width: 100%;">Filtrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. BOTONES ABRIR / CERRAR CAJA --}}
    @if(!$caja || ($caja && $caja->estado == 0))
    <div id="cajaCerrada" class="d-flex justify-content-end mb-3 gap-2">
        <form method="POST" action="{{ route('abrir.caja') }}" id="formAbrirCaja">
            @csrf
            <button type="submit" class="btn-abrirCaja">Abrir caja</button>
        </form>
    </div>
    @else
    <div id="cajaAbierta">
        <div id="botones-cajaAbierta" class="d-flex justify-content-end mb-3 gap-2">
            <form method="POST" action="{{ route('cerrar.caja') }}">
                @csrf
                <button type="submit" class="btn-cerrarCaja">Cerrar Caja</button>
            </form>

            {{-- 4. Botón Agregar + Menú Desplegable --}}
            <div class="dropdown-container">
                <button type="button" class="btn-agregar" onclick="toggleDropdown(event)">
                    Agregar
                </button>

                <div id="opcionesAgregar" class="dropdown-menu" style="display: none;">
                    <button type="button" class="dropdown-item" onclick="openModal('modalTransaccion', event)">
                        Recargar
                    </button>
                    <button type="button" class="dropdown-item" onclick="openModal('modalPagoColaborador', event)">
                        Pagar
                    </button>
                </div>
            </div>
        </div>

        {{-- 5. TABLA DE TRANSACCIONES --}}
        <div id="tablaTransacciones">
            <div class="table-responsive">
                <table class="table dataTables-example">
                    <thead>
                        <tr>
                            <th>NRO. PAGO</th>
                            <th>FECHA</th>
                            <th>DNI</th>
                            <th>NOMBRES</th>
                            <th>TIPO</th>
                            <th>MONTO</th>
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
                        @if(strtolower($transaccion->tipoTransaccion->nombre) == 'caja' || strtolower($transaccion->tipoTransaccion->nombre) == 'personal')
                            <button class="btn-ver" onclick="abrirModalVerPago(
                                '{{ $transaccion->fecha }}',
                                '{{ $transaccion->nombres }}',
                                '{{ $transaccion->dni }}',
                                '{{ $transaccion->descripcion }}',
                                '{{ $transaccion->transaccionDetalle->metodo_pago ?? '' }}',
                                '{{ $transaccion->tipoTransaccion->nombre }}',
                                '{{ $transaccion->transaccionDetalle->nro_operacion ?? '' }}',
                                '{{ $transaccion->monto }}',
                                '{{ $transaccion->transaccionDetalle->comprobante ?? '' }}',
                                '{{ $transaccion->observaciones }}'
                            )">Ver</button>
                            <button class="btn-pdf">PDF</button>
                        @else
                            {{-- Para depósitos, pasar los parámetros correctos --}}
                           <button class="btn-ver" onclick="abrirModalVerDeposito(
                                '{{ $transaccion->fecha }}',
                                '{{ $transaccion->nombres }}',
                                '{{ $transaccion->dni }}',
                                '{{ $transaccion->tipoTransaccion->nombre }}',
                                '{{ $transaccion->monto }}',
                                '{{ $transaccion->descripcion }}',
                                '{{ $transaccion->observaciones }}',
                                '{{ $transaccion->transaccionDetalle->metodo_pago ?? "" }}',
                                '{{ $transaccion->transaccionDetalle->nro_operacion ?? "" }}',
                                '{{ $transaccion->transaccionDetalle->comprobante ?? "" }}'
                            )">
                                Ver
                            </button>
                            <button class="btn-pdf">PDF</button>
                        @endif
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

<div class="modal" id="modalVerPagoColaborador">
    <div class="modal-dialog modal-dialog-lg">
        <div class="modal-content">

            {{-- 1. HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title">👁️ Ver Pago</h5>
                <button type="button" class="btn-close" onclick="closeModal('modalVerPagoColaborador')"></button>
            </div>

            {{-- 2. CONTENIDO DE SOLO LECTURA --}}
            <div class="modal-body-payment">
            <div class="form-row">
                {{-- Fecha --}}
                <div class="form-group" style="margin-right: 3px;">
                    <label class="form-label">Fecha:</label>
                    <input type="date" class="form-control form-control-readonly" id="ver_fecha" readonly>
                </div>

                {{-- Nombres --}}
                <div class="form-group" style="margin-right: 3px;">
                    <label class="form-label">Nombres:</label>
                    <input type="text" class="form-control form-control-readonly" id="ver_nombres" placeholder="Nombres" readonly>
                </div>

                {{-- DNI --}}
                <div class="form-group">
                    <label class="form-label">DNI:</label>
                    <input type="text" class="form-control form-control-readonly" id="ver_dni" placeholder="DNI" readonly>
                </div>
            </div>


                {{-- 2.2 Descripción --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Descripción:</label>
                        <input type="text" class="form-control form-control-readonly" id="ver_descripcion" readonly>
                    </div>
                </div>

                {{-- 2.3 Método de Pago + Tipo de Transacción --}}
                <div class="form-row">
                    {{-- Método de Pago --}}
                    <div class="form-group metodo-pago-group">
                        <label class="form-label">Método de Pago:</label>
                        <input type="text" class="form-control form-control-readonly" id="ver_metodo_pago" readonly>
                    </div>
                    {{-- Tipo de Transacción --}}
                    <div class="form-group">
                        <label class="form-label">Tipo de Transacción:</label>
                        <input type="text" class="form-control form-control-readonly" id="ver_tipo_transaccion" readonly>
                    </div>
                </div>

                {{-- 2.4 Nro. Operación y Monto --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nro. Operación:</label>
                        <input type="text" class="form-control form-control-readonly" id="ver_nro_operacion" readonly>
                    </div>

                    <div class="form-group monto-group">
                        <label class="form-label">Monto:</label>
                        <div class="input-group monto-input-group">
                            <span class="input-group-text">S/</span>
                            <input type="text" class="form-control form-control-readonly" id="ver_monto" readonly>
                        </div>
                    </div>
                </div>

                {{-- 2.5 Comprobante y Observaciones --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Comprobante:</label>
                        <div id="ver_comprobante_container">
                            <span id="ver_comprobante_texto" class="text-muted">Sin comprobante</span>
                            <a href="#" id="ver_comprobante_link" class="btn btn-sm btn-outline-primary" style="display: none;" target="_blank">
                                📎 Ver Comprobante
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Observaciones:</label>
                        <textarea class="form-control form-control-readonly" id="ver_observaciones" rows="2" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Ver Depósito (Solo Lectura) --}}
<div class="modal" id="modalVerDeposito">
    <div class="modal-dialog modal-dialog-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">👁️ Ver Depósito</h5>
                <button type="button" class="btn-close" onclick="closeModal('modalVerDeposito')"></button>
            </div>
            <div class="modal-body-payment">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label small text-muted">Fecha</label>
                            <input type="text" class="form-control form-control-lg" id="ver_deposito_fecha" readonly>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label class="form-label small text-muted">Nombre y DNI</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" id="ver_deposito_nombres" placeholder="Nombres" readonly>
                                <input type="text" class="form-control form-control-lg" id="ver_deposito_dni" placeholder="DNI" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label small text-muted">Tipo de Transacción</label>
                            <input type="text" class="form-control" id="ver_deposito_tipo" readonly>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label small text-muted">Monto</label>
                            <div class="input-group">
                                <span class="input-group-text">S/</span>
                                <input type="text" class="form-control form-control-lg" id="ver_deposito_monto" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label small text-muted">Descripción</label>
                            <input type="text" class="form-control form-control-lg" id="ver_deposito_descripcion" placeholder="Detalle o concepto" readonly>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label small text-muted">Método de Pago</label>
                            <input type="text" class="form-control form-control-lg" id="ver_deposito_metodo_pago" readonly>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label small text-muted">Nro. Operación</label>
                            <input type="text" class="form-control form-control-lg" id="ver_deposito_nro_operacion" readonly>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label small text-muted">Comprobante</label>
                            <div id="ver_deposito_comprobante_container">
                                <span class="text-muted" id="ver_deposito_no_comprobante">Sin comprobante</span>
                                <a href="#" id="ver_deposito_comprobante_link" class="btn btn-sm btn-outline-primary" target="_blank" style="display: none;">
                                    📎 Ver Comprobante
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label small text-muted">Observaciones</label>
                            <textarea class="form-control" id="ver_deposito_observaciones" rows="2" readonly></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 6. MODAL: Nueva Transacción --}}
<div class="modal" id="modalTransaccion">
    <div class="modal-dialog modal-dialog-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🧾 Depósito</h5>
                <button type="button" class="btn-close" onclick="closeModal('modalTransaccion')"></button>
            </div>
            <form method="POST" id="formTransaccion" enctype="multipart/form-data" class="modal-body-payment" action="{{ route('deposito.store') }}">
                @csrf
                <div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label small text-muted">Fecha</label>
                                <input type="date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label class="form-label small text-muted">Nombre y DNI</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" name="nombres" placeholder="Nombres" value="{{ old('nombres') }}" required>
                                    <input type="text" class="form-control form-control-lg" name="dni" placeholder="DNI" value="{{ old('dni') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Tipo de Transacción</label>
                                <input type="hidden" name="tipo_transaccion_id" value="{{ $deposito->id }}">
                                <input type="text" class="form-control" value="{{ $deposito->nombre }}" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label small text-muted">Monto</label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number" class="form-control form-control-lg @error('monto') is-invalid @enderror" step="0.01" placeholder="0.00" name="monto" value="{{ old('monto') }}" required>
                                </div>
                                @error('monto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label small text-muted">Descripción</label>
                                <input type="text" class="form-control form-control-lg" name="descripcion" placeholder="Detalle o concepto" value="{{ old('descripcion') }}">
                            </div>
                        </div>
                        {{-- Método de Pago --}}
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Método de Pago:</label>
                                <div class="btn-group-methods">
                                    @foreach (['Yape','Plin','Transferencia','Efectivo'] as $i => $metodo)
                                    <div class="method-wrapper">
                                        <input
                                            type="radio"
                                            class="btn-check"
                                            name="metodo_pago_trans"
                                            id="trans_{{ $metodo }}"
                                            value="{{ $metodo }}"
                                            @if($i===0) required @endif
                                        >
                                        <label class="btn-method metodo-{{ strtolower($metodo) }}" for="trans_{{ $metodo }}">
                                            {{ $metodo }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('metodo_pago')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        {{-- Hidden para enviar al controlador --}}
                        <input type="hidden" name="metodo_pago" id="hidden_metodo_pago_trans" />
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Nro. Operación:</label>
                                <input type="text" name="nro_operacion" class="form-control" value="{{ old('nro_operacion') }}">
                                @error('nro_operacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Comprobante:</label>
                                <input type="file" name="comprobante" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf">
                                @error('comprobante')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div id="observaciones-col" class="col-6">
                            <div class="form-group">
                                <label class="form-label">Observaciones:</label>
                                <textarea name="observaciones" class="form-control" rows="2" placeholder="Opcional">{{ old('observaciones') }}</textarea>
                                @error('observaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-payment">
                    <button type="submit" class="btn-confirm">
                        <span class="icon-check"></span>Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Pago --}}
<div class="modal" id="modalPagoColaborador">
    <div class="modal-dialog modal-dialog-lg">
        <div class="modal-content">
            {{-- 1. HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title">💸 Pago</h5>
                <button type="button" class="btn-close" onclick="closeModal('modalPagoColaborador')"></button>
            </div>

            {{-- 2. FORMULARIO --}}
            <form method="POST" enctype="multipart/form-data" action="{{ route('pago.store') }}" class="modal-body-payment">
                @csrf

                {{-- 2.1 Fecha (solo informativa) --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Fecha:</label>
                        <input type="date" class="form-control form-control-readonly" value="{{ date('Y-m-d') }}" readonly>
                    </div>

                    {{-- Nombres + filtro + DNI --}}
                    <div class="form-group nombres-group">
                        <label class="form-label">Nombres:</label>
                        <div class="input-with-icon">
                            <input type="text" name="nombres" class="form-control form-control-readonly @error('nombres') is-invalid @enderror" value="{{ old('nombres') }}" placeholder="Nombres" required>
                            <button type="button" class="btn-filter" onclick="abrirSelectorColaborador()">
                                <span class="icon-filter"></span>
                            </button>
                            <input type="text" name="dni" class="form-control form-control-readonly @error('dni') is-invalid @enderror" value="{{ old('dni') }}" placeholder="DNI" required>
                        </div>
                        @error('nombres')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('dni')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- 2.2 Descripción --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Descripción:</label>
                        <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion') }}" placeholder="Opcional">
                        @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                {{-- Método de Pago + Tipo de Transacción --}}
                <div class="form-row">
                    {{-- Método de Pago --}}
                <div class="form-group metodo-pago-group">
                    <label class="form-label">Método de Pago:</label>
                    <div class="btn-group-methods">
                    @foreach (['Yape','Plin','Transferencia','Efectivo'] as $i => $metodo)
                        <div class="method-wrapper">
                        <input
                            type="radio"
                            class="btn-check"
                            name="metodo_pago_pago"
                            id="pago_{{ $metodo }}"
                            value="{{ $metodo }}"
                            @if($i===0) required @endif
                        >
                        <label class="btn-method metodo-{{ strtolower($metodo) }}" for="pago_{{ $metodo }}">
                            {{ $metodo }}
                        </label>
                        </div>
                    @endforeach
                    </div>
                    @error('metodo_pago')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                    {{-- Hidden para enviar al controlador --}}
                    <input type="hidden" name="metodo_pago" id="hidden_metodo_pago_pago" />
                    {{-- Tipo de Transacción --}}
                    <div class="form-group">
                        <label class="form-label">Tipo de Transacción:</label>
                        <select name="tipo_transaccion_id" class="form-control @error('tipo_transaccion_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('tipo_transaccion_id') ? '' : 'selected' }}>
                                Seleccione tipo
                            </option>
                            @foreach($tipoTransacciones as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('tipo_transaccion_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                            @endforeach
                        </select>
                        @error('tipo_transaccion_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- 2.4 Nro. Operación y Monto --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nro. Operación:</label>
                        <input type="text" name="nro_operacion" class="form-control" value="{{ old('nro_operacion') }}">
                        @error('nro_operacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group monto-group">
                        <label class="form-label">Monto:</label>
                        <div class="input-group monto-input-group">
                            <span class="input-group-text">S/</span>
                            <input type="number" name="monto" class="form-control" step="0.01" value="{{ old('monto') }}" step="0.01" placeholder="0.00" required>
                        </div>
                        @error('monto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                {{-- Comprobante y Observaciones --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Comprobante:</label>
                        <input type="file" name="comprobante" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf">
                        @error('comprobante')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Observaciones:</label>
                        <textarea name="observaciones" class="form-control" rows="2" placeholder="Opcional">{{ old('observaciones') }}</textarea>
                        @error('observaciones')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- 3. FOOTER --}}
                <div class="modal-footer-payment">
                    <button type="button" class="btn-cancel" onclick="closeModal('modalPagoColaborador')">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-confirm">
                        <span class="icon-check"></span> Confirmar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Modal Buscador de Colaboradores --}}
<div class="modal" id="modalSelectColaborador">
    <div class="modal-dialog modal-dialog-md">
        <div class="modal-content">
            {{-- Header --}}
            <div class="modal-header">
                <h5 class="modal-title">🔍 Seleccionar Personal</h5>
                <button type="button" class="btn-close" onclick="closeModal('modalSelectColaborador')"></button>
            </div>

            {{-- Body: buscador + tabla --}}
            <div class="modal-body-payment">
                {{-- Input de búsqueda --}}
                <div class="form-group mb-3">
                    <input type="text" id="searchColaborador" class="form-control" placeholder="Buscar por nombre o DNI...">
                </div>

                {{-- Tabla de resultados --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Nombre completo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personales as $i => $personal)
                            <tr class="select-row" style="{{ $i >= 3 ? 'display: none;' : '' }}" onclick="seleccionarColaborador(
                      '{{ addslashes($personal->nombres) }}',
                      '{{ $personal->numero_documento }}'
                    )">
                                <td>{{ $personal->numero_documento }}</td>
                                <td class="text-start">{{ $personal->nombres }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts necesarios --}}
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
        /* -------------------------------------
        A. Mostrar/ocultar dropdown “Agregar”
    -------------------------------------- */
        function toggleDropdown(evt) {
            evt.stopPropagation();
            const menu = document.getElementById('opcionesAgregar');
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }

        // Si el clic es fuera de .dropdown-container, cerrar el dropdown
        document.addEventListener('click', function(e) {
            const container = document.querySelector('.dropdown-container');
            const menu = document.getElementById('opcionesAgregar');
            if (container && !container.contains(e.target)) {
                menu.style.display = 'none';
            }
        });

        /* -------------------------------------
        B. Abrir / cerrar modales
        -------------------------------------- */
        function openModal(modalId, evt) {
            if (evt) evt.stopPropagation();
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
            // Asegurarnos también de ocultar el dropdown
            document.getElementById('opcionesAgregar').style.display = 'none';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal si el clic es sobre el fondo (clase .modal)
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });

        /* -------------------------------------
        C. Mostrar/ocultar campos en Modal Pago
        -------------------------------------- */

        document.addEventListener('DOMContentLoaded', function() {
            // ——— Modal Transacción ———
            const radiosTrans = document.querySelectorAll('#modalTransaccion input[name="metodo_pago_trans"]');
            const hiddenTrans = document.getElementById('hidden_metodo_pago_trans');
            const nroOpDivTrans = document.querySelector('#modalTransaccion input[name="nro_operacion"]').closest('.form-group');
            const compDivTrans  = document.querySelector('#modalTransaccion input[name="comprobante"]').closest('.form-group');
            const obsTrans      = document.getElementById('observaciones-col');

            function updateTrans(value) {
                hiddenTrans.value = value;
                if (value === 'Efectivo') {
                nroOpDivTrans.style.display = 'none';
                compDivTrans.style.display  = 'none';
                obsTrans.classList.replace('col-6','col-12');
                } else {
                nroOpDivTrans.style.display = 'block';
                compDivTrans.style.display  = 'block';
                obsTrans.classList.replace('col-12','col-6');
                }
            }

            radiosTrans.forEach(r => r.addEventListener('change', () => updateTrans(r.value)));

            // Estado inicial
            const checkedT = document.querySelector('#modalTransaccion input[name="metodo_pago_trans"]:checked');
            if (checkedT) updateTrans(checkedT.value);


            // ——— Modal Pago Colaborador ———
            const radiosPago = document.querySelectorAll('#modalPagoColaborador input[name="metodo_pago_pago"]');
            const hiddenPago = document.getElementById('hidden_metodo_pago_pago');
            const nroOpDivPago = document.querySelector('#modalPagoColaborador input[name="nro_operacion"]').closest('.form-group');
            const compDivPago  = document.querySelector('#modalPagoColaborador input[name="comprobante"]').closest('.form-group');

            function updatePago(value) {
                hiddenPago.value = value;
                if (value === 'Efectivo') {
                nroOpDivPago.style.display = 'none';
                compDivPago.style.display  = 'none';
                } else {
                nroOpDivPago.style.display = 'block';
                compDivPago.style.display  = 'block';
                }
            }

            radiosPago.forEach(r => r.addEventListener('change', () => updatePago(r.value)));

            // Estado inicial
            const checkedP = document.querySelector('#modalPagoColaborador input[name="metodo_pago_pago"]:checked');
            if (checkedP) updatePago(checkedP.value);
        });

        /* -------------------------------------
        D. Inicializar DataTables si la caja está abierta
        -------------------------------------- */
        $(document).ready(function() {
            @if($caja && $caja -> estado == 1)
            $('.dataTables-example').DataTable({
                dom: '<"top"lf>rt<"bottom"ip><"clear">'
                , lengthMenu: [
                    [10, 25, 50, 100, -1]
                    , [10, 25, 50, 100, "Todo"]
                ]
                , pageLength: 10
                , language: {
                    lengthMenu: "Mostrar _MENU_ registros por página"
                    , search: "Buscar:"
                    , info: "Mostrando _START_ a _END_ de _TOTAL_ registros"
                    , infoFiltered: "(filtrado de _MAX_ registros totales)"
                    , paginate: {
                        previous: "Anterior"
                        , next: "Siguiente"
                    }
                    , emptyTable: "No hay datos disponibles en la tabla"
                    , infoEmpty: "Mostrando 0 a 0 de 0 registros"
                    , zeroRecords: "No se encontraron registros coincidentes"
                }
                , responsive: true
                , order: [
                    [0, 'desc']
                ]
                , columnDefs: [{
                    targets: -1
                    , orderable: false
                    , searchable: false
                }]
            });

            $('.dataTables_filter input').css('width', '300px');
            @endif
        });

    </script>

    <script>
        // Abre el modal buscador
        function abrirSelectorColaborador() {
            document.getElementById('modalSelectColaborador').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        // Cierra cualquier modal por id
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Filtrar la tabla en tiempo real
        document.getElementById('searchColaborador').addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            document
                .querySelectorAll('#modalSelectColaborador table tbody tr')
                .forEach(row => {
                    const dni = row.children[0].textContent.toLowerCase();
                    const name = row.children[1].textContent.toLowerCase();
                    row.style.display = (dni.includes(term) || name.includes(term)) ? '' : 'none';
                });
        });

        // Al hacer clic en una fila, cargar datos en el formulario de Pago y cerrar buscador
        function seleccionarColaborador(nombre, dni) {
            const pagoForm = document.getElementById('modalPagoColaborador');
            pagoForm.querySelector('input[name="nombres"]').value = nombre;
            pagoForm.querySelector('input[name="dni"]').value = dni;
            closeModal('modalSelectColaborador');
        }


        // Si haces clic fuera del modal, también cierra
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });

    </script>

    <script>
        const tableRows = Array.from(
            document.querySelectorAll('#modalSelectColaborador tbody tr.select-row')
        );

        document.getElementById('searchColaborador').addEventListener('keyup', function() {
            const term = this.value.trim().toLowerCase();

            tableRows.forEach((row, idx) => {
                const text = row.textContent.toLowerCase();

                if (term === '') {
                    // SIN BÚSQUEDA: sólo los primeros 3
                    row.style.display = (idx < 3 ? '' : 'none');
                } else {
                    // CON BÚSQUEDA: mostrar solo si coincide
                    row.style.display = (text.includes(term) ? '' : 'none');
                }
            });
        });

</script>

<script>
   function abrirModalVerDeposito(fecha, nombres, dni, tipoTransaccion, monto, descripcion, observaciones, metodoPago = '', nroOperacion = '', comprobante = '') {
    try {
        // Llenar los campos del modal de depósito
        document.getElementById('ver_deposito_fecha').value = fecha || '';
        document.getElementById('ver_deposito_nombres').value = nombres || '';
        document.getElementById('ver_deposito_dni').value = dni || '';
        document.getElementById('ver_deposito_tipo').value = tipoTransaccion || '';
        document.getElementById('ver_deposito_monto').value = monto || '';
        document.getElementById('ver_deposito_descripcion').value = descripcion || '';
        document.getElementById('ver_deposito_observaciones').value = observaciones || '';
        document.getElementById('ver_deposito_metodo_pago').value = metodoPago || '';
        document.getElementById('ver_deposito_nro_operacion').value = nroOperacion || '';

        // Manejo del comprobante para depósito
        const comprobanteLink = document.getElementById('ver_deposito_comprobante_link');
        const noComprobanteText = document.getElementById('ver_deposito_no_comprobante');

        if (comprobante && comprobante.trim() !== '') {
            comprobanteLink.href = `/storage/comprobantes/${comprobante}`;
            comprobanteLink.style.display = 'inline-block';
            noComprobanteText.style.display = 'none';
        } else {
            comprobanteLink.style.display = 'none';
            noComprobanteText.style.display = 'inline-block';
        }

        // Abrir el modal de depósito
        document.getElementById('modalVerDeposito').classList.add('show');

    } catch (error) {
        console.error('Error al abrir el modal de ver depósito:', error);
    }
}

// Función principal para abrir modal de ver pago
function abrirModalVerPago(fecha, nombres, dni, descripcion, metodoPago, tipoTransaccion, nroOperacion, monto, comprobante, observaciones) {
    try {
        // Llenar los campos del modal de pago
        document.getElementById('ver_fecha').value = fecha || '';
        document.getElementById('ver_nombres').value = nombres || '';
        document.getElementById('ver_dni').value = dni || '';
        document.getElementById('ver_descripcion').value = descripcion || '';
        document.getElementById('ver_metodo_pago').value = metodoPago || '';
        document.getElementById('ver_tipo_transaccion').value = tipoTransaccion || '';
        document.getElementById('ver_nro_operacion').value = nroOperacion || '';
        document.getElementById('ver_monto').value = monto || '';
        document.getElementById('ver_observaciones').value = observaciones || '';

        // Manejar el comprobante para pago
        const comprobanteTexto = document.getElementById('ver_comprobante_texto');
        const comprobanteLink = document.getElementById('ver_comprobante_link');

        if (comprobante && comprobante.trim() !== '') {
            comprobanteTexto.style.display = 'none';
            comprobanteLink.style.display = 'inline-block';
            comprobanteLink.href = `/storage/comprobantes/${comprobante}`;
        } else {
            comprobanteTexto.style.display = 'inline-block';
            comprobanteLink.style.display = 'none';
        }

        // Abrir el modal de pago
        document.getElementById('modalVerPagoColaborador').classList.add('show');

    } catch (error) {
        console.error('Error al abrir el modal de ver pago:', error);
    }
}

</script>

    <script type="application/json" id="datosIngresos">
        @json($ingresos)
    </script>
    <script type="application/json" id="datosEgresos">
        @json($egresos)
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener los datos de PHP
        const ingresosData = JSON.parse(document.getElementById('datosIngresos').textContent);
        const egresosData = JSON.parse(document.getElementById('datosEgresos').textContent);

        const btnFiltrar = document.getElementById('btnFiltrar');
        const fechaInicio = document.getElementById('fechaInicio');
        const fechaFin = document.getElementById('fechaFin');
        const totalIngresosSpan = document.getElementById('totalIngresos');
        const totalEgresosSpan = document.getElementById('totalEgresos');

        if (btnFiltrar && fechaInicio && fechaFin) {
            btnFiltrar.addEventListener('click', function() {
                const fechaInicioValue = fechaInicio.value;
                const fechaFinValue = fechaFin.value;

                // Validar que ambas fechas estén seleccionadas
                if (!fechaInicioValue || !fechaFinValue) {
                    alert('Por favor selecciona ambas fechas');
                    return;
                }

                // Validar que la fecha inicio no sea mayor que la fecha fin
                if (new Date(fechaInicioValue) > new Date(fechaFinValue)) {
                    alert('La fecha de inicio no puede ser mayor que la fecha fin');
                    return;
                }

                // Filtrar ingresos
                const ingresosFiltrados = ingresosData.filter(function(ingreso) {
                    const fechaIngreso = new Date(ingreso.fecha);
                    const fechaIni = new Date(fechaInicioValue);
                    const fechaFin = new Date(fechaFinValue);
                    return fechaIngreso >= fechaIni && fechaIngreso <= fechaFin;
                });

                // Filtrar egresos
                const egresosFiltrados = egresosData.filter(function(egreso) {
                    const fechaEgreso = new Date(egreso.fecha);
                    const fechaIni = new Date(fechaInicioValue);
                    const fechaFin = new Date(fechaFinValue);
                    return fechaEgreso >= fechaIni && fechaEgreso <= fechaFin;
                });

                // Calcular totales
                let totalIngresos = 0;
                let totalEgresos = 0;

                for (let i = 0; i < ingresosFiltrados.length; i++) {
                    totalIngresos += parseFloat(ingresosFiltrados[i].monto);
                }

                for (let i = 0; i < egresosFiltrados.length; i++) {
                    totalEgresos += parseFloat(egresosFiltrados[i].monto);
                }

                // Actualizar los valores en la página
                totalIngresosSpan.textContent = totalIngresos.toFixed(2);
                totalEgresosSpan.textContent = totalEgresos.toFixed(2);
            });
        }
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.classList.add('show');

            // Ocultar automáticamente a los 4 segundos
            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }
    });
</script>

@endsection
