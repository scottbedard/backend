<x-backend::layout.html>
    <x-backend::layout.head />

    <x-backend::layout.body>
        <x-backend::layout.header />

        <div class="grid grid-cols-12">
            <x-backend::layout.nav class="border border-primary-500 col-span-4 lg:col-span-3 xl:col-span-2" />

            <div class="border border-black col-span-8 p-6 lg:col-span-9 xl:col-span-10">
                {{ $slot }}
            </div>
        </div>
    </x-backend::layout.body>
</x-backend::layout.html>
