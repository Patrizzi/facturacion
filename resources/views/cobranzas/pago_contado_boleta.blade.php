<div class="modal fade bd-example-modal-lg" id="todo_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pagos.store_boleta') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="metodo_pago_header">
                        <div id="only_pago">
                            <div class="row" id="row_pago">
                                {{-- <div class="col-sm-4">
                                    <h3 class="text-center">Cuota N° | Monto</h3>
                                    <p class="text-center"><label id="cuota_n"></label> | <label
                                            id="monto_n"></label>
                                    </p>
                                    <input class="monto_total" type="hidden" name="" id="monto_value"
                                        value="0">
                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Fecha de Vencimiento</h3>
                                    <p class="text-center"><label id="fecha_ven"></label></p>
                                </div>
                                <div class="col-sm-4">
                                    <h3 class="text-center">Estado</h3>
                                    <p class="text-center"><label id="estado_n"></label></p>
                                </div> --}}
                            </div>
                            <hr>
                        </div>
                        <div id="lote_pago">

                        </div>
                    </div>
                    
                    <div class="display: none" id="ids_divs_boleta">

                    </div>
                    <input type="hidden" name="id_boleta_m[]" id="id_boleta" value="{{ $boleta->id }}">
                    <input type="hidden" name="numero_boleta_m[]" id="cod_boleta" value="{{ $cod_bol }}">
                    <input type="hidden" name="tot_cuotas[]" id="total_cuota" value="">
                    <input type="hidden" name="tipo_comprobante" value="" id="tipo_comprobante_form">
                    <input type="hidden" value="{{ $fecha_hoy }}" name="" id="fecha_value_php">
                    <div class="metodo_pago">
                        <input type="hidden" name="input_pago" id="input_pago" value="1">
                        <div class="row">
                            <div class="col-sm-3">
                                <h3 class="text-center">Metodos de Pago</h3>
                                <div class="col-lg-12">
                                    <button type="button" value="btn_pago_1"
                                        class="btn btn-block btn-primary btn_pago_selec active" id="bm_pago_1"
                                        onclick="select_pago(1)">Cheque</button>
                                </div>
                                <br>
                                <div class="col-lg-12">
                                    <button type="button" value="btn_pago_2"
                                        class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_2"
                                        onclick="select_pago(2)">Tarjeta</button>
                                </div>
                                <br>
                                <div class="col-lg-12">
                                    <button type="button" value="btn_pago_3"
                                        class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_3"
                                        onclick="select_pago(3)">Efectivo</button>
                                </div>
                                <br>
                                <div class="col-lg-12">
                                    <button type="button" value="btn_pago_4"
                                        class="btn btn-block btn-primary btn_pago_selec" id="bm_pago_4"
                                        onclick="select_pago(4)">Transferencia</button>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="row pago_m m_pago_1"> {{-- Metodo de Pago 1 - CHEQUE --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">¿Es cheque diferido? </label>
                                            <div class="">
                                                <span>No&nbsp;</span><input type="checkbox" class="js-switch-pago" name="cheque_diferido" /><span>&nbsp;Si</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Numero de Cheque</label>
                                            <input type="text" id="" name="cheque_name" value=""
                                                placeholder="Numero de Cheque"
                                                class="form-control pago_class_1 class_pago" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha de Cobro</label>
                                            <input type="date" id="" name="cheque_fecha_cobro"
                                                value="{{ $fecha_hoy }}" placeholder="Fecha de Cobro"
                                                class="form-control pago_class_1 class_pago fecha_hoy" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Banco Emisor</label>
                                            {{-- <input type="text" id="" name="cheque_banco_emisor" value="" placeholder="Banco Emisor" class="form-control pago_class_1 class_pago" required> --}}
                                            <select class="form-control pago_class_1 class_pago"
                                                name="cheque_banco_emisor" id="" required>
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
                                            <input type="text" id="" name="cheque_beneficiario"
                                                value="" placeholder="Beneficiario"
                                                class="form-control pago_class_1 class_pago" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Monto</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                </div>
                                                <input type="number" id="cheque_monto" name="cheque_monto"
                                                    value="" placeholder="Monto"
                                                    class="form-control pago_class_1 class_pago" required
                                                    step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Banco de la Empresa</label>
                                            <select name="banco_cuenta" id="select_banco_pagos" class="form-control select2_banco pago_class_1 class_pago" onchange="changue_bancos_pagos()">
                                                <option value="">Seleccionar</option>
                                                @foreach ($bancos as $banco)
                                                    <option value="{{$banco->id}}">{{$banco->nombre_banco}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">N° de Cuenta</label>
                                            <select name="cheque_n_cuenta" class="form-control pago_class_1 class_pago" id="select_cuenta_pago">
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">N° de Cuenta</label>
                                            <input type="text" value="" name="cheque_n_cuenta"
                                                placeholder="N° de Cuenta"
                                                class="form-control pago_class_1 class_pago" required>
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha de Emision</label>
                                            <input type="date" value="{{ $fecha_hoy }}"
                                                name="cheque_fecha_emision" placeholder="Fecha de Emision"
                                                class="form-control pago_class_1 class_pago" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Comprobante
                                                <small>(opcional)</small></label>
                                            <input type="file" name="cheque_file" id=""
                                                class="form-control pago_class_1 class_pago file_input">
                                        </div>
                                    </div>
                                </div>
                                {{-- {{$fecha_hoy}} --}}
                                <div class="row pago_m m_pago_2"> {{-- Metodo de Pago 2 - TARJETA --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Titular de la Tajeta</label>
                                            <input type="text" id="" name="tarjeta_titular"
                                                value="" placeholder="Titular de la Tajeta"
                                                class="form-control pago_class_2 class_pago">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Banco</label>
                                            <select class="form-control pago_class_2 class_pago" name="tarjeta_banco"
                                                id="">
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
                                            <input type="date" value="{{ $fecha_hoy }}"
                                                class="form-control pago_class_2 class_pago fecha_hoy"
                                                name="tarjeta_fecha" id="">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Comprobante</label>
                                            <input type="file"
                                                class="form-control pago_class_2 class_pago file_input"
                                                name="tarjeta_file" id="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row pago_m m_pago_3"> {{-- Metodo de Pago 3 - EFECTIVO --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Persona que Cancela</label>
                                            <input type="text" id="" name="efectivo_persona"
                                                value="" placeholder="Titular"
                                                class="form-control pago_class_3 class_pago">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha</label>
                                            <input type="date" name="fecha_efectivo"
                                                class="form-control pago_class_3 class_pago fecha_hoy" id=""
                                                value="{{ $fecha_hoy }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Monto de Pago</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="simbolo_pago">S/</span>
                                                </div>
                                                <input type="number" name="monto_pago_efectivo" id="efectivo_pago"
                                                    class="form-control pago_class_3 class_pago" placeholder=""
                                                    step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Vuelto</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="simbolo_pago_vuelto">S/</span>
                                                </div>
                                                <input type="text" name="monto_vuelto" id="efectivo_vuelto"
                                                    class="form-control pago_class_3 class_pago" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pago_m m_pago_4"> {{-- Metodo de Pago 4 - TRANSFERENCIA --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Titular</label>
                                            <input type="text" id="" name="transferencia_titular"
                                                value="" placeholder="Titular"
                                                class="form-control pago_class_4 class_pago">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Fecha</label>
                                            <input type="date"
                                                class="form-control pago_class_4 class_pago fecha_hoy"
                                                name="transferencia_fecha" id=""
                                                value="{{ $fecha_hoy }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form_adelanto">
                                            <label class="col-form-label">Banco de la Empresa</label>
                                            <select name="banco_cuenta_transf_pag" id="select_banco_transf_pag" class="pago_class_4 class_adelanto" onchange="changue_bancos_pago_tr()">
                                                <option value="">Seleccionar</option>
                                                @foreach ($bancos as $banco)
                                                    <option value="{{$banco->id}}">{{$banco->nombre_banco}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form_adelanto">
                                            <label class="col-form-label">N° de Cuenta Bancaria</label>
                                            <select name="transferencia_n_cuenta" class="form-control pago_class_4 class_adelanto" id="select_cuenta_adl_pag">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-form-label">N° de Operación</label>
                                            <input type="text"
                                                class="form-control pago_class_4 class_adelanto" name="transferencia_operacion_pag" id="transferencia_oper_pag" >
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Comprobante</label>
                                            <input type="file"
                                                class="form-control pago_class_4 class_pago file_input"
                                                name="transferencia_comprobante" id="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> {{--  NOTAS PARA TODOS --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Notas Adicionales</label>
                                            <textarea class="form-control" name="notas_adicionales" id="" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var t_comp_view = $('#tipo_comprobante_view').val();
        $('#tipo_comprobante_form').val(t_comp_view);
    });
    function select_pago(item) {
        $('.pago_m').css('display', 'none');
        $(`.m_pago_` + item).css('display', 'flex');

        $('.class_pago').attr('required', false);
        // $('.class_pago').val('');
        $(`.pago_class_` + item).attr('required', true);
        $(`.file_input`).attr('required', false);



        $('.btn_pago_selec').removeClass("active");
        $(`#bm_pago_` + item).addClass("active");
        $('#input_pago').val(item);

        var fecha = $('#fecha_value_php').val();
        console.log(fecha);
        $('.fecha_hoy').val(fecha);
    }

    function modal_pagos(value,tipo) {
        console.log(value);
        $('.input_check').remove();
        $('.cuota_prec_bol').remove()
        $('#lote_pago').css('display', 'none');
        $('#only_pago').css('display', 'block');
        $('#row_pago').empty();
        if(tipo == "credito"){
            //se abre modal
            var numero = $(`#numero_` + value).val();
            var monto = $(`#monto_` + value).val();
            var vencimiento = $(`#fecha_ven_` + value).val();
            var estado = $(`#estado_` + value).val();
            var total_c = $(`#total_` + value).val();
            var ids = `
                <input class="input_check" type="hidden" name="id_cuota[]" value="` + value + `">
                <input type="hidden" name="cuotas_precio_{{ $cod_bol }}[]" id="cuota_precio_` + value +
                `" value="` + value + '_' + total_c + `" class="cuota_prec_bol">
            `;
            $('#ids_divs_boleta').append(ids);

            // cambio en el html 1
            var html_new = `
                <div class="col-sm-4">
                    <h3 class="text-center">Cuota N° | Monto</h3>
                    <p class="text-center"><label id="cuota_n">`+ numero+`</label> | <label id="monto_n">`+monto+`</label>
                    </p>
                    <input class="monto_total" type="hidden" name="" id="monto_value" value="`+total_c+`">
                </div>
                <div class="col-sm-4">
                    <h3 class="text-center">Fecha de Vencimiento</h3>
                    <p class="text-center"><label id="fecha_ven">`+ vencimiento+`</label></p>
                </div>
                <div class="col-sm-4">
                    <h3 class="text-center">Estado</h3>
                    <p class="text-center"><label id="estado_n">`+estado+`</label></p>
                </div>
            `;
            $('#row_pago').append(html_new);;
            $('#efectivo_pago').attr('min', total_c);
            $('#id_cuota_select').val(value);
            console.log('a: ' + total_c)
            $('#total_cuota').val(total_c);
            
        }else{
            var simbolo_monto = $(`#simbolo_monto`).val();
            var monto = $(`#monto_contado`).val();
            var monto_sin_format = $(`#monto_sin_format_0`).val();
            var vencimiento = $(`#fecha_vencimiento`).val();
            // var estado = $(`#estado_` + value).val();
            // var total_c = $(`#total_` + value).val();
            var ids = `
                <input class="input_check" type="hidden" name="id_cuota[]" value=" `+  value + `">
                <input type="hidden" name="cuotas_precio_{{ $cod_bol }}[]" id="cuota_precio_` + value +
                `" value="` + value + '_' + monto + `" class="cuota_prec_bol">
            `;
            $('#ids_divs_boleta').append(ids);
            var html_new = `
                <div class="col-sm-4">
                    <h3 class="text-center">Monto</h3>
                    <p class="text-center"><label id="cuota_n"></label><label id="monto_n">`+ simbolo_monto + ` ` +monto+`</label>
                    </p>
                    <input class="monto_total" type="hidden" name="" id="monto_value" value="`+monto_sin_format+`">
                </div>
                <div class="col-sm-4">
                    <h3 class="text-center">Fecha de Vencimiento</h3>
                    <p class="text-center"><label id="fecha_ven">`+ vencimiento+`</label></p>
                </div>
                <div class="col-sm-4">
                    <h3 class="text-center">Estado</h3>
                    <p class="text-center"><label id="estado_n">PENDIENTE</label></p>
                </div>
            `;
            $('#row_pago').append(html_new);
            $('#monto_value').val(monto_sin_format);
            $('#efectivo_pago').attr('min', monto_sin_format);
            $('#id_cuota_select').val(value);

            $('#total_cuota').val(monto_sin_format);
            console.log(monto_sin_format);
        }
        $('#todo_pago').modal('show');
    }
    $('#efectivo_pago').on('keyup', function() {
        var pago = this.value;
        var total_monto = $('[class="monto_total"]');
        var tot_mont = 0;

        total_monto.each(function() {
            tot_mont += parseFloat($(this).val());
        });
        console.log(tot_mont);
        var vuelto = parseFloat(this.value) - parseFloat(tot_mont);
        $('#efectivo_vuelto').val(Math.round(vuelto * 100) / 100);
    })
</script>

