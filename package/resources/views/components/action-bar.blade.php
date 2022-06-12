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
            <x-backend::link
                :icon-left="$secondaryIcon"
                :text="$secondaryText"
                @click.prevent="$dispatch('secondary-click')" />
        </div>
    @endif

    <div>
        <x-backend::button
            :icon="$buttonIcon"
            :theme="$buttonTheme"
            :type="$buttonType">
            {{ $buttonText }}
        </x-backend::button>
    </div>
</div>
