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

    var i = "{{ $guia_remision->registros->count() }}";
    console.log(i);
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
        $('#table-edit-remision').append(data);
        articlesSelect2();
        i++;
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
        console.log(a);
        if (a == 0) {
            var articulo = document.getElementById(`articulo`).value;
        } else {
            var articulo = document.getElementById(`articulo${a}`).value;
        }
        console.log(articulo);
        // var almacen = document.getElementById(`almacen_in`).value;
        $.ajax({
            type: "post",
            url: "{{ route('guia_remision.peso_stock') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'almacen': "{{ $guia_remision->almacen_id }}",
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
<script>
    $('#guardar').on('click', function() {
        $('#button_submit').val('0');
        var l = Ladda.create(document.querySelector('.button-lada-guardar'));
        var form = document.getElementById('forma_update');
        if (!form.checkValidity()) {
            form.reportValidity(); // muestra mensajes nativos de HTML5
            return;
        }
        document.getElementById('button_submit').click();
        l.start();
    });
    $('#finalizar').on('click', function() {
        $('#button_submit').val('1');
        var l = Ladda.create(document.querySelector('.button-lada-finalizar'));
        var form = document.getElementById('forma_update');
        if (!form.checkValidity()) {
            form.reportValidity(); // muestra mensajes nativos de HTML5
            return;
        }
        document.getElementById('button_submit').click();
        l.start();

    });
</script>
