<div
    x-data="{ modal: false }"
    @dismiss="modal = false"
    @secondary-click="modal = false">
    <x-backend::button
        x-on:click="modal = true"
        :x-bind:disabled="$requireSelection ? '!checked.includes(true)' : null"
        :icon="$icon"
        :theme="$theme"
        :to="$to">
        {{ $text }}
    </x-backend::button>

    @if ($confirm)
        <template x-if="modal">
            <x-backend::action-modal
                method="delete"
                button-type="submit"
                :button-icon="$confirm['buttonIcon']"
                :button-text="$confirm['buttonText']"
                :button-theme="$confirm['buttonTheme']"
                :secondary-icon="$confirm['secondaryIcon']"
                :secondary-text="$confirm['secondaryText']"
                :title="$confirm['title']">

                @foreach ($data as $row)
                    <input
                        name="resource[]"
                        type="checkbox"
                        value="{{ $row->id }}"
                        :checked="checked[{{ $loop->index }}]" />
                @endforeach
                
                <div>{!! $confirm['text'] !!}</div>
            </x-backend::action-modal>
        </template>
    @endif
</div>
