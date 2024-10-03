<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <x-user-profile />
            @foreach ($menuItems as $item)
                <x-menu-item :menuItem="$item" />
            @endforeach
        </ul>
    </div>
</nav>