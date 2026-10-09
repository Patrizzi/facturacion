<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Informe Técnico/Print</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

    <script language="JavaScript">
        function cerrar() {
            window.close();
        }
    </script>

    <style>
        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
            }

            .avoid-break {
                page-break-inside: avoid;
            }
        }

        * {
            color: black !important;
        }

        .form-control {
            border-radius: 10px;
            height: auto;
            border-color: #3D3D3D !important;
            background-color: transparent !important;
        }

        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            border-top-width: 0px;
            border-color: #3D3D3D !important;
        }

        .ruc {
            border-radius: 10px;
            height: 150px;
        }

        .a {
            height: 30px;
            margin: 0;
            border-radius: 0px;
            text-align: center;
        }

        #watermark {
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 0;
        }

        #watermark p {
            position: absolute;
            color: rgba(120, 120, 120, 0.31) !important;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
            font-weight: bolder;
            font-size: 95px !important;
            pointer-events: none;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            top: 35%;
            right: 32%;
            z-index: 0;
        }

        .small-print {
            font-size: 70%;
            display: block;
        }
    </style>
</head>

<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style="margin-bottom: 20px; padding-bottom: 50px;">

                <div class="row" style="align-items: center; justify-content: center">
                    @include('layout_cabecera_ventas')

                    <div class="col-sm-4">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px">RUC : {{ $empresa->ruc ?? '-' }}</h3>
                                <h2 style="font-size: 19px">INFORME TÉCNICO</h2>
                                <h5>{{ $servicioGuia->nro_servicio_guia ?? '-' }}</h5>
                            </center>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <div align="left">
                                <strong>Cliente:</strong>
                                {{ $servicioGuia->cliente->nombre ?? '-' }} <br>

                                <strong>{{ $servicioGuia->cliente->documento_identificacion ?? 'DNI' }}:</strong>
                                {{ $servicioGuia->cliente->numero_documento ?? '-' }} <br>

                                <strong>Dirección:</strong>
                                {{ $servicioGuia->cliente->direccion ?? 'No especificada' }} <br>

                                <strong>Teléfono:</strong>
                                {{ $servicioGuia->cliente->telefono ?? '-' }}
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Celular:</strong>
                                {{ $servicioGuia->cliente->celular ?? '-' }} <br>

                                <strong>Correo:</strong>
                                {{ $servicioGuia->cliente->email ?? 'No especificado' }} <br>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <div align="left">
                                <strong>N° Servicio Técnico:</strong>
                                {{ $servicioGuia->nro_servicio_guia ?? '-' }} <br>

                                <strong>Orden de Servicio:</strong>
                                {{ $servicioGuia->orden_servicio ?? '-' }} <br>

                                <strong>Fecha Registro:</strong>
                                {{ !empty($servicioGuia->fecha_creacion) ? date('d/m/Y', strtotime($servicioGuia->fecha_creacion)) : '-' }} <br>

                                <strong>Fecha Informe:</strong>
                                {{ !empty($informeTecnico->created_at) ? \Carbon\Carbon::parse($informeTecnico->created_at)->format('d/m/Y') : '-' }} <br>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="table-responsive">
                    <table class="table">
                        <thead style="font-weight: bold">
                            <tr>
                                <th style="text-align:center; width: 50px;">ITEM</th>
                                <th>NOMBRE DEL EQUIPO</th>
                                <th style="text-align:center;">N° SERIE</th>
                                <th>OBSERVACIÓN</th>
                                <th style="text-align:center;">F. INICIO REP.</th>
                                <th style="text-align:center;">F. FIN REP.</th>
                                <th>DIAGNÓSTICO</th>
                                <th>DESCRIPCIÓN O/S</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $j = 1; @endphp

                            @forelse ($servIngresoEquipos as $ingreso)
                                @php
                                    $egresosRelacionados = $servEgresosEquipos->where('servicio_g_ingreso_id', $ingreso->id);
                                @endphp

                                @if ($egresosRelacionados->count() > 0)
                                    @foreach ($egresosRelacionados as $egreso)
                                        <tr>
                                            <td style="text-align:center;">{{ $j++ }}</td>
                                            <td>{{ $ingreso->nombre_equipo ?? '-' }}</td>
                                            <td style="text-align:center;">{{ $ingreso->nro_serie ?? '-' }}</td>
                                            <td>{{ $ingreso->observacion ?? '-' }}</td>
                                            <td style="text-align:center;">
                                                {{ !empty($egreso->fecha_inicio_reparacion) ? \Carbon\Carbon::parse($egreso->fecha_inicio_reparacion)->format('d/m/Y') : '—' }}
                                            </td>
                                            <td style="text-align:center;">
                                                {{ !empty($egreso->fecha_fin_reparacion) ? \Carbon\Carbon::parse($egreso->fecha_fin_reparacion)->format('d/m/Y') : '—' }}
                                            </td>
                                            <td>{{ $egreso->diagnostico ?? '—' }}</td>
                                            <td>{{ $egreso->descripcion_os ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td style="text-align:center;">{{ $j++ }}</td>
                                        <td>{{ $ingreso->nombre_equipo ?? '-' }}</td>
                                        <td style="text-align:center;">{{ $ingreso->nro_serie ?? '-' }}</td>
                                        <td>{{ $ingreso->observacion ?? '-' }}</td>
                                        <td style="text-align:center;">—</td>
                                        <td style="text-align:center;">—</td>
                                        <td>—</td>
                                        <td>—</td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align:center;">No hay registros para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <br>

                <div class="row avoid-break">
                    <div class="col-sm-12">
                        <div class="form-control" style="min-height: 120px;">
                            <strong>Conclusión / Resumen del Informe:</strong><br><br>
                            {{ $informeTecnico->observacion ?? $informeTecnico->descripcion ?? 'Sin observaciones registradas.' }}
                        </div>
                    </div>
                </div>

                <br>

                <div class="row avoid-break">
                    <div class="col-sm-12">
                        <small class="small-print">
                            Representación impresa de <strong>INFORME TÉCNICO</strong>
                        </small>
                        <small class="small-print">
                            Documento generado desde el módulo de Servicio Técnico
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>
