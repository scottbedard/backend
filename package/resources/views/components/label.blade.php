@props([
    'required' => false,
    'text' => '',
])

<label>
    <div class="flex flex-nowrap gap-[3px] mb-1">
        <div class="font-bold text-sm tracking-wide">{{ $text }}</div>

        <div class="bg-primary-400 h-[5px] rounded-full w-[5px] dark:bg-primary-500"></div>
    </div>

    <div>
        {{ $slot }}
    </div>
</label>