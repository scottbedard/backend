<x-backend::layout.main>
    <div x-data="{ checked: [] }">
        <div class="flex gap-x-6 p-6">
            @foreach ($toolbar->items as $item)
                @can ($item->permissions)
                    <div>
                        {!! $item->render([ 'data' => $data, 'resource' => $resource ]) !!}
                    </div>
                @endcan
            @endforeach
        </div>

        <x-backend::table
            x-model="checked"
            :columns="$columns"
            :data="$data"
            :rowRoute="fn ($x) => route('backend.resources.update', ['id' => $resource::$id, 'modelId' => $x->{$resource::$modelKey}])"
            :selectable="$selectable" />
    </div>
</x-backend::layout.main>