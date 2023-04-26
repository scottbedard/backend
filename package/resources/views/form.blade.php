<x-backend::layout padded>
  <x-backend::grid padded>

    @foreach ($fields as $field)
      <x-backend::grid-cell :span="$field->get('span', 12)">
        {{ $field->render() }}
      </x-backend::grid-cell>
    @endforeach

  </x-backend::grid>
</x-backend::layout>
