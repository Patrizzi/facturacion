<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket Factura</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
</head>
<body >
    <div class="contenedor-impresion-ticket">
        <div class="row">
            <div class="col-lg-12" align="center">
                <span>Facturacion Electronica</span><br>
                <span>{{$facturacion->codigo_fac}}</span>
            </div>
            <hr st>
            <div class="col-lg-12" align="center">
                <span>{{$facturacion->created_at}}</span><br>
                <span>{{$empresa->razon_social}}</span><br>
                <span><strong>R.U.C:</strong> {{$empresa->ruc}}</span><br>
                <span>{{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}}</span><br>
                <span>Telefono: {{$empresa->telefono}}</span>
            </div>
            <hr>
            <div class="col-lg12">
                
            </div>
        </div>
    </div>
</body>
<style>
    .contenedor-impresion-ticket{
        width: 260px;
        max-width: 260px;
    }
</style>
</html>