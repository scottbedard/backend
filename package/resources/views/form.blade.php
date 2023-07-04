<x-backend::layout padded>
  <x-backend::grid padded>
    @foreach ($fields as $field)
      <x-backend::grid-cell :span="$field->span">
        {{ $field->type->render($model) }}
      </x-backend::grid-cell>
    @endforeach
  </x-backend::grid>

  <div style="height: 2000px">Hey</div>
</x-backend::layout>
