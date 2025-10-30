<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura Manual/PDF</title>
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

        #watermark {
            position: absolute;
            color: rgba(120, 120, 120, 0.31);
            font-family: Arial, sans-serif;
            font-weight: bolder;
            font-size: 95px;
            transform: rotate(-45deg);
            top: 35%;
            left: 25%;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>

<body>
    {{-- Marca de agua si está anulada --}}
    @if($facturacion->f_electronica == 2 || $facturacion->nota_credito == 1)
        <div id="watermark">Anulado</div>
    @endif

    {{-- Cabecera --}}
    <table style="margin-bottom: 20px;">
        <tr>
            {{-- Cabecera izquierda: Logo y datos empresa --}}
            <td style="width: 70%; padding-right: 10px;">
                <h3>{{ $empresa->razon_social ?? 'NOMBRE EMPRESA' }}</h3>
                <p>
                    <strong>Dirección:</strong> {{ $empresa->direccion ?? '' }}<br>
                    <strong>Teléfono:</strong> {{ $empresa->telefono ?? '' }}<br>
                    <strong>Email:</strong> {{ $empresa->email ?? '' }}
                </p>
            </td>

            {{-- Cabecera derecha: Datos factura --}}
            <td style="width: 30%;" class="border-box text-center">
                <h3 style="margin-top: 0;">R.U.C {{ $empresa->ruc }}</h3>
                <h2 style="margin: 4px 0;">FACTURA MANUAL</h2>
                <h4 style="margin-bottom: 0;">{{ $facturacion->codigo_fac }}</h4>
            </td>
        </tr>
    </table>

    {{-- Datos Generales y Condiciones --}}
    <table style="margin-bottom: 15px;">
        <tr>
            <td style="width: 48%;" class="border-box">
                <strong>Señor(es):</strong>
                @if (isset($facturacion->cliente_id))
                    {{ $facturacion->cliente->nombre }}
                @else
                    {{ $facturacion->cotizacion->cliente->nombre }}
                @endif
                <br>
                <strong>R.U.C:</strong>
                @if (isset($facturacion->cliente_id))
                    {{ $facturacion->cliente->numero_documento }}
                @else
                    {{ $facturacion->cotizacion->cliente->numero_documento }}
                @endif
                <br>
                <strong>Dirección:</strong>
                @if (isset($facturacion->cliente_id))
                    {{ $facturacion->cliente->direccion }}
                @else
                    {{ $facturacion->cotizacion->cliente->direccion }}
                @endif
                <br>
                <strong>Condiciones de Pago:</strong>
                @if (isset($facturacion->cliente_id))
                    {{ $facturacion->forma_pago->nombre }}
                @else
                    {{ $facturacion->cotizacion->forma_pago->nombre }}
                @endif
                <br>
                <strong>Tipo de Moneda:</strong>
                @if (isset($facturacion->cliente_id))
                    {{ $facturacion->moneda->nombre }}
                @else
                    {{ $facturacion->cotizacion->moneda->nombre }}
                @endif
            </td>

            <td style="width: 4%;"></td>

            <td style="width: 48%;" class="border-box">
                <strong>Orden de Compra:</strong> {{ $facturacion->orden_compra }}<br>
                <strong>Guía de Remisión:</strong> {{ $facturacion->guia_remision }}<br>
                <strong>Fecha de Emisión:</strong> {{ $facturacion->fecha_emision }}<br>
                <strong>Fecha de Vencimiento:</strong> {{ $facturacion->fecha_vencimiento }}
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
            @foreach ($facturacion_registro as $facturacion_registros)
                <tr style="font-size: 11px;">
                    <td class="text-center">{{ $i++ }}</td>
                    @if (isset($facturacion_registros->producto))
                        <td class="text-center">{{ $facturacion_registros->producto->codigo_producto }}</td>
                        <td>
                            {{ $facturacion_registros->producto->nombre }}
                            {{ $facturacion_registros->descripcion_item }}
                            @if (isset($facturacion_registros->numero_serie))
                                <br><strong>N/S:</strong> {{ $facturacion_registros->numero_serie }}
                            @endif
                        </td>
                    @else
                        <td class="text-center">{{ $facturacion_registros->servicio->codigo_servicio }}</td>
                        <td>
                            {{ $facturacion_registros->servicio->nombre }}
                            {{ $facturacion_registros->descripcion_item }}
                        @endif
                        <td class="text-center">{{ $facturacion_registros->cantidad }}</td>
                        <td class="text-right">{{ number_format($facturacion_registros->precio, 2) }}</td>
                        <td class="text-right">
                            {{ number_format($facturacion_registros->precio * $facturacion_registros->cantidad, 2) }}
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Cálculos --}}
    @php
        $sub_total = $facturacion->op_gravada;
        $sub_total_gravado = $facturacion->op_gravada + $facturacion->op_inafecta + $facturacion->op_exonerada;
        $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100;
        $end = round($sub_total, 2) + round($igv_p, 2);

        use Luecano\NumeroALetras\NumeroALetras;
        $v = new NumeroALetras();
        $letra = $v->toInvoice($end, 2);
        $simbologia = $facturacion->moneda->simbolo;
    @endphp

    {{-- Footer con totales --}}
    <footer>
        <table style="margin-top: 30px;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <h3>Son: {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $facturacion->moneda->nombre }}</h3>
                    <br>
                    <small>Representación Impresa de <strong>FACTURA MANUAL</strong></small><br>
                    <small>Esta puede ser consultada en www.codecta.pe</small><br>
                    <small>Autorizado mediante Resolución de Intendencia N° 0180050001374/SUNAT</small>
                </td>
                <td style="width: 40%;">
                    <table style="border: 1px solid #808080; border-radius: 8px;">
                        <tr>
                            <td style="padding: 5px;">Sub Total:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($sub_total, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">Op. Gravada:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($facturacion->op_gravada, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">Op. Inafecta:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($facturacion->op_inafecta, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">Op. Exonerada:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($facturacion->op_exonerada, 2) }}</td>
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

        {{-- Observaciones y Detracciones --}}
        @if ($detraccion == "not")
            <table style="margin-top: 15px;">
                <tr>
                    <td class="border-box">
                        <strong>Observaciones:</strong><br>
                        {{ $facturacion->observacion }}
                    </td>
                </tr>
            </table>
        @else
            <table style="margin-top: 15px;">
                <tr>
                    <td style="width: 48%;" class="border-box">
                        <strong>Información de Detracción:</strong><br>
                        <strong>Tipo de Detracción:</strong> {{ $detraccion->tipo_detraccion->descripcion }} - {{ $detraccion->porcentaje_detraccion }}%<br>
                        <strong>Medio de Pago:</strong> {{ $detraccion->medio_pago->descripcion }}<br>
                        <strong>Monto de Detracción:</strong> S/. {{ number_format($detraccion->monto_detraccion, 2) }}
                    </td>

                    <td style="width: 4%;"></td>

                    <td style="width: 48%;" class="border-box">
                        <strong>Observaciones:</strong><br>
                        {{ $facturacion->observacion }}
                    </td>
                </tr>
            </table>
        @endif

        {{-- Cuotas de Crédito --}}
        @if ($cuotas != 'not')
            <table style="margin-top: 15px;">
                <tr>
                    <td colspan="3">
                        <strong><h3>Información de Crédito</h3></strong>
                    </td>
                </tr>
                <tr>
                    @foreach ($cuotas as $cuota)
                        <td style="width: 25%;" class="border-box">
                            <strong>Cuota:</strong> {{ $cuota->numero_cuota }}<br>
                            <strong>Monto:</strong>
                            @php
                                if ($facturacion->moneda->id == 1) {
                                    $monto_total_det = ($cuota->monto) - ($detraccion->monto_detraccion);
                                } else {
                                    $mont_porc = $end * ($detraccion->porcentaje_detraccion / 100);
                                    $monto_total_det = $end - $mont_porc;
                                }
                            @endphp
                            {{ $facturacion->moneda->simbolo }} {{ number_format($monto_total_det, 2) }}<br>
                            <strong>Fecha de Vencimiento:</strong> {{ Carbon\Carbon::parse($cuota->fecha_pago)->format('d-m-Y') }}
                        </td>
                    @endforeach
                </tr>
            </table>
        @endif

        {{-- Bancos --}}
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
