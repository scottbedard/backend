<div
    x-data="{ modal: false }"
    @dismiss="modal = false"
    @secondary-click="modal = false">
    <x-backend::button
        x-on:click="modal = true"
        :x-bind:disabled="is_bool($disabled) ? ($disabled ? 'true' : 'false') : $disabled"
        :icon="$icon"
        :theme="$primary ? 'primary' : 'default'"
        :to="$to"
        :type="$submit ? 'submit' : 'button'">
        {{ $text }}
    </x-backend::button>

    @if ($confirm)
        <template x-if="modal">
            <x-backend::action-modal
                :action="$action"
                :button-icon="$confirm['buttonIcon']"
                :button-text="$confirm['buttonText']"
                :button-theme="$confirm['buttonTheme']"
                :resource="$data['resource']"
                :secondary-icon="$confirm['secondaryIcon']"
                :secondary-text="$confirm['secondaryText']"
                :title="$confirm['title']">
                
                @if (array_key_exists('data', $confirm) && is_callable($confirm['data']))
                    {{ $confirm['data']($data) }}
                @endif
                
                <div>{{ $confirm['text'] }}</div>
            </x-backend::action-modal>
        </template>
    @endif
</div>
