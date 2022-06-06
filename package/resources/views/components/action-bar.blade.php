@props([
    'buttonIcon' => null,
    'buttonText' => null,
    'buttonTheme' => null,
    'buttonType' => 'button',
    'secondaryIcon' => null,
    'secondaryText' => null,
])

<div {{ $attributes->class([
    'flex flex-wrap items-center justify-end gap-x-6',
])->merge([]) }}>
    @if ($secondaryText)
        <div class="flex-1">
            <a
                class="inline-flex font-semibold gap-x-2 items-center text-sm unstyled text-gray-400 hover:text-gray-900"
                href="#"
                @click.prevent="$dispatch('secondary-click')">
                @if ($secondaryIcon)
                    <x-backend::icon :name="$secondaryIcon" size="16" />
                @endif

                {{ $secondaryText }}
            </a>
        </div>
    @endif

    <div>
        <x-backend::button
            :icon="$buttonIcon"
            :theme="$buttonTheme"
            :type="$buttonType"
            @click="$dispatch('primary-click')"
            {{ $attributes->merge([':loading'])}}>
            {{ $buttonText }}
        </x-backend::button>
    </div>
</div>
