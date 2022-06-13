<div
    x-data="datefield"
    x-ref="datefield"
    class="cursor-pointer relative"
    :data-date-field="id"
    @click="expanded = true">
    <x-backend::input el="div">
        <div class="flex h-12 items-center px-3">
            {{ $model->{$id} }} - <span x-text="id"></span>
        </div>
    </x-backend::input>

    <template x-if="expanded">
        <div class="absolute pt-6 right-0 top-full z-10">
            <x-backend::input el="div">
                <div class="group p-6 w-64">
                    <div>
                        Soon...
                    </div>

                    <div class="absolute aspect-square border-t border-l bg-gray-50 border-gray-400 left-1/2 rotate-45 rounded-tl-sm top-6 transform -translate-x-1/2 -translate-y-1/2 w-5 group-hover:border-gray-500 dark:group-hover:bg-gray-500/70"></div>
                </div>
            </x-backend::input>
        </div>
    </template>
</div>