<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Factura Electrónica</title>
</head>
<body>

<div class="ticket">

    {{-- ─── HEADER ─── --}}
    <div class="header-box box-outline">
        <h1>Factura Electronica<br>F002-00003848</h1>
    </div>

    <hr>

    {{-- ─── CLIENTE ─── --}}
    <div class="info-section">
        <p><span class="bold">CLIENTE:</span> SOMA LIMA S.A.C</p>
        <p><span class="bold">RUC:</span> 202515005</p>
        <p><span class="bold">FECHA DE EMISION:</span> 14/09/2020 11:14:48</p>
        <p><span class="bold">FECHA DE FINALIZACION:</span> 14/09/2020</p>
    </div>

    <hr>

    {{-- ─── CONDICION / MONEDA ─── --}}
    <table class="tabla-condicion">
        <tbody>
            <tr>
                <td><span class="bold">Condicion:</span> efectivo</td>
                <td class="text-right"><span class="bold">Moneda:</span> soles</td>
            </tr>
        </tbody>
    </table>

    <hr>

    {{-- ─── DETALLE ─── --}}
    <div class="details-header box-outline">
        DETALLE DE COMPRA
    </div>

    <div class="details-body box-outline">
        <div class="item">
            <div class="item-title">IMPRESORA EPSON  TM-U220 TICKET</div>
            <div class="item-detail">
                8 UNI | <span class="bold">Precio:</span> S/20.00 | <span class="bold">Importe:</span> S/160.00
            </div>
        </div>
        <div class="item">
            <div class="item-title">COMPUTADOR SAMSUNG RTX5090 CORE i9</div>
            <div class="item-detail">
                8 UNI | <span class="bold">Precio:</span> S/20.00 | <span class="bold">Importe:</span> S/160.00
            </div>
        </div>
        <div class="item">
            <div class="item-title">COMPUTADOR SAMSUNG RTX5090 CORE i9</div>
            <div class="item-detail">
                8 UNI | <span class="bold">Precio:</span> S/20.00 | <span class="bold">Importe:</span> S/160.00
            </div>
        </div>
    </div>

    <hr>

    {{-- ─── TOTALES ─── --}}
    <table class="totals-section">
        <tbody>
            <tr>
                <td class="col-label">OP. GRAVADAS</td>
                <td class="col-valor">S/20.00</td>
            </tr>
            <tr>
                <td class="col-label">OP. GRATUITAS</td>
                <td class="col-valor">S/20.00</td>
            </tr>
            <tr>
                <td class="col-label">OP. EXONERADAS</td>
                <td class="col-valor">S/20.00</td>
            </tr>
            <tr>
                <td class="col-label">OP. INAFECTADAS</td>
                <td class="col-valor">S/20.00</td>
            </tr>
            <tr>
                <td class="col-label">I.G.V</td>
                <td class="col-valor">S/20.00</td>
            </tr>
            <tr>
                <td class="col-label">SUBTOTAL</td>
                <td class="col-valor">S/20.00</td>
            </tr>
            <tr class="total-venta">
                <td class="col-label"><strong>TOTAL VENTA</strong></td>
                <td class="col-valor"><strong>S/20.00</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- ─── MONTO EN LETRAS ─── --}}
    <div class="amount-words">DOS 40/100 PEN</div>

    <hr>

    {{-- ─── VENDEDOR ─── --}}
    <div class="vendedor">
        <p><span class="bold">VENDEDOR(A):</span> DYLAN</p>
    </div>

    <hr>

    {{-- ─── FOOTER ─── --}}
    <div class="footer-text">
        <p>Representacion impresa de la factura electronica.<br>Gracias por su preferencia.</p>
    </div>

    {{-- ─── QR ─── --}}
    <div class="qr-container">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Factura+F002-00003848" alt="QR">
    </div>

</div>

</body>
<script>
    window.print();
</script>
</html>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body    { width: 213px; }
.ticket { width: 213px; padding: 6px; }

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

.bold       { font-weight: 700; }
.text-right { text-align: right; }

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

.item:last-child { margin-bottom: 0; }

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

.col-label { width: 60%; text-align: left; }
.col-valor { width: 40%; text-align: right; }

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

/* ─── Vendedor ─── */
.vendedor p { font-size: 10px; }

/* ─── Footer ─── */
.footer-text {
    text-align: center;
    font-size: 9px;
    margin-top: 4px;
}

.footer-text p { font-size: 9px; }

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
    @page { size: 75mm auto; margin: 0; }
    body  { width: 213px; }
}
</style>
