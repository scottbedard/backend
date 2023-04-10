<x-backend::layout>
  <div class="p-6">
    <x-backend::banner
      header="Uh oh, no index route is defined!"
      icon="alert-triangle">
      Don't worry, this is an easy fix! Create a <code class="bg-gray-200 inline-block px-1 rounded text-sm">_root.yaml</code>
      and define a route with path <code class="bg-gray-200 inline-block px-1 rounded text-sm">/</code>.
    </x-backend::banner>
  </div>
</x-backend::layout>
