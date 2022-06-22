<div
    x-data="dateField('{{ $value }}', '{{ $parse }}', '{{ $format }}')"
    x-ref="dateField"
    class="relative"
    data-date-field="{{ $id }}"
    @click="expanded = true">
    @if ($label)
        <x-backend::label
            :text="$label"
            :required="$required" />
    @endif

    <div class="be-input be-input-h be-input-px cursor-pointer flex group items-center justify-between">
        <div class="flex items-center gap-3">
            <x-backend::icon
                class="text-gray-400 group-hover:text-gray-700 dark:text-gray-200 dark:group-hover:text-gray-100"
                name="calendar"
                size="18"
                stroke-width="1.8" />

            <div x-text="formatted"></div>
        </div>

        <x-backend::icon
            class="text-gray-400 group-hover:text-gray-700 dark:text-gray-200 dark:group-hover:text-gray-100"
            name="chevron-down"
            size="18" />
    </div>

    <input
        x-model="value"
        class="hidden"
        name="{{ 'form[' . $id . ']' }}"
        type="text"
        value="{{ $value }}" />

    <template x-if="expanded">
        <div
            class="absolute be-popover be-popover-mt right-0 top-full w-72 z-10"
            data-calendar>
            <div class="grid grid-cols-7 px-3">
                <a
                    class="aspect-square col-span-1 flex items-center justify-center rounded-md hover:bg-gray-300/50 dark:hover:bg-gray-800/40"
                    data-prev
                    href="#"
                    @click.prevent="prev">
                    <x-backend::icon name="chevron-left" size="18" />
                </a>

                <div
                    x-text="month"
                    class="col-span-5 flex items-center justify-center"
                    data-month
                ></div>

                <a
                    class="aspect-square col-span-1 flex items-center justify-center rounded-md hover:bg-gray-300/50 dark:hover:bg-gray-800/40"
                    data-next
                    href="#"
                    @click.prevent="next">
                    <x-backend::icon name="chevron-right" size="18" />
                </a>
            </div>

            <div class="grid grid-cols-7 my-2 px-3 w-full">
                <template x-for="header in headers">
                    <div
                        x-text="header"
                        class="col-span-1 flex items-center justify-center pb-1 text-xs tracking-wide z-10 text-gray-400 dark:text-gray-300">
                </template>

                <template x-for="day in days">
                    <a
                        x-text="day.date"
                        href="#"
                        :class="{
                            'aspect-square col-span-1 flex items-center justify-center rounded-md text-sm tracking-wide hover:bg-gray-300/50 dark:hover:bg-gray-800/40': true,
                            'text-gray-400 dark:text-gray-300': !day.thisMonth,
                            'bg-gray-200/50 text-primary-500 dark:bg-gray-800/20': day.selected,
                        }"
                        :data-date="day.date"
                        @click.prevent="select(day.instance)"
                    ></a>
                </template>
            </div>
        </div>
    </template>
</div>