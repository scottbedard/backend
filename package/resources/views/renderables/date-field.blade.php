<div
    x-data="datefield('{{ $value }}', '{{ $parse }}')"
    x-ref="datefield"
    class="cursor-pointer relative"
    @click="expanded = true">

    <x-backend::input el="div">
        <div class="flex h-12 items-center px-3">
            {{ $value }}
        </div>
    </x-backend::input>

    <input
        x-model="value"
        class="hidden"
        type="text" />

    <template x-if="expanded">
        <div class="absolute pt-6 right-0 top-full z-10">
            <div class="bg-gray-50 drop-shadow-lg font-bold group p-3 rounded-md text-sm w-64 dark:bg-gray-600">

                <div class="grid grid-cols-7 mb-3">
                    <a
                        class="aspect-square col-span-1 flex items-center justify-center rounded-sm hover:bg-gray-200/50 dark:hover:bg-gray-800/10"
                        href="#"
                        @click.prevent>
                        <x-backend::icon name="chevron-left" size="16" />
                    </a>

                    <div
                        x-text="month"
                        class="col-span-5 flex items-center justify-center"
                    ></div>

                    <a
                        class="aspect-square col-span-1 flex items-center justify-center rounded-sm hover:bg-gray-200/50 dark:hover:bg-gray-800/10"
                        href="#"
                        @click.prevent>
                        <x-backend::icon name="chevron-right" size="16" />
                    </a>
                </div>

                <div class="gap-[2px] grid grid-cols-7 w-full">
                    <template x-for="header in headers">
                        <div
                            x-text="header"
                            class="col-span-1 flex items-center justify-center pb-1 text-xs tracking-wide z-10 text-gray-300 dark:text-gray-400">
                    </template>

                    <template x-for="day in days">
                        <a
                            href="#"
                            :class="{
                                'aspect-square col-span-1 flex items-center justify-center rounded-sm text-sm tracking-wide hover:bg-gray-200/50 dark:hover:bg-gray-800/10': true,
                                'text-gray-300 dark:text-gray-400': !day.thisMonth,
                                '': day.thisMonth,
                            }"
                            @click.prevent>
                            <span x-text="day.date"></span>
                        </a>
                    </template>
                </div>

                <div class="absolute aspect-square bg-gray-50 left-1/2 rotate-45 rounded-tl-sm top-0 transform -translate-x-1/2 -translate-y-1/2 w-5 dark:bg-gray-600"></div>
            </div>
        </div>
    </template>
</div>