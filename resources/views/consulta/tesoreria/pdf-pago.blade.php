<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #1a1a1a;
            background: #fff;
        }

        .doc-wrapper {
            width: 750px;
            margin: 0 auto;
            padding: 50px 20px;
        }

        /* ── CABECERA CENTRADA ── */
        .header-center {
            text-align: center;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .header-center .titulo-nombre {
            font-size: 13px;
            font-weight: bold;
        }

        .header-center div {
            font-size: 10px;
        }

        /* ── NRO PAGO (alineado a la derecha) ── */
        .nro-pago-row {
            text-align: right;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 15px;
            margin-right: 20px;
        }

        /* ── DOS CAJAS: CLIENTE | CONDICIONES ── */
        .boxes-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 16px 0;
            margin-bottom: 30px;
        }

        .boxes-table td {
            border: 1px solid #1a1a1a;
            padding: 10px 12px;
            vertical-align: top;
            font-size: 10px;
            width: 50%;
            border-radius: 8px;
        }

        .boxes-table .field-label {
            font-weight: bold;
        }

        .field-row {
            margin-bottom: 4px;
        }

        /* ── TABLA DE ÍTEMS ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .items-table th {
            border-top: 0.5px solid #ccc;
            border-bottom: 1px solid #1a1a1a;
            padding: 5px 8px;
            font-size: 10px;
            font-weight: bold;
            text-align: left;
        }

        .items-table th.right,
        .items-table td.right {
            text-align: right;
        }

        .items-table td {
            padding: 5px 8px;
            font-size: 10px;
            border-bottom: 1px solid #ccc;
        }

        .items-table .col-sep {
            border-left: 1px solid #1a1a1a;
        }

        .items-table thead th + th {
            border-left: 1px solid #1a1a1a;
        }

        /* ── COMPROBANTE ── */
        .comprobante-box {
            border: 1px solid #1a1a1a;
            padding: 10px 12px;
            margin-bottom: 16px;
            border-radius: 10px;
        }

        .comprobante-box .obs-label {
            font-weight: bold;
            margin-bottom: 6px;
        }

        .comprobante-box img {
            max-width: 100%;
            max-height: 300px;
            display: block;
            margin-top: 6px;
        }

        /* ── CAJA OBSERVACIONES ── */
        .obs-box {
            border: 1px solid #1a1a1a;
            padding: 10px 12px;
            min-height: 5%;
            font-size: 10px;
            border-radius: 10px;
            margin-bottom: 24px;
        }

        .obs-box .obs-label {
            font-weight: bold;
            margin-bottom: 6px;
        }

        /* ── FOOTER ── */
        .pdf-footer {
            text-align: center;
            font-size: 9px;
            color: #555;
            border-top: 0.5px solid #ccc;
            padding-top: 10px;
            margin-top: 10px;
        }

        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .doc-wrapper { width: 100%; }
            @page { margin: 0.4in; size: A4; }
        }
    </style>
</head>
<body>
<div class="doc-wrapper">

    <!-- ══ CABECERA CENTRADA ══ -->
    <div class="header-center">
        <div class="titulo-nombre">{{ $titulo }}</div>
        <div>Sistema de Tesorería - Caja Chica</div>
    </div>

    <!-- ══ NRO PAGO ══ -->
    <div class="nro-pago-row">
        NRO. PAGO: {{ $transaccion->nro_pago }}
    </div>

    <!-- ══ CAJA CLIENTE | CAJA CONDICIONES ══ -->
    <table class="boxes-table">
        <tr>
            <td>
                <div class="field-row"><span class="field-label">Nombres:</span> {{ $nombres }}</div>
                <div class="field-row"><span class="field-label">DNI:</span> {{ $dni ?: 'No especificado' }}</div>
            </td>
            <td>
                <div class="field-row"><span class="field-label">Fecha:</span> {{ $fecha }}</div>
                <div class="field-row"><span class="field-label">Tipo de transacción:</span> {{ $tipo_transaccion }}</div>
                <div class="field-row"><span class="field-label">Método de pago:</span> {{ $metodo_pago ?: 'No especificado' }}</div>
                <div class="field-row"><span class="field-label">Nro. Operación:</span> {{ $nro_operacion ?: 'No aplica' }}</div>
            </td>
        </tr>
    </table>

    <!-- ══ TABLA DE ÍTEMS ══ -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:70%">Descripción</th>
                <th style="width:30%" class="col-sep right">Monto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $descripcion ?: 'Sin descripción' }}</td>
                <td class="col-sep right">S/ {{ number_format($monto, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- ══ COMPROBANTE (condicional) ══ -->
    @if($comprobante)
    <div class="comprobante-box">
        <div class="obs-label">Comprobante:</div>
        <img src="{{ public_path('storage/comprobantes/' . basename($comprobante)) }}" alt="Comprobante de pago">
    </div>
    @endif

    <!-- ══ CAJA OBSERVACIONES ══ -->
    <div class="obs-box">
        <div class="obs-label">Observaciones:</div>
        <div>{{ $observaciones ?: 'Sin observaciones' }}</div>
    </div>

    <!-- ══ FOOTER ══ -->
    <div class="pdf-footer">
        <p>Generado: {{ date('d/m/Y H:i:s') }} | Sistema de Tesorería - Caja Chica</p>
    </div>

</div>
</body>
</html>