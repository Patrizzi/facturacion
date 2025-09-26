<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--  <title>Cotizaciones - Impresión Múltiple</title>--}}

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>
    <style>
    @media print {
    /* @page {
        size: A4;
        margin: 15mm;
    } */
    body {
        margin: 0 !important;
        padding: 0 !important;
    }
    .avoid-break {
        page-break-inside: avoid;
    }
    }
    </style>
</head>

<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    @php
        use Luecano\NumeroALetras\NumeroALetras;
    @endphp

    @foreach($cotizacionesData as $index => $cotizacionData)
        @php
            $cotizacion = $cotizacionData['cotizacion'];
            $cotizacion_registro = $cotizacionData['cotizacion_registro'];
            $sub_total = $cotizacionData['sub_total'];

            // Cálculos igual que en el método print original
            $igv_p = round($cotizacion->op_gravada, 2) * $igv->igv_total / 100;
            $end = round($sub_total, 2) + round($igv_p, 2);
            $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2);
            $i = 1;
        @endphp

        <div class="animated fadeInRight" @if($index > 0) style="page-break-before: always;" @endif>
            <div class="animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox-content p-xl" style="margin-bottom: 20px;padding-bottom: 50px;">
                            <div class="row">
                                {{-- Cabecera logo y informacion --}}
                                @include('layout_cabecera_ventas')
                                <div class="col-sm-4">
                                    <div class="form-control" align="center" style="height: auto;">
                                        <h3 style="padding-top:10px ">R.U.C {{ $empresa->ruc }}</h3>
                                        <h2 style="font-size: 19px">COTIZACIÓN ELECTRONICA</h2>
                                        <h5>{{ $cotizacion->cod_cotizacion }} </h5>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row" align="center" style="padding-bottom: 5px">
                                <div class="col-sm-6" align="center">
                                    <div class="form-control">
                                        <h3>Contacto Cliente</h3>
                                        <div align="left">
                                            <strong>Señor(es):</strong> &nbsp;{{ $cotizacion->cliente->nombre }}<br>
                                            <strong>{{ $cotizacion->cliente->documento_identificacion }} :</strong>
                                            &nbsp;{{ $cotizacion->cliente->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                            <strong>Dirección:</strong>&nbsp; {{ $cotizacion->cliente->direccion }}<br>
                                            <strong>N° Contacto:</strong>&nbsp; {{ $cotizacion->cliente->celular }}
                                            @if (isset($cotizacion->cliente->telefono))
                                                / {{ $cotizacion->cliente->telefono }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" align="center">
                                    <div class="form-control">
                                        <h3>Condiciones Generales</h3>
                                        <div align="left">
                                            <strong>Forma De Pago:</strong>
                                            &nbsp;{{ $cotizacion->forma_pago->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong>
                                            &nbsp;{{ $cotizacion->created_at }}<br>
                                            <strong>Validez:</strong> &nbsp;{{ $cotizacion->validez }}<br>
                                            <strong>Garantía:</strong>
                                            &nbsp;{{ $cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                            <strong>Tipo de Moneda:</strong>
                                            &nbsp;{{ $cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12" align="center">
                                    <div class="form-control" style="border: none;height: auto">
                                        <div align="left">
                                            <strong>Observaciones:</strong> &nbsp;{{ $cotizacion->observacion }}<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;width: 50px;">ITM </th>
                                            <th style="text-align:center;width: 120px;">CÓDIGO </th>
                                            <th>DESCRIPCION</th>
                                            <th style="text-align:center;width: 70px">CANT.</th>
                                            <th style="text-align:right;width: 110px">P. UNIT.</th>
                                            <th style="text-align:right;width: 110px;">TOTAL <span
                                                    hidden="hidden">{{ $simbologia = $cotizacion->moneda->simbolo }}</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cotizacion_registro as $cotizacion_registros)
                                            <tr>
                                                <td style="text-align:center;">{{ $i++ }} </td>
                                                @if (isset($cotizacion_registros->producto_id))
                                                    <td style="text-align:center;">{{ $cotizacion_registros->producto->codigo_producto }}</td>
                                                    <td>{{ $cotizacion_registros->producto->nombre }}
                                                        <br>{{ $cotizacion_registros->descipcion_item }}</span></td>
                                                @else
                                                    <td style="text-align:center;">{{ $cotizacion_registros->servicio->codigo_servicio }}</td>
                                                    <td>{{ $cotizacion_registros->servicio->nombre }}
                                                        <br>{{ $cotizacion_registros->descipcion_item }}</span></td>
                                                @endif

                                                <td style="text-align: center">{{ $cotizacion_registros->cantidad }}</td>
                                                <td style="text-align: right;">
                                                    {{ number_format($cotizacion_registros->precio_unitario_comi, 2) }}</td>
                                                <td style="text-align: right;">
                                                    {{ number_format($cotizacion_registros->cantidad * $cotizacion_registros->precio_unitario_comi, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <footer style="padding-top: 120px">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h3 align="left">
                                            @php
                                                $v = new NumeroALetras();
                                                $letra = $v->toInvoice($end, 2);
                                            @endphp
                                            Son : {{ ucfirst(strtolower($letra)) }} {{ $cotizacion->moneda->nombre }}
                                        </h3>
                                    </div>
                                    <div class="col-sm-4 form-control">
                                        <span style="display: block;float: left"> Subtotal:</span>
                                        <span style="display: block;float: right;">
                                            {{ $simbologia = $cotizacion->moneda->simbolo }}
                                            {{ number_format($sub_total, 2) }}</span>
                                        <br>
                                        <span style="display: block;float: left"> Op. Agravada: </span>
                                        <span style="display: block;float: right">{{ $simbologia }}
                                            {{ number_format($cotizacion->op_gravada, 2) }}</span><br>
                                        <span style="display: block;float: left"> Op. Inafecta: </span>
                                        <span style="display: block;float: right">{{ $simbologia }}
                                            {{ number_format($cotizacion->op_inafecta, 2) }}</span><br>
                                        <span style="display: block;float: left"> Op. Exonerada: </span>
                                        <span style="display: block;float: right">{{ $simbologia }}
                                            {{ number_format($cotizacion->op_exonerada, 2) }} </span><br>
                                        <span style="display: block;float: left"> I.G.V.: </span>
                                        <span style="display: block;float: right">{{ $cotizacion->moneda->simbolo }}
                                            {{ number_format(round($igv_p, 2), 2) }} </span><br>
                                        <span style="display: block;float: left"> Importe Total: </span>
                                        <span style="display: block;float: right">{{ $cotizacion->moneda->simbolo }}
                                            {{ number_format($end, 2) }}</span>
                                    </div>
                                </div>
                            </footer>
                            <br>
                            <!-- Fin Totales de Productos -->
                            @include('layout_bancos')
                            <br>
                            @include('layout_firma_pie_hoja')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style type="text/css">
        .form-control {
            border-radius: 10px;
            padding: 10px;
            border-color: #3D3D3D
        }

        .ibox-tools a {
            color: white !important
        }

        .a {
            height: 37px;
            margin: 0;
            border-radius: 0px;
            text-align: center;
        }

        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            border-top-width: 0px;
            border-color: #3D3D3D
        }

        * {
            color: black;
        }

        p.form-control {
            border-color: #3D3D3D;
        }

        /* Estilos para salto de página en impresión */
        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    {{-- IMPRIMIR --}}
    <script type="text/javascript">
        window.print();
    </script>

</body>
</html>
