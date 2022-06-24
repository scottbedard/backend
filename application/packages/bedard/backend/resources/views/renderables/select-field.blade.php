@if ($label)
    <x-backend::label
        :text="$label"
        :required="$required" />
@endif

<div
    x-data="selectField({
        data: {{ json_encode($options) }},
        display: '{{ $display }}',
        handler: '{{ $handler }}',
        key: '{{ $id }}',
        placeholder: '{{ $placeholder }}',
        value: null,
    })"
    x-ref="selectField"
    x-bind:class="{
        'be-input-h relative text-sm': true,
    }"
    @click="open">

    <input
        x-model="value"
        name="form[{{ $id }}]"
        type="hidden" />
    
    <div
        x-bind:class="{
            'be-input be-input-h be-input-px cursor-pointer flex group h-full items-center justify-between': true,
            'be-input-focus': expanded,
        }">
        <div
            x-bind:class="{ 'be-input-placeholder': value === null }"
            x-text="displayValue"></div>

        <x-backend::icon name="chevron-down" size="20" />
    </div>

    <template x-if="expanded">
        <div
            x-trap="expanded"
            class="absolute be-popover be-popover-mt be-scrollbar left-0 max-h-64 overflow-y-scroll p-3 right-0 top-full">
            @if ($searchable)
                <div class="mb-2 relative">
                    <input
                        x-model="search"
                        autofocus
                        class="bg-white border border-gray-200 h-10 outline-none px-3 rounded text-sm w-full dark:bg-gray-500/50 dark:border-gray-500 dark:placeholder-gray-400"
                        placeholder="{{ $searchPlaceholder }}" />

                    <x-backend::icon
                        class="absolute pointer-events-none right-3 text-gray-300 top-1/2 transform -translate-y-1/2 dark:text-gray-400"
                        name="search"
                        size="16" />
                </div>
            @endif

            <template x-for="model in data">
                <a
                    x-text="model[display]"
                    class="cursor-pointer flex h-10 items-center px-3 rounded hover:bg-primary-500 hover:text-white "
                    href="#"
                    @click.prevent="select(model[key])">
                </a>
            </template>
        </div>
    </template>
</div>
