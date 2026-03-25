
<div class="ticket">

    {{-- ─── HEADER ─── --}}
    <header>
        <div class="header-box box-outline">
            <h1>Boleta Electronica<br>{{ $boleta->codigo_boleta }}</h1>
        </div>
        <hr>
        <div class="info-section">
            @if(isset($boleta->cliente_id))
                <p><span class="bold">CLIENTE:</span> {{ $boleta->cliente->nombre }}</p>
                <p><span class="bold">{{ $boleta->cliente->documento_identificacion }}:</span> {{ $boleta->cliente->numero_documento }}</p>
            @else
                <p><span class="bold">CLIENTE:</span> {{ $boleta->cotizacion->cliente->nombre }}</p>
            @endif
            <p><span class="bold">FECHA DE EMISION:</span> {{ $boleta->fecha_emision }}</p>
            <p><span class="bold">FECHA DE FINALIZACION:</span> {{ $boleta->fecha_vencimiento }}</p>
        </div>
        <hr>
        <table class="tabla-condicion">
            <tr>
                <td><span class="bold">Condicion:</span> {{ $boleta->forma_pago->nombre }}</td>
                <td class="text-right"><span class="bold">Moneda:</span> {{ $boleta->moneda->nombre }}</td>
            </tr>
        </table>
        <hr>
    </header>

    {{-- ─── DETALLE ─── --}}
    <main>
        <div class="details-header box-outline">DETALLE DE COMPRA</div>
        <div class="details-body box-outline">
            @foreach($boleta_registro as $item)
            <div class="item">
                <div class="item-title">
                    @if(isset($item->producto))
                        {{ $item->producto->codigo_producto }}
                        @php
                           $InicialesP = substr($item->producto->nombre,0,5);
                        @endphp
                        {{ $InicialesP}}
                        @if(isset($item->numero_serie))
                            <br><strong>N/S:</strong> {{ $item->numero_serie }}
                        @endif
                    @else
                        @php
                           $InicialesS = substr($item->servicio->nombre,0,5);
                        @endphp
                        {{ $item->servicio->codigo_servicio }} {{ $InicialesS }}
                        @if(isset($item->numero_serie))
                            <br><strong>N/S:</strong> {{ $item->numero_serie }}
                        @endif
                    @endif
                    <div class="item-detail">
                        {{ $item->cantidad }} UNI |
                        <span class="bold">Precio:</span> S/{{ number_format((float)$item->precio, 2) }} |
                        <span class="bold">Importe:</span> S/{{ number_format((float)$item->precio * (float)$item->cantidad, 2) }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    {{-- ─── FOOTER ─── --}}
    <footer>
        <hr>
        @php
            $sub_total     = (float)$boleta->op_gravada + (float)$boleta->op_inafecta + (float)$boleta->op_exonerada;
            $igv_p         = round((float)$boleta->op_gravada, 2) * (float)$igv->igv_total / 100;
            $TotalVent_num = round($sub_total, 2) + round($igv_p, 2);
            $TotalVent     = number_format($TotalVent_num, 2);
        @endphp
        <table class="totals-section">
            <tr>
                <td class="col-label">SUBTOTAL</td>
                <td class="col-valor">{{ number_format($sub_total, 2) }}</td>
            </tr>
            <tr>
                <td class="col-label">OP. GRAVADAS</td>
                <td class="col-valor">{{ number_format((float)$boleta->op_gravada, 2) }}</td>
            </tr>
            <tr>
                <td class="col-label">OP. GRATUITAS</td>
                <td class="col-valor">{{ number_format((float)$boleta->op_gratuita, 2) }}</td>
            </tr>
            <tr>
                <td class="col-label">OP. EXONERADAS</td>
                <td class="col-valor">{{ number_format((float)$boleta->op_exonerada, 2) }}</td>
            </tr>
            <tr>
                <td class="col-label">OP. INAFECTADAS</td>
                <td class="col-valor">{{ number_format((float)$boleta->op_inafecta, 2) }}</td>
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
            {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $boleta->moneda->nombre }}
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
        {{--  <div class="cabecera-include">
            @include('layout_cabecera_ventas')
        </div>  --}}
    </footer>

</div>

<style>
    .cabecera-include {
        width: 100%;
        text-align: center;
        margin-top: 4px;
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

    .bold { font-weight: 700; }
    .text-right { text-align: right; }

    .info-section p {
        font-size: 10px;
        margin: 2px 0;
    }

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

    .details-header {
        text-align: center;
        padding: 4px;
        font-size: 10px;
        font-weight: bold;
        margin: 4px 0 3px 0;
        background-color: #f0f0f0;
    }

    .details-body {
        padding: 5px 4px;
        margin-bottom: 4px;
    }

    .item {
        text-align: center;
        margin-bottom: 5px;
        font-size: 9px;
    }

    .item:last-child { margin-bottom: 0; }

    .item-title {
        font-weight: 700;
        font-size: 10px;
        margin-bottom: 2px;
    }

    .item-detail {
        font-size: 9px;
        margin-top: 2px;
        text-align: center;
    }

    .totals-section {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .totals-section td {
        padding: 2px 0;
        font-size: 10px;
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

    .amount-words {
        text-align: center;
        font-size: 9px;
        margin: 5px 0;
        font-style: italic;
    }

    .footer-text {
        text-align: center;
        font-size: 9px;
        margin-top: 4px;
    }

    .footer-text small {
        display: block;
        font-size: 70%;
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
        display: inline-block;  /* <-- clave para que text-align: center funcione */
    }

    .qr-placeholder {
        font-size: 12px;
        color: #999;
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
    }
</style>
