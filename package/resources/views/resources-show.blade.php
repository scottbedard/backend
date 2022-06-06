<x-backend::layout.main>
    <div x-data="{ checked: 0 }">
        <div class="flex flex-wrap gap-x-6 p-6">
            @can ('create ' . $resource::$id)
                <x-backend::button icon="plus">
                    {{ $resource->createButtonText() }}
                </x-backend::button>
            @endcan

            @if ($resource->table()->selectable)
                @can ('delete ' . $resource::$id)
                    <x-backend::button
                        ::disabled="checked < 1"
                        icon="trash"
                        theme="danger">
                        Delete selected
                    </x-backend::button>
                @endcan
            @endif
        </div>

        <x-backend::table
            x-model="checked"
            :columns="$columns"
            :data="$data"
            :selectable="$selectable" />
    </div>
</x-backend::layout.main>