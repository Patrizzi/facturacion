<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura Electrónica</title>
    <style>
        .empresa-info {
            text-align: center;
            margin-bottom: 4px;
        }

        .empresa-info strong {
            display: block;
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .empresa-info span {
            display: block;
            font-size: 7px;
            line-height: 1.4;
        }

        .tabla-detalle {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin: 4px 0;
        }

        .tabla-detalle th,
        .tabla-detalle td {
            font-size: 7px;
            padding: 1px 2px;
            vertical-align: middle;
        }

        .tabla-detalle th {
            font-weight: bold;
            font-size: 7px;
        }

        .col-cant {
            width: 12%;
            text-align: center;
        }

        .col-desc {
            width: 46%;
            text-align: left;
            word-break: break-word;
        }

        .col-pu {
            width: 21%;
            text-align: right;
        }

        .col-imp {
            width: 21%;
            text-align: right;
        }

        .cabecera-include {
            width: 100%;
            text-align: center;
            margin-top: 4px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            width: 213px;
            font-size: 7px;
            margin: 0;
            padding: 0;
        }

        .ticket {
            width: 213px;
            padding: 6px;
            font-size: 7px;
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
            font-size: 7px;
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
            font-size: 7px;
        }

        .bold {
            font-weight: 700;
        }

        .text-right {
            text-align: right;
        }

        .info-section p {
            font-size: 7px;
            margin: 2px 0;
        }

        .tabla-condicion {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .tabla-condicion td {
            font-size: 7px;
            padding: 1px 0;
            width: 50%;
        }

        .details-header {
            text-align: center;
            padding: 4px;
            font-size: 7px;
            font-weight: bold;
            margin: 4px 0 3px 0;
            background-color: #f0f0f0;
        }

        .totals-section {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .totals-section td {
            padding: 2px 0;
            font-size: 7px;
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
            font-size: 7px;
        }

        .amount-words {
            text-align: center;
            font-size: 7px;
            margin: 5px 0;
            font-style: italic;
        }

        .footer-text {
            text-align: center;
            font-size: 7px;
            margin-top: 4px;
        }

        .footer-text small {
            display: block;
            font-size: 7px;
        }

        .qr-container {
            width: 100%;
            display: block;
            text-align: center;
            margin-top: 6px;
        }

        .qr-container img {
            width: 80px;
            height: 80px;
            border: 1px solid #111;
            padding: 2px;
            display: inline-block;
        }

        .qr-placeholder {
            font-size: 7px;
            color: #999;
        }

        @media print {
            @page {
                size: 75mm auto;
                margin: 0mm;
            }

            html, body {
                margin: 0 !important;
                padding: 0 !important;
                height: auto !important;
                overflow: visible !important;
            }

            .ticket {
                margin: 0 !important;
                padding: 2px !important;
            }
        }
    </style>
</head>
<body>

    <div class="ticket">
        {{-- ─── HEADER ─── --}}
        <header>
            <div class="header-box box-outline">
                <h1>Factura Electrónica<br>{{ $facturacion_m->codigo_fac }}</h1>
            </div>
            <hr>
            <div class="info-section">
                <div class="empresa-info">
                    <strong>{{ $empresa->razon_social }}</strong>
                    <span>Tel.: {{ $empresa->telefono }} | Móvil: {{ $empresa->movil }}</span>
                    <span>{{ $empresa->correo }}</span>
                    <span>{{ $empresa->calle }}, {{ $empresa->ciudad }}</span>
                    <span>{{ $empresa->region_provincia }} - {{ $empresa->pais }}</span>
                </div>
                <hr>
                @if (isset($facturacion_m->cliente))
                    <p><span class="bold">CLIENTE:</span> {{ $facturacion_m->cliente->nombre }}</p>
                    <p><span class="bold">{{ $facturacion_m->cliente->documento_identificacion }}:</span>
                        {{ $facturacion_m->cliente->numero_documento }}</p>
                @else
                    <p><span class="bold">CLIENTE:</span> {{ $facturacion_m->cotizador->cliente->nombre }}</p>
                @endif
                <p><span class="bold">FECHA EMISION:</span> {{ $facturacion_m->fecha_emision }}</p>
                <p><span class="bold">FECHA VENCIMIENTO:</span> {{ $facturacion_m->fecha_vencimiento }}</p>
            </div>
            <hr>
            <table class="tabla-condicion">
                <tr>
                    <td><span class="bold">Condición:</span> {{ $facturacion_m->forma_pago->nombre }}</td>
                    <td class="text-right"><span class="bold">Moneda:</span> {{ $facturacion_m->moneda->nombre }}</td>
                </tr>
            </table>
            <hr>
        </header>

        {{-- ─── DETALLE ─── --}}
        <main>
            <div class="details-header box-outline">DETALLE DE COMPRA</div>
            <hr>
            <table class="tabla-detalle">
                <thead>
                    <tr>
                        <th class="col-cant">CANT.</th>
                        <th class="col-desc">DESCRIPCIÓN</th>
                        <th class="col-pu">P/U</th>
                        <th class="col-imp">IMPORT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">
                            <hr style="margin:2px 0;">
                        </td>
                    </tr>
                    @foreach ($facturacion_m_registro as $item)
                        <tr>
                            <td class="col-cant">
                                {{ $item->cantidad }}
                            </td>
                            <td class="col-desc">
                                @if (isset($item->producto))
                                    {{ $item->producto->nombre }} {{ $item->descripcion_item ?? '' }}
                                    @if (isset($item->numero_serie))
                                        <br><strong>N/S:</strong> {{ $item->numero_serie }}
                                    @endif
                                    <br>({{ $item->producto->codigo_producto }})
                                @else
                                    {{ $item->servicio->nombre }} {{ $item->descripcion_item ?? '' }}
                                    @if (isset($item->numero_serie))
                                        <br><strong>N/S:</strong> {{ $item->numero_serie }}
                                    @endif
                                    <br>({{ $item->servicio->codigo_servicio }})
                                @endif
                            </td>
                            {{-- Nota: Ajustado a precio_unitario_comi según tu archivo original de factura --}}
                            <td class="col-pu">{{ number_format((float) $item->precio, 2) }}</td>
                            <td class="col-imp">{{ number_format((float) $item->precio * (float) $item->cantidad, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4">
                            <hr style="margin:2px 0;">
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>

        {{-- ─── FOOTER ─── --}}
        <footer>
            @php
                $sub_total = (float) $facturacion_m->op_gravada + (float) $facturacion_m->op_inafecta + (float) $facturacion_m->op_exonerada;
                $igv_p = (round((float) $facturacion_m->op_gravada, 2) * (float) $igv->igv_total) / 100;
                $TotalVent_num = round($sub_total, 2) + round($igv_p, 2);
                $TotalVent = number_format($TotalVent_num, 2);
            @endphp
            <table class="totals-section">
                <tr>
                    <td class="col-label">SUBTOTAL</td>
                    <td class="col-valor">{{ number_format($sub_total, 2) }}</td>
                </tr>
                <tr>
                    <td class="col-label">OP. GRAVADAS</td>
                    <td class="col-valor">{{ number_format((float) $facturacion_m->op_gravada, 2) }}</td>
                </tr>
                <tr>
                    <td class="col-label">OP. GRATUITAS</td>
                    <td class="col-valor">{{ number_format((float) $facturacion_m->op_gratuita, 2) }}</td>
                </tr>
                <tr>
                    <td class="col-label">OP. EXONERADAS</td>
                    <td class="col-valor">{{ number_format((float) $facturacion_m->op_exonerada, 2) }}</td>
                </tr>
                <tr>
                    <td class="col-label">OP. INAFECTADAS</td>
                    <td class="col-valor">{{ number_format((float) $facturacion_m->op_inafecta, 2) }}</td>
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
                    $v = new \Luecano\NumeroALetras\NumeroALetras();
                    $letra = $v->toInvoice($TotalVent_num, 2);
                @endphp
                {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $facturacion_m->moneda->nombre }}
            </div>
            <hr>
            <div class="qr-container">
                @if (!empty($qrCode))
                    <img src="{{ $qrCode }}" alt="Código QR" class="qr-image">
                @else
                    <span class="qr-placeholder">QR</span>
                @endif
            </div>
            <div class="footer-text">
                <small>Representación Impresa de <strong>FACTURA ELECTRÓNICA</strong></small>
                <small>Esta puede ser consultada en www.codecta.pe</small>
                <small>Autorizado mediante Resolución de Intendencia N° 0180050001374/SUNAT</small>
            </div>
            <hr>
            <div class="footer-text">
                <h3>¡Gracias por su compra!</h3>
            </div>
        </footer>
    </div>

    {{-- Script de impresión con retraso para asegurar carga de estilos/QR --}}
    <script type="text/javascript">
        window.addEventListener('load', function() {
            window.print();
        });
    </script>

</body>
</html>
