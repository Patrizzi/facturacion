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

        .header-center .empresa-nombre {
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
        .two-boxes {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            table-layout: fixed;
        }

        .box-left, .box-right {
            display: table-cell;
            border: 1px solid #1a1a1a;
            padding: 10px 12px;
            vertical-align: top;
        }

        .box-left {
            margin-right: 4%;
        }

        /* No hay display:table-cell margin, usamos wrapper */
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

        /* separadores verticales en cabecera */
        .items-table thead th + th {
            border-left: 1px solid #1a1a1a;
        }

        /* ── CAJA OBSERVACIONES ── */
        .obs-box {
            border: 1px solid #1a1a1a;
            padding: 10px 12px;
            min-height: 5%;
            font-size: 10px;
            border-radius: 10px;
        }

        .obs-box .obs-label {
            font-weight: bold;
            margin-bottom: 6px;
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
        <div class="empresa-nombre">{{ $empresa_nombre ?? 'J&P PERIFERICOS' }}</div>
        <div>Tel.: {{ $empresa_telefono ?? '013308292/ móvil -51946201443' }}</div>
        <div>{{ $empresa_email ?? 'julioflores@jypperifericos.com' }}</div>
        <div>{{ $empresa_direccion ?? 'Av. Bolivia 148 Of. 2218 Pta4 - Galeria Centro de Lima - Lima - Peru' }}</div>
    </div>

    <!-- ══ NRO PAGO ══ -->
    <div class="nro-pago-row">
        NRO PAGO: {{ str_pad($transaccion->nro_pago, 5, '0', STR_PAD_LEFT) }}
    </div>

    <!-- ══ CAJA CLIENTE | CAJA CONDICIONES ══ -->
    <table class="boxes-table">
        <tr>
            <td>
                <div class="field-row"><span class="field-label">Cliente:</span> {{ $nombres }}</div>
                <div class="field-row"><span class="field-label">DNI:</span> {{ $dni ?: 'No especificado' }}</div>
            </td>
            <td>
                <div class="field-row"><span class="field-label">Fecha emisión:</span> {{ $fecha }}</div>
                <div class="field-row"><span class="field-label">Tipo de transacción:</span> {{ $tipo_transaccion }}</div>
                <div class="field-row"><span class="field-label">Método de pago:</span> {{ $metodo_pago ?: 'No especificado' }}</div>
            </td>
        </tr>
    </table>

    <!-- ══ TABLA DE ÍTEMS ══ -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width:15%">Nro. Operación</th>
                <th style="width:55%" class="col-sep">Descripción</th>
                <th style="width:20%" class="col-sep right">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $nro_operacion ?: 'No aplica' }}</td>
                <td class="col-sep">{{ $descripcion ?: 'Sin descripción' }}</td>
                <td class="col-sep right">S/ {{ number_format($monto, 2) }}</td>
            </tr>
            
        </tbody>
    </table>

    <!-- ══ CAJA OBSERVACIONES ══ -->
    <div class="obs-box">
        <div class="obs-label">Observaciones:</div>
        <div>{{ $observaciones ?: '' }}</div>
    </div>

</div>
</body>
</html>