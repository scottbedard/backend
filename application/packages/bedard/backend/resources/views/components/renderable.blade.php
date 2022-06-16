@props([
    'content' => null,
    'data' => null,
    'el' => 'null',
])

@if ($el)
    <{{ $el }} {{ $attributes->class([])->merge([]) }}>{{--
        --}}{{ is_callable($content) ? $content($data) : $content }}{{--
    --}}</{{ $el }}>
@else
    {{ is_callable($content) ? $content($data) : $content }}
@endif
