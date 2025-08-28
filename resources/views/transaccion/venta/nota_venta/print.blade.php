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

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">

    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>

</head>

{{-- LLAMADO AL BODY EN FUNCION CERRAR CON UNA DURACION DE 10 SEGUNDOS --}}

<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    <div class="">
        {{--  --}}
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row" style="align-items: center; justify-content: center">
                            @include('layout_cabecera_ventas')
                            {{-- <div class="col-sm-4 text-left" align="left">

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
                            </div> --}}
                            <div class="col-sm-4">
                                <div class="form-control" align="center" style="height: auto;">
                                    <h3 style="padding-top:10px ">R.U.C {{ $empresa->ruc }}</h3>
                                    <h2 style="font-size: 19px">NOTA DE VENTA</h2>
                                    <h5>{{ $nota_venta->cod_nota_venta }}</h5>
                                </div>
                            </div>
                        </div><br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> &nbsp;{{ $nota_venta->cliente->nombre }}<br>
                                        <strong>{{ $nota_venta->cliente->documento_identificacion }} :</strong>
                                        &nbsp;{{ $nota_venta->cliente->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Fecha:</strong> &nbsp;{{ $nota_venta->created_at }}<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Garantia:</strong> &nbsp;@if (isset($nota_venta->id_cotizacion)) {{ $nota_venta->garantia }}
                                        @else
                                            {{ $nota_venta->garantia }} @if (preg_match('/\d+/', $nota_venta->garantia))
                                                Mes(es)
                                            @endif
                                        @endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Tipo de Moneda:</strong>
                                        &nbsp;{{ $nota_venta->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" align="center">
                                <div class="form-control" style="border: none;height: auto">
                                    <div align="left">
                                        <strong>Observaciones:</strong> &nbsp;{{ $nota_venta->observacion }}<br>
                                    </div>
                                </div>
                            </div>

                        </div><br>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;width: 50px;">ITEM</th>
                                        <th>DESCRIPCIÓN</th>
                                        <th style="text-align:center;width: 70px">CANT.</th>
                                        <th style="text-align:right;width: 110px">P. UNIT.</th>
                                        <th style="text-align:right;width: 110px;">TOTAL <span
                                                hidden="hidden">{{ $simbologia = $nota_venta->moneda->simbolo }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <span hidden>{{ $i = 1 }}{{ $sume = 0 }}</span>
                                <tbody>
                                    @foreach ($nota_venta_re as $nota_venta_reg)
                                        <tr>
                                            <td style="text-align: center">{{ $i++ }} </td>
                                            <td>{{ $nota_venta_reg->producto }}<br>{{ $nota_venta_reg->descripcion }}
                                            </td>
                                            <td style="text-align: center">{{ $nota_venta_reg->cantidad }}</td>
                                            <td style="text-align: right;">{{ $simbologia }}
                                                {{ $nota_venta_reg->precio_nacional }}</td>
                                            <td style="text-align: right;">{{ $simbologia }}
                                                {{ $nota_venta_reg->cantidad * $nota_venta_reg->precio_nacional }}</td>
                                            <span
                                                hidden>{{ $sume = $nota_venta_reg->cantidad * $nota_venta_reg->precio_nacional + $sume }}</span>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- /table-responsive -->

                        <footer style="padding-top: 120px">
                            <h3 align="left">
                                <?php use Luecano\NumeroALetras\NumeroALetras;
                                $v = new NumeroALetras();
                                $letra = $v->toInvoice($sume, 2);
                                ?>
                                Son : {{ ucfirst(mb_strtolower($letra,'UTF-8')) }} {{ $nota_venta->moneda->nombre }}
                            </h3>

                            <div class="row">
                                <div class="col-lg-12" align="right">
                                    <div style="width:20%">
                                        <p class="form-control a"> <strong>Importe Total</strong></p>
                                        <p class="form-control a"> {{ $nota_venta->moneda->simbolo }}
                                            {{ number_format($sume, 2) }}</p>
                                    </div>

                                </div>
                            </div>
                        </footer>

                        <br>
                        @include('layout_bancos')
                        <!-- Fin Totales de Productos -->
                        <br>
                        @include('layout_firma_pie_hoja')
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


{{-- <!-- </div> -->  --}}

<style>
    .form-control {
        margin-top: 5px;
        border-radius: 5px
    }

    p#texto {
        text-align: center;
        color: black;
    }

    input#archivoInput {
        position: absolute;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        width: 100%;
        height: 100%;
        opacity: 0;
    }
</style>
<style type="text/css">
    * {
        color: black;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px;
        border-color: #3D3D3D
    }

    .ibox-tools a {
        color: white !important
    }

    .a {
        height: 37px;
        margin: 0;
        border-radius: 0px;
        text-align: center;
    }

    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
        border-top-width: 0px;
        border-color: #3D3D3D
    }

    p.form-control {
        border-color: #3D3D3D;
    }

    .form-control {
        background-color: transparent !important;
    }

    * {
        color: black;
    }
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
