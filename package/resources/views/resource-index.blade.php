<x-backend::layout.main>
    <div class="border-4 border-gray-500 border-dashed h-24 flex items-center justify-center">
        Scoreboard area
    </div>

    <div class="p-6">
        {{ $toolbar()->render() }}
    </div>

    <div>
        {{ $table()->render() }}
    </div>
</x-backend::layout.main>