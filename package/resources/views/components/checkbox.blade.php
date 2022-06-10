@props([
    'checked' => false,
])

<div
    x-bind:aria-checked="checked ? 'true' : 'false'"
    x-data="{ checked: {{ $checked ? 'true' : 'false' }} }"
    x-modelable="checked"
    role="checkbox"
    {{
        $attributes->merge([
            'class' => 'x-checkbox cursor-pointer flex h-full items-center justify-center px-2',
        ])
    }}>
    <label
        class="aspect-square bg-gray-50 border border-gray-300 cursor-pointer flex group items-center justify-center rounded-md transform translate-y-px hover:border-gray-400 dark:bg-gray-500 dark:border-none dark:focus:bg-gray-500/70 dark:hover:bg-gray-500/70"
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
    </label>
</div>