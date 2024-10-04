@if ($menuItem->hasAccess())
<li>
    <a href="{{ $menuItem->url }}"
        @if ($menuItem->url == route('logout'))
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        @endif>
        
        @if ($menuItem->icon)
            <img src="{{ $menuItem->icon }}" class="iconos">
        @endif
        
        <span class="nav-label">{!! $menuItem->text !!}</span> 

        @if ($menuItem->notifications > 0)
            &nbsp;&nbsp;&nbsp;
            <span class="label label-warning">{{ $menuItem->notifications }}</span>
        @endif

        @if ($menuItem->url == route('logout'))
            <form id="logout-form" action="{{ $menuItem->url }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endif
    </a>

    @if ($menuItem->subMenus)
        <ul class="nav nav-second-level collapse" id="side-menu">
            @foreach ($menuItem->subMenus as $subMenu)
                <li>
                    <a href="{{ $subMenu->url }}">
                        @if ($subMenu->icon)
                            <img src="{{ $subMenu->icon }}" class="iconos">
                        @endif
                        <span class="nav-label">{{ $subMenu->text }}</span>
                    </a>

                    @if ($subMenu->subMenus)
                        <ul class="nav nav-third-level collapse">
                            @foreach ($subMenu->subMenus as $thirdLevelMenu)
                                <li>
                                    <a href="{{ $thirdLevelMenu->url }}">
                                        @if ($thirdLevelMenu->icon)
                                            <img src="{{ $thirdLevelMenu->icon }}" class="iconos">
                                        @endif
                                        <span class="nav-label">{{ $thirdLevelMenu->text }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</li>
@endif
