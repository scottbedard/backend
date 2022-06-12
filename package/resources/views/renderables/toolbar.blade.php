<div @class([
    'flex flex-wrap gap-6 items-center' => true,
    'justify-center' => $align === 'center',
    'justify-end' => $align === 'right',
    'justify-between' => $align === 'between',
])>
    @foreach ($items as $item)
        {{ $item->render() }}
    @endforeach
</div>
