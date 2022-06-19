@php
    $alert = session()->get('alert')
@endphp

@if ($alert)
    @php
        $type = data_get($alert, 'type', 'default');

        $message = data_get($alert, 'message', '');

        $icon = 'info';
        if ($type === 'danger') $icon = 'alert-triangle';
        if ($type === 'success') $icon = 'check';
    @endphp

    <div
        x-data="customAlert"
        class="fixed left-1/2 top-12 transform -translate-x-1/2"
        data-alert="{{ $type }}"
        @click="acknowledged = true"
        @mouseenter="pause"
        @mouseleave="resume">
        <template x-if="!acknowledged">
            <x-backend::button
                :icon="$icon"
                :theme="$type"
                title="Dismiss alert"
                @click="acknowledge">
                {{ $message }}
            </x-backend::button>
        </template>
    </div>
@endif
