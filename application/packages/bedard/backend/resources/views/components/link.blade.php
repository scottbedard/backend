@props([
    'href' => '#',
    'iconLeft' => null,
    'iconRight' => null,
    'text' => '',
])

<a
    {{ 
        $attributes->class([
            'inline-flex font-bold gap-x-2 items-center text-sm tracking-wide unstyled hover:text-primary-400' => true
        ])
        ->merge([
            'href' => $href,
        ])
    }}>
    @if ($iconLeft)
        <x-backend::icon size="16" :name="$iconLeft" />
    @endif

    {{ $text }}

    @if ($iconRight)
        <x-backend::icon size="16" :name="$iconRight" />
    @endif
</a>
