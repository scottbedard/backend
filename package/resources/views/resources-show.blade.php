<x-backend::layout.main>
    <div x-data="{ checked: 0 }" class="grid gap-6">
        <div class="grid gap-6 p-6">
            Upper section
            
            <template x-if="checked">
                <div><span x-text="checked"></span> <span x-text="checked === 1 ? 'row is' : 'rows are'"></span> selected</div>
            </template>

            <template x-if="!checked">
                <div>Nothing is selected</div>
            </template>
        </div>

        <x-backend::table
            x-model="checked"
            :columns="$columns"
            :data="$data"
            :selectable="$selectable" />
    </div>
</x-backend::layout.main>