<nav {{ $attributes->class(['grid gap-6 p-6']) }}>
    @foreach (Backend::resources() as $link)
        <a
            class="flex gap-3 items-center"
            href="{{ route('backend.resources.show', ['resource' => $link['route']]) }}">
            <x-backend::icon :name="$link['icon']" />

            {{ $link['title'] }}
        </a>
    @endforeach
</nav>