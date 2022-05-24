<x-backend::layout.main>
    <div class="grid gap-6">
        <div class="p-6">
            Upper section
        </div>

        <pre>{{ json_encode($resource::schema()) }}</pre>

        <x-backend::table />
    </div>
</x-backend::layout.main>