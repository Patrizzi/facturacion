<div class="nav nav-custom">
    @can('vendedores.listar')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('vendedores.index') }}" id="tab-1-tab">
                <span class="badge badge-success" style="background-color :green;">0 </span>
                Personal
            </a>
        </li>
    @endcan
</div>
