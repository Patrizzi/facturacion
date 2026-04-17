
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cotización/PDF</title>
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

            {{-- Cabecera derecha: Datos cotización --}}
            <td style="width: 30%;" class="border-box text-center">
                <h3 style="margin-top: 0;">R.U.C {{ $empresa->ruc }}</h3>
                <h2 style="margin: 4px 0;">COTIZACIÓN ELECTRÓNICA</h2>
                <h4 style="margin-bottom: 0;">{{ $cotizacion->cod_cotizacion }}</h4>
            </td>
        </tr>
    </table>

    {{-- Datos del Cliente y Condiciones --}}
    <table style="margin-bottom: 15px;">
        <tr>
            <td style="width: 48%;" class="border-box">
                <strong style="display: block; text-align: center; margin-bottom: 10px;">Contacto Cliente</strong>
                <strong>Nombre o Empresa:</strong> {{ $cotizacion->cliente->nombre }}<br>
                <strong>{{ $cotizacion->cliente->documento_identificacion }}:</strong> {{ $cotizacion->cliente->numero_documento }}<br>
                <strong>Dirección:</strong> {{ $cotizacion->cliente->direccion }}<br>
                <strong>N° Contacto:</strong> {{ $cotizacion->cliente->celular }}
                @if (isset($cotizacion->cliente->telefono))
                    / {{ $cotizacion->cliente->telefono }}
                @endif
                <br>
                <strong>Forma de Pago:</strong> {{ $cotizacion->forma_pago->nombre }}<br>
                <strong>Tipo de Moneda:</strong> {{ $cotizacion->moneda->nombre }}
            </td>

            <td style="width: 4%;"></td>

            <td style="width: 48%;" class="border-box">
                <strong style="display: block; text-align: center; margin-bottom: 10px;">Condiciones Generales</strong>
                <strong>Fecha:</strong> {{ $cotizacion->created_at }}<br>
                <strong>Validez:</strong> {{ $cotizacion->validez }}<br>
                <strong>Garantía:</strong> {{ $cotizacion->garantia }}
            </td>
        </tr>
    </table>

    {{-- Observaciones --}}
    @if($cotizacion->observacion)
    <table style="margin-bottom: 15px;">
        <tr>
            <td class="border-box">
                <strong>Observaciones:</strong> {{ $cotizacion->observacion }}
            </td>
        </tr>
    </table>
    @endif

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
            @foreach ($cotizacion_registro as $cotizacion_registros)
                <tr style="font-size: 11px;">
                    <td class="text-center">{{ $i++ }}</td>
                    @if (isset($cotizacion_registros->producto_id))
                        <td class="text-center">{{ $cotizacion_registros->producto->codigo_producto }}</td>
                        <td>
                            {{ $cotizacion_registros->producto->nombre }}
                            @if($cotizacion_registros->descripcion_item)
                                <br>{{ $cotizacion_registros->descripcion_item }}
                            @endif
                        </td>
                    @else
                        <td class="text-center">{{ $cotizacion_registros->servicio->codigo_servicio }}</td>
                        <td>
                            {{ $cotizacion_registros->servicio->nombre }}
                            @if($cotizacion_registros->descripcion_item)
                                <br>{{ $cotizacion_registros->descripcion_item }}
                            @endif
                        </td>
                    @endif
                    <td class="text-center">{{ $cotizacion_registros->cantidad }}</td>
                    <td class="text-right">{{ number_format($cotizacion_registros->precio_unitario_comi, 2) }}</td>
                    <td class="text-right">
                        {{ number_format($cotizacion_registros->precio_unitario_comi * $cotizacion_registros->cantidad, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Cálculos --}}
    @php
        use Luecano\NumeroALetras\NumeroALetras;
        $v = new NumeroALetras();
        $letra = $v->toInvoice($end, 2);
        $simbologia = $cotizacion->moneda->simbolo;
    @endphp

    {{-- Footer con totales --}}
    <footer>
        <table style="margin-top: 30px;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <h3>Son: {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $cotizacion->moneda->nombre }}</h3>
                    <br>
                    <small>Representación Impresa de <strong>COTIZACIÓN ELECTRÓNICA</strong></small><br>
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
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($cotizacion->op_gravada, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">Op. Inafecta:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($cotizacion->op_inafecta, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">Op. Exonerada:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($cotizacion->op_exonerada, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">I.G.V.:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format(round($igv_p, 2), 2) }}</td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td style="padding: 5px;">Importe Total:</td>
                            <td class="text-right" style="padding: 5px;">{{ $simbologia }} {{ number_format($end, 2) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

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

        {{-- Firma digital si existe --}}
        @if(isset($firma) && $firma)
        <table style="margin-top: 15px;">
            <tr>
                <td class="text-center">
                    <img src="{{ $firma }}" alt="Firma Digital" style="max-width: 200px; max-height: 100px;">
                </td>
            </tr>
        </table>
        @endif
    </footer>
</body>
</html>
