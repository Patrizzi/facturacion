<div class="nav nav-custom" style="min-width: 1450px;overflow-y: hidden;overflow-x: auto;">
    @can('productos.ver')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('productos.index') }}" id="tab-1-tab">
                <span class="badge badge-success"
                    style="background-color : var(--primary);">0</span>
                Productos
            </a>
        </li>
    @endcan
</div>
