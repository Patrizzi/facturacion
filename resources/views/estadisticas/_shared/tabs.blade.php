<div class="nav" id="tablas">
    <li class="nav-item" >
        <a class="nav-link" href="{{route('estadisticas.index')}}" id="tab-1-tab">
            <span class="badge badge-success" style="background-color :green "></span>
            Ventas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('estadisticas.servicios')}}" id="tab-2-tab">
            <span class="badge badge-success" style="background-color: orange;"></span>
            Servicios
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('estadisticas.clientes')}}" id="tab-3-tab">
            <span class="badge badge-success" style="background-color: red;"></span> Clientes
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('estadisticas.empleados')}}" id="tab-4-tab">
            <span class="badge badge-success" style="background-color: blue;"></span> Empleados
        </a>
    </li>
</div>

<style>
    .nav-item {
        transition: background-color 0.3s ease; /* Suaviza la transición */
        
    }

    .nav-item:hover {
        background-color: #1d34c6; /* Azul más oscuro para el hover */
        border-radius: 10px 10px 0 0;
    }
    #tablas {
    background-color: #2641f8;    
    border-radius: 10px 10px 0 0; /* Solo redondea las esquinas superiores */
    overflow: hidden;
    }
</style>