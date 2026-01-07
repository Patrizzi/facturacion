<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Boleta/PDF</title>
    <style type="text/css">
        * {
            color: black;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: white;
            padding: 20px;
        }

        .form-control,
        .single-line {
            background-color: #FFFFFF;
            background-image: none;
            border: 1px solid #e5e6e7;
            border-radius: 1px;
            color: inherit;
            display: block;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
        }

        @page {
            size: A4;
            margin: 15mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table {
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table th,
        .table td {
            padding: 8px;
            vertical-align: top;
        }

        .table thead th {
            border-bottom: 2px solid #3D3D3D;
        }

        .border-box {
            border: 1px solid #3D3D3D;
            border-radius: 8px;
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        h2, h3, h4 {
            margin: 5px 0;
        }

        footer {
            margin-top: 20px;
        }

        small {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <table style="margin-bottom: 20px;">
        <tr>
            {{-- Cabecera izquierda: Logo y datos empresa --}}
            <td style="width: 70%; padding-right: 10px;">
                {{-- Si tienes logo, usa: <img src="{{ public_path('images/logo.png') }}" width="150"> --}}
                <h3>{{ $empresa->razon_social ?? 'NOMBRE EMPRESA' }}</h3>
                <p>
                    <strong>Dirección:</strong> {{ $empresa->direccion ?? '' }}<br>
                    <strong>Teléfono:</strong> {{ $empresa->telefono ?? '' }}<br>
                    <strong>Email:</strong> {{ $empresa->email ?? '' }}
                </p>
            </td>

            {{-- Cabecera derecha: Datos boleta --}}
            <td style="width: 30%;" class="border-box text-center">
                <h3 style="margin-top: 0;">R.U.C {{ $empresa->ruc }}</h3>
                <h2 style="margin: 4px 0;">BOLETA ELECTRÓNICA</h2>
                <h4 style="margin-bottom: 0;">{{ $boleta->codigo_boleta }}</h4>
            </td>
        </tr>
    </table>

    {{-- Datos Generales y Condiciones --}}
    <table style="margin-bottom: 15px;">
        <tr>
            <td style="width: 48%;" class="border-box">
                <strong style="display: block; text-align: center; margin-bottom: 10px;">Datos Generales</strong>
                <strong>Señor(es):</strong>
                @if (isset($boleta->cliente_id))
                    {{ $boleta->cliente->nombre }}
                @else
                    {{ $boleta->cotizacion->cliente->nombre }}
                @endif
                <br>
                <strong>N° de Documento:</strong>
                @if (isset($boleta->cliente_id))
                    {{ $boleta->cliente->numero_documento }}
                @else
                    {{ $boleta->cotizacion->cliente->numero_documento }}
                @endif
                <br>
                <strong>Dirección:</strong>
                @if (isset($boleta->cliente_id))
                    {{ $boleta->cliente->direccion }}
                @else
                    {{ $boleta->cotizacion->cliente->direccion }}
                @endif
                <br>
                <strong>Condiciones de Pago:</strong>
                @if (isset($boleta->cliente_id))
                    {{ $boleta->forma_pago->nombre }}
                @else
                    {{ $boleta->cotizacion->forma_pago->nombre }}
                @endif
                <br>
                <strong>Tipo de Moneda:</strong>
                @if (isset($boleta->cliente_id))
                    {{ $boleta->moneda->nombre }}
                @else
                    {{ $boleta->cotizacion->moneda->nombre }}
                @endif
            </td>

            <td style="width: 4%;"></td>

            <td style="width: 48%;" class="border-box">
                <strong style="display: block; text-align: center; margin-bottom: 10px;">Condiciones Generales</strong>
                <strong>Orden de Compra:</strong> {{ $boleta->orden_compra }}<br>
                <strong>Guía de Remisión:</strong> {{ $boleta->guia_remision }}<br>
                <strong>Fecha de Emisión:</strong> {{ $boleta->fecha_emision }}<br>
                <strong>Fecha de Vencimiento:</strong> {{ $boleta->fecha_vencimiento }}
            </td>
        </tr>
    </table>

    {{-- Tabla de productos/servicios --}}
    <table class="table" style="margin-top: 15px;">
        <thead>
            <tr style="font-weight: bold;">
                <th style="width: 5%; text-align: center;">ITEM</th>
                <th style="width: 13%; text-align: center;">CÓDIGO</th>
                <th style="text-align: left;">DESCRIPCIÓN</th>
                <th style="width: 11%; text-align: center;">CANT.</th>
                <th style="width: 8%; text-align: right;">P. UNIT.</th>
                <th style="width: 8%; text-align: right;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($boleta_registro as $boleta_registros)
                <tr style="font-size: 11px;">
                    <td class="text-center">{{ $i++ }}</td>
                    @if (isset($boleta_registros->producto))
                        <td class="text-center">{{ $boleta_registros->producto->codigo_producto }}</td>
                        <td>
                            {{ $boleta_registros->producto->nombre }}
                            {{ $boleta_registros->descripcion_item }}
                            @if (isset($boleta_registros->numero_serie))
                                <br><strong>N/S:</strong> {{ $boleta_registros->numero_serie }}
                            @endif
                        </td>
                    @else
                        <td class="text-center">{{ $boleta_registros->servicio->codigo_servicio }}</td>
                        <td>
                            {{ $boleta_registros->servicio->nombre }}
                            {{ $boleta_registros->descripcion_item }}
                            @if (isset($boleta_registros->numero_serie))
                                <br><strong>N/S:</strong> {{ $boleta_registros->numero_serie }}
                            @endif
                        </td>
                    @endif
                    <td class="text-center">{{ $boleta_registros->cantidad }}</td>
                    <td class="text-right">{{ number_format($boleta_registros->precio_unitario_comi, 2) }}</td>
                    <td class="text-right">
                        {{ number_format($boleta_registros->precio_unitario_comi * $boleta_registros->cantidad, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Cálculos --}}
    @php
        $sub_total = $boleta->op_gravada;
        $sub_total_gravado = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada;
        $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100;
        $end = round($sub_total, 2) + round($igv_p, 2);

        use Luecano\NumeroALetras\NumeroALetras;
        $v = new NumeroALetras();
        $letra = $v->toInvoice($end, 2);
        $simbologia = $boleta->moneda->simbolo;
    @endphp

    {{-- Footer con totales --}}
    <footer>
        <table style="margin-top: 30px;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <h3>Son: {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $boleta->moneda->nombre }}</h3>
                    <br>
                    <small>Representación Impresa de <strong>BOLETA ELECTRÓNICA</strong></small><br>
                    <small>Esta puede ser consultada en www.codecta.pe</small><br>
                    <small>Autorizado mediante Resolución de Intendencia N° 0180050001374/SUNAT</small>
                </td>
                <td style="width: 40%;">
                    <table style="border: 1px solid #808080; border-radius: 8px;">
                        <tr>
                            <td style="padding: 5px;">Subtotal:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($sub_total, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">Op. Gravada:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($boleta->op_gravada, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">Op. Inafecta:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($boleta->op_inafecta, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">Op. Exonerada:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($boleta->op_exonerada, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">I.G.V.:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($igv_p, 2) }}</td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td style="padding: 5px;">Importe Total:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($end, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Observaciones --}}
        <table style="margin-top: 15px;">
            <tr>
                <td class="border-box">
                    <strong>Observaciones:</strong><br>
                    {{ $boleta->observacion }}
                </td>
            </tr>
        </table>

        {{-- Bancos - Si tienes datos de bancos, agrégalos aquí inline --}}
        @if($banco_count > 0)
        <table style="margin-top: 15px;" class="border-box">
            <tr>
                <td><strong>Datos Bancarios:</strong></td>
            </tr>
            @foreach($banco as $b)
            <tr>
                <td>
                    <strong>{{ $b->nombre_banco }}</strong> -
                    Cta. {{ $b->numero_cuenta }} -
                    CCI: {{ $b->cci }}
                </td>
            </tr>
            @endforeach
        </table>
        @endif
    </footer>
</body>
</html>