<div @class([
    'text-left' => $align === 'left',
    'text-center' => $align === 'center',
    'text-right' => $align === 'right',
])>
    {{ $output }}
</div>