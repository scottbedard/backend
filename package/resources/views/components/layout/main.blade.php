<x-backend::layout.html :user="$user">
    <x-backend::layout.head />

    <x-backend::layout.body>
        {{ $slot }}
    </x-backend::layout.body>
</x-backend::layout.html>
