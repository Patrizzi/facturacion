@extends('layout')

@section('title', 'Guia Remision Ver')
@section('breadcrumb', 'Guia Remision')
@section('breadcrumb2', 'Guia Remision')
@section('href_accion', route('guia_remision.index'))
@section('value_accion', 'Atras')

@section('content')

    <!-- modal -->
    {{-- <div class="row">
        <div class="col-lg-12">
            <div id="modal-form" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row" align="center">
                                <div class="col-sm-12 b-r">
                                    <h3 class="m-t-none m-b">Crear Guia Remision</h3>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ route('guia_remision.seleccionar') }}"><button class="btn btn-sm btn-info"
                                            type="submit"><strong>Ver Aprobadas</strong></button></a>
                                </div>
                                <div class="col-sm-6">
                                    @if ($conteo_almacen == 1 and $user_login->name == 'Administrador')
                                        <form action="{{ route('guia_remision.create') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="text" value="{{ $almacen_primero->id }}" hidden="hidden"
                                                name="almacen">
                                            <input class="btn btn-sm btn-info" type="submit" value="Crear una nueva Guia">
                                        </form>
                                    @elseif($conteo_almacen == 1 and $user_login->almacen->estado == 1 and $user_login->name == 'Colaborador')
                                        <input id="auto" onclick="divAuto()" type="submit" class="btn btn-sm btn-info"
                                            value="Crear una Nueva Guia">
                                        <div id="div-mostrar" style="color: black">
                                            <div id="texto"
                                                style="opacity:0;transition: .4s ;text-align: center;padding-top: 10px;">
                                                Almacen Asignado esta Desactivado, Activelo o cambie de Almacen.</div>
                                        </div>
                                    @elseif($conteo_almacen == 1 and $user_login->almacen->estado == 0 and $user_login->name == 'Colaborador')
                                        <form action="{{ route('guia_remision.create') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="text" value="{{ $user_login->almacen_id }}" hidden="hidden"
                                                name="almacen">
                                            <input class="btn btn-sm btn-info" type="submit" value="Crear una nueva Guia">
                                        </form>
                                    @elseif($conteo_almacen > 1 and $user_login->name == 'Administrador')
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Crear una
                                                Nueva Guia</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <form
                                                    action="{{ route('guia_remision.create') }}"enctype="multipart/form-data">
                                                    @csrf
                                                    @foreach ($almacen as $almacens)
                                                        <input type="submit" class="dropdown-item" name="almacen"
                                                            value="{{ $almacens->id }} - {{ $almacens->nombre }}">
                                                    @endforeach
                                                </form>
                                            </div>
                                        </div>
                                    @elseif($conteo_almacen > 1 and $user_login->name == 'Colaborador')
                                        @if ($user_login->almacen->estado == 1)
                                            <input id="auto" onclick="divAuto()" type="submit"
                                                class="btn btn-sm btn-info" value="Crear una Nueva Guia">
                                            <div id="div-mostrar" style="color: black">
                                                <div id="texto"
                                                    style="opacity:0;transition: .4s ;text-align: center;padding-top: 10px;">
                                                    Almacen Asignado esta Desactivado, Activelo o cambie de Almacen.</div>
                                            </div>
                                        @elseif($user_login->almacen->estado == 0)
                                            <form action="{{ route('guia_remision.create') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="text" value="{{ $user_login->almacen_id }}" hidden="hidden"
                                                    name="almacen">
                                                <input class="btn btn-sm btn-info" type="submit"
                                                    value="Crear una nueva Guia">
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- fimodal --}}

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between" style="padding-right: 3.1%">
                @include('transaccion.comprobantes._shared.btn_create_with_almacen', [
                    'routeCreate' => 'guia_remision.create',
                    'almacen' => $almacen,
                    'useAlmacen' => true,
                    'method' => 'POST'
                ])
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a class="" href="{{ route('comprobantes.index_guia_remision') }}">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="padding-right: 3.1%">
                <div class="row tooltip-demo">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6" align="right">
                        <a href="{{ route('pdf_guia', $guia_remision->id) }}" class="btn btn-success" data-toggle="tooltip"
                            data-placement="bottom" title="" data-original-title="Descargar PDF"><i
                                class="fa fa-file-pdf-o fa-lg"></i>
                        </a>
                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.guia_remision', $guia_remision->id) }}" method="post"
                                style="text-align: none;padding-right: 0;padding-left: 0;" class="btn">
                                @csrf
                                <button type="submit" class="btn btn-secondary" data-toggle="tooltip"
                                    data-placement="bottom" title="" formtarget="_blank"
                                    data-original-title="Enviar por correo">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif
                        <a class="btn btn-success"
                            href="{{ route('guia_remision.print', $guia_remision->id) }}"target="_blank"
                            class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title=""
                            data-original-title="Imprimir"><i class="fa fa-print fa-lg"></i></a>
                        <div id="auto" onclick="divAuto()">
                            <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip"
                                data-placement="bottom" title="" data-original-title="Enviar a"><i
                                    class="fa fa-whatsapp fa-lg" style="color: white"></i> </a>
                        </div>
                        @if ($guia_remision->estado == 0)
                            <button class="btn btn-warning btn-editar" id="edit" onclick="click_editar()"><i
                                    class="fa fa-pencil"></i></button>
                            <button class="btn-no-editar no_mostrar btn btn-warning" onclick="click_cancelar_editar()"><i
                                    class="fa fa-times"></i></button>
                        @endif
                        <div id="div-mostrar" style="height: 0px; overflow: hidden;">
                            <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                                style="text-align: none;padding-right: 0;padding-left: 0;">
                                @csrf
                                <input type="tel" name="numero" value="{{ $guia_remision->cliente->celular }}" />
                                <input type="text" name="mensaje" id="texto_orden" hidden="" />
                                <input type="text" hidden="" name="url"
                                    value="{{ route('pdf_guia', $guia_remision->id) }}?archivo=">
                                <input type="text" name="name_sin_cambio" hidden=""
                                    value="{{ $guia_remision->cod_guia }}" />
                                <button type="submit" class="btn  btn-success"
                                    style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip"
                                    data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i
                                        class="fa fa-send fa-lg"></i> </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mostrar" id="show_guias">
                <div class="row">
                    <div class="col-lg-12" style="margin-top: -2px">
                        <div class="id_show">
                            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                                <div class="row">
                                    <div class="col-sm-4 text-left" align="left">
                                        <address class="col-sm-4" align="left">
                                            <img src="{{ asset('img/logos/') }}/{{ $empresa->foto }}" alt=""
                                                width="300px">
                                        </address>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
                                    <div class="col-sm-4 ">
                                        <div class="form-control" align="center" style="height: auto;">
                                            <h3 style="padding-top:10px ">R.U.C {{ $empresa->ruc }}</h3>
                                            <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>
                                            <h5>{{ $guia_remision->cod_guia }} </h5>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row" align="center" style="padding-bottom: 5px">
                                    <div class="col-sm-6" align="center">
                                        <div class="form-control">
                                            <h3>Domicilio De Partida</h3>
                                            <div align="left" style="font-size: 13px">
                                                <p>{{ $guia_remision->almacen->direccion }} -
                                                    {{ $guia_remision->almacen->cod_postal }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" align="center">
                                        <div class="form-control">
                                            <h3>Domicilio De Llegada</h3>
                                            <div align="left" style="font-size: 13px">
                                                @if (isset($guia_remision->sucursal_cliente))
                                                    <p>{{ $guia_remision->sucursal_cliente }} -
                                                        {{ $guia_remision->cod_postal_cliente }}</p>
                                                @else
                                                    <p>{{ $guia_remision->cliente->direccion }} -
                                                        {{ $guia_remision->cliente->cod_postal }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($guia_remision->g_electronica == 2 || $guia_remision->estado_anulado == 1)
                                    <div id="watermark">
                                        <p>Anulado</p>
                                    </div>
                                @endif
                                <div class="row" align="center">
                                    <div class="col-sm-6" align="center">
                                        <div class="form-control">
                                            <h3>Destinario</h3>
                                            <div align="left" style="font-size: 13px">
                                                <p><b>señor(es) :</b> {{ $guia_remision->cliente->nombre }} <br>
                                                    <b>R.U.C / DNI : </b>
                                                    {{ $guia_remision->cliente->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;<b>Fecha
                                                        Emision :</b> {{ $guia_remision->fecha_emision }} <br><b>Fecha
                                                        Traslado
                                                        :</b>
                                                    {{ $guia_remision->fecha_entrega }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" align="center">
                                        <div class="form-control">
                                            <h3>Unidad de Transporte/Conductor</h3>
                                            <div align="left" style="font-size: 13px">
                                                @if (isset($guia_remision->vehiculo_id))
                                                    <p>
                                                        <b>Placa del Vehiculo :
                                                        </b>{{ $guia_remision->vehiculo->placa }}<br>
                                                        <b>Marca del Vehiculo :
                                                        </b>{{ $guia_remision->vehiculo->marca }}<br>
                                                        <b>Conductor : </b>{{ $guia_remision->personal->nombres }}
                                                    </p>
                                                @elseif(isset($guia_remision->vehiculo_publico))
                                                    <p>
                                                        <b>Empresa:</b> {{ $guia_remision->vehiculo_publicos->nombre }}<br>
                                                        <b>Ruc: </b> {{ $guia_remision->vehiculo_publicos->ruc }}<br>
                                                        <b>Nota:</b>Esta Empresa es Publica

                                                    </p>
                                                @else
                                                    <p>
                                                        <b>Placa del Vehiculo : </b>No Hay Vehiculo<br>
                                                        <b>Marca del Vehiculo : </b>No Hay Vehiculo<br>
                                                        @if (isset($guia_remision->conductor_id))
                                                            <b>Conductor : </b>{{ $guia_remision->personal->nombres }}
                                                        @else
                                                            <b>Conductor : </b> No Hay Conductor
                                                        @endif
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Codigo Producto </th>
                                                <th>Marca / Descripcion</th>
                                                <th>Unid.Medida</th>
                                                <th>Cantidad</th>
                                                <th>Peso</th>
                                        </thead>
                                        <span hidden>{{ $z = 1 }}</span>
                                        <tbody>
                                            @foreach ($guia_registro as $guia_registros)
                                                <tr>
                                                    <td>{{ $z++ }}</td>
                                                    <td>{{ $guia_registros->producto->codigo_original }}</td>
                                                    <td>{{ $guia_registros->producto->marcas_i_producto->nombre }} /
                                                        {{ $guia_registros->producto->nombre }} /
                                                        {{ $guia_registros->descripcion }}
                                                        <br>
                                                        <strong>N/S: </strong>{{ $guia_registros->numero_serie }}
                                                    </td>
                                                    <td>{{ $guia_registros->producto->unidad_i_producto->medida }}</td>
                                                    <td>{{ $guia_registros->cantidad }}</td>
                                                    <td>{{ $guia_registros->peso }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="6">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" align="right">Peso Total:</td>
                                                <td>{{ $guia_registro->sum('peso') }} KGM</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- /table-responsive -->


                                <footer style="padding-top: 120px">
                                    <div class="row" align="center" style="padding-bottom: 5px">
                                        <div class="col-sm-6" align="center">
                                            <div class="form-control">
                                                <h3>Observacion:</h3>
                                                <div align="left" style="font-size: 13px">
                                                    <p>{{ $guia_remision->observacion }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6" align="center">
                                            <div class="form-control">
                                                <h3>Motivo de Traslado</h3>
                                                <div align="left" style="font-size: 13px">
                                                    <p>{{ $guia_remision->motivo_traslado }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($guia_remision->estado_anulado == 1)
                                        <div class="row" align="center" style="padding-bottom: 5px">
                                            <div class="col-sm-12" align="center">
                                                <div class="form-control">
                                                    <h3>Motivo de la Anulacion:</h3>
                                                    <div align="left" style="font-size: 13px">
                                                        <p>{{ $guia_remision->motivo_anulacion ?? 'Sin motivo especificado' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </footer>

                                <br>
                                <!-- Fin Totales de Productos -->

                                {{-- @include('layout_bancos') --}}

                                <br>
                                @include('layout_firma_pie_hoja')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="no_mostrar" id="edicion_guias">
                @if ($guia_remision->estado == 0)
                    @include('transaccion.venta.guia_remision.edit')
                @endif
            </div>
        </div>
    </div>

    <style type="text/css">
        /* SHOW */
        .form-control {
            /* border-radius: 10px; */
            height: auto;
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
        }

        /* EDIT */
        .input-group>.select2-container--bootstrap {
            width: auto;
            flex: 1 1 auto;
        }

        .input-group>.select2-container--bootstrap .select2-selection--single {
            height: 100%;
            line-height: inherit;
            padding: 0.5rem 1rem;
            border: 1px solid #e5e6e7;
        }

        .select2-results__option.select2-results__option--highlighted {
            background-color: #1c84c6 !important;
            color: white !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 12px;
        }

        .select2-container--default .select2-selection--single {
            border: none;
        }

        span.select2.select2-container.select2-container--default {
            max-width: 100% !important;
            width: 700px !important;
            background-color: #FFFFFF;
            background-image: none;
            border-radius: 1px;
            display: block;
            padding: 3px 12px;
            border: 1px solid #e5e6e7;
        }

        .select2-hidden-accessible {
            width: auto !important;
        }

        #div-mostrar {
            /*width: 50%;*/
            margin: auto;
            height: 0px;
            /*margin-top: -5px*/
            /*background: #000;*/
            /*box-shadow: 10px 10px 3px #D8D8D8;*/
            transition: height .4s;
            color: white;
            text-align: right;
        }

        .mostrar {
            display: ;
        }

        .no_mostrar {
            display: none;
        }
    </style>
    {{-- Fin de modal configuracion --}}

    <style>
        .form-control {
            margin-top: 5px;
            /* border-radius: 5px */
        }

        p#texto {
            text-align: center;
            color: black;
        }
    </style>
    <style>
        #auto {
            /*padding: -100px;*/
            /*background: orange;*/
            /*width: 95px;*/
            cursor: pointer;
            /*margin-top: 10px;*/
            /*margin-bottom: 10px;*/
            box-shadow: 0px 0px 1px #000;
            display: inline-block;
        }

        #auto:hover {
            opacity: .8;
        }

        #div-mostrar {
            /*width: 50%;*/
            margin: auto;
            height: 0px;
            /*margin-top: -5px*/
            /*background: #000;*/
            /*box-shadow: 10px 10px 3px #D8D8D8;*/
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

        #watermark {
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99;
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
            z-index: 99;
        }
    </style>
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>


    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script type="text/javascript">
        function mostrarPassword() {
            var cambio = document.getElementById("txtPassword");
            if (cambio.type == "password") {
                cambio.type = "text";
                $('#ojo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                cambio.type = "password";
                $('#ojo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }
    </script>
    <script type="text/javascript">
        // {{-- Fotooos --}}

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

        function click_editar() {
            // MOSTRAR LOS INPUTS
            $('#edicion_guias').removeClass('no_mostrar');
            $('#edicion_guias').addClass('mostrar');
            // OCULTAR TABLA
            $('#show_guias').addClass('no_mostrar');
            // BOTONES
            $('.btn-no-editar').removeClass('no_mostrar');
            $('.btn-editar').addClass('no_mostrar');
        }

        function click_cancelar_editar() {
            // OCULTAR INPUTS
            $('#edicion_guias').removeClass('mostrar');
            $('#edicion_guias').addClass('no_mostrar');
            // MOSTRAR TABLA
            $('#show_guias').removeClass('no_mostrar');
            $('#show_guias').addClass('mostrar');

            $('.btn-editar').removeClass('no_mostrar');
            $('.btn-no-editar').addClass('no_mostrar');
        }
    </script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}", '', {
                    timeOut: 3000
                });
            @endif
        });
    </script>

    @include('transaccion.venta.guia_remision._shared.edit_script')
@endsection
