<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notas de Venta - Impresión Múltiple</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style type="text/css">
        * {
            color: black !important;
        }

        .form-control,
        .single-line {
            background-color: #FFFFFF;
            background-image: none;
            border: 1px solid #000000;
            border-radius: 10px;
            color: black;
            display: block;
            padding: 6px 12px;
            width: 100%;
            margin-bottom: 5px;
        }


        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table thead th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .ruc-box {
            border: 2px solid #000;
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            height: 125px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .bank-box {
            border: 2px solid #000;
            border-radius: 15px;
            padding: 10px;
            margin: 5px;
            height: 120px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .company-info {
            text-align: center;
            padding: 10px;
        }

        @media print {
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            margin: 0 !important;
            padding: 0 !important;
        }
        .avoid-break {
            page-break-inside: avoid;
        }
        }

        .section-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .footer-total {
            padding-top: 50px;
        }

        .footer-total h3, .footer-total p {
            margin: 5px 0;
        }
    </style>
</head>
<body class="white-bg">
    @php
        use Luecano\NumeroALetras\NumeroALetras;
        $igvPorcentaje = isset($igvModel) ? $igvModel->igv_total : 18;
    @endphp

    @foreach($notasData as $index => $notaData)
        @php
            $nota_venta = $notaData['nota_venta'];
            $nota_venta_reg = $notaData['nota_venta_reg'];
            $sub_total = $notaData['sub_total'];
            $total_igv = $notaData['total_igv'];
            $total_general = $notaData['total_general'];
            $sume = $total_general;
            $item = 1;

            $v = new NumeroALetras();
            $letra = $v->toInvoice($sume, 2);
        @endphp

        <div class="container-fluid" @if($index > 0) style="page-break-before: always;" @endif>
            <div class="row" style="margin-top: 10px;">
                <!-- Encabezado -->
                <div class="col-sm-8">
                    <div class="form-control" style="height: 125px;">
                        <div class="row">
                            <div class="col-sm-3" style="text-align: center;">
                                @if(isset($empresa->logo) && $empresa->logo)
                                    <img src="{{ asset('img/logo/' . $empresa->logo) }}" width="80px" height="80px" style="margin-top: 10px;">
                                @else
                                    <div style="width: 80px; height: 80px; border: 1px solid #ccc; margin: 10px auto; display: flex; align-items: center; justify-content: center;">
                                        LOGO
                                    </div>
                                @endif
                            </div>
                            <div class="col-sm-9 company-info">
                                <h3 style="margin-bottom: 5px; font-weight: bold;">{{ $empresa->nombre_comercial ?? 'NOMBRE EMPRESA' }}</h3>
                                <p style="margin-bottom: 2px; font-size: 11px; font-weight: bold;">{{ $empresa->razon_social ?? 'RAZON SOCIAL' }}</p>
                                <p style="margin-bottom: 2px; font-size: 11px;">Tel.: {{ $empresa->telefono ?? 'N/A' }} / Móvil: {{ $empresa->movil ?? 'N/A' }}</p>
                                <p style="margin-bottom: 2px; font-size: 11px;">{{ $empresa->correo ?? 'correo@empresa.com' }}</p>
                                <p style="margin-bottom: 0; font-size: 11px;">{{ $empresa->direccion ?? 'Dirección de la empresa' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="ruc-box">
                        <h3 style="margin-bottom: 10px; font-weight: bold;">R.U.C {{ $empresa->ruc ?? '00000000000' }}</h3>
                        <h2 style="margin-bottom: 10px; font-weight: bold;">NOTA DE VENTA</h2>
                        <h4>{{ $nota_venta->cod_nota_venta ?? 'NV 001-000000' }}</h4>
                    </div>
                </div>
            </div>

            <!-- Información del cliente -->
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-6">
                    <div class="section-box">
                        <h4 style="font-weight: bold; margin-bottom: 10px;">Contacto Cliente</h4>
                        <p style="margin: 2px 0;"><strong>Señor(es):</strong> {{ $nota_venta->cliente->nombre ?? 'CLIENTE' }}</p>
                        <p style="margin: 2px 0;"><strong>RUC:</strong> {{ $nota_venta->cliente->numero_documento ?? '00000000000' }}</p>
                        <p style="margin: 2px 0;"><strong>Dirección:</strong> {{ $nota_venta->cliente->direccion ?? 'Dirección del cliente' }}</p>
                        <p style="margin: 2px 0;"><strong>Fecha:</strong> {{ $nota_venta->fecha_emision ?? date('d-m-Y') }}</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="section-box">
                        <h4 style="font-weight: bold; margin-bottom: 10px;">Condiciones Generales</h4>
                        <p style="margin: 2px 0;"><strong>Garantía:</strong> {{ $nota_venta->garantia ?? 'A CONVENIR' }}</p>
                        <p style="margin: 2px 0;"><strong>Tipo de Moneda:</strong> {{ $nota_venta->moneda->nombre ?? 'soles' }}</p>
                        <p style="margin: 2px 0;"><strong>Condiciones de Pago:</strong> {{ $nota_venta->forma_pago ?? 'Contado' }}</p>
                        <p style="margin: 2px 0;"><strong>Vendedor:</strong> {{ $nota_venta->user->name ?? 'Administrador' }}</p>
                    </div>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="section-box">
                        <strong>Observaciones:</strong> {{ $nota_venta->observacion ?? 'Emitimos la siguiente Nota de Venta a vuestra solicitud' }}
                    </div>
                </div>
            </div>

            <!-- Tabla de productos -->
            <div class="row" style="margin-top: 10px;">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Unidad</th>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nota_venta_reg as $reg)
                                <tr>
                                    <td style="text-align: center;">{{ $item++ }}</td>
                                    <td style="text-align: center;">{{ $reg->unidad_medida }}</td>
                                    <td>{{ $reg->codigo_producto }}</td>
                                    <td>{{ $reg->descripcion_producto }}</td>
                                    <td style="text-align: center;">{{ number_format($reg->cantidad, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($reg->precio, 2) }}</td>
                                    <td style="text-align: right;">{{ number_format($reg->cantidad * $reg->precio, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer con totales -->
            <footer class="footer-total">
                <h3 align="left">
                    Son: {{ ucfirst(strtolower($letra)) }} {{ $nota_venta->moneda->nombre }}
                </h3>

                <div class="row">
                    <div class="col-lg-12" align="right">
                        <div style="width: 20%;">
                            <p class="form-control"><strong>Importe Total</strong></p>
                            <p class="form-control">{{ $nota_venta->moneda->simbolo }} {{ number_format($sume, 2) }}</p>
                        </div>
                    </div>
                </div>
            </footer>

            <!-- Información Bancaria -->
            @include('layout_bancos')

            <!-- Firma -->
            @include('layout_firma_pie_hoja')
        </div>
    @endforeach
    <script type="text/javascript">
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>
