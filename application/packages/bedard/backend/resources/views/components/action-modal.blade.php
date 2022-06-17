@props([
    'action' => '',
    'buttonIcon' => null,
    'buttonText' => null,
    'buttonTheme' => null,
    'secondaryText' => null,
    'secondayIcon' => null,
    'resource' => null,
    'title' => '',
])

<x-backend::modal padded>
    @if ($resource && $action)
        <form
            x-data="{ loading: true }"
            action="{{ route('backend.resources.action', ['id' => $resource::$id]) }}"
            method="POST"
            @submit="loading = true">
            @csrf

            <input type="hidden" name="_action" value="{{ $action }}" />
    @else
        <div>
    @endif
        <div class="grid gap-6">
            <div class="grid gap-6 mb-10">
                <h3 class="font-bold text-2xl">{{ $title }}</h3>

                <div>{{ $slot }}</div>
            </div>
            
            <x-backend::action-bar
                button-type="submit"
                :button-icon="$buttonIcon"
                :button-text="$buttonText"
                :button-theme="$buttonTheme"
                :secondary-icon="$secondaryIcon"
                :secondary-text="$secondaryText" />
        </div>
    @if ($action)
        </form>
    @else
        </div>
    @endif
</x-backend::modal>