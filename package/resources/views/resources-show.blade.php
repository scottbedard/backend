<x-backend::layout.main>
    <div x-data="{ checked: [], loading: true, showDeleteConfirmation: false }">
        <div class="flex flex-wrap gap-x-6 p-6">
            @can ('create ' . $resource::$id)
                <x-backend::button
                    icon="plus"
                    theme="primary">
                    {{ $resource->createButtonText() }}
                </x-backend::button>
            @endcan

            @if ($resource->table()->selectable)
                @can ('delete ' . $resource::$id)
                    <x-backend::button
                        x-bind:disabled="!checked.includes(true)"
                        icon="trash"
                        @click="showDeleteConfirmation = true">
                        Delete selected
                    </x-backend::button>

                    <template x-if="showDeleteConfirmation">
                        <x-backend::action-modal
                            method="delete"
                            button-icon="trash"
                            button-text="Confirm"
                            button-theme="danger"
                            button-type="submit"
                            secondary-icon="arrow-left"
                            secondary-text="Cancel"
                            @secondary-click="showDeleteConfirmation = false">
                            Are you sure you want to delete these records?

                            @foreach ($data as $row)
                                <input
                                    class="hidden"
                                    name="resource[]"
                                    type="checkbox"
                                    value="{{ $row->id }}"
                                    :checked="checked[{{ $loop->index }}]" />
                            @endforeach
                        </x-backend::action-modal>
                    </template>
                @endcan
            @endif
        </div>

        <x-backend::table
            x-model="checked"
            :columns="$columns"
            :data="$data"
            :rowRoute="fn ($x) => route('backend.resources.update', ['id' => $resource::$id, 'uid' => $x->id])"
            :selectable="$selectable" />
    </div>
</x-backend::layout.main>