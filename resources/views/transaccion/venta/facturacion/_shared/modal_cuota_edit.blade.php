<!-- Modal Tipo de Pago | Cuotas -->
<div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_campos"
                    style="display: none">
                    <strong style="font-size:11px">Rellenar todos los campos</strong>
                    <button type="button" class="close_model_rc close" onclick="cerrar_but_rc()" style="padding: 6;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="suma_campos"
                    style="display: none">
                    <strong style="font-size:11px">La suma de las cuotas es diferente del monto
                        total</strong>
                    <button type="button" class="close_model_mt close" onclick="cerrar_but_mt()" style="padding: 6;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row_number">
                    @forelse ($facturacion->cuotas_credito as $i_cuota => $cuotas)
                        <div class="pago_modal row">
                            <div class="col-sm-1"><label>Fecha:</label></div>
                            <div class="col-sm-4">
                                <input type="date" name="fecha_pago[]" id="fecha_pago{{ $i_cuota }}"
                                    class="fecha_pago form-control" min="{{ $facturacion->fecha_emision_edit }}"
                                    value="{{ $cuotas->fecha_pago }}">
                            </div>
                            <div class="col-sm-1"><label>Monto:</label></div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3" style="padding-right:15px">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="basic-addon3">{{ $facturacion->moneda->simbolo }}</span>
                                    </div>
                                    <input type="text" name="monto_pago[]" id="monto_pago{{ $i_cuota }}"
                                        class="monto_pago form-control" onkeypress="return filterFloat(event,this);"
                                        value="{{ $cuotas->monto }}">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                @if ($i_cuota == 0)
                                    <label><button type="button" aria-hidden="true" id="add_pago"
                                            class="add_pago btn btn-success"><i class="fa fa-plus-square-o fa-lg">
                                            </i></button></label>
                                @else
                                    <label>
                                        <button type="button" class="xd btn btn-danger"
                                            onclick="eliminar({{ $i_cuota }})"><i class="fa fa-trash-o fa-lg"> </i>
                                    </label>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="pago_modal row">
                            <div class="col-sm-1"><label>Fecha:</label></div>
                            <div class="col-sm-4">
                                <input type="date" name="fecha_pago[]" id="fecha_pago0"
                                    class="fecha_pago form-control" min="{{ $facturacion->fecha_emision_edit }}">
                            </div>
                            <div class="col-sm-1"><label>Monto:</label></div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3" style="padding-right:15px">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">{{ $moneda->simbolo }}</span>
                                    </div>
                                    <input type="text" name="monto_pago[]" id="monto_pago0"
                                        class="monto_pago form-control" onkeypress="return filterFloat(event,this);">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <label><button type="button" aria-hidden="true" id="add_pago"
                                        class="add_pago btn btn-success"><i class="fa fa-plus-square-o fa-lg">
                                        </i></button></label>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer" style="display: block">
                <div class="row">
                    <div class="col-sm-6" style="">
                        <label for=""><strong>Precio Total: &nbsp;</strong><span
                                id="simb_fot">{{ $moneda->simbolo }}</span>&nbsp;</label><label
                            id="cuotas_footer"></label>
                    </div>
                    <div class="col-sm-6" align="right">
                        <button type="button" id="button_cuotas_save" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
