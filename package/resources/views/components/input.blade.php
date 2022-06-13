@props([
    'autofocus' => false,
    'disabled' => false,
    'el' => 'input',
    'name' => '',
    'placeholder' => '',
    'readonly' => false,
    'required' => false,
    'type' => 'input',
    'value' => '',
])

<{{ $el }}
    @class([
        'border bg-gray-50 border-gray-300 rounded-md tracking-wide w-full text-sm dark:bg-gray-500 dark:border-none' => true,
        'h-12 outline-none px-3 focus:border-gray-400 dark:focus:bg-gray-500/70 dark:placeholder:text-gray-200' => $el === 'input',
        'hover:border-gray-400 dark:hover:bg-gray-600' => !$readonly,
        'cursor-not-allowed' => $readonly || $disabled,
    ])
    {{ $autofocus ? "autofocus={$autofocus}" : '' }}
    {{ $disabled || $readonly ? 'disabled' : '' }}
    {{ $name ? "name={$name}" : '' }}
    {{ $placeholder ? "placeholder={$placeholder}" : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $required ? 'required' : '' }}
    {{ $type ? "type={$type}" : '' }}
    {{ $value ? "value={$value}" : '' }}
>{{ $slot }}</{{ $el }}>
