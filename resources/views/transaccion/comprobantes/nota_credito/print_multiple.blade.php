<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notas de Crédito - Impresión Múltiple</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 10px;
        }
        
        .form-control {
            background-color: #FFFFFF;
            background-image: none;
            border: 1px solid #808080;
            border-radius: 10px;
            color: inherit;
            display: block;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
            margin-bottom: 10px;
        }

        @page {
            size: 420mm 297mm landscape;
            margin: 0.5cm;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .form-control {
                border: 1px solid #000 !important;
            }
        }
        
        .dark-bold {
            color: #000000;
            font-weight: bold;
        }
        
        .dark-regular {
            color: #000000;
            font-weight: normal;
        }
        
        .table thead th {
            color: #000000;
            font-weight: bold;
            background-color: #f2f2f2 !important;
            border-bottom: 2px solid #000;
        }
        
        .header-container {
            display: flex;
            margin-bottom: 15px;
        }
        
        .company-info {
            flex: 3;
            padding: 10px;
        }
        
        .document-info {
            flex: 1;
            padding: 10px;
            text-align: center;
            border-left: 1px solid #ddd;
        }
        
        .info-section {
            margin-bottom: 15px;
        }
        
        .totals-box {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        
        .totals-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .watermark {
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 0;
        }
        
        .watermark p {
            position: absolute;
            color: rgba(120, 120, 120, 0.31);
            font-weight: bolder;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 95px;
            pointer-events: none;
            transform: rotate(-45deg);
            top: 45%;
            right: 40%;
            z-index: 100;
        }
    </style>

    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>

</head>

<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    @php
        use Luecano\NumeroALetras\NumeroALetras;
    @endphp

    @foreach($notasData as $index => $notaData)
        @php
            $nota_credito = $notaData['nota_credito'];
            $nota_credito_reg = $notaData['nota_credito_reg'];
            $document = $notaData['document'];
            $doc_reg = $notaData['doc_reg'];
            $estado = $notaData['estado'];
            $sub_total = $notaData['sub_total'];
            $sub_total_gravado = $notaData['sub_total_gravado'];
            $igv_p = $notaData['igv_p'];
            $end = $notaData['end'];
            $end2 = $notaData['end2'];
            $u = 1;
            
            if ($estado == 0) {
                $moneda = $nota_credito->nota_i_facturacion->moneda;
            } elseif($estado == 1) {
                $moneda = $nota_credito->nota_i_boleta->moneda;
            } elseif($estado == 3) {
                $moneda = $nota_credito->nota_i_boleta_manual->moneda;
            } else {
                $moneda = $nota_credito->nota_i_fac_manual->moneda;
            }
        @endphp

        <div class="row" @if($index > 0) style="page-break-before: always;" @endif>
            <div class="col-lg-12">
                <div class="ibox-content p-xl" style="margin-bottom: 20px; padding-bottom: 30px;">
                    
                    @if($nota_credito->n_electronica == 2)
                        <div class="watermark">
                            <p>Anulado</p>
                        </div>    
                    @endif
                    
                    <!-- Encabezado -->
                    <div class="form-control header-container">
                        <div class="company-info">
                            <div style="text-align: center;">
                                <h3 style="margin-bottom: 5px;" class="dark-bold">{{ $empresa->nombre_comercial }}</h3>
                                <p style="margin-bottom: 3px; font-size: 13px;" class="dark-regular">
                                    <span class="dark-bold">{{ $empresa->razon_social }}</span><br>
                                    {{ $empresa->direccion }}<br>
                                    Teléfono: {{ $empresa->telefono }}
                                </p>
                            </div>
                        </div>
                        <div class="document-info">
                            <div style="margin-bottom: 10px;" class="dark-bold">R.U.C: {{ $empresa->ruc }}</div>
                            <div style="font-size: 18px; font-weight: bold; margin-bottom: 5px;">NOTA DE CRÉDITO</div>
                            <div class="dark-regular">{{ $nota_credito->codigo_n_c }}</div>
                        </div>
                    </div>
                    
                    <!-- Información del cliente y documento -->
                    <div class="row info-section">
                        <div class="col-sm-6">
                            <div class="form-control">
                                <div class="dark-bold section-title">Cliente:</div>
                                @if ($estado == 0)
                                    <div class="info-row">
                                        <span class="dark-bold">Nombre: </span>
                                        <span class="dark-regular">
                                            @if (isset($nota_credito->nota_i_facturacion->cliente_id))
                                                {{ $nota_credito->nota_i_facturacion->cliente->nombre }}
                                            @else
                                                {{ $nota_credito->nota_i_facturacion->cotizacion->cliente->nombre }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-row">
                                        <span class="dark-bold">RUC: </span>
                                        <span class="dark-regular">
                                            @if (isset($nota_credito->nota_i_facturacion->cliente_id))
                                                {{ $nota_credito->nota_i_facturacion->cliente->numero_documento }}
                                            @else
                                                {{ $nota_credito->nota_i_facturacion->cotizacion->cliente->numero_documento }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-row">
                                        <span class="dark-bold">Dirección: </span>
                                        <span class="dark-regular">
                                            @if (isset($nota_credito->nota_i_facturacion->cliente_id))
                                                {{ $nota_credito->nota_i_facturacion->cliente->direccion }}
                                            @else
                                                {{ $nota_credito->nota_i_facturacion->cotizacion->cliente->direccion }}
                                            @endif
                                        </span>
                                    </div>
                                @elseif($estado == 1)
                                    <!-- Estructura similar para boletas -->
                                    <div class="info-row">
                                        <span class="dark-bold">Nombre: </span>
                                        <span class="dark-regular">
                                            @if (isset($nota_credito->nota_i_boleta->cliente_id))
                                                {{ $nota_credito->nota_i_boleta->cliente->nombre }}
                                            @else
                                                {{ $nota_credito->nota_i_boleta->cotizacion->cliente->nombre }}
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-row">
                                        <span class="dark-bold">RUC: </span>
                                        <span class="dark-regular">
                                            @if (isset($nota_credito->nota_i_boleta->cliente_id))
                                                {{ $nota_credito->nota_i_boleta->cliente->numero_documento }}
                                            @else
                                                {{ $nota_credito->nota_i_boleta->cotizacion->cliente->numero_documento }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-control">
                                <div class="dark-bold section-title">Documento:</div>
                                <div class="info-row">
                                    <span class="dark-bold">Número: </span>
                                    <span class="dark-regular">
                                        @if ($nota_credito->facturacion_id != null)
                                            {{ $nota_credito->nota_i_facturacion->codigo_fac }}
                                        @elseif($nota_credito->boleta_id != null)
                                            {{ $nota_credito->nota_i_boleta->codigo_boleta }}
                                        @elseif($nota_credito->boleta_m_id != null)
                                            {{ $nota_credito->nota_i_boleta_manual->codigo_boleta }}
                                        @else
                                            {{ $nota_credito->nota_i_fac_manual->codigo_fac }}
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="dark-bold">Fecha Emisión: </span>
                                    <span class="dark-regular">
                                        @if(isset($nota_credito->fecha_emision))
                                            {{ $nota_credito->fecha_emision }}
                                        @else
                                            {{ $nota_credito->created_at }}
                                        @endif
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="dark-bold">Tipo de operación: </span>
                                    <span class="dark-regular">
                                        @switch($nota_credito->motivo)
                                            @case(01)
                                            Anulación de la operación
                                            @break
                                            @case(02)
                                            Anulación por error en el RUC
                                            @break
                                            @case(03)
                                            Corrección por error en la descripción
                                            @break
                                            @case(06)
                                            Devolución total
                                            @break
                                            @default
                                            {{ $nota_credito->motivo }}
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabla de productos/servicios -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 8%">ITEM</th>
                                    <th style="width: 15%">Código</th>
                                    <th>Descripción</th>
                                    <th style="width: 11%">Cantidad</th>
                                    <th style="text-align: center;width: 8%">Pr. Unit</th>
                                    <th style="text-align: center;width: 8%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nota_credito_reg as $e => $nota_credito_registro)
                                <tr>
                                    <td class="dark-regular">{{ $u++ }}</td>
                                    @if (isset($nota_credito_registro->producto_id))
                                        <td class="dark-regular">{{ $nota_credito_registro->producto->codigo_producto }}</td>
                                        <td class="dark-regular">
                                            {{ $nota_credito_registro->producto->descripcion }}
                                            @if(isset($doc_reg[$e])) {{ $doc_reg[$e]->descripcion_item }} @endif
                                        </td>
                                    @else
                                        <td class="dark-regular">{{ $nota_credito_registro->servicio->codigo_servicio }}</td>
                                        <td class="dark-regular">
                                            {{ $nota_credito_registro->servicio->descripcion }}
                                            @if(isset($doc_reg[$e])) {{ $doc_reg[$e]->descripcion_item }} @endif
                                        </td>
                                    @endif
                                    <td class="dark-regular">{{ $nota_credito_registro->cantidad }}</td>
                                    <td class="dark-regular" style="text-align: right">{{ number_format($nota_credito_registro->precio, 2) }}</td>
                                    <td class="dark-regular" style="text-align: right">{{ number_format($nota_credito_registro->precio * $nota_credito_registro->cantidad, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Monto en letras y totales -->
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="amount-box">
                                <div class="dark-bold">
                                    @php
                                        $v = new Luecano\NumeroALetras\NumeroALetras();
                                        $letra = ($v->toInvoice($end, 2));
                                    @endphp
                                    Son: <span class="dark-regular">{{ucfirst(strtolower($letra))}} {{ $moneda->nombre }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="totals-box">
                                <div class="totals-row">
                                    <span class="dark-bold">Subtotal:</span>
                                    <span class="dark-regular">{{$moneda->simbolo}} {{number_format($sub_total, 2)}}</span>
                                </div>
                                <div class="totals-row">
                                    <span class="dark-bold">Op. Gravada:</span>
                                    <span class="dark-regular">{{$moneda->simbolo}} {{number_format($nota_credito->op_gravada,2)}}</span>
                                </div>
                                <div class="totals-row">
                                    <span class="dark-bold">Op. Inafecta:</span>
                                    <span class="dark-regular">{{$moneda->simbolo}} {{ number_format($nota_credito->op_inafecta,2)}}</span>
                                </div>
                                <div class="totals-row">
                                    <span class="dark-bold">Op. Exonerada:</span>
                                    <span class="dark-regular">{{$moneda->simbolo}} {{number_format($nota_credito->op_exonerada,2)}}</span>
                                </div>
                                <div class="totals-row">
                                    <span class="dark-bold">I.G.V.:</span>
                                    <span class="dark-regular">{{$moneda->simbolo}} {{number_format(round($igv_p, 2),2)}}</span>
                                </div>
                                <div class="totals-row" style="border-top: 1px solid #000; padding-top: 5px;">
                                    <span class="dark-bold">Importe Total:</span>
                                    <span class="dark-regular">{{$moneda->simbolo}} {{number_format(round($end, 2),2)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script type="text/javascript">
        window.print();
    </script>

</body>
</html>