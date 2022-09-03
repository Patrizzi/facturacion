<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Boleta</title>
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
    <div class="contenedor-impresion-ticket">
        <div class="row">
            <div class="col-lg-12" align="center">
                <strong><span>Boleta Electronica</span></strong><br>
                <span>{{$boleta->codigo_bol}}</span>
            </div>
            <hr>
            <div class="col-lg-12" align="center">
                <span>{{$boleta->created_at}}</span><br>
                <span>{{$empresa->razon_social}}</span><br>
                <span><strong>R.U.C:</strong> {{$empresa->ruc}}</span><br>
                <span>{{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}}</span><br>
                <span>Telefono: {{$empresa->telefono}}</span>
            </div>
            <hr>
            <div class="col-lg-12">
                <table class="table" style="border-color: white;width: 100%">
                    {{-- <tbody> --}}
                        <tr style="border-color: white;width: 100%">
                            <td>Cliente</td>
                            <td>:</td>
                            <td>{{$boleta->cliente->nombre}}</td>
                        </tr>
                        <tr>
                            <td>{{$boleta->cliente->documento_identificacion}}</td>
                            <td>:</td>
                            <td>{{$boleta->cliente->numero_documento}}</td>
                        </tr>
                    {{-- </tbody> --}}
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
                        @foreach ($boleta_registro as $item)
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
                    <td align="right">{{$simbolo  = $moneda->simbolo }}{{$subtotal = number_format($boleta->op_gravada+$boleta->op_inafecta + $boleta->op_exonerada,2)}} </td>
                </tr>
                <tr>
                    <td>Op. Gravada</td>
                    <td>:</td>
                    <td align="right">{{$simbolo}}. {{number_format($boleta->op_gravada,2)}}</td>
                </tr>
                <tr>
                    <td>Op. Inafecta</td>
                    <td>:</td>
                    <td align="right">{{$simbolo}}. {{number_format($boleta->op_inafecta,2)}} </td>
                </tr>
                <tr>
                    <td>Op. Exonerada</td>
                    <td>:</td> 
                    <td align="right">{{$simbolo}}. {{number_format($boleta->op_exonerada,2)}}  </td>
                </tr>
                <tr>
                    <td>I.G.V</td>
                    <td>:</td>
                    <td align="right">{{$simbolo}}. {{$igv = number_format(round($boleta->op_gravada * $igv->igv_total/100,2),2)}}</td>
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
                <span>Boleta de Venta Electronica</span><br>
                <span>Para consultar el documento</span><br>
                <span>Ingrese a:</span><br>
                <span>{{$empresa->pagina_web}}</span><br>
            </div>
        </div>
    </div>
</body>

<style>
    *{ 
        /* margin: 0mm; */
        /* padding: 0mm; */
        /* size: 297mm 70mm landscape;  */
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
</html>