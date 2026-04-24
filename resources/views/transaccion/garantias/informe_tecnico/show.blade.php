@extends('layout')

@section('title', 'Ver Informe Tecnico')
@section('breadcrumb', 'Ver informe Tecnico')
@section('breadcrumb2', 'Informe Tecnico')
@section('href_accion', route('garantia_informe_tecnico.guias'))
@section('value_accion', 'Nueva Guia')

@section('button2', 'Inicio')
@section('config', route('garantia_informe_tecnico.index'))

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between" style="padding-right: 3.1%">
                <div></div>
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a href="{{ route('garantia_informe_tecnico.index') }}" title="Cerrar">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>

            <div class="ibox-content" style="padding-right: 3.1%;padding-left: 3.1%; padding-bottom: 10px;">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3">
                        <h3 style="margin: 0;">{{ $garantias_informe_tecnico->orden_servicio }}</h3>
                        <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                    </div>

                    <div class="col-12 col-md-4 text-center">
                        <h2 class="mb-0 text-nowrap" style="margin-left: 200px;">
                            INFORME TÉCNICO
                        </h2>
                    </div>

                    <div class="col-12 col-md-5 d-flex flex-wrap justify-content-end align-items-center" style="gap: 4px;">
                        @can('informe_tecnico.editar')
                            <div class="d-flex align-items-center" style="overflow: hidden;">
                                <div id="btn-slider-informe"
                                    style="width: 0; overflow: hidden; transition: width 0.3s ease; display: flex; align-items: center;">
                                    <a href="#punto" onclick="Formulario_edit()" id="click" class="btn btn-info"
                                        data-toggle="tooltip" data-placement="bottom"
                                        data-original-title="Editar informe técnico"
                                        style="white-space: nowrap; margin-right: 4px;">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                </div>
                                <button type="button" id="btn-toggle-informe" onclick="toggleBtnsInforme()"
                                    class="btn btn-default"
                                    style="background-color: #fff; border: 1px solid #ccc; padding: 5px 8px; transition: transform 0.3s;">
                                    <i class="fa fa-chevron-right" id="btn-arrow-informe"></i>
                                </button>
                            </div>
                        @endcan

                        <div style="width: 1px; height: 30px; background-color: #ccc; margin: 0 6px;"></div>

                        <form class="btn" style="padding: 0;"
                            action="{{ route('pdf_informe', $garantias_informe_tecnico->id) }}">
                            <input type="text" name="archivo" hidden
                                value="{{ $garantias_informe_tecnico->orden_servicio }}">
                            <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"
                                data-original-title="Descargar PDF">
                                <i class="fa fa-file-pdf-o fa-lg"></i>
                            </button>
                        </form>

                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.informe_tecnico', $garantias_informe_tecnico->id) }}"
                                method="post" style="padding: 0;" class="btn">
                                @csrf
                                <button type="submit" class="btn btn-secondary" data-toggle="tooltip"
                                    data-placement="bottom" data-original-title="Enviar por correo" formtarget="_blank">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('impresiones_informe', $garantias_informe_tecnico->id) }}" target="_blank"
                            class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
                            data-original-title="Imprimir">
                            <i class="fa fa-print fa-lg"></i>
                        </a>

                        <div style="position: relative; display: inline-block;">
                            <div id="auto" onclick="divAuto()">
                                <a class="btn btn-success" style="background: green;border-color: green;"
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
                                value="{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->celular }}" />
                            <input type="text" name="mensaje" id="texto_orden" hidden />
                            <input type="text" hidden name="url"
                                value="{{ route('pdf_informe', $garantias_informe_tecnico->id) }}?archivo=">
                            <input type="text" name="name_sin_cambio" hidden
                                value="{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->orden_servicio }}" />
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
        <div class="row">
            <div class="col-lg-12" style="margin-top: -26px">
                <div class="ibox-content p-xl" style=" margin-bottom: 2px;padding-bottom: 50px;">
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control" style="height: 90%">
                                <h3>Contacto Cliente</h3>
                                <div align="left">
                                    <strong>Señor(es):</strong>
                                    &nbsp;{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre }}<br>
                                    <strong>{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion }}
                                        :</strong>
                                    &nbsp;{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Fecha:</strong>
                                    &nbsp;{{ date('d/m/Y', strtotime($garantias_informe_tecnico->fecha)) }}<br>
                                    <strong>Teléfono:</strong>&nbsp;{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Correo:</strong>&nbsp;
                                    {{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email }}<br>
                                    <strong>Dirección:</strong>&nbsp;
                                    {{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion }}<br>
                                    <strong>Contacto:&nbsp;</strong>
                                    @if ($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contacto_cliente_id == null)
                                        <em>Sin Contacto</em>
                                    @else
                                        {{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contactos->nombre }}
                                    @endif
                                    <br> &nbsp;
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control" style="height: 90%">
                                <h3>Condiciones Generales</h3>
                                <div align="left">
                                    <strong>Técnico
                                        Asignado:</strong>&nbsp;{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres }}
                                    {{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->apellidos }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{-- {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}<br>
                                    <strong>Motivo:</strong>&nbsp;{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo }}<br>
                                    <strong>Marca
                                        :</strong>&nbsp;{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre }}
                                    &nbsp;<br>

                                    <strong>Asunto:</strong>&nbsp;{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-12" align="center" style="padding-top: 15px;" id="punto">
                            <div class="form-control" style="height: 100%">
                                <h3>Datos del Equipo</h3>
                                <div class="row" style="padding-bottom: 1px">
                                    <div align="left" class="col-sm-6">
                                        <strong>Modelo:</strong>
                                        &nbsp;{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo }}<br>
                                        <strong>Número de serie:</strong>
                                        &nbsp;{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie }}<br>
                                        <strong>Descripcion del Problema:&nbsp;</strong><br>
                                        {!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->descripcion_problema) !!}
                                    </div>
                                    <div align="left" class="col-sm-6">
                                        <strong>Código Interno:</strong>&nbsp;
                                        {{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno }}<br>
                                        <strong>Fecha de Compra:</strong>
                                        &nbsp;{{ date('d/m/Y', strtotime($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra)) }}<br>
                                        <strong>Revisión y Diagnóstico:&nbsp;</strong>{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->revision_diagnostico) !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                    <div id="vista_update">
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control" style="height: 100%">
                                    <h3>Estética</h3>
                                    <div align="left" style="font-size: 13px">
                                        <p>{!! nl2br($garantias_informe_tecnico->estetica) !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control" style="height: 100%">
                                    <h3>Revisión y diagnóstico:</h3>
                                    <div align="left" style="font-size: 13px;">
                                        <p>{!! nl2br($garantias_informe_tecnico->revision_diagnostico) !!}</p>
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
                                        <p> {!! nl2br($garantias_informe_tecnico->causas_del_problema) !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control" style="height: 100%">
                                    <h3>Solución</h3>
                                    <div align="left" style="font-size: 13px">
                                        <p>{!! nl2br($garantias_informe_tecnico->solucion) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Formulario Update --}}
                    <div id="form_update" hidden="">
                        <form action="{{ route('garantia_informe_tecnico.update', $garantias_informe_tecnico->id) }}"
                            enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="row" align="center" style="padding-bottom: 5px">
                                <div class="col-sm-12">
                                    <div class="tabs-container">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Estética</a>
                                            </li>
                                            <li><a class="nav-link" data-toggle="tab" href="#tab-2">Revisión y
                                                    diagnóstico</a></li>
                                            <li><a class="nav-link" data-toggle="tab" href="#tab-3">Causas del
                                                    problema</a></li>
                                            <li><a class="nav-link" data-toggle="tab" href="#tab-4">Solución</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                                <div class="panel-body">
                                                    <textarea class="form-control" rows="10" placeholder="Escribir aqui estetica" name="estetica" maxlength="1230"
                                                        required>{{ $garantias_informe_tecnico->estetica }}</textarea>
                                                </div>
                                            </div>
                                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                                <div class="panel-body">
                                                    <textarea class="form-control" rows="10" placeholder="Escribir aqui Revisión y diganostico"
                                                        name="revision_diagnostico" maxlength="1230" required>{{ $garantias_informe_tecnico->revision_diagnostico }}</textarea>
                                                </div>
                                            </div>
                                            <div role="tabpanel" id="tab-3" class="tab-pane">
                                                <div class="panel-body">
                                                    <textarea class="form-control" rows="10" placeholder="Escribir aqui Causas del Problema"
                                                        name="causas_del_problema" maxlength="1230" required>{{ $garantias_informe_tecnico->causas_del_problema }}</textarea>
                                                </div>
                                            </div>
                                            <div role="tabpanel" id="tab-4" class="tab-pane">
                                                <div class="panel-body">
                                                    <textarea class="form-control" rows="10" placeholder="Escribir aqui la Solucion" name="solucion"
                                                        maxlength="1230" required>{{ $garantias_informe_tecnico->solucion }}</textarea>
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
                    </div>
                    {{-- Formulario Update --}}
                    <br>
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-12" align="center">
                            <div class="form-control" style="height: 100%">
                                <h3>Imágenes</h3>
                                <div align="left" style="font-size: 13px">
                                    <div class="row">
                                        @foreach ($archivo_informe_tecnico as $archivo)
                                            <div class="col-sm-4">
                                                <img src="{{ asset('archivos/imagenes/informe_tecnico') }}/{{ $archivo->archivos }}"
                                                    style="width:270px;height: 270px;border-radius: 10px">
                                                <p></p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                    </div>
                    <br>
                    <footer style="padding-top: 10px">
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <strong>
                                    <p><u>Centro de Atención :
                                </strong></u></p>
                                <strong>Dirección:</strong>
                                {{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->almacen->direccion }}<br>
                                <strong>Teléfonos :</strong> {{ $empresa->telefono }} / {{ $usuario->celular }} &nbsp;<br>
                                <strong>{{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre_empresa }}:</strong>
                                {{ $garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->telefono }}<br>
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
    <script type="text/javascript">
        {{-- Fotooos --}}

        function validarExt() {
            var archivoInput = document.getElementById('archivoInput');
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.jpg|.png|.jfif)$/i;
            if (!extPermitidas.exec(archivoRuta)) {
                alert('Asegurese de haber seleccionado una Imagen');
                archivoInput.value = '';
                return false;
            } else {
                //PRevio del PDF
                if (archivoInput.files && archivoInput.files[0]) {
                    var visor = new FileReader();
                    visor.onload = function(e) {
                        document.getElementById('visorArchivo').innerHTML =
                            '<img name="firma" src="' + e.target.result + '"width="390px" height="200px" />';
                    };
                    visor.readAsDataURL(archivoInput.files[0]);
                }
            }
        }
    </script>
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
    </script>
    <script>
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
            var form_update = document.getElementById("form_update");
            var vista_update = document.getElementById("vista_update");
            var boton = document.getElementById("click");
            if (form_update.hasAttribute("hidden")) {
                form_update.removeAttribute("hidden", "");
                boton.innerHTML = '<i class="fa fa-window-close"></i>';
                vista_update.setAttribute("hidden", "");
                boton.setAttribute("href", "#punto");
            } else {
                form_update.setAttribute("hidden", "");
                boton.innerHTML = '<i class="fa fa-edit"></i>';
                vista_update.removeAttribute("hidden", "");
                boton.removeAttribute("href", "");
            }
        }
    </script>
    <script>
        function toggleBtnsInforme() {
            const slider = document.getElementById('btn-slider-informe');
            const arrow = document.getElementById('btn-arrow-informe');
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
