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
    //Llama predeterminada para el select articles (productos- servicios), se ejecuta al cargar la pagina
    $(document).ready(function() {
        articlesSelect2();
    });

    //Funcion para el select articles "AJAX" (productos- servicios), ejecutandose cada vez realizada una llamada
    function articlesSelect2() {
        var almacen = "{{$facturacion->almacen_id}}";
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
    // Para obtener el Stock Actual de los productos Ya creados
</script>
