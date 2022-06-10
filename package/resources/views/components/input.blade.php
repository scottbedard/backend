@props([
    'autofocus' => false,
    'placeholder' => '',
    'readonly' => false,
    'required' => false,
    'type' => 'input',
    'value' => '',
])

<input
    class="border bg-gray-50 border-gray-300 h-12 outline-none px-3 rounded-md tracking-wide w-full text-sm focus:border-gray-400 hover:border-gray-400 dark:bg-gray-500 dark:border-none dark:focus:bg-gray-500/70 dark:hover:bg-gray-500/70 dark:placeholder:text-gray-200"
    placeholder="{{ $placeholder }}"
    type="{{ $type }}"
    value="{{ $value }}"
    {{ $autofocus ? 'autofocus' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $required ? 'required' : '' }} />
