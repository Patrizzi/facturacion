<!-- modal - Tipo de Cambio-->
<div id="modal-tipo_cambio-editar" class="modal fade " style="display: none;" aria-hidden="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Editar Tipo de Cambio</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="form_editar_tc">
                    @csrf
                    <input type="hidden" name="" id="id_tc_ed">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><strong>Fecha</strong></label>
                        <div class="col-sm-10"><input type="text" class="form-control" id="fecha_tc_ed" readonly></div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label"><strong>Compra</strong></label>
                        <div class="col-sm-10"><input type="text" class="form-control" id="compra_tc_ed"></div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label"><strong>Venta</strong></label>
                        <div class="col-sm-10"><input type="text" class="form-control" id="venta_tc_ed"></div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label"><strong>Paralelo</strong></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="paralelo_tc_ed">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <button type="button" class="btn btn-primary btn-block"  id="guardar_form">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
