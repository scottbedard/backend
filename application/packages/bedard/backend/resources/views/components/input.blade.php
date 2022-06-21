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
        'be-input be-input-h be-input-px outline-none w-full' => true,
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
