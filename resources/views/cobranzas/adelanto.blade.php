<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('adelantos.store_adelanto_factura')}}" method="post" >
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
                        <div class="row">
                            <div class="col-sm-3">
                                <h3 class="text-center">Metodos de Adelanto</h3>
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
                            <div class="col-sm-9">
                                <div class="row adelanto_m m_adelanto_1"> {{-- Metodo de Adelanto 1 - CHEQUE --}}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">¿Es cheque diferido? </label>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input class="" type="checkbox" name="" id=""> Si
                                                </div>
                                                <div class="col-sm-6">
                                                    <input class="" type="checkbox" name="" id=""> No
                                                </div>
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
                                            <label class="col-form-label">N° de Cuenta</label>
                                            {{-- <input type="text" value="" name="cheque_n_cuenta" placeholder="N° de Cuenta" class="form-control adelanto_class_1 class_adelanto" required> --}}
                                            <select name="cheque_n_cuenta" class="form-control adelanto_class_1 class_adelanto" id="select_cuenta_adl">
                                                @foreach ($cuentas as $banco_reg)
                                                    <option value="{{$banco_reg->id}}">{{$banco_reg->tipo_cuenta}} - {{$banco_reg->monedas_i->simbolo}} - {{$banco_reg->nombre_cuenta}}</option>
                                                @endforeach
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
                                    <div class="col-sm-12">
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
                                    {{-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Vuelto</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="simbolo_adelanto_vuelto">S/</span>
                                                </div>
                                                <input type="text" name="monto_vuelto" id="efectivo_vuelto_adl" class="form-control adelanto_class_3 class_adelanto" placeholder="">
                                            </div>
                                        </div>
                                    </div> --}}
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
                                            <label class="col-form-label">N° de Cuenta Bancaria</label>
                                            <select name="transferencia_n_cuenta" class="form-control adelanto_class_4 class_adelanto" id="select_cuenta_adl_transf">
                                                @foreach ($cuentas as $banco_reg)
                                                    <option value="{{$banco_reg->id}}">{{$banco_reg->tipo_cuenta}} - {{$banco_reg->monedas_i->simbolo}} - {{$banco_reg->nombre_cuenta}}</option>
                                                @endforeach
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
                                            <label class="col-form-label">Comprobante</label>
                                            <input type="file" class="form-control adelanto_class_4 class_adelanto file_input" name="transferencia_comprobante_adl" id="" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Banco</label>
                                            <select class="form-control adelanto_class_2 class_adelanto" name="tarjeta_banco_adl" id="">
                                                <option value="">Seleccionar Banco</option>
                                                <option value="BCP">BCP</option>
                                                <option value="INTERBANK">INTERBANK</option>
                                                <option value="BBVA">BBVA</option>
                                                <option value="SCOTIABANK">SCOTIABANK</option>
                                            </select>
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
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
    function pago_adelanto_m(n_factura){
        $('#adelanto_header').empty();
        // $('#tot_simbolo').empty();
        // $('#ids_divs_factura').empty();
        // $('#todo_pago').modal('show');

        var html_id_fact = `<input type="hidden" name="adelanto_fact_m" id="id_fact`+n_factura+`"> value="n_factura"`;
        $('#id_factura_m_adl').append(html_id_fact);

        $.ajax({
            type: "post",
            url: "{{route('adelantos.ajax_fact')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'id_factura_m': n_factura
            },
            success: function(msg){
                var data_msg = `
                    <div class="col-sm-4">
                        <h3 class="text-center">N° de Factura</h3>
                        <label class="form-control">` + msg.factura_cod +`</label>
                        <input class="" type="hidden" name="numero_factura_m" id="numero_fac_m" value="` + msg.factura_cod + `">
                    </div>
                    <div class="col-sm-4">
                        <h3 class="text-center">Cuota</h3>
                        <select placeholder="" id="select_adelanto" class="select_2_multipl" name="cuotas_precio_` + msg.factura_cod + `[]"  onchangue="select_2_adelanto()" required> <option value="" selected disabled style="display:none;">Selecciona una opción</option> ` + msg.cuotas_array.map(function(bar) {
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
                                <span class="input-group-text" id="simbolor_label">` + msg.factura_simbolo + `</span>
                            </div>
                            <label class="form-control" id="lbl_tot">0</label>
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
                    $(`#lbl_tot`).html(math_total);
                    // if (igual == msg.factura_simbolo) {
                        var tot_math = Math.round(math_total * 100) / 100;
                    // } else {
                    //     if (msg.factura_moneda == "soles" && igual ==
                    //         '$') { //DE DOLAR A SOL
                    //         var new_val = parseFloat(math_total) / tipo_cambio;
                    //         var tot_math = Math.round(
                    //             parseFloat(new_val) * 100) / 100;
                    //         // console.log('a');
                    //     } else { // DE SOL A DOLAR
                    //         var new_val = parseFloat(math_total) * tipo_cambio;
                    //         var tot_math = Math.round(
                    //             parseFloat(new_val) * 100) / 100;
                    //         // console.log('b');
                    //     }
                    // }
                    $('#simbolo_adelanto_vuelto').html(igual);
                    $('#cheque_adl_monto').attr('max', tot_math);
                    $('#efectivo_adelanto').attr('max', tot_math);
                    n_cheque_adl
                    // $('#').
                    
                    console.log(tot_math);
                    // var ant = $(`#total_cuotas`).val();
                    // if (ant == "") {
                    //     ant = 0;
                    // }
                    // var data_cuota = data.text.replace(/N°-\d+: /g, '');
                    // var math_total = Math.round((parseFloat(data_cuota) + parseFloat(ant)) * 100) / 100;
                    // $(`#total_cuotas`).val(math_total);
                    // $(`#lbl_tot`).html(math_total);
                    // // TOTAL DE TOTALES

                    // if (igual == msg.factura_simbolo) {
                    //     var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(
                    //         data_cuota)) * 100) / 100;
                    // } else {
                    //     if (msg.factura_moneda == "soles" && igual ==
                    //         '$') { //DE DOLAR A SOL
                    //         var new_val = parseFloat(data_cuota) / tipo_cambio;
                    //         var tot_math = Math.round((parseFloat(tota_tot) +
                    //             parseFloat(new_val)) * 100) / 100;
                    //         // console.log('a');
                    //     } else { // DE SOL A DOLAR
                    //         var new_val = parseFloat(data_cuota) * tipo_cambio;
                    //         var tot_math = Math.round((parseFloat(tota_tot) +
                    //             parseFloat(new_val)) * 100) / 100;
                    //         // console.log('b');
                    //     }
                    // }
                    // $('#tota_totas').html(tot_math);
                    // $('#cheque_adl_monto').attr('max', tot_math);
                    // $('#efectivo_adl_pago').attr('min', tot_math);
                    // $('#cheque_adl_monto').val(tot_math);
                });
            }
        });
    }
    function select_adelanto_click(item) {
        clean_requires();
        // switch (item) {
        //     case '1': //cheque
        //         $('#n_cheque_adl').attr('required', true);
        //         $('#cheque_emisor_adl').attr('required', true);
        //         $('#cheque_beneficiario_adl').attr('required', true);
        //         $('#cheque_monto_adl').attr('required', true);
        //         $('#banco_emisor_adl').attr('required', true);
        //         $('#cheque_adl_monto').attr('required', true);
                
        //         break;
        //     case '2': //tarjeta
                
        //         break; 
        //     case '3': //efectivo0
                
        //         break;
        //     case '4': //transferencia
                
        //         break;
        // }
        
        $('.adelanto_m').css('display', 'none');
        $(`.m_adelanto_` + item).css('display', 'flex');

        $('.class_adelanto').attr('required', false);
        // $('.class_pago').val('');
        $(`.adelanto_class_` + item).attr('required', true);
        $(`.file_input`).attr('required', false);

        $('.btn_adelanto_selec').removeClass("active");
        $(`#bm_adelanto_` + item).addClass("active");
        $('#input_adelanto').val(item);

        var fecha = $('#fecha_value_php').val();
        // console.log(fecha);
        $('.fecha_hoy').val(fecha);
    }
    // $('#efectivo_adelanto').on('keyup', function() {
    //     var pago = this.value;
    //     var total = $('#lbl_tot').text();
    //     var vuelto = parseFloat(this.value) - parseFloat(total);
    //     $('#efectivo_vuelto_adl').val(Math.round(vuelto * 100) / 100);
    // })
    function clean_requires(){
        $('.class_adelanto').attr('required', false);
    }
</script>