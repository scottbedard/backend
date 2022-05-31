@props([
    'align' => 'left',
    'sortable' => false,
])

<div {{ $attributes->class([
    'border-y border-gray-300 align-middle h-12 px-6 table-cell dark:border-gray-600',
    'text-center' => strtolower(trim($align)) === 'center',
    'text-left' => strtolower(trim($align)) === 'left',
    'text-right' => strtolower(trim($align)) === 'right',
]) }}>
    {{ $slot }}
</div>
