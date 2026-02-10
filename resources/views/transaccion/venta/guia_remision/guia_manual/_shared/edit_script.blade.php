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
        $('.select2_demo_almacen').select2();
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
                        search: params.term, // search term
                        tipo_doc: 'manual'

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
        $.ajax({
            type: "post",
            url: "{{ route('remision_m.peso_ajax') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'articulo': articulo
            },
            success: function(msg) {
                $(`#peso${a}`).val(msg);
                $(`#peso_view${a}`).val(msg);
                $(`#peso_ori${a}`).val(msg);
                $(`#cantidad${a}`).val(0);
                sum_total();
            },
            error: function(eject) {
                if (eject.status === 400) {
                    console.log(eject.responseJSON.error);
                }
            },
            cache: true
        });

    }
    //
    var i = "{{ $guia_remision_m->registros_m->count() }}";
    $(".addmore").on('click', function() {
        var data = `[
<tr>
    <td>
        <button type="button" class='delete borrar e btn btn-sm btn-danger'><i class="fa fa-trash"
                aria-hidden="true"></i></button>
    </td>
    <td class="td_selected">
        <select class="select2_demo_productos" name="articulo[]" id="articulo${i}" style="width: 100%;" onchange="ajax(${i})"
            required></select>
        <textarea class="form-control" name="descripcion[]" placeholder="Detalle del Producto" id="" rows="1"
            style="margin-top: 5px"></textarea>
    </td>
    <td>
        <input style="min-width: 100px" type="text" name="cantidad[]" id="cantidad${i}" class="form-control" required
            onkeypress="return event.charCode >= 48 && event.charCode <= 57" onkeyup="peso_view_p(${i});sum_total()">
    </td>
    <td>
        <textarea style="min-width: 250px" name="serie[]" id="n_serie${i}" class="form-control prod_text"
            placeholder="Numero de Serie"></textarea>
    </td>
    <td>
        <div class="input-group" style="min-width: 140px">
            <input type="text" name="peso[]" id="peso${i}" class="form-control" required step="0.01"
                onkeypress="return event.charCode >= 46 && event.charCode <= 57"
                onkeyup="peso_view_p(${i});sum_total()">
            <div class="input-group-append">
                <span class="input-group-addon">KG</span>
            </div>
            <input style="min-width: 100px" type="hidden" name="peso_view" id="peso_view${i}" onkeyup="sum_total()">
            <input style="min-width: 100px" type="hidden" name="peso_ori" id="peso_ori${i}" onkeyup="sum_total()">
        </div>
    </td>
    <td>
        <div class="input-group" style="min-width: 130px">
            <input type="text" name="peso_tot[]" step="0.01" disabled id="peso_tot${i}" class="form-control"
                required onkeypress="return event.charCode >= 46 && event.charCode <= 57" onkeyup="sum_total()">
            <div class="input-group-append">
                <span class="input-group-addon">KG</span>
            </div>
        </div>
    </td>
</tr>
]`;
        $('.tables').append(data);
        articlesSelect2();
        i++
    });
    $(document).on('click', '.borrar', function(event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        // ELIMINAR TR
        if (e > 1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        } else {
            $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
        }
    });

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

    function almacen_cod() {
        var almacen = $('#almacen').val();
        console.log(almacen);
        $.ajax({
            type: "post",
            url: "{{ route('remision_m.almacen_remision_m') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'almacen': almacen
            },
            success: function(msg) {
                $('#cod_guia').html(msg);
            },
            error: function(eject) {
                if (eject.status === 400) {
                    console.log(eject.responseJSON.error);
                }
            },
            cache: true
        });

    }

    function peso_view_p(a) {
        var peso = $(`#peso${a}`).val();
        var cantidad = $(`#cantidad${a}`).val();
        console.log(peso);
        $(`#peso_view${a}`).val(peso);
        $(`#peso_tot${a}`).val(peso * cantidad);
        $(`#peso_ori${a}`).val(peso * cantidad);
    }

    function sum_total() {
        var total_t = 0;
        var totalInp = $('[name="peso_ori"]');
        console.log(totalInp)
        // console.log(totalInp);
        totalInp.each(function() {
            if (!isNaN(parseFloat($(this).val()))) {
                total_t += parseFloat($(this).val());
            }
        });
        var tot = total_t;
        console.log(tot);
        $('#peso_total').val(tot);

    }

    function mult_peso(b) {
        // var cantidad = $(`#cantidad${b}`).val();
        // var peso_ori = $(`#peso_ori${b}`).val();
        // var peso_multi = parseInt(cantidad) * parseFloat(peso_ori);
        // $(`#peso_view${b}`).val(peso_multi);
        // $(`#peso${b}`).val(peso_multi);
        // sum_total();



        // $(`#peso${b}`).val(peso_multi);



        // // var
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

    function delete_guion(string) { //solo letras y numeros
        return string.replace(/-/g, "");
    }
</script>


<script>
    $('#guardar').on('click', function() {
        $('#button_submit').val('0');
        var l = Ladda.create(document.querySelector('.button-lada-guardar'));
        var form = document.getElementById('form_update');
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
        var form = document.getElementById('form_update');
        if (!form.checkValidity()) {
            form.reportValidity(); // muestra mensajes nativos de HTML5
            return;
        }
        document.getElementById('button_submit').click();
        l.start();

    });
</script>
