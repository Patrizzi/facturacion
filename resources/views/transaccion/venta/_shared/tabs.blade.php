<div class="nav nav-custom" style="min-width: 720px;overflow-y: hidden;overflow-x: auto;">
    <li class="nav-item">
        <a class="nav-link" href="{{route('ventas.cotizacion')}}" id="tab-1-tab">
            <span class="badge badge-success" style="background-color :green;">{{$count_all_ventas['cotizacion_day_count']}}</span>
            Cotización
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{route('ventas.cotizacion_manual')}}" id="tab-2-tab">
            <span class="badge badge-success" style="background-color: orange;">{{$count_all_ventas['cotizacion_m_day_count']}}</span>
            Cotización Manual
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"href="{{route('ventas.nota_venta')}}" id="tab-3-tab">
            <span class="badge badge-success" style="background-color: red;">{{$count_all_ventas['nota_venta_day_count']}}</span> Nota de
            Venta
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('ventas.clientes')}}"  id="tab-4-tab">
            <span class="badge badge-success" style="background-color: blue;">{{$count_all_ventas['cliente_day_count']}}</span> Clientes
        </a>
    </li>
</div>
