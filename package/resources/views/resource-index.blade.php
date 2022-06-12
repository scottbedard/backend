<x-backend::layout.main>
    <div x-data="{ checked: [] }">
        
        <!-- <div class="border-4 border-gray-500 border-dashed flex items-center">
            <pre class="text-left text-sm" x-text="JSON.stringify({ checked }, null, '\t')"></pre>
        </div> -->

        <div class="p-6">
            <x-backend::renderable
                :content="$toolbar()->render()">
            </x-backend::renderable>
        </div>

        <div>
            {{ $table()->render() }}
        </div>
    </div>
</x-backend::layout.main>