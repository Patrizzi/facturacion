<div class="nav nav-custom">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('personal.index') }}" id="tab-1-tab">
            <span class="badge badge-success" style="background-color :green;">0 </span>
            Activos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('personal.index_inactivo') }}" id="tab-2-tab">
            <span class="badge badge-success" style="background-color: orange;"> 0</span>
            Inactivos
        </a>
    </li>
</div>
<ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
    {{-- <button class="btn btn-success" type="button">
        <i class="fa fa-plus"></i>
    </button> --}}
    <a href="{{route('personal.create')}}" class="btn btn-success">
        <i class="fa fa-plus"></i>
    </a>
</ul>
