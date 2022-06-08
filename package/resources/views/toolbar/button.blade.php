<div
    x-data="{ modal: false }"
    @dismiss="modal = false"
    @secondary-click="modal = false">
    <x-backend::button
        x-on:click="modal = true"
        :x-bind:disabled="$attrs['requireSelection'] ? '!checked.includes(true)' : null"
        :icon="$attrs['icon']"
        :theme="$attrs['theme']">
        {{ $attrs['text'] }}
    </x-backend::button>

    @if ($attrs['confirm'])
        <template x-if="modal">
            <x-backend::action-modal
                method="delete"
                button-type="submit"
                :button-icon="$attrs['confirm']['buttonIcon']"
                :button-text="$attrs['confirm']['buttonText']"
                :button-theme="$attrs['confirm']['buttonTheme']"
                :secondary-icon="$attrs['confirm']['secondaryIcon']"
                :secondary-text="$attrs['confirm']['secondaryText']"
                :title="$attrs['confirm']['title']">

                @foreach ($context['data'] as $row)
                    <input
                        class="hidden"
                        name="resource[]"
                        type="checkbox"
                        value="{{ $row->id }}"
                        :checked="checked[{{ $loop->index }}]" />
                @endforeach
                
                <div>{!! $attrs['confirm']['text'] !!}</div>
            </x-backend::action-modal>
        </template>
    @endif
</div>