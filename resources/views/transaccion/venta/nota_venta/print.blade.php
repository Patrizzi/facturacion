<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nota de Venta- Impresion</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>

</head>

{{-- LLAMADO AL BODY EN FUNCION CERRAR CON UNA DURACION DE 10 SEGUNDOS --}}
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    <div class="wrapper wrapper-content animated fadeInRight">
        {{--  --}}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row">
                            <div class="col-sm-4 text-left" align="left">

                                <address class="col-sm-4" align="left">
                                    <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                                </address>
                            </div>
                            <div class="col-sm-4 text-center" style="font-size: 13px"><br>
                                <strong>{{$empresa->razon_social}}</strong>
                                <br>
                                Tel.: {{$empresa->telefono}} / Móvil: {{$empresa->movil}}
                                <br>
                                {{$empresa->correo}}
                                <br>
                                {{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}} - {{$empresa->pais}}
                            </div>
                            <div class="col-sm-4">
                                <div class="form-control" align="center" style="height: auto;">
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2 style="font-size: 19px">NOTA DE VENTA</h2>
                                    <h5>{{$nota_venta->cod_nota_venta}}</h5>
                                </div>
                            </div>
                        </div><br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> &nbsp;{{$nota_venta->cliente->nombre}}<br>
                                        <strong>{{$nota_venta->cliente->documento_identificacion}} :</strong> &nbsp;{{$nota_venta->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Fecha:</strong> &nbsp;{{$nota_venta->created_at}}<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                               <div class="form-control" >
                                   <h3>Condiciones Generales</h3>
                                   <div align="left">
                                    <strong>Garantia:</strong> &nbsp;{{$nota_venta->garantia }} Mes(es)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <strong>Tipo de Moneda:</strong> &nbsp;{{$nota_venta->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" align="center">
                           <div class="form-control" style="border: none;height: auto" >
                               <div align="left">
                                <strong>observaciones:</strong> &nbsp;{{$nota_venta->observacion }}<br>
                            </div>
                        </div>
                    </div>

                </div><br>
                <div class="table-responsive">
                    <table class="table " >
                        <thead >
                           <tr >
                            <th>ITEM </th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>P.Unitario</th>
                           <th>Total <span hidden="hidden">{{$simbologia=$nota_venta->moneda->simbolo}}</span></th>
                        </tr>
                    </thead>
                    <span hidden>{{$i=1}}{{$sume=0}}</span>
                    <tbody>
                        @foreach($nota_venta_re as $nota_venta_reg)
                        <tr>
                            <td>{{$i++}} </td>
                            <td>{{$nota_venta_reg->producto}}</td>
                            <td>{{$nota_venta_reg->cantidad}}</td>
                            <td>{{$simbologia}} {{$nota_venta_reg->precio_nacional}}</td>
                            <td>{{$simbologia}} {{$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional}}</td>
                            <span hidden>{{$sume=$nota_venta_reg->cantidad*$nota_venta_reg->precio_nacional+$sume}}</span>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div><!-- /table-responsive -->

        <footer style="padding-top: 120px">
         <h3 align="left">
            <?php $v=new CifrasEnLetras() ;
                $letra=($v->convertirEurosEnLetras($sume));
                $letra_final = strstr($letra, 'soles',true);
                $end_final=strstr($sume, '.');
            ?>
            Son : {{$letra_final}} {{$end_final}}/100 {{$nota_venta->moneda->nombre }}
        </h3>

        <div class="row">
            <div class="col-lg-12" align="right">
                <div style="width:20%">
                 <p class="form-control a"> Importe Total</p>
                 <p class="form-control a"> {{$nota_venta->moneda->simbolo}} {{$sume}}</p>
             </div>

         </div>
        </div>
    </footer>

    <br>
    @include('layout_bancos')
    <!-- Fin Totales de Productos -->
        <br>
        <div class="row">
            <div class="col-sm-3">
                <p><u>Centro de Atencion : </u></p>
                Telefono : {{$nota_venta->user->personal->telefono }}<br>
            Celular : {{$nota_venta->user->personal->celular }}<br>
            Email : {{$nota_venta->user->personal->email }}<br>
            Web : {{$empresa->pagina_web}} <br>
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"><br><br>                                
        </div>
        
        {{-- <!-- </div> -->  --}}

        <style>
            .form-control{margin-top: 5px; border-radius: 5px}
            p#texto{
                text-align: center;
                color:black;
            }

            input#archivoInput{
                position:absolute;
                top:0px;
                left:0px;
                right:0px;
                bottom:0px;
                width:100%;
                height:100%;
                opacity: 0  ;
            }
        </style>
        <style type="text/css">
            .form-control{border-radius: 10px; padding: 10px }
            .ibox-tools a{color: white !important}
            .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}

        </style>

        <!-- Mainly scripts -->
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>

        {{-- IMPRIMIR --}}
        <script type="text/javascript">
            window.print();
        </script>
