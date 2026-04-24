@extends('layout')

@section('title', 'Ver Guia de Egreso')
@section('breadcrumb', 'Ver Guia de Egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.guias'))
@section('value_accion', 'Nueva Guia')
@section('button2', 'Inicio')
@section('config', route('garantia_guia_egreso.index'))

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between" style="padding-right: 3.1%">
                <div></div>
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a href="{{ route('garantia_guia_egreso.index') }}" title="Cerrar">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content" style="padding-right: 3.1%;padding-left: 3.1%; padding-bottom: 10px;">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3">
                        <h3 style="margin: 0;">{{ $garantias_guias_egreso->garantia_ingreso_i->orden_servicio }}</h3>
                        <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                    </div>

                    <div class="col-12 col-md-4 text-center">
                        <h2 class="mb-0 text-nowrap" style="margin-left: 200px;">
                            GUÍA DE EGRESO
                        </h2>
                    </div>

                    <div class="col-12 col-md-5 d-flex flex-wrap justify-content-end align-items-center" style="gap: 4px;">
                        @if ($garantias_guias_egreso->estado == 1 && $garantias_guias_egreso->informe_tecnico == 0)
                            @can('guia_egreso.editar')
                                <div class="d-flex align-items-center" style="overflow: hidden;">
                                    <div id="btn-slider-egreso"
                                        style="width: 0; overflow: hidden; transition: width 0.3s ease; display: flex; align-items: center;">
                                        <a href="#form_egreso" onclick="Formulario_edit()" id="click" class="btn btn-info"
                                            data-toggle="tooltip" data-placement="bottom"
                                            data-original-title="Editar guía de egreso"
                                            style="white-space: nowrap; margin-right: 4px;">
                                            <i class="fa fa-edit fa-lg"></i>
                                        </a>
                                    </div>
                                    <button type="button" id="btn-toggle-egreso" onclick="toggleBtnsEgreso()"
                                        class="btn btn-default"
                                        style="border: 1px solid #ccc; padding: 5px 8px; transition: transform 0.3s;">
                                        <i class="fa fa-chevron-right" id="btn-arrow-egreso"></i>
                                    </button>
                                </div>
                            @endcan    
                        @endif
                        <div style="width: 1px; height: 30px; background-color: #ccc; margin: 0 6px;"></div>

                        <form class="btn" style="padding: 0;"
                            action="{{ route('pdf_egreso', $garantias_guias_egreso->id) }}">
                            <input type="text" name="archivo" hidden
                                value="{{ $garantias_guias_egreso->garantia_ingreso_i->orden_servicio }}">
                            <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"
                                data-original-title="Descargar PDF">
                                <i class="fa fa-file-pdf-o fa-lg"></i>
                            </button>
                        </form>

                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.guia_egreso', $garantias_guias_egreso->id) }}" method="post"
                                style="padding: 0;" class="btn">
                                @csrf
                                <button type="submit" class="btn btn-secondary" data-toggle="tooltip"
                                    data-placement="bottom" data-original-title="Enviar por correo" formtarget="_blank">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('impresiones_egreso', $garantias_guias_egreso->id) }}" target="_blank"
                            class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
                            data-original-title="Imprimir">
                            <i class="fa fa-print fa-lg"></i>
                        </a>

                        <div style="position: relative; display: inline-block;">
                            <div id="auto" onclick="divAuto()">
                                <a class="btn btn-success" style="background: green; border-color: green;"
                                    data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar a">
                                    <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div id="div-mostrar" style="height: 0px; overflow: hidden; width: 100%; transition: height .4s;">
                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                            style="text-align: none;padding-right: 0;padding-left: 0;">
                            @csrf
                            <input type="tel" name="numero"
                                value="{{ $garantias_guias_egreso->garantia_ingreso_i->clientes_i->celular }}" />
                            <input type="text" name="mensaje" id="texto_orden" hidden />
                            <input type="text" hidden name="url"
                                value="{{ route('pdf_egreso', $garantias_guias_egreso->id) }}?archivo=">
                            <input type="text" name="name_sin_cambio" hidden
                                value="{{ $garantias_guias_egreso->garantia_ingreso_i->orden_servicio }}" />
                            <button type="submit" class="btn btn-success" style="background: green;border-color: green;"
                                formtarget="_blank" data-toggle="tooltip" data-placement="bottom"
                                data-original-title="Enviar por Whatsapp">
                                <i class="fa fa-send fa-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{--  --}}
        <div class="row">
            <div class="col-lg-12" style="margin-top: -26px">
                <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <h3>Contacto Cliente</h3>
                                <div align="left">
                                    <strong>
                                        @if ($garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion == 'RUC')
                                            Empresa:
                                        @else
                                            Nombre:
                                        @endif
                                    </strong>
                                    &nbsp;{{ $garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre }}<br>
                                    <strong>{{ $garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion }}
                                        :</strong>
                                    &nbsp;{{ $garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Fecha:</strong>
                                    &nbsp;{{ date('d/m/Y', strtotime($garantias_guias_egreso->fecha)) }}<br>
                                    <strong>Teléfono:</strong>&nbsp;{{ $garantias_guias_egreso->garantia_ingreso_i->clientes_i->telefono }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Correo:</strong>&nbsp;
                                    {{ $garantias_guias_egreso->garantia_ingreso_i->clientes_i->email }}<br>
                                    <strong>Dirección:</strong>&nbsp;
                                    {{ $garantias_guias_egreso->garantia_ingreso_i->clientes_i->direccion }}<br>
                                    <strong>Contacto:&nbsp;</strong>
                                    @if ($garantias_guias_egreso->garantia_ingreso_i->contacto_cliente_id == null)
                                        <em>Sin Registro</em>
                                    @else
                                        {{ $garantias_guias_egreso->garantia_ingreso_i->contactos->nombre }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <h3>Condiciones Generales</h3>
                                <div align="left">
                                    <strong>Técnico
                                        Asignado:</strong>&nbsp;{{ $garantias_guias_egreso->garantia_ingreso_i->personal_laborales->nombres }}
                                    {{ $garantias_guias_egreso->garantia_ingreso_i->personal_laborales->apellidos }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <strong>Motivo:</strong>&nbsp;{{ $garantias_guias_egreso->garantia_ingreso_i->motivo }}<br>
                                    <strong>Marca
                                        :</strong>&nbsp;{{ $garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre }}
                                    &nbsp;<br>

                                    <strong>Asunto:</strong>&nbsp;{{ $garantias_guias_egreso->garantia_ingreso_i->asunto }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
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
                                        <strong>Modelo:</strong>
                                        &nbsp;{{ $garantias_guias_egreso->garantia_ingreso_i->nombre_equipo }}<br>
                                        <strong>Número de serie:</strong>
                                        &nbsp;{{ $garantias_guias_egreso->garantia_ingreso_i->numero_serie }}<br>
                                    </div>
                                    <div align="left" class="col-sm-6">
                                        <strong>Codigo Interno:</strong>&nbsp;
                                        {{ $garantias_guias_egreso->garantia_ingreso_i->codigo_interno }}<br>
                                        <strong>Fecha de Compra:</strong>
                                        &nbsp;{{ date('d/m/Y', strtotime($garantias_guias_egreso->garantia_ingreso_i->fecha_compra)) }}<br>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div class="row" align="center" style="padding-bottom: 5px" id="vista_egreso">
                        <div class="col-sm-4" align="center">
                            <div class="form-control" style="height: 100%">
                                <h3>Descripción del Problema:</h3>
                                <div align="left" style="font-size: 13px;">
                                    <p>{{ $garantias_guias_egreso->descripcion_problema }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4" align="center">
                            <div class="form-control" style="height: 100%">
                                <h3>Revisión y diagnóstico</h3>
                                <div align="left" style="font-size: 13px;">
                                    <p>{{ $garantias_guias_egreso->diagnostico_solucion }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4" align="center">
                            <div class="form-control" style="height: 100%">
                                <h3>Recomendaciones</h3>
                                <div align="left" style="font-size: 13px">
                                    <p>{{ $garantias_guias_egreso->recomendaciones }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Form --}}
                    <form action="{{ route('garantia_guia_egreso.update', $garantias_guias_egreso->id) }}"
                        enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="row" align="center" style="padding-bottom: 5px" id="form_egreso" hidden="hidden"
                            id="ab">
                            <div class="col-lg-12">
                                <div class="tabs-container">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Descripción del
                                                Problema</a></li>
                                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Diagnóstico y
                                                Solución</a></li>
                                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Recomendaciones</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                                                <textarea class="form-control" rows="10" placeholder="Escribir aqui Descripcion Del Problema"
                                                    name="descripcion_problema" maxlength="1230" required>{{ $garantias_guias_egreso->descripcion_problema }}</textarea>
                                            </div>
                                        </div>
                                        <div role="tabpanel" id="tab-2" class="tab-pane">
                                            <div class="panel-body">
                                                <textarea class="form-control" rows="10" placeholder="Escribir aqui Diagnostico y Solucion"
                                                    name="diagnostico_solucion" maxlength="1230" required>{{ $garantias_guias_egreso->diagnostico_solucion }}</textarea>
                                            </div>
                                        </div>
                                        <div role="tabpanel" id="tab-3" class="tab-pane">
                                            <div class="panel-body">
                                                <textarea class="form-control" rows="10" placeholder="Escribir aqui las recomendaciones" name="recomendaciones"
                                                    maxlength="1230" required>{{ $garantias_guias_egreso->recomendaciones }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12" align="center" style="margin-top:20px">
                                <button class="btn btn-info">Guardar</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <footer style="padding-top: 10px">
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>
                                    <p><u>Centro de Atención :
                                </strong></u></p>
                                <strong>Dirección:</strong>
                                {{ $garantias_guias_egreso->garantia_ingreso_i->almacen->direccion }}<br>
                                <strong>Teléfonos :</strong> {{ $empresa->telefono }} / {{ $usuario->celular }} &nbsp;<br>
                                <strong>{{ $garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre_empresa }}:</strong>
                                {{ $garantias_guias_egreso->garantia_ingreso_i->marcas_i->telefono }}<br>
                                <strong>Email:</strong> {{ $usuario->email }}<br>
                                <strong>Web:</strong> {{ $empresa->pagina_web }}<br>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"><br><br>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <style>
        #auto {
            cursor: pointer;
            box-shadow: 0px 0px 1px #000;
            display: inline-block;
        }

        #auto:hover {
            opacity: .8;
        }

        #div-mostrar {
            margin: auto;
            height: 0px;
            transition: height .4s;
            color: white;
            text-align: right;
        }

        #auto:hover {
            opacity: .8;
        }

        #auto:hover+#div-mostrar {
            height: 50px;
        }
    </style>
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script type="text/javascript">
        function actualizatext() {
            let action = document.getElementById("texto2").value;
            document.getElementById("texto_orden").value = action;
        }

        var clic = 1;

        function divAuto() {
            if (clic == 1) {
                document.getElementById("div-mostrar").style.height = "50px";
                clic = clic + 1;
            } else {
                document.getElementById("div-mostrar").style.height = "0px";
                clic = 1;
            }
        }
    </script>
    <script>
        function Formulario_edit() {
            var form_egreso = document.getElementById("form_egreso");
            var vista_egreso = document.getElementById("vista_egreso");
            var boton = document.getElementById("click");
            if (form_egreso.hasAttribute("hidden")) {
                form_egreso.removeAttribute("hidden", "");
                boton.innerHTML = '<i class="fa fa-window-close"></i>';
                vista_egreso.setAttribute("hidden", "");
            } else {
                form_egreso.setAttribute("hidden", "");
                boton.innerHTML = '<i class="fa fa-edit"></i>';
                vista_egreso.removeAttribute("hidden", "");

            }

        }
    </script>
    <script>
        function toggleBtnsEgreso() {
            const slider = document.getElementById('btn-slider-egreso');
            const arrow = document.getElementById('btn-arrow-egreso');
            const isOpen = slider.style.width !== '0px' && slider.style.width !== '0';

            if (isOpen) {
                slider.style.width = '0';
                arrow.classList.remove('fa-chevron-left');
                arrow.classList.add('fa-chevron-right');
            } else {
                slider.style.width = slider.scrollWidth + 'px';
                arrow.classList.remove('fa-chevron-right');
                arrow.classList.add('fa-chevron-left');
            }
        }
    </script>
@endsection
