<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--  <title>Guías de Egreso - Impresión Múltiple</title>--}}

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

    @foreach($guiasData as $index => $guiaData)
        @php
            $garantias_guias_egreso = $guiaData['guia'];
            $usuario = $guiaData['usuario'];
        @endphp

        <div class="animated fadeInRight" @if($index > 0) style="page-break-before: always;" @endif>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style="margin-bottom: 20px;padding-bottom: 50px;">
                        <div class="row" style="height: auto;">
                            <div class="col-sm-4 text-left" align="left">
                                <div class="form-control" align="center" style="height: 100%;vertical-align: middle;align-items: center;display: inline-flex;justify-content: center;" align="left">
                                    <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="max-width: 100%;max-height: 100px;padding: 5px;">
                                </div>
                            </div>
                            <div class="col-sm-4" align="center">
                                <div class="form-control" align="center" style="height: 100%;vertical-align: middle;align-items: center;display: inline-flex;justify-content: center;" align="center">
                                    <img align="center" src="{{asset('archivos/imagenes/marcas/'.$garantias_guias_egreso->garantia_ingreso_i->marcas_i->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
                                </div>
                            </div>
                            <div class="col-sm-4" align="right">
                                <div class="form-control" align="center" style="height: 100%;" align="right">
                                    <h3 style=""><strong>R.U.C {{$empresa->ruc}}</strong></h3>
                                    <h2><strong>GUIA DE EGRESO</strong></h2>
                                    <h4>{{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}</h4>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>@if($garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion == "RUC") Empresa: @else Nombre: @endif</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}<br>
                                        <strong>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion}} :</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Fecha:</strong> &nbsp;{{date("d/m/Y", strtotime($garantias_guias_egreso->fecha))}}<br>
                                        <strong>Direccion:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->direccion}}<br>
                                        <strong>Telefono:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Correo:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->email}}<br>
                                        <strong>Contacto:&nbsp;</strong>
                                        @if($garantias_guias_egreso->garantia_ingreso_i->contacto_cliente_id == null)
                                        <em>Sin Registro</em>
                                        @else
                                        {{$contacto->where('id','=',$garantias_guias_egreso->garantia_ingreso_i->contacto_cliente_id)->pluck('nombre')->first()}} &nbsp;
                                        @endif
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Técnico Asignado:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                        <strong>Motivo:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->motivo}}<br>
                                        <strong>Marca :</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre}} &nbsp;<br>
                                        <strong>Asunto:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->asunto}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
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
                                            <strong>Modelo:</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->nombre_equipo}}<br>
                                            <strong>Número de serie:</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->numero_serie}}<br>
                                        </div>
                                        <div align="left" class="col-sm-6">
                                            <strong>Codigo Interno:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->codigo_interno}}<br>
                                            <strong>Fecha de Compra:</strong> &nbsp;{{date("d/m/Y", strtotime($garantias_guias_egreso->garantia_ingreso_i->fecha_compra))}}<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <footer style="padding-top: 10px">
                            <div class="row" align="center">
                                <div class="col-sm-12" align="center">
                                    <div class="form-control" style="height: 100%">
                                        <h3>Descripcion del Problema:</h3>
                                        <div align="left" style="font-size: 13px;">
                                            <p>{!! nl2br($garantias_guias_egreso->descripcion_problema)!!}</p>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class="col-sm-12" align="center" style="padding-top: 15px;">
                                    <div class="form-control" style="height: 100%">
                                        <h3>Revisión y diagnóstico</h3>
                                        <div align="left" style="font-size: 13px;">
                                            <p>{!! nl2br($garantias_guias_egreso->diagnostico_solucion)!!}</p>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class="col-sm-12" align="center" style="padding-top: 15px;">
                                    <div class="form-control" style="height: 100%">
                                        <h3>Recomendaciones</h3>
                                        <div align="left" style="font-size: 13px">
                                            <p>{!! nl2br($garantias_guias_egreso->recomendaciones)!!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="row" align="center" style="padding-bottom: 5px">
                                <div class="col-sm-4" align="center">
                                    <div class="form-control" style="height: 100%">
                                        <h3>Descripcion del Problema:</h3>
                                        <div align="left" style="font-size: 13px;">
                                            <p>{!! nl2br($garantias_guias_egreso->descripcion_problema)!!}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="center">
                                    <div class="form-control" style="height: 100%">
                                        <h3>Revisión y diagnóstico</h3>
                                        <div align="left" style="font-size: 13px;">
                                            <p>{!! nl2br($garantias_guias_egreso->diagnostico_solucion)!!}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" align="center">
                                    <div class="form-control" style="height: 100%">
                                        <h3>Recomendaciones</h3>
                                        <div align="left" style="font-size: 13px">
                                            <p>{!! nl2br($garantias_guias_egreso->recomendaciones)!!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </footer>

                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <strong><p><u>Centro de Atencion : </strong></u></p>
                                <strong>Direccion:</strong> {{$usuario->almacen->direccion}}<br>
                                <strong>Telefonos :</strong>  {{$mi_empresa->telefono}} / {{$usuario->celular}} &nbsp;<br>
                                <strong>{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre_empresa}}:</strong> {{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->telefono}}<br>
                                <strong>Email:</strong> {{$usuario->email}}<br>
                                <strong>Web:</strong> {{$mi_empresa->pagina_web}}<br>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"><br><br></div>
                        </div>

                        <div class="row" style="margin-top:8rem;">
                            <div class="col-sm-6">
                                <center>
                                    <p style="width: 50%;border-top: 1px solid #aaaaaa">
                                        Departamento de Servicio Tecnico <br> Ing. {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->apellidos}}
                                    </p>
                                </center>
                            </div>
                            <div class="col-sm-6">
                                <center>
                                    <p style="width: 50%;border-top: 1px solid #aaaaaa">
                                        {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}<br> ({{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion}} : {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}})
                                    </p>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        .cero {
            margin-bottom: 0px;
        }

        .container {
            margin: 1 1 1rem;
            height: 7rem;
            display: flex;
            align-items: start;
            margin-top: 8rem;
        }

        .child1 {
            height: 7rem;
            padding: .2rem;
            margin-left: 120px;
        }

        .child2 {
            padding: .2rem;
            height: 7rem;
            margin-left: 30%;
        }

        .border {
            border-color: #aaaaaa;
            border-width: 1px;
            border-style: solid;
        }

        .form-control {
            border-radius: 7px;
            margin-top: 5px;
            border-color: #3D3D3D;
            padding: 10px;
        }

        * {
            color: black;
        }

        /* Estilos específicos para impresión - evitar opacidad */
        .form-control {
            background-color: white;
            opacity: 1;
        }

        .ibox-content {
            background-color: white;
            opacity: 1;
        }

        /* Asegurar que todos los elementos sean visibles */
        body, html {
            background-color: white;
            opacity: 1;
        }

        /* Estilos para salto de página en impresión */
        @media print {
            .page-break {
                page-break-before: always;
            }
        }

        @media print {
        /* Forzar opacidad total en todo */
        body, html, .ibox-content, .form-control, .animated {
            opacity: 1 !important;
            filter: none !important;
            -webkit-filter: none !important;
            background-color: white !important;
            color: black !important;
        }

        /** {
            opacity: 1 !important;
            filter: none !important;
            -webkit-filter: none !important;
        }*/
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
