<x-backend::layout.html>
    <x-backend::layout.head />

    <x-backend::layout.body class="dark:bg-gray-700 dark:text-white">
        <div class="flex flex-col min-h-screen">
            <x-backend::layout.header />

            <div class="flex flex-1">
                <x-backend::layout.nav />

                <div class="flex-1 overflow-x-auto overflow-y-hidden">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </x-backend::layout.body>
</x-backend::layout.html>
