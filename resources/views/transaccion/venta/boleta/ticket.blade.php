<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket Boleta</title>
</head>
<body>
    <div class="ticket">

        {{-- CABECERA --}}
        <div class="text-center">
            <strong>Boleta Electronica</strong><br>
            <span>{{ $boleta->codigo_bol }}</span>
        </div>

        <div class="linea-punteada"></div>

        <div class="text-center">
            <strong>{{ $empresa->razon_social }}</strong><br>
            <span><strong>R.U.C:</strong> {{ $empresa->ruc }}</span><br>
            <span>{{ $empresa->calle }} - {{ $empresa->ciudad }}</span><br>
            <span>{{ $empresa->region_provincia }}</span><br>
            <span>Tel: {{ $empresa->telefono }}</span><br>
            <span>{{ $boleta->created_at }}</span>
        </div>

        <div class="linea-punteada"></div>

        {{-- CLIENTE --}}
        <table>
            <tr>
                <td class="label">Cliente</td>
                <td>:</td>
                <td>{{ $boleta->cliente->nombre }}</td>
            </tr>
            <tr>
                <td class="label">{{ $boleta->cliente->documento_identificacion }}</td>
                <td>:</td>
                <td>{{ $boleta->cliente->numero_documento }}</td>
            </tr>
        </table>

        <div class="linea-punteada"></div>

        {{-- PRODUCTOS --}}
        <table>
            <thead>
                <tr>
                    <th class="col-producto">Artículo</th>
                    <th class="col-cant">Cant</th>
                    <th class="col-precio">P.U</th>
                    <th class="col-total">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($boleta_registro as $item)
                <tr class="fila-producto">
                    <td>
                        @if(isset($item->producto_id))
                            {{ $item->producto->nombre }}
                        @else
                            {{ $item->servicio->nombre }}
                        @endif
                    </td>
                    <td class="text-center">{{ $item->cantidad }}</td>
                    <td class="text-right">{{ number_format($item->precio_unitario_comi, 2) }}</td>
                    <td class="text-right">{{ number_format($item->precio_unitario_comi * $item->cantidad, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="linea-simple"></div>

        {{-- TOTALES --}}
        <table class="tabla-totales">
            <tr>
                <td>Subtotal</td>
                <td class="text-right">
                    {{ $simbolo = $moneda->simbolo }}
                    {{ $subtotal = number_format($boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada, 2) }}
                </td>
            </tr>
            <tr>
                <td>Op. Gravada</td>
                <td class="text-right">{{ $simbolo }} {{ number_format($boleta->op_gravada, 2) }}</td>
            </tr>
            <tr>
                <td>Op. Inafecta</td>
                <td class="text-right">{{ $simbolo }} {{ number_format($boleta->op_inafecta, 2) }}</td>
            </tr>
            <tr>
                <td>Op. Exonerada</td>
                <td class="text-right">{{ $simbolo }} {{ number_format($boleta->op_exonerada, 2) }}</td>
            </tr>
            <tr>
                <td>I.G.V</td>
                <td class="text-right">
                    {{ $simbolo }} {{ $igv = number_format(round($boleta->op_gravada * $igv->igv_total / 100, 2), 2) }}
                </td>
            </tr>
            <tr class="fila-total">
                <td><strong>TOTAL</strong></td>
                <td class="text-right">
                    <strong>{{ $simbolo }} {{ number_format(round($subtotal + $igv, 2), 2) }}</strong>
                </td>
            </tr>
        </table>

        <div class="linea-doble"></div>

        {{-- PIE --}}
        <div class="text-center small">
            <span>Atendido por {{ auth()->user()->nombre }}</span><br>
            <span>Autorizado mediante resolucion</span><br>
            <span>N° RS 018-005-0002243/SUNAT</span><br><br>
            <span>Representación impresa de la</span><br>
            <span>Boleta de Venta Electronica</span><br><br>
            <span>Para consultar el documento</span><br>
            <span>Ingrese a:</span><br>
            <span>{{ $empresa->pagina_web }}</span>
        </div>

    </div>
</body>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        margin: 0;
        padding: 0;
    }

    body {
        width: 60mm;
        font-family: 'Courier New', Courier, monospace;
        font-size: 10px;
        color: black;
    }

    @media print {
        @page {
            size: 60mm auto;  
            margin: 2mm;
        }
        body {
            width: 60mm;
        }
    }

    /* Contenedor */
    .ticket {
        width: 100%;
        padding: 2mm;
    }

    /* Texto */
    .text-center { text-align: center; }
    .text-right  { text-align: right; }
    .small       { font-size: 8px; }

    /* Separadores */
    .linea-simple   { border-top: 1px solid black}
    .linea-doble    { border-top: 3px double black}
    .linea-punteada { border-top: 1px dashed black}

    /* Tablas generales */
    table {
        width: 100%;
        border-collapse: collapse;
        border: none;
    }

    td, th {
        padding: 1px 0;
        font-size: 9px;
        vertical-align: top;
        border: none;
    }

    th {
        font-size: 9px;
        border-bottom: 1px solid black;
    }

    /* Columnas de productos */
    .col-producto { width: 40%; }
    .col-cant     { width: 10%; text-align: center; }
    .col-precio   { width: 25%; text-align: right; }
    .col-total    { width: 25%; text-align: right; }

    .fila-producto td { font-size: 9px; }

    /* Label cliente */
    .label { width: 35%; }

    /* Tabla totales */
    .tabla-totales td { font-size: 9px; }
    .fila-total td    { border-top: 1px solid black; font-size: 10px; }
</style>

<script>
    window.print();
</script>
</html>
