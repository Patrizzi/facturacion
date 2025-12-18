<div class="modal fade bd-example-modal-lg" id="modal_detalle_pago" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Detalle Pago de la cuota</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                <div id="pago_cheque" style="display: none">
                    <h3>Pago con Cheque</h3>
                    <div>
                        @include('cobranzas.facturas_manuales._shared.modal_detalle.cheque')
                    </div>
                </div>

                <div id="pago_tarjeta" style="display: none">
                    <h3>Pago con Tarjeta</h3>
                    <div>
                        @include('cobranzas.facturas_manuales._shared.modal_detalle.tarjeta')
                    </div>
                </div>

                <div id="pago_efectivo" style="display: none">
                    <h3>Pago con Efectivo</h3>
                    <div>
                        @include('cobranzas.facturas_manuales._shared.modal_detalle.efectivo')
                    </div>
                </div>

                <div id="pago_transferencia" style="display: none">
                    <h3>Pago con Transferncia</h3>
                    <div>
                        @include('cobranzas.facturas_manuales._shared.modal_detalle.transferencia')
                    </div>
                </div>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
             </div>
        </div>
    </div>
  </div>
</div>