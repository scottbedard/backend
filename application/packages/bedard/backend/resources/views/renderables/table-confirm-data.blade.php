@foreach ($rows as $row)
    <input
        class="hidden"
        name="models[]"
        type="checkbox"
        value="{{ $row->{$resource::$modelKey} }}"
        :checked="checked[{{ $loop->index }}]" />
@endforeach
