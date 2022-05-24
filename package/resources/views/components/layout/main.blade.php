<x-backend::layout.html>
    <x-backend::layout.head />

    <x-backend::layout.body>
        <x-backend::layout.header />

        <div class="grid grid-cols-12">
            <x-backend::layout.nav class="col-span-4 lg:col-span-3 xl:col-span-2" />

            <div class="col-span-8 lg:col-span-9 xl:col-span-10">
                {{ $slot }}
            </div>
        </div>
    </x-backend::layout.body>
</x-backend::layout.html>
