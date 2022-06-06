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
                class="inline-flex font-bold gap-x-2 items-center text-sm tracking-wide unstyled text-gray-700 hover:text-black"
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
