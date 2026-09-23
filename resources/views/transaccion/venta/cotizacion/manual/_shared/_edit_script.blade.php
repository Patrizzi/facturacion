<script>
    let articulosAgregados = new Set();
    $('.celda').each(function() {
        var valor = $(this).val();
        var partes = valor.split('|').map(p => p.trim());
        var id = partes[0];
        articulosAgregados.add(String(id));
    });

    //*Condicional para el tipo de factura
    var tipo_coti = $('#tipo_coti').val();
    var cliente_default = $('#cliente_id').val();
    $(".select2_tipo_op").select2({
        width: "100%",
    });
    $(".select2_moneda").select2({
        width: "100%",
    });

    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        width: "100%",
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

    var clic = 1;

    function divAuto() {
        if (clic == 1) {
            document.getElementById("div-mostrar").style.height = "40px";
            clic = clic + 1;
        } else {
            document.getElementById("div-mostrar").style.height = "0px";
            clic = 1;
        }
    }
    //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
    var e = {{ $h }};
    $(document).ready(function() {
        console.log("variable h: " + e);
        // var a
        for (var a = 0; a < e; a++) {
            prueba_ajax(a);
        }
        articlesSelect2();
    });

    function prueba_ajax(a) {
        var articulo = document.getElementById(`articulo${a}`).value;
        document.getElementById(`input_prod${a}`).value = articulo;

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
            success: function(msg2) {
                $(`#precio_oficial${a}`).val(msg2.price);
            },
            error: function(eject) {
                if (eject.status === 400) {
                    console.log(eject.responseJSON.error);
                }
            },
            cache: true
        });
    }

    var i = $('#count_articles').val();
    $(".addmore").on('click', function() {
        console.log(i)
        var data = `[
            <tr>
                <td>
                    <button type="button" class='delete borrar e btn btn-primary btn-sm'>
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </td>";
                <td>
                    <input type="hidden" name="n_registros_ori[]" id="n_registros_ori" value="nuevo">
                    <select class="select2_demo_3 select_change" id='articulo${i}' onchange="inputs_campos(${i}),ajax(${i})"  autocomplete="off" required></select>
                    <textarea type='text' id='descripcion${i}' name='descripcion_item[]' placeholder="Descripción de Item" class="form-control" autocomplete="off" style="margin-top: 5px;"></textarea>
                    <input hidden="hidden"  class="celda"  name="articulo[]" id="input_prod${i}" >
                </td>
                <td>
                    <input type='number' min='1' style="min-width: 100px"  id='cantidad${i}' name='cantidad[]' class="cantidad monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
                </td>
                <td class="full-height-scroll tooltip-demo">
                    <input type='text' style="min-width: 100px"  id='precio_oficial${i}' name='precio_oficial[]' ondblclick="copy(${i})" class="precio_oficial${i} form-control inp" required  autocomplete="off" readonly data-toggle="tooltip" data-placement="top" title="Doble click (Copiar)" />
                </td>
                <td>
                    <input style="min-width: 100px" type='text' id='precio_s_igv${i}' name='precio_s_igv[]'  class="precio_s_igv monto${i} form-control" onkeyup="multi_s_igv(${i}),multi(${i})" required  autocomplete="off" />
                    <input hidden type='text' id='precio_s_igv_float${i}' name='precio_s_igv_float'  class="form-control precio_s_igv_float" onkeyup="multi_s_igv(${i}),multi(${i})"   autocomplete="off" />
                </td>
                <td>
                    <input style="min-width: 100px" type='text' id='precio_c_igv${i}' name='precio_c_igv[]'  class="precio_c_igv p_inp monto${i} form-control" onkeyup="multi_c_igv(${i}),multi(${i})" required  autocomplete="off" />
                </td>
                <td>
                    <input type='text' id='total${i}'  style="min-width: 100px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
                </td>
            </tr>
         `;
        $('.tables').append(data);
        $('#count_articles').val(i);
        console.log(i);
        i++;
        articlesSelect2();
        $(".borrar").prop("disabled", false);
        $(".addmore").prop("disabled", false);
        
        const section = document.getElementById("left_h3");
        console.log(section);
        section.scrollIntoView({
            block: "end",
            behavior: "smooth"
        });
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

    function copy(a) {
        if (a == 0) {
            var copy = document.getElementById(`precio_oficial0`).value;
            document.getElementById(`precio_s_igv0`).value = copy;
            multi_s_igv(0);
        } else {
            var copy = document.getElementById(`precio_oficial${a}`).value;
            document.getElementById(`precio_s_igv${a}`).value = copy;
            multi_s_igv(a);
        }
        multi(a);

    }

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

    function ajax(a) {

        var articulo = document.getElementById(`articulo${a}`).value;
        document.getElementById(`input_prod${a}`).value = articulo;


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
                    // $(`#cantidad${a}`).attr('max', msg.amount );
                    // $(`#cantidad`).attr('max', msg.amount );
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
        var multiplier = 100;
        $(`.monto${a}`).each(function() {
            if (!isNaN(parseFloat($(this).val()))) {
                change = true;
                total *= parseFloat($(this).val());
            }
        });
        total = (change) ? total : 0;
        var cantidad = document.querySelector(`#cantidad${a}`).value;
        //CALCULAR PRECIO SIN IGV
        var precio_sin = document.querySelector(`#precio_s_igv${a}`).value;
        var final_sin = precio_sin * cantidad;
        // var final_decimal_sin = Math.round(final_sin * multiplier) / multiplier;
        var final_decimal_sin = final_sin;


        document.getElementById(`precio_s_igv_float${a}`).value = final_decimal_sin;
        //CALCULAR PRECIO CON IGV
        var precio = document.querySelector(`#precio_c_igv${a}`).value;
        var final = precio * cantidad;
        // var final_decimal = Math.round(final * multiplier) / multiplier;
        //igv calculo
        var only_igv = final_sin + (parseFloat(final_sin) * (igv / multiplier))
        // var igv_decimal = Math.round(only_igv * multiplier) / multiplier;
        var igv_decimal = parseFloat(only_igv.toFixed(8));

        document.getElementById(`total${a}`).value = igv_decimal;



        // Operacion para subtotal sin igv
        var sub_igv = $('[name="precio_s_igv_float"]');
        var sub_igv_t = 0;
        sub_igv.each(function() {
            sub_igv_t += parseFloat($(this).val());
        });
        var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
        var sub_igv_tt = sub_igv_t;
        // $('#sub_total').val(sub_igv_tt);
        document.getElementById("subtotal").value = parseFloat(sub_igv_tt).toFixed(8);
        document.getElementById("subtotal_view").value = sub_igv_tt.toFixed(2);

        //OPERACION PARA CALULCAR EL IGV
        var only_igv = (parseFloat(sub_igv_tt) * (igv / multiplier))
        // var igv_decimal = Math.round(only_igv * multiplier) / multiplier;
        var igv_decimal = only_igv;
        document.getElementById("igv").value = igv_decimal.toFixed(8);
        document.getElementById("igv_view").value = igv_decimal.toFixed(2);

        // Operacion para total
        var totalInp = $('[name="total"]');
        var total_t = 0;
        totalInp.each(function() {
            total_t += parseFloat($(this).val());
        });
        console.log(total_t);
        var multiplier2 = 100;
        // var total_tt = Math.round(total_t * multiplier2) / multiplier2;
        var total_tt = total_t;

        $('#total').val(total_tt);

        var subtotal = document.querySelector(`#total`).value;
        document.getElementById("total_final").value = parseFloat(subtotal).toFixed(8);
        document.getElementById("total_final_view").value = total_tt.toFixed(2);

    }

    function inputs_campos(a) {
        var articulo = document.getElementById(`articulo${a}`).value;
        document.getElementById(`input_prod${a}`).value = articulo;
    }

    var igv = {{ $igv_t->renta }}
    var multiplier = 100;

    function multi_s_igv(a) {
        var pr_s_igv = $(`#precio_s_igv${a}`).val();
        parseFloat(pr_s_igv).toFixed(8);
        $(`#precio_s_igv_float${a}`).val(parseFloat(pr_s_igv));
        var c_igv_s_redondeo = parseFloat(pr_s_igv) + (parseFloat(pr_s_igv) * igv / multiplier);
        // var c_igv_redondeo = Math.round(c_igv_s_redondeo * multiplier) / multiplier;
        var c_igv_redondeo = c_igv_s_redondeo;
        $(`#precio_c_igv${a}`).val(parseFloat(c_igv_redondeo.toFixed(8)));
    }

    function multi_c_igv(a) {
        var pr_c_igv = $(`#precio_c_igv${a}`).val();
        var igv_dec = igv / multiplier;
        var s_igv_s_base = parseFloat(pr_c_igv) / (1 + parseFloat(igv_dec));
        // var s_igv_redondeo = Math.round(s_igv_s_base * multiplier) / multiplier;
        var s_igv_redondeo = s_igv_s_base;
        $(`#precio_s_igv${a}`).val(parseFloat(s_igv_redondeo.toFixed(8)));
        $(`#precio_s_igv_float${a}`).val(parseFloat(s_igv_redondeo.toFixed(8)));


    }
    $(document).on('click', '.borrar', function(event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        var input_text_opt = fila.find('input[class="celda"]').val();
        if (input_text_opt) {
            var partes = input_text_opt.split('|').map(p => p.trim());
            var id = partes[0];
            articulosAgregados.delete(String(id));
            reactivarBotonModal(id);
            // console.log(articulosAgregados);
        }
        $('option[value="' + input_text_opt + '"]').prop("disabled", false);
        $(".addmore").prop("disabled", false);

        // ELIMINAR TR
        if (e > 1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
            //RECALCULO PARA LOS SUBTOTAL IGV Y TOTAL
            // Operacion para subtotal sin igv
            var sub_igv = $('[name="precio_s_igv_float"]');
            var sub_igv_t = 0;
            sub_igv.each(function() {
                sub_igv_t += parseFloat($(this).val());
            });
            var sub_igv_tt = Math.round(sub_igv_t * multiplier) / multiplier;
            $('#sub_total').val(sub_igv_tt);
            document.getElementById("subtotal").value = sub_igv_tt;
            document.getElementById("subtotal_view").value = sub_igv_tt;

            //OPERACION PARA CALULCAR EL IGV
            var only_igv = (parseFloat(sub_igv_tt) * (igv / multiplier))
            var igv_decimal = Math.round(only_igv * multiplier) / multiplier;
            document.getElementById("igv").value = igv_decimal;
            document.getElementById("igv_view").value = igv_decimal;

            // Operacion para total
            var totalInp = $('[name="total"]');
            var total_t = 0;
            totalInp.each(function() {
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            var total_tt = Math.round(total_t * multiplier2) / multiplier2;

            console.log(total_tt);
            $('#total').val(total_tt);
            $('#total_final_view').val(total_tt);

            var subtotal = document.querySelector(`#total`).value;
            document.getElementById("total_final").value = subtotal;
        } else {
            if(input_text_opt == ""){
                return;
            }
            $(".addmore").prop("disabled", false);
            $(".select2_demo_3").val(null).trigger("change");
            limpiar_inputs();

        }
        // articlesSelect2();
    });

    function limpiar_inputs() {
        $(`.precio_s_igv`).val("");
        $(`.precio_c_igv`).val("");
        $(`.cantidad`).val("");
        $(`.p_inp`).val("");
        $(`.txt-limp`).val("");
        $('#subtotal_view').val("");
        $('#igv_view').val("");
        $('#total_final_view').val("");
        $('.total').val("");

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
                    if (selected == 'articulo') {
                        ajax(0);
                    } else {
                        ajax(selected.substring(8));
                    }
                }
                disabled_money();
            },
        });
    }

    function disabled_money() {
        $(`.money_change`).prop('disabled', true);
        $(`.button_money`).addClass('not-active');

        setTimeout(function() {
            $(`.money_change`).prop('disabled', false);
            $(`.button_money`).removeClass('not-active');
        }, 10000);
    }

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

        var almacen = $('[id="almacen_id"]').val();
        var moneda = $('[id="moneda_id"]').val();
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
                                const yaAgregado = articulosAgregados.has(String(row.id));
                                return `<button class="btn btn-primary btn-xs btn-agregar-articulo" data-id="${row.id}" data-cod_producto="${row.codigo_producto}" data-cod_original="${row.codigo_original}" data-nombre="${row.nombre}"> <i class="fa fa-plus"></i> Agregar</button>`;
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

        articulosAgregados.add(String(id));

        var concat_data = id + " | " + cod_prod + " | " + cod_origi + " | " + nombres;
            const newOption = new Option(concat_data, concat_data, true, true);

            var $primerSelect = $('#articulo');
            var existePrimerSelect = $primerSelect.length > 0;
            var valorPrimerSelect = existePrimerSelect ? $primerSelect.val() : null;

            if (!existePrimerSelect || valorPrimerSelect == null || valorPrimerSelect == "") {
                // Busca todos los selects existentes (incluyendo #articulo si existe)
                var $selectsExistentes = $('select[id^="articulo"]');

            if ($selectsExistentes.length === 0) {
                // No queda NINGÚN select en el formulario: crear uno desde cero
                $('.addmore').prop('disabled', false).click();
                $selectsExistentes = $('select[id^="articulo"]');
            }

            var $selectDestino = $selectsExistentes.last();
            var idAttr = $selectDestino.attr('id');
            var count_artc = idAttr === 'articulo' ? 0 : parseInt(idAttr.replace('articulo', ''));
            var valorDestino = $selectDestino.val();

            if (valorDestino != null && valorDestino != "") {
                // El último select ya tiene algo: crea uno nuevo
                $('.addmore').prop('disabled', false).click();
                $selectsExistentes = $('select[id^="articulo"]');
                $selectDestino = $selectsExistentes.last();
                idAttr = $selectDestino.attr('id');
                count_artc = idAttr === 'articulo' ? 0 : parseInt(idAttr.replace('articulo', ''));
            }

            $selectDestino.append(newOption).trigger('change');

            let debounceTimer;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                $(`#cantidad${count_artc}`).val(cantidad);
                multi(count_artc);
            }, 1000);

        } else {
            var $selectsNumerados = $('select[id^="articulo"]').not('#articulo');
            var count_artc = $selectsNumerados.length > 0
                ? Math.max(...$selectsNumerados.map(function () {
                    return parseInt($(this).attr('id').replace('articulo', ''));
                }).get())
                : null;
            var $ultimoSelect = count_artc === null ? $('#articulo') : $(`#articulo${count_artc}`);
            var valorActual = $ultimoSelect.val();
            if (valorActual != null && valorActual != "") {
                $('.addmore').prop('disabled', false).click();
                // Recalcular tras crear la fila
                $selectsNumerados = $('select[id^="articulo"]').not('#articulo');
                count_artc = Math.max(...$selectsNumerados.map(function () {
                    return parseInt($(this).attr('id').replace('articulo', ''));
                }).get());
                $ultimoSelect = $(`#articulo${count_artc}`);
            }

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
