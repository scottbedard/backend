<x-backend::button
  class="border border-primary-500 p-3"
  :theme="isset($theme) ? $theme : 'default'">
  {{ $label }}
</x-backend::button>
