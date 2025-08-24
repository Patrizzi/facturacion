<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Informes Técnicos - Impresión Múltiple</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>
</head>

<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">

    @foreach($informesData as $index => $informeData)
        @php
            $garantias_informe_tecnico = $informeData['informe'];
            $archivo_informe_tecnico = $informeData['archivos'];
            $usuario = $informeData['usuario'];
        @endphp

        <div class="animated fadeInRight" @if($index > 0) style="page-break-before: always;" @endif>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style="margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row" style="height: auto;">
                            <div class="col-sm-4 text-left" align="left">
                                <div class="form-control" align="center" style="height: 100%;vertical-align: middle;align-items: center;display: inline-flex;justify-content: center;" align="left">
                                    <img align="center" src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="max-width: 100%;max-height: 100px;padding: 5px;">
                                </div>
                            </div>
                            <div class="col-sm-4" align="center">
                                <div class="form-control" align="center" style="height: 100%;vertical-align: middle;align-items: center;display: inline-flex;justify-content: center;" align="center">
                                    <img align="center" src="{{asset('archivos/imagenes/marcas/'.$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->imagen)}}" style="max-width: 100%;max-height: 100px;padding: 5px">
                                </div>
                            </div>
                            <div class="col-sm-4" align="right">
                                <div class="form-control" align="center" style="height: 100%;" align="right">
                                    <h2 style="">R.U.C {{$mi_empresa->ruc}}</h2>
                                    <h3 style="font-size: 19px">GUIA DE INFORME TECNICO</h3>
                                    <h4>{{$garantias_informe_tecnico->orden_servicio}}</h4>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<br>
                                        <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion}} :</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Fecha:</strong> &nbsp;{{date("d/m/Y", strtotime($garantias_informe_tecnico->fecha))}}<br>
                                        <strong>Telefono:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Correo:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}<br>
                                        <strong>Direccion:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion}}<br>
                                        <strong>Contacto:&nbsp;</strong>
                                        @if($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contacto_cliente_id == null)
                                        <em>Sin Registro</em>
                                        @else
                                        {{$contacto->where('id','=',$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contacto_cliente_id)->pluck('nombre')->first()}} &nbsp;
                                        @endif
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Técnico Asignado:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Motivo:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}<br>
                                        <strong>Marca :</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}} &nbsp;<br>
                                        <strong>Asunto:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-12" align="center" style="padding-top: 15px;">
                                <div class="form-control" style="height: 100%">
                                    <h3>Datos del Equipo</h3>
                                    <div class="row" style="padding-bottom: 1px">
                                        <div align="left" class="col-sm-6">
                                            <strong>Modelo:</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo}}<br>
                                            <strong>Número de serie:</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie}}<br>
                                            <strong>Descripcion del Problema:&nbsp;</strong><br>
                                            {!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->descripcion_problema)!!}
                                        </div>
                                        <div align="left" class="col-sm-6">
                                            <strong>Codigo Interno:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno}}<br>
                                            <strong>Fecha de Compra:</strong> &nbsp;{{date("d/m/Y", strtotime($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra))}}<br>
                                            <strong>Revision y Diagnóstico:&nbsp;</strong>{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->revision_diagnostico)!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control" style="height: 100%">
                                    <h3>Estética</h3>
                                    <div align="left" style="font-size: 13px">
                                        <p>{!! nl2br($garantias_informe_tecnico->estetica)!!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control" style="height: 100%">
                                    <h3>Revision y diagnóstico:</h3>
                                    <div align="left" style="font-size: 13px;">
                                        <p>{!! nl2br($garantias_informe_tecnico->revision_diagnostico)!!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control" style="height: 100%">
                                    <h3>Causas del Problema</h3>
                                    <div align="left" style="font-size: 13px;">
                                        <p> {!! nl2br($garantias_informe_tecnico->causas_del_problema)!!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control" style="height: 100%">
                                    <h3>Solución</h3>
                                    <div align="left" style="font-size: 13px">
                                        <p>{!! nl2br($garantias_informe_tecnico->solucion)!!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <footer style="position:relative;bottom:0;width:100%;height:200%;">
                            <div class="row" style="margin-top:8rem;">
                                <div class="col-sm-6">
                                    <center>
                                        <p style="width: 50%;border-top: 1px solid #aaaaaa">
                                            Departamento de Servicio Tecnico <br>Ing. {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->apellidos}}
                                        </p>
                                    </center>
                                </div>
                                <div class="col-sm-6">
                                    <center>
                                        <p style="width: 50%;border-top: 1px solid #aaaaaa">
                                            {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<br>
                                            ({{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}})
                                        </p>
                                    </center>
                                </div>
                            </div>
                            <div class="saltopagina">
                                <div class="row" align="center" style="padding-bottom: 5px;">
                                    <div class="col-sm-12" align="center">
                                        <div class="form-control" style="height: 100%">
                                            <h3>Imagenes</h3>
                                            <div align="left" style="font-size: 13px">
                                                <div class="row" align="center">
                                                    @foreach($archivo_informe_tecnico as $archivo)
                                                    <div class="col-sm-4" style="padding: 50px;padding-left: 70px ;margin: -15px" align="center">
                                                        <img src="{{asset('archivos/imagenes/informe_tecnico')}}/{{$archivo->archivos}}" style="width:270px;height: 270px;border-radius: 10px">
                                                        <br>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        @media all {
            div.saltopagina {
                display: none;
            }
        }

        @media print {
            div.saltopagina {
                display: block;
                page-break-before: always;
            }
        }

        .form-control {
            margin-top: 5px;
            border-radius: 5px;
            border-color: #3D3D3D;
            padding: 10px;
        }

        p#texto {
            text-align: center;
            color: black;
        }

        * {
            color: black;
        }

        /* Estilos para salto de página en impresión */
        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>

    {{-- IMPRIMIR --}}
    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
