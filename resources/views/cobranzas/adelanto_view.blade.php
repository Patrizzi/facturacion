<div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <i class="fa fa-money modal-icon"></i>
                <h4 class="modal-title">Detalle de Adelanto de Cuota</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0px" id="body_adelantos">
                 
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<script>
    
    function search_factura_m(id_adl){
        $.ajax({
            type: "post",
            url: "{{route('adelantos.ajax_registro')}}",
            data: {
                '_token': $('input[name=_token]').val(),
                'id_adl_reg': id_adl
            },
            success: function(msg){
                $('#body_adelantos').empty();
                if (msg.file_input == null) {
                    var comprobante =  `<dd class="mb-1" id="sin_comprobante_cheque_adelanto"><i>Sin Comprobante</i></dd>`;
                }else{
                    var comprobante = `<a href="{{asset('/facturas_electronicas/'.`+msg.file_input+`)}}" download="{{`+msg.file_input+`}}" class="btn btn-primary btn-sm" id="comprobante_download_cheque_adelanto"><i class="fa fa-download"></i>&nbsp; Descargar</a>`;
                }
                switch (msg.tipo_pago) {
                    case "cheque":
                        if (msg.option_input != null) {
                           var diferido =  `<span class="label label-primary">Si</span>`;
                        }else{
                            var diferido =`<span class="label label-danger">No</span>`;
                        }
                        var html_adelanto = `
                        <div id="adelanto_cheque"> {{-- CHEQUE  --}}
                            <div class="row" id="">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <a href="#" class="btn btn-white btn-xs float-right">Edit project</a>
                                        <h2 id="">CHEQUE</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Diferido:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1">`+
                                                diferido
                                                +`
                                            </dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>N de Cheque:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="num_cheque_adelanto">`+msg.numero_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Fecha Cobro:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="fecha_cobro_cheque_adelanto">`+msg.fechas_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Banco Emisor:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="banco_emisor_cheque_adelanto">`+msg.bancos_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Beneficiario:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="beneficiario_cheque_adelanto">`+msg.persona_input+`</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div class="col-lg-6" id="cluster_info">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Monto:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="monto_cheque_adelanto">`+msg.montos_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>N Cuenta:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="n_cuenta_cheque_adelanto">`+msg.adicional_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Fecha Emision:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="fecha_emision_cheque_adelanto">`+msg.fecha_emision_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Comprobante:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            `+msg.montos_input+`
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="row mb-0">
                                        <div class="col-sm-2 text-sm-right">
                                            <dt>Notas Adicionales.:</dt>
                                        </div>
                                        <div class="col-sm-10 text-sm-left">
                                            <dd class="mb-1" id="notas_cheque_adelanto">`+msg.notas_adicionales+`</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        `;
                    break;
                    case "tarjeta":
                        var html_adelanto = `
                        <div id="adelanto_tarjeta"> {{-- TARJETA  --}}
                            <div class="row" id="">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <a href="#" class="btn btn-white btn-xs float-right">Edit project</a>
                                        <h2 id="">TARJETA</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Titular:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="titular_tarjeta_adelanto">`+msg.persona_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Banco:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="banco_tarjeta_adelanto">`+msg.bancos_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Monto:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="monto_tarjeta_adelanto">`+msg.fechas_input+`</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Feha:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="fecha_tarjeta_adelanto">`+msg.montos_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Comprobante:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            `+comprobante+`
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="row mb-0">
                                        <div class="col-sm-2 text-sm-right">
                                            <dt>Notas Adicionales:</dt>
                                        </div>
                                        <div class="col-sm-10 text-sm-left">
                                            <dd class="mb-1" id="notas_tarjeta_adelanto">`+msg.notas_adicionales+`</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        `;
                    break;
                    case "efectivo":
                        var html_adelanto = `
                        <div id="adelanto_efectivo"> {{-- EFECTIVO  --}}
                            <div class="row" id="">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <a href="#" class="btn btn-white btn-xs float-right">Edit project</a>
                                        <h2 id="">Efectivo</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Titular:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="titular_efectivo_adelanto">`+msg.persona_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Fecha:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="fecha_efectivo_adelanto">`+msg.fechas_input+`</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Monto:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="monto_efectivo_adelanto">`+msg.montos_input+`</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="row mb-0">
                                        <div class="col-sm-2 text-sm-right">
                                            <dt>Notas Adicionales:</dt>
                                        </div>
                                        <div class="col-sm-10 text-sm-left">
                                            <dd class="mb-1" id="notas_efectivo_adelanto">`+msg.notas_adicionales+`</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        `;
                    break;
                    case "transferencia":
                        var html_adelanto = `
                        <div id="adelanto_transferencia"> {{-- TRANSFERENCIA  --}}
                            <div class="row" id="">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <a href="#" class="btn btn-white btn-xs float-right">Edit project</a>
                                        <h2 id="">Transferencia</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Titular:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="titular_transferencia_adelanto">`+msg.persona_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Fecha:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="fecha_transferencia_adelanto">`+msg.fechas_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Cuenta Banc.:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="n_cuenta_transferencia_adelanto">`+msg.adicional_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>N Operación.:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="n_operacion_transferencia_adelanto">`+msg.numero_input+`</dd>
                                        </div>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Banco Emi.:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="banco_emisor_transferencia_adelanto">`+msg.bancos_input+`</dd>
                                        </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Monto:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            <dd class="mb-1" id="monto_transferencia_adelanto">`+msg.montos_input+`</dd>
                                        </div>
                                    </dl>
                                
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-right">
                                            <dt>Comprobante:</dt>
                                        </div>
                                        <div class="col-sm-8 text-sm-left">
                                            `+comprobante+`
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="row mb-0">
                                        <div class="col-sm-2 text-sm-right">
                                            <dt>Notas Adicionales:</dt>
                                        </div>
                                        <div class="col-sm-10 text-sm-left">
                                            <dd class="mb-1" id="notas_transferencia_adelanto">`+msg.notas_adicionales+`</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        `;
                    break;
                }
                $('#body_adelantos').append(html_adelanto);
                $('#myModal6').modal('show');
            }
        });
    }
</script>