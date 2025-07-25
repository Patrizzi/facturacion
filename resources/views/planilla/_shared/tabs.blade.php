<div class="nav nav-custom">
    <li class="nav-item">
        <a class="nav-link" href="{{route('ventas.cotizacion')}}" id="tab-1-tab">
            <span class="badge badge-success" style="background-color :green;">{{$count_all_ventas['cotizacion_day_count']}}</span>
            Personal Activo
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  href="{{route('ventas.cotizacion_manual')}}" id="tab-2-tab">
            <span class="badge badge-success" style="background-color: orange;">{{$count_all_ventas['cotizacion_m_day_count']}}</span>
            Cotización Manual
        </a>
    </li>
</div>
