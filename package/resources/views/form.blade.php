<x-backend::layout padded>
  <x-backend::grid padded>

    @foreach ($options['fields'] as $field)
      <x-backend::grid-cell :span="$field['span']">
        <x-backend::input />
      </x-backend::grid-cell>
    @endforeach

  </x-backend::grid>
</x-backend::layout>
