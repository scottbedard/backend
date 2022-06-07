<div
    x-data="{ modal: false }"
    @dismiss="modal = false"
    @secondary-click="modal = false">
    <x-backend::button
        x-on:click="modal = true"
        :x-bind:disabled="$requireSelection ? '!checked.includes(true)' : null"
        :icon="$icon"
        :theme="$theme">
        {{ $text }}
    </x-backend::button>

    @if ($confirm)
        <template x-if="modal">
            <x-backend::action-modal
                method="delete"
                button-icon="trash"
                button-text="Confirm"
                button-theme="danger"
                button-type="submit"
                secondary-icon="arrow-left"
                secondary-text="Cancel">
                Are you sure you want to delete these records?
            </x-backend::action-modal>
        </template>
    @endif
</div>