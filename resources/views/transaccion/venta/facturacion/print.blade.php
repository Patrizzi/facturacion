<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Facturación/Print</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- <script src="@yield('vue_js', '#')" defer></script> -->

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>

</head>
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">

   <div class="row">
    <div class="col-lg-12">
        <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
            <div class="row">
                @include('layout_cabecera_ventas')
               <div class="col-sm-4 ">
                <div class="form-control ruc" style="height: 125px">
                    <center>
                        <h3 style="padding-top:10px ">RUC : {{$empresa->ruc}}</h3>
                        <h2>FACTURA ELECTRÓNICA</h2>
                        <h5> {{$facturacion->codigo_fac}}</h5>

                    </center>

                </div>
            </div>
        </div><br>

        <div class="row" align="center" style="padding-bottom: 5px">
            <div class="col-sm-6" align="center">
                <div class="form-control">
                    <!-- <h3> Datos Generales</h3> -->
                    <div align="left">
                        <strong>Cliente:</strong>
                        @if(isset($facturacion->cliente_id)){{$facturacion->cliente->nombre}}
                        @else{{$facturacion->cotizacion->cliente->nombre}}
                        @endif <br>
                        <strong>R.U.C:</strong>
                        @if(isset($facturacion->cliente_id)){{$facturacion->cliente->numero_documento}}
                        @else{{$facturacion->cotizacion->cliente->numero_documento}}
                        @endif <br>
                        <strong>Dirección:</strong>
                        @if(isset($facturacion->cliente_id)){{$facturacion->cliente->direccion}}
                        @else{{$facturacion->cotizacion->cliente->direccion}}
                        @endif <br>
                        <strong>Condiciones de Pago:</strong>
                        @if(isset($facturacion->cliente_id)){{$facturacion->forma_pago->nombre }}
                        @else{{$facturacion->cotizacion->forma_pago->nombre }}
                        @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Tipo de Moneda:</strong>
                        @if(isset($facturacion->cliente_id)){{$facturacion->moneda->nombre }}
                        @else{{$facturacion->cotizacion->moneda->nombre }}
                        @endif <br>

                    </div>
                </div>
            </div>
            <div class="col-sm-6" align="center">
               <div class="form-control" >
                   <!-- <h3>Condiciones Generales</h3> -->
                   <div align="left">
                    <strong>Orden de Compra:</strong>
                    {{$facturacion->orden_compra}} <br>
                    <strong>Guía de Remisión:</strong>
                    {{$facturacion->guia_remision}} <br>
                    <strong>Fecha Emisión:</strong>
                    {{$facturacion->fecha_emision}} <br>
                    <strong>Fecha de Vencimiento:</strong>
                    {{$facturacion->fecha_vencimiento }} <br>

                </div>
            </div>
        </div>
        <div class="col-sm-12" align="center">
           <div class="form-control" style="border: none;height: auto" >
               <div align="left">

               </div>
           </div>
       </div>

   </div>

   <br>
   {{-- Table --}}

   <div class="table-responsive">
    <table class="table ">
        <thead style="font-weight: bold">
            <tr>
                <th style="width: 8%">Item</th>
                <th style="width: 15%">Cod. de Item</th>
                <th>Descripción</th>
                <th style="width: 11%">Cantidad</th>
                <th  style="text-align: center;width: 8%">Pr. Unit.</th>
                <th  style="text-align: center;width: 8%">Total</th>
            </tr>
        </thead>
        <tbody>


            <tr>
                @foreach($facturacion_registro as $facturacion_registros)
                <span hidden="hidden">{{$i=1}} </span>
                <tr>
                    <td>{{$j++}} </td>
                    @if(isset($facturacion_registros->producto))
                    <td>{{$facturacion_registros->producto->codigo_producto}}</td>
                    <td>{{$facturacion_registros->producto->nombre}} {{$facturacion_registros->descripcion_item}} @if(isset($facturacion_registros->numero_serie))<br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}@endif</td>
                    @else
                    <td>{{$facturacion_registros->servicio->codigo_servicio}}</td>
                    <td>{{$facturacion_registros->servicio->nombre}} {{$facturacion_registros->descripcion_item}}
                        @endif
                        <td style="text-align:center;">{{$facturacion_registros->cantidad}}</td>
                        <td  style="text-align:center;">{{number_format($facturacion_registros->precio_unitario_comi,2)}}</td>
                        <td style="text-align:center;" >{{number_format($facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad ,2)}}</td>
                        <td style="display: none">
                            {{$sub_total=($facturacion->op_gravada)+($facturacion->op_inafecta)+($facturacion->op_exonerada)}}
                            {{$sub_total_gravado=($facturacion->op_gravada)}}
                            {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                            {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                            {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                        </td>
                    </tr>
                    <span hidden="hidden">{{$i++}}</span>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    {{-- Table --}}


    <br><br><br><br>

    <div class="row">
        <div class="col-sm-8 ">
            <h3 align="left">
                <?php $v=new CifrasEnLetras() ;
                $letra=($v->convertirEurosEnLetras($end));
                $letra_final = ucfirst(strstr($letra, 'soles',true));
                $end_final_point=strstr($end2, '.',false);
                $end_final=str_replace('.', '',$end_final_point);
            ?>
            Son : {{$letra_final}} con {{$end_final}}/100 {{$facturacion->moneda->nombre }}
        </h3>
    </div>
    <div class="col-sm-4 form-control" >
        <span style="display: block;float: left"> Subtotal:</span>
        <span style="display: block;float: right;">{{$simbologia=$facturacion->moneda->simbolo}} {{number_format($sub_total, 2)}}</span>
        <br>
        <span style="display: block;float: left"> Op. Gravada: </span>
        <span style="display: block;float: right">{{$simbologia}} {{number_format($facturacion->op_gravada,2)}}</span><br>
        <span style="display: block;float: left"> Op. Inafecta: </span>
        <span style="display: block;float: right">{{$simbologia}} {{ number_format($facturacion->op_inafecta,2)}}</span><br>
        <span style="display: block;float: left"> Op. Exonerada: </span>
        <span style="display: block;float: right">{{$simbologia}} {{number_format($facturacion->op_exonerada,2)}} </span><br>
        <span style="display: block;float: left"> I.G.V.: </span>
        <span style="display: block;float: right">{{$facturacion->moneda->simbolo}} {{number_format(round($igv_p, 2),2)}}</span><br>
        <span style="display: block;float: left"> Importe Total: </span>
        <span style="display: block;float: right">{{$facturacion->moneda->simbolo}} {{number_format($end,2)}}</span>
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-12 form-control" style="height:  120px">
        <strong>Observaciones:</strong><br>
        {{$facturacion->observacion}}
    </div>
</div>
<br>
<!-- EXTENSION PARA LLAMAR AL LAYOUT DE BANCOS -->
@include('layout_bancos')

<br>
</div>
</div>

</div>




<style type="text/css">
    .form-control{border-radius: 10px; height: auto; border-color: #808080}
    .ibox-tools a{color: white !important}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;border-color: #808080}
</style>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

{{-- IMPRIMIR --}}
<script type="text/javascript">
    window.print();
</script>
</body>
</html>