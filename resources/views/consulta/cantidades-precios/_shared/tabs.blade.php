<div class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{route('cantidad_precio.index')}}" id="tab-1-tab">
            <span class="badge badge-success" style="background-color: red;">7</span> Productos
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{route('cantidad_precio.index_servicio')}}" id="tab-2-tab">
            <span class="badge badge-success" style="background-color: orange;">2</span> Servicios
        </a>
    </li>
    <!--
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-4">
            <span class="badge badge-success" style="background-color: blue;">5</span> Garantias
        </a>
    </li>-->
</div>
<style>
    .nav-tabs .nav-link{
        color: #676a6c;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
        color: #495057;
    }
    /* #tab-1-tab, {
        color: #676a6c !important;
    } */
</style>