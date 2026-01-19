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
</style>
<script>
    $(".select2_tipo_op").select2();
    // Boton acceder a la edicion
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

    function seleccionado_fp() {
        var opt = $('#forma_pago').val();
        if (opt == "1") {
            document.getElementById('credito_pago').style.display = "none";
            document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-5");
            document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-8");

            document.getElementById('fecha_vencimiento').removeAttribute('disabled');

        } else {
            document.getElementById('credito_pago').style.display = "block";

            document.getElementsByClassName('pago_first_column')[0].classList.remove("col-sm-8");
            document.getElementsByClassName('pago_first_column')[0].classList.add("col-sm-5");

            document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
        }
    }

    // Select2 para el cliente
    var tipo_coti = 1;
    var cliente_default = $('#cliente_id_input').val();
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
    $('.select2_demo_client').val(cliente_default).trigger('change');
    // Para lista de Guia Remision
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
    // Para los productos 

    // Agregar producto
    var i = "{{ count($facturacion->registros) - 1 }}";
    $(".addmore").on('click', function() {
        var data = `[
        <tr>
            <td>
                <button type="button" class='delete e borrar btn btn-sm btn-danger'> <i class="fa fa-trash" aria-hidden="true"></i> </button>
            </td>";
            <td class="td_selected">
                <select class="monto0 select2_demo_3 select_change" id='articulo${i}' onchange="ajax(${i})" autocomplete="off" required></select>
                <textarea type='text' id='descripcion${i}' name='descripcion_item[]' class="form-control" placeholder="Descripción de Item"  autocomplete="off" style="margin-top: 5px;"></textarea>
                <textarea type='text' id='numero_serie0' placeholder="N° de Serie" name='numero_serie[]' class="form-control"   autocomplete="off" style="margin-top: 5px;"></textarea>
                <input type='text' style="min-width: 76px"  id='tipo_afec${i}' name='tipo_afec[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" hidden   autocomplete="off" />
                <input type="hidden"    class="celda"  name="articulo[]" id="input_prod${i}">
            </td>
            <td>
                <input type='text' style="min-width: 76px"  id='stock${i}' name='stock[]' readonly="readonly" class="form-control" required  autocomplete="off"/>
            </td>
            <td>
                <input type='number' style="min-width: 76px"  id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off" min="1" max=""/>
            </td>
            <td>
                <input type='text' style="min-width: 76px"  id='precio${i}' name='precio[]' readonly="readonly" class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
            </td>
            <td>
                <div style="position: relative;" >
                    <input class="text_des"type='text' id='descuento${i}' name='descuento[]' readonly="readonly" class="" required onkeyup="multi(${i})"  autocomplete="off"/>
                </div>
                <div  class="div_check">
                    <input class="check"  type='checkbox' id='check${i}' name='check[]' onclick="multi(${i})" style="" autocomplete="off"/>
                </div>
                <input style="min-width: 76px" type='hidden'id='check_descuento${i}' name='check_descuento[]'  class="form-control"  required >
                <input type='hidden' id='promedio_original${i}' name='promedio_original[]'  class="form-control"   >
            </td>
            <td>
                <input type='text' id='precio_unitario_descuento${i}'  style="min-width: 76px"  name='precio_unitario_descuento[]' readonly="readonly" class=" form-control"  required  autocomplete="off" />
            </td>
            <td>
                <input type='hidden' name="comision[]" id='comision${i}'  style="min-width: 76px"  readonly="readonly" class="form-control comision_input"  required  autocomplete="off" onchange="multi(${i})" />
                <input type='text' id='precio_unitario_comision${i}'  style="min-width: 76px"  name='precio_unitario_comision[]' readonly="readonly" class="form-control"  required  autocomplete="off" />
            </td>
            <td>
                <input type='text' id='total${i}'  style="min-width: 76px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
                <input type='text' id='afectacion${i}'  style="min-width: 76px" hidden  name='afectacion' disabled="disabled" class="afectacion form-control "  required  autocomplete="off"/>
            </td>
        </tr>
        `;
        $('.tables').append(data);
        $('#count_articles').val(i);
        i++;
        //Llamada para la ejecucion de articlesSelect (funcionamiento de los select nuevos creados)
        articlesSelect2();

        var input_ds = [];
        var number_tot = document.getElementsByName('articulo[]').length;
        for (j = 0; j < number_tot; j++) {
            input_ds[j] = document.getElementsByName('articulo[]')[j].value;
            if (input_ds[j].indexOf("SERV-") == 4) {
                $('option[value="' + input_ds[j] + '"]').prop("disabled", false);
            } else {
                $('option[value="' + input_ds[j] + '"]').prop("disabled", true);
            }
        };
        $(".addmore").prop("disabled", true);
        $(".borrar").prop("disabled", false);

    });


    //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
    $(document).ready(function() {
        articlesSelect2();
    });

    //Funcion para el select articles "AJAX" (productos- servicios), ejecutandose cada vez realizada una llamada
    function articlesSelect2() {
        var almacen = "{{ $facturacion->almacen_id }}";
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
                        almacen: almacen
                    };
                },
                processResults: function(data) {
                    //validador de articulos multiples
                    let data_length = data.length;
                    let articles_selected_ajax = document.getElementsByClassName("select2_demo_3");
                    let articles_selected_count_ajax = articles_selected_ajax.length;
                    for (var z = 0; z < articles_selected_count_ajax; z++) {
                        var selected_ajax = document.getElementsByClassName("select2_demo_3 select_change")[
                            z].value;
                        for (var y = 0; y < data_length; y++) {
                            if (selected_ajax == data[y].id + " | " + data[y].codigo + " | " + data[y]
                                .codigo_original + " | " + data[y].nombre) {
                                data[y].disabled = true;
                            }
                        }
                    }
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

    // TODO funcion ajax para obtener los parametros requeridos de articulo (PRODUCTOS - SERVICIOS)
    function ajax(a) {
        if (a == 0) {
            var articulo = document.getElementById(`articulo`).value;
            document.getElementById(`input_prod1`).value = articulo;
        } else {
            var articulo = document.getElementById(`articulo${a}`).value;
            document.getElementById(`input_prod${a}`).value = articulo;
        }

        var almacen = "{{ $facturacion->almacen_id }}";
        var moneda = "{{ $facturacion->moneda_id }}";
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
                console.log(msg);
                $(`#tipo_afec${a}`).val(msg.afectacion);
                $(`#precio${a}`).val(msg.price);
                $(`#cantidad${a}`).val(1);
                $(`#precio_unitario_descuento${a}`).val(msg.price);
                $(`#promedio_original${a}`).val(msg.average);
                $(`#stock${a}`).val(msg.amount);
                $(`#descuento${a}`).val(msg.discount);
                $(`#check_descuento${a}`).val(0);
                $(`#cantidad${a}`).attr('max', msg.amount);
                $(`#cantidad`).attr('max', msg.amount);
                var separador = " ";
                var comision = document.querySelector(`#comisionista`).value;
                // //revirtiendo la cadena
                // var reverse9 = reverseString(comision); //devuelve toda la cadena articulo al reves
                // //para comision
                // var comision_v_r = reverse9.split(separador, 2); //devuelve el precio en objeto al revez
                // var comision_r = comision_v_r[1]; //obtiene el precio del objeto [0] al revez
                // var comision_v = reverseString(comision_v_r[
                //     1]); //convierte el precio al revez a la normalidad
                if (comision != 0) {
                    document.getElementById(`comision${a}`).value = comision;
                } else {
                    document.getElementById(`comision${a}`).value = 0;
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

    //Función para el calculo de los totales de cada articulo y para los totales de la factura
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

        // Get the checkbox
        var checkBox = document.getElementById(`check${a}`);
        var cantidad = document.querySelector(`#cantidad${a}`).value;
        var promedio_origina_descuento1 = document.querySelector(`#precio_unitario_descuento${a}`).value;
        var promedio_original2 = document.querySelector(`#promedio_original${a}`).value;
        var descuento = document.querySelector(`#descuento${a}`).value;
        var afec = document.querySelector(`#tipo_afec${a}`).value;
        var igv_new = {{ $igv->renta }};

        if (checkBox.checked == true && descuento > 0) {

            var precio = document.querySelector(`#precio${a}`).value;
            var promedio_original = document.querySelector(`#promedio_original${a}`).value;
            var comision_porcentaje = document.querySelector(`#comision${a}`).value;
            var multiplier = 100;
            var precio_uni = precio - (promedio_original * descuento / 100);
            var precio_uni_dec = Math.round(precio_uni * multiplier) / multiplier;

            document.getElementById(`check_descuento${a}`).value = descuento;
            document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;

            var comisiones9 = precio_uni_dec + (precio_uni_dec * comision_porcentaje / 100);
            var comisiones = Math.round(comisiones9 * multiplier) / multiplier;
            document.getElementById(`precio_unitario_comision${a}`).value = comisiones;

            var final = comisiones * cantidad;
            var final_decimal = Math.round(final * multiplier) / multiplier;
            console.log(final_decimal);
            if (afec.toString() == "Gravado") {
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = final_decimal;
                var precio_uni_igv = Math.round((final_decimal + (final_decimal * (igv_new / 100))) * multiplier) /
                    multiplier;
            } else {
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = 0;
                var precio_uni_igv = final_decimal;
            }
            // document.getElementById(`precio_unitario_igv${a}`).value = precio_uni_igv;
        } else {
            var multiplier = 100;
            var descuento = 0;
            var precio = document.querySelector(`#precio${a}`).value;
            var comision_porcentaje = document.querySelector(`#comision${a}`).value;
            var final = cantidad * precio;
            var end9 = parseFloat(precio) + (parseFloat(precio) * parseInt(comision_porcentaje) / 100);

            var end = Math.round(end9 * multiplier) / multiplier;
            var final2 = cantidad * end;
            var final_decimal = Math.round(final2 * multiplier) / multiplier;

            console.log("la promedio_origina_descuento1 es:" + promedio_origina_descuento1);
            console.log("la comision procentaje es:" + comision_porcentaje);
            console.log("la promedio_original2 procentaje es:" + promedio_original2);
            console.log("la end es:" + end);

            document.getElementById(`check_descuento${a}`).value = 0;

            document.getElementById(`precio_unitario_descuento${a}`).value = precio;
            document.getElementById(`precio_unitario_comision${a}`).value = end;
            if (afec.toString() == "Gravado") {
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = final_decimal;
                var precio_uni_igv = Math.round((final_decimal + (final_decimal * (igv_new / 100))) * multiplier) /
                    multiplier;
            } else {
                document.getElementById(`total${a}`).value = final_decimal;
                document.getElementById(`afectacion${a}`).value = 0;
                var precio_uni_igv = final_decimal;

            }
            // document.getElementById(`precio_unitario_igv${a}`).value = precio_uni_igv;
        }

        // var totalInp = $('[name="afectacion"]');

        //SUMA SUBTOTAL SIN IGV
        var totalInp = $('[name="total"]');

        var total_t = 0;

        totalInp.each(function() {
            total_t += parseFloat($(this).val());
        });

        var multiplier2 = 100;
        var total_tt = Math.round(total_t * multiplier2) / multiplier2;

        $('#sub_total').val(total_tt);

        //SOLO GRAVADO
        var totalInpG = $('[name="afectacion"]');
        var total_tg = 0;

        totalInpG.each(function() {
            total_tg += parseFloat($(this).val());
        });

        var multiplier3 = 100;
        var total_ttg = Math.round(total_tg * multiplier3) / multiplier3;

        $('#subtotal_gravado').val(total_ttg);


        var igv_valor = {{ $igv->renta }};

        var subtotal = document.querySelector(`#sub_total`).value;
        // var igv=subtotal*igv_valor/100;

        //GRAVADO
        var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;
        var igv = subtotal_gravado * igv_valor / 100;

        var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
        var end = igv_decimal + parseFloat(subtotal);

        var end2 = Math.round(end * multiplier2) / multiplier2;

        document.getElementById("igv").value = igv_decimal;
        document.getElementById("total_final").value = end2;
        // var total = document.getElementById("total_final").value;
        // $(`#monto_pago0`).attr('max', end2);
        // document.getElementById("monto_pago0").value = end2;
        var monto_c = document.getElementsByClassName('monto_pago');

        actualizarSaldoRestante();
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            // var input_text = document.getElementById(`${monto}`).value;
            var fin = (end2 / inp_mont)
            document.getElementById("monto_pago0").value = Math.round(end2 * multiplier2) / multiplier2;
            $("#cuotas_footer").html(Math.round(end2 * multiplier2) / multiplier2);
            actualizarSaldoRestante();
            // document.getElementById(`${monto}`).value = end2;
        }
        multi_detraccion();
        resetModalCuotas()
        $(document).on('input', '.monto_pago', function() {
            actualizarSaldoRestante();
        });
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
                'almacen': "{{ $facturacion->almacen_id }}",
                'moneda': "{{ $facturacion->moneda_id }}"
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
                // resetModalCuotas()
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
                // resetModalCuotas()
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
