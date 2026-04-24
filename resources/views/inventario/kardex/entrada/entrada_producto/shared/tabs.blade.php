<div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
    @can('kardex_entrada.crear')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('comprobantes.index_boleta') }}" id="tab-1-tab">
                <span class="badge badge-success"
                    style="background-color : var(--primary);">0</span>
                Kardex Entrada
            </a>
        </li>
    @endcan
</div>