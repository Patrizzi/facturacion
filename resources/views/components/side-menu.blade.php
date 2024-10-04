<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <x-user-profile />
            @foreach ($menuItems as $item)
                <x-menu-item :menuItem="$item" />
            @endforeach
            <li>
                <a style="display: flex;">
                    <img src="{{ asset('/archivos/imagenes/layout/logout.png') }}" class="iconos" style="height: 20px; align-self: center;">
                    <span class="nav-label">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <input type="submit" value="Cerrar Sesión" style="font-weight: 600;color: #a7b1c2; border: none; background: transparent">
                        </form>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</nav>