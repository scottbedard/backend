<nav {{ $attributes->class(['grid gap-6 p-6']) }}>
    @foreach (Backend::resources() as $resource)
        <a
            class="flex gap-3 items-center"
            href="{{ route('backend.resources.show', ['resource' => $resource::$id]) }}">
            <x-backend::icon :name="$resource::$icon" />

            {{ $resource::$title }}
        </a>
    @endforeach
</nav>