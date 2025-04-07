<div class="modal fade" id="producto_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
        <div class="modal-content">
            <div class="modal-body" style="padding: 0px;">
                <div class="ibox-content float-e-margins">
                    <h3 class="font-bold col-lg-12" align="center">
                        ¿Esta Seguro que Deseas Anular el Producto:<br><span id="prod_nombre"> </span>? <br>
                        <h4 align="center"> <strong>Nota: Una vez Anulado no hay opción de devolver la acción </strong>
                        </h4>
                    </h3>
                    <p align="center">
                    <form action="{{ route('productos.destroy') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_producto" id="prod_id_form" value="">
                        <center>
                            <button type="submit" class="btn btn-w-m btn-primary" id="button_anular">Anular</button>
                        </center>
                    </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
