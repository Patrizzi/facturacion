<!-- Modal AGREGAR CON UN CLICK UN ARTICULO -->
<div class="modal fade bd-example-modal-lg" id="add_product_data" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="height: 575px;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Agregado Rápido de Artículos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6" style="margin-bottom: 15px">
                        <input type="text" name="" id="search_product" class="form-control form-control-sm"
                            placeholder="Buscar por código o nombre del producto o servicio" autocomplete="off">
                    </div>
                    <div class="col-sm-6" style="margin-bottom: 15px">
                        <button data-toggle="button" class="btn btn-primary btn-outline btn-sm" type="button"
                            aria-pressed="false" id="button_filter_stock">Con Stock</button>
                    </div>
                </div>
                <div class="row" style="height: 90%">
                    <div class="col-lg-12">
                        <div class="table-responsive" style="height: 100% !important">
                            <table class="table table-striped table-hover data_table_multiple"
                                style="font-size: 90%;border-top: 1px solid #e7eaec;padding: 0px">
                                <thead>
                                    <tr>
                                        {{-- <th>ID</th> --}}
                                        <th>CÓDIGO</th>
                                        <th>ARTÍCULO</th>
                                        <th style="text-align: center">STOCK</th>

                                        <th>PRECIO U. </th>
                                        <th>PRECIO S/IGV</th>
                                        <th>TOTAL EST.</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-cart-footer d-flex justify-content-between align-items-center">
                            <div class="dt-left-info"></div>
                            <div class="dt-right-actions d-flex align-items-center">
                                <div class="subtotal-box text-right mr-4">
                                    <div class="subtotal-label"><strong>TOTAL ESTIMADO</strong></div>
                                    <div class="subtotal-value">
                                        <span
                                            id="subtotal-simbolo">{{ $moneda->simbolo ?? ($cotizacion->moneda->simbolo ?? $monedas->where('principal', 1)->pluck('simbolo')->first()) ?? "" }}</span>
                                        <span id="subtotal-monto">0.00</span>
                                        {{-- <span id="subtotal-items">(0 ítems)</span> --}}
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-secondary rounded-pill mr-2"
                                    id="btn-cancelar-cotizacion" data-dismiss="modal">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>