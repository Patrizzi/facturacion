<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Factura</title>
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <script LANGUAGE="JavaScript">
        function cerrar() {
            // window.close();
        }
    </script>
    
</head>
<body class="" onLoad="setTimeout('cerrar()',1*1000)">
    <div class="contenedor-impresion-ticket">
        <div class="row">
            <div class="col-lg-12" align="center">
                <strong><span>Facturacion Electronica</span></strong><br>
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
                <table class="table" style="border-color: white">
                    <tbody>
                        <tr style="border-color: white">
                            <td>Cliente</td>
                            <td>:</td>
                            <td>{{$facturacion->cliente->nombre}}</td>
                        </tr>
                        <tr>
                            <td>{{$facturacion->cliente->documento_identificacion}}</td>
                            <td>:</td>
                            <td>{{$facturacion->cliente->numero_documento}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- <div class="col-lg-12">
                <div class="row">
                    <div class="col-sm-4">
                        Cliente <br>
                        {{$facturacion->cliente->documento_identificacion}} <br>
                    </div>
                    <div class="col-sm-2">
                        : <br>
                        : <br>
                    </div>
                    <div class="col-sm-6">
                        {{$facturacion->cliente->nombre}} <br>
                        {{$facturacion->cliente->numero_documento}} <br>
                    </div>
                </div>
            </div> --}}
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
                    <tbody>
                        @foreach ($facturacion_registro as $item)
                            <tr>
                                @if(isset($item->producto_id))
                                    <td >{{$item->producto->nombre}}</td>
                                @else
                                    <td>{{$item->servicio->nombre}}</td>
                                @endif
                                <td>{{$item->cantidad}}</td>
                                <td>{{$item->precio_unitario_comi}}</td>
                                <td>{{$item->precio_unitario_comi* $item->cantidad}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="row" >
            <div class="col-sm-6">
                Subtotal <br>
                Op. Gravada <br>
                Op. Inafecta<br>
                Op. Exonerada<br>
                I.G.V<br>
                Total<br>
            </div>
            <div class="col-sm-2">
                : <br>
                : <br>
                : <br>
                : <br>
                : <br>
                : <br>
            </div>
            <div class="col-sm-4" align="right">
                {{$simbolo  = $moneda->simbolo }}{{$subtotal = number_format($facturacion->op_gravada+$facturacion->op_inafecta + $facturacion->op_exonerada,2)}} <br>
                {{$simbolo}}. {{number_format($facturacion->op_gravada,2)}} <br>
                {{$simbolo}}. {{number_format($facturacion->op_inafecta,2)}} <br>
                {{$simbolo}}. {{number_format($facturacion->op_exonerada,2)}} <br>
                {{$simbolo}}. {{$igv = round($facturacion->op_gravada * $igv->igv_total/100,2)}} <br>
                {{$simbolo}}. {{$total = round($subtotal + $igv,2)}} <br>
            </div>
        </div>
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
        /* size: 297mm 70mm landscape;  */
        font-size: 100%;
        
    }
    html{
        margin: 0mm;
        padding: 0mm;
    }

    table{
        border: none;
    }
</style>
    
<script type="text/javascript">
    window.print();
</script>
</html>