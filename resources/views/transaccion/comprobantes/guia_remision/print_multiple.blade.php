<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Guías de Remisión / Print Multiple</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        /* --- Página y tipografía general (más compacto) --- */
        @page { size: A4; margin: 6mm 6mm; }
        html, body { font-size: 9px; line-height: 1.15; }
        *{ color:#000; }

        /* --- Contenedores --- */
        .ibox-content { padding: 8px 10px !important; margin-bottom: 6px !important; }
        .form-control{
            border-radius: 6px;
            height:auto;
            border-color:#3D3D3D;
            background:transparent!important;
            padding: 3px 5px;
            margin-bottom: 5px;
        }
        .spacer{ height: 4px; }

        /* --- Bloque de RUC/Serie (más pequeño) --- */
        .ruc{ border-radius:8px; height: 78px !important; }
        .ruc h3{ font-size:12px; margin:0; padding:0; }
        .ruc h2{ font-size:13px; margin:1px 0 0; }
        .ruc h5{ font-size:10px; margin:1px 0 0; }

        /* --- Tabla (muy densa) --- */
        .table{ margin-bottom: 4px; table-layout: fixed; }
        .table>thead>tr>th,
        .table>tbody>tr>td{
            border-top-width:0;
            border-color:#3D3D3D;
            padding: 2px 3px !important;
            font-size: 8.5px;
            vertical-align: top;
            word-break: break-word;
        }
        .table thead th{ font-weight:600; }

        /* Columnas más angostas */
        th.col-item{   width: 42px;  text-align:center; }
        th.col-cod{    width: 90px;  text-align:center; }
        th.col-serie{  width: 82px;  text-align:center; }
        th.col-cant{   width: 54px;  text-align:center; }
        th.col-peso{   width: 60px;  text-align:center; }

        /* Observaciones / totales */
        .obs{ min-height: 0 !important; }
        .totales{ padding: 5px; }
        .bank-block{ margin-top: 4px; }

        /* En impresión, aún más compacto si hace falta */
        @media print{
            .bank-block{ display:none; }               /* oculta cuentas bancarias para ganar espacio */
            body{ zoom: 0.85; }                        /* escala global (Chrome/Edge) */
            .page-break{ page-break-before: always; }
        }
    </style>

    <script>
        function cerrar(){ window.close(); }
    </script>
</head>
<body class="white-bg" onload="setTimeout(cerrar,1000)">

@foreach($guiasData as $idx => $pack)
    @php
        /** @var \App\Guia_remision $guia */
        $guia      = $pack['guia'];
        $registros = $pack['registros'];
        $j = 1;
        $pesoTotal = $registros->sum(function($r){
            return (float)($r->peso ?? 0) * (float)($r->cantidad ?? 0);
        });
    @endphp

    <div class="row" @if($idx>0) style="page-break-before: always" @endif>
        <div class="col-lg-12">
            <div class="ibox-content">

                <div class="row" style="align-items:center;justify-content:center">
                    {{-- Cabecera corporativa --}}
                    @include('layout_cabecera_ventas')

                    <div class="col-sm-4">
                        <div class="form-control ruc">
                            <center>
                                <h3 style="padding-top:4px">RUC: {{ $empresa->ruc }}</h3>
                                <h2>GUÍA DE REMISIÓN</h2>
                                <h5>{{ $guia->cod_guia }}</h5>
                            </center>
                        </div>
                    </div>
                </div>

                <div class="spacer"></div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-control">
                            <strong>Cliente:</strong> {{ optional($guia->cliente)->nombre }} <br>
                            <strong>RUC/DNI:</strong> {{ optional($guia->cliente)->numero_documento }} <br>
                            <strong>Dirección destino:</strong>
                            {{ $guia->sucursal_cliente ?: optional($guia->cliente)->direccion }} <br>
                            <strong>Cód. Postal:</strong> {{ $guia->cod_postal_cliente }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-control">
                            <strong>Fecha Emisión:</strong> {{ $guia->fecha_emision }} <br>
                            <strong>Fecha Entrega:</strong> {{ $guia->fecha_entrega }} <br>
                            <strong>Motivo traslado:</strong> {{ $guia->motivo_traslado }} <br>
                            <strong>Transporte:</strong>
                            @php
                                $map = [0=>'Sin transporte',1=>'Público',2=>'Privado'];
                                $t = $map[$guia->tipo_transporte] ?? $guia->tipo_transporte;
                            @endphp
                            {{ $t }}
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-control" style="border:none;height:auto"></div>
                    </div>
                </div>

                @if($guia->tipo_transporte==1 && $guia->vehiculo_publico)
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-control">
                                <strong>Transporte público:</strong> {{ $guia->vehiculo_publico }}
                            </div>
                        </div>
                    </div>
                @elseif($guia->tipo_transporte==2)
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-control">
                                <strong>Vehículo (placa):</strong> {{ optional($guia->vehiculo)->placa }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-control">
                                @php
                                    $conductor = optional($guia->personal);
                                    $nombreConductor = trim(($conductor->nombres ?? '').' '.($conductor->apellidos ?? ''));
                                @endphp
                                <strong>Conductor:</strong> {{ $nombreConductor ?: '-' }}
                            </div>
                        </div>
                    </div>
                @endif

                <div class="spacer"></div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="col-item">ITEM</th>
                            <th class="col-cod">CÓDIGO</th>
                            <th>DESCRIPCIÓN</th>
                            <th class="col-serie">SERIE</th>
                            <th class="col-cant">CANT.</th>
                            <th class="col-peso">PESO</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($registros as $r)
                            <tr>
                                <td style="text-align:center">{{ $j++ }}</td>
                                @if($r->producto)
                                    <td style="text-align:center">{{ $r->producto->codigo_producto }}</td>
                                    <td>
                                        {{ $r->producto->nombre }}
                                        @if($r->descripcion) - {{ $r->descripcion }} @endif
                                    </td>
                                @else
                                    <td style="text-align:center">-</td>
                                    <td>{{ $r->descripcion }}</td>
                                @endif
                                <td style="text-align:center">{{ $r->numero_serie }}</td>
                                <td style="text-align:center">{{ $r->cantidad }}</td>
                                <td style="text-align:center">{{ number_format((float)($r->peso ?? 0), 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="spacer"></div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-control obs">
                            <strong>Observaciones:</strong><br>
                            {{ $guia->observacion }}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-control totales">
                            <span style="display:block;float:left">Ítems:</span>
                            <span style="display:block;float:right">{{ $registros->count() }}</span><br>
                            <span style="display:block;float:left">Peso total (ref.):</span>
                            <span style="display:block;float:right">{{ number_format($pesoTotal,2) }}</span>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </div>

                {{-- Opcional: bancos (oculto al imprimir por CSS) --}}
                <div class="bank-block">
                    @include('layout_bancos')
                </div>

            </div>
        </div>
    </div>
@endforeach

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script> window.print(); </script>
</body>
</html>
