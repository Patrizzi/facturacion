<div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
    @can('kardex_distribucion.listar')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kardex-entrada-Distribucion.index') }}" id="tab-1">
                <span style="color: white; background-color: var(--primary);font-size: 90%" class="px-1">0</span>
                Distribuciones
            </a>
        </li>
    @endcan
</div>
