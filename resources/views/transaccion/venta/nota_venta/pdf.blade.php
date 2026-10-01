<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota de Venta</title>{{--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    {{-- <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet"> --}}
</head>
<style type="text/css">
    .form-control,
    .single-line {
        background-color: #FFFFFF;
        background-image: none;
        border: 0.5px solid #808080;
        border-radius: 1px;
        color: inherit;
        display: block;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        width: 100%;
    }

    @page {
        size: 21cm 29.7cm;
        font-size: 60% !important;
    }
</style>

<body class="white-bg">
    <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
        <tr>
            @include('layout_cabecera_ventas_pdf')
            <td style="width: 30%; ;border: 1px #808080 solid;border-radius: 8px;margin-top: 0px" align="right">
                <center>
                    <h3 style="text-align: center;margin: 0px"> R.U.C {{ $empresa->ruc }}</h3><br>
                    <h2 style="font-size: 19px;text-align: center;margin: 0px">Nota de Venta</h2><br>
                    <h5 style="text-align: center;margin: 0px">{{ $nota_venta->cod_nota_venta }}</h5>
                </center>
            </td>
        </tr>
    </table>
    <div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
        <table style="width: 100%;border-collapse:separate;margin-top: -20px">
            <tr>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                    <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
                    <strong>Señor(es):</strong>&nbsp;{{ $nota_venta->cliente->nombre }}<br>
                    <strong>{{ $nota_venta->cliente->documento_identificacion }}
                        :</strong>&nbsp;{{ $nota_venta->cliente->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <strong>Fecha:</strong>&nbsp;{{ Carbon\Carbon::parse($nota_venta->updated_at)->format('d-m-Y h:i:s') }}<br>
                </td>
                <th style="width: 5%;border-color: white"></th>
                <td colspan="2" style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                    <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center>
                    <br>
                    <strong>Garantia:</strong> &nbsp;@if (isset($nota_venta->id_cotizacion))
                        {{ $nota_venta->garantia }}
                    @else
                        {{ $nota_venta->garantia }} @if (preg_match('/\d+/', $nota_venta->garantia))
                            Mes(es)
                        @endif
                    @endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <strong>Tipo de Moneda:</strong>
                    &nbsp;{{ $nota_venta->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    <strong>Forma de Pago:</strong> 
                    {{ $nota_venta->forma_pago_nombre }}
                </td>
            </tr>
        </table>
        <div class="form-control" style="border: none;height: auto">
            <div align="left">
                <strong>Observaciones:</strong> &nbsp;{{ $nota_venta->observacion }}<br>
            </div>
        </div>
        <br>
        <span hidden="" style="color:white;">{{ $i = 1 }}</span>
        <div class="table-responsive">
            <table class="table " style="border-top: 0px">
                <thead align="left">
                    <tr style="font-weight: bold;border-top-width:  0px ">
                        <th style="text-align: center;width: 8%">ITEM</th>
                        <th>DESCRIPCIÓN</th>
                        <th style="text-align: center;width: 8%">CANT.</th>
                        <th style="text-align: right;width: 14%">P. UNIT.</th>
                        <th style="text-align: right;width: 14%">TOTAL <span
                                hidden="hidden">{{ $simbologia = $nota_venta->moneda->simbolo }}</span></th>
                    </tr>
                </thead>
                <span style="display:none">{{ $i = 1 }}{{ $sume = 0 }}</span>
                <tbody align="left">
                    @foreach ($nota_venta_re as $nota_venta_reg)
                        <tr style="border-bottom-width:   0px white ">
                            <td style="text-align: center;">{{ $i++ }} </td>
                            <td>{{ $nota_venta_reg->producto }}<br>{{ $nota_venta_reg->descripcion }}</td>
                            <td style="text-align: center;">{{ $nota_venta_reg->cantidad }}</td>
                            <td style="text-align: right;">{{ $simbologia }}
                                {{ number_format($nota_venta_reg->precio_nacional, 2) }}</td>
                            <td style="text-align: right;">{{ $simbologia }}
                                {{ number_format($nota_venta_reg->cantidad * $nota_venta_reg->precio_nacional, 2) }}
                            </td>
                            <span
                                style="display:none">{{ $sume = $nota_venta_reg->cantidad * $nota_venta_reg->precio_nacional + $sume }}</span>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <footer style="padding-top: 120px">
            <h3 align="left">
                <?php use Luecano\NumeroALetras\NumeroALetras;
                $v = new NumeroALetras();
                $letra = $v->toInvoice($sume, 2);
                ?>

                Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $nota_venta->moneda->nombre }}
            </h3>

            <table style="border: white 0px solid;text-align: center;">
                <tr style="border: white 0px solid">
                    <td style="border: 1px #3D3D3D none;border-radius: 4px;width: 75%">
                        <br style="height: 2px;">
                    </td>
                    <th style="width: 2%;border-color: white"></th>
                    <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 25%">
                        Importe Total<br style="height: 2px;">
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px #3D3D3D none;border-radius: 4px;width: 75%">
                        <br style="height: 2px;">
                    </td>
                    <th style="width: 2%;border-color: white"></th>
                    <td style="border: 1px #3D3D3D solid;border-radius: 4px;width: 25%">
                        {{ $nota_venta->moneda->simbolo }}{{ number_format($sume, 2) }}<br style="height: 2px;">
                    </td>
                </tr>
            </table>
            <br>

            <!-- Fin Totales de Productos -->

            @include('layout_bancos_pdf')
            <br>
            @include('layout_firma_pie_hoja_pdf')
        </footer>
    </div>
</body>
{{--  --}}
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
</html>
