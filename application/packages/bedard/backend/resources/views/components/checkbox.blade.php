@props([
    'checked' => false,
    'id' => null,
])

<label
    x-bind:aria-checked="checked ? true : false"
    x-bind:data-checked="checked ? true : null"
    x-bind:data-not-checked="checked ? null : true"
    x-data="{ checked: {{ $checked ? 'true' : 'false' }} }"
    x-modelable="checked"
    data-checkbox
    role="checkbox"
    {{
        $attributes->merge([
            'class' => 'x-checkbox cursor-pointer flex h-full items-center justify-center',
            'id' => $id,
        ])
    }}>
    <div
        class="aspect-square be-input flex items-center justify-center w-6"
        style="width: 1.35rem">
        <input
            x-model="checked"
            class="hidden"
            type="checkbox" />

        <svg
            class="text-primary-500 w-4/5 dark:text-primary-50"
            focusable="false"
            version="1.1"
            viewBox="0 0 24 24">
            <path
                d="M4.1,12.7 9,17.6 20.3,6.3"
                fill="none"
                stroke="currentColor"
                stroke-dasharray="50"
                stroke-dashoffset="50"
                stroke-width="3.5" />
        </svg>
    </div>
</label>