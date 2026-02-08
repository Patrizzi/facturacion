<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>Facturas Manuales/Print Multiple</title> --}}

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        html,
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }

        body {
            font-size: 9px;
            line-height: 1.25;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            margin: 0 !important;
            padding: 0 !important;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        .ruc {
            border-radius: 10px;
            height: 150px;
        }

        .form-control {
            border-radius: 10px;
            border-color: #3D3D3D;
            background-color: transparent !important;
        }

        .a {
            height: 30px;
            margin: 0;
            border-radius: 0;
            text-align: center;
        }

        .table>thead>tr>th,
        .table>tbody>tr>td,
        .table>tfoot>tr>th {
            border-top-width: 0;
            border-color: #3D3D3D;
        }

        * {
            color: #000;
        }

        p.form-control {
            border-color: #3D3D3D;
        }

        #watermark {
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 0;
        }

        #watermark p {
            position: absolute;
            color: rgba(120, 120, 120, .31);
            font-family: Cambria, Georgia, Times, 'Times New Roman', serif !important;
            font-weight: bolder;
            font-size: 95px !important;
            pointer-events: none;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            top: 35%;
            right: 35%;
            z-index: 0;
        }

        @media print {
            @page {
                size: auto;
                margin: 0;
            }

            body {
                padding: 12mm 10mm !important;
            }

            .page-break {
                page-break-before: always;
            }

            .wrapper,
            .white-bg,
            .ibox,
            .ibox-content,
            .ibox-title {
                border: 0 !important;
                box-shadow: none !important;
                background: #fff !important;
            }

            .row:first-child,
            .row:first-child .col-lg-12,
            .row:first-child .ibox-content,
            .row:first-child .ibox-title {
                border-top: 0 !important;
            }

            table,
            .table {
                border-top: 0 !important;
            }

            * {
                outline: 0 !important;
            }
        }

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
    </style>
</head>
<body class="white-bg">
    @php use Luecano\NumeroALetras\NumeroALetras; @endphp

    @foreach($facturasData as $index => $facturaData)
    @php
    $factura = $facturaData['factura'];
    $factura_registro = $facturaData['factura_registro'];
    $sub_total = $facturaData['sub_total'];
    $detraccion = $facturaData['detraccion'];
    $cuotas = $facturaData['cuotas'];
    $i = 1;
    $sub_total_gravado = $factura->op_gravada;
    $igv_p = round($sub_total_gravado, 2) * $igv->igv_total / 100;
    $end = round($sub_total, 2) + round($igv_p, 2);
    $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2);
    @endphp

    <div class="row" @if($index> 0) style="page-break-before: always;" @endif>
        <div class="col-lg-12" style="margin-top: -5px;">
            @if ($factura->f_electronica == 2 || $factura->nota_credito == 1)
            <div id="watermark">
                <p>Anulado</p>
            </div>
            @endif
            <div class="ibox-content p-xl" style="margin-bottom:20px; padding-bottom:50px;">
                <div class="row" style="align-items:center; justify-content:center">
                    @include('layout_cabecera_ventas')
                    <div class="col-sm-4">
                        <div class="form-control ruc" style="height:125px">
                            <center>
                                <h3 style="padding-top:10px">R.U.C : {{$empresa->ruc}}</h3>
                                <h2>FACTURA ELECTRÓNICA</h2>
                                <h5>{{$factura->codigo_fac}}</h5>
                            </center>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" align="center" style="padding-bottom:5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <div align="left">
                                <strong>Cliente:</strong>
                                @if(isset($factura->cliente_id)){{$factura->cliente->nombre}}@else{{$factura->cotizacion->cliente->nombre}}@endif <br>
                                <strong>R.U.C:</strong>
                                @if(isset($factura->cliente_id)){{$factura->cliente->numero_documento}}@else{{$factura->cotizacion->cliente->numero_documento}}@endif <br>
                                <strong>Dirección:</strong>
                                @if(isset($factura->cliente_id)){{$factura->cliente->direccion}}@else{{$factura->cotizacion->cliente->direccion}}@endif <br>
                                <strong>Condiciones de Pago:</strong>
                                @if(isset($factura->cliente_id)){{$factura->forma_pago->nombre}}@else{{$factura->cotizacion->forma_pago->nombre}}@endif
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Tipo de Moneda:</strong>
                                @if(isset($factura->cliente_id)){{$factura->moneda->nombre}}@else{{$factura->cotizacion->moneda->nombre}}@endif <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <div align="left">
                                <strong>Orden de Compra:</strong> {{$factura->orden_compra}} <br>
                                <strong>Guía de Remisión:</strong> {{$factura->guia_remision}} <br>
                                <strong>Fecha Emisión:</strong> {{$factura->fecha_emision}} <br>
                                <strong>Fecha de Vencimiento:</strong> {{$factura->fecha_vencimiento}} <br>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center; width:50px;">ITEM</th>
                                <th style="text-align:center; width:120px">CÓDIGO</th>
                                <th>DESCRIPCIÓN</th>
                                <th style="text-align:center; width:70px">CANT.</th>
                                <th style="text-align:right; width:110px">P. UNIT.</th>
                                <th style="text-align:right; width:110px;">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($factura_registro as $factura_registros)
                            <tr>
                                <td style="text-align:center">{{$i}}</td>
                                @if(isset($factura_registros->producto))
                                <td style="text-align:center">{{$factura_registros->producto->codigo_producto}}</td>
                                <td>{{$factura_registros->producto->nombre}} {{$factura_registros->descripcion_item}}@if(isset($factura_registros->numero_serie)) <br><strong>N/S:</strong> {{$factura_registros->numero_serie}}@endif</td>
                                @else
                                <td style="text-align:center">{{$factura_registros->servicio->codigo_servicio}}</td>
                                <td>{{$factura_registros->servicio->nombre}} {{$factura_registros->descripcion_item}}</td>
                                @endif
                                <td style="text-align:center">{{$factura_registros->cantidad}}</td>
                                <td style="text-align:right">{{number_format($factura_registros->precio,2)}}</td>
                                <td style="text-align:right">{{number_format($factura_registros->precio * $factura_registros->cantidad - ($factura_registros->precio * $factura_registros->cantidad * $factura_registros->descuento)/100, 2)}}</td>
                            </tr>
                            @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <br><br><br><br>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 align="left">
                                    @php $v = new NumeroALetras(); $letra = $v->toInvoice($end, 2); @endphp
                                    Son : {{ ucfirst(strtolower($letra)) }} {{ $factura->moneda->nombre }}
                                </h3>
                                <br>
                                <small style="font-size:70%"><strong>FACTURA ELECTRÓNICA</strong> – Representación Impresa</small>
                                <small style="font-size:70%">Esta puede ser consultada en www.codecta.pe</small>
                                <small style="font-size:70%">Autorizado mediante Resolución de Intendencia N° 0180050001374/SUNAT</small>
                            </div>
                             <div class="col-sm-4 qr-container">
                                <div class="qr-box">
                                    @if(!empty($facturaData['qrCode']))
                                        <img src="{{ $facturaData['qrCode'] }}" alt="Código QR" class="qr-image">
                                    @else
                                        <span class="qr-placeholder">QR</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 form-control">
                        <span style="display:block; float:left">Sub Total:</span>
                        <span style="display:block; float:right">{{$simbologia=$factura->moneda->simbolo}} {{number_format($sub_total,2)}}</span>
                        <br>
                        <span style="display:block; float:left">Op. Gravada:</span>
                        <span style="display:block; float:right">{{$simbologia}} {{number_format($factura->op_gravada,2)}}</span><br>
                        <span style="display:block; float:left">Op. Inafecta:</span>
                        <span style="display:block; float:right">{{$simbologia}} {{number_format($factura->op_inafecta,2)}}</span><br>
                        <span style="display:block; float:left">Op. Exonerada:</span>
                        <span style="display:block; float:right">{{$simbologia}} {{number_format($factura->op_exonerada,2)}}</span><br>
                        <span style="display:block; float:left">I.G.V.:</span>
                        <span style="display:block; float:right">{{$factura->moneda->simbolo}} {{number_format(round($igv_p,2),2)}}</span><br>
                        <span style="display:block; float:left">Importe Total:</span>
                        <span style="display:block; float:right">{{$factura->moneda->simbolo}} {{number_format(round($end,2),2)}}</span>
                    </div>
                </div>
                <br>
                <div class="row">
                    @if ($detraccion == 'not')
                    <div class="col-sm-12 form-control" style="height:120px">
                        <strong>Observaciones:</strong><br>
                        {{$factura->observacion}}
                    </div>
                    @else
                    <div class="col-sm-6">
                        <div class="form-control" style="height:100px !important">
                            <strong>Información de Detracción:</strong><br>
                            <strong>Tipo de Detracción:</strong> {{$detraccion->tipo_detraccion->descripcion}} - {{$detraccion->porcentaje_detraccion}} %<br>
                            <strong>Medio de Pago:</strong> {{$detraccion->medio_pago->descripcion}} <br>
                            <strong>Monto de Detracción:</strong> S/. {{number_format($detraccion->monto_detraccion, 2)}} <br>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-control" style="height:100px !important">
                            <strong>Observaciones:</strong><br>
                            {{$factura->observacion}}
                        </div>
                    </div>
                    @endif
                </div>
                <br>
                @if ($cuotas != 'not')
                <strong>Información de Crédito:</strong><br>
                <div class="row" style="justify-content:left">
                    @foreach ($cuotas as $cuota)
                    @php
                    if ($factura->moneda->id == 1) {
                    $monto_total_det = $cuota->monto - $detraccion->monto_detraccion;
                    } else {
                    $mont_porc = $end * ($detraccion->porcentaje_detraccion / 100);
                    $monto_total_det = $end - $mont_porc;
                    }
                    @endphp
                    <div class="col-sm-3">
                        <div class="form-control">
                            <strong>Cuota:</strong><br>
                            {{$cuota->numero_cuota}}<br>
                            <strong>Monto:</strong><br>
                            {{$factura->moneda->simbolo}} {{number_format($monto_total_det, 2)}}<br>
                            <strong>Fecha de Vencimiento:</strong><br>
                            {{Carbon\Carbon::parse($cuota->fecha_pago)->format('d-m-Y')}} <br>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                <br>
                @include('layout_bancos')
                <br>
            </div>
        </div>
    </div>
    @endforeach

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                try {
                    window.focus();
                } catch (e) {}
                window.print();
            }, 150);
        });
        window.addEventListener('afterprint', function() {
            try {
                if (window.opener) window.close();
            } catch (e) {}
        });

    </script>
</body>
</html>
