<x-backend::layout.main>
    <div class="grid gap-6">
        <div class="p-6">
            Upper section
        </div>

        <x-backend::table
            :columns="$columns"
            :data="$data"
            :selectable="$selectable" />
    </div>
</x-backend::layout.main>