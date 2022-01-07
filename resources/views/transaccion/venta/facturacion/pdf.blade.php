<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturacion</title>{{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .form-control, .single-line {
    background-color: #FFFFFF;
    background-image: none;
    border: 1px solid #808080;
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
                     Telefono: {{$empresa->telefono}} / Movil: {{$empresa->movil}} 
                    <br>
                     {{$empresa->correo}}
                     <br>
                      {{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}} - {{$empresa->pais}}
            </td>
            <td style="width: 30%; ;border: 1px #808080 solid;border-radius: 8px;margin-top: 0px" align="right">
                <center>
                    <h3 style="text-align: center;padding-top:15px;margin-bottom: -28px;margin-top: -10px"> R.U.C {{$empresa->ruc}}</h3><br>
                    <h2 style="font-size: 19px;text-align: center;margin-bottom: -28px" >FACTURA ELECTRONICA</h2><br>
                    <h5 style="text-align: center;margin-bottom: -1px" >{{$facturacion->codigo_fac}}</h5>
                </center>
            </td>
        </tr>
    </table>

<div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">

<table style="width: 100%;border-collapse:separate;margin-top: -20px">
    <tr >
        <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">Datos Generales </strong></center><br>
            <strong>Señor(es)</strong>&nbsp;
                @if(isset($facturacion->cliente_id)){{$facturacion->cliente->nombre}}
                @else{{$facturacion->cotizacion->cliente->nombre}}
                @endif<br>
            <strong>R.U.C :</strong>&nbsp;
                @if(isset($facturacion->cliente_id)){{$facturacion->cliente->numero_documento}}
                @else{{$facturacion->cotizacion->cliente->numero_documento}}
                @endif&nbsp;&nbsp;<br>
            <strong>Direccion:</strong>&nbsp;
            @if(isset($facturacion->cliente_id)){{$facturacion->cliente->direccion}}
                @else{{$facturacion->cotizacion->cliente->direccion}}
                @endif<br>
            <strong>Condiciones de Pago:</strong>&nbsp;@if(isset($facturacion->cliente_id)){{$facturacion->forma_pago->nombre }}
                @else{{$facturacion->cotizacion->forma_pago->nombre }}
                @endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Tipo de Moneda:</strong>&nbsp;
                @if(isset($facturacion->cliente_id)){{$facturacion->moneda->nombre }}
                @else{{$facturacion->cotizacion->moneda->nombre }}
                @endif<br>
        </td>
        <th style="width: 5%;border-color: white"></th>
        <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center><br>
            <strong>Orden de Compra:</strong>&nbsp;{{$facturacion->orden_compra}}<br>
            <strong>Guia de Remision:</strong> &nbsp;{{$facturacion->guia_remision}}<br>
            <strong>Fecha de Emision:</strong> &nbsp;{{$facturacion->fecha_emision}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
            <strong>Fecha de Vencimiento:</strong> &nbsp;{{$facturacion->fecha_vencimiento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
        </td>
    </tr>
</table>
<div class="form-control" style="border: none;height: auto" >
    <div align="left">

    </div>
</div>
<br>
@if($facturacion->tipo=="producto")
<div class="table-responsive">
    <table class="table " style="border-top: 0px;border-color: #808080" >
        <thead style="border-color: #808080">
            <tr style="text-align: left;font-weight: bold;border-top-width:  0px;border-color: #808080">
                <td width="10px">ITEM </td>
                <td width="120px" >Codigo Producto</td>
                <td width="60px">Cantidad</td>
                <td width="60px">Unid.Medida</td>
                <td width="300px">Descripción</td>
                {{-- <td width="auto">Valor Unitario</td>
                <td width="auto">Dscto.%</td> --}}
                <td width="auto">Precio Unitario</td>
                <td width="auto" style="text-align: center;">Valor Venta</td>
            </tr>
        </thead>
        <tbody>
            @foreach($facturacion_registro as $facturacion_registros)
            <tr>
                <td>{{$i++}} </td>
                <td>{{$facturacion_registros->producto->codigo_producto}}</td>
                <td>{{$facturacion_registros->cantidad}}</td>
                <td>{{$facturacion_registros->producto->unidad_i_producto->medida}}</td>
                <td>{{$facturacion_registros->producto->nombre}} <br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}</td>
                {{-- <td>{{$facturacion_registros->precio}}</td>
                <td>{{$facturacion_registros->descuento}}%</td> --}}
                <td style="text-align: right;">{{number_format($facturacion_registros->precio_unitario_comi,2)}}</td>
                <td style="text-align: right;">{{number_format($facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad ,2)}}</td>
                <td style="display: none">
                    {{$sub_total=($facturacion->op_gravada)}}
                    {{$sub_total_gravado=($facturacion->op_gravada)+($facturacion->op_inafecta)+($facturacion->op_exonerada)}}
                    {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                    {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table >
</div>
@else
<div class="table-responsive">
    <table class="table " style="border-top: 0px;border-color: #808080" >
        <thead style="">
           <tr style="text-align: ce;font-weight: bold;border-top-width:  0px;border-color: #808080 ">
                <td width="30px">ITEM </td>
                <td width="120px" >Codigo Servicio</td>
                <td width="60px">Cantidad</td>
                <td width="300px">Descripcion</td>
                {{-- <td width="auto">Valor Unitario</td>
                <td width="auto">Dscto.%</td> --}}
                <td width="auto">Precio Unitario</td>
                <td width="auto">Valor Venta</td>
            </tr>
        </thead>
        <tbody>
          @foreach($facturacion_registro as $facturacion_registros)
            <tr>
                <td>{{$i++}} </td>
                <td>{{$facturacion_registros->servicio->codigo_servicio}}</td>
                <td>{{$facturacion_registros->cantidad}}</td>

                <td>{{$facturacion_registros->servicio->nombre}}</td>
                {{-- <td>{{$facturacion_registros->precio}}</td> --}}
                {{-- <td>{{$facturacion_registros->descuento}}%</td> --}}
                <td style="text-align: right;">{{number_format($facturacion_registros->precio_unitario_comi,2)}}</td>
                <td style="text-align: right;">{{number_format($facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad ,2)}}</td>
                <td style="display: none">
                    {{$sub_total_gravado=($facturacion->op_gravada)}}
                    {{$sub_total=($facturacion->op_gravada)+($facturacion->op_exonerada)+($facturacion->op_inafecta)}}
                    {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                    {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div><!-- /table-responsive -->
@endif
<footer style="padding-top: 120px">

<table  style="width: 100%;border-collapse:collapse;margin-bottom: -10px; border-radius: 8px">
     <tr>
         <td style="width: 70%;border: none">
            <h3 align="left">
                <?php $v=new CifrasEnLetras() ;
                $letra=($v->convertirEurosEnLetras($end));
                $letra_final = ucfirst(strstr($letra, 'soles',true));
                $end_final_point=strstr($end2, '.',false);
                $end_final=str_replace('.', '',$end_final_point);
                ?>
                Son : {{$letra_final}} con {{$end_final}}/100 {{$facturacion->moneda->nombre }}
            </h3>
         </td>
         <td   style="width: auto;border: 1px #808080 solid;margin-top: 0px;border-right: none;margin-right: 15px;border-collapse:collapse;" align="left">
            <span > Sub Total:</span><br>
            <span > Op. Agravada:</span><br>
            <span > Op. Inafecta:</span><br>
            <span > Op. Exonerada:</span><br>
            <span > I.G.V.:</span> <br>
            <span > Importe Total:</span><br>
        </td>
        <td   style="width: auto;border: 1px #808080 solid;border-top-left-radius: 8px 8px 8px 8px;margin-top: 0px;border-left: none;border-collapse:collapse;" align="right">
            <span>{{$simbologia=$facturacion->moneda->simbolo}} {{number_format($sub_total, 2)}}</span><br>
            <span>{{$simbologia}} {{number_format($facturacion->op_gravada,2)}}</span><br>
            <span>{{$simbologia}} {{number_format($facturacion->op_inafecta,2)}}</span><br>
            <span>{{$simbologia}} {{number_format($facturacion->op_exonerada,2)}}</span><br>
            <span>{{$simbologia}} {{number_format(round($igv_p, 2),2)}}</span><br>
            <span>{{$simbologia}} {{number_format($end,2)}}</span>
        </td>
     </tr>
</table>
</center>


<br>
<table style="width: 100%;height: 120px;border-collapse:separate;margin-bottom: -10px">
    <tr>
        <td colspan="2" style="border: 1px #808080 solid;border-radius: 8px;width: auto">
            <strong>Observaciones:</strong><br>
            {{$facturacion->observacion}}
        </td>
            
    </tr>


</table>

<!-- Fin Totales de Productos -->
<br>
<table style="border-collapse: separate;">
    <tr>
         <th style="width: 2%;border-color: white"></th>
        @foreach($banco as $bancos)
        @if($banco_count==3)
        <th width="33%" style="border: 1px #808080 solid;border-radius: 8px;">
        @elseif($banco_count==2)
        <th width="50%"style="border: 1px #808080 solid;border-radius: 8px;">
        @elseif($banco_count==1)
        <th width="100%"style="border: 1px #808080 solid;border-radius: 8px;">
        @else
        <th width="20%"style="border: 1px #808080 solid;border-radius: 8px;">
        @endif
        <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="height: 30px;"><br>
          <span style="font-size: 11px"><strong> {{$bancos->tipo_cuenta}}</strong></span>
          <br>
          <span style="font-size: 12px">
          S/: {{$bancos->numero_soles}}
          <br>
          $: {{$bancos->numero_dolares}}<br>
          </span>
         </p>
        </th>
         <th style="width: 2%;border-color: white"></th>
        @endforeach
    </tr>
</table>
<div class="row">
<br>
{{-- <table style="border:  0px solid white">
    <tr style="border:  0px solid white">
        <td>
            <p><u>centro de Atencion : </u></p>
            Usuario : {{$facturacion->user->personal->nombres }}<br>
            Telefono : {{$facturacion->user->personal->telefono }}<br>
            Celular : {{$facturacion->user->personal->celular }}<br>
            Email : {{$facturacion->user->personal->email }}<br>
            Web :{{$empresa->pagina_web}} <br>
        </td>
        <td >
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <hr>
            <center>{{$cotizacion->user_personal->personal->nombres }}</center>
        </td>
    </tr>
</table> --}}
</div>

{{--  --}}
<style>

    *{font-size: 14px;color: #495057;font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}
    .cero{
    margin-bottom: 0px;

    }
     .table-bordered .blanco {
    border: none;
}
    .blanco{border: none;
        border: border-color: #808080 ;
        }
    .border {
        border-color: #808080;
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
