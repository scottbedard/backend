@props([
    'padded' => false,
    'paddedX' => false,
    'paddedY' => false,
])

<div {{ $attributes->class([
    'p-6' => $padded,
    'px-6' => $paddedX,
    'py-6' => $paddedY,
]) }}>
    {{ $slot }}
</div>