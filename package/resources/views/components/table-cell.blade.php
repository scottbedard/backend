@props([
    'align' => 'left',
])

<div {{ $attributes->class([
    'align-middle border-b border-gray-300 h-12 px-6 table-cell dark:border-gray-600',
    'text-center' => strtolower(trim($align)) === 'center',
    'text-left' => strtolower(trim($align)) === 'left',
    'text-right' => strtolower(trim($align)) === 'right',
]) }}>
    {{ $slot }}
</div>