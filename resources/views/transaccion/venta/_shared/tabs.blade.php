<div class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{route('cotizacion.index3')}}" id="tab-1-tab">
            <span class="badge badge-success" style="background-color :green;">{{$count_all_ventas['cotizacion_day_count']}}</span>
            Cotización
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{route('cotizacion_manual.index2')}}" id="tab-2-tab">
            <span class="badge badge-success" style="background-color: orange;">{{$count_all_ventas['cotizacion_m_day_count']}}</span>
            Cotización Manual
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-3" id="tab-3-tab">
            <span class="badge badge-success" style="background-color: red;">{{$count_all_ventas['nota_venta_day_count']}}</span> Nota de
            Venta
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#tab-4">
            <span class="badge badge-success" style="background-color: blue;">5</span> Clientes
        </a>
    </li>
</div>
