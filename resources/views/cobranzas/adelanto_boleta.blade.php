<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('adelantos.store_adelanto_boleta')}}" method="post" >  {{-- BOLETA Y BOLETA MANUAL --}}
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h5 class="modal-title">Adelanto de Cuotas</h5>                    
                </div>
                <div class="modal-body" style="padding-bottom: 0px">
                    <div class="row" id="adelanto_header">
                        
                    </div>
                </div>
                <div class="modal-body">
                    <div class="metodo_adelanto">
                        <input type="hidden" name="input_adelanto" id="input_adelanto" value="1">
                        <input type="hidden" name="tipo_comprobante" value="" id="tipo_comprobante_form_adl">
                        <div id="id_boleta_adl">

                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <h3 class="text-center">Adelanto para Boleta</h3>
                                {{-- <div class="col-lg-12"> --}}
                                    <button type="button" value="btn_adelanto_1"
                                        class="btn btn-block btn-primary btn_adelanto_selec active" id="bm_adelanto_1" onclick="select_adelanto_click(1)">Cheque</button>
                                {{-- </div> --}}
                                <br>
                                {{-- <div class="col-lg-12"> --}}
                                    <button type="button" value="btn_adelanto_2"
                                        class="btn btn-block btn-primary btn_adelanto_selec" id="bm_adelanto_2" onclick="select_adelanto_click(2)">Tarjeta</button>
                                {{-- </div> --}}
                                <br>
                                {{-- <div class="col-lg-12"> --}}
                                    <button type="button" value="btn_adelanto_3"
                                        class="btn btn-block btn-primary btn_adelanto_selec" id="bm_adelanto_3" onclick="select_adelanto_click(3)">Efectivo</button>
                                {{-- </div> --}}
                                <br>
                                {{-- <div class="col-lg-12"> --}}
                                    <button type="button" value="btn_adelanto_4"
                                        class="btn btn-block btn-primary btn_adelanto_selec" id="bm_adelanto_4" onclick="select_adelanto_click(4)">Transferencia</button>
                                {{-- </div> --}}
                            </div>
                            <input type="hidden" name="" id="value_option_type" value="1">
                            <div class="col-sm-9">
                                <div class="row adelanto_m m_adelanto_1"> {{-- Metodo de Adelanto 1 - CHEQUE --}}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">¿Es cheque diferido? </label>
                                            <div class="">
                                                <span>No&nbsp;</span><input type="checkbox" class="js-switch" name="cheque_diferido" /><span>&nbsp;Si</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Numero de Cheque</label>
                                            <input type="text" id="n_cheque_adl" name="cheque_name_adl" value="" placeholder="Numero de Cheque" class="form-control adelanto_class_1 class_adelanto" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha de Cobro</label>
                                            <input type="date" id="cheque_fecha_adl" name="cheque_fecha_cobro_adl" value="{{ $fecha_hoy }}" placeholder="Fecha de Cobro" class="form-control adelanto_class_1 class_adelanto fecha_hoy" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Banco Emisor</label>
                                            <select class="form-control adelanto_class_1 class_adelanto" name="cheque_banco_emisor_adl" id="banco_emisor_adl" required>
                                                <option value="">Seleccionar Banco</option>
                                                <option value="BCP">BCP</option>
                                                <option value="INTERBANK">INTERBANK</option>
                                                <option value="BBVA">BBVA</option>
                                                <option value="SCOTIABANK">SCOTIABANK</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Beneficiario</label>
                                            <input type="text" id="cheque_beneficiario_adl" name="cheque_beneficiario_adl" value="" placeholder="Beneficiario" class="form-control adelanto_class_1 class_adelanto" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Monto</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="simbolo_adelanto_vuelto">S/</span>
                                                </div>
                                                <input type="number" id="cheque_adl_monto" name="cheque_monto" value="" placeholder="Monto" class="form-control adelanto_class_1 class_adelanto" required step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form_adelanto">
                                            <label class="col-form-label">Banco de la Empresa</label>
                                            <select name="banco_cuenta" id="select_banco_adl" class="select2_banco adelanto_class_1 class_adelanto" onchange="changue_bancos()">
                                                @foreach ($bancos as $banco)
                                                    <option value="{{$banco->id}}">{{$banco->nombre_banco}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form_adelanto">
                                            <label class="col-form-label">N° de Cuenta</label>
                                            <select name="cheque_n_cuenta" class="form-control adelanto_class_1 class_adelanto" id="select_cuenta_adl">
                                                {{-- @foreach ($cuentas as $banco_reg)
                                                    <option value="{{$banco_reg->id}}">{{$banco_reg->tipo_cuenta}} - {{$banco_reg->monedas_i->simbolo}} - {{$banco_reg->nombre_cuenta}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha de Emision</label>
                                            <input type="date" value="{{ $fecha_hoy }}" id="cheque_emisor_adl" name="cheque_fecha_emision_adl" placeholder="Fecha de Emision" class="form-control adelanto_class_1 class_adelanto" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Comprobante
                                                <small>(opcional)</small></label>
                                            <input type="file" name="cheque_file_adl" id="" class="form-control adelanto_class_1 class_adelanto file_input">
                                        </div>
                                    </div>
                                </div>
                                <div class="row adelanto_m m_adelanto_2"> {{-- Metodo de Pago 2 - TARJETA --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Titular de la Tajeta</label>
                                            <input type="text" id="" name="tarjeta_titular_adl" value="" placeholder="Titular de la Tajeta" class="form-control adelanto_class_2 class_adelanto">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Banco</label>
                                            <select class="form-control adelanto_class_2 class_adelanto" name="tarjeta_banco_adl" id="tarjeta_banco_adl">
                                                <option value="">Seleccionar Banco</option>
                                                <option value="BCP">BCP</option>
                                                <option value="INTERBANK">INTERBANK</option>
                                                <option value="BBVA">BBVA</option>
                                                <option value="SCOTIABANK">SCOTIABANK</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Monto</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="simbolo_adelanto_tarjeta">S/</span>
                                                </div>
                                                <input type="text" class="form-control adelanto_class_2 class_adelanto" name="tarjeta_mondo_adl" id="monto_tarjeta_adl" step="0.01" placeholder="Monto">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha</label>
                                            <input type="date" value="{{ $fecha_hoy }}" class="form-control adelanto_class_2 class_adelanto fecha_hoy" name="tarjeta_fecha_adl" id="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Comprobante</label>
                                            <input type="file" class="form-control adelanto_class_2 class_adelanto file_input" name="tarjeta_file_adl" id="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row adelanto_m m_adelanto_3"> {{-- Metodo de Pago 3 - EFECTIVO --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Persona que Cancela</label>
                                            <input type="text" id="" name="efectivo_persona_adl" value="" placeholder="Titular" class="form-control adelanto_class_3 class_adelanto">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha</label>
                                            <input type="date" name="fecha_efectivo_adl" class="form-control adelanto_class_3 class_adelanto fecha_hoy" id="" value="{{ $fecha_hoy }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Monto de Pago</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="simbolo_adelanto">S/</span>
                                                </div>
                                                <input type="number" name="monto_adelanto_efectivo_adl" id="efectivo_adelanto" class="form-control adelanto_class_3 class_adelanto" placeholder="" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row adelanto_m m_adelanto_4"> {{-- Metodo de Pago 4 - TRANSFERENCIA --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Titular</label>
                                            <input type="text" id="" name="transferencia_titular_adl" value="" placeholder="Titular" class="form-control adelanto_class_4 class_adelanto">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha</label>
                                            <input type="date"
                                                class="form-control adelanto_class_4 class_adelanto fecha_hoy" name="transferencia_fecha_adl" id="" value="{{ $fecha_hoy }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form_adelanto">
                                            <label class="col-form-label">Banco de la Empresa</label>
                                            <select name="banco_cuenta_transf" id="select_banco_transf_adl" class="select3_banco adelanto_class_4 class_adelanto" onchange="changue_bancos_trans()">
                                                @foreach ($bancos as $banco)
                                                    <option value="{{$banco->id}}">{{$banco->nombre_banco}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form_adelanto">
                                            <label class="col-form-label">N° de Cuenta Bancaria</label>
                                            <select name="transferencia_n_cuenta" class="form-control adelanto_class_4 class_adelanto" id="select_cuenta_adl_transf">
                                                {{-- @foreach ($cuentas as $banco_reg)
                                                    <option value="{{$banco_reg->id}}">{{$banco_reg->tipo_cuenta}} - {{$banco_reg->monedas_i->simbolo}} - {{$banco_reg->nombre_cuenta}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">N° de Operación</label>
                                            <input type="text"
                                                class="form-control adelanto_class_4 class_adelanto" name="transferencia_operacion_adl" id="transferencia_oper_adl" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Banco Emisor</label>
                                            <select class="form-control adelanto_class_4 class_adelanto" name="transferencia_banco_adl" id="">
                                                <option value="">Seleccionar Banco</option>
                                                <option value="BCP">BCP</option>
                                                <option value="INTERBANK">INTERBANK</option>
                                                <option value="BBVA">BBVA</option>
                                                <option value="SCOTIABANK">SCOTIABANK</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Monto</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="simbolo_adelanto_transferencia">S/</span>
                                                </div>
                                                <input type="number" id="tranferencia_adl_monto" name="transferencia_monto" value="" placeholder="Monto" class="form-control adelanto_class_4 class_adelanto" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Comprobante</label>
                                            <input type="file" class="form-control adelanto_class_4 class_adelanto file_input" name="transferencia_comprobante_adl" id="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> {{--  NOTAS PARA TODOS --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Notas Adicionales</label>
                                            <textarea class="form-control" name="notas_adicionales_adl" id="" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardar_adelanto">Guardar</button>
                    <button type="submit" style="display: none" id="button_submit_adelanto" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .form_adelanto > .select2.select2-container.select2-container--default{
        width: 100% !important;
    }
    .adelanto_m {
        display: none;
    }

    .adelanto_m.m_adelanto_1 {
        display: flex;
    }
    #view_all {
        display: none;
    }

    .view_adelanto {
        display: none;
    }
</style>


<script>
    $( document ).ready(function() {
        var t_comp_view = $('#tipo_comprobante_view').val();
        $('#tipo_comprobante_form_adl').val(t_comp_view);

        $('#select_banco_adl').select2({
            placeholder: "Seleccionar",
        });
        $('#select_cuenta_adl').select2({
            placeholder: "Seleccionar",
        });
        $('#select_banco_transf_adl').select2({
            placeholder: "Seleccionar",
        });
        $('#select_cuenta_adl_transf').select2({
            placeholder: "Seleccionar",
        });
    });
</script>
<script>
    
    function changue_bancos(){
        // $("#select_banco_adl").attr('disabled', false);
        console.log('a');
        var id_banc = $("#select_banco_adl").val();
        $('#select_cuenta_adl').select2({
            placeholder: "Seleccionar",
            ajax: {
                minimumInputLength: 1,
                url: "{{route('bancos.registros_search')}}",
                dataType: 'json',
                type: "POST",
                data: function (params) {
                    return {
                        '_token': $('input[name=_token]').val(),
                        'id_bancos': id_banc
                    };
                },
                processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.tipo_cuenta+' - '+item.nombre_cuenta,
                        };
                    })
                };
                },
                cache: true
            }
        });
    }
    
    function changue_bancos_trans(){
        console.log('b');
        var id_banc = $("#select_banco_transf_adl").val();
        $('#select_cuenta_adl_transf').select2({
            placeholder: "Seleccionar",
            ajax: {
                minimumInputLength: 1,
                url: "{{route('bancos.registros_search')}}",
                dataType: 'json',
                type: "POST",
                data: function (params) {
                    return {
                        '_token': $('input[name=_token]').val(),
                        'id_bancos': id_banc
                    };
                },
                processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.tipo_cuenta+' - '+item.nombre_cuenta,
                        };
                    })
                };
                },
                cache: true
            }
        });
    }

    var elem_2 = document.querySelector('.js-switch');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

    function pago_adelanto(n_boleta, tipo, cuota_id){  // PARA BOLETA NORMAL
        // tipo === ONLY : VIEW EDIT || FULL || INDEX
        console.log(tipo);
        $('#adelanto_header').empty();
        if (tipo == "full") {
            var html_id_bol = `<input type="hidden" name="id_boleta" id="id_boleta_` + n_boleta + `" value="` + n_boleta + `">`;
            $('#id_boleta_adl').append(html_id_bol);
            $.ajax({
                type: "post",
                url: "{{route('adelantos.ajax_bol')}}",
                data: {
                        
                    'id_boleta': n_boleta
                },
                success: function(msg){
                    var data_msg = `
                        <div class="col-sm-4">
                            <h3 class="text-center">N° de Boleta</h3>
                            <label class="form-control">` + msg.boleta_cod +`</label>
                            <input class="" type="hidden" name="numero_boleta" id="numero_bol" value="` + msg.boleta_cod + `">
                        </div>
                        <div class="col-sm-4">
                            <h3 class="text-center">Cuota</h3>
                            <select placeholder="" id="select_adelanto" class="select_2_multipl" name="cuotas_precio_` + msg.boleta_cod + `"  onchangue="select_2_adelanto()" required> <option value="" selected disabled style="display:none;">Selecciona una opción</option> ` + msg.cuotas_array.map(function(bar) {
                                    if (bar.estado == 0) {
                                        return '<option value="' + bar.id_cuota + '_' + bar.monto +
                                            '">' +
                                            'N°-' + bar.cuota_n + ': ' + bar.monto + '</option>'
                                    }
                                }) + `
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="text-center">Total</h3>
                            <div class="input-group col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="simbolor_label">` + msg.boleta_simbolo + `</span>
                                </div>
                                <label class="form-control" id="lbl_tot_adl">0</label>
                                <input class="form-control" type="hidden" name="tot_cuotas[]" id="total_cuotas">
                            </div>
                        </div>
                    `;
                    $('#adelanto_header').append(data_msg);
                            
                    $('#select_adelanto').select2({
                        placeholder: "Seleccionar Cuotas"
                    });
                    $(`#select_adelanto`).on('select2:select', function(e) {
                        var data = e.params.data;
                        var math_total = data.text.replace(/N°-\d+: /g, '');
                        var igual = $("#simbolor_label").html();
                        $(`#lbl_tot_adl`).html(math_total);

                        var tot_math = Math.round(math_total * 100) / 100;
        
                        $('#simbolo_adelanto').html(igual);
                        $('#simbolo_adelanto_vuelto').html(igual);
                        $('#simbolo_adelanto_tarjeta').html(igual);
                        $('#simbolo_adelanto_transferencia').html(igual);
                        

                        $('#cheque_adl_monto').attr('max', tot_math);
                        $('#efectivo_adelanto').attr('max', tot_math);
                        $('#monto_tarjeta_adl').attr('max', tot_math);
                        $('#tranferencia_adl_monto').attr('max', tot_math);
                                        
                    });
                }
            });
        } else {

            var serie = $('#serie_comp').val();
            var n_cuota = $(`#n_cuota_`+cuota_id).html();
            var n_cuota_view = $(`#cuota_view_n_`+cuota_id).html();
            var simbolo_precio = $('#simbolo_precio').val();
            var tota_cuota = $(`#total_`+cuota_id).val();
            var monto_sin_for = $(`#monto_sin_format_`+cuota_id).val();
            
            var html_id_bol = `<input type="hidden" name="id_boleta" id="id_boleta_` + n_boleta + `" value="` + n_boleta + `">`;
            $('#id_boleta_adl').append(html_id_bol);

            var data_html = `
                <div class="col-sm-4">
                    <h3 class="text-center">N° de Boleta</h3>
                    <label class="form-control">`+ serie +`</label>
                    <input class="" type="hidden" name="numero_boleta" id="numero_bol" value="`+ serie +`">
                </div>
                <div class="col-sm-4">
                    <h3 class="text-center">Cuota N</h3>
                    <label class="form-control">Cuota N  `+ n_cuota_view +`</label>
                    <input type="hidden" name="cuotas_precio_`+ serie +`" id="" value="`+ n_cuota +`_`+monto_sin_for+`">
                </div>
                <div class="col-sm-4">
                    <h3 class="text-center">Total</h3>
                    <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="simbolor_label">` + simbolo_precio   + `</span>
                        </div>
                        <label class="form-control" id="lbl_tot_adl">` + monto_sin_for   + `</label>
                        <input class="form-control" type="hidden" name="tot_cuotas[]" id="total_cuotas">
                    </div>
                </div>
            `;
            $('#adelanto_header').append(data_html);
            $('#simbolo_adelanto').html(simbolo_precio);
            $('#simbolo_adelanto_vuelto').html(simbolo_precio);
            $('#simbolo_adelanto_tarjeta').html(simbolo_precio);
            $('#simbolo_adelanto_transferencia').html(simbolo_precio);
            

            $('#cheque_adl_monto').attr('max', tota_cuota);
            $('#efectivo_adelanto').attr('max', tota_cuota);
            $('#monto_tarjeta_adl').attr('max', tota_cuota);
            $('#tranferencia_adl_monto').attr('max', tota_cuota);
        }
    }


    function pago_adelanto_m(n_boleta, tipo, cuota_id){  // BOLETA MANUAL
        // tipo === ONLY : VIEW EDIT || FULL || INDEX
        $('#adelanto_header').empty();
        if (tipo == "full") {
            var html_id_bol = `<input type="hidden" name="id_boleta" id="id_boleta_` + n_boleta + `" value="` + n_boleta + `">`;
            $('#id_boleta_adl').append(html_id_bol);
            $.ajax({
                type: "post",
                url: "{{route('adelantos.ajax_bol_m')}}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id_boleta_m': n_boleta
                },
                success: function(msg){
                    var data_msg = `
                        <div class="col-sm-4">
                            <h3 class="text-center">N° de Boleta</h3>
                            <label class="form-control">` + msg.boleta_cod +`</label>
                            <input class="" type="hidden" name="numero_boleta" id="numero_bol" value="` + msg.boleta_cod + `">
                        </div>
                        <div class="col-sm-4">
                            <h3 class="text-center">Cuota</h3>
                            <select placeholder="" id="select_adelanto" class="select_2_multipl" name="cuotas_precio_` + msg.boleta_cod + `"  onchangue="select_2_adelanto()" required> <option value="" selected disabled style="display:none;">Selecciona una opción</option> ` + msg.cuotas_array.map(function(bar) {
                                    if (bar.estado == 0) {
                                        return '<option value="' + bar.id_cuota + '_' + bar.monto +
                                            '">' +
                                            'N°-' + bar.cuota_n + ': ' + bar.monto + '</option>'
                                    }
                                }) + `
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="text-center">Total</h3>
                            <div class="input-group col-sm-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="simbolor_label">` + msg.boleta_simbolo + `</span>
                                </div>
                                <label class="form-control" id="lbl_tot_adl">0</label>
                                <input class="form-control" type="hidden" name="tot_cuotas[]" id="total_cuotas">
                            </div>
                        </div>
                    `;
                    $('#adelanto_header').append(data_msg);
                            
                    $('#select_adelanto').select2({
                        placeholder: "Seleccionar Cuotas"
                    });
                    $(`#select_adelanto`).on('select2:select', function(e) {
                        var data = e.params.data;
                        var math_total = data.text.replace(/N°-\d+: /g, '');
                        var igual = $("#simbolor_label").html();
                        $(`#lbl_tot_adl`).html(math_total);

                        var tot_math = Math.round(math_total * 100) / 100;
        
                        $('#simbolo_adelanto').html(igual);
                        $('#simbolo_adelanto_vuelto').html(igual);
                        $('#simbolo_adelanto_tarjeta').html(igual);
                        $('#simbolo_adelanto_transferencia').html(igual);
                        

                        $('#cheque_adl_monto').attr('max', tot_math);
                        $('#efectivo_adelanto').attr('max', tot_math);
                        $('#monto_tarjeta_adl').attr('max', tot_math);
                        $('#tranferencia_adl_monto').attr('max', tot_math);
                                        
                    });
                }
            });
        } else {

            var serie = $('#serie_comp').val();
            var n_cuota = $(`#n_cuota_`+cuota_id).html();
            var simbolo_precio = $('#simbolo_precio').val();
            var tota_cuota = $(`#total_`+cuota_id).val();
            var monto_sin_for = $(`#monto_sin_format_`+cuota_id).val();
            
            var html_id_bol = `<input type="hidden" name="id_boleta" id="id_boleta_` + n_boleta + `" value="` + n_boleta + `">`;
            $('#id_boleta_adl').append(html_id_bol);

            var data_html = `
                <div class="col-sm-4">
                    <h3 class="text-center">N° de Boleta</h3>
                    <label class="form-control">`+ serie +`</label>
                    <input class="" type="hidden" name="numero_boleta" id="numero_bol" value="`+ serie +`">
                </div>
                <div class="col-sm-4">
                    <h3 class="text-center">Cuota N</h3>
                    <label class="form-control">Cuota N  `+ n_cuota +`</label>
                    <input type="hidden" name="cuotas_precio_`+ serie +`" id="" value="`+ n_cuota +`_`+monto_sin_for+`">
                </div>
                <div class="col-sm-4">
                    <h3 class="text-center">Total</h3>
                    <div class="input-group col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="simbolor_label">` + simbolo_precio   + `</span>
                        </div>
                        <label class="form-control" id="lbl_tot_adl">` + monto_sin_for   + `</label>
                        <input class="form-control" type="hidden" name="tot_cuotas[]" id="total_cuotas">
                    </div>
                </div>
            `;
            $('#adelanto_header').append(data_html);
            $('#simbolo_adelanto').html(simbolo_precio);
            $('#simbolo_adelanto_vuelto').html(simbolo_precio);
            $('#simbolo_adelanto_tarjeta').html(simbolo_precio);
            $('#simbolo_adelanto_transferencia').html(simbolo_precio);
            

            $('#cheque_adl_monto').attr('max', tota_cuota);
            $('#efectivo_adelanto').attr('max', tota_cuota);
            $('#monto_tarjeta_adl').attr('max', tota_cuota);
            $('#tranferencia_adl_monto').attr('max', tota_cuota);
        }
    }
    function select_adelanto_click(item) {
        clean_requires();
        $('#value_option_type').val(item)
        $('.adelanto_m').css('display', 'none');
        $(`.m_adelanto_` + item).css('display', 'flex');

        $('.class_adelanto').attr('required', false);
        
        $(`.adelanto_class_` + item).attr('required', true);
        $(`.file_input`).attr('required', false);

        $('.btn_adelanto_selec').removeClass("active");
        $(`#bm_adelanto_` + item).addClass("active");
        $('#input_adelanto').val(item);

        var fecha = $('#fecha_value_php').val();
        // console.log(fecha);
        $('.fecha_hoy').val(fecha);
    }
    
    function clean_requires(){
        $('.class_adelanto').attr('required', false);
    }

    $('#guardar_adelanto').on('click', function (){
        console.log('a');
        //* seleccion basada en el input select
        var total = $(`#lbl_tot_adl`).html();
        var item  = $('#value_option_type').val();
        console.log(typeof(total));
        switch (item) {
            case '1': //cheque
                var total_input_monto = $('#cheque_adl_monto').val();    
                var input = $('#cheque_adl_monto');    
                break;
            case '2': //tarjeta
                var total_input_monto = $('#monto_tarjeta_adl').val();    
                var input = $('#monto_tarjeta_adl');    
                break;
            case '3': //efectivo
                var total_input_monto = $('#efectivo_adelanto').val();
                var input = $('#efectivo_adelanto');
                break;
            case '4': //transferencia
                var total_input_monto = $('#tranferencia_adl_monto').val();    
                var input = $('#tranferencia_adl_monto');    
                break;
        }
        input.css('border-color', 'none');
        console.log(typeof(total_input_monto));

        if(parseFloat(total_input_monto) >= parseFloat(total)){
            // console.log(total_input_monto);
            input.css('border-color', 'red');
        }else{
            $('#button_submit_adelanto').click();
        }
    });

</script>