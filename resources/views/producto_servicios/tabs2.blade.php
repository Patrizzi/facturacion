<div class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('productos.index') }}" id="tab-1-tab" class="tab-pane active show">
            <span style="color: white; background-color: blue;" class="px-1">2</span>
            Activos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{ route('productos.index2') }}" id="tab-2-tab">
            <span style="color: white; background-color: #949494;" class="px-1">6</span>
            Inactivos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{ route('productos.index3') }}" id="tab-3-tab">
            <span style="color: white; background-color: #dadada;" class="px-1">4</span>
            Anulados
        </a>
    </li>
</div>
<li class="ml-auto">
    <div class="btn-group">
        <a class="btn btn-primary btn-sm" style="background-color:blue; border-color:blue;" href="{{ route('productos.create') }}">
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
