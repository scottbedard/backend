<x-backend::layout.main>
    <div x-data="{ checked: [], loading: true, showDeleteConfirmation: false }">
        <!-- new toolbar -->
        <div class="border border-danger-500 flex gap-x-6 p-6">
            @foreach ($toolbar->items as $item)
                <div>{!! $item->render([
                    'data' => $data,
                    'resource' => $resource,
                ]) !!}</div>
            @endforeach
        </div>

        <x-backend::table
            x-model="checked"
            :columns="$columns"
            :data="$data"
            :rowRoute="fn ($x) => route('backend.resources.update', ['id' => $resource::$id, 'uid' => $x->id])"
            :selectable="$selectable" />
    </div>
</x-backend::layout.main>