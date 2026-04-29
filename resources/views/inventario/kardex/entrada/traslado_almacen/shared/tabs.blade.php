<div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
    @can('kardex_traslado.listar')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kardex-entrada-Distribucion.index') }}" id="tab-1">
                <span class="badge badge-success" style="background-color : var(--primary);">0</span>
                Traslados
            </a>
        </li>
    @endcan
</div>