<x-backend::layout.main>
    <div class="bg-gray-200 flex font-bold items-center h-12 text-sm tracking-wide">
        <a
            class="bg-gray-300 flex h-full items-center px-6 "
            href="{{ route('backend.resources.show', ['id' => $resource::$id]) }}">

            {{ $resource::$title }}
        </a>
        
        <div
            class="border-l-[1.5rem] border-l-gray-300 border-r-0 border-solid border-y-[1.5rem] flex h-full items-center px-6">
            New {{ $resource::$entity }}
        </div>
    </div>

    <form class="gap-6 grid p-6">
        @csrf

        @foreach ($fields as $field)
            <div>
                {{ $field->label }}
            </div>
        @endforeach
    </form>

</x-backend::layout.main>