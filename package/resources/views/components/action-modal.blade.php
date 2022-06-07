@props([
    'action' => '',
    'buttonIcon' => null,
    'buttonText' => null,
    'buttonTheme' => null,
    'secondaryText' => null,
    'secondayIcon' => null,
    'method' => 'post',
    'title' => '',
])

<x-backend::modal>
    <form
        action="{{ $action }}"
        class="grid gap-6"
        method="POST">
        @csrf

        <input type="hidden" name="_method" value="{{ $method }}" />

        <div class="grid gap-6 p-6">
            <h3 class="font-bold text-xl">{{ $title }}</h3>

            <div>
                {{ $slot }}
            </div>
        </div>
        
        <x-backend::action-bar
            class="bg-gray-200 p-6"
            button-type="submit"
            :button-icon="$buttonIcon"
            :button-text="$buttonText"
            :button-theme="$buttonTheme"
            :secondary-icon="$secondaryIcon"
            :secondary-text="$secondaryText"
            @secondary-click="showDeleteConfirmation = false" />
    </form>
</x-backend::modal>