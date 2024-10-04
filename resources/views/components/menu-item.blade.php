@if ($menuItem->hasAccess())
<li>
    <a href="{{ $menuItem->url }}">
        
        @if ($menuItem->icon)
            <img src="{{ $menuItem->icon }}" class="iconos">
        @endif
        
        <span class="nav-label">{!! $menuItem->text !!}</span> 

        @if ($menuItem->notifications > 0)
            &nbsp;
            <span class="label label-warning">
                {{ $menuItem->notifications > 99 ? '+99' : $menuItem->notifications }}
            </span>
        @endif
    </a>

    @if ($menuItem->subMenus)
        <ul class="nav nav-second-level collapse" id="side-menu">
            @foreach ($menuItem->subMenus as $secondLevelMenu)
                @if ($secondLevelMenu->hasAccess())
                <li>
                    <a href="{{ $secondLevelMenu->url }}">
                        @if ($secondLevelMenu->icon)
                            <img src="{{ $secondLevelMenu->icon }}" class="iconos">
                        @endif
                        <span class="nav-label">{{ $secondLevelMenu->text }}</span>
                    </a>

                    @if ($secondLevelMenu->subMenus)
                        <ul class="nav nav-third-level collapse">
                            @foreach ($secondLevelMenu->subMenus as $thirdLevelMenu)
                                @if ($thirdLevelMenu->hasAccess())
                                <li>
                                    <a href="{{ $thirdLevelMenu->url }}">
                                        @if ($thirdLevelMenu->icon)
                                            <img src="{{ $thirdLevelMenu->icon }}" class="iconos">
                                        @endif
                                        <span class="nav-label">{{ $thirdLevelMenu->text }}</span>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
                @endif
            @endforeach
        </ul>
    @endif
</li>
@endif
