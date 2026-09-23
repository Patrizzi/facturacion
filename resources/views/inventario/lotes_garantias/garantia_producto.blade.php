@extends('layout')

@section('title', 'Consulta de Garantía de Producto - Control de Lotes y Garantías')
@section('breadcrumb', 'Inventario')
@section('breadcrumb2', 'Garantía de Producto')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">

    {{-- Navegación secundaria entre los submódulos --}}
    @include('inventario.lotes_garantias.navbar_tabs')

    {{-- Buscador de Garantía de Producto (Página 10 PDF) --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><i class="fa fa-shield mr-2"></i>Consulta de Garantía de Producto</h5>
                </div>
                <div class="ibox-content">
                    <form id="formGarantiaProducto">
                        <div class="form-row align-items-end">
                            <div class="col-md-5 col-sm-12 mb-2">
                                <label class="font-weight-bold" style="font-size: 13px;">Código de Producto:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="codigo_producto" placeholder="Ej: P-12345...">
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12 mb-2">
                                <label class="font-weight-bold" style="font-size: 13px;">Serial de Producto:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="serial_producto" placeholder="Ej: 161-S...">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 mb-2 d-flex">
                                <button type="button" class="btn btn-primary btn-block mr-1 font-weight-bold" style="background-color: #2641f8; border-color: #2641f8;">
                                    <i class="fa fa-search mr-1"></i> Buscar
                                </button>
                                <button type="button" class="btn btn-outline-primary" title="Búsqueda avanzada de más productos" data-toggle="modal" data-target="#modalBusquedaProductos">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 3 Cuadros de Información Detallada (Página 10 PDF) --}}
    <div class="row">
        {{-- Cuadro 1: Información de Garantía --}}
        <div class="col-lg-4 col-md-12 mb-3">
            <div class="ibox border-left border-primary shadow-sm h-100 mb-0">
                <div class="ibox-title py-2 d-flex justify-content-between align-items-center" style="background-color: #2641f8; color: #fff;">
                    <h5 class="font-weight-bold mb-0 text-white"><i class="fa fa-calendar-check-o mr-2"></i>Información de Garantía</h5>
                </div>
                <div class="ibox-content py-3">
                    <ul class="list-group list-group-flush" style="font-size: 13px;">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Fecha de Compra:</span>
                            <span class="font-weight-bold text-dark" id="gpFechaCompra">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Fecha de Vencimiento:</span>
                            <span class="font-weight-bold text-dark" id="gpFechaVencimiento">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Tiempo Total Cobertura:</span>
                            <span class="font-weight-bold text-dark" id="gpTiempoTotal">--</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Cuadro 2: Información de Producto --}}
        <div class="col-lg-4 col-md-12 mb-3">
            <div class="ibox border-left border-info shadow-sm h-100 mb-0">
                <div class="ibox-title py-2 d-flex justify-content-between align-items-center" style="background-color: #23c6c8; color: #fff;">
                    <h5 class="font-weight-bold mb-0 text-white"><i class="fa fa-cube mr-2"></i>Información de Producto</h5>
                </div>
                <div class="ibox-content py-3">
                    <ul class="list-group list-group-flush" style="font-size: 13px;">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Número de Lote:</span>
                            <span class="font-weight-bold text-dark" id="gpNumLote">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Código Interno:</span>
                            <span class="font-weight-bold text-dark" id="gpCodInterno">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Marca:</span>
                            <span class="font-weight-bold text-dark" id="gpMarca">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Producto / Descripción:</span>
                            <span class="font-weight-bold text-dark" id="gpProducto">--</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Cuadro 3: Información de Proveedor --}}
        <div class="col-lg-4 col-md-12 mb-3">
            <div class="ibox border-left border-warning shadow-sm h-100 mb-0">
                <div class="ibox-title py-2 d-flex justify-content-between align-items-center" style="background-color: #1c84c6; color: #fff;">
                    <h5 class="font-weight-bold mb-0 text-white"><i class="fa fa-truck mr-2"></i>Información de Proveedor</h5>
                </div>
                <div class="ibox-content py-3">
                    <ul class="list-group list-group-flush" style="font-size: 13px;">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Código Proveedor:</span>
                            <span class="font-weight-bold text-dark" id="gpCodProv">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Nombre Proveedor:</span>
                            <span class="font-weight-bold text-dark" id="gpNomProv">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">N° Guía / Factura:</span>
                            <span class="font-weight-bold text-dark" id="gpNumDoc">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Guía Remisión:</span>
                            <span class="font-weight-bold text-dark" id="gpGuiaRemision">--</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted">Estado Garantía:</span>
                            <span class="badge badge-secondary" id="gpEstadoGarantia">Sin consultar</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Cuadro Resumen Inferior (Página 10 PDF) --}}
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title d-flex justify-content-between align-items-center">
                    <h5><i class="fa fa-table mr-2"></i>Resumen General de Garantía del Producto</h5>
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
                                    <th class="align-middle">N. Serie</th>
                                    <th class="align-middle">Código</th>
                                    <th class="align-middle">Marca</th>
                                    <th class="align-middle">Producto</th>
                                    <th class="align-middle">F. Venta</th>
                                    <th class="align-middle">F. Venc. Garantía</th>
                                    <th class="align-middle">Est. Garantía</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Empty state limpio conforme a requerimientos (sin datos estáticos falsos) --}}
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fa fa-shield fa-3x mb-3 text-muted d-block"></i>
                                        <p class="font-weight-bold mb-1" style="font-size: 15px;">No se ha consultado ningún producto</p>
                                        <small class="text-muted">Ingrese el código de producto y su número de serie para verificar la vigencia de garantía de la empresa y del proveedor.</small>
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

{{-- Modal para búsqueda avanzada / visualizar más productos (Página 10 PDF) --}}
<div class="modal fade" id="modalBusquedaProductos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2641f8; color: #fff;">
                <h5 class="modal-title text-white" id="modalLabel"><i class="fa fa-search mr-2"></i>Búsqueda Avanzada de Productos para Garantía</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Buscar por código, serie o descripción del producto...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" style="background-color: #2641f8; border-color: #2641f8;">Buscar</button>
                    </div>
                </div>
                <div class="text-center py-4 text-muted">
                    <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                    <span>No hay resultados de búsqueda preliminares.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection
