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
                                            id="subtotal-simbolo">{{ $moneda->simbolo ?? ($cotizacion->moneda->simbolo ?? $moneda->where('principal', 1)->pluck('simbolo')->first()) }}</span>
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

<style>
    .bootstrap-touchspin {
        background-color: #f4f5f7;
        border-radius: 50px;
        overflow: hidden;
        border: none;
        display: inline-flex;
        align-items: center;
        width: auto;
    }

    .bootstrap-touchspin .touchspin-btn {
        background-color: transparent !important;
        border: none !important;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: none !important;
    }

    .bootstrap-touchspin .touchspin-btn:hover {
        background-color: #e9eaed !important;
        border-radius: 50%;
    }

    .bootstrap-touchspin .touchspin1 {
        background-color: transparent !important;
        border: none !important;
        text-align: center;
        box-shadow: none !important;
        width: 40px;
        padding: 0;
    }

    .bootstrap-touchspin .touchspin1:focus {
        outline: none;
        box-shadow: none;
    }

    .bootstrap-touchspin .input-group-btn {
        display: flex;
    }

    .btn.btn-link.btn-sm.bootstrap-touchspin-up:hover,
    .btn.btn-link.btn-sm.bootstrap-touchspin-down:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    .input-cantidad.js-touchspin-init {
        font-size: 12px;
    }

    ul.pagination {
        margin-bottom: 0px;
    }

    .precio_search {
        vertical-align: middle !important;
        /* text-align: center !important; */

    }

    .precio_cantidad {
        text-align: center !important;
    }

    .bootstrap-touchspin {
        flex-wrap: nowrap;
    }

    .precio_dt {
        text-align: right !important;
        vertical-align: middle !important;
    }

    .modal-cart-footer {
        position: absolute;
        margin-left: 0px;
        right: 15px;
        bottom: 0px;
    }

    .small-description {
        font-size: 9px !important;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    #DataTables_Table_0_info {
        margin-bottom: 5px !important;
    }

    .articulo-nombre {
        max-width: 330px;
        overflow: hidden;
        white-space: nowrap;
        position: relative;
    }

    .articulo-nombre.is-overflowing span {
        display: inline-block;
        animation: marquee 8s linear infinite;
        padding-right: 40px;
        /* espacio antes de repetir */
    }

    @keyframes marquee {

        0%,
        30% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(calc(-100% - 20px));
        }
    }
</style>
