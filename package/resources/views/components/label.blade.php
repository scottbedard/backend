@props([
    'for' => '',
    'required' => false,
    'text' => '',
])

<label {{
    $attributes
        ->class('flex flex-nowrap gap-[3px] mb-1')
        ->merge([
            'for' => $for,
        ])
}}>
    <div class="font-bold text-sm tracking-wide">{{ $text }}</div>

    @if ($required)
        <div class="bg-primary-400 h-[5px] rounded-full w-[5px] dark:bg-primary-500"></div>
    @endif
</label>