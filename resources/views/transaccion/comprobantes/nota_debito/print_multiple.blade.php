<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--  <title>Notas de Débito - Impresión Múltiple</title>--}}

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">

    <style type="text/css">
        .form-control,
        .single-line {
            background-color: #FFFFFF;
            background-image: none;
            border: 1px solid #808080;
            border-radius: 10px;
            color: inherit;
            display: block;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
        }

        @page {
            size: 420mm 297mm landscape;
        }

        /* Estilos para salto de página en impresión */
        /* @media print {
            .page-break {
                page-break-before: always;
            }
        } */

        /* ESTILOS AGREGADOS PARA NEGRITA Y COLOR NEGRO OSCURO */
        .dark-bold {
            color: #000000;
            font-weight: bold;
        }

        .dark-semibold {
            color: #000000;
            font-weight: 600;
        }

        .dark-regular {
            color: #000000;
            font-weight: normal;
        }

        .table thead th {
            color: #000000;
            font-weight: bold;
            background-color: #f2f2f2 !important;
        }

        .invoice-header {
            color: #000000;
            font-weight: bold;
        }

        .section-title {
            color: #000000;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        .totals-label {
            color: #000000;
            font-weight: 600;
        }

        .bank-title {
            color: #000000;
            font-weight: bold;
        }

        .bank-detail {
            color: #000000;
            font-weight: normal;
        }
    </style>

</head>

<body class="white-bg">
    @php
        use Luecano\NumeroALetras\NumeroALetras;
    @endphp

    @foreach($notasData as $index => $notaData)
        @php
            $nota_debito = $notaData['nota_debito'];
            $nota_debito_reg = $notaData['nota_debito_reg'];
            $document = $notaData['document'];
            $doc_reg = $notaData['doc_reg'];
            $estado = $notaData['estado'];
            $sub_total = $notaData['sub_total'];
            $sub_total_gravado = $notaData['sub_total_gravado'];
            $igv_p = $notaData['igv_p'];
            $end = $notaData['end'];
            $end2 = $notaData['end2'];
            $u = 1;

            // DEFINIR LA VARIABLE $moneda SEGÚN EL TIPO DE DOCUMENTO
            if ($estado == 0) {
                $moneda = $nota_debito->nota_i_facturacion->moneda;
            } elseif($estado == 1) {
                $moneda = $nota_debito->nota_i_boleta->moneda;
            } elseif($estado == 3) {
                $moneda = $nota_debito->nota_i_boleta_manual->moneda;
            } else {
                $moneda = $nota_debito->nota_i_fac_manual->moneda;
            }
        @endphp

        <div class="row" @if($index > 0) style="page-break-before: always;" @endif>
            <div class="col-lg-12" style="margin-top: -5px;">
                <div class="ibox-content p-xl" style="margin-bottom: 20px;padding-bottom: 50px;">
                    <div class="row">
                        {{-- Cabecera de la empresa --}}
                        <div class="col-sm-8">
                            <div class="form-control" style="height: 125px">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <center>
                                            <img src="{{ asset('img/logo/' . $empresa->logo) }}" width="80px" height="80px">
                                        </center>
                                    </div>
                                    <div class="col-sm-9">
                                        <center>
                                            <h3 style="margin-bottom: 0;" class="dark-bold">{{ $empresa->nombre_comercial }}</h3>
                                            <p style="margin-bottom: 0; font-size: 12px;" class="dark-regular">
                                                <span class="dark-bold">{{ $empresa->razon_social }}</span><br>
                                                {{ $empresa->direccion }}<br>
                                                Teléfono: {{ $empresa->telefono }}
                                            </p>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 ">
                            <div class="form-control ruc" style="height: 125px">
                                <center>
                                    <h3 style="padding-top:10px " class="dark-bold">R.U.C : {{ $empresa->ruc }}</h3>
                                    <h2 class="dark-bold">NOTA DE DEBITO</h2>
                                    <span class="dark-regular">{{ $nota_debito->codigo_n_d }}</span>
                                </center>
                            </div>
                        </div>
                    </div><br>

                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <div align="left">
                                    @if ($estado == 0)
                                        <span class="dark-bold">Cliente:</span>
                                        @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->cliente->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->cotizacion->cliente->nombre }}</span>
                                        @endif <br>
                                        <span class="dark-bold">R.U.C:</span>
                                        @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->cliente->numero_documento }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->cotizacion->cliente->numero_documento }}</span>
                                        @endif <br>
                                        <span class="dark-bold">Direccion:</span>
                                        @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->cliente->direccion }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->cotizacion->cliente->direccion }}</span>
                                        @endif <br>
                                        <span class="dark-bold">Condiciones de Pago:</span>
                                        @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->forma_pago->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->cotizacion->forma_pago->nombre }}</span>
                                        @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="dark-bold">Tipo de Moneda:</span>
                                        @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->moneda->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->cotizacion->moneda->nombre }}</span>
                                        @endif
                                        <br>
                                    @elseif($estado == 1)
                                        <span class="dark-bold">Cliente:</span>
                                        @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->cliente->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->cotizacion->cliente->nombre }}</span>
                                        @endif <br>
                                        <span class="dark-bold">R.U.C:</span>
                                        @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->cliente->numero_documento }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->cotizacion->cliente->numero_documento }}</span>
                                        @endif <br>
                                        <span class="dark-bold">Direccion:</span>
                                        @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->cliente->direccion }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->cotizacion->cliente->direccion }}</span>
                                        @endif <br>
                                        <span class="dark-bold">Condiciones de Pago:</span>
                                        @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->forma_pago->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->cotizacion->forma_pago->nombre }}</span>
                                        @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="dark-bold">Tipo de Moneda:</span>
                                        @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->moneda->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta->cotizacion->moneda->nombre }}</span>
                                        @endif
                                        <br>
                                    @elseif($estado == 3)
                                        <span class="dark-bold">Cliente:</span>
                                        @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->cliente->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->cotizacion->cliente->nombre }}</span>
                                        @endif <br>
                                        <span class="dark-bold">R.U.C:</span>
                                        @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->cliente->numero_documento }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->cotizacion->cliente->numero_documento }}</span>
                                        @endif <br>
                                        <span class="dark-bold">Direccion:</span>
                                        @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->cliente->direccion }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->cotizacion->cliente->direccion }}</span>
                                        @endif <br>
                                        <span class="dark-bold">Condiciones de Pago:</span>
                                        @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->forma_pago->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->cotizacion->forma_pago->nombre }}</span>
                                        @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="dark-bold">Tipo de Moneda:</span>
                                        @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->moneda->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->cotizacion->moneda->nombre }}</span>
                                        @endif
                                        <br>
                                    @else
                                        <span class="dark-bold">Cliente:</span>
                                        @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->cliente->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->cotizacion->cliente->nombre }}</span>
                                        @endif <br>
                                        <span class="dark-bold">R.U.C:</span>
                                        @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->cliente->numero_documento }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->cotizacion->cliente->numero_documento }}</span>
                                        @endif <br>
                                        <span class="dark-bold">Direccion:</span>
                                        @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->cliente->direccion }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->cotizacion->cliente->direccion }}</span>
                                        @endif <br>
                                        <span class="dark-bold">Condiciones de Pago:</span>
                                        @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->forma_pago->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->cotizacion->forma_pago->nombre }}</span>
                                        @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="dark-bold">Tipo de Moneda:</span>
                                        @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->moneda->nombre }}</span>
                                        @else
                                            <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->cotizacion->moneda->nombre }}</span>
                                        @endif
                                        <br>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <div align="left">
                                    <span class="dark-bold">Documento: </span>
                                    @if ($nota_debito->facturacion_id != null)
                                        <span class="dark-regular">{{ $nota_debito->nota_i_facturacion->codigo_fac }}</span><br>
                                    @elseif($nota_debito->boleta_id != null)
                                        <span class="dark-regular">{{ $nota_debito->nota_i_boleta->codigo_boleta }}</span><br>
                                    @elseif($nota_debito->boleta_m_id != null)
                                        <span class="dark-regular">{{ $nota_debito->nota_i_boleta_manual->codigo_boleta }}</span><br>
                                    @else
                                        <span class="dark-regular">{{ $nota_debito->nota_i_fac_manual->codigo_fac }}</span><br>
                                    @endif
                                    <span class="dark-bold">Orden de Compra:</span>
                                    <span class="dark-regular">{{ $document->orden_compra }}</span><br>
                                    <span class="dark-bold">Guia de Remision:</span>
                                    <span class="dark-regular">{{ $document->guia_remision }}</span><br>
                                    <span class="dark-bold">Fecha Emision:</span>
                                    <span class="dark-regular">{{ $document->fecha_emision }}</span><br>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-12" style="padding-top: 15px">
                            <div class="form-control">
                                <div align="left" class="row">
                                    <div class="col-sm-6">
                                        <span class="dark-bold">Tipo:</span>
                                        @if ($nota_debito->tipo == 01)
                                            <span class="dark-regular">Interes por mora</span>
                                        @elseif($nota_debito->tipo == 02)
                                            <span class="dark-regular">Aumentos en el valor</span>
                                        @else
                                            <span class="dark-regular">Penalidade</span>
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <span class="dark-bold">Motivo:</span>
                                        <span class="dark-regular">{{ $nota_debito->motivo }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="table-responsive">
                        <table class="table ">
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
                                @foreach ($nota_debito_reg as $e => $nota_debito_registro)
                                <tr>
                                    <td class="dark-regular">{{ $u++ }}</td>
                                    @if (isset($nota_debito_registro->producto_id))
                                        <td class="dark-regular">{{ $nota_debito_registro->producto->codigo_producto }}</td>
                                        <td class="dark-regular">{{ $nota_debito_registro->producto->descripcion }}
                                            @if(isset($doc_reg[$e])){{ $doc_reg[$e]->descripcion_item }}@endif
                                        </td>
                                    @else
                                        <td class="dark-regular">{{ $nota_debito_registro->servicio->codigo_servicio }}</td>
                                        <td class="dark-regular">{{ $nota_debito_registro->servicio->descripcion }}
                                            @if(isset($doc_reg[$e])){{ $doc_reg[$e]->descripcion_item }}@endif
                                        </td>
                                    @endif
                                    <td class="dark-regular">{{ $nota_debito_registro->cantidad }}</td>
                                    <td class="dark-regular" style="text-align: right">{{ number_format($nota_debito_registro->precio, 2) }}</td>
                                    <td class="dark-regular" style="text-align: right">{{ number_format($nota_debito_registro->precio * $nota_debito_registro->cantidad, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br><br><br><br>

                    <div class="row">
                        <div class="col-sm-8">
                            <h3 align="left" class="dark-bold">
                                @php
                                    $v = new Luecano\NumeroALetras\NumeroALetras();
                                    $letra = ($v->toInvoice($end, 2));
                                @endphp
                                Son: <span class="dark-regular" style="font-weight: normal">{{ucfirst(strtolower($letra))}} {{ $moneda->nombre }}</span>
                            </h3>
                            <br>
                            <div class="row">
                                <div class="col-sm-4 text-left">
                                    <small style="font-size: 70%" class="dark-regular">
                                        Representación Impresa de <strong class="dark-bold">NOTA DE DÉBITO ELECTRÓNICA</strong>
                                    </small>
                                    <small style="font-size: 70%" class="dark-regular">
                                        Esta puede ser consultada en www.codecta.pe
                                    </small>
                                    <small style="font-size: 70%" class="dark-regular">
                                        Autorizado mediante Resolución de Intendencia N° 0180050001374/SUNAT
                                    </small>
                                </div>
                                <div class="col-sm-8">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 form-control">
                            <span class="totals-label" style="display: block;float: left"> Subtotal:</span>
                            <span class="dark-regular" style="display: block;float: right;"> {{$moneda->simbolo}} {{number_format($sub_total, 2)}}</span>
                            <br>
                            <span class="totals-label" style="display: block;float: left"> Op. Gravada: </span>
                            <span class="dark-regular" style="display: block;float: right">{{$moneda->simbolo}} {{number_format($nota_debito->op_gravada,2)}}</span><br>
                            <span class="totals-label" style="display: block;float: left"> Op. Inafecta: </span>
                            <span class="dark-regular" style="display: block;float: right">{{$moneda->simbolo}} {{ number_format($nota_debito->op_inafecta,2)}}</span><br>
                            <span class="totals-label" style="display: block;float: left"> Op. Exonerada: </span>
                            <span class="dark-regular" style="display: block;float: right">{{$moneda->simbolo}} {{number_format($nota_debito->op_exonerada,2)}} </span><br>
                            <span class="totals-label" style="display: block;float: left"> I.G.V.: </span>
                            <span class="dark-regular" style="display: block;float: right">{{$moneda->simbolo}} {{number_format(round($igv_p, 2),2)}}</span><br>
                            <span class="totals-label" style="display: block;float: left"> Importe Total: </span>
                            <span class="dark-regular" style="display: block;float: right">{{$moneda->simbolo}} {{number_format(round($end, 2),2)}}</span>
                        </div>
                        <div class="col-sm-12 form-control" align="center" style="margin-top: 8px">
                            <div align="left">
                                <span class="dark-bold">Observación:</span>
                                <p class="dark-regular"> {{$nota_debito->observacion ?? 'Emitimos la siguiente Nota de Débito a vuestra solicitud'}} </p>
                            </div>
                        </div>
                    </div>
                    <br>
                    @include('layout_bancos')
                    <br>
                </div>
            </div>
        </div>
    @endforeach

    <style type="text/css">
        .form-control {
            border-radius: 10px;
            padding: 10px
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
