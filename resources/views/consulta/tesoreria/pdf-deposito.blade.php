<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <link rel="stylesheet" href="css/caja-chica/pdf-deposito.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            background-color: #f8f9fa;
            font-size: 12px;
        }

        .pdf-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .pdf-header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .pdf-title {
            color: #007bff;
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        .pdf-subtitle {
            color: #6c757d;
            font-size: 12px;
            margin-top: 3px;
        }

        .pdf-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .pdf-info-item {
            margin-bottom: 8px;
        }

        .pdf-label {
            font-weight: bold;
            color: #495057;
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 3px;
            display: block;
        }

        .pdf-value {
            font-size: 12px;
            color: #212529;
            padding: 5px 8px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            min-height: 16px;
        }

        .pdf-value.large {
            font-size: 16px;
            font-weight: bold;
            color: #dc3545;
        }

        .pdf-value.badge {
            background-color: #17a2b8;
            color: white;
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            border: none;
        }

        .pdf-full-width {
            grid-column: 1 / -1;
        }

        .pdf-comprobante {
            text-align: center;
            margin: 8px 0;
            padding: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
        }

        .pdf-comprobante img {
            width: 250px%;
            height: 250px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            margin-top: 5px;
        }

        .pdf-comprobante p {
            margin: 3px 0;
            font-size: 10px;
        }

        .pdf-footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
        }

        .pdf-nro-pago {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #ffc107;
            color: #212529;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 12px;
        }

        @media print {
            body {
                margin: 0;
                padding: 5px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .pdf-container {
                box-shadow: none;
                margin: 0;
                padding: 10px;
            }

            @page {
                margin: 0.5in;
                size: A4;
            }
        }
    </style>
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

            <div class="pdf-info-item">
                <span class="pdf-label">Tipo de Transacción:</span>
                <div class="pdf-value badge">{{ $tipo_transaccion }}</div>
            </div>

            <div class="pdf-info-item">
                <span class="pdf-label">Monto:</span>
                <div class="pdf-value large">S/ {{ number_format($monto, 2) }}</div>
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
                <span class="pdf-label">Nro. Operación:</span>
                <div class="pdf-value">{{ $nro_operacion ?: 'No aplica' }}</div>
            </div>

            @if($comprobante)
            <div class="pdf-info-item pdf-full-width">
                <span class="pdf-label">Comprobante:</span>
                <div class="pdf-comprobante">
                    <img src="{{ public_path('storage/comprobantes/' . basename($comprobante)) }}" alt="Comprobante de depósito">
                </div>
            </div>
            @endif

            <div class="pdf-info-item pdf-full-width">
                <span class="pdf-label">Observaciones:</span>
                <div class="pdf-value">{{ $observaciones ?: 'Sin observaciones' }}</div>
            </div>
        </div>

        <div class="pdf-footer">
            <p>Fecha de generación: {{ date('d/m/Y H:i:s') }}</p>
            <p>Sistema de Tesorería - Caja Chica</p>
        </div>
    </div>
</body>
</html>
