<x-backend::layout.main>
    <div x-data="{ checked: [] }">
        <div>
            {{ $toolbar()->render() }}
        </div>

        <div>
            {{ $table()->render() }}
        </div>
    </div>
</x-backend::layout.main>