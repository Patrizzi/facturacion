<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket Boleta</title>
</head>

<body>
    <div class="ticket">
        {{-- Secicon del header --}}
        <header>
            <div class="text-center">
                <strong>Boleta Electronica</strong><br>
                <span>{{ $boleta->codigo_bol }}</span>
            </div>
            <div class="linea-simple"></div>
            <div>
                <table>
                    <tr>
                        <td class="label">Cliente : {{ $boleta->cliente->nombre }}</td>
                    </tr>
                    <tr>
                        <td class="label">
                            {{ $boleta->cliente->documento_identificacion }} : {{ $boleta->cliente->numero_documento }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        </header>
        {{-- Secicon del footer --}}

        <footer>
            <div>
                <div class="col-sm-4 qr-container">
                    <div class="qr-box">
                        @if (!empty($qrCode))
                            <img src="{{ $qrCode }}" alt="Código QR" class="qr-image">
                        @else
                            <span class="qr-placeholder">QR</span>
                        @endif
                    </div>
                </div>
                <div>
                    <h1>Area de datos de la mepresa</h1>
                </div>
            </div>
        </footer>

</body>

<style>
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

    html,
    body {
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
            /* ancho fijo, alto automático */
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
    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .small {
        font-size: 8px;
    }

    /* Separadores */
    .linea-simple {
        border-top: 1px solid black
    }


    /* Tablas generales */
    table {
        width: 100%;
        border-collapse: collapse;
        border: none;
    }

    td,
    th {
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
    .col-producto {
        width: 40%;
    }

    .col-cant {
        width: 10%;
        text-align: center;
    }

    .col-precio {
        width: 25%;
        text-align: right;
    }

    .col-total {
        width: 25%;
        text-align: right;
    }

    .fila-producto td {
        font-size: 9px;
    }

    /* Label cliente */
    .label {
        width: 35%;
    }

    /* Tabla totales */
    .tabla-totales td {
        font-size: 9px;
    }

    .fila-total td {
        border-top: 1px solid black;
        font-size: 10px;
    }
</style>

<script>
    window.print();
</script>

</html>
