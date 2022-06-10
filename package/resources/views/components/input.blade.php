@props([
    'autofocus' => false,
    'disabled' => false,
    'placeholder' => '',
    'readonly' => false,
    'required' => false,
    'type' => 'input',
    'value' => '',
])

<input
    @class([
        'border bg-gray-50 border-gray-300 h-12 outline-none px-3 rounded-md tracking-wide w-full text-sm focus:border-gray-400 dark:bg-gray-500 dark:border-none dark:focus:bg-gray-500/70 dark:placeholder:text-gray-200' => true,
        'hover:border-gray-400 dark:hover:bg-gray-500/70' => !$readonly,
        'cursor-not-allowed' => $readonly || $disabled,
    ])
    placeholder="{{ $placeholder }}"
    type="{{ $type }}"
    value="{{ $value }}"
    {{ $autofocus ? 'autofocus' : '' }}
    {{ $disabled || $readonly ? 'disabled' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $required ? 'required' : '' }} />
