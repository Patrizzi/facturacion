@extends('layout')
@section('title', 'Nota de Venta')
@section('href_accion', route('nota_venta.index'))
@section('value_accion', 'Inicio')
{{-- @section('nombre', 'nueva cotizacion') --}}

@section('button2', 'Nueva Nota de Venta')
@section('onclick', "event.preventDefault();document.getElementById('nueva_nota').submit();")

@section('content')
    <?php use Luecano\NumeroALetras\NumeroALetras; ?>
    <form action="{{ route('nota_venta.create') }}"enctype="multipart/form-data" method="post" id="nueva_nota">
        @csrf
        <input type="text" hidden="hidden" name="almacen" value="{{ $nota_venta->almacen_id }}">
        <input hidden="hidden" type="submit">
    </form>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title d-flex justify-content-between" style="">
                <div style="margin-top: 5px; margin-bottom: 8px; margin-left: 10px;">
                    @if (auth()->user()->almacen_id == null)
                        <span class="dropdown">
                            <a id="" class="no-hover-icon" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="cursor: pointer;">
                                <i class="fa fa-arrow-left text-muted"></i>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs" aria-labelledby="">
                                <li style="padding: 3px 12px;"><b>Almacenes:</b></li>

                                @foreach ($almacen as $almacens)
                                    <li>
                                        <form action="{{ route('nota_venta.create') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="almacen" value="{{ $almacens->id }}">
                                            <button class="btn btn-w-m btn-link" type="submit">
                                                {{ $almacens->nombre }}
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </span>
                    @else
                        <form action="{{ route('nota_venta.create') }}" method="post" style="display:inline;">
                            @csrf
                            <input type="hidden" name="almacen" value="{{ auth()->user()->almacen_id }}">

                            <button class="btn btn-link no-hover-icon" type="submit" style="cursor: pointer; padding:0;">
                                <i class="fa fa-arrow-left text-muted"></i>
                            </button>
                        </form>
                    @endif
                </div>
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up text-muted"></i>
                    </a>
                    <a class="" href="{{ route('ventas.nota_venta') }}">
                        <i class="fa fa-times text-muted"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content" style="padding-bottom: 10px">
                <div class="row align-items-center tooltip-demo">
                    <div class="col-12 col-md-4">
                        <h3 style="margin: 0;">{{ $nota_venta->cod_nota_venta }}</h3>
                        <strong style="margin: 0;">R.U.C : </strong>{{ $empresa->ruc }}
                    </div>

                    <div class="col-12 col-md-4 text-center">
                        <h2 class="mb-0 text-nowrap" style="text-align: center">
                            NOTA DE VENTA
                        </h2>
                    </div>

                    <div class="col-12 col-md-4 d-flex flex-wrap justify-content-end align-items-center" style="gap: 4px;">

                        {{-- @if ($nota_venta->estado == 0 && $nota_venta->estado_vigente == 0 && $nota_venta->id_cotizacion == null && $nota_venta->id_cotizacion_m == null)
                            <div class="d-flex align-items-center" style="overflow: hidden;">
                                @can('nota_venta.editar')
                                    <div id="btn-slider-nota-venta"
                                        style="width: 0; overflow: hidden; transition: width 0.3s ease; display: flex; align-items: center;">

                                    </div>

                                    <button type="button" type="button"
                                            id="btn btn-toggle-nota-venta"
                                            onclick="toggleBtnsNotaVenta()"
                                            class="btn btn-sm btn-default"
                                            style="background: #fff; border: 1px solid #ccc; padding: 5px 8px; transition: transform 0.3s;">
                                        <i class="fa fa-chevron-left" id="btn-arrow-nota-venta"></i>
                                    </button>
                                @endcan
                            </div>

                            <div style="width: 1px; height: 30px; background-color: #ccc; margin: 0 6px;"></div>
                        @endif --}}

                        <a href="{{ route('nota_venta_pdf', $nota_venta->id) }}" class="btn btn-sm btn-success"
                            data-toggle="tooltip" data-placement="bottom" data-original-title="Descargar PDF">
                            <i class="fa fa-file-pdf-o fa-lg"></i>
                        </a>

                        <a href="{{ route('nota_venta.ticket', $nota_venta->id) }}" class="btn btn-sm btn-info"
                            target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="Ticket">
                            <i class="fa fa-ticket fa-lg"></i>
                        </a>

                        <a class="btn btn-sm btn-success" href="{{ route('nota_venta.print', $nota_venta->id) }}"
                            target="_blank" data-toggle="tooltip" data-placement="bottom" data-original-title="Imprimir">
                            <i class="fa fa-print fa-lg"></i>
                        </a>

                        @if (Auth::user()->email_creado == 1)
                            <form action="{{ route('email.nota_venta', $nota_venta->id) }}" method="post"
                                style="padding-right: 0; padding-left: 0;" class="btn">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-secondary" data-toggle="tooltip"
                                    data-placement="bottom" formtarget="_blank" data-original-title="Enviar por correo">
                                    <i class="fa fa-envelope fa-lg"></i>
                                </button>
                            </form>
                        @endif
                        <div style="position: relative; display: inline-block;">
                            <div id="auto" onclick="divAuto()">
                                <a class="btn btn-sm btn-success" style="background: green; border-color: green;"
                                    data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar a">
                                    <i class="fa fa-whatsapp fa-lg" style="color: white"></i>
                                </a>
                            </div>
                        </div>
                        @if (
                            $nota_venta->estado == 0 &&
                                $nota_venta->estado_vigente == 0 &&
                                $nota_venta->id_cotizacion == null &&
                                $nota_venta->id_cotizacion_m == null)
                            @can('nota_venta.editar')
                                <button type="button" class="btn btn-editar btn-sm btn-warning" onclick="click_editar()"
                                    data-toggle="tooltip" data-placement="bottom" data-original-title="Editar nota de venta"
                                    style="white-space: nowrap; margin-right: 4px;">
                                    <i class="fa fa-pencil"></i>
                                </button>

                                <button type="button" class="btn btn-no-editar no_mostrar btn-sm btn-warning"
                                    onclick="click_cancelar_editar()" data-toggle="tooltip" data-placement="bottom"
                                    data-original-title="Cancelar edición" style="white-space: nowrap; margin-right: 4px;">
                                    <i class="fa fa-times"></i>
                                </button>
                            @endcan
                        @endif
                    </div>
                    <div id="div-mostrar"
                        style="height: 0px; overflow: hidden; width: 100%; transition: height .4s; margin-right: 18px;">
                        <form action="{{ route('agregado.whatsapp_send') }}" method="post" class="btn"
                            style="text-align: none; padding-right: 0; padding-left: 0;">
                            @csrf
                            <input type="tel" name="numero" value="{{ $nota_venta->cliente->celular }}" />
                            <input type="text" name="mensaje" hidden value="" />
                            <input type="text" hidden name="url"
                                value="{{ route('nota_venta_pdf', $nota_venta->id) }}">
                            <input type="text" name="name_sin_cambio" hidden
                                value="PDF-DOC-{{ $nota_venta->cod_nota_venta }}-{{ $empresa->ruc }}" />
                            <button type="submit" class="btn btn-success"
                                style="background: green; border-color: green;" formtarget="_blank" data-toggle="tooltip"
                                data-placement="bottom" data-original-title="Enviar por Whatsapp">
                                <i class="fa fa-send fa-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" style="margin-top: -26px;">
                <div class="ibox-content " style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <br>
                    <div class="table-no mostrar">
                        <div class="row " align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> &nbsp;{{ $nota_venta->cliente->nombre }}<br>
                                        <strong>{{ $nota_venta->cliente->documento_identificacion }} :</strong>
                                        &nbsp;{{ $nota_venta->cliente->numero_documento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <br>
                                        <strong>Fecha:</strong>
                                        &nbsp;{{ Carbon\Carbon::parse($nota_venta->updated_at)->format('d-m-Y h:i:s') }}<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Condiciones Generales</h3>
                                    <div align="left">
                                        <strong>Garantia:</strong>&nbsp;
                                        @if (isset($nota_venta->id_cotizacion))
                                            {{ $nota_venta->garantia }}
                                        @else
                                            {{ $nota_venta->garantia }} @if (preg_match('/\d+/', $nota_venta->garantia))
                                                Mes(es)
                                            @endif
                                        @endif
                                        <br>
                                        <strong>Moneda:</strong>
                                        &nbsp;{{ $nota_venta->moneda->nombre }}
                                        <input type="hidden" name="moneda" id="moneda"
                                            value="{{ $nota_venta->moneda->nombre }}">
                                        <input type="hidden" id="moneda_id" value="{{ $nota_venta->moneda->id }}">
                                        <br>
                                        <strong>Forma de Pago</strong>
                                        {{ $nota_venta->forma_pago_nombre }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" align="center">
                                <div class="form-control" style="border: none;height: auto">
                                    <div align="left">
                                        <strong>Observaciones:</strong> &nbsp;{{ $nota_venta->observacion }}<br>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <br>
                    <div class="mostrar table-no">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">ITEM </th>
                                        <th style="width: 40%">Descripcion</th>
                                        <th style="width: 8%;text-align: center">Cantidad</th>
                                        <th style="width: 10%;text-align: center">P.Unitario</th>
                                        <th style="width: 10%;text-align: center">Total 
                                            <span
                                                hidden="hidden">{{ $simbologia = $nota_venta->moneda->simbolo }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <span hidden>{{ $i = 1 }}{{ $sume = 0 }}</span>
                                <tbody>
                                    @foreach ($nota_venta_re as $nota_venta_reg)
                                        <tr>
                                            <td>{{ $i++ }} </td>
                                            <td>{{ $nota_venta_reg->producto }}<br><small>{{ $nota_venta_reg->descripcion }}</small>
                                            </td>
                                            <td style="text-align: center;vertical-align: middle"> {{ $nota_venta_reg->cantidad }}</td>
                                            <td style="vertical-align: middle">
                                                <div style="display: flex;justify-content: space-between">
                                                    <div>
                                                        {{ $simbologia }}
                                                    </div>
                                                    <div>
                                                        {{ number_format(round($nota_venta_reg->precio_nacional, 2),2) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <div style="display: flex;justify-content: space-between">
                                                    <div>
                                                        {{ $simbologia }}
                                                    </div>
                                                    <div>  
                                                        {{ number_format(round($nota_venta_reg->cantidad * $nota_venta_reg->precio_nacional, 2),2) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <span
                                                hidden>{{ $sume = round($nota_venta_reg->cantidad * $nota_venta_reg->precio_nacional + $sume, 2) }}</span>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <span hidden>{{ $h = 0 }}</span>
                        </div>
                        <div class="row" style="padding-top: 120px">
                                <div class="col-sm-8">
                                    <h3 align="left" class="">
                                        <?php
                                        $end = round($sume, 2);
                                        $v = new NumeroALetras();
                                        $letra = $v->toInvoice($end, 2);
                                        ?>
                                        Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }}
                                        {{ $nota_venta->moneda->nombre }}
                                    </h3>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-control" align="center">
                                        <p class=" a"> <strong>Importe Total</strong></p>
                                        <span>{{ $nota_venta->moneda->simbolo }}</span>
                                        <span class="">{{ number_format($end, 2) }}</span>
                                        {{-- <input type="text" name="impor_t" id="impor_t" value="" readonly class="form-control-plaintext" style="width: 60%"> --}}
                                    </div>
                                </div>
                            </div>
                    </div>
                    <span hidden>{{ $h = 0 }}</span>
                    <div class="div-editar no_mostrar">
                        @if ($nota_venta->estado == 0 && $nota_venta->estado_vigente == 0)
                            @include('transaccion.venta.nota_venta.edit')
                        @endif
                    </div>

                    <br>
                    @include('layout_bancos')
                    <!-- Fin Totales de Productos -->

                    <br>
                    @include('layout_firma_pie_hoja')
                </div>
            </div>
        </div>
    </div>

    {{--  --}}
    <style>

        p#texto {
            text-align: center;
            color: black;
        }

        input#archivoInput {
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            width: 100%;
            height: 100%;
            opacity: 0;
        }

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

        .row_articulo {
            width: 400px !important;
            /* max-width: 45% !important; */
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

        /* Opciones del desplegable: sin salto de línea, sin recortar */
        .select2-nowrap .select2-results__option {
            white-space: nowrap;
        }

        /* El desplegable nunca más angosto que el select */
        .select2-nowrap {
            min-width: 400px;
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

        .mostrar {
            display: revert;
        }

        .no_mostrar {
            display: none;
        }

        .table-responsive {
            /* overflow-x: revert; */
        }

        span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1000px;
            }
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
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <!-- Sweet alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- TouchSpin -->
    <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

    <script>
        let articulosAgregados = new Set();
        $('.celda').each(function() {
            var valor = $(this).val();
            var partes = valor.split('|').map(p => p.trim());
            var id = partes[0];
            articulosAgregados.add(String(id));
        });
        $('.demo3').click(function() {
            if (document.forms['nota_vent_update'].reportValidity()) {
                swal({
                        title: "¿Estas seguro que deseas Finalizar?",
                        text: "Una vez Finalizado, no podras modificar la Nota de Venta",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3686ff",
                        confirmButtonText: "Si, Finalizar",
                        cancelButtonText: "Cancelar!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $(".finalizar").click();
                            swal("Edicion de Nota de Venta Finalizada", "Ya no podrás editar", "success");
                        } else {
                            swal("Cancelado", "Cancelado la Finalizar", "error");
                        }
                    });
            } else {
                console.log("campos incompletos");
            }
        });
        $(document).ready(function() {
            // Bind normal buttons
            Ladda.bind('.ladda-button', {
                timeout: 8000
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".select2_demo_client").select2({
            placeholder: "Seleccionar Cliente",
            width: '100%',
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_coti: tipo_coti,
                        select_default: cliente_default
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };

                        })
                    };
                },
                cache: true
            }

        });

        function mostrarMensaje(mensaje) {
            $("#divmsg").empty(); //limpiar div
            $("#divmsg").append(mensaje);
            $("#divmsg").show(200);
        }
        {{-- Darle valor a cada Boton si es Finalizar o solo Guardar --}}
        $(".guardar").on('submit', function() {
            $(".demo3").attr('disabled', true);
            var data =
                `<input value="1" type='hidden' name='submit' class="form-control" required/>  <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);

        });
        $(".finalizar").on('click', function() {
            var data =
                `<input value="2" type='hidden' name='submit' class="form-control" required/>   <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);
            // $(".guardar").remove();
        });

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

        $(document).ready(function() {
            articlesSelect2();
        });
        //Funcion para el select articles "AJAX" (productos- servicios), ejecutandose cada vez realizada una llamada
        function articlesSelect2() {
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Articulo",
                width: "400px",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{ route('pa.articles') }}",
                    dataType: 'json',
                    type: "POST",
                    // delay: 1500,
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
                            almacen: 0,
                            tipo_doc: 'manual'
                        };
                    },
                    processResults: function(data) {
                        //validador de articulos multiples
                        let data_length = data.length;
                        let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                        let articles_selected_count_ajax = articles_selected_ajax.length;
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nombre,
                                    disabled: item.disabled,
                                    tipo: item.tipo
                                };
                            })
                        };
                        
                    },
                    cache: true,
                    passive: true
                }
            });

        }

        function ajax(a) {
            let item = $('#article_text' + a).select2('data')[0];
            if(item.tipo){
                if(item.tipo == "producto"){
                    $('#tipo_articulo_' + a).val("product");
                }else{
                    console.log(item);
                    $('#tipo_articulo_' + a).val("service");
                }
                 $('#input_prod' + a).val($('#article_text' + a).val());
            }

            var articulo = document.getElementById(`input_prod${a}`).value;
            var tipo = document.getElementById(`tipo_articulo_${a}`).value;
            // console.log("tipo "+tipo);

            var almacen = $('[id="almacen_id"]').val();
            var moneda = $('[name="almacen"]').val();
            var igv = {{ $igv->igv_total }}
            $.ajax({
                type: "post",
                url: "{{ route('pa.description') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': articulo,
                    'almacen': almacen,
                    'moneda': moneda,
                    'nota_venta': true,
                    'tipo': tipo
                },
                success: function(msg) {
                    // $(`#tipo_articulo_${a}`).val(msg.id)
                    if (msg.price == 0 && msg.amount == 0) {
                        $(`#precio_sugerido${a}`).val(msg.price)
                    } else {
                        var new_price = msg.price + (msg.price * igv / 100);
                        $(`#precio_sugerido${a}`).val(Math.round(new_price * 100) / 100);
                    }
                    multi(a);
                    $(`.addmore`).prop("disabled", false);
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }
    </script>
    <script>
        var i = $('#count_articles').val();
        $(".addmore").on('click', function() {
            var data = `[
                <tr>
                    <td>
                        <button type="button" class='delete borrar e btn btn-primary btn-sm'><i class="fa fa-trash" aria-hidden="true"></i></button>
                    </td>";
                    <td>
                        <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="nuevo">
                        <select name="articulo[]" class="monto0 select2_demo_3 select_change" id='article_text${i}' onchange="ajax(${i})"  autocomplete="off" required></select>
                        </select>
                        <textarea name="article_descripcion[]" id="" class="form-control" placeholder="Descripcion del artículo" style="margin-top: 5px" rows="1"></textarea>
                        <input type="hidden" id="tipo_articulo_${i}"></input>
                        <input type="hidden" class="celda"  id="input_prod${i}" >
                    </td>
                    <td>
                        <input type='text'  id='cantidad${i}' name='cantidad[]' class="cantidad${i} form-control" onkeyup="multi(${i})" required  autocomplete="off" value="1"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" readonly id="precio_sugerido${i}" ondblclick="copy(${i})">
                    </td>
                    <td>
                        <input type='text'  id='precio${i}' name='precio[]' class="precio${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
                    </td>
                    <td>
                        <input type='text' id='total${i}'    name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
                    </td>
                </tr>
            `;
            $('.tables').append(data);
            articlesSelect2();
            i++;
            $(".addmore").prop("disabled", false);
            $(".borrar").prop("disabled", false);
        });

        function multi(a) {
            var cantidad = document.querySelector(`#cantidad${a}`).value;
            var precio = document.querySelector(`#precio${a}`).value;
            var total = cantidad * precio;
            var round_tota = parseFloat(Math.round((total) * 100) / 100).toFixed(2);
            document.querySelector(`#total${a}`).value = round_tota;
            // console.log(total);
            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });
            var red = parseFloat(Math.round((total_t) * 100) / 100).toFixed(2);
            document.querySelector(`#total_final_view`).value = red;
            $('.impor_t').html(red);
            // ajax_l();
        }

        // function ajax_l() {
        //     var numeros = $('.impor_t').html();

        //     console.log("antes_ajax" + numeros);
        //     var moneda = document.querySelector(`#moneda`).value;
        //     $.ajax({
        //         type: "post",
        //         url: "{{ route('pa.numberletters') }}",
        //         data: {
        //             '_token': $('input[name=_token]').val(),
        //             'numeros': numeros,
        //             'moneda': moneda
        //         },
        //         success: function(msg) {
        //             console.log(msg);
        //             $('.h3-total').html(msg);
        //         }
        //     });
        // }
        $(document).on('click', '.borrar', function(event) {
            event.preventDefault();
            var e = document.getElementsByClassName("e").length;
            var fila = $(this).parents("tr");
            var input_text_opt = fila.find('input[class="celda"]').val();
            if (input_text_opt) {
                articulosAgregados.delete(String(input_text_opt));
            }
            $(".addmore").prop("disabled", false);
            // ELIMINAR TR
            if (e > 1) {
                fila.closest('tr').remove();
                $(".borrar").prop("disabled", false);
                $(".addmore").prop("disabled", false);
            } else {
                $(".borrar").prop("disabled", true);
                $(".addmore").prop("disabled", false);
                $(".limp").val("");
            }
            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });
            var multiplier2 = 100;
            var total_tt = Math.round(total_t * multiplier2) / multiplier2;
            $('#total_final_view').val(total_tt);
            // ajax_l();
        });

        // MODAL BUSQUEDA DE PRODUCTO
        let debounceTimer;
        $('#search_product').on('input', function(e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                var busqueda = $(this).val();
                search_multiple(busqueda);
            }, 500); // Espera 300 ms antes de ejecutar la acción
        });
        $('#add_new_product').on('click', function() {
            search_multiple("");
            $('#search_product').val('');
        });

        let filtrarConStock = false;
        function search_multiple(busqueda) {
            // CLEAN DATABLE(?)
            if ($.fn.DataTable.isDataTable('.data_table_multiple')) {
                $('.data_table_multiple').DataTable().clear().destroy();
            }
            $('.data_table_multiple tbody').empty();

            var almacen = $('[name="almacen"]').val();
            var moneda = $('[id="moneda_id"]').find(":selected").val();
            console.log(moneda);
            $.ajax({
                type: "post",
                url: "{{ route('pa.search_multiple_manual') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': busqueda,
                    'almacen': almacen,
                    'stock': filtrarConStock ? 1 : 0,
                    'moneda': moneda
                },
                success: function(msg) {
                    // Intentar parsear si el backend no manda las cabeceras application/json correctas
                    let data = typeof msg === 'string' ? JSON.parse(msg) : msg;
                    // Validación unificada: Si no hay data o está vacío, mostrar alerta y salir
                    if (!data || data.length === 0) {
                        toastr.warning("No se encontraron resultados", '', {
                            timeOut: 3000
                        });
                        return;
                    }

                    $('.data_table_multiple').DataTable({
                        "bLengthChange": false,
                        "searching": false,
                        "autoWidth": false,
                        pageLength: 7,
                        responsive: true,
                        "aaData": data,
                        drawCallback: function(settings) {
                            $(".touchspin1").each(function() {
                                const $input = $(this);
                                // Evitar doble inicialización si el plugin ya envolvió este input
                                if (!$input.hasClass('js-touchspin-init')) {
                                    $input.addClass('js-touchspin-init').TouchSpin({
                                        buttondown_class: 'btn btn-link btn-sm',
                                        buttonup_class: 'btn btn-link btn-sm',
                                        min: 1,
                                    });
                                }
                            });
                            activarSliderSiDesborda();
                        },
                        dom: '<"top"f>rt<"dt-left-info"ip>', // i = info ("Mostrando X-Y de Z"), p = paginación
                        language: {
                            info: "Mostrando _START_-_END_ de _TOTAL_ artículos",
                            infoEmpty: "No hay artículos",
                            paginate: {
                                previous: '<i class="fa fa-chevron-left"></i>',
                                next: '<i class="fa fa-chevron-right"></i>'
                            }
                        },
                        pagingType: "simple_numbers",
                        "columns": [
                            // { "data": "id" },
                            {
                                "data": "codigo",
                                "width": "130px",
                                render: function(data, type, row) {
                                    return `
                                            <span class="codigo-toggle" 
                                                data-producto="${row.codigo_producto}" 
                                                data-original="${row.codigo_original ?? ''}" 
                                                data-showing="producto"
                                                style="cursor:pointer; display:inline-block; min-width:80px;">
                                                <span class="badge badge-info">${row.codigo_producto}</span>
                                            </span>
                                        `;
                                }
                            },
                            {
                                "data": "nombre",
                                "defaultContent": "",
                                render: function(data, type, row) {
                                    return `
                                            <div class="articulo-nombre"><span><strong>${row.nombre}</strong></span></div>
                                            <div class="small-description"><small>${row.description}</small></div>
                                        `;
                                }
                            },
                            {
                                "data": "stock",
                                "className": "precio_search precio_cantidad",
                                "defaultContent": "",
                                render: function(data, type, row) {
                                    let claseCss;
                                    return `<span class="badge badge-plain">${row.stock}</span>`;
                                }
                            },
                            {
                                data: null,
                                title: 'CANTIDAD',
                                "className": "precio_cantidad",
                                "width": "100px",
                                render: function(data, type, row) {
                                    return `
                                            <input class="touchspin1 form-control-sm input-cantidad" type="text" value="1" name="demo1" min="1" data-simbolo="${row.moneda.simbolo}" value="1" data-price="${row.price}" data-id="${row.id}">
                                        `;
                                }
                            },
                            {
                                data: 'price',
                                title: 'P. UNITARIO',
                                "width": "100px",
                                "className": "precio_dt",
                                render: function(data, type, row) {
                                    const formattedPrice = $.fn.dataTable.render.number(',',
                                        '.', 2).display(data);
                                    return `${row.moneda.simbolo} ${formattedPrice}`;
                                }
                            },
                            {
                                data: null,
                                title: 'TOTAL',
                                "width": "100px",
                                "className": "precio_dt",
                                render: function(data, type, row) {
                                    return `<span class="total" data-id="${row.id}" data-simbolo="${row.moneda.simbolo}">${row.moneda.simbolo} ${row.price.toFixed(2)}</span>`;
                                }
                            },
                            {
                                "width": "100px",
                                "className": "precio_search precio_cantidad",
                                render: function(data, type, row) {
                                    return `<button class="btn btn-primary btn-xs btn-agregar-articulo" data-id="${row.id}" data-cod_producto="${row.codigo_producto}" data-cod_original="${row.codigo_original}" data-nombre="${row.nombre}" data-type="${row.identifier}"> <i class="fa fa-plus"></i> Agregar</button>`;
                                }
                            }
                        ]
                    });
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        // console.log(eject.responseJSON.error);
                        console.log('Error');
                    }
                },
                cache: true
            });
        }
        $('.data_table_multiple').on('input change', '.input-cantidad', function() {
            const cantidad = parseFloat($(this).val()) || 0;
            const price = parseFloat($(this).data('price'));
            const simbolo = $(this).data('simbolo');
            const total = cantidad * price;
            const id = $(this).data('id');
            $(`.total[data-id="${id}"]`).text(`${simbolo} ` + `${total.toFixed(2)}`);
        });

        $('.data_table_multiple').on('click', '.btn-agregar-articulo', function(e) {
            var $btn = $(this);
            var $row = $(this).closest('tr');

            var stock = $row.find("td:eq(3)").text();
            var cantidad = $row.find('input').val();

            var count_artc = $('#count_articles').val();
            var id = $(this).data('id');
            var cod_prod = $(this).data('cod_producto');
            var cod_origi = $(this).data('cod_original');
            var nombres = $(this).data('nombre');
            var tipo = $(this).data('type');
            articulosAgregados.add(String(id));

            // var concat_data = id + " | " + cod_prod + " | " + cod_origi + " | " + nombres;
            const newOption = new Option(nombres, nombres, true, true);

            var $primerSelect = $('#article_text');
            var existePrimerSelect = $primerSelect.length > 0;
            var valorPrimerSelect = existePrimerSelect ? $primerSelect.val() : null;

            if (!existePrimerSelect || valorPrimerSelect == null || valorPrimerSelect == "") {
                console.log("first");
                    // Busca todos los selects existentes (incluyendo #articulo si existe)
                var $selectsExistentes = $('select[id^="article_text"]');

                if ($selectsExistentes.length === 0) {
                    // No queda NINGÚN select en el formulario: crear uno desde cero
                    $('.addmore').prop('disabled', false).click();
                    $selectsExistentes = $('select[id^="article_text"]');
                }

                var $selectDestino = $selectsExistentes.last();
                var idAttr = $selectDestino.attr('id');
                var count_artc = idAttr === 'article_text' ? 0 : parseInt(idAttr.replace('article_text', ''));
                var valorDestino = $selectDestino.val();
                
                if (valorDestino != null && valorDestino != "") {
                    // El último select ya tiene algo: crea uno nuevo
                    $('.addmore').prop('disabled', false).click();
                    $selectsExistentes = $('select[id^="article_text"]');
                    $selectDestino = $selectsExistentes.last();
                    idAttr = $selectDestino.attr('id');
                    count_artc = idAttr === 'article_text' ? 0 : parseInt(idAttr.replace('article_text', ''));
                }
                // $(`#tipo_articulo_${count_artc}`).val(type);
                $(`#tipo_articulo_${count_artc}`).val(tipo);
                $(`#input_prod${count_artc}`).val(id);
                
                $selectDestino.append(newOption).trigger('change');

                let debounceTimer;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    $(`#cantidad${count_artc}`).val(cantidad);
                    multi(count_artc);
                }, 1000);

            } else {
                console.log("two");
                var $selectsNumerados = $('select[id^="article_text"]').not('#article_text');
                var count_artc = $selectsNumerados.length > 0
                    ? Math.max(...$selectsNumerados.map(function () {
                        return parseInt($(this).attr('id').replace('article_text', ''));
                    }).get())
                    : null;
                var $ultimoSelect = count_artc === null ? $('#article_text') : $(`#article_text${count_artc}`);
                
                var valorActual = $ultimoSelect.val();
                if (valorActual != null && valorActual != "") {
                    $('.addmore').prop('disabled', false).click();
                    // Recalcular tras crear la fila
                    $selectsNumerados = $('select[id^="article_text"]').not('#article_text');
                    count_artc = Math.max(...$selectsNumerados.map(function () {
                        return parseInt($(this).attr('id').replace('article_text', ''));
                    }).get());
                    $ultimoSelect = $(`#article_text${count_artc}`);
                }

                $(`#tipo_articulo_${count_artc}`).val(tipo);
                $(`#input_prod${count_artc}`).val(id);
                $ultimoSelect.append(newOption).trigger('change');

                let debounceTimer;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    $(`#cantidad${count_artc}`).val(cantidad);
                    multi(count_artc);
                }, 1000);
            }

            toastr.info("Se agregó el Articulo correctamente", '', {
                timeOut: 3000
            });
        });

        $('#total_final_view').on('input change', function() {
            var total = $(this).val();
            $('#subtotal-monto').html(total);
        });

        setInterval(function() {
            $('.codigo-toggle').each(function() {
                const $el = $(this);
                const showing = $el.data('showing');

                if (showing === 'producto') {
                    $el.fadeOut(150, function() {
                        $el.html(`<span class="badge badge-info">${$el.data('original')}</span>`)
                            .fadeIn(150);
                    });
                    $el.data('showing', 'original');
                } else {
                    $el.fadeOut(150, function() {
                        $el.html(`<span class="badge badge-info">${$el.data('producto')}</span>`)
                            .fadeIn(150);
                    });
                    $el.data('showing', 'producto');
                }
            });
        }, 5000); // cambia cada 2 segundos

        function activarSliderSiDesborda() {
            setTimeout(function() {
                $('.articulo-nombre').each(function() {
                    const el = this; // elemento DOM nativo, no jQuery
                    if (el.scrollWidth > el.clientWidth) {
                        $(el).addClass('is-overflowing');
                    } else {
                        $(el).removeClass('is-overflowing');
                    }
                });
            }, 50);
            setTimeout(function() {
                $('.small-description').each(function() {
                    const el = this; // elemento DOM nativo, no jQuery
                    if (el.scrollWidth > el.clientWidth) {
                        $(el).addClass('is-overflowing');
                    } else {
                        $(el).removeClass('is-overflowing');
                    }
                });
            }, 10);
        }
        $('#add_product_data').on('shown.modal', function() {
            activarSliderSiDesborda();
        });

        $('#button_filter_stock').on('click', function() {
            const $btn = $(this);
            filtrarConStock = !$btn.hasClass('active');
            search_multiple($('#buscador_articulo').val());
        });

        function reactivarBotonModal(id) {
            var $btn = $(`.btn-agregar-articulo[data-id="${id}"]`);
            console.log($btn);
            if ($btn.length) {
                $btn.prop('disabled', false);
            }
        }

        function validarJson(data) {
            try {
                JSON.parse(data);
                return true; // es JSON válido
            } catch (e) {
                return false; // no es JSON
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
    </script>

    <script>
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

        function ajax_p_sugerido(item, elemt) {
            var item = item;
            var moneda = $("#moneda_id").val();
            $.ajax({
                type: "post",
                url: "{{ route('nota_venta.precio_sugerido') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'item': item,
                    'moneda': moneda,
                },
                success: function(msg) {
                    console.log(msg);
                    $(`#precio_sugerido${elemt}`).val(msg);
                    $(`#value${elemt}`).val(msg);

                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }

        function change_list(valor, elem) {
            var options = document.getElementById(`browsers${elem}`).getElementsByTagName('option');
            var optionVals = [];
            var i = 0;

            for (i; i < options.length; i += 1) {
                optionVals.push(options[i].value);
            }

            if (optionVals.indexOf(valor.value) > -1) {
                console.log(valor.value);
                ajax_p_sugerido(valor.value, elem);
            }
        }

        function copy(a) {
            if (a == 0) {
                var copy = document.getElementById(`precio_sugerido0`).value;
                document.getElementById(`precio0`).value = copy;
            } else {
                var copy = document.getElementById(`precio_sugerido${a}`).value;
                document.getElementById(`precio${a}`).value = copy;
            }
            multi(a);
        }
        $(document).ready(function() {
            var contador = `{{ $count_reg }}`;
            for (var index = 0; index < contador; index++) {
                var options = document.getElementById(`article_text${index}`).value;

                console.log(options);
                ajax_p_sugerido(options, index);

            }
        });

        function toggleBtnsNotaVenta() {
            const slider = document.getElementById('btn-slider-nota-venta');
            const arrow = document.getElementById('btn-arrow-nota-venta');
            const isOpen = slider.style.width !== '0px' && slider.style.width !== '0';

            if (isOpen) {
                slider.style.width = '0';
                arrow.classList.remove('fa-chevron-right');
                arrow.classList.add('fa-chevron-left');
            } else {
                slider.style.width = slider.scrollWidth + 'px';
                arrow.classList.remove('fa-chevron-left');
                arrow.classList.add('fa-chevron-right');
            }
        }

         let status = 0;
        function changeMoney() {
            console.log("moneda cambiada");
            $.ajax({
                type: "post",
                url: "{{ route('pa.money') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'status': status,
                },
                beforeSend: function() {
                    $('#loaderGif').show();
                },
                complete: function(data) {
                    /*
                    * Se ejecuta al termino de la petición
                    * */
                },
                success: function(msg) {
                    //Cambio de moneda
                    $(`#moneda_id`).val(msg.id);
                    $(`#moneda`).val(msg.nombre);
                    $(`#subtotal-simbolo`).val(msg.simbolo);
                    
                    $(`#button_changeMoney`).html(msg.other);
                    if (status == 1) {
                        status = 0;
                    } else {
                        status = 1;
                    }
                    $('#loaderGif').hide();
                    let articles_selected = document.getElementsByClassName("select2_demo_3");
                    let articles_selected_count = articles_selected.length;
                    for (let z = 0; z < articles_selected_count; z++) {
                        let selected = document.getElementsByClassName("select2_demo_3 select_change")[z]
                            .getAttribute('id');
                        if (selected == 'article_text') {
                            ajax(0);
                        } else {
                            ajax(selected.substring(8));
                        }
                    }
                    disabled_money();
                },
            });
        }
    </script>
@endsection
