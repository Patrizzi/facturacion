<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notas de Débito - Impresión Múltiple</title>

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

        .ruc {
            border-radius: 10px;
            height: 125px;
        }

        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
            border-top-width: 0px;
        }

        /* Estilos para salto de página en impresión */
        @media print {
            .page-break {
                page-break-before: always;
            }
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
        // Remover el use statement - lo usaremos directamente en el código
    @endphp

    @foreach($notasData as $index => $notaData)
        @php
            $nota_debito = $notaData['nota_debito'];
            $nota_debito_reg = $notaData['nota_debito_reg'];
            $document = $notaData['document'];
            $doc_reg = $notaData['doc_reg'] ?? [];
            $estado = $notaData['estado'];
            $u = 1;

            // Calcular totales
            $sub_total = $nota_debito->op_gravada + $nota_debito->op_inafecta + $nota_debito->op_exonerada;
            $sub_total_gravado = $nota_debito->op_gravada;
            $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100;
            $end = round($sub_total, 2) + round($igv_p, 2);
            $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2);
        @endphp

        <div class="ibox-content p-xl" style="margin-bottom: 20px;padding-bottom: 50px;" @if($index > 0) class="page-break" @endif>
            <div class="row">
                @include('layout_cabecera_ventas')
                <div class="col-sm-4">
                    <div class="form-control ruc" style="height: 125px">
                        <center>
                            <h3 style="padding-top:10px">R.U.C : {{ $empresa->ruc }}</h3>
                            <h2>NOTA DE DÉBITO</h2>
                            {{ $nota_debito->codigo_n_d }}
                        </center>
                    </div>
                </div>
            </div>
            <br>

            <div class="row" align="center" style="padding-bottom: 5px">
                <div class="col-sm-6" align="center">
                    <div class="form-control">
                        <div align="left">
                            @if ($estado == 0)
                                <strong>Cliente:</strong>
                                @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                    {{ $nota_debito->nota_i_facturacion->cliente->nombre }}
                                    @else
                                        {{ $nota_debito->nota_i_facturacion->cotizacion->cliente->nombre }}
                                @endif <br>
                                <strong>R.U.C:</strong>
                                @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                    {{ $nota_debito->nota_i_facturacion->cliente->numero_documento }}
                                    @else{{ $nota_debito->nota_i_facturacion->cotizacion->cliente->numero_documento }}
                                @endif <br>
                                <strong>Direccion:</strong>
                                @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                    {{ $nota_debito->nota_i_facturacion->cliente->direccion }}
                                    @else{{ $nota_debito->nota_i_facturacion->cotizacion->cliente->direccion }}
                                @endif <br>
                                <strong>Condiciones de Pago:</strong>
                                @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                    {{ $nota_debito->nota_i_facturacion->forma_pago->nombre }}
                                    @else{{ $nota_debito->nota_i_facturacion->cotizacion->forma_pago->nombre }}
                                @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Tipo de Moneda:</strong>
                                @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                                    {{ $nota_debito->nota_i_facturacion->moneda->nombre }}
                                    @else{{ $nota_debito->nota_i_facturacion->cotizacion->moneda->nombre }}
                                @endif
                                <br>
                            @elseif($estado == 1)
                                <strong>Cliente:</strong>
                                @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                    {{ $nota_debito->nota_i_boleta->cliente->nombre }}
                                    @else{{ $nota_debito->nota_i_boleta->cotizacion->cliente->nombre }}
                                @endif <br>
                                <strong>R.U.C:</strong>
                                @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                    {{ $nota_debito->nota_i_boleta->cliente->numero_documento }}
                                    @else{{ $nota_debito->nota_i_boleta->cotizacion->cliente->numero_documento }}
                                @endif <br>
                                <strong>Direccion:</strong>
                                @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                    {{ $nota_debito->nota_i_boleta->cliente->direccion }}
                                    @else{{ $nota_debito->nota_i_boleta->cotizacion->cliente->direccion }}
                                @endif <br>
                                <strong>Condiciones de Pago:</strong>
                                @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                    {{ $nota_debito->nota_i_boleta->forma_pago->nombre }}
                                    @else{{ $nota_debito->nota_i_boleta->cotizacion->forma_pago->nombre }}
                                @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Tipo de Moneda:</strong>
                                @if (isset($nota_debito->nota_i_boleta->cliente_id))
                                    {{ $nota_debito->nota_i_boleta->moneda->nombre }}
                                    @else{{ $nota_debito->nota_i_boleta->cotizacion->moneda->nombre }}
                                @endif
                                <br>
                            @elseif($estado == 3)
                                <strong>Cliente:</strong>
                                @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                    {{ $nota_debito->nota_i_boleta_manual->cliente->nombre }}
                                    @else{{ $nota_debito->nota_i_boleta_manual->cotizacion->cliente->nombre }}
                                @endif <br>
                                <strong>R.U.C:</strong>
                                @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                    {{ $nota_debito->nota_i_boleta_manual->cliente->numero_documento }}
                                    @else{{ $nota_debito->nota_i_boleta_manual->cotizacion->cliente->numero_documento }}
                                @endif <br>
                                <strong>Direccion:</strong>
                                @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                    {{ $nota_debito->nota_i_boleta_manual->cliente->direccion }}
                                    @else{{ $nota_debito->nota_i_boleta_manual->cotizacion->cliente->direccion }}
                                @endif <br>
                                <strong>Condiciones de Pago:</strong>
                                @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                    {{ $nota_debito->nota_i_boleta_manual->forma_pago->nombre }}
                                    @else{{ $nota_debito->nota_i_boleta_manual->cotizacion->forma_pago->nombre }}
                                @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Tipo de Moneda:</strong>
                                @if (isset($nota_debito->nota_i_boleta_manual->cliente_id))
                                    {{ $nota_debito->nota_i_boleta_manual->moneda->nombre }}
                                    @else{{ $nota_debito->nota_i_boleta_manual->cotizacion->moneda->nombre }}
                                @endif
                                <br>
                            @else
                                <strong>Cliente:</strong>
                                @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                    {{ $nota_debito->nota_i_fac_manual->cliente->nombre }}
                                    @else{{ $nota_debito->nota_i_fac_manual->cotizacion->cliente->nombre }}
                                @endif <br>
                                <strong>R.U.C:</strong>
                                @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                    {{ $nota_debito->nota_i_fac_manual->cliente->numero_documento }}
                                    @else{{ $nota_debito->nota_i_fac_manual->cotizacion->cliente->numero_documento }}
                                @endif <br>
                                <strong>Direccion:</strong>
                                @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                    {{ $nota_debito->nota_i_fac_manual->cliente->direccion }}
                                    @else{{ $nota_debito->nota_i_fac_manual->cotizacion->cliente->direccion }}
                                @endif <br>
                                <strong>Condiciones de Pago:</strong>
                                @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                    {{ $nota_debito->nota_i_fac_manual->forma_pago->nombre }}
                                    @else{{ $nota_debito->nota_i_fac_manual->cotizacion->forma_pago->nombre }}
                                @endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Tipo de Moneda:</strong>
                                @if (isset($nota_debito->nota_i_fac_manual->cliente_id))
                                    {{ $nota_debito->nota_i_fac_manual->moneda->nombre }}
                                    @else{{ $nota_debito->nota_i_fac_manual->cotizacion->moneda->nombre }}
                                @endif
                                <br>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-sm-6" align="center">
                    <div class="form-control">
                        <div align="left">
                            <strong>Documento: </strong>
                            @if ($nota_debito->facturacion_id != null)
                                {{ $nota_debito->nota_i_facturacion->codigo_fac }}<br>
                            @elseif($nota_debito->boleta_id != null)
                                {{ $nota_debito->nota_i_boleta->codigo_boleta }}<br>
                            @elseif($nota_debito->boleta_m_id != null)
                                {{ $nota_debito->nota_i_boleta_manual->codigo_boleta }}<br>
                            @else
                                {{ $nota_debito->nota_i_fac_manual->codigo_fac }}<br>
                            @endif
                            <strong>Orden de Compra:</strong>
                            {{ $document->orden_compra }}<br>
                            <strong>Guia de Remision:</strong>
                            {{ $document->guia_remision }}<br>
                            <strong>Fecha Emision:</strong>
                            {{ $document->fecha_emision }}<br>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12" style="padding-top: 15px">
                    <div class="form-control">
                        <div align="left" class="row">
                            <div class="col-sm-6">
                                <strong>Tipo:</strong>
                                @if ($nota_debito->tipo == 01)
                                    Interes por mora
                                @elseif($nota_debito->tipo == 02)
                                    Aumentos en el valor
                                @else
                                    Penalidade
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <strong>Motivo:</strong>
                                {{ $nota_debito->motivo }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12" align="center">
                    <div class="form-control" style="border: none;height: auto">
                        <div align="left">
                        </div>
                    </div>
                </div>
            </div>
            <br>

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
                        @foreach ($nota_debito_reg as $e => $nota_debito_registro)
                            <tr>
                                <td>{{ $u++ }}</td>
                                @if (isset($nota_debito_registro->producto_id))
                                    <td>{{ $nota_debito_registro->producto->codigo_producto }}</td>
                                @else
                                    <td>{{ $nota_debito_registro->servicio->codigo_servicio }}</td>
                                @endif

                                <td>
                                    {{ $nota_debito_registro->producto->descripcion }}
                                    {{ $doc_reg[$e]->descripcion_item ?? '' }}
                                </td>
                                <td>{{ $nota_debito_registro->cantidad }}</td>
                                <td>{{ number_format($nota_debito_registro->precio, 2) }}</td>
                                <td>{{ number_format($nota_debito_registro->precio * $nota_debito_registro->cantidad, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br><br><br><br>

            <div class="row">
                <div class="col-sm-8">
                    <h3 align="left">
                        @php
                            // Opción 1: Si usas CifrasEnLetras local
                            try {
                                $v = new \CifrasEnLetras();
                                $letra = $v->convertirEurosEnLetras($end);
                                $letra_final = ucfirst(strstr($letra, 'soles', true));
                                $end_final_point = strstr($end2, '.', false);
                                $end_final = str_replace('.', '', $end_final_point);
                            } catch (Exception $e) {
                                // Opción 2: Si usas el paquete Luecano
                                try {
                                    $v = new \Luecano\NumeroALetras\NumeroALetras();
                                    $letra = $v->toInvoice($end, 2);
                                    $letra_final = ucfirst(strtolower($letra));
                                    $end_final = '';
                                } catch (Exception $e2) {
                                    // Fallback si ninguna clase funciona
                                    $letra_final = 'Error al convertir número a letras';
                                    $end_final = '';
                                }
                            }
                        @endphp
                        Son: {{ $letra_final }}
                        @if($end_final)con {{ $end_final }}/100 @endif
                        @if (isset($nota_debito->facturacion_id))
                            {{ $nota_debito->nota_i_facturacion->moneda->nombre }}
                        @elseif(isset($nota_debito->boleta_id))
                            {{ $nota_debito->nota_i_boleta->moneda->nombre }}
                        @elseif(isset($nota_debito->boleta_m_id))
                            {{ $nota_debito->nota_i_boleta_manual->moneda->nombre }}
                        @else
                            {{ $nota_debito->nota_i_fac_manual->moneda->nombre }}
                        @endif
                    </h3>
                </div>
                <div class="col-sm-4 form-control">
                    <span style="display: block;float: left"> Subtotal:</span>
                    <span style="display: block;float: right;">
                        @if (isset($nota_debito->facturacion_id))
                            {{ $simbologia = $nota_debito->nota_i_facturacion->moneda->simbolo }}
                        @elseif(isset($nota_debito->boleta_id))
                            {{ $simbologia = $nota_debito->nota_i_boleta->moneda->simbolo }}
                        @elseif(isset($nota_debito->boleta_m_id))
                            {{ $simbologia = $nota_debito->nota_i_boleta_manual->moneda->simbolo }}
                        @else
                            {{ $simbologia = $nota_debito->nota_i_fac_manual->moneda->simbolo }}
                        @endif
                        {{ number_format($sub_total, 2) }}
                    </span>
                    <br>
                    <span style="display: block;float: left"> Op. Gravada: </span>
                    <span style="display: block;float: right">{{ $simbologia }}
                        {{ number_format($nota_debito->op_gravada, 2) }}</span><br>
                    <span style="display: block;float: left"> Op. Inafecta: </span>
                    <span style="display: block;float: right">{{ $simbologia }}
                        {{ number_format($nota_debito->op_inafecta, 2) }}</span><br>
                    <span style="display: block;float: left"> Op. Exonerada: </span>
                    <span style="display: block;float: right">{{ $simbologia }}
                        {{ number_format($nota_debito->op_exonerada, 2) }} </span><br>
                    <span style="display: block;float: left"> I.G.V.: </span>
                    <span style="display: block;float: right">{{ $simbologia }}
                        {{ number_format(round($igv_p, 2), 2) }}</span><br>
                    <span style="display: block;float: left"> Importe Total: </span>
                    <span style="display: block;float: right">{{ $simbologia }}
                        {{ number_format(round($end, 2), 2) }}</span>
                </div>
            </div>
            <br><br>
        </div>

        <!-- Salto de página para la siguiente nota -->
        @if(!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
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

        #watermark {
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 0;
        }

        #watermark p {
            position: absolute;
            color: rgba(120, 120, 120, 0.31);
            font-weight: bolder;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 95px;
            pointer-events: none;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            top: 45%;
            right: 40%;
            z-index: 100;
        }
    </style>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>

    {{-- IMPRIMIR --}}
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
