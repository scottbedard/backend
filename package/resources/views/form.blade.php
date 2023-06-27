<x-backend::layout padded>
  Forms coming soon
  {{-- <div class="gap-6 grid">
    <x-backend::grid padded>
      @foreach ($fields as $field)
        <x-backend::grid-cell :span="$field->get('span', 12)">
          {{ $field->render() }}
        </x-backend::grid-cell>
      @endforeach
    </x-backend::grid>

    <div class="flex flex-wrap justify-end gap-6 ">
      @foreach ($actions as $action)
        <x-backend::button
          class="w-full sm:w-auto"
          :href="$action->get('href')"
          :icon="$action->get('icon')"
          :theme="$action->get('theme')"
          :to="$action->get('to')">
          {{ $action->get('label') }}
        </x-backend::button>
      @endforeach
    </div>
  </div> --}}
</x-backend::layout>
