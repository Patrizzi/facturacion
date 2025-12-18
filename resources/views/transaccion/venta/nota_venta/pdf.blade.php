<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota de Venta</title>{{--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
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
            <td style="width: 30%;border-color: white" rowspan="2" valign="top">
                <center><img align="center" src="{{ asset('img/logos/') }}/{{ $empresa->foto }}"
                        style="margin-top: 0px;" width="80%" /></center>
            </td>
            <td style="width: 30%;border-color: white;text-align: center;margin: 15px 10px" rowspan="2"
                valign="top">
                <strong>{{ $empresa->razon_social }}</strong><br>
                <span style="font-size: 80%">
                    @if ($empresa->telefono != "0")
                        Telef: {{ $empresa->telefono }} /
                    @endif Celular: {{ $empresa->movil }} <br>
                    Correo: {{ $empresa->correo }}<br>
                    Web: {{ $empresa->pagina_web }} <br>
                    {{ $empresa->calle }} - {{ $empresa->ciudad }} - {{ $empresa->region_provincia }} -
                    {{ $empresa->pais }}
                </span>
            </td>
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
                        :</strong>&nbsp;{{ $nota_venta->cliente->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>Fecha:</strong>&nbsp;{{ $nota_venta->created_at }}<br>
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
        font-family: apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        color: black;
    }

    .table-bordered .blanco {
        border: none;
    }

    .blanco {
        border: none;
        border: medium transparent;
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
</style>

</html>
