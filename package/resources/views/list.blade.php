<x-backend::layout>
  <div class="gap-6">
    <div class="border-b border-gray-300 flex gap-6 p-6">
      @foreach ($actions as $action)
        <x-backend::button
            :confirmation="$action->confirmation"
            :data-backend-action="$action->action"
            :href="$action->href"
            :icon="$action->icon"
            :theme="$action->theme"
            :type="$action->type"
            :value="$action->action">
            {{ $action->label($actionData) }}
        </x-backend::button>
      @endforeach
    </div>

    <x-backend::table
      :checkboxes="$checkboxes"
      :columns="$columns"
      :hrefs="$hrefs"
      :paginator="$paginator" />
  </div>
</x-backend::layout>
