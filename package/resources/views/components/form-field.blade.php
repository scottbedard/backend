@props([
    'label' => '',
    'required' => false,
])

<x-backend::label
    :text="$label" 
    :required="$required">

    {{ $slot }}
</x-backend::label>