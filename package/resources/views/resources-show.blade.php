<x-backend::layout.main>
    <div class="grid gap-6">
        <div class="p-6">
            Upper section
        </div>

        <x-backend::table
            :data="$data"
            :schema="$schema" />
    </div>
</x-backend::layout.main>