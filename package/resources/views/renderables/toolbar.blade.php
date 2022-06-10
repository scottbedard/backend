<div @class([
    'flex flex-wrap gap-6' => true,
    'justify-center' => $align === 'center',
    'justify-end' => $align === 'right',
])>
    @foreach ($items as $item)
        {{ $item->render() }}
    @endforeach
</div>