@props([
    'autofocus' => false,
    'disabled' => false,
    'el' => 'input',
    'id' => null,
    'name' => '',
    'placeholder' => '',
    'readonly' => false,
    'required' => false,
    'type' => 'input',
    'value' => '',
])

<{{ $el }}
    @class([
        'be-input w-full' => true,
        'be-input-h be-input-px outline-none focus:border-gray-400 dark:focus:bg-gray-500/70 dark:placeholder:text-gray-200' => $el === 'input',
        'hover:border-gray-400 dark:hover:bg-gray-600' => !$readonly,
        'cursor-not-allowed' => $readonly || $disabled,
    ])
    {{ $autofocus ? "autofocus={$autofocus}" : '' }}
    {{ $disabled || $readonly ? 'disabled' : '' }}
    {{ $id ? "id={$id}" : '' }}
    {{ $name ? "name={$name}" : '' }}
    {{ $placeholder ? "placeholder={$placeholder}" : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $required ? 'required' : '' }}
    {{ $type ? "type={$type}" : '' }}
    {{ $value ? "value={$value}" : '' }}
>{{ $slot }}</{{ $el }}>
