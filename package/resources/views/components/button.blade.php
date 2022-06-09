@props([
    'disabled' => false,
    'icon' => null,
    'theme' => 'default',
])

<button
    {{
        $attributes
            ->class([
                'flex font-bold items-center gap-2 h-10 px-4 rounded text-sm tracking-wide whitespace-nowrap disabled:pointer-events-none' => true,
                'bg-primary-600 disabled:opacity-70 text-white hover:bg-primary-500' => $theme === 'primary',
                'bg-gray-200 disabled:opacity-70 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500' => $theme === 'default',
                'bg-danger-500 text-white hover:bg-danger-600 disabled:bg-danger-300 dark:disabled:bg-danger-400/90' => $theme === 'danger',
            ])
            ->merge([
                'data-button' => true,
            ])
    }}>
    @if ($icon)
        <div class="aspect-square inline-flex items-center justify-center w-4">
            <x-backend::icon
                size="16"
                :name="$icon" />
        </div>
    @endif

    {{ $slot }}
</button>