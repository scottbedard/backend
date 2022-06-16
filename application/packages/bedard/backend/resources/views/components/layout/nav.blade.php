<nav {{ $attributes->class(['bg-gray-700 text-white w-20 dark:bg-gray-800']) }}>
    @foreach (Backend::resources() as $resource)
        @can ('access ' . $resource::$id)
            <a
                class="aspect-square flex flex-wrap group items-center justify-center unstyled w-full"
                href="{{ route('backend.resources.show', ['id' => $resource::$id]) }}">
                <div class="flex flex-wrap gap-3 justify-center">
                    <div class="aspect-square flex justify-center w-6">
                        <x-backend::icon
                            class="h-full w-full group-hover:text-primary-500"
                            :name="$resource::$icon" />
                    </div>

                    <div class="text-center text-sm w-full">
                        {{ $resource::$title }}
                    </div>
                </div>
            </a>
        @endcan
    @endforeach
</nav>