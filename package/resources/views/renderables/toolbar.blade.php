<div class="flex gap-6 p-6">
    @foreach ($items as $item)
        {{ $item->render() }}
    @endforeach
</div>