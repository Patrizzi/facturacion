@extends('layout')

@section('title', 'Guia Remision Ver')
@section('breadcrumb', 'Guia Remision')
@section('breadcrumb2', 'Guia Remision')
@section('href_accion', route('guia_remision.index'))
@section('value_accion', 'Atras')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between">
                @include('transaccion.comprobantes._shared.btn_create_with_almacen', [
                    'routeCreate' => 'guia_remision.create',
                    'almacen' => $almacen,
                    'useAlmacen' => true,
                    'method' => 'POST',
                ])
                <div class="ibox-tools" style="margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a class="" href="{{ route('comprobantes.index_guia_remision') }}">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="padding-bottom: 10px;">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4">
                        <h3 style="margin: 0;">{{ $guia_remision->cod_guia }}</h3>
                        <strong style="margin: 0;">R.U.C :</strong>{{ $empresa->ruc }}
                    </div>
                    <div class="col-12 col-md-4 text-center">
                        <h2 class="mb-0 text-nowrap">
                            GUÍA DE REMISIÓN ELECTRÓNICA
                        </h2>
                    </div>
                    <div class="col-12 col-md-4 d-flex flex-wrap justify-content-end align-items-center" style="gap: 4px;">
                        <a href="{{ route('pdf_guia', $guia_remision->id) }}" class="btn btn-success btn-sm"
                            data-toggle="tooltip" data-placement="bottom" data-original-title="Descargar PDF">
                            <i class="fa fa-file-pdf-o fa-lg"></i>
                        </a>

                        <a class="btn btn-success btn-sm" href="{{ route('guia_remision.print', $guia_remision->id) }}"
                            target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="Imprimir">
                            <i class="fa fa-print fa-lg"></i>
                        </a>

                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.guia_remision', $guia_remision->id) }}" method="post"
                                style="padding: 0;" class="btn">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm" data-toggle="tooltip"
                                    data-placement="bottom" data-original-title="Enviar por correo" formtarget="_blank">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif

                        <div style="position: relative; display: inline-block;">
                            <div id="auto" onclick="divAuto()">
                                <a class="btn btn-success btn-sm" style="background: green; border-color: green;">
                                    <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                </a>
                            </div>
                        </div>

                        @if ($guia_remision->estado == 0)
                            @can('guia_remision.editar')
                                <button class="btn btn-warning btn-sm btn-editar" id="edit" onclick="click_editar()">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn-no-editar no_mostrar btn btn-warning btn-sm"
                                    onclick="click_cancelar_editar()">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endcan
                        @endif

                        <div id="div-mostrar" style="height: 0px; overflow: hidden; width: 100%; transition: height .4s;">
                            <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                                style="text-align: none;padding-right: 0;padding-left: 0;">
                                @csrf
                                <input type="tel" name="numero" value="{{ $guia_remision->cliente->celular }}" />
                                <input type="text" name="mensaje" id="texto_orden" hidden />
                                <input type="text" hidden name="url"
                                    value="{{ route('pdf_guia', $guia_remision->id) }}?archivo=">
                                <input type="text" name="name_sin_cambio" hidden
                                    value="{{ $guia_remision->cod_guia }}" />
                                <button type="submit" class="btn btn-success btn-sm"
                                    style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip"
                                    data-placement="bottom" data-original-title="Enviar por Whatsapp">
                                    <i class="fa fa-send fa-lg"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-top: -26px">
                <div class="ibox-content" style="padding-bottom: 50px;">
                    @if ($guia_remision->g_electronica == 2 || $guia_remision->estado_anulado == 1)
                        <div id="watermark">
                            <p>Anulado</p>
                        </div>
                    @endif
                    <div class="table-no mostrar">
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
                        <br>    
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
                    </div>
                    <div class="table-no mostrar">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Codigo Producto </th>
                                    <th>Artículo</th>
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
                                        <td>{{ $guia_registros->producto->nombre }}
                                            @if ($guia_registros->descripcion)
                                                / <small>{{ $guia_registros->descripcion }} </small>
                                            @endif
                                            <br>
                                            <strong>N/S: </strong>{{ $guia_registros->numero_serie }}
                                        </td>
                                        <td>{{ $guia_registros->producto->unidad_i_producto->medida }}</td>
                                        <td>{{ $guia_registros->cantidad }}</td>
                                        <td>{{ $guia_registros->peso }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" align="right">Peso Total:</td>
                                    <td>{{ $guia_registro->sum('peso') }} KGM</td>
                                </tr>
                            </tbody>
                        </table>
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
                        @include('layout_firma_pie_hoja')
                    </div>
                    <br>
                    <div class="div-editar no_mostrar">
                        @if ($guia_remision->estado == 0)
                            @can('guia_remision.editar')
                                @include('transaccion.venta.guia_remision.edit')
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .input-group>.select2-container {
            width: auto;
            flex: 1 1 auto;
        }

        .input-group>.select2-container .select2-selection--single {
            height: 100%;
            line-height: inherit;
        }

        .check {
            -webkit-appearance: none;
            height: 34px;
            background-color: #ffffff00;
            -moz-appearance: none;
            border: none;
            appearance: none;
            width: 90px;
            border-radius: 10px;
        }

        .div_check {
            position: relative;
            top: -33px;
            left: 0px;
            background-color: #ffffff00;
            top: -35;
        }

        .check:checked {
            background: #0375bd6b;
        }

        .text_des {
            border-radius: 10px;
            border: 1px solid #e5e6e7;
            width: 80px;
            padding: 6px 12px;
        }

        #div-mostrar {
            margin: auto;
            margin-right: 15px;
            height: 0px;
            transition: height .4s;
            color: white;
            text-align: right;
            width: 100%;
        }

        #div-mostrar>form {
            text-align: none;
            padding-right: 0;
            padding-left: 0;
            margin-top: 10px;
            margin-right: 0px;
        }

        .no_mostrar {
            display: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            /* font-size: 12px; */
        }

        .select2-container--default .select2-selection--single {
            border: none;
        }

        span.select2.select2-container.select2-container--default {
            background-color: #FFFFFF;
            background-image: none;
            border-radius: 1px;
            display: block;
            padding: 3px 12px;
            border: 1px solid #e5e6e7;
        }

        /* Renovacion */
        .renovacion {
            padding: 0;
            margin-bottom: 15px;
            margin-top: 8px;
        }

        .switch-container {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            margin: 0;
            flex-shrink: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .3s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        input:checked+.slider {
            background-color: #1ab394;
        }

        input:focus+.slider {
            box-shadow: 0 0 2px #1ab394;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .switch-label {
            font-size: 13px;
            color: #676a6c;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
            margin: 0;
            line-height: 24px;
            white-space: nowrap;
        }

        #renovacion_container {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .renovacion select:focus {
            outline: none;
            box-shadow: none;
            border-color: #e5e6e7;
        }

        .renovacion hr {
            display: none;
        }

        #renovacion_container select {
            font-size: 13px;
            height: 34px;
            padding: 0.375rem 0.75rem;
            line-height: 1.5;
            border: 1px solid #e5e6e7;
            width: 100%;
        }

        #extra_selects select {
            font-size: 13px;
            height: 34px;
            padding: 0.375rem 0.75rem;
            line-height: 1.5;
            margin-bottom: 0;
            border: 1px solid #e5e6e7;
            width: 100%;
        }

        .renovacion .row {
            margin-bottom: 6px;
        }

        .row_articulo {
            width: 45% !important;
            max-width: 45% !important;
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1000px;
            }
        }

        .dataTables_wrapper {
            padding: 0px;
        }

        #DataTables_Table_0_wrapper {
            display: flex;
            flex-direction: column !important;
            justify-content: space-between !important;
            height: 100% !important;
        }

        #DataTables_Table_0_wrapper>.top {
            display: none;
        }

        #DataTables_Table_0_wrapper>.row>.col-sm-12 {
            padding: 0px !important;
        }

        .data_table_multiple {
            border: 1px solid #e7eaec;
            margin-bottom: 0px !important;
        }

        #DataTables_Table_0_info {
            margin-bottom: 5px !important;
        }

        span.select2.select2-container.select2-container--default.select2-container--below {
            /* max-width: 400px !important; */
            /* min-width: 400px !important; */
        }

        .word-style select,
        .word-style input,
        .word-style textarea,
        .word-style span {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .select2-nowrap .select2-results__option {
            white-space: nowrap;
        }

        .select2-nowrap {
            min-width: 400px;
        }

        .limp {
            min-width: 85px !important;
        }

        .detracc_campo_required,
        .retenc_campo_required {
            display: none;
            color: red;
        }

        span.select2-container.select2-container--default.select2-container--open {
            z-index: 999999;
        }

        .td-width {
            min-width: 85px;
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
            $('.div-editar').removeClass('no_mostrar');
            $('.div-editar').addClass('mostrar');
            // OCULTAR TABLA
            $('.table-no').addClass('no_mostrar');
            // BOTONES
            $('.btn-no-editar').removeClass('no_mostrar');
            $('.btn-editar').addClass('no_mostrar');
        }

        function click_cancelar_editar() {
            // OCULTAR INPUTS
            $('.div-editar').removeClass('mostrar');
            $('.div-editar').addClass('no_mostrar');
            // MOSTRAR TABLA
            $('.table-no').removeClass('no_mostrar');
            $('.table-no').addClass('mostrar');

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
