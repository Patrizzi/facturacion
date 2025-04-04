<div class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('servicios.index') }}" id="tab-1">
            {{-- <span style="color: white; background-color: blue;" class="px-1">{{$s_statics['cantidad_hoy_creados']}}</span> --}}
            Servicios activos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('servicios.index2') }}" id="tab-2">
            {{-- <span style="color: white; background-color: #949494;" class="px-1">{{$s_statics['cantidad_hoy_anulados']}}</span> --}}
            Servicios Anulados
        </a>
    </li>
</div>
<li class="ml-auto">
    <div class="btn-group">
        <a class="btn btn-primary btn-sm" 
            href="{{ route('servicios.create') }}">
            <i class="fa fa-plus"></i>
        </a>
    </div>
</li>
