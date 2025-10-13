@extends('layout')
@section('title', 'Guia Remision Agregar')
@section('breadcrumb', 'Guia Remision')
@section('breadcrumb2', 'Guia Remision')
@section('href_accion', route('guia_remision.index'))
@section('value_accion', 'Atras')
{{-- @extends('layout_agregado_rapido') --}}

{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
{{-- <script type="text/javascript">

</script> --}}
@section('content')


    {{-- @section('form_action_modal_cliente', route('agregado_rapido.cliente_cotizado'))
@section('ruta_retorno', 'guia_remision')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div> --}}

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-title">
                    <h5>Crear Guía Remisión</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('guia_remision.store') }}" id="pro" enctype="multipart/form-data"
                        method="post" onsubmit="return valida(this)">
                        @method('POST')
                        @csrf
                        <div class="row word-style">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Cliente:</strong></label>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <select class="select2_demo_client" name="cliente" id="cliente" required=""
                                                onchange="change_cli()"></select>
                                            </select>
                                            <div class="input-group-append">
                                                <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente"><i
                                                        class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Almacén:</strong></label>
                                    <div class="col-md-10">
                                        <input type="text" readonly name="" id=""
                                            value="{{ $id_almacen->nombre }} - {{ $id_almacen->abreviatura }}"
                                            class="form-control">
                                        <input type="text" id="almacen_in" name="almacen" value="{{ $almacen }}"
                                            hidden>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-4"><strong>F. Emis.:</strong></label>
                                            <div class="col-md-8">
                                                <input type="text" style="font-size: 12px" name="fecha_emision"
                                                    class="form-control" value="{{ date('Y/m/d') }}" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-4">F.Entrega:</label>
                                            <div class="col-md-8">
                                                <input type="date" name="fecha_entrega" class="form-control"
                                                    required="required" min="{{ $fecha_1 }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Sucursal:</strong></label>
                                    <div class="col-md-10">
                                        <div class="tooltip-demo">
                                            <div class="input-group-prepend" style="column-gap: 10px">
                                                <input list="sucursal_list" id="sucursal_input" name="sucursal_cli"
                                                    data-toggle="tooltip" class="form-control" data-placement="top"
                                                    title="Sucursal" required onchange="select_sucursal()"
                                                    style="width: 65%" autocomplete="off">
                                                <datalist id="sucursal_list">
                                                    {{-- <option value=""></option> --}}
                                                </datalist>
                                                <input id="postal_input" class="form-control" name="postal_input"
                                                    style="width: 25%" data-toggle="tooltip" data-placement="top"
                                                    title="Codigo Ubigeo" required onkeyup="this.value=NumText(this.value)"
                                                    maxlength="6" minlength="6">
                                                <a href="https://account.geodir.co/recursos/ubigeo-inei-peru.html"
                                                    target="_blank" style="margin: auto"><i class="fa fa-question-circle"
                                                        style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999"></i></a>
                                            </div>
                                            <input type="hidden" name="" id="input_suc_array">
                                            <input type="hidden" name="" id="input_post_array">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Motivo T.:</strong></label>
                                    <div class="col-md-10">
                                        <select name="motivo_traslado" class="form-control">
                                            @foreach ($motivo_traslado as $motivo_traslad)
                                                <option id="{{ $motivo_traslad->id }}">{{ $motivo_traslad->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"><strong>Transporte:</strong></label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="tipo_transporte" autocomplete="off"
                                            onchange="test(this)" id="select_id" required>
                                            <option value="">Escoge el tipo de transporte</option>
                                            {{-- <option value="0">Sin Transporte</option> --}}
                                            <option value="1">Transporte Público</option>
                                            <option value="2">Transaporte Privado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row" id="transporte_publico" hidden="hidden">
                                    <label class="col-form-label col-md-1"><strong>V. Público:</strong></label>
                                    <div class="col-md-11">
                                        <select class="form-control" name="vehiculo_publico" autocomplete="off"
                                            id="vehiculo_publico">
                                            <option value="">Ningún Vehículo</option>
                                            @foreach ($transporte_publico as $transporte_publicos)
                                                <option value="{{ $transporte_publicos->id }}">
                                                    {{ $transporte_publicos->nombre }} /{{ $transporte_publicos->ruc }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="transporte_privado" hidden="hidden">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-2"><strong>V. Privado:</strong></label>
                                            <div class="col-md-10">
                                                <select class="form-control" name="vehiculo" autocomplete="off"
                                                    id="vehiculo_privado">
                                                    <option value="">Ningún Vehículo</option>
                                                    @foreach ($vehiculo as $vehiculos)
                                                        <option value="{{ $vehiculos->id }}">{{ $vehiculos->placa }}
                                                            /{{ $vehiculos->marca }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-2"><strong>Conductor:</strong></label>
                                            <div class="col-md-10">
                                                <select class="form-control" name="conductor" autocomplete="off"
                                                    id="conductor">
                                                    <option value="">Ningún Conductor</option>
                                                    @foreach ($personal as $ersonals)
                                                        <option disabled="disabled">------------------------------</option>
                                                        <option value="{{ $ersonals->id }}">{{ $ersonals->nombres }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-1"><strong>Observación:</strong></label>
                                    <div class="col-md-11">
                                        <textarea name="observacion" class="form-control" rows="1s">Guía Electrónica Emitida para el Cliente  </textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table cellspacing="0" class="table tables">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">
                                                    {{-- <input class='check_all' type='checkbox'
                                                        onclick="select_all()" /> --}}
                                                    <button type="button" class='addmore btn btn-sm btn-success'> <i
                                                            class="fa fa-plus-square" aria-hidden="true"></i> </button>
                                                </th>
                                                <th style="width: 600px">Artículo</th>
                                                <th style="width: 100px">Stock</th>
                                                <th style="width: 100px">Cantidad</th>
                                                <th style="width: 500px">Números Series</th>
                                                <th style="width: 100px">Peso (KGM)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{-- <input type='checkbox' class="case"> --}}
                                                    <button type="button" class="btn btn-sm btn-danger"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                                <td class="td_selected">
                                                    <select class="select2_demo_productos" name="articulo[]"
                                                        id="articulo" style="width: 100%;" onchange="ajax(0);"
                                                        required></select>
                                                    <textarea class="form-control" name="descripcion[]" placeholder="Detalle del Producto" id=""
                                                        rows="1" style="margin-top: 5px"></textarea>
                                                </td>
                                                <td>
                                                    <input style="min-width: 100px" type='text' id='stock0'
                                                        readonly="readonly" name='stock[]' class="form-control" required
                                                        autocomplete="off" />
                                                </td>
                                                <td class="tooltip-demo">
                                                    <input style="min-width: 100px" type='text' id='cantidad0'
                                                        name='cantidad[]' max="" class="monto0 form-control"
                                                        required autocomplete="off" data-placement="top"
                                                        title="No se puede procesar productos con stock '0'"
                                                        onchange="peso_cantidad(0)" />
                                                </td>
                                                <td>
                                                    <textarea style="min-width: 250px" name="series[]" id="series0" class="form-control prod_text" placeholder="escanear N/S"></textarea>
                                                </td>
                                                <td>
                                                    <input style="min-width: 100px" id='peso0' name='peso[]'
                                                        type="text" class="form-control" value=""
                                                        readonly="readonly">
                                                    <input type="hidden" id="peso_base0">
                                                </td>

                                                <span id="spTotal"></span>
                                            </tr>

                                        </tbody><br>

                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" id="boton" class="btn btn-primary float-right"
                                        style="background: #0400c2; border-radius:8px; font-weight:450; font-size: 1rem; padding: 7px 20px;">
                                        <strong>Guardar</strong>
                                    </button>
                                    {{-- <button class="btnn float-right" id="finalizar_button" type="button"
                                        style="margin-left:10px; background: #6c757d; border-radius:8px; font-weight:450; font-size: 1rem; padding: 7px 20px; border: none; color: white;">
                                        <strong>Guardar y finalizar</strong>
                                    </button> --}}
                                    {{-- <button class="btn btn-primary float-right" type="submit" id="boton"><i
                                            class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp; --}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>




    {{-- <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');

        .word-style select,
        .word-style input,
        .word-style span,
        .word-style label {
            font-family: 'Outfit', sans-serif;
            font-size: 11px;
        }

        .required {
            color: red;
            margin-left: 2px;
        }
    </style> --}}

    {{-- <script>
        function mostrarTransporte() {
            const tipo = document.getElementById("select_transporte").value;
            const grupoVehiculo = document.getElementById("grupo_vehiculo");
            const labelVehiculo = document.getElementById("label_vehiculo");
            const contenedorVehiculo = document.getElementById("contenedor_vehiculo");
            const grupoConductor = document.getElementById("grupo_conductor");

            contenedorVehiculo.innerHTML = '';
            grupoVehiculo.style.display = 'none';
            grupoConductor.style.display = 'none';

            if (tipo === '1') { // Público
                grupoVehiculo.style.display = 'flex';
                labelVehiculo.textContent = 'Vehículo';

                const select = document.createElement("select");
                select.className = "form-control";
                select.name = "vehiculo_publico";
                select.innerHTML = `
        <option value="">Ningún Vehículo</option>
        @foreach ($transporte_publico as $transporte_publicos)
        <option value="{{ $transporte_publicos->id }}">{{ $transporte_publicos->nombre }} / {{ $transporte_publicos->ruc }}</option>
        @endforeach
      `;
                contenedorVehiculo.appendChild(select);
            } else if (tipo === '2') { // Privado
                grupoVehiculo.style.display = 'flex';
                grupoConductor.style.display = 'flex';
                labelVehiculo.textContent = 'Vehículo';

                const select = document.createElement("select");
                select.className = "form-control";
                select.name = "vehiculo_privado";
                select.innerHTML = `
        <option value="">Ningún Vehículo</option>
        @foreach ($vehiculo as $vehiculos)
        <option value="{{ $vehiculos->id }}">{{ $vehiculos->placa }} / {{ $vehiculos->marca }}</option>
        @endforeach
      `;
                contenedorVehiculo.appendChild(select);
            }
        }
    </script> --}}



    <style type="text/css">
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

        .ruc {
            border-radius: 10px;
            height: 150px;
        }

        .form-control {
            border-radius: 10px;
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

        input[type=date],
        input[type=datetime-local],
        input[type=month],
        input[type=time] {
            font-size: 12px;
        }

        @media only screen and (max-width: 1497px) {
            .td_selected>span.select2.select2-container.select2-container--default {
                min-width: 376px !important;
            }
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

    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>

    <!-- Jquery Validate -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    {{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
    <script>
        $(document).ready(function() {
            $(".prod_text").keypress(function(e) {
                if (e.which == 13) {
                    setTimeout(function() {
                        e.target.value += ' | ';
                    }, 4);
                    e.preventDefault();
                }
            });
            articlesSelect2();
            // $('.select2_demo_almacen').select2();
        });

        function valida(f) {
            var boton = document.getElementById("boton");
            var completo = true;
            var incompleto = false;
            if (f.elements[0].value == "") {
                alert(incompleto);
            } else {
                boton.type = 'button';
            }
        }
    </script>
    {{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
    <script>
        var i = 2;
        $(".addmore").on('click', function() {
            var data = `[
        <tr>
        <td>
        <button type='button' class='btn btn-danger btn-xs' style='margin-top: 5px; margin-left: 5px;' onclick='$(this).closest("tr").remove();'><i class='fa fa-trash'></i></button>
        </td>";
        <td class="td_selected">
        <select class="select2_demo_productos" name="articulo[]" id="articulo${i}" style="width: 100%;" onchange="ajax(${i});" required></select>
        <textarea class="form-control" name="descripcion[]" placeholder="Detalle del Producto" id="" rows="1" style="margin-top: 5px"></textarea>
        </td>
        <td>
        <input style="min-width: 100px" type='text' id='stock${i}' name='stock[]' readonly="readonly" class="form-control" required  autocomplete="off"/>
        </td>
        <td>
        <input style="min-width: 100px" type='text' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control prod_text"  required  onchange="peso_cantidad(${i})" autocomplete="off" data-placement="top" title="No se puede procesar productos con stock '0'"/>
        </td>
        <td>
        <textarea style="min-width: 250px" id='series${i}' name='series[]' class="form-control" placeholder="escanear N/S"></textarea>
        </td>
        <td>
        <input style="min-width: 100px" id='peso${i}' name='peso[]' type="text" class="form-control" value="0"  readonly="readonly">
        <input type="hidden" id="peso_base${i}">
        </td>
        </tr>`;
            $('table').append(data);
            articlesSelect2();
            i++;
        });
    </script>
    <script>
        $(".select2_demo_client").select2({
            theme: "bootstrap",
            placeholder: "Seleccionar Cliente",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.clients') }}",
                dataType: 'json',
                type: "POST",
                delay: 10,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term // search term
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

        function articlesSelect2() {
            $(".select2_demo_productos").select2({
                placeholder: "Seleccionar Producto",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{ route('pa.ajax_remision') }}",
                    dataType: 'json',
                    type: "POST",
                    // delay: 1500,
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            id: params.id,
                            search: params.term // search term

                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id + " | " + item.cod_prod + " | " + item.cod_origi +
                                        " | " + item.nombre,
                                    text: item.id + " | " + item.cod_prod + " | " + item.cod_origi +
                                        " | " + item.nombre,
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
            if (a == 0) {
                var articulo = document.getElementById(`articulo`).value;
            } else {
                var articulo = document.getElementById(`articulo${a}`).value;
            }
            var almacen = document.getElementById(`almacen_in`).value;
            $.ajax({
                type: "post",
                url: "{{ route('guia_remision.peso_stock') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'almacen': almacen,
                    'articulo': articulo
                },
                success: function(msg) {
                    $(`#peso${a}`).val(msg.peso);
                    $(`#peso_base${a}`).val(msg.peso);
                    $(`#stock${a}`).val(msg.stock);
                    $(`#cantidad${a}`).attr('max', msg.stock);
                    if (msg.stock == 0) {
                        $(`#cantidad${a}`).on('keydown paste focus mousedown', function(e) {
                            if (e.keyCode != 9) // ignore tab
                                e.preventDefault();
                        });
                        $(`#cantidad${a}`).attr('data-toggle', 'tooltip');
                    } else {
                        $(`#cantidad${a}`).off('keydown paste focus mousedown');
                        $(`#cantidad${a}`).attr('data-toggle', '');

                    }
                    // sum_total();
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });

        }

        function peso_cantidad(b) {
            if (b == 0) {
                var articulo = document.getElementById(`articulo`).value;
            } else {
                var articulo = document.getElementById(`articulo${b}`).value;
            }

            var cantidad = $(`#cantidad${b}`).val();
            var peso = $(`#peso_base${b}`).val();

            var total = parseFloat(cantidad) * parseFloat(peso);
            console.log(total)
            $(`#peso${b}`).val(Math.round(total * 100) / 100);

        }
    </script>
    <script>
        $(".delete").on('click', function() {
            $('.case:checkbox:checked').parents("tr").remove();
            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });
            $('#sub_total').val(total_t);

            var igv_valor = {{ $igv->renta }};
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv = parseFloat(subtotal) * igv_valor / 100;
            var end = parseFloat(igv) + parseFloat(subtotal);

            // console.log(typeof igv);
            // console.log(typeof end);
            document.getElementById("igv").value = igv;
            document.getElementById("total_final").value = end;
        });
    </script>

    <script>
        function select_all() {
            $('input[class=case]:checkbox').each(function() {
                if ($('input[class=check_all]:checkbox:checked').length == 0) {
                    $(this).prop("checked", false);
                } else {
                    $(this).prop("checked", true);
                }
            });
        }

        function Clear(elem) {
            elem.value = '';
        }
    </script>

    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    <style type="text/css">
        .a {
            color: red
        }
    </style>
    <script>
        function change_cli() {
            var cliente = $('#cliente').val();
            $('#sucursal_list').empty();
            $('#postal_input').val("");
            $('#sucursal_input').val("");
            $.ajax({
                type: "post",
                url: "{{ route('guia_remision.ajax_sucursal') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'cliente': cliente
                },
                success: function(msg) {

                    let cod_co = msg.cod_postal;
                    let msg_length = cod_co.length;
                    // console.log(msg_length)
                    var list = document.getElementById('sucursal_list');
                    var p_list = document.getElementById('postal_cod_list');

                    if (msg_length == 1) {
                        $('#sucursal_input').val(msg.sucursal[0]);
                        $('#postal_input').val(msg.cod_postal[0]);
                        document.getElementById('input_post_array').value = msg.cod_postal[0];
                        document.getElementById('input_suc_array').value = msg.sucursal[0];
                    } else {
                        $('#sucursal_input').attr('placeholder', 'Seleccionar Sucursal');
                        $('#postal_input').attr('placeholder', 'Selec. Codigo Ubigeo');
                        for (let i = 0; i < msg_length; i++) {
                            var option = document.createElement('option');
                            option.value = msg.sucursal[i];
                            list.appendChild(option);
                            document.getElementById('input_post_array').value = msg.cod_postal;
                            document.getElementById('input_suc_array').value = msg.sucursal;

                            // var option2 = document.createElement('option');
                            // option2.value = msg.cod_postal[i];
                            // p_list.appendChild(option2);
                        }
                    }

                    // sum_total();

                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }

        function select_sucursal() {
            var valor_input = $('#sucursal_input').val();
            var all_suc = document.getElementById('input_suc_array').value;
            var all_postal = document.getElementById('input_post_array').value;
            // CODIGO PARA SEPARAR LAS SUCURSALES
            const split_suc = all_suc.split(',');
            // CODIGO PARA SEPARAR LASA SUCURSALES
            const split_post = all_postal.split(',');
            for (let i_suc = 0; i_suc < split_suc.length; i_suc++) {
                var el_suc = split_suc[i_suc];
                console.log(el_suc);
                if (el_suc == valor_input) {
                    $('#postal_input').val(split_post[i_suc]);
                }

            }
        }
    </script>
    <script>
        function test(a) {
            var x = (a.value || a.options[a.selectedIndex].value); //crossbrowser solution =)
            if (x == 2) /*Transaporte Privado*/ {
                document.getElementById("transporte_privado").removeAttribute("hidden");
                document.getElementById("transporte_publico").setAttribute("hidden", "hidden");

                document.getElementById("vehiculo_privado").setAttribute("required", "required");
                document.getElementById("conductor").setAttribute("required", "required");
                document.getElementById("vehiculo_publico").removeAttribute("required");


            }
            if (x == 0) /*Sin Transporte*/ {
                document.getElementById("transporte_privado").setAttribute("hidden", "hidden");
                document.getElementById("transporte_publico").setAttribute("hidden", "hidden");

                document.getElementById("vehiculo_publico").removeAttribute("required");
                document.getElementById("vehiculo_privado").removeAttribute("required");
                document.getElementById("conductor").removeAttribute("required");


            }
            if (x == 1) /*Transporte Público*/ {
                document.getElementById("transporte_publico").removeAttribute("hidden");
                document.getElementById("transporte_privado").setAttribute("hidden", "hidden");

                document.getElementById("vehiculo_publico").setAttribute("required", "required");
                document.getElementById("vehiculo_privado").removeAttribute("required");
                document.getElementById("conductor").removeAttribute("required");
            }
        }

        function delete_guion(string) { //solo letras y numeros
            return string.replace(/-/g, "");
        }
    </script>

    @include('transaccion.venta.clientes.modal_create')

@endsection
