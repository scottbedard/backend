@if ($label)
    <div class="flex flex-nowrap gap-[3px] mb-1">
        <div class="font-bold text-sm tracking-wide">{{ $label }}</div>

        @if ($required)
            <div class="bg-primary-400 h-[5px] rounded-full w-[5px] dark:bg-primary-500"></div>
        @endif
    </div>
@endif

<x-backend::input
    :type="$type"
    :required="$required"
    :autofocus="$autofocus"
    :readonly="$readonly"
    :disabled="$disabled"
    :value="$value">
</x-backend::input>
