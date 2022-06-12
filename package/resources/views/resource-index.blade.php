<x-backend::layout.main>
    <div x-data="{ checked: [] }">
        
        <x-backend::renderable
            class="p-6 empty:hidden"
            :content="$toolbar()->render()" />

        <div>
            {{ $table()->render() }}
        </div>
    </div>
</x-backend::layout.main>