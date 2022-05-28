<nav {{ $attributes->class(['bg-gray-700 py-3 text-white']) }}>
    @foreach (Backend::resources() as $resource)
        <a
            class="flex gap-3 group items-center px-6 py-3 unstyled w-full"
            href="{{ route('backend.resources.show', ['id' => $resource::$id]) }}">
            <x-backend::icon
                class="group-hover:text-primary-500"
                :name="$resource::$icon" />

            {{ $resource::$title }}
        </a>
    @endforeach
</nav>