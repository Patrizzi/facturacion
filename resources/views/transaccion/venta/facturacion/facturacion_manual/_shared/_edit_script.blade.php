<style>
    .text_des {
        border-radius: 10px;
        border: 1px solid #e5e6e7;
        width: 80px;
        padding: 6px 12px;
    }

    .check {
        -webkit-appearance: none;
        height: 34px;
        background-color: #ffffff00;
        -moz-appearance: none;
        border: none;
        appearance: none;
        width: 80px;
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

    span.select2-container.select2-container--default.select2-container--open {
        z-index: 2126 !important;
    }
</style>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function toggle() {
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    }
    // Clientes
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
                var tipo_coti = 1;
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
                //LIMPIAR EL INPUT GUIA REMISION
                $('#guia_save_inp').val("0");
            },
            cache: true
        }
    });
    $('.select2_demo_client').on('select2:select', function(e) {
        $('#guia_remi_input').val('0');
        var s = document.getElementById("guia_list");
        var numChilds = s.children.length;
        for (var i = 0; i < numChilds; i++) {
            s.children[0].remove()
        }
        var data = e.params.data;
        $.ajax({
            type: "post",
            url: "{{ route('facturacion_manual.ajx_remision') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'id_cliente': data.id,
            },
            success: function(msg) {
                var miSpan = document.getElementById('lista_gr');
                while (miSpan.firstChild) {
                    miSpan.removeChild(miSpan.firstChild);
                }
                $('#guia_save_inp').val("0");

                if (typeof(msg) == "object") {
                    for (let index = 0; index < msg.length; index++) {
                        $('#guia_list').append("<option value='" + msg[index] + "'>");
                    }
                }
            },
            error: function(eject) {
                if (eject.status === 400) {
                    console.log(eject.responseJSON.error);
                }
            },
            cache: true
        });
    });
    // Tipo Operacion
    $('.select2_tipo_op').select2();
    // Almacen
    $('.select2_tipo_almacen').select2();
    // Medio de Pago
    $('.select2_mediopago').select2();
    // Detraccion
    $('.select2_tipodetrac').select2();

    // Guia de Remision
    $('#guia_remi_input').on('change', function() {
        var valor = this.value;
        var conversion = valor.replace(/ /g, "|");
        var listaNombres = valor.split(" ");
        console.log(listaNombres);
        for (let i = 0; i < listaNombres.length; i++) {
            var compa = /^([A-Z0-9]{3,4})-\d{1,8}$/;
            var seg = compa.test(listaNombres[i])
            if (seg == true || listaNombres[i] == 0) {
                $('#guia_remi_input').css('border', '1px solid #e5e6e7');
                agregarElemento();
            } else {
                $('#guia_remi_input').css('border', 'solid 1px red');

            }
        }
    });
    $("#guia_remi_input").on("keyup", function() {
        var value = $(this).val();
        var spaceIndex = value.indexOf(" ");
        if (spaceIndex > -1) {
            $('#guia_remi_input').click();
        }
    });
    $('#guia_remi_input').on('keydown', function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();

            let focusable = $('input, select, textarea, button')
                .filter(':visible:not([disabled])');
            let index = focusable.index(this);
            if (index > -1 && index + 1 < focusable.length) {
                focusable.eq(index + 1).focus();
            }
        }
    });

    function agregarElemento() {

        const input = document.getElementById("guia_remi_input");
        const datalist = document.getElementById("guia_list");
        const listaElementos = document.getElementById("lista_gr");
        const opciones = input.value.trim().split(' ');

        opciones.forEach(opcion => {
            if (opcion && !Array.from(listaElementos.children).some(el => el.textContent === opcion)) {
                var val = $('#guia_save_inp').val();
                listaElementos.innerHTML += `<a class="item_guia" onclick="remove_item(this)">${opcion}</a>`;

                if (val == "0") {
                    $('#guia_save_inp').val("");
                }
                var val2 = $('#guia_save_inp').val();
                $('#guia_save_inp').val(val2 + `${opcion} `);
            }
        });

        input.value = "";
    }

    function remove_item(elemento) {
        var input = $('#guia_save_inp').val();
        var texto = elemento.innerText;
        var new_text = texto + ' ';
        console.log(texto);
        var nuevoValor = input.replace(new_text, '');
        $('#guia_save_inp').val(nuevoValor);
        elemento.remove();
    }

    // Almacen

    // Forma de Pago
    function seleccionado_fp() {
        var opt = $('#forma_pago').val();
        if (opt == "1") { //Si es contado
            document.getElementById('credito_pago').style.display = "none";
            document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-5");
            document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-8");

            document.getElementById('fecha_vencimiento').removeAttribute('disabled');

        } else {
            document.getElementById('credito_pago').style.display = "block";

            document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-8");
            document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-5");

            document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
            document.getElementById('fecha_vencimiento').value = '';
        }
    }
    // Para las cuotas
    var total = document.getElementById('total_final_view').value;
    var x = 1;
    $(".add_pago").on('click', function() {
        console.log(x);
        var simb = $('#basic-addon3').html();
        var fecha_min = "$facturacion->fecha_emision }}";
        var total = document.getElementById('total_final_view').value;
        var data = `
                <div class="delete_modal${x} row">
                <div class="col-sm-1"><label>Fecha:</label></div>
                <div class="col-sm-4">
                <input type="date" min="` + fecha_min + `" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" >
                </div>
                <div class="col-sm-1"><label>Monto:</label></div>
                <div class="col-sm-4">
                <div class="input-group mb-3" style="padding-right:15px">
                <div class="input-group-prepend">
                <span class="input-group-text span_simbolo_credido" id="basic-addon4">` + simb + `</span>
                </div>
                <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}" onkeypress="return filterFloat(event,this);"  >
                </div>
                </div>
                <div class="col-sm-2">
                <label ><button type="button"  class="xd btn btn-danger" onclick="eliminar(${x})"><i class="fa fa-trash-o fa-lg" > </i></button></label>
                </div>
                </div>`;
        $('.row_number').append(data);

        var inp_mont = document.getElementsByClassName('monto_pago').length;

        // document.getElementById(`monto_pago${x}`).value = (total/inp_mont);

        x++;
        if (inp_mont > 6) {
            $('.add_pago').attr('disabled');
        }
        var multiplier2 = 100;
        var monto_c = document.getElementsByClassName('monto_pago');
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (total / inp_mont)
            document.getElementById("monto_pago0").value = '';
            // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
        }
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        if (inp_mont > 5) {
            document.getElementById('add_pago').setAttribute('disabled', "true");
        } else {
            document.getElementById('add_pago').removeAttribute('disabled');
        }
        actualizarSaldoRestante();
    });
    $(document).on('input', '.monto_pago', function() {
        actualizarSaldoRestante();
    });

    function resetModalCuotas() {
        x = 1;
        $('.row_number .delete_modal1, .row_number .delete_modal2, .row_number .delete_modal3, .row_number .delete_modal4, .row_number .delete_modal5, .row_number .delete_modal6')
            .remove();

        // $('#fecha_pago0').val('');
        // $('#monto_pago0').val('');

        $(".monto_pago").each(function() {
            $(this).val('');
        });
        $(".fecha_pago").each(function() {
            $(this).val('');
        });

        $('.add_pago').prop('disabled', false);
        $('#add_pago').prop('disabled', false);

        $('#cuotas_footer').html('0.00').css('color', 'green');
        $('#cuotas_footer').parent().find('strong').html('Total Restante: &nbsp;');

        actualizarSaldoRestante();
    }

    //Función de borrado de fila de articulos (Producto-Servicio)
        $(document).on('click', '.borrar', function(event) {
            event.preventDefault();
            var e = document.getElementsByClassName("e").length;
            var fila = $(this).parents("tr");
            var input_text_opt = fila.find('input[class="celda"]').val();
            $('option[value="' + input_text_opt + '"]').prop("disabled", false);
            $(".addmore").prop("disabled", false);
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Item",
            });
            // ELIMINAR TR
            if (e > 1) {
                fila.closest('tr').remove();
                // $(".borrar").prop("disabled", false);
                $(".addmore").prop("disabled", false);
            } else {
                // $(".borrar").prop("disabled", true);
                $(".addmore").prop("disabled", false);
                $(".select2_demo_3").val(null).trigger("change");
                $(".inp").val(null);

            }
            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            // var total_tt = Math.round(total_t * multiplier2) / multiplier2;
            var total_tt = total_t ;

            document.getElementById("sub_total").value = total_tt;
            document.getElementById("sub_total_view").value = total_tt.toFixed(2);

            var igv_valor = {{ $igv->renta }};
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv = subtotal * igv_valor / 100;

            // var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            var igv_decimal = igv;
            var end = igv_decimal + parseFloat(subtotal);

            // var end2 = Math.round(end * multiplier2) / multiplier2;
            var end2 = end;

            document.getElementById("igv").value = igv_decimal;
            document.getElementById("igv_view").value = igv_decimal.toFixed(2);
            

            var end = parseFloat(igv_decimal) + parseFloat(subtotal);
            // var end3 = Math.round(end * multiplier2) / multiplier2;
            var end3 = end ;
            document.getElementById("total_final").value = end3;
            document.getElementById("total_final_view").value = end3.toFixed(2);

            var monto_c = document.getElementsByClassName('monto_pago');

            var inp_mont = document.getElementsByClassName('monto_pago').length;
            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var fin = (end2 / inp_mont)
                document.getElementById("monto_pago0").value = Math.round(end2 * multiplier2) / multiplier2;
            }
            articlesSelect2();
        });

    function eliminar(x) {
        $(`.delete_modal${x}`).remove();
        var monto_c = document.getElementsByClassName('monto_pago');
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        var total = document.getElementById('total_final_view').value;
        var multiplier2 = 100;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;

            var fin = (total / inp_mont)
            document.getElementById("monto_pago0").value = '';
            // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
        }
        if (inp_mont > 5) {
            document.getElementById('add_pago').setAttribute('disabled', "true");
        } else if (inp_mont == 1) {
            document.getElementById("monto_pago0").value = total;
        } else {
            document.getElementById('add_pago').removeAttribute('disabled');
        }
        actualizarSaldoRestante();
    };
    $(document).on('input', '.monto_pago', function() {
        actualizarSaldoRestante();
    });
    //* Registros
    var i = "{{ count($facturacion->registros_m) }}";
    $(".addmore").on('click', function() {
        var data = `[
            <tr>
                <td>
                    <button type="button" class='delete borrar e btn btn-sm btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>
                <td class="td_selected">
                    <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})" autocomplete="off" required></select>
                    <textarea type='text' {{-- id='descripcion${i}' --}}   name='descripcion_item[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                    <textarea type='text' id='numero_serie${i}' placeholder="N° de Serie" name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                    <input type="hidden" class="celda"  name="articulo[]" id="input_prod${i}" >
                </td>
                <td>
                    <input type='text' style="min-width: 100px"  id='cantidad${i}' name='cantidad[]' class="monto${i} form-control inp" onkeyup="multi(${i})" required  autocomplete="off"/>
                </td>
                <td class="full-height-scroll tooltip-demo">
                    <input type='text' style="min-width: 100px"  id='precio_oficial${i}' name='precio_oficial[]' ondblclick="copy(${i})" class="precio_oficial${i} form-control inp" required  autocomplete="off" readonly data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" />
                </td>
                <td>
                    <input type='number' style="min-width: 100px"step="0.0000000000000001"  id='precio${i}' onchange="change(${i})" name='precio[]' class="monto${i} form-control inp" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off"/>
                    <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float'  class="precio_s_igv_float form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
                </td>
                <td>
                    <input style="min-width: 100px" type='number' step="0.0000000000000001"id='precio_c_igv${i}' name='precio_c_igv[]'  class="precio_c_igv p_inp monto${i} form-control inp" onkeyup="multi_c_igv(${i}),multi(${i})" required  autocomplete="off" />
                </td>
                <td>
                    <input type='number' id='total${i}'  style="min-width: 100px"  name='total' disabled="disabled" class="total form-control inp"  required  autocomplete="off"/>
                </td>
            </tr>
        `;
        $('.tables').append(data);
        $('#count_articles').val(i);
        i++;

        //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
        articlesSelect2();
        toggle();

        $(".addmore").prop("disabled", true);
        // $(".borrar").prop("disabled", false);
    });
    //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
    $(document).ready(function() {
        articlesSelect2();
    });
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

    //Funcion Copiar
    function copy(a) {
        if (a == 0) {
            var copy = document.getElementById(`precio_oficial0`).value;
            document.getElementById(`precio0`).value = copy;
            multi_s_igv(0);
        } else {
            var copy = document.getElementById(`precio_oficial${a}`).value;
            document.getElementById(`precio${a}`).value = copy;
            multi_s_igv(a);
        }
        multi(a);
    }

    // TODO funcion ajax para obtener los parametros requeridos de articulo (PRODUCTOS - SERVICIOS)
    function ajax(a) {
        if (a == 0) {
            var articulo = document.getElementById(`articulo`).value;
            document.getElementById(`input_prod0`).value = articulo;

        } else {
            var articulo = document.getElementById(`articulo${a}`).value;
            document.getElementById(`input_prod${a}`).value = articulo;

        }

        var almacen = $('[id="almacen_id"]').val();
        var moneda = $('[id="moneda_id"]').val();
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
                const $input = $(`#cantidad${a}`);
                if (msg.price == 0 && msg.amount == 0) {
                    // $(`#precio${a}`).val(0);
                    if ($input.val() > 1) {
                        $input.val($input.val());
                    } else if ($input.length) {
                        $input.val(1);
                    }
                    $(`#cantidad${a}`).attr('max', msg.amount);
                    $(`#cantidad`).attr('max', msg.amount);
                    $(`#precio_oficial${a}`).val(msg.price)
                } else {
                    // $(`#precio${a}`).val(1);
                    $(`#precio_oficial${a}`).val(msg.price)

                    if ($input.val() > 1) {
                        $input.val($input.val());
                    } else if ($input.length) {
                        $input.val(1);
                    }

                    // $(`#cantidad${a}`).attr('max', msg.amount );
                    // $(`#cantidad`).attr('max', msg.amount );
                }
                multi(a);
                $(`.addmore`).prop("disabled", false);
                onFinish();
            },
            error: function(eject) {
                if (eject.status === 400) {
                    console.log(eject.responseJSON.error);
                }
            },
            cache: true
        });
    }

    var igv = {{ $igv->renta }}
    var multiplier = 100;

    function multi_s_igv(a) {
        var pr_s_igv = $(`#precio${a}`).val();
        $(`#precio_s_igv_float${a}`).val(pr_s_igv);
        var c_igv_s_redondeo = parseFloat(pr_s_igv) + (parseFloat(pr_s_igv) * igv / multiplier);
        // var c_igv_redondeo = Math.round(c_igv_s_redondeo * multiplier) / multiplier;
        var c_igv_redondeo = c_igv_s_redondeo;
        $(`#precio_c_igv${a}`).val(c_igv_redondeo);
    }

    function multi_c_igv(a) {
        var pr_c_igv = $(`#precio_c_igv${a}`).val();
        var igv_dec = igv / multiplier;
        var s_igv_s_base = parseFloat(pr_c_igv) / (1 + parseFloat(igv_dec));
        // var s_igv_redondeo = Math.round(s_igv_s_base * multiplier) / multiplier;
        var s_igv_redondeo = s_igv_s_base;
        $(`#precio${a}`).val(s_igv_redondeo);
        $(`#precio_s_igv_float${a}`).val(s_igv_redondeo);
    }

    function disabled_money() {
        $(`.money_change`).prop('disabled', true);
        $(`.button_money`).addClass('not-active');

        setTimeout(function() {
            $(`.money_change`).prop('disabled', false);
            $(`.button_money`).removeClass('not-active');
        }, 10000);
    }
    // funcion dinamica de actualizar el total a cuotas
    function actualizarSaldoRestante() {
        var total = parseFloat(document.getElementById('total_final').value) || 0;
        var sumaMontos = 0;

        // Sumar todos los montos ingresados
        $('.monto_pago').each(function() {
            var valor = parseFloat($(this).val()) || 0;
            sumaMontos += valor;
        });

        var saldoRestante = total - sumaMontos;
        var multiplier = 100;
        saldoRestante = Math.round(saldoRestante * multiplier) / multiplier;

        if (saldoRestante > 0) {
            $('#cuotas_footer').html(saldoRestante).css('color', 'red');
            $('#cuotas_footer').parent().find('strong').html('Total Restante: &nbsp;');
        } else if (saldoRestante === 0) {
            $('#cuotas_footer').html('0.00').css('color', 'green');
            $('#cuotas_footer').parent().find('strong').html('¡Completo! &nbsp;');
        } else {
            $('#cuotas_footer').html(Math.abs(saldoRestante)).css('color', 'orange');
            $('#cuotas_footer').parent().find('strong').html('Exceso: &nbsp;');
        }
    }

    function multi(a) {
        var igv = 18.00;
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
        // var final_decimal = Math.round(final * multiplier) / multiplier;
        var final_decimal =final;

        document.getElementById(`precio_s_igv_float${a}`).value = final_decimal;
        var only_igv = final + (parseFloat(final) * (igv / multiplier));
        // var igv_decimal = Math.round(only_igv * multiplier) / multiplier;
        var igv_decimal = only_igv;
        document.getElementById(`total${a}`).value = igv_decimal;
        console.log(igv_decimal);
        // Operacion para subtotal sin igv
        var sub_igv = $('[name="precio_s_igv_float"]');
        var sub_igv_t = 0;
        console.log(sub_igv);
        sub_igv.each(function() {
            sub_igv_t += parseFloat($(this).val());
        });
        // var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
        var sub_igv_tt = sub_igv_t;
        // console.log(sub_igv_t);
        // console.log(Math.round(sub_igv_t * multiplier) / multiplier);
        // console.log(Math.round( * multiplier) / multiplier);
        // $('#sub_total').val(sub_igv_tt);
        document.getElementById("sub_total").value = sub_igv_tt;
        document.getElementById("sub_total_view").value = sub_igv_tt.toFixed(2);

        //OPERACION PARA CALULCAR EL IGV
        var only_igv = (parseFloat(sub_igv_tt) * (igv / multiplier))
        // var igv_decimal = Math.round(only_igv * multiplier) / multiplier;
        var igv_decimal = only_igv;
        document.getElementById("igv").value = igv_decimal;
        document.getElementById("igv_view").value = igv_decimal.toFixed(2);

        var end = igv_decimal + parseFloat(sub_igv_tt);
        // var end2 = Math.round(end * multiplier) / multiplier;
        var end2 = end;

        if (parseFloat(end2) > 700) {
            console.log('mayor a 700');
            $('#detraccion').attr('disabled', false);
            $('#button_detracc').attr('data-target', '#modal_detraccion');
        } else {
            var select_det = $('.select2_tipo_op').val();
            var split_id = select_det.split(' ');
            if (split_id[0] == '1001' || split_id[0] == '1002' || split_id[0] == '1003' || split_id[0] == '1004') {
                // Se activa la opcion de detraccion
            } else {
                $('#detraccion').attr('disabled', true);
                $('#button_detracc').attr('data-target', '#modal_detraccion');
            }
            var det_op = $('#detraccion').val();
            if(det_op == 1){
                $('#detraccion').val(0).trigger('change.select2');
            }
        }

        // Operacion para total
        // var totalInp = $('[name="total"]');
        // var total_t = 0;
        // totalInp.each(function(){
        //     total_t += parseFloat($(this).val());
        // });
        // console.log(total_t);
        // var multiplier2 = 100;
        var total_tt = sub_igv_tt + end2;

        $('#total').val(total_tt);

        // var subtotal = document.querySelector(`#total`).value;
        document.getElementById("total_final").value = end2;
        document.getElementById("total_final_view").value = end2.toFixed(2);


        var monto_c = document.getElementsByClassName('monto_pago');

        actualizarSaldoRestante();
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (end2 / inp_mont)
            document.getElementById("monto_pago0").value = Math.round(end2 * multiplier) / multiplier;
            actualizarSaldoRestante();
        }
        $("#cuotas_footer").html(end2);
        resetModalCuotas()
        multi_detraccion();
    }

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
            url: "{{ route('pa.search_multiple_manual') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'articulo': busqueda,
                'almacen': almacen,
                'moneda': moneda
            },
            success: function(msg) {
                // console.log(data.mone)
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
                var igv = $('#igv_input').val();
                var quantity = $('#quantity_modal').val();
                if (quantity == "") {
                    quantity = 1;
                }
                $('.data_table_multiple').DataTable({
                    "autoWidth": false,
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
                            data: null,
                            title: 'CANTIDAD',
                            render: function(data, type, row, meta) {
                                return `<input type="number" class="form-control form-control-sm input-cantidad" min="1" max="${row.stock}" value="1" data-price="${row.price}" data-id="${row.id}" />`;

                            }
                        },
                        {
                            data: 'price',
                            title: 'PRECIO S. C / IGV',
                            render: function(data, type, row) {
                                const simbolo = row.moneda
                                    .simbolo; // Obtén el símbolo de la moneda
                                const formattedPrice = $.fn.dataTable.render.number(',',
                                    '.', 2).display(data); // Formatea el precio
                                return `${simbolo} ${formattedPrice}`; // Retorna el precio con el símbolo
                            }
                        },
                        {
                            data: 'price',
                            title: 'PRECIO S / IGV',
                            render: function(data, type, row) {
                                const simbolo = row.moneda.simbolo;
                                const formattedPrice = $.fn.dataTable.render.number(',',
                                    '.', 2).display(data); // Formatea el precio
                                return `
                                        <div class="input-group input-group-sm" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon" id="basic-addon3">${simbolo}</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm total_s_igv" value="${formattedPrice}" id="precio_s_igv${row.id}" data-id="${row.id}">
                                        </div>
                                    `;
                            }
                        },
                        {
                            data: 'price',
                            title: 'PRECIO  C / IGV',
                            render: function(data, type, row) {
                                const simbolo = row.moneda.simbolo;
                                const formattedPrice = $.fn.dataTable.render.number(',',
                                    '.', 2).display(data); // Formatea el precio
                                return `
                                         <div class="input-group input-group-sm" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon" >${simbolo}</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm total_c_igv" value="${formattedPrice}" id="precio_c_igv${row.id}" data-id="${row.id}">
                                        </div>
                                    `; // Retorna el precio con el símbolo
                            }
                        }
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

    // PRECIO SIN IGV
    $('.data_table_multiple').on('input', '.total_s_igv', function() {
        console.log($(this));
        const id = $(this).data('id');
        const price = parseFloat($(`#precio_s_igv${id}`).val());
        var simbolo = $('#basic-addon3').html();

        var igv = $('#igv_input').val();
        const precio_c_gv = price + (price * (igv / 100));
        $(`#precio_c_igv${id}`).val(`${precio_c_gv.toFixed(2)}`);
    });
    // PRECIO SIN IGV
    $('.data_table_multiple').on('input', '.total_c_igv', function() {
        console.log($(this));
        const id = $(this).data('id');
        const price = parseFloat($(`#precio_c_igv${id}`).val());
        var simbolo = $('#basic-addon3').html();

        var igv = $('#igv_input').val();
        const precio_s_igv = price / (1 + (igv / 100));
        $(`#precio_s_igv${id}`).val(`${precio_s_igv.toFixed(2)}`);
    });

    $('.data_table_multiple').on('click', 'tbody > tr', function(e) {
        if ($(e.target).is('input') || $(e.target).closest('td').index() === 3 || $(e.target).closest('td')
            .index() === 5 || $(e.target).closest('td').index() === 6) {
            return;
        }
        var cantidad = $(this).find('.input-cantidad').val();
        var precio_s_igv = $(this).find('.total_s_igv').val();

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
                $(`#precio0`).val(precio_s_igv);
                multi_s_igv(0);
                multi(0);
                console.log("se cambio de cantidad");
                resetModalCuotas()
            }, 1000);
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
                $(`#precio${count_artc}`).val(precio_s_igv);
                multi_s_igv(`${count_artc}`);
                multi(`${count_artc}`);
                console.log("se cambio de cantidad")
                resetModalCuotas()
            }, 1000);
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
    // Detracción

    function multi_detraccion() {

        var moneda = $('#moneda_id').val();

        if (moneda == 1) { //soles
            var total = $('#total_final').val();
            var porc_det = $('#porcentaje_detc').val();
            var op_det = total * (porc_det / 100);
            var sub_zero = Math.round(op_det * 100) / 100;
            console.log(sub_zero);
            $('#tota_detra').val(sub_zero);
        } else { //dolares
            var total_dol = $('#total_final').val();

            var tipo_cam = $('#tc_paralelo').html();
            var total = total_dol * tipo_cam;

            var porc_det = $('#porcentaje_detc').val();
            var op_det = total * (porc_det / 100);
            var sub_zero = Math.round(op_det * 100) / 100;
            console.log(sub_zero);
            $('#tota_detra').val(sub_zero);
        }
    }

    $('#porcentaje_detc').on('keyup', function() {
        console.log('porcentaje cambiando');
        multi_detraccion();
    });

    $('.select2_tipodetrac').on('select2:select', function(e) {

        var data = e.params.data;
        var id_data = data.id;
        $.ajax({
            type: "post",
            url: "{{ route('pa.tipo_op_search') }}",
            data: {
                '_token': '{{ csrf_token() }}',
                'id_tipo_detra': data.id,
            },
            success: function(msg) {
                // console.log(msg.tasa)
                $('#porcentaje_detc').val(msg.tasa);
                multi_detraccion();
            },
            error: function(eject) {
                if (eject.status === 400) {
                    console.log(eject.responseJSON.error);
                }
            },
            cache: true
        });
    });

    $('.select2_tipo_op').on('select2:select', function(e) {
        var id = e.params.data.id;
        var split_id = id.split(' ');
        if (split_id[0] == '1001' || split_id[0] == '1002' || split_id[0] == '1003' || split_id[0] == '1004') {
            console.log('a');
            $('#button_detracc').attr('data-target', '#modal_detraccion');
            $('#detraccion').attr('disabled', false);
        }
    });

    function save_detraccion() {
        var seletc_det = $('.select2_tipo_op').val();
        var split_id = seletc_det.split(' ');
        if (split_id[0] == '12' || split_id[0] == '13' || split_id[0] == '14' || split_id[0] == '15') {
            var tipo_detra = $('#select_tipo_pago').val();
            var ipt_medio = $('.select2_mediopago').val();
            var porce_detra = $('#porcentaje_detc').val();
            var tot_det = $('#tota_detra').val();

            if (tipo_detra == "" || ipt_medio == "" || porce_detra == "" || tot_det == "") {
                $('#modal_detraccion').modal('show');
                var inputs = document.querySelectorAll('.detracc_campo_required');
                inputs.forEach(function(input) {
                    input.style.display = 'block';
                });
                return;
            } else {
                var inputs = document.querySelectorAll('.detracc_campo_required');
                inputs.forEach(function(input) {
                    input.style.display = 'none';
                });
                $('#modal_detraccion').modal('hide');
            }

        }
    }

    $('#detraccion').on('change', function() {
        var selected = this.value;
        console.log(selected);
        if (selected == "1") {
            $('#modal_detraccion').modal('show');
            var inputs = document.querySelectorAll('.ipt_detrac');
            inputs.forEach(function(input) {
                // input.setAttribute('required', 'required');
            });
            $('.select2_tipo_op').val('12').trigger('change.select2');
        } else {
            var inputs = document.querySelectorAll('.ipt_detrac');
            inputs.forEach(function(input) {
                // input.removeAttribute('required');
            });
            $('.select2_tipo_op').val('1').trigger('change.select2');
        }
    });

    $(document).on('click', '#button_cuotas_save', function(event) {

        var monto_c = document.getElementsByClassName('monto_pago');
        var monto_fc = document.getElementsByClassName('fecha_pago');
        console.log(monto_c)
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        // se usa el total real, mas no el dinamico
        var total = parseFloat(document.getElementById('total_final_view').value) || 0;
        var fin = 0;
        var comp = 0;
        for (var i = 0; i < inp_mont; i++) {
            fin = parseFloat(fin) + parseFloat(monto_c[i].value);
        }
        var fin_r = Math.round(fin * 100) / 100;
        var total_r = Math.round(total * 100) / 100;

        for (var i = 0; i < inp_mont; i++) {
            var fecha = monto_fc[i].id;
            var monto = monto_c[i].id;

            var input_text = document.getElementById(`${monto}`).value;
            var date_text = document.getElementById(`${fecha}`).value;
            console.log(date_text);
            if (input_text.length == 0 || date_text.length == 0) {
                console.log("a");
                document.getElementById('alert_campos').style.display = "flex";
                mostrarMensaje();
                return;
            }
            var end_date = document.getElementById(`${fecha}`).value;
        }

        if (fin_r != total_r) {
            document.getElementById('suma_campos').style.display = "flex";
        } else {
            console.log('e')
            var [year, month, day] = end_date.split("-");
            var formattedDate = `${year}-${month}-${day}`;
            $('#fecha_vencimiento').val(formattedDate)
            $('#cuotas_modal').modal('hide')
        }
        mostrarMensaje();

    });

    function mostrarMensaje() {
        // $("#alert_campos").show(200);
        $("#alert_campos").hide(3000);
        $("#suma_campos").hide(3000);
    }

    function mostrarMensaje() {
        // $("#alert_campos").show(200);
        $("#alert_campos").hide(3000);
        $("#suma_campos").hide(3000);
    }

    function cerrar_but_rc() {
        document.getElementById('alert_campos').style.display = "none";
    }

    function cerrar_but_mt() {
        document.getElementById('suma_campos').style.display = "none";
    }

    function filterFloat(evt, input) {
        var key = window.Event ? evt.which : evt.keyCode;
        var chark = String.fromCharCode(key);
        var tempValue = input.value + chark;

        if (key >= 48 && key <= 57) {
            if (filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            if (key == 8 || key == 13 || key == 0) {
                return true;
            } else if (key == 46) {
                if (filter(tempValue) === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    function filter(__val__) {
        var preg = /^([0-9]+\.?[0-9]{0,2})$/;
        if (preg.test(__val__) === true) {
            return true;
        } else {
            return false;
        }
    }
    let status =
        "@if ($facturacion->moneda->principal == 1) 0 @else 1 @endif";
    let total_val = 0;
    let completed = 0;

    function onFinish() {
        completed++;
        if (completed === total_val) {
            toastr.clear();
            toastr.success(
                'Todos los precios se actualizaron correctamente',
                'Proceso finalizado'
            );
            disabled_money();
        }
    }

    function changeMoney() {
        $.ajax({
            type: "post",
            url: "{{ route('pa.money') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'status': status,
            },
            beforeSend: function() {
                toastr.info(
                    '<i class="fa fa-spinner fa-spin"></i> Cambiando el precio, espere un momento...',
                    'Procesando', {
                        timeOut: 0,
                        extendedTimeOut: 0,
                        closeButton: false,
                        tapToDismiss: false
                    });
            },
            success: function(msg) {
                //Cambio de moneda
                $(`#moneda_id`).val(msg.id);
                $(`#moneda`).val(msg.nombre);
                $(`#button_changeMoney`).html(msg.other);
                $(`#basic-addon3`).html(msg.simbolo);
                $(`.span_simbolo_credido`).html(msg.simbolo);

                $(`#simb_fot`).html(msg.simbolo);

                resetModalCuotas()
                if (status == 1) {
                    status = 0;
                } else {
                    status = 1;
                }
                let articles_selected = document.getElementsByClassName("select2_demo_3");
                console.log("cantidad de articulos seleccionados: " + articles_selected.length);
                let articles_selected_count = articles_selected.length;
                // Para finalizar el toastr de carga
                total_val = articles_selected.length;
                completed = 0;

                if (total_val === 0) {
                    toastr.clear();
                    toastr.success(
                        'Moneda actualizada correctamente',
                        'Proceso finalizado'
                    );
                    disabled_money();
                    return;
                }

                for (let z = 0; z < articles_selected_count; z++) {
                    let selected = document.getElementsByClassName("select2_demo_3 select_change")[z]
                        .getAttribute('id');
                    if (selected == 'articulo') {
                        ajax(0);
                    } else {
                        ajax(selected.substring(8));
                    }
                }

                // disabled_money();
            },
        });
    }

    // TOAST PARA LA CARGA
    // toastr.clear();
    // toastr.success("Cambio de moneda exitoso",
    //     'success', {
    //         timeOut: 3000
    //     });

    function disabled_money() {
        $(`.money_change`).prop('disabled', true);
        $(`.button_money`).addClass('not-active');

        setTimeout(function() {
            $(`.money_change`).prop('disabled', false);
            $(`.button_money`).removeClass('not-active');
        }, 10000);
    }

    $("#boton").on("click", function(buton) {
        $('#button_submit').val('0');
        var l = Ladda.create(document.querySelector('.button-ladda'));
        var forma_pago = $("#forma_pago option:selected").val();
        if (forma_pago == 2) {
            var monto_c = document.getElementsByClassName('monto_pago');
            var monto_fc = document.getElementsByClassName('fecha_pago');
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var total = parseFloat(document.getElementById('total_final_view').value) || 0;
            var fin = 0.00;
            var comp = 0;
            for (var i = 0; i < inp_mont; i++) {
                fin = parseFloat(fin) + parseFloat(monto_c[i].value);
            }
            var fin_r = Math.round(fin * 100) / 100;
            // console.log(total);
            for (var i = 0; i < inp_mont; i++) {
                var fecha = monto_fc[i].id;
                var monto = monto_c[i].id;

                var input_text = document.getElementById(`${monto}`).value;
                var date_text = document.getElementById(`${fecha}`).value;
                if (input_text.length == 0 || date_text.length == 0) {
                    $('#cuotas_modal').modal('show');
                    document.getElementById('alert_campos').style.display = "flex";
                    setTimeout(mostrarMensaje, 3000);
                    return;
                }
            }
            if (fin_r != total) {
                $('#cuotas_modal').modal('show');
                document.getElementById('suma_campos').style.display = "flex";
                setTimeout(mostrarMensaje, 3000);
            } else {
                // console.log('e')
                var form = document.getElementById('form_update');
                if (!form.checkValidity()) {
                    form.reportValidity(); // muestra mensajes nativos de HTML5
                    return;
                }
                l.start();
                document.getElementById('button_submit').click();
            }
            // buton.preventDefault();
        } else {
            var form = document.getElementById('form_update');
            if (!form.checkValidity()) {
                form.reportValidity(); // muestra mensajes nativos de HTML5
                return;
            }
            l.start();
            document.getElementById('button_submit').click();
        }
    });
    $("#finalizar").on("click", function(buton) {
        $('#button_submit').val('1');
        var l = Ladda.create(document.querySelector('.button-ladda'));
        var forma_pago = $("#forma_pago option:selected").val();
        if (forma_pago == 2) {
            var monto_c = document.getElementsByClassName('monto_pago');
            var monto_fc = document.getElementsByClassName('fecha_pago');
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var total = parseFloat(document.getElementById('total_final_view').value) || 0;
            var fin = 0.00;
            var comp = 0;
            for (var i = 0; i < inp_mont; i++) {
                fin = parseFloat(fin) + parseFloat(monto_c[i].value);
            }
            var fin_r = Math.round(fin * 100) / 100;
            // console.log(total);
            for (var i = 0; i < inp_mont; i++) {
                var fecha = monto_fc[i].id;
                var monto = monto_c[i].id;

                var input_text = document.getElementById(`${monto}`).value;
                var date_text = document.getElementById(`${fecha}`).value;
                if (input_text.length == 0 || date_text.length == 0) {
                    $('#cuotas_modal').modal('show');
                    document.getElementById('alert_campos').style.display = "flex";
                    setTimeout(mostrarMensaje, 3000);
                    return;
                }
            }
            if (fin_r != total) {
                $('#cuotas_modal').modal('show');
                document.getElementById('suma_campos').style.display = "flex";
                setTimeout(mostrarMensaje, 3000);
            } else {
                // console.log('e')
                var form = document.getElementById('form_update');
                if (!form.checkValidity()) {
                    form.reportValidity(); // muestra mensajes nativos de HTML5
                    return;
                }
                l.start();
                document.getElementById('button_submit').click();
            }
            // buton.preventDefault();
        } else {
            var form = document.getElementById('form_update');
            if (!form.checkValidity()) {
                form.reportValidity(); // muestra mensajes nativos de HTML5
                return;
            }
            l.start();
            document.getElementById('button_submit').click();
        }
    });

    function codigo_numero() {
        var almacen = $('.select2_demo_almacen').val();
        console.log(almacen);
        $.ajax({
            type: "post",
            url: "{{ route('facturacion_manual.change_almacen_tipo') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'almacen': almacen,
            },
            success: function(msg) {
                $('#codigo_fac_manual').html(msg +
                    ` <span class="small" data-toggle="tooltip" data-placement="bottom" title="N° Referencial"><i class="fa fa-question-circle"></i></span>`
                )
            }
        })
    }
</script>
