<x-backend::layout.main>
    <x-backend::title-bar>
        <x-slot:left>
            <a href="{{ route('backend.resources.show', ['id' => $resource::$id]) }}">
                {{ $resource::$title }}
            </a>
        </x-slot:left>

        <x-slot:right>
            New {{ $resource::$entity }}
        </x-slot:right>
    </x-backend::title-bar>

    <form class="gap-6 grid p-6">
        @csrf

        @foreach ($fields as $field)
            <div>
                {{ $field->label }}
            </div>
        @endforeach
    </form>
</x-backend::layout.main>