@extends('layout')

@section('title', 'Consulta de Garantía de Cliente - Control de Lotes y Garantías')
@section('breadcrumb', 'Inventario')
@section('breadcrumb2', 'Garantía de Cliente')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">

    {{-- Navegación secundaria entre los submódulos --}}
    @include('inventario.lotes_garantias.navbar_tabs')

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="ibox border-left border-primary shadow-sm">
                <div class="ibox-title text-white py-3 d-flex justify-content-between align-items-center" style="background-color: #2641f8;">
                    <h5 class="mb-0 text-white font-weight-bold" style="font-size: 16px;">
                        <i class="fa fa-user-circle mr-2"></i>Consulta Garantía de Clientes
                    </h5>
                    <span class="badge badge-light text-primary font-weight-bold">Atención Postventa</span>
                </div>
                <div class="ibox-content p-4">

                    {{-- Formulario guiado de consulta (Página 12 y 14 PDF) --}}
                    <form id="formGarantiaCliente">
                        <div class="alert alert-light border mb-4 text-muted" style="font-size: 13px;">
                            <i class="fa fa-info-circle text-primary mr-1"></i>
                            Ingrese el comprobante del cliente (Factura o Guía de Remisión) y el código del producto para validar la vigencia de su garantía.
                        </div>

                        {{-- Selector de Tipo de Documento --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">Tipo de Comprobante:</label>
                            <div class="col-sm-8 d-flex align-items-center">
                                <div class="custom-control custom-radio custom-control-inline mr-4">
                                    <input type="radio" id="tipoDocFactura" name="tipo_documento" class="custom-control-input" value="factura" checked>
                                    <label class="custom-control-label font-weight-bold" for="tipoDocFactura">
                                        <i class="fa fa-file-text-o mr-1"></i> Factura
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="tipoDocGuia" name="tipo_documento" class="custom-control-input" value="guia">
                                    <label class="custom-control-label font-weight-bold" for="tipoDocGuia">
                                        <i class="fa fa-truck mr-1"></i> Guía de Remisión
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Número de Factura o Guía --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold" id="lblNumDoc">Num. Factura:</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="num_documento" placeholder="Ej: F001-000123...">
                                </div>
                            </div>
                        </div>

                        {{-- Fecha de Venta (Visualización calculada) --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">F. Venta Prod:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light" name="fecha_venta" id="gcFechaVenta" placeholder="Se completará al validar el documento..." readonly>
                            </div>
                        </div>

                        {{-- Código del Producto --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">Cod. de Producto:</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="codigo_producto" placeholder="Ej: P-12345...">
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="form-group row mb-4">
                            <div class="col-sm-8 offset-sm-4 d-flex">
                                <button type="button" class="btn btn-primary font-weight-bold mr-2" style="background-color: #2641f8; border-color: #2641f8;">
                                    <i class="fa fa-search mr-1"></i> Validar Garantía
                                </button>
                                <button type="reset" class="btn btn-outline-secondary font-weight-bold">
                                    <i class="fa fa-times mr-1"></i> Cancelar
                                </button>
                            </div>
                        </div>

                        <hr>

                        {{-- Tarjeta de Resultados del Estatus de Garantía (Página 12 PDF) --}}
                        <h6 class="font-weight-bold text-dark mb-3">
                            <i class="fa fa-certificate text-primary mr-1"></i> Estatus de Garantía del Cliente
                        </h6>

                        <div class="card bg-light border p-3" style="border-radius: 6px;">
                            <div class="row" style="font-size: 13px;">
                                <div class="col-sm-6 mb-2">
                                    <span class="text-muted d-block">Fecha de Vencimiento de Garantía:</span>
                                    <strong class="text-dark" id="resGcFecVenc">--</strong>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="text-muted d-block">Tiempo Total de Garantía:</span>
                                    <strong class="text-dark" id="resGcTiempoTotal">--</strong>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="text-muted d-block">Garantía Transcurrida:</span>
                                    <strong class="text-dark" id="resGcTiempoTransc">--</strong>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <span class="text-muted d-block">Estado de la Garantía:</span>
                                    <span class="badge badge-secondary" id="resGcEstado">Sin consultar</span>
                                </div>
                            </div>
                        </div>

                        {{-- Términos y Condiciones Aplicables (Página 14 PDF) --}}
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fa fa-gavel mr-1"></i><strong>Condiciones aplicables:</strong>
                                La garantía cubre defectos de fabricación bajo condiciones normales de uso. No aplica para fallas por manipulación indebida, daños por sobretensión o roturas físicas.
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radFactura = document.getElementById('tipoDocFactura');
        const radGuia = document.getElementById('tipoDocGuia');
        const lblNumDoc = document.getElementById('lblNumDoc');

        if (radFactura && radGuia && lblNumDoc) {
            radFactura.addEventListener('change', function () {
                if (this.checked) lblNumDoc.textContent = 'Num. Factura:';
            });
            radGuia.addEventListener('change', function () {
                if (this.checked) lblNumDoc.textContent = 'Guía de Remisión:';
            });
        }
    });
</script>
@endsection
