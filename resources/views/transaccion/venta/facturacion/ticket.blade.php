<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Factura</title>
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <script LANGUAGE="JavaScript">
        function cerrar() {
            // window.close();
        }
    </script>

</head>
<body class="" onLoad="setTimeout('cerrar()',1*1000)">
{{--


<div class="contenedor-impresion-ticket">
    <div class="row">
        <div class="col-lg-12" align="center">
            <strong><span>Factura Electronica</span></strong><br>
            <span>{{$facturacion->codigo_fac}}</span>
        </div>
        <hr>
        <div class="col-lg-12" align="center">
            <span>{{$facturacion->created_at}}</span><br>
            <span>{{$empresa->razon_social}}</span><br>
            <span><strong>R.U.C:</strong> {{$empresa->ruc}}</span><br>
            <span>{{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}}</span><br>
            <span>Telefono: {{$empresa->telefono}}</span>
        </div>
        <hr>
        <div class="col-lg-12">
            <table class="table" style="border-color: white;width: 100%">

                    <tr style="border-color: white;width: 100%">
                        <td>Cliente</td>
                        <td>:</td>
                        <td>{{$facturacion->cliente->nombre}}</td>
                    </tr>
                    <tr>
                        <td>{{$facturacion->cliente->documento_identificacion}}</td>
                        <td>:</td>
                        <td>{{$facturacion->cliente->numero_documento}}</td>
                    </tr>

            </table>
        </div>

        <hr>
        <div class="col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 40%">Articulo</th>
                        <th style="width: 14%">Cant.</th>
                        <th style="width: 24%">P. Unit</th>
                        <th style="width: 22%">Total</th>
                    </tr>
                </thead>
                <tbody  >
                    @foreach ($facturacion_registro as $item)
                        <tr class="body_table">
                            @if(isset($item->producto_id))
                                <td>{{$item->producto->nombre}}</td>
                            @else
                                <td>{{$item->servicio->nombre}}</td>
                            @endif
                            <td >{{$item->cantidad}}</td>
                            <td class="mont">{{number_format($item->precio_unitario_comi,2)}}</td>
                            <td class="mont">{{number_format($item->precio_unitario_comi* $item->cantidad,2)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>Subtotal</td>
                <td>:</td>
                <td align="right">{{$simbolo  = $moneda->simbolo }}{{$subtotal = number_format($facturacion->op_gravada+$facturacion->op_inafecta + $facturacion->op_exonerada,2)}} </td>
            </tr>
            <tr>
                <td>Op. Gravada</td>
                <td>:</td>
                <td align="right">{{$simbolo}}. {{number_format($facturacion->op_gravada,2)}}</td>
            </tr>
            <tr>
                <td>Op. Inafecta</td>
                <td>:</td>
                <td align="right">{{$simbolo}}. {{number_format($facturacion->op_inafecta,2)}} </td>
            </tr>
            <tr>
                <td>Op. Exonerada</td>
                <td>:</td>
                <td align="right">{{$simbolo}}. {{number_format($facturacion->op_exonerada,2)}}  </td>
            </tr>
            <tr>
                <td>I.G.V</td>
                <td>:</td>
                <td align="right">{{$simbolo}}. {{$igv = number_format(round($facturacion->op_gravada * $igv->igv_total/100,2),2)}}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>:</td>
                <td align="right">{{$simbolo}}. {{$total = number_format(round($subtotal + $igv,2),2)}}</td>
            </tr>
        </tbody>
    </table>
    <div class="row" >
        <div class="col-sm-12" align="center">
            <span>Atendido por {{auth()->user()->nombre}}</span><br>
            <span>Autorizado mediante resolucion</span><br>
            <span>N° RS 018-005-0002243/SUNAT</span><br>
            <span>Representación impresa de la</span><br>
            <span>Factura de Venta Electronica</span><br>
            <span>Para consultar el documento</span><br>
            <span>Ingrese a:</span><br>
            <span>{{$empresa->pagina_web}}</span><br>
        </div>
    </div>
</div>
</body>

<style>
*{
    margin: 0mm;
    padding: 0mm;

    font-size: 13px;

}
html{
    margin: 0mm;
    padding: 0mm;
}

table{
    border: none;
}
.body_table > td{

    font-size: 12px;
}
.mont{
    text-align: right;
}
</style>

<script type="text/javascript">
window.print();
</script>
--}}

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Factura Electrónica</title>
<style>
    /* Estilos Generales */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        padding: 20px;
        color: #111;
    }

    /* Contenedor principal del ticket */
    .ticket {
        background-color: #fff;
        width: 340px;
        padding: 20px 25px;
        border-radius: 5px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Cajas con bordes redondeados y sombra sutil */
    .box-outline {
        border: 1.5px solid #111;
        border-radius: 8px;
        box-shadow: 2px 2px 0px rgba(0,0,0,0.15);
    }

    .header-box {
        text-align: center;
        padding: 12px;
        margin-bottom: 15px;
    }

    .header-box h1 {
        font-size: 20px;
        margin: 0;
        font-weight: normal;
        line-height: 1.3;
    }

    /* Separadores */
    hr {
        border: none;
        border-top: 1.5px solid #111;
        margin: 12px 0;
    }

    /* Tipografía y utilidades */
    p {
        margin: 4px 0;
        font-size: 13px;
    }

    .bold {
        font-weight: 700;
    }

    .flex-row {
        display: flex;
        justify-content: space-between;
    }

    /* Sección de Detalles */
    .details-header {
        text-align: center;
        padding: 6px;
        font-size: 14px;
        font-weight: bold;
        margin: 15px 0 5px 0;
        background-color: #fafafa;
    }

    .details-body {
        padding: 15px 10px;
        margin-bottom: 15px;
    }

    .item {
        text-align: center;
        margin-bottom: 12px;
        font-size: 12px;
    }

    .item:last-child {
        margin-bottom: 0;
    }

    .item-title {
        font-weight: 700;
        margin-bottom: 2px;
        font-size: 11.5px;
    }

    /* Sección de Totales */
    .totals-section {
        font-size: 12px;
    }

    .totals-section .flex-row {
        margin-bottom: 4px;
    }

    .total-venta {
        font-weight: 700;
        margin-top: 6px;
    }

    .amount-words {
        text-align: center;
        font-size: 14px;
        margin: 15px 0 5px 0;
    }

    /* Footer y QR */
    .footer-text {
        text-align: center;
        font-size: 12px;
        margin-top: 10px;
    }

    .qr-container {
        text-align: center;
        margin-top: 15px;
    }

    .qr-container img {
        width: 130px;
        height: 130px;
        border: 2px solid #111;
        border-radius: 8px;
        padding: 4px;
    }
</style>
</head>
<body>

<div class="ticket">
    <div class="header-box box-outline">
        <h1>Factura Electronica<br>{{ $facturacion->codigo_fac }}</h1>
    </div>

    <hr>

    <div class="info-section">
        <p><span class="bold">CLIENTE: {{ $facturacion->cliente->nombre }} </span> </p>
        <p><span class="bold">{{ $facturacion->cliente->documento_identificacion }}:</span> {{ $facturacion->cliente->numero_documento }}</p>
        <p><span class="bold">FECHA DE EMISION:</span> {{ $facturacion->created_at }}</p>
        <p><span class="bold">FECHA DE FINALIZACION:</span> {{ $facturacion->fecha_vencimiento }}</p>
    </div>

    <hr>

    <div class="flex-row">
        <p><span class="bold">Forma de pago :</span> {{ $facturacion->forma_pago->nombre }}</p>
        <p><span class="bold">Moneda:</span> {{ $facturacion->moneda->nombre }}</p>
    </div>

    <div class="details-header box-outline">
        DETALLE DE COMPRA
    </div>

    <div class="details-body box-outline">
        {{ foreach ($facturacion_registro as $registro) {

            <div class="item">
                <div class="item-title">{$registro->producto_id->name}</div>
                <div> {{ $registro->cantidad }} UND. | <span class="bold">Precio: </span> {{ $facturacion->moneda->simbolo, numberformat($registro->precio,2)  }} | <span class="bold">Importe:</span> S/ {{ numberformat($registro->precio_unitario_comi * $registro->cantidad),2  }}</div>
            </div>
        } }}

    </div>

    <hr>

    <div class="totals-section">
        <div class="flex-row"><span>OP. GRAVADAS</span><span>{{ $simbolo }}, {{$operacion_gravada = number_format($facturacion->op_gravada,2)}}</span></div>
        <div class="flex-row"><span>OP. GRATUITAS</span><span>{{ $simbolo }}, {{ $operacion_gratuita = number_format($facturacion->op_gratuita,2) }}</span></div>
        <div class="flex-row"><span>OP. EXONERADAS</span><span>{{ $simbolo }}, {{$operacion_exonerada = number_format($facturacion->op_exonerada,2) }}</span></div>
        <div class="flex-row"><span>OP. INAFECTADAS</span><span>{{ $simbolo }}, {{$operacion_infectada = number_format($facturacion->op_inafectada,2) }}</span></div>
        <div class="flex-row"><span>I.G.V</span><span>{{ $simbolo }}, {{ $igv = number_format(round($facturacion->op_gravada * $igv->igv_total/100,2),2)  }}</span></div>
        <div class="flex-row"><span>SUBTOTAL</span><span>{{ $simbolo }}, {{$subtotal = number_format($operacion_gravada+$operacion_inafectada+$operacion_inafectada+$operacion_exonerada)  }}</span></div>
        <div class="flex-row total-venta"><span>TOTAL VENTA</span><span>{{ $simbolo }}, {{ $igv+$subtotal }} </span></div>
    </div>

    <div class="amount-words">
        DOS 40/100 PEN
    </div>

    <hr>

    <div>
        <p><span class="bold">VENDEDOR(A):</span> DYLAN</p>
    </div>

    <hr>

    <div class="footer-text">
        <p>Representacion impresa de la factura electronica.<br>Gracias por su preferencia.</p>
    </div>

    <div class="qr-container">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Factura+F002-00003848" alt="Código QR">
    </div>
</div>
<script type="text/javascript">
window.print();
</script>

</body>
</html>
</html>
