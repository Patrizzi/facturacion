<div class="nav nav-custom">
    @can('personal.listar')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('personal.index') }}" id="tab-1-tab">
                <span class="badge badge-success" style="background-color :green;">0 </span>
                Personal
            </a>
        </li>
    @endcan
    {{-- @can('personal.listar')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('personal.index_inactivo') }}" id="tab-2-tab">
                <span class="badge badge-success" style="background-color: orange;"> 0</span>
                Inactivos
            </a>
        </li>
    @endcan --}}
</div>
