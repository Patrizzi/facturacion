<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización</title>
    <style type="text/css">
        .form-control,
        .single-line {
            background-color: #FFFFFF;
            background-image: none;
            border: 1px solid #3D3D3D;
            border-radius: 10px;
            color: inherit;
            display: block;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
        }

        @page {
            size: A4;
            font-size: 55% !important;
        }
    </style>
</head>

<body class="white-bg">
    <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
        <tr>
            @include('layout_cabecera_ventas_pdf')
            <td style="width: 30%; border: 1px #3D3D3D solid;border-radius: 8px;margin-top: 0px" align="right">
                <center>
                    <h3 style="text-align: center;margin-top: 2px"> R.U.C {{ $empresa->ruc }}</h3>
                    <h2 style="text-align: center;margin: 2px">COTIZACIÓN ELECTRONICA</h2>
                    <h4 style="text-align: center;margin-bottom: 2px">{{ $cotizacion->cod_cotizacion }}</h4>
                </center>
            </td>
        </tr>
    </table>
    <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
        <table style="width: 100%;border-collapse:separate;margin-top: -20px">
            <tr>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                    <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
                    <strong>Nombre o Empresa:</strong>&nbsp;{{ $cotizacion->cliente->nombre }}<br>
                    <strong>{{ $cotizacion->cliente->documento_identificacion }}
                        :</strong>&nbsp;{{ $cotizacion->cliente->numero_documento }}&nbsp;&nbsp;<br>
                    <strong>Dirección:</strong>&nbsp;{{ $cotizacion->cliente->direccion }}<br>
                    <strong>N° Contacto:</strong>&nbsp;{{ $cotizacion->cliente->celular }}
                    @if (isset($cotizacion->cliente->telefono))
                        / {{ $cotizacion->cliente->celular }}
                    @endif
                    <br>
                    {{-- Datos de la renovacion --}}
                    @if ($renovacion && $fecha_vencimiento)
                        <strong>F.
                            Vencimiento:</strong>&nbsp;{{ $fecha_vencimiento->format('d-m-Y') }}&nbsp;&nbsp;&nbsp;&nbsp;
                        <strong>Días restantes:</strong>&nbsp;{{ $dias_restantes_texto }}<br>
                    @endif
                </td>
                <th style="width: 5%;border-color: white"></th>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                    <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center>
                    <br>
                    <strong>Forma de
                        Pago:</strong>&nbsp;{{ $cotizacion->forma_pago->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong>&nbsp;{{ $cotizacion->created_at }}<br>
                    <strong>Validez :</strong> &nbsp;{{ $cotizacion->validez }}<br>
                    <strong>Garantía:</strong>
                    &nbsp;{{ $cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <strong>Tipo de Moneda:</strong>
                    &nbsp;{{ $cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                </td>
            </tr>
        </table>
        <div class="form-control" style="border: none;height: auto">
            <div align="left">
                <strong>Observaciones:</strong> &nbsp;{{ $cotizacion->observacion }}<br>
            </div>
        </div>
        <br>
        <div class="">
            <table class="table " style="border-top: 0px;">
                <thead style="">
                    <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
                        <td style="width: 4% !important;text-align: center">ITEM</td>
                        <td style="width: 13% !important;text-align: center">CÓDIGO</td>
                        <td style="width: 380px !important;">DESCRIPCION</td>
                        <td style="text-align: center;">CANT.</td>
                        <td style="text-align:right;width: 60px;">P. UNIT.</td>
                        <td style="text-align:right;width: 60px;">TOTAL <span
                                hidden="hidden">{{ $simbologia = $cotizacion->moneda->simbolo }}</span></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cotizacion_registro as $cotizacion_registros)
                        <tr style="border-bottom-width:   0px white">
                            <td style="text-align: center">{{ $i++ }} </td>
                            @if (isset($cotizacion_registros->producto_id))
                                <td style="text-align: center">{{ $cotizacion_registros->producto->codigo_producto }}
                                </td>
                                <td style="">{{ $cotizacion_registros->producto->nombre }}
                                    <br><small>{{ $cotizacion_registros->descripcion_item }}</small>
                                </td>
                            @else
                                <td style="text-align: center">{{ $cotizacion_registros->servicio->codigo_servicio }}
                                </td>
                                <td style="">{{ $cotizacion_registros->servicio->nombre }}
                                    <br><small>{{ $cotizacion_registros->descripcion_item }}</small>
                                </td>
                            @endif
                            <td style="text-align: center;">{{ $cotizacion_registros->cantidad }}</td>
                            <td style="text-align: right">
                                {{ number_format($cotizacion_registros->precio_unitario_comi, 2) }}</td>
                            <td style="text-align: right">
                                {{ number_format($cotizacion_registros->cantidad * $cotizacion_registros->precio_unitario_comi, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /table-responsive -->
        <footer style="padding-top: 120px">
            <table style="width: 100%;border-collapse:collapse;margin-bottom: -10px">
                <tr>
                    <td style="width: 70%;border: none">
                        <h3 align="left" style="margin-bottom: 0px;margin-top: 0px">
                            <?php use Luecano\NumeroALetras\NumeroALetras;
                            $v = new NumeroALetras();
                            $letra = $v->toInvoice($end, 2);
                            //  $letra_final = ucfirst(strstr($letra, 'soles',true));
                            //  $end_final_point=strstr($end2, '.', false);
                            //  $end_final=str_replace('.', '',$end_final_point);
                            ?>
                            Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $cotizacion->moneda->nombre }}
                        </h3>
                    </td>
                    <td style="width: auto; ;border: 1px #3D3D3D solid;border-top-right-radius: 8px 0 0 8px;margin-top: 0px;border-right: none;margin-right: 15px;border-collapse:collapse;"
                        align="left">
                        <span> Subtotal:</span>
                        <br>
                        <span> Op. Agravada:</span> <br>
                        <span> Op. Inafecta:</span> <br>
                        <span> Op. Exonerada:</span> <br>
                        <span> I.G.V.:</span> <br>
                        <span> Importe Total:</span> <br>
                    </td>
                    <td style="width: auto; border: 1px #3D3D3D solid;border-top-left-radius: 8px 0 0 8px;margin-top: 0px;border-left: none;border-collapse:collapse;"
                        align="right">
                        <span>{{ $simbologia = $cotizacion->moneda->simbolo }}
                            {{ number_format($sub_total, 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format($cotizacion->op_gravada, 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format($cotizacion->op_inafecta, 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format($cotizacion->op_exonerada, 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format(round($igv_p, 2), 2) }}</span><br>
                        <span>{{ $simbologia }} {{ number_format($end, 2) }}</span><br>
                    </td>
                </tr>
            </table>
        </footer>
        <br>
        @include('layout_bancos_pdf')
        <!-- Fin Totales de Productos -->
        <br>
        @include('layout_firma_pie_hoja_pdf')
    </div>
    <style>
        * {
            color: black;
            font-family: "Oufit", sans-serif;
            color: black
        }

        .cero {
            margin-bottom: 0px;

        }

        .table-bordered .blanco {
            border: none;
        }

        .blanco {
            border: none;
            border-color: #3D3D3D;
        }

        .border {
            border-color: #3D3D3D;
            border-width: 1px;
            border-style: solid;
        }

        .table {
            /* width: 100%;
                max-width: 100%; */
            margin-bottom: 1rem;
            background-color: transparent;
            border-top-width: 0px;

        }

        table {
            border-collapse: collapse;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        table th,
        table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        table .table {
            background-color: #fff;
        }

        table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody+tbody {
            border: 0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-primary,
        .table-primary>th,
        .table-primary>td {
            background-color: #b8daff;
        }

        .table-hover .table-primary:hover {
            background-color: #9fcdff;
        }

        .table-hover .table-primary:hover>td,
        .table-hover .table-primary:hover>th {
            background-color: #9fcdff;
        }

        .table-secondary,
        .table-secondary>th,
        .table-secondary>td {
            background-color: #d6d8db;
        }

        .table-hover .table-secondary:hover {
            background-color: #c8cbcf;
        }

        .table-hover .table-secondary:hover>td,
        .table-hover .table-secondary:hover>th {
            background-color: #c8cbcf;
        }

        .table-success,
        .table-success>th,
        .table-success>td {
            background-color: #c3e6cb;
        }

        .table-hover .table-success:hover {
            background-color: #b1dfbb;
        }

        .table-hover .table-success:hover>td,
        .table-hover .table-success:hover>th {
            background-color: #b1dfbb;
        }

        .table-info,
        .table-info>th,
        .table-info>td {
            background-color: #bee5eb;
        }

        .table-hover .table-info:hover {
            background-color: #abdde5;
        }

        .table-hover .table-info:hover>td,
        .table-hover .table-info:hover>th {
            background-color: #abdde5;
        }

        .table-warning,
        .table-warning>th,
        .table-warning>td {
            background-color: #ffeeba;
        }

        .table-hover .table-warning:hover {
            background-color: #ffe8a1;
        }

        .table-hover .table-warning:hover>td,
        .table-hover .table-warning:hover>th {
            background-color: #ffe8a1;
        }

        .table-danger,
        .table-danger>th,
        .table-danger>td {
            background-color: #f5c6cb;
        }

        .table-hover .table-danger:hover {
            background-color: #f1b0b7;
        }

        .table-hover .table-danger:hover>td,
        .table-hover .table-danger:hover>th {
            background-color: #f1b0b7;
        }

        .table-light,
        .table-light>th,
        .table-light>td {
            background-color: #fdfdfe;
        }

        .table-hover .table-light:hover {
            background-color: #ececf6;
        }

        .table-hover .table-light:hover>td,
        .table-hover .table-light:hover>th {
            background-color: #ececf6;
        }

        .table-dark,
        .table-dark>th,
        .table-dark>td {
            background-color: #c6c8ca;
        }

        .table-hover .table-dark:hover {
            background-color: #b9bbbe;
        }

        .table-hover .table-dark:hover>td,
        .table-hover .table-dark:hover>th {
            background-color: #b9bbbe;
        }

        .table-active,
        .table-active>th,
        .table-active>td {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover>td,
        .table-hover .table-active:hover>th {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table .thead-dark th {
            color: #fff;
            background-color: #212529;
            border-color: #32383e;
        }

        .table .thead-light th {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .table-dark {
            color: #fff;
            background-color: #212529;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th {
            border-color: #32383e;
        }

        .table-dark.table-bordered {
            border: 0;
        }

        .table-dark.table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .table-dark.table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.075);
        }




        .d-table {
            display: table !important;
        }

        .d-table-row {
            display: table-row !important;
        }

        .d-table-cell {
            display: table-cell !important;
        }

        .d-sm-table {
            display: table !important;
        }

        .d-sm-table-row {
            display: table-row !important;
        }

        .d-sm-table-cell {
            display: table-cell !important;
        }

        .d-md-table {
            display: table !important;
        }

        .d-md-table-row {
            display: table-row !important;
        }

        .d-md-table-cell {
            display: table-cell !important;
        }

        .d-lg-table {
            display: table !important;
        }

        .d-lg-table-row {
            display: table-row !important;
        }

        .d-lg-table-cell {
            display: table-cell !important;
        }

        .d-xl-table {
            display: table !important;
        }

        .d-xl-table-row {
            display: table-row !important;
        }

        .d-xl-table-cell {
            display: table-cell !important;
        }

        .d-print-table {
            display: table !important;
        }

        .d-print-table-row {
            display: table-row !important;
        }

        .d-print-table-cell {
            display: table-cell !important;
        }

        .table {
            border-collapse: collapse !important;
        }

        .table td,
        .table th {
            background-color: #fff !important;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6 !important;
        }

        .blockquote-footer {
            display: block;
            font-size: 80%;
            color: #6c757d;
        }

        .blockquote-footer::before {
            content: "\2014 \00A0";
        }
    </style>
</body>

</html>
