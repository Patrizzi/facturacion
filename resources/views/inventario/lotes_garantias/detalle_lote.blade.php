@extends('layout')

@section('title', 'Detalle de Lote - Control de Lotes y Garantías')
@section('breadcrumb', 'Inventario')
@section('breadcrumb2', 'Detalle de Lote')

@section('content')
<style>
    /* Estilos modernos y acabados premium para Detalle de Lote */
    .lote-kpi-card {
        border-radius: 8px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.06);
        background: #ffffff;
    }
    .lote-kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(38, 65, 248, 0.12);
    }
    .kpi-icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .badge-soft-primary { background: #e0e7ff; color: #2641f8; font-weight: 600; border: 1px solid #c7d2fe; }
    .badge-soft-success { background: #dcfce7; color: #15803d; font-weight: 600; border: 1px solid #bbf7d0; }
    .badge-soft-warning { background: #fef3c7; color: #b45309; font-weight: 600; border: 1px solid #fde68a; }
    .badge-soft-danger  { background: #fee2e2; color: #b91c1c; font-weight: 600; border: 1px solid #fecaca; }
    .badge-soft-secondary { background: #f1f5f9; color: #475569; font-weight: 600; border: 1px solid #e2e8f0; }

    .nav-tabs-modern {
        border-bottom: 2px solid #e2e8f0;
    }
    .nav-tabs-modern .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 20px;
        position: relative;
        background: transparent;
        transition: color 0.2s ease;
    }
    .nav-tabs-modern .nav-link:hover {
        color: #2641f8;
    }
    .nav-tabs-modern .nav-link.active {
        color: #2641f8;
        background: transparent;
    }
    .nav-tabs-modern .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: #2641f8;
        border-radius: 3px 3px 0 0;
    }

    .table-modern thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-modern tbody tr {
        transition: background-color 0.15s ease;
    }
    .table-modern tbody tr:hover {
        background-color: #f8faff;
    }

    .progress-bar-mini {
        height: 6px;
        border-radius: 3px;
        background: #e2e8f0;
        overflow: hidden;
        margin-top: 4px;
    }
    .progress-bar-mini-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.4s ease;
    }

    .chip-detail {
        display: inline-flex;
        align-items: center;
        background: #f8fafc;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        font-size: 12.5px;
        color: #334155;
    }
    .chip-detail i {
        color: #2641f8;
        margin-right: 6px;
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">

    {{-- Navegación secundaria entre los submódulos --}}
    @include('inventario.lotes_garantias.navbar_tabs')

    {{-- Barra Superior de Información y Acciones Rápidas (Estilo Modernizado) --}}
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="ibox mb-0 shadow-sm" style="border-radius: 8px; border-left: 4px solid #2641f8;">
                <div class="ibox-content py-3" style="background: #ffffff; border-radius: 8px;">
                    <div class="row align-items-center">
                        <div class="col-md-7 col-sm-12 mb-2 mb-md-0">
                            <div class="d-flex align-items-center mb-1">
                                <span class="kpi-icon-circle bg-light text-primary mr-2" style="width: 36px; height: 36px; font-size: 16px;">
                                    <i class="fa fa-cubes"></i>
                                </span>
                                <h4 class="font-bold text-dark mb-0" style="font-size: 18px; letter-spacing: -0.3px;">
                                    Detalle de Lote de Producto
                                </h4>
                            </div>
                            <div class="d-flex flex-wrap mt-2" style="gap: 10px;">
                                <div class="chip-detail">
                                    <i class="fa fa-tag"></i> <strong>SKU:</strong>&nbsp;<span id="infoCodProducto">--</span>
                                </div>
                                <div class="chip-detail">
                                    <i class="fa fa-cube"></i> <strong>Producto / Modelo:</strong>&nbsp;<span id="infoModelo">--</span>
                                </div>
                                <div class="chip-detail">
                                    <i class="fa fa-building-o"></i> <strong>Almacén:</strong>&nbsp;<span id="infoAlmacen">--</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12 text-md-right text-left">
                            <a href="{{ route('lotes-garantias.garantia-cliente') }}" class="btn btn-primary font-weight-bold shadow-sm" style="background-color: #2641f8; border-color: #2641f8; border-radius: 6px;">
                                <i class="fa fa-user-circle mr-1"></i> Consulta Garantía Cliente
                            </a>
                            <a href="{{ route('lotes-garantias.garantia-producto') }}" class="btn btn-outline-secondary font-weight-bold ml-1" style="border-radius: 6px;">
                                <i class="fa fa-shield mr-1"></i> Garantía Producto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel de Métricas (4 Cuadros Informativos Modernos) --}}
    <div class="row mb-3">
        {{-- Métrica 1: Total Lotes --}}
        <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
            <div class="ibox lote-kpi-card shadow-sm mb-0">
                <div class="ibox-content p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Total Lotes</span>
                        <h2 class="no-margins font-bold text-dark mt-1" id="metricTotalLotes" style="font-size: 28px;">0</h2>
                        <small class="text-muted"><i class="fa fa-database mr-1"></i>Registrados en catálogo</small>
                    </div>
                    <div class="kpi-icon-circle" style="background: #eff6ff; color: #2563eb;">
                        <i class="fa fa-cubes"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Métrica 2: Unidades Disponibles --}}
        <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
            <div class="ibox lote-kpi-card shadow-sm mb-0">
                <div class="ibox-content p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Unidades Disponibles</span>
                        <h2 class="no-margins font-bold text-success mt-1" id="metricUnidadesDisponibles" style="font-size: 28px;">0</h2>
                        <small class="text-success"><i class="fa fa-check-circle mr-1"></i>Listas para facturación</small>
                    </div>
                    <div class="kpi-icon-circle" style="background: #f0fdf4; color: #16a34a;">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Métrica 3: Lotes Activos --}}
        <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
            <div class="ibox lote-kpi-card shadow-sm mb-0">
                <div class="ibox-content p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Lotes Activos</span>
                        <h2 class="no-margins font-bold text-primary mt-1" id="metricLotesActivosCount" style="font-size: 28px; color: #2641f8 !important;">0</h2>
                        <small class="text-muted"><i class="fa fa-calendar-check-o mr-1"></i>Vigentes sin expirar</small>
                    </div>
                    <div class="kpi-icon-circle" style="background: #eef2ff; color: #2641f8;">
                        <i class="fa fa-check"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Métrica 4: Lotes Vencidos --}}
        <div class="col-lg-3 col-md-6 col-sm-6 mb-2">
            <div class="ibox lote-kpi-card shadow-sm mb-0">
                <div class="ibox-content p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Lotes Vencidos</span>
                        <h2 class="no-margins font-bold text-danger mt-1" id="metricLotesVencidosCount" style="font-size: 28px;">0</h2>
                        <small class="text-danger"><i class="fa fa-clock-o mr-1"></i>Fuera de vigencia</small>
                    </div>
                    <div class="kpi-icon-circle" style="background: #fff1f2; color: #e11d48;">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Contenedor Principal de Filtros y Tablas --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox shadow-sm" style="border-radius: 8px;">
                <div class="ibox-title border-bottom-0 pb-0 pt-3 px-3">
                    <ul class="nav nav-tabs nav-tabs-modern" id="loteTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="lotes-activos-tab" data-toggle="tab" href="#lotes-activos" role="tab" data-tab="activos">
                                <i class="fa fa-check-circle text-success mr-1"></i> Lotes Activos 
                                <span class="badge badge-soft-primary ml-1" id="badgeActivos">0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="lotes-vencidos-tab" data-toggle="tab" href="#lotes-vencidos" role="tab" data-tab="vencidos">
                                <i class="fa fa-clock-o text-danger mr-1"></i> Lotes Vencidos 
                                <span class="badge badge-soft-danger ml-1" id="badgeVencidos">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="ibox-content p-3 pt-4">

                    {{-- Panel de Filtros de Búsqueda --}}
                    <div class="card border-0 mb-4 p-3" style="background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="font-weight-bold text-dark mb-0">
                                <i class="fa fa-sliders mr-2 text-primary"></i>Filtros Avanzados de Lotes
                            </h6>
                            <span class="badge badge-light border text-muted px-2 py-1" style="font-size: 11px;">
                                <i class="fa fa-info-circle mr-1"></i>Filtra por fechas, cantidades o proveedor
                            </span>
                        </div>
                        <form id="formFiltroLotes">
                            <input type="hidden" name="codigo_producto" id="filtroCodigoProducto" value="">
                            <input type="hidden" name="almacen" id="filtroAlmacen" value="">

                            <div class="form-row">
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold text-muted" style="font-size: 11px; text-transform: uppercase;">Fecha Desde:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fa fa-calendar"></i></span></div>
                                        <input type="date" class="form-control" name="fecha_desde" id="filtroFechaDesde">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold text-muted" style="font-size: 11px; text-transform: uppercase;">Fecha Hasta:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fa fa-calendar"></i></span></div>
                                        <input type="date" class="form-control" name="fecha_hasta" id="filtroFechaHasta">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold text-muted" style="font-size: 11px; text-transform: uppercase;">Texto a buscar:</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fa fa-search"></i></span></div>
                                        <input type="text" class="form-control" name="texto_buscar" id="filtroTextoBuscar" placeholder="Lote, serie o proveedor...">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold text-muted" style="font-size: 11px; text-transform: uppercase;">Estado del Lote:</label>
                                    <select class="form-control form-control-sm" name="estado" id="filtroEstado">
                                        <option value="">Todos los estados</option>
                                        <option value="Completo">Completo (100% disponible)</option>
                                        <option value="En Proceso">En Proceso (Consumo parcial)</option>
                                        <option value="Terminado">Terminado (Agotado)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mt-2 align-items-end">
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <label class="font-weight-bold text-muted" style="font-size: 11px; text-transform: uppercase;">Proveedor:</label>
                                    <select class="form-control form-control-sm" name="proveedor" id="filtroProveedor">
                                        <option value="">Todos los proveedores</option>
                                        @isset($proveedores)
                                            @foreach($proveedores as $prov)
                                                <option value="{{ $prov->id }}">{{ $prov->empresa ?? $prov->nombre }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold text-muted" style="font-size: 11px; text-transform: uppercase;">Cantidad Ingresada (Mín - Máx):</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control" name="cant_min" id="filtroCantMin" placeholder="Mín">
                                        <div class="input-group-prepend input-group-append"><span class="input-group-text">-</span></div>
                                        <input type="number" class="form-control" name="cant_max" id="filtroCantMax" placeholder="Máx">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold text-muted" style="font-size: 11px; text-transform: uppercase;">Cant. Disponible (Mín - Máx):</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control" name="disp_min" id="filtroDispMin" placeholder="Mín">
                                        <div class="input-group-prepend input-group-append"><span class="input-group-text">-</span></div>
                                        <input type="number" class="form-control" name="disp_max" id="filtroDispMax" placeholder="Máx">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12 mb-2 d-flex">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block mr-1 font-weight-bold shadow-sm" style="background-color: #2641f8; border-color: #2641f8; border-radius: 6px;">
                                        <i class="fa fa-filter mr-1"></i> Filtrar
                                    </button>
                                    <button type="button" id="btnLimpiarFiltros" class="btn btn-outline-secondary btn-sm" title="Limpiar filtros" style="border-radius: 6px;">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Contenido de Pestañas --}}
                    <div class="tab-content" id="loteTabsContent">
                        {{-- Tab 1: Lotes Activos --}}
                        <div class="tab-pane fade show active" id="lotes-activos" role="tabpanel">
                            <div class="table-responsive border" style="border-radius: 8px;">
                                <table class="table table-bordered table-hover text-center table-modern mb-0" id="tablaLotesActivos">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">Código de Lote</th>
                                            <th class="align-middle">Cant. Total</th>
                                            <th class="align-middle" style="min-width: 140px;">Disponibilidad</th>
                                            <th class="align-middle">Costo Unit.</th>
                                            <th class="align-middle">F. Producción</th>
                                            <th class="align-middle">F. Vencimiento</th>
                                            <th class="align-middle text-left">Proveedor</th>
                                            <th class="align-middle">Estado</th>
                                            <th class="align-middle">Trazabilidad</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyLotesActivos">
                                        <tr>
                                            <td colspan="10" class="text-center py-5 text-muted">
                                                <i class="fa fa-calendar-check-o fa-3x mb-3 text-muted d-block"></i>
                                                <p class="font-weight-bold mb-1" style="font-size: 15px;">Cargando lotes activos...</p>
                                                <small class="text-muted"><i class="fa fa-spin fa-spinner mr-1"></i> Consultando registros del sistema</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                                <div class="text-muted small" id="paginationInfoActivos">Mostrando 0 registros</div>
                                <ul class="pagination pagination-sm mb-0" id="paginationNavActivos"></ul>
                            </div>
                        </div>

                        {{-- Tab 2: Lotes Vencidos --}}
                        <div class="tab-pane fade" id="lotes-vencidos" role="tabpanel">
                            <div class="table-responsive border" style="border-radius: 8px;">
                                <table class="table table-bordered table-hover text-center table-modern mb-0" id="tablaLotesVencidos">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">Código de Lote</th>
                                            <th class="align-middle">Cant. Total</th>
                                            <th class="align-middle" style="min-width: 140px;">Disponibilidad</th>
                                            <th class="align-middle">Costo Unit.</th>
                                            <th class="align-middle">F. Producción</th>
                                            <th class="align-middle">F. Vencimiento</th>
                                            <th class="align-middle text-left">Proveedor</th>
                                            <th class="align-middle">Estado</th>
                                            <th class="align-middle">Trazabilidad</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyLotesVencidos">
                                        <tr>
                                            <td colspan="10" class="text-center py-5 text-muted">
                                                <i class="fa fa-exclamation-circle fa-3x mb-3 text-muted d-block"></i>
                                                <p class="font-weight-bold mb-1" style="font-size: 15px;">No hay lotes vencidos en el sistema</p>
                                                <small class="text-muted">Los lotes que superen su fecha de expiración aparecerán automáticamente aquí.</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                                <div class="text-muted small" id="paginationInfoVencidos">Mostrando 0 registros</div>
                                <ul class="pagination pagination-sm mb-0" id="paginationNavVencidos"></ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para Visualización de Series por Lote (Estilo Modernizado) --}}
<div class="modal fade" id="modalSeriesLote" tabindex="-1" role="dialog" aria-labelledby="modalSeriesLoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header text-white py-3" style="background: linear-gradient(135deg, #2641f8 0%, #1e3a8a 100%) !important;">
                <div class="d-flex align-items-center">
                    <span class="mr-2" style="font-size: 20px;"><i class="fa fa-barcode"></i></span>
                    <h5 class="modal-title font-weight-bold text-white mb-0" id="modalSeriesLoteLabel">
                        Trazabilidad de Series: Lote <span id="modalLoteCodigo" class="badge badge-light text-primary ml-1 font-weight-bold">--</span>
                    </h5>
                </div>
                <button type="button" class="close text-white opacity-100" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3 bg-light">
                <div class="card border-0 shadow-sm p-3 mb-3 bg-white" style="border-radius: 8px;">
                    <div class="row text-center">
                        <div class="col-md-4 col-sm-4 border-right">
                            <small class="text-muted text-uppercase font-weight-bold" style="font-size: 10px;">Código Producto (SKU)</small>
                            <h5 class="font-bold text-dark mb-0 mt-1" id="modalProductoSku">--</h5>
                        </div>
                        <div class="col-md-4 col-sm-4 border-right">
                            <small class="text-muted text-uppercase font-weight-bold" style="font-size: 10px;">Unidades Ingresadas</small>
                            <h5 class="font-bold text-primary mb-0 mt-1" id="modalLoteCantTotal">0</h5>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <small class="text-muted text-uppercase font-weight-bold" style="font-size: 10px;">Saldo Disponible</small>
                            <h5 class="font-bold text-success mb-0 mt-1" id="modalLoteCantDisp">0</h5>
                        </div>
                    </div>
                </div>

                <div class="table-responsive border bg-white" style="max-height: 380px; overflow-y: auto; border-radius: 8px;">
                    <table class="table table-bordered table-hover text-center table-modern mb-0" style="font-size: 12px;">
                        <thead class="sticky-top">
                            <tr>
                                <th style="width: 45px;">#</th>
                                <th>Número de Serie</th>
                                <th>Estado Físico</th>
                                <th>Ubicación</th>
                                <th>Calidad</th>
                                <th>F. Venta</th>
                                <th>Garantía</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyModalSeries">
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fa fa-spin fa-spinner fa-2x mb-2 d-block text-primary"></i> Cargando series...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer py-2 bg-white">
                <button type="button" class="btn btn-secondary font-weight-bold btn-sm" data-dismiss="modal" style="border-radius: 6px;">
                    <i class="fa fa-times mr-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * Módulo JavaScript Encapsulado: DetalleLoteModule
 * Maneja la interacción asíncrona, filtros, pestañas, barras de progreso y modal de series.
 */
const DetalleLoteModule = (function () {
    let currentTab = 'activos';
    let currentPage = 1;
    const ajaxEndpoint = '{{ route("lotes-garantias.ajax.detalle-lote") }}';
    const seriesEndpoint = '{{ route("lotes-garantias.ajax.series-por-lote") }}';
    const busquedaSerieBaseUrl = '{{ route("lotes-garantias.busqueda-serie") }}';

    function getQueryParams() {
        const params = new URLSearchParams(window.location.search);
        return {
            codigo_producto: params.get('codigo_producto') || '',
            almacen: params.get('almacen') || ''
        };
    }

    function cargarLotes(page = 1) {
        currentPage = page;
        const tbody = currentTab === 'vencidos' 
            ? document.getElementById('tbodyLotesVencidos') 
            : document.getElementById('tbodyLotesActivos');

        tbody.innerHTML = `
            <tr>
                <td colspan="10" class="text-center py-5 text-muted">
                    <i class="fa fa-spin fa-spinner fa-2x mb-2 text-primary d-block"></i>
                    <p class="font-weight-bold mb-0">Consultando lotes...</p>
                </td>
            </tr>`;

        const form = document.getElementById('formFiltroLotes');
        const formData = new FormData(form);
        formData.append('tab', currentTab);
        formData.append('page', currentPage);

        fetch(ajaxEndpoint, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Error HTTP ' + response.status);
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // 1. Actualizar barra de cabecera
                if (data.producto_info) {
                    document.getElementById('infoCodProducto').textContent = data.producto_info.codigo || '--';
                    document.getElementById('infoModelo').textContent = data.producto_info.modelo || data.producto_info.nombre || '--';
                    document.getElementById('infoAlmacen').textContent = data.producto_info.almacen || '--';
                }

                // 2. Actualizar tarjetas métricas
                if (data.metricas) {
                    document.getElementById('metricTotalLotes').textContent = data.metricas.total_lotes.toLocaleString();
                    document.getElementById('metricUnidadesDisponibles').textContent = data.metricas.unidades_disponibles.toLocaleString();
                    document.getElementById('metricLotesActivosCount').textContent = data.metricas.conteo_activos.toLocaleString();
                    document.getElementById('metricLotesVencidosCount').textContent = data.metricas.conteo_vencidos.toLocaleString();
                    
                    document.getElementById('badgeActivos').textContent = data.metricas.conteo_activos.toLocaleString();
                    document.getElementById('badgeVencidos').textContent = data.metricas.conteo_vencidos.toLocaleString();
                }

                // 3. Renderizar tabla según tab
                renderTabla(data.lotes, currentTab);

                // 4. Renderizar paginador
                renderPaginacion(data.paginacion, currentTab);
            }
        })
        .catch(err => {
            console.error('Error cargando detalle de lotes:', err);
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-4 text-danger">
                        <i class="fa fa-exclamation-triangle mr-1"></i> Error al cargar los lotes. Verifique su conexión o intente nuevamente.
                    </td>
                </tr>`;
        });
    }

    function renderTabla(lotes, tab) {
        const tbody = tab === 'vencidos' 
            ? document.getElementById('tbodyLotesVencidos') 
            : document.getElementById('tbodyLotesActivos');

        if (!lotes || lotes.length === 0) {
            const mensaje = tab === 'vencidos' 
                ? 'No hay lotes vencidos en el sistema' 
                : 'No se encontraron lotes activos para los criterios seleccionados';
            const submensaje = tab === 'vencidos'
                ? 'Los lotes que superen su fecha de expiración aparecerán automáticamente aquí.'
                : 'Ajuste los filtros o registre un ingreso en Kardex para este producto.';

            tbody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-5 text-muted">
                        <i class="fa ${tab === 'vencidos' ? 'fa-exclamation-circle' : 'fa-calendar-check-o'} fa-3x mb-3 text-muted d-block"></i>
                        <p class="font-weight-bold mb-1" style="font-size: 15px;">${mensaje}</p>
                        <small class="text-muted">${submensaje}</small>
                    </td>
                </tr>`;
            return;
        }

        tbody.innerHTML = lotes.map(lote => {
            // Badges suaves para el estado
            let estadoBadge = '<span class="badge badge-soft-secondary">Desconocido</span>';
            if (lote.es_vencido) {
                estadoBadge = '<span class="badge badge-soft-danger"><i class="fa fa-times-circle mr-1"></i>Vencido</span>';
            } else if (lote.estado === 'Completo') {
                estadoBadge = '<span class="badge badge-soft-success"><i class="fa fa-check-circle mr-1"></i>Completo</span>';
            } else if (lote.estado === 'En Proceso' || lote.estado === 'Proceso') {
                estadoBadge = '<span class="badge badge-soft-warning"><i class="fa fa-hourglass-half mr-1"></i>En Proceso</span>';
            } else if (lote.estado === 'Terminado') {
                estadoBadge = '<span class="badge badge-soft-secondary"><i class="fa fa-ban mr-1"></i>Terminado</span>';
            }

            // Barra de progreso de disponibilidad
            const porcentaje = lote.cantidad > 0 ? Math.min(100, Math.round((lote.cantidad_disponible / lote.cantidad) * 100)) : 0;
            let barraColor = '#10b981'; // verde
            if (porcentaje < 20) {
                barraColor = '#ef4444'; // rojo
            } else if (porcentaje < 50) {
                barraColor = '#f59e0b'; // ámbar
            }

            const serieBtn = lote.total_series > 0
                ? `<button type="button" class="btn btn-xs btn-primary font-weight-bold btn-ver-series shadow-sm" 
                           style="background-color: #2641f8; border-color: #2641f8; border-radius: 4px;" data-lote-id="${lote.id}">
                       <i class="fa fa-barcode mr-1"></i> ${lote.total_series} Series
                   </button>`
                : `<span class="badge badge-light border text-muted">Sin series</span>`;

            return `
                <tr>
                    <td><strong>#${lote.id}</strong></td>
                    <td class="font-weight-bold text-dark">
                        <code class="px-2 py-1 bg-light border rounded text-primary">${escapeHtml(lote.lote)}</code>
                    </td>
                    <td><span class="font-weight-bold">${lote.cantidad}</span></td>
                    <td class="text-left" style="min-width: 140px;">
                        <div class="d-flex justify-content-between font-weight-bold small">
                            <span class="${lote.cantidad_disponible > 0 ? 'text-primary' : 'text-danger'}">${lote.cantidad_disponible}</span>
                            <span class="text-muted">${porcentaje}%</span>
                        </div>
                        <div class="progress-bar-mini">
                            <div class="progress-bar-mini-fill" style="width: ${porcentaje}%; background-color: ${barraColor};"></div>
                        </div>
                    </td>
                    <td><strong>$ ${lote.costo_individual}</strong></td>
                    <td class="small text-muted">${lote.fecha_produccion}</td>
                    <td class="${lote.es_vencido ? 'text-danger font-weight-bold' : 'small text-muted'}">
                        ${lote.fecha_vencimiento}
                        ${lote.es_vencido ? '<small class="d-block text-danger font-weight-bold"><i class="fa fa-exclamation-triangle"></i> Expirado</small>' : ''}
                    </td>
                    <td class="text-left"><small class="font-weight-bold text-dark">${escapeHtml(lote.proveedor)}</small></td>
                    <td>${estadoBadge}</td>
                    <td>${serieBtn}</td>
                </tr>`;
        }).join('');

        // Vincular eventos a los botones de series
        tbody.querySelectorAll('.btn-ver-series').forEach(btn => {
            btn.addEventListener('click', function () {
                const loteId = this.getAttribute('data-lote-id');
                abrirModalSeries(loteId);
            });
        });
    }

    function renderPaginacion(pag, tab) {
        const info = tab === 'vencidos' ? document.getElementById('paginationInfoVencidos') : document.getElementById('paginationInfoActivos');
        const nav = tab === 'vencidos' ? document.getElementById('paginationNavVencidos') : document.getElementById('paginationNavActivos');

        if (!pag || pag.total === 0) {
            info.textContent = 'Mostrando 0 registros';
            nav.innerHTML = '';
            return;
        }

        const desde = ((pag.current_page - 1) * pag.per_page) + 1;
        const hasta = Math.min(pag.current_page * pag.per_page, pag.total);
        info.textContent = `Mostrando ${desde} a ${hasta} de ${pag.total.toLocaleString()} lotes`;

        let html = `
            <li class="page-item ${pag.current_page <= 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pag.current_page - 1}"><i class="fa fa-chevron-left"></i></a>
            </li>`;

        const start = Math.max(1, pag.current_page - 2);
        const end = Math.min(pag.last_page, start + 4);

        for (let i = start; i <= end; i++) {
            html += `
                <li class="page-item ${i === pag.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}" style="${i === pag.current_page ? 'background-color: #2641f8; border-color: #2641f8;' : ''}">${i}</a>
                </li>`;
        }

        html += `
            <li class="page-item ${pag.current_page >= pag.last_page ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pag.current_page + 1}"><i class="fa fa-chevron-right"></i></a>
            </li>`;

        nav.innerHTML = html;

        nav.querySelectorAll('a.page-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const targetPage = parseInt(this.getAttribute('data-page'));
                if (targetPage && targetPage >= 1 && targetPage <= pag.last_page && targetPage !== pag.current_page) {
                    cargarLotes(targetPage);
                }
            });
        });
    }

    function abrirModalSeries(loteId) {
        const tbodyModal = document.getElementById('tbodyModalSeries');
        tbodyModal.innerHTML = `
            <tr>
                <td colspan="8" class="text-center py-4 text-muted">
                    <i class="fa fa-spin fa-spinner fa-2x mb-2 d-block text-primary"></i> Cargando series del lote...
                </td>
            </tr>`;

        $('#modalSeriesLote').modal('show');

        fetch(seriesEndpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ lote_id: loteId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modalLoteCodigo').textContent = data.lote.codigo;
                document.getElementById('modalProductoSku').textContent = data.lote.codigo_producto;
                document.getElementById('modalLoteCantTotal').textContent = data.lote.cantidad;
                document.getElementById('modalLoteCantDisp').textContent = data.lote.cantidad_disponible;

                if (!data.series || data.series.length === 0) {
                    tbodyModal.innerHTML = `
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fa fa-info-circle mr-1"></i> Este lote no tiene números de serie individuales registrados.
                            </td>
                        </tr>`;
                    return;
                }

                tbodyModal.innerHTML = data.series.map((s, idx) => `
                    <tr>
                        <td><strong>${idx + 1}</strong></td>
                        <td class="font-weight-bold text-dark"><code class="text-primary font-weight-bold">${escapeHtml(s.numero_serie)}</code></td>
                        <td><span class="badge ${s.estado === 'En Stock' ? 'badge-soft-success' : 'badge-soft-secondary'}">${escapeHtml(s.estado)}</span></td>
                        <td>${escapeHtml(s.ubicacion)}</td>
                        <td><span class="badge badge-light border font-weight-bold">${escapeHtml(s.calidad)}</span></td>
                        <td class="small text-muted">${s.fecha_venta}</td>
                        <td class="small text-muted">${s.fecha_vencimiento_garantia}</td>
                        <td>
                            <a href="${busquedaSerieBaseUrl}?numero_serie=${encodeURIComponent(s.numero_serie)}" 
                               class="btn btn-xs btn-outline-primary font-weight-bold" target="_blank" title="Trazar en Búsqueda por Serie" style="border-radius: 4px;">
                                <i class="fa fa-search mr-1"></i> Trazar
                            </a>
                        </td>
                    </tr>
                `).join('');
            } else {
                tbodyModal.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-3 text-danger">
                            ${escapeHtml(data.message || 'Error al obtener series.')}
                        </td>
                    </tr>`;
            }
        })
        .catch(err => {
            console.error('Error modal series:', err);
            tbodyModal.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-3 text-danger">
                        <i class="fa fa-exclamation-triangle mr-1"></i> Error al conectar con el servidor.
                    </td>
                </tr>`;
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // Inicialización del módulo al cargar el DOM
    document.addEventListener('DOMContentLoaded', function () {
        const queryParams = getQueryParams();
        if (queryParams.codigo_producto) {
            document.getElementById('filtroCodigoProducto').value = queryParams.codigo_producto;
        }
        if (queryParams.almacen) {
            document.getElementById('filtroAlmacen').value = queryParams.almacen;
        }

        // Carga inicial
        cargarLotes(1);

        // Envío del formulario de filtros
        const form = document.getElementById('formFiltroLotes');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            cargarLotes(1);
        });

        // Cambio de pestañas (Activos vs Vencidos)
        $('#loteTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            const targetTab = $(e.target).data('tab');
            if (targetTab && targetTab !== currentTab) {
                currentTab = targetTab;
                cargarLotes(1);
            }
        });

        // Botón limpiar filtros
        document.getElementById('btnLimpiarFiltros').addEventListener('click', function () {
            form.reset();
            const qp = getQueryParams();
            document.getElementById('filtroCodigoProducto').value = qp.codigo_producto;
            document.getElementById('filtroAlmacen').value = qp.almacen;
            cargarLotes(1);
        });
    });

    return {
        recargar: () => cargarLotes(currentPage),
        cambiarTab: (t) => { currentTab = t; cargarLotes(1); }
    };
})();
</script>
@endsection
