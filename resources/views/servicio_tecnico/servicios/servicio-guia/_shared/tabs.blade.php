{{-- Archivo: servicio_tecnico/servicios/servicio-guia/_shared/tabs.blade.php --}}
<li class="nav-item custom">
    <a class="nav-link" href="{{ route('servicio-guias.index') }}">
       Servicios
    </a>
</li>
<li class="nav-item custom">
    <a class="nav-link active" data-toggle="tab" href="#tab-ingresos" id="tab-ingresos-link" role="tab">
        <span style="color: white; background-color: var(--primary);font-size: 90%" class="px-1">
            {{ $servIngresoEquipos->count() }}
        </span>
        Ingresos
    </a>
</li>
<li class="nav-item custom">
    <a class="nav-link" data-toggle="tab" href="#tab-egresos" id="tab-egresos-link" role="tab">
        <span style="color: white; background-color: var(--primary);font-size: 90%" class="px-1">
            {{ $servEgresosEquipos->count() }}
        </span>
        Egresos
    </a>
</li>
<li class="nav-item custom">
    <a class="nav-link" data-toggle="tab" href="#tab-informe" id="tab-informe-link" role="tab">
        <span style="color: white; background-color: var(--primary);font-size: 90%" class="px-1">
            0
        </span>
        Informe Técnico
    </a>
</li>
