@props([
    'columns' => [],
    'data' => [],
    'selectable' => false,
])

<div class="table text-sm">
    <div class="table-header-group">
        <div class="table-row">
            @if ($selectable)
                <x-backend::table-header>
                    <x-backend::checkbox />
                </x-backend::table-header>
            @endif

            @foreach ($columns as $column)
                <x-backend::table-header :align="$column->align">
                    {{ $column->renderHeader() }}
                </x-backend::table-header>
            @endforeach
        </div>
    </div>
    <div class="table-row-group">
        @foreach ($data as $row)
            <a
                class="table-row unstyled odd:bg-gray-100 hover:bg-primary-100 dark:odd:bg-gray-600 dark:hover:bg-gray-800"
                href="javascript:void 0;">
                @if ($selectable)
                    <x-backend::table-cell>
                        <x-backend::checkbox />
                    </x-backend::table-cell>
                @endif

                @foreach ($columns as $column)
                    <x-backend::table-cell :align="$column->align">
                        {{ $column->render($row) }}
                    </x-backend::table-cell>
                @endforeach
            </a>
        @endforeach
    </div>
</div>
