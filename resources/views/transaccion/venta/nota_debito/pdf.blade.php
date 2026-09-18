<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota de Debito</title>{{--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>
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
        size: A4;
        font-size: 60% !important;
    }
</style>

<body class="white-bg">
    <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
        <tr>
            @include('layout_cabecera_ventas_pdf')
            <td style="width: 30%; ;border: 1px #808080 solid;border-radius: 8px;margin-top: 0px" align="right">
                <center>
                    <h3 style="text-align: center;margin: 6px"> R.U.C {{ $empresa->ruc }}</h3>
                    <h2 style="font-size: 19px;text-align: center;margin: 6px">NOTA DE DÉBITO</h2>
                    <h4 style="text-align: center;margin: 6px">{{ $nota_debito->codigo_n_d }}</h4>
                </center>
            </td>
        </tr>
    </table>
    {{-- CONTENIDO DE DATOS --}}
    <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
        <table style="width: 100%;border-collapse:separate;margin-top: -20px">
            <tr>
                <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
                    @if ($estado == 0)
                        <strong>Cliente:</strong>
                        @if (isset($nota_debito->nota_i_facturacion->cliente_id))
                            {{ $nota_debito->nota_i_facturacion->cliente->nombre }}
                            @else{{ $nota_debito->nota_i_facturacion->cotizacion->cliente->nombre }}
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
                </td>
                <th style="width: 5%;border-color: white"></th>
                <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
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
                </td>
            </tr>
        </table>
        <table style="width: 100%;border-collapse:separate;">
            <tr>
                <td style="border: 1px #808080 solid;border-radius: 8px;width: auto">
                    <table style="width: 100%;border-collapse:separate;margin: 0px">
                        <tr>
                            <td style="border: none">
                                <strong>Tipo:</strong>
                                @if ($nota_debito->tipo == 01)
                                    Interes por mora
                                @elseif($nota_debito->tipo == 02)
                                    Aumentos en el valor
                                @else
                                    Penalidade
                                @endif
                            </td>
                            <td style="border: none">
                                <strong>Motivo:</strong>
                                {{ $nota_debito->motivo }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="form-control" style="border: none;height: auto">
            <div align="left">

            </div>
        </div>
        {{-- <br> --}}
        <div class="table-responsive">
            <table class="table " style="border-top: 0px;border-color: #808080">
                <thead style="border-color: #808080">
                    <tr>
                        <th style="width: 8%">Item</th>
                        <th style="width: 15%">Código</th>
                        <th>Descripción</th>
                        <th style="width: 11%">Cantidad</th>
                        <th style="text-align: center;width: 10%">P. Unitario</th>
                        <th style="text-align: center;width: 10%">Total</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    {{-- <span hidden="hidden">{{$u=1}} </span> --}}
                    @foreach ($nota_debito_reg as $e => $nota_deb_reg)
                        <tr>
                            <td>{{ $u++ }}</td>
                            @if (isset($nota_deb_reg->producto_id))
                                <td>{{ $nota_deb_reg->producto->codigo_producto }}</td>
                            @else
                                <td>{{ $nota_deb_reg->servicio->codigo_servicio }}</td>
                            @endif
                            <td>
                                {{ $nota_deb_reg->descripcion }}
                                {{ $doc_reg[$e]->descripcion_item }}
                            </td>
                            <td>{{ $nota_deb_reg->cantidad }}</td>
                            <td>{{ $nota_deb_reg->precio }}</td>
                            <td>{{ $nota_deb_reg->precio * $nota_deb_reg->cantidad }}</td>
                            <td style="display: none">
                                {{ $sub_total = $nota_deb_reg->nota_id->op_gravada + $nota_deb_reg->nota_id->op_inafecta + $nota_deb_reg->nota_id->op_exonerada }}
                                {{ $sub_total_gravado = $nota_deb_reg->nota_id->op_gravada }}
                                {{ $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100 }}
                                {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                {{ $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <table style="width: 100%;border-collapse:collapse;margin-bottom: -10px; border-radius: 8px">
            <tr>
                <td style="width: 70%;border: none">
                    <h3 align="left">
                        <?php
                        use Luecano\NumeroALetras\NumeroALetras;
                        $v = new NumeroALetras();
                        $letra = $v->toInvoice($end, 2);
                        ?>
                        Son : {{ ucfirst(mb_strtolower($letra,'UTF-8')) }}
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
                </td>
                <td class="col-sm-4 qr-container">
                    <div class="qr-box">
                        @if(!empty($qrCode))
                            <img src="{{ $qrCode }}" alt="Código QR" class="qr-image">
                        @else
                            <span class="qr-placeholder">QR</span>
                         @endif
                    </div>
                </td>
                <td style="width: auto;border: 1px #808080 solid;margin-top: 0px;border-right: none;margin-right: 15px;border-collapse:collapse;"
                    align="left">
                    <span> Subtotal:</span><br>
                    <span> Op. Gravada:</span><br>
                    <span> Op. Inafecta:</span><br>
                    <span> Op. Exonerada:</span><br>
                    <span> I.G.V.:</span> <br>
                    <span> Importe Total:</span><br>
                </td>
                <td style="width: auto;border: 1px #808080 solid;border-top-left-radius: 8px 8px 8px 8px;margin-top: 0px;border-left: none;border-collapse:collapse;"
                    align="right">
                    <span>
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
                    </span><br>
                    <span>{{ $simbologia }} {{ number_format($nota_debito->op_gravada, 2) }}</span><br>
                    <span>{{ $simbologia }} {{ number_format($nota_debito->op_inafecta, 2) }}</span><br>
                    <span>{{ $simbologia }} {{ number_format($nota_debito->op_exonerada, 2) }}</span><br>
                    <span>{{ $simbologia }} {{ number_format(round($igv_p, 2), 2) }}</span><br>
                    <span>{{ $simbologia }} {{ number_format($end, 2) }}</span>
                </td>
            </tr>
        </table>
    </div>
</body>
<style>
    * {
        color: #495057;
        font-family: apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"
    }

    .table-bordered .blanco {
        border: none;
    }

    .blanco {
        border: none;
        border-color: #808080;
    }

    .border {
        border-color: #3D3D3D;
        border-width: 1px;
        border-style: solid;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
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
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
        font-weight: bolder;
        font-size: 95px;
        pointer-events: none;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        top: 35%;
        right: 35%;
        z-index: 1000;
    }

    .form-control {
        background-color: transparent !important;
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

</html>
