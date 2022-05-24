@props([
    'align' => 'left',
    'sortable' => false,
])

<div {{ $attributes->class([
    'text-center' => strtolower(trim($align)) === 'center',
    'text-left' => strtolower(trim($align)) === 'left',
    'text-right' => strtolower(trim($align)) === 'right',
]) }}>
    {{ $slot }}
</div>
