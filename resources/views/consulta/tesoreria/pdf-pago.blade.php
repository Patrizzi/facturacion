<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <link rel="stylesheet" href="css/caja-chica/pdf-pago.css">
</head>
<body>
    <div class="pdf-container">
        <div class="pdf-nro-pago">
            NRO. PAGO: {{ $transaccion->nro_pago }}
        </div>

        <div class="pdf-header">
            <h1 class="pdf-title">{{ $titulo }}</h1>
            <p class="pdf-subtitle">Sistema de Tesorería - Caja Chica</p>
        </div>

        <div class="pdf-info-grid">
            <div class="pdf-info-item">
                <span class="pdf-label">Fecha:</span>
                <div class="pdf-value">{{ $fecha }}</div>
            </div>

            <div class="pdf-info-item">
                <span class="pdf-label">DNI:</span>
                <div class="pdf-value">{{ $dni ?: 'No especificado' }}</div>
            </div>

            <div class="pdf-info-item pdf-full-width">
                <span class="pdf-label">Nombres:</span>
                <div class="pdf-value">{{ $nombres }}</div>
            </div>

            <div class="pdf-info-item pdf-full-width">
                <span class="pdf-label">Descripción:</span>
                <div class="pdf-value">{{ $descripcion ?: 'Sin descripción' }}</div>
            </div>

            <div class="pdf-info-item">
                <span class="pdf-label">Método de Pago:</span>
                <div class="pdf-value">{{ $metodo_pago ?: 'No especificado' }}</div>
            </div>

            <div class="pdf-info-item">
                <span class="pdf-label">Tipo de Transacción:</span>
                <div class="pdf-value badge">{{ $tipo_transaccion }}</div>
            </div>

            <div class="pdf-info-item">
                <span class="pdf-label">Nro. Operación:</span>
                <div class="pdf-value">{{ $nro_operacion ?: 'No aplica' }}</div>
            </div>

            <div class="pdf-info-item">
                <span class="pdf-label">Monto:</span>
                <div class="pdf-value large">S/ {{ number_format($monto, 2) }}</div>
            </div>

            @if($comprobante)
            <div class="pdf-info-item pdf-full-width">
                <span class="pdf-label">Comprobante:</span>
                <div class="pdf-comprobante">
                    <img src="{{ public_path('storage/comprobantes/' . basename($comprobante)) }}" alt="Comprobante de pago">
                </div>
            </div>
            @endif

            <div class="pdf-info-item pdf-full-width">
                <span class="pdf-label">Observaciones:</span>
                <div class="pdf-value">{{ $observaciones ?: 'Sin observaciones' }}</div>
            </div>
        </div>

        <div class="pdf-footer">
            <p>Generado: {{ date('d/m/Y H:i:s') }} | Sistema de Tesorería - Caja Chica</p>
        </div>
    </div>
</body>
</html>
