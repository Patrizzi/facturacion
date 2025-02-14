<div class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{route('servicios.index')}}" id="tab-1">
            Servicios activos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{route('servicios.index2')}}" id="tab-2">
            Servicios inactivos
        </a>
    </li>
</div>
<li class="ml-auto">
    <div class="btn-group">
        <a class="btn btn-primary btn-sm" style="background-color:blue; border-color:blue;" href="{{ route('servicios.create') }}">
            <i class="fa fa-plus"></i>
        </a>
    </div>
</li>
<li>
    <div class="col-md-12 d-flex justify-content-md-start align-content-center row-cols-12">
        <div class="col-md-auto">
            <label for="inputBuscar" class="col-form-label">Buscar:</label>
        </div>
        <div class="col-md-10">
            <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
        </div>
    </div>
</li>
