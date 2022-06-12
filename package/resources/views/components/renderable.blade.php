@props([
    'content' => null,
    'data' => null,
])

<div {{ $attributes->class([])->merge([]) }}>{{ is_callable($content) ? $content($data) : $content }}</div>
