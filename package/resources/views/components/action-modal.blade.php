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

<x-backend::modal padded>
    <form
        action="{{ $action }}"
        class="grid gap-6"
        method="POST">
        @csrf

        <input type="hidden" name="_method" value="{{ $method }}" />

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
    </form>
</x-backend::modal>