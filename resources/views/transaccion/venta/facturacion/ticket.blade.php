<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Factura Electrónica</title>

</head>
<body>






<div class="ticket">

    {{-- ─── HEADER ─── --}}
    <header>
        <div class="header-box box-outline">
            <h1>Factura Electronica<br>{{ $facturacion->codigo_fac }}</h1>

        </div>
        <hr>

            {{-- Datos del cliente solo en la primera página --}}
            <div class="info-section">
                @if(isset($facturacion->cliente))
                    <p><span class="bold">CLIENTE:</span> {{ $facturacion->cliente->nombre }}</p>
                    <p><span class="bold">{{ $facturacion->cliente->documento_identificacion }}:</span> {{ $facturacion->cliente->numero_documento }}</p>
                @else
                    <p><span class="bold">CLIENTE:</span> {{ $facturacion->cotizador->cliente->nombre}}</p>
                @endif
                <p><span class="bold">FECHA DE EMISION:</span> {{ $facturacion->fecha_emision }}</p>
                <p><span class="bold">FECHA DE FINALIZACION:</span> {{ $facturacion->fecha_vencimiento }}</p>
            </div>
            <hr>
            <table class="tabla-condicion">
                <tr>
                    <td><span class="bold">Condicion:</span> {{ $facturacion->forma_pago->nombre }}</td>
                    <td class="text-right"><span class="bold">Moneda:</span> {{ $facturacion->moneda->nombre }}</td>
                </tr>
            </table>
            <hr>

    </header>

    {{-- ─── DETALLE ─── --}}
    <main>
        <div class="details-header box-outline">DETALLE DE COMPRA</div>
        <div class="details-body box-outline">
            @foreach($facturacion_registro as $registro)
            <div class="item">
                <div class="item-title">
                    @if(isset($registro->producto))
                        {{ $registro->producto->nombre }} {{ $registro->descripcion_item }}
                        @if(isset($registro->numero_serie))
                            <br><strong>N/S:</strong> {{ $registro->numero_serie }}
                        @endif
                    @else
                        {{ $registro->servicio->nombre }} {{ $registro->descripcion_item }}
                        @if(isset($registro->numero_serie))
                            <br><strong>N/S:</strong> {{ $registro->numero_serie }}
                        @endif
                    @endif
                </div>
                <div class="item-detail">
                    {{ $registro->cantidad }} UNI |
                    <span class="bold">Precio:</span> S/{{ number_format((float)$registro->precio_unitario_comi, 2) }} |
                    <span class="bold">Importe:</span> S/{{ number_format((float)$registro->precio_unitario_comi * (float)$registro->cantidad, 2) }}
                </div>
            </div>
            @endforeach
        </div>
    </main>

    {{-- ─── FOOTER (se repite en cada página) ─── --}}
    <footer>
        <hr>
        <table class="totals-section">
            @php
                // Valores numéricos puros (float) para operar
                $sub_total     = (float)$facturacion->op_gravada + (float)$facturacion->op_inafecta + (float)$facturacion->op_exonerada;
                $igv_p         = round((float)$facturacion->op_gravada, 2) * (float)$igv->igv_total / 100;
                $TotalVent_num = round($sub_total, 2) + round($igv_p, 2); // <- número puro para cálculos
                $TotalVent     = number_format($TotalVent_num, 2);         // <- string solo para mostrar
            @endphp
            <tr>
                <td class="col-label">SUBTOTAL</td>
                <td class="col-valor">{{ number_format($sub_total, 2) }}</td>
            </tr>
            <tr>
                <td class="col-label">OP. GRAVADAS</td>
                <td class="col-valor">{{ number_format((float)$facturacion->op_gravada, 2) }}</td>
            </tr>
            <tr>
                <td class="col-label">OP. GRATUITAS</td>
                <td class="col-valor">{{ number_format((float)$facturacion->op_gratuita, 2) }}</td>
            </tr>
            <tr>
                <td class="col-label">OP. EXONERADAS</td>
                <td class="col-valor">{{ number_format((float)$facturacion->op_exonerada, 2) }}</td>
            </tr>
            <tr>
                <td class="col-label">OP. INAFECTADAS</td>
                <td class="col-valor">{{ number_format((float)$facturacion->op_inafecta, 2) }}</td>
            </tr>
            <tr>
                <td class="col-label">I.G.V</td>
                <td class="col-valor">{{ number_format($igv_p, 2) }}</td>
            </tr>
            <tr class="total-venta">
                <td class="col-label"><strong>TOTAL VENTA</strong></td>
                <td class="col-valor"><strong>{{ $TotalVent }}</strong></td>
            </tr>
        </table>
        <hr>
        <div class="amount-words">
            @php
                $v     = new \Luecano\NumeroALetras\NumeroALetras();
                $letra = $v->toInvoice($TotalVent_num, 2);
            @endphp
            {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $facturacion->moneda->nombre }}
        </div>
        <hr>
        <div class="footer-text">
            <small>Representación Impresa de <strong>BOLETA ELECTRÓNICA</strong></small>
            <small>Esta puede ser consultada en www.codecta.pe</small>
            <small>Autorizado mediante Resolución de Intendencia N° 0180050001374/SUNAT</small>
        </div>
        <div class="qr-container">
            @if(!empty($qrCode))
                <img src="{{ $qrCode }}" alt="Código QR" class="qr-image">
            @else
                <span class="qr-placeholder">QR</span>
            @endif
        </div>
    </footer>

</div>

<script type="text/javascript">
window.print();
</script>
<style>
    .page-break {
        page-break-after: always;
        break-after: always;
        margin-bottom: 0;
    }

    header small {
        display: block;
        text-align: center;
        font-size: 9px;
        font-style: italic;
        margin-top: 2px;
    }

    header,
    footer,
    main {
        display: block;
        width: 100%;
    }
    footer{
         position: relative !important;
    }
    .qr-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .qr-box {
        width: 120px;
        height: 120px;
        border: 2px solid #3D3D3D;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        background: white;
    }

    .qr-image {
        max-width: 100%;
        max-height: 100%;
        display: block;
    }

    .qr-placeholder {
        font-size: 12px;
        color: #999;
        text-align: center;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        width: 213px;
    }

    .ticket {
        width: 213px;
        padding: 6px;
        height: auto !important;
        overflow: visible !important;
    }

    .box-outline {
        border: 1px solid #111;
    }

    .header-box {
        text-align: center;
        padding: 6px;
        margin-bottom: 5px;
    }

    .header-box h1 {
        font-size: 11px;
        font-weight: bold;
        line-height: 1.4;
        margin: 0;
    }

    hr {
        border: none;
        border-top: 1px solid #111;
        margin: 4px 0;
    }

    p {
        margin: 2px 0;
        font-size: 10px;
    }

    .bold {
        font-weight: 700;
    }

    .text-right {
        text-align: right;
    }

    .info-section p {
        font-size: 10px;
        margin: 2px 0;
    }

    /* ─── Condicion / Moneda ─── */
    .tabla-condicion {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .tabla-condicion td {
        font-size: 10px;
        padding: 1px 0;
        width: 50%;
    }

    /* ─── Detalle header ─── */
    .details-header {
        text-align: center;
        padding: 4px;
        font-size: 10px;
        font-weight: bold;
        margin: 4px 0 3px 0;
        background-color: #f0f0f0;
    }

    /* ─── Detalle body ─── */
    .details-body {
        padding: 5px 4px;
        margin-bottom: 4px;
    }

    .item {
        text-align: center;
        margin-bottom: 5px;
        font-size: 9px;
        page-break-inside: avoid;
    }

    .item:last-child {
        margin-bottom: 0;
    }

    .item-title {
        font-weight: 700;
        font-size: 10px;
        margin-bottom: 2px;
    }

    .item-detail {
        width: 100%;
        font-size: 9px;
        margin-top: 2px;
        text-align: center;
    }

    /* ─── Totales ─── */
    .totals-section {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .totals-section td {
        padding: 2px 0;
        font-size: 10px;
        overflow: hidden;
    }

    .col-label {
        width: 60%;
        text-align: left;
    }

    .col-valor {
        width: 40%;
        text-align: right;
    }

    .total-venta td {
        border-top: 1px solid #111;
        padding-top: 3px;
        font-size: 11px;
    }

    /* ─── Monto en letras ─── */
    .amount-words {
        text-align: center;
        font-size: 9px;
        margin: 5px 0;
        font-style: italic;
    }

    /* ─── Footer text ─── */
    .footer-text {
        text-align: center;
        font-size: 9px;
        margin-top: 4px;
    }

    .footer-text small {
        display: block;
        font-size: 70%;
    }

    /* ─── QR ─── */
    .qr-container {
        text-align: center;
        margin-top: 6px;
    }

    .qr-container img {
        width: 80px;
        height: 80px;
        border: 1px solid #111;
        padding: 2px;
    }

    @media print {
        @page {
            size: 75mm auto;
            margin: 0;
        }

        html, body {
            height: auto !important;
            overflow: hidden !important;
        }

        .ticket {
            page-break-inside: avoid;
        }
    }
</style>

</body>
</html>
</html>
