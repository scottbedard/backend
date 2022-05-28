@props([
    'data' => [],
    'schema' => [],
])

<div class="table">
    <div class="table-header-group">
        <div class="table-row">
            @foreach ($schema as $column)
                <div class="border border-black px-6 table-cell tracking-wide">
                    {{ $column->renderHeader() }}
                </div>
            @endforeach
        </div>
    </div>
    <div class="table-row-group">
        @foreach ($data as $row)
            <a class="table-row odd:bg-gray-100 dark:odd:bg-gray-600" href="javascript:void 0;">
                @foreach ($schema as $column)
                    <div class="{{ implode(' ', [
                        'table-cell',
                        $column->align === 'center' ? 'text-center' : '',
                        $column->align === 'right' ? 'text-right' : '',
                    ]) }}">
                        <div class="flex h-12 items-center px-6">
                            {{ $column->render($row) }}
                        </div>
                    </div>
                @endforeach
            </a>
        @endforeach
    </div>
</div>
