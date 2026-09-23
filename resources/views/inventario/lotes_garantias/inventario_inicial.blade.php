@extends('layout')

@section('title', 'Inventario Inicial - Control de Lotes y Garantías')
@section('breadcrumb', 'Inventario')
@section('breadcrumb2', 'Inventario Inicial')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">

    {{-- Navegación secundaria entre los submódulos --}}
    @include('inventario.lotes_garantias.navbar_tabs')

    {{-- Panel de Métricas Superiores --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="ibox border-left border-primary shadow-sm mb-0">
                <div class="ibox-content text-center py-3">
                    <h5 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Productos Diferentes</h5>
                    <h2 class="no-margins font-bold text-primary" style="font-size: 32px;">0</h2>
                    <small class="text-muted"><i class="fa fa-tag mr-1"></i>Total únicos en sistema</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="ibox border-left border-info shadow-sm mb-0">
                <div class="ibox-content text-center py-3">
                    <h5 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Unidades Totales</h5>
                    <h2 class="no-margins font-bold text-info" style="font-size: 32px;">0</h2>
                    <small class="text-muted"><i class="fa fa-cubes mr-1"></i>Suma total de existencias</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="ibox border-left border-success shadow-sm mb-0">
                <div class="ibox-content text-center py-3">
                    <h5 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Valor Total Inventario</h5>
                    <h2 class="no-margins font-bold text-success" style="font-size: 32px;">$ 0.00</h2>
                    <small class="text-muted"><i class="fa fa-money mr-1"></i>Valoración calculada</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="ibox border-left border-warning shadow-sm mb-0">
                <div class="ibox-content text-center py-3">
                    <h5 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Productos con Stock Bajo</h5>
                    <h2 class="no-margins font-bold text-warning" style="font-size: 32px;">0</h2>
                    <small class="text-muted"><i class="fa fa-exclamation-triangle mr-1"></i>Debajo del stock mínimo</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros y Tabla Principal de Productos --}}
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title d-flex justify-content-between align-items-center">
                    <h5><i class="fa fa-list mr-2"></i>Inventario Inicial - Tabla de Productos</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    {{-- Barra de filtros --}}
                    <form class="mb-4" id="formFiltroInventario">
                        <div class="form-row align-items-end">
                            <div class="col-md-4 col-sm-12 mb-2">
                                <label class="font-weight-bold" style="font-size: 12px;">Texto a buscar:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="buscar" placeholder="Código, nombre o descripción...">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <label class="font-weight-bold" style="font-size: 12px;">Categoría:</label>
                                <select class="form-control" name="categoria">
                                    <option value="">Todas las categorías</option>
                                    @isset($categorias)
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nombre ?? $cat->descripcion }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <label class="font-weight-bold" style="font-size: 12px;">Almacén:</label>
                                <select class="form-control" name="almacen">
                                    <option value="">Todos los almacenes</option>
                                    @isset($almacenes)
                                        @foreach($almacenes as $alm)
                                            <option value="{{ $alm->id }}">{{ $alm->nombre }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-12 mb-2">
                                <button type="button" class="btn btn-primary btn-block" style="background-color: #2641f8; border-color: #2641f8;">
                                    <i class="fa fa-filter mr-1"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Tabla de Productos según Documentación --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center" style="font-size: 13px;">
                            <thead class="thead-light">
                                <tr>
                                    <th rowspan="2" class="align-middle text-uppercase" style="background: #eef2f7; color: #334155;">Código</th>
                                    <th rowspan="2" class="align-middle text-uppercase" style="background: #eef2f7; color: #334155; min-width: 180px;">Producto</th>
                                    <th rowspan="2" class="align-middle text-uppercase" style="background: #eef2f7; color: #334155;">Categoría</th>
                                    <th rowspan="2" class="align-middle text-uppercase" style="background: #eef2f7; color: #334155;">Stock</th>
                                    <th colspan="4" class="align-middle text-uppercase text-center" style="background: #2641f8; color: #ffffff;">Precios</th>
                                    <th rowspan="2" class="align-middle text-uppercase" style="background: #eef2f7; color: #334155;">Almacén</th>
                                    <th rowspan="2" class="align-middle text-uppercase" style="background: #eef2f7; color: #334155;">Valor Total</th>
                                    <th rowspan="2" class="align-middle text-uppercase" style="background: #eef2f7; color: #334155;">Acciones</th>
                                </tr>
                                <tr>
                                    <th class="align-middle text-uppercase" style="background: #f1f5f9; font-size: 11px;">Costo</th>
                                    <th class="align-middle text-uppercase" style="background: #f1f5f9; font-size: 11px;">Costo Promedio</th>
                                    <th class="align-middle text-uppercase" style="background: #f1f5f9; font-size: 11px;">Venta</th>
                                    <th class="align-middle text-uppercase" style="background: #f1f5f9; font-size: 11px;">Sugerido</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Empty state limpio conforme a requerimientos (sin datos estáticos falsos) --}}
                                <tr>
                                    <td colspan="11" class="text-center py-5 text-muted">
                                        <i class="fa fa-folder-open-o fa-3x mb-3 text-muted d-block"></i>
                                        <p class="font-weight-bold mb-1" style="font-size: 15px;">No hay productos registrados en el inventario inicial</p>
                                        <small class="text-muted">Utilice los filtros superiores para refinar la búsqueda o sincronice los productos del sistema.</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación y Resumen --}}
                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                        <small class="text-muted">Mostrando 0 a 0 de 0 registros</small>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-chevron-left"></i></a></li>
                                <li class="page-item active"><a class="page-link" href="#" style="background-color: #2641f8; border-color: #2641f8;">1</a></li>
                                <li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-chevron-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
