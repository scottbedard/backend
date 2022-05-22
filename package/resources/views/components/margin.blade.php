@props([
    'padded' => false,
    'paddedX' => false,
    'paddedY' => false,
])

<div {{ $attributes->class([
    'border border-black max-w-screen-2xl mx-auto',
    'p-6' => $padded,
    'px-6' => $paddedX,
    'py-6' => $paddedY,
]) }}>
    {{ $slot }}
</div>