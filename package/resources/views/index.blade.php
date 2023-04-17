<x-backend::layout>
  <div class="p-6">
    <x-backend::banner
      header="Uh oh, no index route is defined!"
      icon="alert-triangle">
      Don't worry, this is an easy fix! Create an <code class="bg-gray-200 inline-block px-1 rounded text-sm">_index.yaml</code> file
      and define a route with a path of <code class="bg-gray-200 inline-block px-1 rounded text-sm">null</code>.
    </x-backend::banner>
  </div>
</x-backend::layout>
