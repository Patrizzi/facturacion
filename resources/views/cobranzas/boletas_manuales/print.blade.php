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
                                    <h5>{{ $boleta->codigo_boleta }} </h5>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> {{ $boleta->cliente->nombre }}<br>
                                        <strong>{{ $boleta->cliente->documento_identificacion }} :</strong>
                                        {{ $boleta->cliente->numero_documento }}<br>
                                        <strong>Dirección:</strong> {{ $boleta->cliente->direccion }}<br>
                                        <strong>N° Contacto:</strong> {{ $boleta->cliente->celular }}
                                        @if (isset($boleta->cliente->telefono))
                                            / {{ $boleta->cliente->telefono }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Forma De Pago: </strong>{{ $boleta->forma_pago->nombre }}<br>
                                        <strong>Fecha: </strong> {{ Carbon\Carbon::parse($boleta->created_at)->format('d-m-Y h:m:s') }}<br>
                                        <strong> </strong>
                                        <strong>Tipo de Moneda:</strong>
                                        {{ $boleta->moneda->nombre }}<br>
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
                                @if ($boleta->forma_pago_id == 2)
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
                                                @foreach ($bol_cuotas as $index => $fc_cuota)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>Cuota N° {{ $fc_cuota->numero_cuota }}</td>
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
                                                            {{ $boleta->moneda->simbolo }}
                                                            {{ number_format($fc_cuota->monto, 2) }}
                                                        </td>
                                                        <td>
                                                            @if ($fc_cuota->estado == 1)
                                                                {{ $boleta->moneda->simbolo }}
                                                                {{ number_format((float) $pagos_reg->where('id_cuota_credito', $fc_cuota->id)->pluck('monto_pago')->first(),2) }}
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
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Codigo de Pago</th>
                                                    <th>Estado</th>
                                                    <th>Monto</th>
                                                    <th>Monto Cancelado</th>
                                                    <th>Fecha de Vencimiento</th>
                                                    <th>Metodo de Pago</th>
                                                    <th>Fecha de Pago</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- {{$boleta}} --}}
                                                {{-- @foreach ($empresa as $index => $item) --}}
                                                    <span hidden>{{$subtotal = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada }}</span>
                                                    <tr>
                                                       <td>1</td> 
                                                       <td>N° de Cuota 1</td> 
                                                        <td>
                                                            @if ($boleta->estado_pago == 2)
                                                                <strong>PAGADA</strong>
                                                            @else
                                                                <strong>SIN PAGAR</strong>
                                                            @endif
                                                        </td> 
                                                        <td>
                                                            {{$boleta->moneda->simbolo}} {{number_format(round(($subtotal+($boleta->op_gravada*$igv->renta/100)),2),2)}}
                                                        </td>
                                                        <td>
                                                            @if ($boleta->estado_pago == 2)
                                                                {{$boleta->moneda->simbolo}} {{$pagos_reg[0]->comprobante_pago->monto_pago}}
                                                            @else
                                                                {{$boleta->moneda->simbolo}} 0.00
                                                            @endif
                                                        </td>
                                                        
                                                       <td>
                                                            {{Carbon\Carbon::parse($boleta->fecha_vencimiento)->format('d-m-Y')}}
                                                        </td>
                                                       
                                                        @if ($boleta->estado_pago == 2)
                                                            <td>
                                                                {{ucfirst($pagos[0]->tipo_pago)}}
                                                            </td>
                                                            <td>{{Carbon\Carbon::parse($boleta->fecha_registro)->format('d-m-Y')}}</td>
                                                        @else
                                                            <td>
                                                                <i>Aun no ha sido Cancelado</i>
                                                            </td>
                                                            <td>
                                                                <i>Aun no ha sido Cancelado</i>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                {{-- @endforeach --}}
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
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
                                </div>
                                <div class="col-sm-4" align="center">
                                    <div class="form-control">
                                        <div align="left">
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <p><strong>Monto Total de Deuda:</strong></p>
                                                    <p><strong>Monto Pagado:</strong></p>
                                                    <p><strong>Monto Total Deuda:</strong></p>
                                                </div>
                                                <div style="display: none">
                                                    @if ($boleta->forma_pago_id == 2)
                                                        {{$total = $pagos_reg->sum('monto_pago') }}
                                                        {{$pagado =  $bol_cuotas->sum('monto') }}
                                                        {{$all_tot = $pagado - $total }}
                                                    @else
                                                        @if ($boleta->estado_pago == 0)
                                                            
                                                            {{$pagado = round(($subtotal+($boleta->op_gravada*$igv->renta/100)),2) }}
                                                            {{$total =  0}}
                                                        @else
                                                            {{$total = floatval($pagos[0]->monto_pago) }}
                                                            {{$pagado =  floatval($pagos[0]->monto_pago) }}
                                                        @endif
                                                        {{$all_tot = $pagado - $total }}
                                                    @endif
                                                </div>
                                                <div class="col-sm-5">
                                                    <p>{{ $boleta->moneda->simbolo }} {{number_format($pagado ,2) }}
                                                    </p>
                                                    <p>{{ $boleta->moneda->simbolo }} {{number_format($total , 2) }}
                                                    </p>
                                                    <p>{{ $boleta->moneda->simbolo }} {{ number_format($all_tot,2)}}
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
        font-size: 95px !important;
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
