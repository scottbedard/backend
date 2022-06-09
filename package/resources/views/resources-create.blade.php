<x-backend::layout.main>
    <div class="bg-gray-200 flex gap-3 items-center h-12 px-6">
        <div>{{ $resource::$title }}</div>

        <x-backend::icon
            name="chevron-right"
            size="16" />
        
        <div>New {{ $resource::$entity }}</div>
    </div>

    <form class="p-6">
        @csrf
        
        Soon...
    </form>

</x-backend::layout.main>