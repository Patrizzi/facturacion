<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2 class="text-capitalize">{{ $title }}</h2>
        @if (!empty($breadcrumbs))
            <ol class="breadcrumb">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item {{ $breadcrumb['is_last'] ? 'active' : '' }}">
                        @if (!$breadcrumb['is_last'])
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                        @else
                            <strong>{{ $breadcrumb['name'] }}</strong>
                        @endif
                    </li>
                @endforeach
            </ol>
        @endif
    </div>
    <div class="col-sm-8">
        <div class="title-action text-white">
            @foreach ($buttons as $button)
                <x-button :buttonAttributes="$button['attributes'] ?? []" :text="$button['text'] ?? ''" :visible="$button['visible'] ?? true" />
            @endforeach
        </div>
    </div>
    {{ $slot }}