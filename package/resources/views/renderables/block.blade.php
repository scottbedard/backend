<div @class([
    $class => true,
    'flex gap-6' => $spaced,
])>
    @foreach ($items as $item)
        {{ $item->render() }}
    @endforeach

    {{ $text }}
</div>