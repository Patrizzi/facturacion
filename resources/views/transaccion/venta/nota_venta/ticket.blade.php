<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Nota de Venta</title>
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
                <strong><span>Nota de Venta Electronica</span></strong><br>
                <span>{{$nota_venta->codigo_bol}}</span>
            </div>
            <hr>
            <div class="col-lg-12" align="center">
                <span>{{$nota_venta->created_at}}</span><br>
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
                            <td>{{$nota_venta->cliente->nombre}}</td>
                        </tr>
                        <tr>
                            <td>{{$nota_venta->cliente->documento_identificacion}}</td>
                            <td>:</td>
                            <td>{{$nota_venta->cliente->numero_documento}}</td>
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
                    <tbody  > <span hidden><{{$sume = 0}}/span>
                        @foreach ($nota_registro as $item)
                            <tr class="body_table">
                                <td>{{$item->producto}}</td>
                                <td >{{$item->cantidad}}</td>
                                <td class="mont">{{number_format($item->precio_nacional,2)}}</td>
                                <td class="mont">{{number_format($item->precio_nacional* $item->cantidad,2)}}</td>
                                <span hidden>{{$sume=$item->cantidad*$item->precio_nacional+$sume}}</span>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
            <hr>

        <table style="width: 100%">
            <tbody>
                <tr>
                    <td>Importe Total</td>
                    <td>:</td>
                    <td align="right">{{$simbolo  = $moneda->simbolo }}{{$subtotal = number_format($sume,2)}} </td>
                </tr>
            </tbody>
        </table>
        <div class="row" >
            <div class="col-sm-12" align="center">
                <span>Atendido por {{auth()->user()->nombre}}</span><br>
                <span>Autorizado mediante resolucion</span><br>
                <span>N° RS 018-005-0002243/SUNAT</span><br>
                <span>Representación impresa de la</span><br>
                <span>Nota de Venta Electronica</span><br>
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
        
        font-size: 11px;
    } 
    .mont{
        text-align: right;
    }
</style>
    
<script type="text/javascript">
    window.print();
</script>
</html>