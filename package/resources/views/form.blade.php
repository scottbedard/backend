<x-backend::layout padded>
  Forms coming soon...
  <br />
  <br />

  <x-backend::grid padded>
    @foreach ($fields as $field)
      <x-backend::grid-cell :span="$field->span">
        {{ $field->type->render() }}
      </x-backend::grid-cell>
    @endforeach
  </x-backend::grid>
</x-backend::layout>
