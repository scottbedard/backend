@props([
    'content' => null,
    'data' => null,
])

@if (is_callable($content))
    {{ $content($data) }}
@else
    {{ $content }}
@endif
