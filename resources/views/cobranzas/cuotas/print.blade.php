<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>Detalle Cuota - {{ $codigo_cuota }}</title> --}}

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

{{-- <body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)"> --}}

<body class="white-bg">
    <div class=" animated fadeInRight">
        <div class=" animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row">
                            {{-- Cabecera logo y informacion --}}
                            @include('layout_cabecera_ventas')
                            <div class="col-sm-4">
                                <div class="form-control" align="center" style="height: auto;">
                                    <h3 style="padding-top:10px ">R.U.C {{ $empresa->ruc }}</h3>
                                    <h2 style="font-size: 19px">REPORTE DE PAGOS</h2>
                                    <h5>{{ $factura->codigo_fac }} </h5>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> &nbsp;{{ $factura->cliente->nombre }}<br>
                                        <strong>{{ $factura->cliente->documento_identificacion }} :</strong>
                                        &nbsp;{{ $factura->cliente->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Dirección:</strong>&nbsp; {{ $factura->cliente->direccion }}<br>
                                        <strong>N° Contacto:</strong>&nbsp; {{ $factura->cliente->celular }}
                                        @if (isset($factura->cliente->telefono))
                                            / {{ $factura->cliente->telefono }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Forma De Pago:</strong>
                                        &nbsp;{{ $factura->forma_pago->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong>
                                        &nbsp;{{ $factura->created_at }}<br>
                                        <strong>Validez:</strong> &nbsp;{{ $factura->validez }}<br>
                                        <strong>Garantía:</strong>
                                        &nbsp;{{ $factura->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Tipo de Moneda:</strong>
                                        &nbsp;{{ $factura->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" align="center">
                                <div class="" style="border: none;height: auto;margin: 15px 0px">
                                    <div align="left">
                                        <strong>Observaciones:</strong> Emitimos la siguiente informacion <br>
                                    </div>
                                </div>
                            </div>
                            <br>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ITEM</th>
                                                <th>N ° CUOTA</th>
                                                <th>ESTADO</th>
                                                <th>MONTO</th>
                                                <th>MONTO CANCELADO</th>
                                                <th>FECHA DE VENCIMIENTO</th>
                                                <th>METODO DE PAGO</th>
                                                <th>FECHA DE PAGO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fact_cuotas as $index => $fc_cuota)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <th>Cuota N° {{$fc_cuota->numero_cuota}}</th>
                                                    <td>
                                                        @if ($fc_cuota->estado == 0)
                                                            <strong>PENDIENTE</strong>
                                                        @elseif($fc_cuota->estado == 1)
                                                            <strong>PAGADO</strong>
                                                        @else
                                                            <strong>RETRASADO</strong>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $factura->moneda->simbolo }}
                                                        {{ number_format($fc_cuota->monto, 2) }}
                                                    </td>
                                                    <td>
                                                        @if ($fc_cuota->estado == 1)
                                                            {{$pagos_reg->where('id_cuota_credito', $fc_cuota->id )->pluck('monto_pago')->first()}}
                                                        @else
                                                            Sin Pago
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Carbon\Carbon::parse($fc_cuota->fecha_pago)->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($fc_cuota->estado == 0)
                                                            <strong>--- --- ---</strong>
                                                        @else
                                                            <strong>{{ strtoupper($pagos_reg[$index]->comprobante_pago->tipo_pago) }}</strong>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($fc_cuota->estado == 0)
                                                            <strong>--- --- ---</strong>
                                                        @elseif($fc_cuota->estado == 1)
                                                            <strong>{{ Carbon\Carbon::parse($pagos_reg[$index]->fecha_registro)->format('d/m/Y') }}</strong>
                                                        @else
                                                            <strong>RETRASADO</strong>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <footer> --}}
    <div class="">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="" style=" margin-bottom: 20px;padding-bottom: 50px;">
                        <div>
                            <div class="row">
                                <div class="col-sm-8" align="center">
                                    {{-- <div class="form-control">
                                            <h3>Contacto Cliente</h3>
                                            <div align="left">
                                                <strong>Señor(es):</strong>
                                                &nbsp;{{ $factura->cliente->nombre }}<br>
                                                <strong>{{ $factura->cliente->documento_identificacion }}
                                                    :</strong>
                                                &nbsp;{{ $factura->cliente->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                                <strong>Dirección:</strong>&nbsp;
                                                {{ $factura->cliente->direccion }}<br>
                                                <strong>N° Contacto:</strong>&nbsp;
                                                {{ $factura->cliente->celular }}
                                                @if (isset($factura->cliente->telefono))
                                                    / {{ $factura->cliente->telefono }}
                                                @endif
                                            </div>
                                        </div> --}}
                                </div>
                                <div class="col-sm-4" align="center">
                                    <div class="form-control">
                                        <div align="left">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p><strong>Monto Total:</strong></p>
                                                    <p><strong>Monto Deuda:</strong></p>
                                                    <p><strong>Monto Pagado:</strong></p>
                                                </div>
                                                <div>
                                                    
                                                </div>
                                                <div class="col-sm-6">
                                                    <p>{{ $factura->moneda->simbolo }} {{$total = $pagos_reg->sum('monto_pago') }}
                                                    </p>
                                                    <p>{{ $factura->moneda->simbolo }} {{$pagado =  $fact_cuotas->sum('monto') }}
                                                    </p>
                                                    <p>{{ $factura->moneda->simbolo }} {{ $total - $pagado }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">

                                </div>
                            </div>
                        </div>
                        @include('layout_bancos')
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- </footer> --}}
</body>
<style type="text/css">
    .form-control {
        border-radius: 10px;
        height: auto;
        border-color: #3D3D3D
    }

    .ibox-tools a {
        color: white !important
    }

    .a {
        height: 30px;
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

    #watermark {
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 0;
    }

    #watermark p {
        position: absolute;
        color: rgba(120, 120, 120, 0.31);
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
        font-weight: bolder;
        font-size: 95px;
        pointer-events: none;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        top: 35%;
        right: 35%;
        z-index: 0;
    }

    .form-control {
        background-color: transparent !important;
    }

    * {
        color: black;
    }

    p.form-control {
        border-color: #3D3D3D;
    }

    footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 350px;
        /* altura de pie de página */
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
