<x-backend::layout.main>
    <div class="grid gap-6">
        <div class="p-6">
            Upper section
        </div>

        <x-backend::table
            :schema="$resource::schema()" />
    </div>
</x-backend::layout.main>