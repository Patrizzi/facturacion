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
                    <h2 class="no-margins font-bold text-primary" id="metricProductosDiferentes" style="font-size: 32px;">0</h2>
                    <small class="text-muted"><i class="fa fa-tag mr-1"></i>Total únicos en sistema</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="ibox border-left border-info shadow-sm mb-0">
                <div class="ibox-content text-center py-3">
                    <h5 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Unidades Totales</h5>
                    <h2 class="no-margins font-bold text-info" id="metricUnidadesTotales" style="font-size: 32px;">0</h2>
                    <small class="text-muted"><i class="fa fa-cubes mr-1"></i>Suma total de existencias</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="ibox border-left border-success shadow-sm mb-0">
                <div class="ibox-content text-center py-3">
                    <h5 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Valor Total Inventario</h5>
                    <h2 class="no-margins font-bold text-success" id="metricValorTotal" style="font-size: 32px;">$ 0.00</h2>
                    <small class="text-muted"><i class="fa fa-money mr-1"></i>Valoración calculada</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="ibox border-left border-warning shadow-sm mb-0">
                <div class="ibox-content text-center py-3">
                    <h5 class="text-muted text-uppercase mb-2 font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Productos con Stock Bajo</h5>
                    <h2 class="no-margins font-bold text-warning" id="metricStockBajo" style="font-size: 32px;">0</h2>
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
                                    <input type="text" class="form-control" name="buscar" id="inputBuscar" placeholder="Código, nombre o descripción...">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <label class="font-weight-bold" style="font-size: 12px;">Categoría:</label>
                                <select class="form-control" name="categoria" id="selectCategoria">
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
                                <select class="form-control" name="almacen" id="selectAlmacen">
                                    <option value="">Todos los almacenes</option>
                                    @isset($almacenes)
                                        @foreach($almacenes as $alm)
                                            <option value="{{ $alm->id }}">{{ $alm->nombre }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-12 mb-2 d-flex">
                                <button type="submit" class="btn btn-primary btn-block mr-1" id="btnFiltrar" style="background-color: #2641f8; border-color: #2641f8;">
                                    <i class="fa fa-filter mr-1"></i> Filtrar
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="btnLimpiarFiltros" title="Limpiar filtros">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Tabla de Productos según Documentación --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center" id="tablaProductos" style="font-size: 13px;">
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
                                {{-- Empty state limpio por defecto --}}
                                <tr id="rowLoading">
                                    <td colspan="11" class="text-center py-5 text-muted">
                                        <i class="fa fa-spinner fa-spin fa-2x mb-2 d-block text-primary"></i>
                                        Cargando inventario...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación y Resumen --}}
                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                        <small class="text-muted" id="paginationInfo">Mostrando 0 a 0 de 0 registros</small>
                        <nav>
                            <ul class="pagination pagination-sm mb-0" id="paginationNav">
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

<script>
/**
 * Módulo JavaScript Encapsulado: InventarioInicialModule
 * Asignado a: DEV 3 (Sección 1: Inventario Inicial)
 * Directiva: INSTRUCCIONES_AGENTES_IA.md
 */
const InventarioInicialModule = (function () {
    let currentPage = 1;

    function cargarInventario(page = 1) {
        currentPage = page;
        const form = document.getElementById('formFiltroInventario');
        const formData = new FormData(form);
        formData.append('page', currentPage);
        formData.append('_token', '{{ csrf_token() }}');

        const tbody = document.querySelector('#tablaProductos tbody');
        tbody.innerHTML = `
            <tr>
                <td colspan="11" class="text-center py-4 text-muted">
                    <i class="fa fa-spinner fa-spin mr-1 text-primary"></i> Consultando registros...
                </td>
            </tr>`;

        fetch('{{ route("lotes-garantias.ajax.inventario-inicial") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            if (!res.ok) throw new Error('Error en la respuesta del servidor: ' + res.status);
            return res.json();
        })
        .then(data => {
            if (data.success) {
                // 1. Actualizar métricas superiores
                if (data.metricas) {
                    document.getElementById('metricProductosDiferentes').textContent = data.metricas.productos_diferentes.toLocaleString();
                    document.getElementById('metricUnidadesTotales').textContent = data.metricas.unidades_totales.toLocaleString();
                    document.getElementById('metricValorTotal').textContent = data.metricas.valor_total_inventario;
                    document.getElementById('metricStockBajo').textContent = data.metricas.stock_bajo.toLocaleString();
                }

                // 2. Renderizar filas de la tabla
                renderTabla(data.productos);

                // 3. Renderizar controles de paginación
                renderPaginacion(data.paginacion);
            }
        })
        .catch(err => {
            console.error('Error cargando inventario:', err);
            tbody.innerHTML = `
                <tr>
                    <td colspan="11" class="text-center py-4 text-danger">
                        <i class="fa fa-exclamation-triangle mr-1"></i> No se pudo cargar el inventario. Verifique su conexión o intente nuevamente.
                    </td>
                </tr>`;
        });
    }

    function renderTabla(productos) {
        const tbody = document.querySelector('#tablaProductos tbody');

        if (!productos || productos.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="11" class="text-center py-5 text-muted">
                        <i class="fa fa-folder-open-o fa-3x mb-3 text-muted d-block"></i>
                        <p class="font-weight-bold mb-1" style="font-size: 15px;">No se encontraron productos en el inventario</p>
                        <small class="text-muted">Ajuste los filtros superiores o limpie los criterios de búsqueda.</small>
                    </td>
                </tr>`;
            return;
        }

        const detalleLoteUrlBase = '{{ route("lotes-garantias.detalle-lote") }}';

        tbody.innerHTML = productos.map(p => `
            <tr>
                <td class="font-weight-bold"><code>${escapeHtml(p.codigo)}</code></td>
                <td class="text-left font-weight-bold text-dark">${escapeHtml(p.producto)}</td>
                <td><span class="badge badge-light border">${escapeHtml(p.categoria)}</span></td>
                <td>
                    <span class="badge ${p.stock > 0 ? 'badge-primary' : 'badge-danger'}" style="${p.stock > 0 ? 'background-color: #2641f8;' : ''}">
                        ${p.stock}
                    </span>
                </td>
                <td>$ ${p.costo}</td>
                <td>$ ${p.costo_promedio}</td>
                <td class="font-weight-bold text-success">$ ${p.precio_venta}</td>
                <td class="text-muted">$ ${p.precio_sugerido}</td>
                <td><small class="text-muted">${escapeHtml(p.almacen)}</small></td>
                <td class="font-weight-bold">$ ${p.valor_total}</td>
                <td>
                    <a href="${detalleLoteUrlBase}?codigo_producto=${encodeURIComponent(p.codigo)}" 
                       class="btn btn-xs btn-primary font-weight-bold" 
                       style="background-color: #2641f8; border-color: #2641f8;" title="Ver Detalle de Lote">
                        <i class="fa fa-cubes mr-1"></i> Lotes
                    </a>
                </td>
            </tr>
        `).join('');
    }

    function renderPaginacion(pag) {
        const info = document.getElementById('paginationInfo');
        const nav = document.getElementById('paginationNav');

        if (!pag || pag.total === 0) {
            info.textContent = 'Mostrando 0 a 0 de 0 registros';
            nav.innerHTML = '';
            return;
        }

        const desde = ((pag.current_page - 1) * pag.per_page) + 1;
        const hasta = Math.min(pag.current_page * pag.per_page, pag.total);
        info.textContent = `Mostrando ${desde} a ${hasta} de ${pag.total.toLocaleString()} registros`;

        let html = '';

        // Botón Anterior
        html += `
            <li class="page-item ${pag.current_page <= 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pag.current_page - 1}"><i class="fa fa-chevron-left"></i></a>
            </li>`;

        // Rango de páginas (máximo 5 botones)
        const start = Math.max(1, pag.current_page - 2);
        const end = Math.min(pag.last_page, start + 4);

        for (let i = start; i <= end; i++) {
            html += `
                <li class="page-item ${i === pag.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}" style="${i === pag.current_page ? 'background-color: #2641f8; border-color: #2641f8;' : ''}">${i}</a>
                </li>`;
        }

        // Botón Siguiente
        html += `
            <li class="page-item ${pag.current_page >= pag.last_page ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${pag.current_page + 1}"><i class="fa fa-chevron-right"></i></a>
            </li>`;

        nav.innerHTML = html;

        // Asignar listeners a enlaces de paginación
        nav.querySelectorAll('a.page-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const pageTarget = parseInt(this.getAttribute('data-page'));
                if (pageTarget && pageTarget >= 1 && pageTarget <= pag.last_page && pageTarget !== pag.current_page) {
                    cargarInventario(pageTarget);
                }
            });
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // Inicialización al cargar el DOM
    document.addEventListener('DOMContentLoaded', function () {
        cargarInventario(1);

        const form = document.getElementById('formFiltroInventario');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            cargarInventario(1);
        });

        // Disparar búsqueda al cambiar selectores
        document.getElementById('selectCategoria').addEventListener('change', () => cargarInventario(1));
        document.getElementById('selectAlmacen').addEventListener('change', () => cargarInventario(1));

        // Botón Limpiar
        document.getElementById('btnLimpiarFiltros').addEventListener('click', function () {
            form.reset();
            cargarInventario(1);
        });
    });

    return {
        recargar: () => cargarInventario(currentPage),
        irAPagina: (p) => cargarInventario(p)
    };
})();
</script>
@endsection
