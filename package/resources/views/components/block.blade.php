<div @class([ $class ])>
    @foreach ($items as $item)
        {{ $item->render() }}
    @endforeach

    {{ $text }}
</div>