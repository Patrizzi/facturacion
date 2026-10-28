@extends('layout')

@section('title', 'Series del Lote - Control de Lotes y Garantías')
@section('breadcrumb', 'Inventario')
@section('breadcrumb2', 'Series del Lote')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    @include('inventario.lotes_garantias.navbar_tabs')

    <div class="ibox">
        <div class="ibox-title d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="mb-2 mb-md-0">
                <i class="fa fa-barcode mr-2 text-primary"></i>
                Series del lote <strong>{{ $lote->lote }}</strong>
            </h5>
            <a href="{{ route('lotes-garantias.detalle-lote') }}?id_producto={{ $lote->producto_id }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left mr-1"></i> Volver a lotes
            </a>
        </div>
        <div class="ibox-content">
            <div class="row mb-3">
                <div class="col-md-4"><strong>Producto:</strong> {{ $lote->codigo_producto }}</div>
                <div class="col-md-4"><strong>Unidades del lote:</strong> {{ $lote->cantidad }}</div>
                <div class="col-md-4"><strong>Disponibles:</strong> {{ $lote->cantidad_disponible }}</div>
            </div>

            <div class="alert alert-info py-2 small">
                <i class="fa fa-info-circle mr-1"></i>
                Usa <strong>Editar</strong> junto a una serie para corregir su número. Presiona <strong>Enter</strong> para guardar y pasar a la siguiente serie editable. Solo se permiten cambios en series en stock que no estén vinculadas a ventas, comprobantes, garantías ni reclamos. Para agregar unidades nuevas, regístralas desde Kardex.
            </div>

            <div id="seriesFeedback" class="alert d-none" role="alert"></div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Número de serie</th>
                            <th>Estado</th>
                            <th>Ubicación</th>
                            <th>Calidad</th>
                            <th>Fecha de venta</th>
                            <th>Vencimiento de garantía</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodySeriesLote">
                        @forelse($series as $index => $serie)
                            @php
                                $garantia = $hayTablaGarantias ? $serie->garantiaActual : null;
                                $editable = $seriesEditables[$serie->id] ?? false;
                            @endphp
                            <tr data-serie-id="{{ $serie->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td class="numero-serie">{{ $serie->numero_serie }}</td>
                                <td>{{ $serie->estadoProducto->nombre_estado ?? 'En Stock' }}</td>
                                <td>{{ $serie->estadoProducto->ubicacion ?? 'Almacén Principal' }}</td>
                                <td>{{ $serie->estadoProducto->calidad ?? 'A' }}</td>
                                <td>{{ $garantia && $garantia->fecha_venta ? $garantia->fecha_venta->format('Y-m-d') : '--' }}</td>
                                <td>{{ $garantia && $garantia->fecha_vencimiento ? $garantia->fecha_vencimiento->format('Y-m-d') : '--' }}</td>
                                <td class="acciones-serie">
                                    @if($editable)
                                        <button type="button" class="btn btn-sm btn-primary btn-editar-serie">
                                            <i class="fa fa-pencil mr-1"></i> Editar
                                        </button>
                                    @else
                                        <span class="text-muted small">No editable</span>
                                    @endif
                                    <a class="btn btn-sm btn-outline-secondary"
                                       href="{{ route('lotes-garantias.busqueda-serie') }}?numero_serie={{ urlencode($serie->numero_serie) }}"
                                       target="_blank" rel="noopener">
                                        <i class="fa fa-search mr-1"></i> Trazar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">Este lote no tiene números de serie registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const updateUrl = @json(route('lotes-garantias.ajax.actualizar-numero-serie'));
    const traceUrl = @json(route('lotes-garantias.busqueda-serie'));
    const loteId = @json($lote->id);
    const csrfToken = @json(csrf_token());
    const feedback = document.getElementById('seriesFeedback');
    const tbody = document.getElementById('tbodySeriesLote');

    function showFeedback(message, isError) {
        feedback.textContent = message;
        feedback.className = 'alert ' + (isError ? 'alert-danger' : 'alert-success');
    }

    tbody.addEventListener('click', function (event) {
        const button = event.target.closest('.btn-editar-serie');
        if (button) iniciarEdicion(button);
    });

    function iniciarEdicion(button) {
        const row = button.closest('tr');
        const cell = row.querySelector('.numero-serie');
        const actions = row.querySelector('.acciones-serie');
        const oldNumber = cell.textContent.trim();
        const serieId = row.dataset.serieId;

        cell.innerHTML = '<input type="text" maxlength="50" class="form-control form-control-sm" aria-label="Número de serie">';
        const input = cell.querySelector('input');
        input.value = oldNumber;
        input.focus();
        input.select();

        actions.innerHTML = `
            <button type="button" class="btn btn-sm btn-success btn-guardar-serie mr-1">
                <i class="fa fa-check mr-1"></i> Guardar
            </button>
            <button type="button" class="btn btn-sm btn-secondary btn-cancelar-serie">Cancelar</button>`;

        actions.querySelector('.btn-cancelar-serie').addEventListener('click', function () {
            window.location.reload();
        });

        const saveButton = actions.querySelector('.btn-guardar-serie');
        saveButton.addEventListener('click', function () {
            guardarSerie(row, serieId, input, saveButton, false);
        });
        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                guardarSerie(row, serieId, input, saveButton, true);
            }
        });
    }

    async function guardarSerie(row, serieId, input, saveButton, avanzarAlSiguiente) {
        const newNumber = input.value.trim();
        if (!newNumber) {
            showFeedback('El número de serie es obligatorio.', true);
            input.focus();
            return;
        }

        let nextEditableId = null;
        if (avanzarAlSiguiente) {
            let nextRow = row.nextElementSibling;
            while (nextRow) {
                if (nextRow.querySelector('.btn-editar-serie')) {
                    nextEditableId = nextRow.dataset.serieId;
                    break;
                }
                nextRow = nextRow.nextElementSibling;
            }
        }

        saveButton.disabled = true;
        input.disabled = true;
        saveButton.innerHTML = '<i class="fa fa-spinner fa-spin mr-1"></i> Guardando';

        try {
            const response = await fetch(updateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    lote_id: loteId,
                    serie_id: serieId,
                    numero_serie: newNumber
                })
            });
            const result = await response.json();

            if (!response.ok || !result.success) {
                const validationError = result.errors && result.errors.numero_serie
                    ? result.errors.numero_serie[0]
                    : result.message;
                throw new Error(validationError || 'No se pudo actualizar la serie.');
            }

            row.querySelector('.numero-serie').textContent = newNumber;
            const updatedTraceUrl = new URL(traceUrl, window.location.origin);
            updatedTraceUrl.searchParams.set('numero_serie', newNumber);
            row.querySelector('.acciones-serie').innerHTML = `
                <button type="button" class="btn btn-sm btn-primary btn-editar-serie">
                    <i class="fa fa-pencil mr-1"></i> Editar
                </button>
                <a class="btn btn-sm btn-outline-secondary" href="${updatedTraceUrl.toString()}" target="_blank" rel="noopener">
                    <i class="fa fa-search mr-1"></i> Trazar
                </a>`;
            showFeedback('Número de serie actualizado.', false);

            if (nextEditableId !== null) {
                const nextRow = Array.from(tbody.querySelectorAll('tr[data-serie-id]'))
                    .find(candidate => candidate.dataset.serieId === nextEditableId);
                const nextEditButton = nextRow && nextRow.querySelector('.btn-editar-serie');
                if (nextEditButton) nextEditButton.click();
            }
        } catch (error) {
            saveButton.disabled = false;
            input.disabled = false;
            saveButton.innerHTML = '<i class="fa fa-check mr-1"></i> Guardar';
            showFeedback(error.message, true);
            input.focus();
        }
    }
});
</script>
@endsection
