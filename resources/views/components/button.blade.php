@props([
    'text' => '',
    'visible' => true,
    'buttonAttributes' => [],
    'class' => 'btn btn-primary',
])

@if ($visible)
    <a {{ $attributes->merge(['class' => "$class"])->merge($buttonAttributes) }}>
        {{ $text }}
    </a>
@endif
