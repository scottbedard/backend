@if ($label)
    <x-backend::label
        :text="$label"
        :required="$required" />
@endif

<div
    x-data="selectField({
        data: {{ json_encode($options) }},
        display: '{{ $display }}',
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
            class="absolute be-popover left-0 mt-3 p-3 right-0 top-full">
            <template x-for="model in data">
                <div
                    x-text="model[display]"
                    class="cursor-pointer flex h-10 items-center px-3 rounded hover:bg-primary-500 hover:text-white "
                    @click="select(model[key])">
                </div>
            </template>
        </div>
    </template>
</div>
