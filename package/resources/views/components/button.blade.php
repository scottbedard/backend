@props([
    'icon' => null,
    'theme' => 'default',
])

<button
    {{
        $attributes->class([
            'flex font-bold items-center gap-2 h-10 px-3 rounded text-sm tracking-wide',
            'bg-gray-200 hover:bg-gray-300' => $theme === 'default',
            'bg-danger-500 text-white hover:bg-danger-600 disabled:bg-danger-200' => $theme === 'danger',
        ])
        ->merge()
    }}>
    @if ($icon)
        <x-backend::icon
            size="16"
            :name="$icon"></x-backend::icon>
    @endif
    
    {{ $slot }}
</button>