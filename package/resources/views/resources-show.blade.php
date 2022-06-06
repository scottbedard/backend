<x-backend::layout.main>
    <div x-data="{ checked: 0, loading: true, showDeleteConfirmation: false }">
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
                        ::disabled="checked < 1"
                        icon="trash"
                        @click="showDeleteConfirmation = true">
                        Delete selected
                    </x-backend::button>

                    <template x-if="showDeleteConfirmation">
                        <x-backend::modal @dismiss="showDeleteConfirmation = false">
                            <h3 class="font-bold mb-3 text-xl" >Confirm delete</h3>

                            <div class="mb-6">Are you sure you want to delete these records?</div>

                            <form
                                action="{{ route('backend.resources.destroy', ['id' => $resource::$id]) }}"
                                method="POST">
                                @csrf

                                <input type="hidden" name="_method" value="DELETE" />

                                @foreach ($data as $row)
                                    <input
                                        class="hidden"
                                        name="resource[]"
                                        type="checkbox"
                                        value="{{ $row->id }}"
                                        :checked="checked[{{ $loop->index }}]" />
                                @endforeach
                        
                                <x-backend::action-bar
                                    button-icon="trash"
                                    button-text="Confirm"
                                    button-theme="danger"
                                    button-type="submit"
                                    secondary-icon="arrow-left"
                                    secondary-text="Cancel"
                                    @secondary-click="showDeleteConfirmation = false" />
                            </form>
                        </x-backend::modal>
                    </template>
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