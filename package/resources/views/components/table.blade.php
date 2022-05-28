@props([
    'data' => [],
    'schema' => [],
])

<div class="table text-sm">
    <div class="table-header-group">
        <div class="table-row">
            @foreach ($schema as $column)
                <div class="border-y border-gray-300 align-middle h-12 px-6 table-cell tracking-wider dark:border-gray-600">
                    {{ $column->renderHeader() }}
                </div>
            @endforeach
        </div>
    </div>
    <div class="table-row-group">
        @foreach ($data as $row)
            <a
                class="table-row unstyled odd:bg-gray-100 hover:bg-primary-100 dark:odd:bg-gray-600 dark:hover:bg-gray-800"
                href="javascript:void 0;">
                @foreach ($schema as $column)
                    <div class="{{ implode(' ', [
                        'align-middle border-b border-gray-300 h-12 px-6 table-cell dark:border-gray-600',
                        $column->align === 'center' ? 'text-center' : '',
                        $column->align === 'right' ? 'text-right' : '',
                    ]) }}">
                        {{ $column->render($row) }}
                    </div>
                @endforeach
            </a>
        @endforeach
    </div>
</div>
