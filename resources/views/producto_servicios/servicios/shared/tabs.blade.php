<div class="nav nav-custom">
    @can('servicios.listar')
        <li class="nav-item">
            <a class="nav-link " href="{{ route('servicios.index') }}" id="tab-1">
                {{-- <span class="badge badge-success" style="background-color : var(--primary);">0</span> --}}
                <span style="color: white; background-color: var(--primary);font-size: 90%" class="px-1">0</span>
                Servicios
            </a>
        </li>
    @endcan
</div>
{{-- <li class="nav-item">
    <a class="nav-link" href="{{ route('servicios.index2') }}" id="tab-2">
        <span style="color: white; background-color: var(--primary);font-size: 90%" class="px-1">{{$s_statics['cantidad_hoy_anulados']}}</span>
        Servicios Anulados
    </a>
</li> --}}
{{-- <li class="ml-auto">
    <div class="btn-group">
        <a class="btn btn-primary btn-sm" href="{{ route('servicios.create') }}">
            <i class="fa fa-plus"></i>
        </a>
    </div>
</li> --}}