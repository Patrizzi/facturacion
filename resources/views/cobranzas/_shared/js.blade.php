<script>
    function select_pago(item) {
        $('.pago_m').css('display', 'none');
        $(`.m_pago_` + item).css('display', 'block');

        $('.class_pago').attr('required', false);
        // $('.class_pago').val('');
        $(`.pago_class_` + item).attr('required', true);
        $(`.file_input`).attr('required', false);

        $('.btn_pago_selec').addClass("btn-outline");
        $(`#bm_pago_` + item).removeClass("btn-outline");
        $('#input_pago').val(item);

        var fecha = $('#fecha_value_php').val();
        // console.log(fecha);
        $('.fecha_hoy').val(fecha);
    }
    $('#efectivo_pago').on('keyup', function() {
        var pago = this.value;
        var total = $('#tota_totas').text();
        var vuelto = parseFloat(this.value) - parseFloat(total);
        $('#efectivo_vuelto').val(Math.round(vuelto * 100) / 100);
    })

    // FUNCION PARA LOS CALCULOS EN LAS OPCIONES DE PAGO
    //*  Campos para el pago con cheque

    function calcular_monto_cheque() {
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $("#moneda_pago_cheque option:selected").text();
        var tipo_cambio = parseFloat($('#tipo_cambio_cheque').val());
        var monto_actual = parseFloat($('#cheque_monto').val());
        var monto_total = parseFloat($('#tota_totas').html());
        if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
            $('#tipo_cambio_cheque').attr('readonly', false);
            if (moneda_select != '$') { // Si la moneda no es dolar
                var monto_convertido = monto_total * tipo_cambio;
                $('#cheque_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_total / tipo_cambio;
                $('#cheque_monto').val(monto_convertido.toFixed(2));
            }
        } else {
            if (moneda_select == '$') { // Si la moneda no es sol
                $('#cheque_monto').val(monto_total.toFixed(2));
            } else {
                $('#cheque_monto').val(monto_total.toFixed(2));
            }
            $('#tipo_cambio_cheque').attr('readonly', true);
        }
    }
    $('#cheque_fecha_emision').on('change', function() {
        $.ajax({
            url: "{{ route('tipo_cambio.busqueda_tipo_cambio') }}",
            method: "GET",
            data: {
                '_token': $('input[name=_token]').val(),
                'fecha': $(this).val()
            },
            success: function(data) {
                toastr.success('Tipo de cambio obtenido correctamente', '', {
                    timeOut: 3000
                });
                $('#tipo_cambio_cheque').val(data.tipo_cambio.paralelo);
                calcular_monto_cheque();

            },
            error: function(data) {
                toastr.warning('No se pudo obtener el tipo de cambio, añadirlo manualmente', '', {
                    timeOut: 3000
                });
            }
        });
    });
    $('#moneda_pago_cheque').on('change', function() { // CUANDO CAMBIA LA MONEDA DE PAGO
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $(this).find('option:selected').text();
        var tipo_cambio = parseFloat($('#tipo_cambio_cheque').val());
        var monto_actual = parseFloat($('#cheque_monto').val());
        var monto_total = parseFloat($('#tota_totas').html());
        // Comparativa si ambas son monedas iguales
        if (moneda_select == moneda_principal) {
            $('#cheque_monto').removeAttr('max');
            $('#tipo_cambio_cheque').attr('readonly', true);
            if (moneda_select != '$') { // Si la moneda no es dolar
                // var monto_convertido = monto_total * tipo_cambio;
                $('#cheque_monto').val(monto_total.toFixed(2));
            } else {
                // $('#tipo_cambio_cheque').val(1);
                $('#cheque_monto').val(monto_total.toFixed(2));
            }
        } else {
            $('#cheque_monto').attr('max', monto_total);
            if (moneda_select == '$') { // Si la moneda es dolar
                var monto_convertido = monto_actual / tipo_cambio;
                $('#cheque_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_actual * tipo_cambio;
                $('#cheque_monto').val(monto_convertido.toFixed(2));
            }
            $('#tipo_cambio_cheque').attr('readonly', false);
        }
    });
    $('#cheque_monto').on('keyup', function() {
        var monto = parseFloat($(this).val());
        var monto_total = parseFloat($('#tota_totas').html());
        var moneda_principal = $('#simbolor_label').html();
        var moneda_pago = $("#moneda_pago_cheque option:selected").text();
        if (moneda_pago != moneda_principal) {
            $('#tipo_cambio_cheque').attr('readonly', false);
            if (moneda_pago == '$') {
                var tipo_cambio = monto_total / monto;
                $('#tipo_cambio_cheque').val(tipo_cambio.toFixed(4));
            } else {
                var tipo_cambio = monto / monto_total;
                $('#tipo_cambio_cheque').val(tipo_cambio.toFixed(4));
            }
        } else {
            $('#cheque_monto').val(monto_total.toFixed(2));
            // $('#tipo_cambio_cheque').val(1);
            $('#tipo_cambio_cheque').attr('readonly', true);
        }
    });
    $('#tipo_cambio_cheque').on('keyup', function() {
        var tipo_cambio_manual = parseFloat($(this).val());
        var monto_total = parseFloat($('#tota_totas').html());
        var monto_actual = parseFloat($('#cheque_monto').val());
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $("#moneda_pago_cheque option:selected").text();

        if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
            $('#tipo_cambio_cheque').attr('readonly', false);
            if (moneda_select != '$') { // Si la moneda no es dolar
                var monto_convertido = monto_total * tipo_cambio_manual;
                $('#cheque_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_total / tipo_cambio_manual;
                $('#cheque_monto').val(monto_convertido.toFixed(2));
            }
        } else {
            if (moneda_select == '$') { // Si la moneda no es sol
                var monto_convertido = monto_actual / tipo_cambio_manual;
                $('#cheque_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_actual * tipo_cambio_manual;
                $('#cheque_monto').val(monto_convertido.toFixed(2));
            }
        }
    });

    //*!! Campos para el pago con tarjeta

    function calcular_monto_tarjeta() {
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $("#moneda_pago_tarjeta option:selected").text();
        var tipo_cambio = parseFloat($('#tipo_cambio_tarjeta').val());
        var monto_total = parseFloat($('#tota_totas').html());
        var monto_actual = parseFloat($('#tarjeta_monto').val());
        if (moneda_select != moneda_principal) {
            $('#tipo_cambio_tarjeta').attr('readonly', false);
            if (moneda_select != '$') {
                var monto_convertido = monto_total * tipo_cambio;
                $('#tarjeta_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_total / tipo_cambio;
                $('#tarjeta_monto').val(monto_convertido.toFixed(2));
            }
        } else {
            if (moneda_select == '$') {
                $('#tarjeta_monto').val(monto_total.toFixed(2));
            } else {
                $('#tarjeta_monto').val(monto_total.toFixed(2));
            }
            $('#tipo_cambio_tarjeta').attr('readonly', true);
        }
    }
    $('#tarjeta_fecha_pago').on('change', function() {
        // get_tipo_cambio($(this).val(), $('#tipo_cambio_tarjeta'));
        $.ajax({
            url: "{{ route('tipo_cambio.busqueda_tipo_cambio') }}",
            method: "GET",
            data: {
                '_token': $('input[name=_token]').val(),
                'fecha': $(this).val()
            },
            success: function(data) {
                toastr.success('Tipo de cambio obtenido correctamente', '', {
                    timeOut: 3000
                });
                $('#tipo_cambio_tarjeta').val(data.tipo_cambio.paralelo);
                calcular_monto_tarjeta();

            },
            error: function(data) {
                toastr.warning('No se pudo obtener el tipo de cambio, añadirlo manualmente', '', {
                    timeOut: 3000
                });
            }
        });
    });
    $('#moneda_pago_tarjeta').on('change', function() { // CUANDO CAMBIA LA MONEDA DE PAGO
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $(this).find('option:selected').text();
        var tipo_cambio = parseFloat($('#tipo_cambio_tarjeta').val());
        var monto_actual = parseFloat($('#tarjeta_monto').val());
        var monto_total = parseFloat($('#tota_totas').html());
        if (moneda_select == moneda_principal) {
            $('#tarjeta_monto').removeAttr('max');
            $('#tipo_cambio_tarjeta').attr('readonly', true);
            if (moneda_select != '$') { // Si la moneda no es dolar
                $('#tarjeta_monto').val(monto_total.toFixed(2));
            } else {
                $('#tarjeta_monto').val(monto_total.toFixed(2));
            }
        } else {
            $('#tarjeta_monto').attr('max', monto_total);
            if (moneda_select == '$') { // Si la moneda es dolar
                var monto_convertido = monto_actual / tipo_cambio;
                $('#tarjeta_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_actual * tipo_cambio;
                $('#tarjeta_monto').val(monto_convertido.toFixed(2));
            }
            $('#tipo_cambio_tarjeta').attr('readonly', false);
        }
    });
    $('#tarjeta_monto').on('keyup', function() {
        var monto = parseFloat($(this).val());
        var monto_total = parseFloat($('#tota_totas').html());
        var moneda_principal = $('#simbolor_label').html();
        var moneda_pago = $("#moneda_pago_tarjeta option:selected").text();
        if (moneda_pago != moneda_principal) {
            $('#tipo_cambio_tarjeta').attr('readonly', false);
            if (moneda_pago == '$') {
                var tipo_cambio = monto_total / monto;
                $('#tipo_cambio_tarjeta').val(tipo_cambio.toFixed(4));
            } else {
                var tipo_cambio = monto / monto_total;
                $('#tipo_cambio_tarjeta').val(tipo_cambio.toFixed(4));
            }
        } else {
            $('#tarjeta_monto').val(monto_total.toFixed(2));
            // $('#tipo_cambio_tarjeta').val(1);
            $('#tipo_cambio_tarjeta').attr('readonly', true);
        }
    });
    $('#tipo_cambio_tarjeta').on('keyup', function() {
        var tipo_cambio_manual = parseFloat($(this).val());
        var monto_total = parseFloat($('#tota_totas').html());
        var monto_actual = parseFloat($('#tarjeta_monto').val());
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $("#moneda_pago_tarjeta option:selected").text();

        if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
            $('#tipo_cambio_tarjeta').attr('readonly', false);
            console.log('diferentes');
            if (moneda_select != '$') { // Si la moneda no es dolar
                var monto_convertido = monto_total * tipo_cambio_manual;
                $('#tarjeta_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_total / tipo_cambio_manual;
                $('#tarjeta_monto').val(monto_convertido.toFixed(2));
            }
        } else {
            console.log('iguales');
            if (moneda_select == '$') { // Si la moneda no es sol
                var monto_convertido = monto_actual / tipo_cambio_manual;
                $('#tarjeta_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_actual * tipo_cambio_manual;
                $('#tarjeta_monto').val(monto_convertido.toFixed(2));
            }
        }
    });

    //*!! Campos para el pago con Efectivo

    function calcular_monto_efectivo() {
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $("#moneda_pago_efectivo option:selected").text();
        var tipo_cambio = parseFloat($('#tipo_cambio_efectivo').val());
        var monto_actual = parseFloat($('#efectivo_monto').val());
        var monto_total = parseFloat($('#tota_totas').html());
        if (moneda_select != moneda_principal) {

            $('#tipo_cambio_efectivo').attr('readonly', false);
            if (moneda_select != '$') {
                var monto_convertido = monto_total * tipo_cambio;
                $('#efectivo_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_total / tipo_cambio;
                $('#efectivo_monto').val(monto_convertido.toFixed(2));
            }
        } else {
            if (moneda_select == '$') {
                $('#efectivo_monto').val(monto_total.toFixed(2));
            } else {
                $('#efectivo_monto').val(monto_total.toFixed(2));
            }
            $('#tipo_cambio_efectivo').attr('readonly', true);
        }
    }
    $('#efectivo_fecha_pago').on('change', function() {
        // get_tipo_cambio($(this).val(), $('#tipo_cambio_efectivo'));
        $.ajax({
            url: "{{ route('tipo_cambio.busqueda_tipo_cambio') }}",
            method: "GET",
            data: {
                '_token': $('input[name=_token]').val(),
                'fecha': $(this).val()
            },
            success: function(data) {
                toastr.success('Tipo de cambio obtenido correctamente', '', {
                    timeOut: 3000
                });
                $('#tipo_cambio_efectivo').val(data.tipo_cambio.paralelo);
                calcular_monto_efectivo();

            },
            error: function(data) {
                toastr.warning('No se pudo obtener el tipo de cambio, añadirlo manualmente', '', {
                    timeOut: 3000
                });
            }
        });
    });
    $('#moneda_pago_efectivo').on('change', function() { // CUANDO CAMBIA LA MONEDA DE PAGO
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $(this).find('option:selected').text();
        var tipo_cambio = parseFloat($('#tipo_cambio_efectivo').val());
        var monto_actual = parseFloat($('#efectivo_monto').val());
        var monto_total = parseFloat($('#tota_totas').html());

        if (moneda_select == moneda_principal) {
            $('#efectivo_monto').removeAttr('max');
            $('#tipo_cambio_efectivo').attr('readonly', true);
            if (moneda_select != '$') { // Si la moneda no es dolar
                $('#efectivo_monto').val(monto_total.toFixed(2));
            } else {
                $('#efectivo_monto').val(monto_total.toFixed(2));
            }
        } else {
            $('#efectivo_monto').attr('max', monto_total);
            if (moneda_select == '$') { // Si la moneda es dolar
                var monto_convertido = monto_actual / tipo_cambio;
                $('#efectivo_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_actual * tipo_cambio;
                $('#efectivo_monto').val(monto_convertido.toFixed(2));
            }
            $('#tipo_cambio_efectivo').attr('readonly', false);
        }
    });
    $('#efectivo_monto').on('keyup', function() {
        var monto = parseFloat($(this).val());
        var monto_total = parseFloat($('#tota_totas').html());
        var moneda_principal = $('#simbolor_label').html();
        var moneda_pago = $("#moneda_pago_efectivo option:selected").text();
        if (moneda_pago != moneda_principal) {
            $('#tipo_cambio_efectivo').attr('readonly', false);
            if (moneda_pago == '$') {
                var tipo_cambio = monto_total / monto;
                $('#tipo_cambio_efectivo').val(tipo_cambio.toFixed(4));
            } else {
                var tipo_cambio = monto / monto_total;
                $('#tipo_cambio_efectivo').val(tipo_cambio.toFixed(4));
            }
        } else {
            $('#efectivo_monto').val(monto_total.toFixed(2));
            // $('#tipo_cambio_efectivo').val(1);
            $('#tipo_cambio_efectivo').attr('readonly', true);
        }
    });
    $('#tipo_cambio_efectivo').on('keyup', function() {
        var tipo_cambio_manual = parseFloat($(this).val());
        var monto_total = parseFloat($('#tota_totas').html());
        var monto_actual = parseFloat($('#efectivo_monto').val());
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $("#moneda_pago_efectivo option:selected").text();

        if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
            $('#tipo_cambio_efectivo').attr('readonly', false);
            console.log('diferentes');
            if (moneda_select != '$') { // Si la moneda no es dolar
                var monto_convertido = monto_total * tipo_cambio_manual;
                $('#efectivo_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_total / tipo_cambio_manual;
                $('#efectivo_monto').val(monto_convertido.toFixed(2));
            }
        } else {
            console.log('iguales');
            if (moneda_select == '$') { // Si la moneda no es sol
                var monto_convertido = monto_actual / tipo_cambio_manual;
                $('#efectivo_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_actual * tipo_cambio_manual;
                $('#efectivo_monto').val(monto_convertido.toFixed(2));
            }
        }
    });

    //*!! Campos para el pago con Transferencia

    function calcular_monto_transferencia() {
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $("#moneda_pago_transferencia option:selected").text();
        var tipo_cambio = parseFloat($('#tipo_cambio_transferencia').val());
        var monto_total = parseFloat($('#tota_totas').html());

        if (moneda_select != moneda_principal) {
            $('#tipo_cambio_transferencia').attr('readonly', false);
            if (moneda_select != '$') {
                var monto_convertido = monto_total * tipo_cambio;
                $('#transferencia_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_total / tipo_cambio;
                $('#transferencia_monto').val(monto_convertido.toFixed(2));
            }
        } else {
            if (moneda_select == '$') {
                $('#transferencia_monto').val(monto_total.toFixed(2));
            } else {
                $('#transferencia_monto').val(monto_total.toFixed(2));
            }
            $('#tipo_cambio_transferencia').attr('readonly', true);
        }
    }
    $('#transferencia_fecha_pago').on('change', function() {
        $.ajax({
            url: "{{ route('tipo_cambio.busqueda_tipo_cambio') }}",
            method: "GET",
            data: {
                '_token': $('input[name=_token]').val(),
                'fecha': $(this).val()
            },
            success: function(data) {
                toastr.success('Tipo de cambio obtenido correctamente', '', {
                    timeOut: 3000
                });
                $('#tipo_cambio_transferencia').val(data.tipo_cambio.paralelo);
                calcular_monto_efectivo();

            },
            error: function(data) {
                toastr.warning('No se pudo obtener el tipo de cambio, añadirlo manualmente', '', {
                    timeOut: 3000
                });
            }
        });
    });
    $('#moneda_pago_transferencia').on('change', function() { // CUANDO CAMBIA LA MONEDA DE PAGO
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $(this).find('option:selected').text();
        var tipo_cambio = parseFloat($('#tipo_cambio_transferencia').val());
        var monto_actual = parseFloat($('#transferencia_monto').val());
        var monto_total = parseFloat($('#tota_totas').html());
        if (moneda_select == moneda_principal) {
            $('#transferencia_monto').removeAttr('max');
            $('#tipo_cambio_transferencia').attr('readonly', true);
            if (moneda_select != '$') { // Si la moneda no es dolar
                $('#transferencia_monto').val(monto_total.toFixed(2));
            } else {
                $('#transferencia_monto').val(monto_total.toFixed(2));
            }
        } else {
            $('#transferencia_monto').attr('max', monto_total);
            if (moneda_select == '$') { // Si la moneda es dolar
                var monto_convertido = monto_actual / tipo_cambio;
                $('#transferencia_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_actual * tipo_cambio;
                $('#transferencia_monto').val(monto_convertido.toFixed(2));
            }
            $('#tipo_cambio_transferencia').attr('readonly', false);
        }
    });
    $('#transferencia_monto').on('keyup', function() {
        var monto = parseFloat($(this).val());
        var monto_total = parseFloat($('#tota_totas').html());
        var moneda_principal = $('#simbolor_label').html();
        var moneda_pago = $("#moneda_pago_transferencia option:selected").text();
        if (moneda_pago != moneda_principal) {
            $('#tipo_cambio_transferencia').attr('readonly', false);
            if (moneda_pago == '$') {
                var tipo_cambio = monto_total / monto;
                $('#tipo_cambio_transferencia').val(tipo_cambio.toFixed(4));
            } else {
                var tipo_cambio = monto / monto_total;
                $('#tipo_cambio_transferencia').val(tipo_cambio.toFixed(4));
            }
        } else {
            $('#transferencia_monto').val(monto_total.toFixed(2));
            // $('#tipo_cambio_transferencia').val(1);
            $('#tipo_cambio_transferencia').attr('readonly', true);
        }
    });
    $('#tipo_cambio_transferencia').on('keyup', function() {
        var tipo_cambio_manual = parseFloat($(this).val());
        var monto_total = parseFloat($('#tota_totas').html());
        var monto_actual = parseFloat($('#transferencia_monto').val());
        var moneda_principal = $('#simbolor_label').html();
        var moneda_select = $("#moneda_pago_transferencia option:selected").text();

        if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
            $('#tipo_cambio_transferencia').attr('readonly', false);
            console.log('diferentes');
            if (moneda_select != '$') { // Si la moneda no es dolar
                var monto_convertido = monto_total * tipo_cambio_manual;
                $('#transferencia_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_total / tipo_cambio_manual;
                $('#transferencia_monto').val(monto_convertido.toFixed(2));
            }
        } else {
            console.log('iguales');
            if (moneda_select == '$') { // Si la moneda no es sol
                var monto_convertido = monto_actual / tipo_cambio_manual;
                $('#transferencia_monto').val(monto_convertido.toFixed(2));
            } else {
                var monto_convertido = monto_actual * tipo_cambio_manual;
                $('#transferencia_monto').val(monto_convertido.toFixed(2));
            }
        }
    });
</script>
<script>
    var elem_2 = document.querySelector('.js-switch-pago');
    var switchery_2 = new Switchery(elem_2, {
        color: '#ED5565'
    });

    $(document).ready(function() {
        $('#select_banco_pagos').select2({
            placeholder: "Seleccionar",
        });
        $('#select_cuenta_pago').select2({
            placeholder: "Seleccionar",
        });

        $('#select_banco_transf_pag').select2({
            placeholder: "Seleccionar",
        });
        $('#select_cuenta_adl_pag').select2({
            placeholder: "Seleccionar",
        });
    });

    function changue_bancos_pagos(val) {
        // $("#select_banco_adl").attr('disabled', false);
        $('#select_bancos_pago').val(val);
        var id_banc = $("#select_banco_pagos").val();
        $('#select_cuenta_pago').select2({
            placeholder: `Seleccionar N° Cuenta de ${val.options[val.selectedIndex].text}`,
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('bancos.registros_search') }}",
                dataType: 'json',
                type: "POST",
                data: function(params) {
                    return {
                        '_token': $('input[name=_token]').val(),
                        'id_bancos': id_banc
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.tipo_cuenta + ' - ' + item.nombre_cuenta,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    }

    function changue_bancos_pago_tr() {
        // $("#select_banco_adl").attr('disabled', false);
        console.log('a');
        var id_banc = $("#select_banco_transf_pag").val();
        $('#select_cuenta_adl_pag').select2({
            placeholder: "Seleccionar",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('bancos.registros_search') }}",
                dataType: 'json',
                type: "POST",
                data: function(params) {
                    return {
                        '_token': $('input[name=_token]').val(),
                        'id_bancos': id_banc
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,    
                                text: item.tipo_cuenta + ' - ' + item.nombre_cuenta,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    }

    $("#select_cuenta_adl").select2();
    $("#select_cuenta_adl_transf").select2();

    function limpiar_fechas() {
        var table_lp = $('.dataTables-example').DataTable();
        table_lp.column(5).search('').draw();
    }

    function limpiar_fechas_2() {
        var table_lp_2 = $('.dataTables-examaple-2').DataTable();
        table_lp_2.column(6).search('').draw();
    }
    var tipo_coti = 3;
    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        allowClear: true,
        ajax: {
            minimumInputLength: 1,
            url: "{{ route('pa.clients') }}",
            dataType: 'json',
            type: "POST",
            delay: 10,
            data: function(params) {
                var tipo_coti = $('[name="tipo_coti"]:checked').val();
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
