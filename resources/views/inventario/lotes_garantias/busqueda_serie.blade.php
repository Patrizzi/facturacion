@extends('layout')

@section('title', 'Búsqueda por Serie - Control de Lotes y Garantías')
@section('breadcrumb', 'Inventario')
@section('breadcrumb2', 'Búsqueda por Serie')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">

    {{-- Navegación secundaria entre los submódulos --}}
    @include('inventario.lotes_garantias.navbar_tabs')

    {{-- Buscador Principal Superior (Página 2 PDF 2) --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-search mr-2"></i>Búsqueda de Producto y Trazabilidad por Serie</h5>
                </div>
                <div class="ibox-content">
                    <form id="formBusquedaSerie">
                        <div class="form-row align-items-end">
                            <div class="col-md-5 col-sm-12 mb-2">
                                <label class="font-weight-bold" style="font-size: 13px;">Número de Serie:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="numero_serie" placeholder="Ingrese número de serie del producto...">
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12 mb-2">
                                <label class="font-weight-bold" style="font-size: 13px;">Producto o Código:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-cube"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="codigo_producto" placeholder="Ingrese código o modelo de producto...">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 mb-2 d-flex">
                                <button type="button" class="btn btn-primary btn-block mr-1 font-weight-bold" style="background-color: #2641f8; border-color: #2641f8;">
                                    <i class="fa fa-search mr-1"></i> Buscar
                                </button>
                                <button type="reset" class="btn btn-outline-secondary" title="Limpiar formulario">
                                    <i class="fa fa-eraser"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 3 Tarjetas de Resumen Organizadas: Lote, Garantía y Estado (Página 2-3 PDF 2) --}}
    <div class="row">
        {{-- Tarjeta 1: Lote --}}
        <div class="col-lg-4 col-md-12 mb-3">
            <div class="ibox border-left border-primary shadow-sm h-100 mb-0">
                <div class="ibox-title py-2 d-flex justify-content-between align-items-center">
                    <h5 class="text-primary font-weight-bold mb-0"><i class="fa fa-cubes mr-2"></i>Lote</h5>
                    <span class="badge badge-light border">Producción</span>
                </div>
                <div class="ibox-content py-3">
                    <ul class="list-group list-group-flush" style="font-size: 13px;">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Código de Lote:</span>
                            <span class="font-weight-bold text-dark" id="resLote">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Proveedor:</span>
                            <span class="font-weight-bold text-dark" id="resProveedor">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Unidades del Lote:</span>
                            <span class="font-weight-bold text-dark" id="resUnidades">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Fecha de Producción:</span>
                            <span class="font-weight-bold text-dark" id="resFechaProduccion">--</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Tarjeta 2: Garantía --}}
        <div class="col-lg-4 col-md-12 mb-3">
            <div class="ibox border-left border-success shadow-sm h-100 mb-0">
                <div class="ibox-title py-2 d-flex justify-content-between align-items-center">
                    <h5 class="text-success font-weight-bold mb-0"><i class="fa fa-shield mr-2"></i>Garantía</h5>
                    <span class="badge badge-light border">Vigencia</span>
                </div>
                <div class="ibox-content py-3">
                    <ul class="list-group list-group-flush" style="font-size: 13px;">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Estado Garantía:</span>
                            <span class="badge badge-secondary" id="resEstadoGarantia">Sin verificar</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Fecha de Venta:</span>
                            <span class="font-weight-bold text-dark" id="resFechaVenta">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Fecha Vencimiento:</span>
                            <span class="font-weight-bold text-dark" id="resFechaVencimiento">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Días Restantes:</span>
                            <span class="font-weight-bold text-dark" id="resDiasRestantes">--</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Tarjeta 3: Estado y Calidad --}}
        <div class="col-lg-4 col-md-12 mb-3">
            <div class="ibox border-left border-info shadow-sm h-100 mb-0">
                <div class="ibox-title py-2 d-flex justify-content-between align-items-center">
                    <h5 class="text-info font-weight-bold mb-0"><i class="fa fa-map-marker mr-2"></i>Estado y Ubicación</h5>
                    <span class="badge badge-light border">Stock</span>
                </div>
                <div class="ibox-content py-3">
                    <ul class="list-group list-group-flush" style="font-size: 13px;">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Condición / Estado:</span>
                            <span class="font-weight-bold text-dark" id="resCondicion">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Ubicación Física:</span>
                            <span class="font-weight-bold text-dark" id="resUbicacion">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Calificación Calidad:</span>
                            <span class="badge badge-light border font-weight-bold" id="resCalidad">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Último Movimiento:</span>
                            <span class="font-weight-bold text-dark" id="resUltimoMovimiento">--</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla con Historial de Series Relacionadas (Página 2 PDF 2) --}}
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title d-flex justify-content-between align-items-center">
                    <h5><i class="fa fa-history mr-2"></i>Historial de Series Relacionadas al Producto</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center" style="font-size: 13px;">
                            <thead class="thead-light">
                                <tr>
                                    <th class="align-middle">ID Serie</th>
                                    <th class="align-middle">Número de Serie</th>
                                    <th class="align-middle">Código Producto</th>
                                    <th class="align-middle">Lote</th>
                                    <th class="align-middle">Estado</th>
                                    <th class="align-middle">Fecha Venta</th>
                                    <th class="align-middle">Fecha Vencimiento</th>
                                    <th class="align-middle">Ubicación</th>
                                    <th class="align-middle">Calidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Empty state limpio conforme a requerimientos (sin datos estáticos falsos) --}}
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="fa fa-barcode fa-3x mb-3 text-muted d-block"></i>
                                        <p class="font-weight-bold mb-1" style="font-size: 15px;">No hay historial de series disponible</p>
                                        <small class="text-muted">Ingrese un número de serie o código de producto en el buscador superior para consultar el historial.</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
