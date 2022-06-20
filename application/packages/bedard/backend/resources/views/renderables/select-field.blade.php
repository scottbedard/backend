@if ($label)
    <x-backend::label
        :text="$label"
        :required="$required" />
@endif

<div
    x-data="selectField"
    x-ref="selectField"
    @class([
        'bg-gray-50 border border-gray-300 flex h-12 items-center justify-between px-3 relative rounded-md text-sm tracking-wide w-full focus-within:border-gray-400 dark:bg-gray-500 dark:border-none dark:focus:bg-gray-500/70' => true,
        'hover:border-gray-400 dark:hover:bg-gray-600' => !$readonly,
        'cursor-pointer' => !$readonly && !$disabled,
    ])
    @click="expand">
    <div>Left</div>

    <x-backend::icon name="chevron-down" size="20" />

    <template x-if="expanded">
        <div class="absolute bg-gray-50 border border-gray-400 grid left-0 rounded p-2 top-full w-full">
            @foreach ($options as $option)
                <div
                    class="flex h-8 items-center px-3 rounded hover:bg-success-500 hover:text-white"
                    @click="select(1)">
                    @if (is_callable($display))
                        {{ $display($option, $loop->index) }}
                    @else
                        {{ $option->{$display} }}
                    @endif
                </div>
            @endforeach
        </div>
    </template>
</div>
