<div class="row mb-3">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-pills" style="background: #fff; padding: 10px 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); display: flex; flex-wrap: wrap; gap: 8px;">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lotes-garantias.inventario-inicial') || request()->routeIs('lotes-garantias.index') ? 'active' : '' }}" 
                       href="{{ route('lotes-garantias.inventario-inicial') }}" 
                       style="{{ request()->routeIs('lotes-garantias.inventario-inicial') || request()->routeIs('lotes-garantias.index') ? 'background-color: #2641f8; color: #fff; font-weight: 600;' : 'color: #495057; font-weight: 500;' }}">
                        <i class="fa fa-cubes mr-1"></i> 1. Inventario Inicial
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lotes-garantias.detalle-lote') ? 'active' : '' }}" 
                       href="{{ route('lotes-garantias.detalle-lote') }}" 
                       style="{{ request()->routeIs('lotes-garantias.detalle-lote') ? 'background-color: #2641f8; color: #fff; font-weight: 600;' : 'color: #495057; font-weight: 500;' }}">
                        <i class="fa fa-th-list mr-1"></i> 2. Detalle de Lote
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lotes-garantias.busqueda-serie') ? 'active' : '' }}" 
                       href="{{ route('lotes-garantias.busqueda-serie') }}" 
                       style="{{ request()->routeIs('lotes-garantias.busqueda-serie') ? 'background-color: #2641f8; color: #fff; font-weight: 600;' : 'color: #495057; font-weight: 500;' }}">
                        <i class="fa fa-barcode mr-1"></i> 3. Búsqueda por Serie
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lotes-garantias.garantia-producto') ? 'active' : '' }}" 
                       href="{{ route('lotes-garantias.garantia-producto') }}" 
                       style="{{ request()->routeIs('lotes-garantias.garantia-producto') ? 'background-color: #2641f8; color: #fff; font-weight: 600;' : 'color: #495057; font-weight: 500;' }}">
                        <i class="fa fa-shield mr-1"></i> 4. Garantía de Producto
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lotes-garantias.garantia-cliente') ? 'active' : '' }}" 
                       href="{{ route('lotes-garantias.garantia-cliente') }}" 
                       style="{{ request()->routeIs('lotes-garantias.garantia-cliente') ? 'background-color: #2641f8; color: #fff; font-weight: 600;' : 'color: #495057; font-weight: 500;' }}">
                        <i class="fa fa-user-circle mr-1"></i> 5. Garantía de Cliente
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
