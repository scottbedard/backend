<x-backend::layout padded>
  <div class="gap-6 grid">
    <x-backend::grid padded>
      @foreach ($fields as $field)
        <x-backend::grid-cell :span="$field->option('span', 12)">
          {{ $field->render() }}
        </x-backend::grid-cell>
      @endforeach
    </x-backend::grid>

    <div class="flex flex-wrap justify-end gap-6 ">
      <x-backend::button
        class="w-full sm:w-auto"
        icon="arrow-left">
        Return to list
      </x-backend::button>

      <x-backend::button
        class="w-full sm:w-auto"
        icon="user-plus"
        theme="primary">
        Create admin
      </x-backend::button>
    </div>
  </div>
</x-backend::layout>
