@extends('layout')
@section('title', 'Nota de Venta')
@section('href_accion', route('nota_venta.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')
{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
@section('content')
    {{-- @include('layout_agregado_rapido') --}}
    {{-- Boton para modal de Clientes --}}
    {{-- @section('ruta_retorno', 'cotizacion')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o"
            aria-hidden="true"></i>cliente </a>
</div> --}}


    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h4><strong>Generar Nota de Venta</strong></h4>
                <div class="ibox-tools" style="margin-top: 5px;margin-bottom: 8px;margin-right: 10px">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="" href="{{ route('ventas.nota_venta') }}">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form action="{{ route('nota_venta.store') }}" enctype="multipart/form-data" method="post"
                    id="nota_venta_store">
                    @csrf
                    <div class="row form-label word-style">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"><strong>Cliente:</strong></label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <select class="select2_demo_client" name="cliente" id="cliente"
                                            required=""></select>
                                        <div class="input-group-append">
                                            <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente"><i
                                                    class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"><strong>Fecha Emisión:</strong></label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input type="text" name="fecha_emision" class="form-control"
                                            value="{{ date('d-m-Y') }}" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"><strong>Moneda:</strong></label>
                                <div class="col-md-10">
                                    <select name="moneda" class="form-control" required id="moneda_id">
                                        @foreach ($moneda as $monedas)
                                            <option value="{{ $monedas->id }}">{{ $monedas->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"><strong>Almacén:</strong></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" value="{{ $almacen->nombre }}" disabled>
                                    <input type="text" class="form-control" value="{{ $almacen->id }}" name="almacen"
                                        hidden>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"><strong>Forma Pago:</strong></label>
                                <div class="col-md-10">
                                    <select class="form-control" name="forma_pago" required="required">
                                        @foreach ($forma_pagos as $forma_pago)
                                            <option value="{{ $forma_pago->id }}">{{ $forma_pago->nombre }}
                                            </option>
                                        @endforeach
                                        <select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"><strong>Garantía:</strong></label>
                                <div class="col-md-10">
                                    <select class="form-control" name="garantia">
                                        @foreach ($garantia as $garantias)
                                            <option value="{{ $garantias->descripcion }}">
                                                {{ $garantias->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-form-label col-md-1"><strong>Observación:</strong></label>
                                <div class="col-md-11">
                                    <textarea class="form-control" name="observacion" id="observacion" rows="1" placeholder="Ingrese una observación">Emitimos la siguiente Nota de Venta a vuestra solicitud</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="border: 1px solid #ddd; margin: 10px 0;width: 100%;">
                        </div>
                        <div class="col-md-12">
                            <table cellspacing="0" class="table tables  " id="inp_s">
                                <thead>
                                    <tr>
                                        <th>
                                            {{-- <div>
                                                    <button type="button" class='addmore btn btn-sm btn-info' style="display: none"><i
                                                    class="fa fa-plus-square" aria-hidden="true"></i></button>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#add_product_data">
                                                    <i class="fa fa-plus-square"></i>
                                                </button> --}}
                                            <button type="button" class="btn btn-sm btn-primary btn-outline" data-toggle="modal"
                                                data-target="#add_product_data">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </th>
                                        <th style="width: 30%;max-width: 30%;">Producto</th>
                                        <th>Cantidad</th>
                                        <th>P.Sugerido</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <button type="button" class="addmore btn btn-sm btn-primary">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <select class="monto0 select2_demo_3 select_change" required=""
                                                id="articulo" onchange="ajax(0)" autocomplete="off"></select>
                                            <input type="hidden" class="celda" name="articulo[]" id="input_prod1">
                                            <input type="text" name='descripcion_item[]' class="form-control"
                                                autocomplete="off" placeholder="Descripcion del artículo"
                                                style="margin-top: 5px" />
                                        </td>
                                        <td>
                                            <input style="min-width: 96px" type='text' id='cantidad0'
                                                name='cantidad[]' max="" class="monto0 form-control"
                                                onkeyup="multi(0)" required autocomplete="off" value="1" />
                                        </td>
                                        <td>
                                            <input type="text" style="min-width: 96px" class="form-control" readonly
                                                id="precio_sugerido0" ondblclick="copy(0)">
                                        </td>
                                        <td>
                                            <input style="min-width: 96px" type='text' id='precio0' name='precio[]'
                                                class="monto0 form-control" onkeyup="multi(0)" required
                                                autocomplete="off" />
                                        </td>
                                        <td>
                                            <input style="min-width: 96px" type='text' id='total0' name='total'
                                                disabled="disabled" class="total form-control " required
                                                autocomplete="off" />
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="text-center">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Total:</strong></td>
                                        <td>
                                            <input id='sub_total' hidden name="costo_sub_total" readonly="readonly"
                                                class="form-control" required />
                                            <input id='total_final' name="costo_total" readonly="readonly"
                                                class="form-control" required />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="tooltip-demo" align="right">
                                <button class="guardar ladda-button btn btn-primary btn-outline"
                                    type="submit">Guardar</button>
                                <button class=" btn btn-primary  demo3 float-right" style="margin-left: 10px;"
                                    type="button">Guardar y Finalizar</button>
                                <button class="btn btn-secondary ladda-button finalizar " id="finalizar" hidden=""
                                    data-style="zoom-out">
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal AGREGAR CON UN CLICK UN ARTICULO -->
    <div class="modal fade bd-example-modal-lg" id="add_product_data" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Agregado Rápido de Artículos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12" style="margin-bottom: 15px">
                            <input type="text" name="" id="search_product" class="form-control"
                                placeholder="Buscar por código o nombre del producto o Servicio" autocomplete="off">
                            <small style="padding-right: 12px;padding-left: 12px ">Filtrado por producto o servicio</small>
                        </div>
                        <div class="col-lg-12">
                            <input type="hidden" name="" id="count_articles" value="">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover data_table_multiple"
                                    style="font-size: 90%;border-top: 1px solid #e7eaec;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>CÓDIGO</th>
                                            <th>ARTÍCULO</th>
                                            <th>STOCK</th>
                                            <th>PRECIO U. SUGERIDO </th>
                                            <th>PRECIO S/IGV</th>
                                            <th>PRECIO C/IGV</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close_add_product_data"
                        data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
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

        .text_des {
            border-radius: 10px;
            border: 1px solid #e5e6e7;
            width: 80px;
            padding: 6px 12px;
        }

        .a {
            color: red
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 12px;
        }

        .select2-container--default .select2-selection--single {
            border: none;
        }

        span.select2.select2-container.select2-container--default {
            width: 100% !important;
            max-width: 50vw !important;
            background-color: #FFFFFF;
            background-image: none;
            border-radius: 1px;
            display: block;
            padding: 3px 12px;
            border: 1px solid #e5e6e7;
            /* margin-bottom: 15px; */
        }

        .form-group.row>div>span.select2.select2-container.select2-container--default {
            max-width: 100% !important;
        }

        .select2-hidden-accessible {
            width: 0px;
            margin: 0px;
            width: auto;
        }

        @media only screen and (max-width: 1498px) {
            .td_selected>span.select2.select2-container.select2-container--default {
                width: 100% !important;
                min-width: 376px !important;
            }
        }

        @media (min-width: 992px) {
            #add_product_data>.modal-lg {
                max-width: 1200px;
            }
        }
    </style>
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
    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <!-- Sweet alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script type="text/javascript">
        $('.demo3').click(function(e) {
            if (document.forms['nota_venta_store'].reportValidity()) {
                swal({
                        title: "¿Estas seguro que deseas Finalizar?",
                        text: "Una vez Finalizado, No se podrá editar la Nota de Venta",
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
                            swal("Nota de Venta Finalizada", "", "success");
                            $('.finalizar').click();
                            $('.gurdar').attr('disabled', true);
                        } else {
                            swal("Cancelado", "Cancelado la Finalizar", "error");
                        }
                    });
            } else {
                console.log("campos incompletos ");
            }
        });

        $(document).ready(function() {
            // Bind normal buttons
            Ladda.bind('.ladda-button', {
                timeout: 8000
            });
        });

        // $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

        function mostrarMensaje(mensaje) {
            $("#divmsg").empty(); //limpiar div
            $("#divmsg").append(mensaje);
            $("#divmsg").show(200);
        }
        $(".guardar").on('submit', function(e) {
            $(".demo3").attr('disabled', true);
            var data =
                `<input value="1" type='hidden' name='submit' class="form-control" required/>  <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);

        });
        $(".finalizar").on('click', function(e) {
            var data =
                `<input value="2" type='hidden' name='submit' class="form-control" required/>   <input type='hidden' name='accion' readonly="readonly" value="guardar"  hidden="hidden" />`;
            $('#inp_s').append(data);
            //  $(".guardar").dis();
        });
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
                    var tipo_coti = 2;
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term, // search term
                        tipo_coti: tipo_coti
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
    </script>

    <script>
        var i = 2;

        $(".addmore").on('click', function() {
            var data = `[
        <tr>
        <td>
            <button type="button" class="addmore btn btn-sm btn-primary">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </td>";
        <td>
            <select class="monto${i} select2_demo_3 select_change" required="" id="articulo${i}" onchange="ajax(${i})" autocomplete="off"></select>
            <input type="hidden" class="celda"  name="articulo[]" id="input_prod${i}" >
            <input type="text"  {{-- id='descripcion0' --}}  name='descripcion_item[]' class="form-control"   autocomplete="off" placeholder="Descripcion del artículo" style="margin-top: 5px" />
        </td>
        <td>
            <input type='text' style="min-width: 96px" value="1" id='cantidad${i}' name='cantidad[]'  class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
            <input type="text" style="min-width: 96px" class="form-control" readonly id="precio_sugerido${i}" ondblclick="copy(${i})">
        </td>
        <td>
            <input type='text' style="min-width: 96px"  id='precio${i}' name='precio[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
            <input type='text' id='total${i}'  style="min-width: 96px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
        </td>

        </tr>
        `;
            // $(`.monto${a}`).each(function(){

            $('.tables').append(data);
            $('#count_articles').val(i);
            i++;
            articlesSelect2();
        });
    </script>
    <script>
        //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
        $(document).ready(function() {
            articlesSelect2();
        });
        //Funcion para el select articles "AJAX" (productos- servicios), ejecutandose cada vez realizada una llamada
        function articlesSelect2() {
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Articulo",
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
                        // for(var z=0;z<articles_selected_count_ajax;z++){
                        //     var selected_ajax=document.getElementsByClassName("select2_demo_3 select_change")[z].value;
                        //     for(var y=0;y<data_length;y++){
                        //         if(selected_ajax == data[y].id+ " | " + data[y].codigo + " | " + data[y].codigo_original + " | " + data[y].nombre){
                        //             if(data[y].tipo == 'producto'){
                        //                 data[y].disabled=true;
                        //             }else{
                        //                 data[y].disabled=false;
                        //             }
                        //         }
                        //     }
                        // }
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id + " | " + item.codigo + " | " + item.codigo_original +
                                        " | " + item.nombre,
                                    text: item.id + " | " + item.codigo + " | " + item.codigo_original +
                                        " | " + item.nombre,
                                    disabled: item.disabled
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
                document.getElementById(`input_prod1`).value = articulo;

            } else {
                var articulo = document.getElementById(`articulo${a}`).value;
                document.getElementById(`input_prod${a}`).value = articulo;

            }

            var almacen = $('[id="almacen_id"]').val();
            var moneda = $('[id="moneda_id"]').val();
            var igv = {{ $igv->igv_total }}
            $.ajax({
                type: "post",
                url: "{{ route('pa.description') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': articulo,
                    'almacen': almacen,
                    'moneda': moneda
                },
                success: function(msg) {
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

        function multi(a) {
            var total = 1;
            var totales = 0;
            var change = false; //
            $(`.monto${a}`).each(function() {
                if (!isNaN(parseFloat($(this).val()))) {
                    change = true;

                    total *= parseFloat($(this).val());
                }
            });
            total = (change) ? total : 0;

            var cantidad = document.querySelector(`#cantidad${a}`).value;
            var precio = document.querySelector(`#precio${a}`).value;
            var multiplier = 100;
            var final = precio * cantidad;
            var final_decimal = Math.round(final * multiplier) / multiplier;
            console.log(final_decimal);
            document.getElementById(`total${a}`).value = final_decimal;

            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            var total_tt = Math.round(total_t * multiplier2) / multiplier2;

            $('#sub_total').val(total_tt);

            var igv_valor = 0;
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv = subtotal * igv_valor / 100;

            var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            var end = igv_decimal + parseFloat(subtotal);

            var end2 = Math.round(end * multiplier2) / multiplier2;

            // document.getElementById("igv").value = igv_decimal;
            document.getElementById("total_final").value = end2;

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

            var igv_valor = 18;
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv = parseFloat(subtotal) * igv_valor / 100;
            // var end=parseFloat(igv)+parseFloat(subtotal);

            // console.log(typeof igv);
            // console.log(typeof end);
            // document.getElementById("igv").value = igv;
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
    </script>
    <script>
        // MODAL BUSQUEDA DE PRODUCTO
        let debounceTimer;
        $('#search_product').on('keyup', function(e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                var busqueda = $(this).val();
                search_multiple(busqueda);
            }, 500); // Espera 300 ms antes de ejecutar la acción
        });

        function search_multiple(busqueda) {
            // CLEAN DATABLE(?)
            if ($.fn.DataTable.isDataTable('.data_table_multiple')) {
                $('.data_table_multiple').DataTable().clear().destroy();
            }
            $('.data_table_multiple tbody').empty();

            var almacen = $('[id="almacen_id"]').val();
            var moneda = $('[id="moneda_id"]').val();
            $.ajax({
                type: "post",
                url: "{{ route('pa.search_multiple') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'articulo': busqueda,
                    'almacen': almacen,
                    'moneda': moneda
                },
                success: function(msg) {
                    if (validarJson(msg)) {
                        var data = JSON.parse(msg);
                        if (data.length === 0) {
                            toastr.warning("No se encontraron resultados",
                                '', {
                                    timeOut: 3000
                                });
                            return;
                        }
                    } else if (msg == "[]") {
                        toastr.warning("No se encontraron resultados",
                            '', {
                                timeOut: 3000
                            });
                        return;
                    } else {
                        toastr.warning("No se encontraron resultados",
                            '', {
                                timeOut: 3000
                            });
                        return;
                    }
                    var quantity = $('#quantity_modal').val();
                    if (quantity == "") {
                        quantity = 1;
                    }
                    $('.data_table_multiple').DataTable({
                        "autoWidth": false,
                        "bLengthChange": false,
                        "searching": false,
                        pageLength: 10,
                        responsive: true,
                        "aaData": data,
                        "columns": [{
                                "data": "id"
                            },
                            {
                                "data": "codigo"
                            },
                            {
                                "data": "nombre",
                                "defaultContent": ""
                            },
                            {
                                "data": "stock",
                                "defaultContent": ""
                            },
                            {
                                data: null,
                                title: 'CANTIDAD',
                                render: function(data, type, row, meta) {
                                    return `<input type="number" class="form-control form-control-sm input-cantidad" min="1" max="${row.stock}" value="1" data-price="${row.price}" data-id="${row.id}" />`;

                                }
                            },
                            {
                                data: 'price',
                                title: 'PRECIO U.',
                                render: function(data, type, row) {
                                    const simbolo = row.moneda
                                        .simbolo; // Obtén el símbolo de la moneda
                                    const formattedPrice = $.fn.dataTable.render.number(',',
                                        '.', 2).display(data); // Formatea el precio
                                    return `${simbolo} ${formattedPrice}`; // Retorna el precio con el símbolo
                                }
                            },
                            {
                                data: null,
                                title: 'PRECIO TOTAL',
                                render: function(data, type, row, meta) {
                                    return `<span class="total" data-id="${row.id}">${row.moneda.simbolo} ${row.price.toFixed(2)}</span>`;
                                }
                            },
                        ]
                    });
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }
        $('.data_table_multiple').on('input', '.input-cantidad', function() {
            const cantidad = parseFloat($(this).val()) || 0;
            const price = parseFloat($(this).data('price'));
            const total = cantidad * price;
            var simbolo = $('#basic-addon3').html();
            const id = $(this).data('id');
            $(`.total[data-id="${id}"]`).text(`${simbolo}` + `${total.toFixed(2)}`);
        });

        $('.data_table_multiple').on('click', 'tbody > tr', function(e) {
            if ($(e.target).is('input') || $(e.target).closest('td').index() === 4) {
                return;
            }
            var stock = $(this).find("td:eq(3)").text();
            var cantidad = $(this).find('input').val();
            console.log(stock);
            console.log(cantidad);
            if (parseFloat(cantidad) > parseFloat(stock)) {
                console.log("dentro del if");
                toastr.warning("Cantidad mayor al stock",
                    '', {
                        timeOut: 3000
                    });
                return;
            }
            var count_artc = $('#count_articles').val();
            var id = $(this).find("td:eq(0)").text();
            var codigos = $(this).find("td:eq(1)").text();
            var nombres = $(this).find("td:eq(2)").text();

            var concat_data = id + " | " + codigos + " | " + nombres;
            const newOption = new Option(concat_data, concat_data, true, true);
            const selectedValue = $('#articulo').val();
            if (count_artc == "" && selectedValue == null) {
                $('#articulo').append(newOption).trigger('change');
                $('#count_articles').val(1);
                //
                let debounceTimer;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    $(`#cantidad0`).val(cantidad);
                    console.log("se cambio de cantidad");
                }, 1500);
                //
            } else {
                $('.addmore').click();
                var count_artc = $('#count_articles').val();
                $(`#articulo${count_artc}`).append(newOption).trigger('change');

                //
                let debounceTimer;
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    $(`#cantidad${count_artc}`).val(cantidad);
                    console.log("se cambio de cantidad")
                }, 1500);
                //
            }
            toastr.info("Se agregó el Articulo correctamente",
                '', {
                    timeOut: 3000
                });
        });

        function validarJson(data) {
            try {
                JSON.parse(data);
                return true; // es JSON válido
            } catch (e) {
                return false; // no es JSON
            }
        }
    </script>
    @include('transaccion.venta.clientes.modal_create')
@stop
