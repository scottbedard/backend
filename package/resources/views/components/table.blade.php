@props([
    'columns' => [],
    'data' => [],
    'selectable' => false,
])

<div
    x-data="table({{ count($data) }})"
    x-modelable="modelable"
    data-component="table"
    {{ $attributes->merge([]) }}>
    <div class="table text-sm w-full">
        <div
            class="font-bold table-header-group"
            data-table-group="header">
            <div class="table-row">
                @if ($selectable)
                    <x-backend::table-header class="w-8">
                        <x-backend::checkbox x-model="all" />
                    </x-backend::table-header>
                @endif

                @foreach ($columns as $column)
                    <x-backend::table-header :align="$column->align">
                        {{ $column->renderHeader() }}
                    </x-backend::table-header>
                @endforeach
            </div>
        </div>
        <div
            class="table-row-group"
            data-table-group="body">
            @foreach ($data as $row)
                <a
                    class="table-row unstyled odd:bg-gray-100 hover:bg-primary-100 dark:odd:bg-gray-600 dark:hover:bg-primary-500 dark:hover:bg-opacity-30"
                    href="javascript:void 0;">
                    @if ($selectable)
                        <x-backend::table-cell>
                            <x-backend::checkbox x-model="rows[{{ $loop->index }}]" />
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
</div>
