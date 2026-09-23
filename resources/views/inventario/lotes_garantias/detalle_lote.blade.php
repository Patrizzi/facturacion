@extends('layout')

@section('title', 'Detalle de Lote - Control de Lotes y Garantías')
@section('breadcrumb', 'Inventario')
@section('breadcrumb2', 'Detalle de Lote')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">

    {{-- Navegación secundaria entre los submódulos --}}
    @include('inventario.lotes_garantias.navbar_tabs')

    {{-- Barra Superior de Información y Acciones Rápidas (Página 3 PDF) --}}
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="ibox mb-0">
                <div class="ibox-content py-3" style="background: #ffffff; border-radius: 4px;">
                    <div class="row align-items-center">
                        <div class="col-md-7 col-sm-12 mb-2 mb-md-0">
                            <h4 class="font-bold text-dark mb-1" style="font-size: 18px;">
                                <i class="fa fa-cubes text-primary mr-2"></i>Detalle de Lote de Producto
                            </h4>
                            <div class="d-flex flex-wrap text-muted" style="font-size: 13px; gap: 20px;">
                                <span><strong>Cód. Producto:</strong> <span class="badge badge-light p-1 px-2 border" id="infoCodProducto">--</span></span>
                                <span><strong>Modelo:</strong> <span class="badge badge-light p-1 px-2 border" id="infoModelo">--</span></span>
                                <span><strong>Almacén:</strong> <span class="badge badge-light p-1 px-2 border" id="infoAlmacen">--</span></span>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12 text-md-right text-left">
                            <a href="{{ route('lotes-garantias.garantia-cliente') }}" class="btn btn-primary font-weight-bold" style="background-color: #2641f8; border-color: #2641f8;">
                                <i class="fa fa-user-circle mr-1"></i> Consulta Garantía de Cliente
                            </a>
                            <a href="{{ route('lotes-garantias.garantia-producto') }}" class="btn btn-outline-secondary font-weight-bold ml-1">
                                <i class="fa fa-shield mr-1"></i> Garantía Producto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel de Métricas (2 Cuadros Principales) --}}
    <div class="row mb-3 justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-6 mb-2">
            <div class="ibox border-left border-primary shadow-sm mb-0">
                <div class="ibox-content text-center py-3">
                    <h5 class="text-muted text-uppercase mb-1 font-weight-bold" style="font-size: 12px;">Total Lotes</h5>
                    <h2 class="no-margins font-bold text-primary" style="font-size: 34px;">0</h2>
                    <small class="text-muted"><i class="fa fa-calculator mr-1"></i>Lotes registrados para el producto</small>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 mb-2">
            <div class="ibox border-left border-info shadow-sm mb-0">
                <div class="ibox-content text-center py-3">
                    <h5 class="text-muted text-uppercase mb-1 font-weight-bold" style="font-size: 12px;">Unidades Disponibles</h5>
                    <h2 class="no-margins font-bold text-info" style="font-size: 34px;">0</h2>
                    <small class="text-muted"><i class="fa fa-check-circle mr-1"></i>Stock disponible para venta inmediata</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Pestañas de Navegación: Lotes Activos vs Lotes Vencidos (Página 3-4 PDF) --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <ul class="nav nav-tabs card-header-tabs" id="loteTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active font-weight-bold" id="lotes-activos-tab" data-toggle="tab" href="#lotes-activos" role="tab">
                                <i class="fa fa-check-circle text-success mr-1"></i> Lotes Activos <span class="badge badge-primary ml-1" style="background-color: #2641f8;">0</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="lotes-vencidos-tab" data-toggle="tab" href="#lotes-vencidos" role="tab">
                                <i class="fa fa-clock-o text-danger mr-1"></i> Lotes Vencidos <span class="badge badge-danger ml-1">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="ibox-content">

                    {{-- Panel de Filtros de Búsqueda (Página 4 PDF) --}}
                    <div class="card bg-light border-0 mb-4 p-3" style="border-radius: 6px;">
                        <h6 class="font-weight-bold text-dark mb-3"><i class="fa fa-sliders mr-2"></i>Filtros de Búsqueda de Lotes</h6>
                        <form id="formFiltroLotes">
                            <div class="form-row">
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold" style="font-size: 12px;">Fecha Desde:</label>
                                    <input type="date" class="form-control" name="fecha_desde">
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold" style="font-size: 12px;">Fecha Hasta:</label>
                                    <input type="date" class="form-control" name="fecha_hasta">
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold" style="font-size: 12px;">Texto a buscar:</label>
                                    <input type="text" class="form-control" name="texto_buscar" placeholder="Lote, serie o proveedor...">
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold" style="font-size: 12px;">Estado:</label>
                                    <select class="form-control" name="estado">
                                        <option value="">Todos los estados</option>
                                        <option value="Terminado">Terminado</option>
                                        <option value="Proceso">En Proceso</option>
                                        <option value="Completo">Completo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mt-2 align-items-end">
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <label class="font-weight-bold" style="font-size: 12px;">Proveedor:</label>
                                    <select class="form-control" name="proveedor">
                                        <option value="">Todos los proveedores</option>
                                        @isset($proveedores)
                                            @foreach($proveedores as $prov)
                                                <option value="{{ $prov->id }}">{{ $prov->empresa ?? $prov->nombre }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold" style="font-size: 12px;">Cantidad (Mín - Máx):</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="cant_min" placeholder="Mín">
                                        <div class="input-group-prepend input-group-append"><span class="input-group-text">-</span></div>
                                        <input type="number" class="form-control" name="cant_max" placeholder="Máx">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label class="font-weight-bold" style="font-size: 12px;">Cant. Disponible (Mín - Máx):</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="disp_min" placeholder="Mín">
                                        <div class="input-group-prepend input-group-append"><span class="input-group-text">-</span></div>
                                        <input type="number" class="form-control" name="disp_max" placeholder="Máx">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12 mb-2 d-flex">
                                    <button type="button" class="btn btn-primary btn-block mr-1" style="background-color: #2641f8; border-color: #2641f8;">
                                        <i class="fa fa-filter"></i> Filtrar
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary" title="Limpiar filtros">
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover text-center" style="font-size: 13px;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">Lote</th>
                                            <th class="align-middle">Cantidad</th>
                                            <th class="align-middle">Cant. Disponible</th>
                                            <th class="align-middle">Costo Individual</th>
                                            <th class="align-middle">Fecha Producción</th>
                                            <th class="align-middle">Fecha Vencimiento</th>
                                            <th class="align-middle">Proveedor</th>
                                            <th class="align-middle">Estado</th>
                                            <th class="align-middle">Serie</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Empty state limpio conforme a requerimientos (sin datos estáticos falsos) --}}
                                        <tr>
                                            <td colspan="10" class="text-center py-5 text-muted">
                                                <i class="fa fa-calendar-check-o fa-3x mb-3 text-muted d-block"></i>
                                                <p class="font-weight-bold mb-1" style="font-size: 15px;">No se encontraron lotes activos</p>
                                                <small class="text-muted">Ajuste los filtros o registre lotes para este producto.</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Tab 2: Lotes Vencidos --}}
                        <div class="tab-pane fade" id="lotes-vencidos" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover text-center" style="font-size: 13px;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="align-middle">ID</th>
                                            <th class="align-middle">Lote</th>
                                            <th class="align-middle">Cantidad</th>
                                            <th class="align-middle">Cant. Disponible</th>
                                            <th class="align-middle">Costo Individual</th>
                                            <th class="align-middle">Fecha Producción</th>
                                            <th class="align-middle">Fecha Vencimiento</th>
                                            <th class="align-middle">Proveedor</th>
                                            <th class="align-middle">Estado</th>
                                            <th class="align-middle">Serie</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="10" class="text-center py-5 text-muted">
                                                <i class="fa fa-exclamation-circle fa-3x mb-3 text-muted d-block"></i>
                                                <p class="font-weight-bold mb-1" style="font-size: 15px;">No hay lotes vencidos en el sistema</p>
                                                <small class="text-muted">Los lotes que superen su fecha de vencimiento aparecerán automáticamente aquí.</small>
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
    </div>
</div>
@endsection
