<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for=""><strong>Titular de la Tarjeta</strong></label>
            <p class="form-control" id="titular_tarjeta"></p>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for=""><strong>Banco</strong></label>
            <p class="form-control" id="banco_tarjeta"></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for=""><strong>Moneda y Monto de Pago</strong></label>
            <p class="form-control" id="moneda_monto_tarjeta"></p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for=""><strong>Tipo de Cambio</strong></label>
            <p class="form-control" id="tipo_cambio_tarjeta"></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for=""><strong>Fecha de Pago</strong></label>
            <p class="form-control" id="fecha_tarjeta"></p>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for=""><strong>Comprobante</strong></label>
            {{-- <p class="form-control" id="banco_empresa_cheque"></p> --}}
            {{-- Imagen o pdf vista previa? --}}
            <br>
            <a href="#" class="btn btn-primary btn-sm button-comprobante" data-toggle="modal" data-target="#modal_comprobante_view">Ver Comprobante</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for=""><strong>Observaciones</strong></label>
            <p class="form-control" id="observaciones_tarjeta" style="min-height: 36.6px"></p>
        </div>
    </div>
</div>
