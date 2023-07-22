<x-backend::layout padded>
  <x-backend::grid
    id="backend-form"
    padded
    tag="form">
    @foreach ($fields as $field)
      <x-backend::grid-cell :span="$field->span">
        {{ $field->type->render($model) }}
      </x-backend::grid-cell>
    @endforeach

    <x-backend::grid-cell
      class="gap-x-6 gap-y-3 flex flex-wrap justify-center md:justify-between"
      :span="12">
      <div class="flex flex-wrap gap-6 w-full md:w-auto">
        @foreach ($actions->where('secondary', true) as $action)
          <x-backend::button
            class="w-full"
            name="action"
            :href="$action->href"
            :icon="$action->icon"
            :theme="$action->theme"
            :type="$action->type"
            :value="$action->action">
            {{ $action->label }} {{ $action->href }}
          </x-backend::button>
        @endforeach
      </div>

      <div class="flex flex-wrap gap-x-6 gap-y-3 w-full md:w-auto">
        @foreach ($actions->where('secondary', false) as $action)
          <x-backend::button
            class="w-full md:w-auto"
            name="action"
            :href="$action->href"
            :icon="$action->icon"
            :theme="$action->theme"
            :type="$action->type"
            :value="$action->action">
            {{ $action->label }}
          </x-backend::button>
        @endforeach
      </div>
    </x-backend::grid-cell>
  </x-backend::grid>
</x-backend::layout>
