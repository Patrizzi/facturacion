<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta/PDF</title>{{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .form-control, .single-line {
        background-color: #FFFFFF;
        background-image: none;
        border: 1px solid #e5e6e7;
        border-radius: 1px;
        color: inherit;
        display: block;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        width: 100%;
    }
    @page { size: 420mm 297mm landscape; }
</style>
<body class="white-bg">
{{-- <div class="ibox" style=" margin-bottom:0px; width: 100%">
    <div class="table-responsive" >

        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:200px;height: 50px ;margin-top: 5px">
    </div>
</div> --}}
<table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
    <tr>
        <td style="width: 30%;border-color: white" rowspan="2" valign="top">
            <img align="" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="margin-top: 0px;" width="300px" />
            <br>
        </td>
        <td style="width: 40%;border-color: white;text-align: center;" rowspan="2" valign="top" >
         <strong>{{$empresa->razon_social}}</strong>
         <br>
         Telefono: {{$empresa->telefono}} / Móvil: {{$empresa->movil}}
         <br>
         {{$empresa->correo}}
         <br>
         {{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}} - {{$empresa->pais}}
     </td>
     <td style="width: 30%; ;border: 1px #e5e6e7 solid;border-radius: 8px;margin-top: 0px" align="right">
        <center>
            <h3 style="text-align: center;padding-top:10px;margin-bottom: -28px;margin-top: -10px"> R.U.C {{$empresa->ruc}}</h3><br>
            <h2 style="font-size: 19px;text-align: center;margin-bottom: -28px" >BOLETA ELECTRÓNICA</h2><br>
            <h5 style="text-align: center;margin-bottom: -5px" >{{$boleta->codigo_boleta}}</h5>
        </center>
    </td>
</tr>
</table>

<div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">

    <table style="width: 100%;border-collapse:separate;margin-top: -20px">
        <tr >
            <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto;height:auto;" >
                <center><strong style="align-content: center;margin: 5px">Datos Generales </strong></center><br>
                <strong>Señor(es)</strong>&nbsp;
                @if(isset($boleta->cliente_id)){{$boleta->cliente->nombre}}
                @else{{$boleta->cotizacion->cliente->nombre}}
                @endif<br>
                <strong>N° de Documento:</strong>&nbsp;
                @if(isset($boleta->cliente_id)){{$boleta->cliente->numero_documento}}
                @else{{$boleta->cotizacion->cliente->numero_documento}}
                @endif&nbsp;&nbsp;<br>
                <strong>Dirección:</strong>&nbsp;
                @if(isset($boleta->cliente_id)){{$boleta->cliente->direccion}}
                @else{{$boleta->cotizacion->cliente->direccion}}
                @endif<br>
                <strong>Condiciones de Pago:</strong>&nbsp;@if(isset($boleta->cliente_id)){{$boleta->forma_pago->nombre }}
                @else{{$boleta->cotizacion->forma_pago->nombre }}
                @endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Tipo de Moneda:</strong>&nbsp;
                @if(isset($boleta->cliente_id)){{$boleta->moneda->nombre }}
                @else{{$boleta->cotizacion->moneda->nombre }}
                @endif<br>
            </td>
            <th style="width: 5%;border-color: white"></th>
            <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto">
                <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center><br>
                <strong>Orden de Compra:</strong>&nbsp;{{$boleta->orden_compra}}<br>
                <strong>Guía de Remisión:</strong> &nbsp;{{$boleta->guia_remision}}<br>
                <strong>Fecha de Emisión:</strong> &nbsp;{{$boleta->fecha_emision}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                <strong>Fecha de Vencimiento:</strong> &nbsp;{{$boleta->fecha_vencimiento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
            </td>
        </tr>
    </table>
    <div class="form-control" style="border: none;height: auto" >
        <div align="left">

        </div>
    </div>
    <br>
   <div class="table-responsive">
    <table class="table " style="border-top: 0px" >
        <thead style="">
           <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
            <td width="30px">Item</td>
            <td width="110px" >Código de Item</td>
            <td >Descripción</td>
            <td width="50px">Cantidad</td>
            <td width="50px">P.Unit.</td>
            <td width="50px">Total</td>
        </tr>
    </thead>
        <tbody>
            @foreach($boleta_registro as $boleta_registros)

            <tr style="border-bottom-width:   0px white ;font-size: 10px">
                <td>{{$i++}} </td>
               @if(isset($boleta_registros->producto))
                    <td>{{$boleta_registros->producto->codigo_producto}}</td>
                    {{-- <td>{{$boleta_registros->producto->unidad_i_producto->medida}}</td> --}}
                    <td>{{$boleta_registros->producto->nombre}} {{$boleta_registros->descripcion_item}}@if(isset($boleta_registros->numero_serie)) <br><strong>N/S:</strong> {{$boleta_registros->numero_serie}}@endif</td>
                @else
                    <td>{{$boleta_registros->servicio->codigo_servicio}}</td>
                    {{-- <td>{{$boleta_registros->producto->unidad_i_producto->medida}}</td> --}}
                    <td>{{$boleta_registros->servicio->nombre}} {{$boleta_registros->descripcion_item}}@if(isset($boleta_registros->numero_serie)) <br><strong>N/S:</strong> {{$boleta_registros->numero_serie}}@endif</td>
                @endif
                <td>{{$boleta_registros->cantidad}}</td>
                <td style="text-align: right;">{{number_format($boleta_registros->precio_unitario_comi,2)}}</td>
                <td style="text-align: right;">{{number_format($boleta_registros->precio_unitario_comi * $boleta_registros->cantidad ,2)}}</td>
                <td style="display: none">{{$sub_total=($boleta->op_gravada)}}
                    S/.{{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</tbody>
</table>
</div><!-- /table-responsive -->
<footer style="padding-top: 120px">

    <table style="border: white 0px solid;text-align: center;border-radius: 4px;" >
        <tr style="border: white 0px solid;border-radius: 4px;" >
            <td style="width: 90%;border-color: white">
                
            </td>
            {{-- <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 15%;text-align: left;border-right:none;border-bottom: none">
                Subtotal <br style="height: 2px;">
            </td>
            <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 15%;text-align: right;border-left: none;border-bottom: none">
             {{$simbologia= $boleta->moneda->simbolo}} {{round($sub_total, 2)}}
         </td> --}}
    </tr>

    <tr style="border: white 0px solid" >
        <td style="width: 80%;border-color: white"></td>
        <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 15%;text-align: left;border-right:  none;">
            <strong>Importe Total</strong>
        </td>
        {{-- <th style="width: 2%;border-color: white"></th> --}}
        <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 15%;text-align: right;border-left: none;">
             {{$simbologia= $boleta->moneda->simbolo}} {{round($sub_total, 2)}}
        </td>
        
    </td>
</tr>
</table>
</center>


<br>

<!-- Fin Totales de Productos -->
<table style="width: 100%;height: 120px;border-collapse:separate;margin-bottom: -10px">
    <tr>
        <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
            <strong>Observaciones:</strong><br>
            {{$boleta->observacion}}
        </td>

    </tr>


</table>

<br>
@include('layout_bancos_pdf')
  <div class="row">
    <br>
</div>

{{--  --}}
<style>

    *{font-size: 13px;color: #495057;font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}
    .cero{
        margin-bottom: 0px;

    }
    .table-bordered .blanco {
        border: none;
    }
    .blanco{border: none;
        border: medium transparent;
    }
    .border {
        border-color: #aaaaaa;
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
