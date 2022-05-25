<nav {{ $attributes->class(['p-6']) }}>
    <div class="gap-6 grid">
        @foreach (Backend::resources() as $resource)
            <a
                class="flex gap-3 items-center w-full"
                href="{{ route('backend.resources.show', ['id' => $resource::$id]) }}">
                <x-backend::icon :name="$resource::$icon" />

                {{ $resource::$title }}
            </a>
        @endforeach
    </div>
</nav>