<li>
    <a href="{{ $menuItem->url }}">
        @if ($menuItem->icon)
            <img src="{{ $menuItem->icon }}" class="iconos">
        @endif
        <span class="nav-label">{{ $menuItem->text }}</span>
    </a>

    @if ($menuItem->subMenus)
        @foreach ($menuItem->subMenus as $subMenu)
            <ul class="nav nav-second-level collapse" id="side-menu">
                <x-menu-item :menuItem="$subMenu" />
            </ul>
        @endforeach
    @endif
</li>
