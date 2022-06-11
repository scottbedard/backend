<div
    x-data="table({{ count($data['rows']) }})"
    x-modelable="modelable"
    data-component="table">
    <div class="table text-sm w-full">
        <div
            class="font-bold table-header-group"
            data-table-group="header">
            <div class="h-12 table-row">
                @if ($selectable)
                    <div
                        class="align-middle cursor-pointer table-cell text-right pl-6 pr-3 w-px"
                        @click.stop.prevent="all = !all">
                        <x-backend::checkbox x-model="all" @click.stop />
                    </div>
                @endif

                @foreach ($columns as $column)
                    <div @class([
                        'align-middle table-cell px-3 first:pl-6 last:pr-6' => true,
                        'text-left' => $column->align === 'left',
                        'text-center' => $column->align === 'center',
                        'text-right' => $column->align === 'right',
                    ])>
                        {{ $column->header }}
                    </div>
                @endforeach
            </div>
        </div>

        <div
            class="table-row-group"
            data-table-group="body">
            @foreach ($data['rows'] as $row)
                <a
                    class="h-12 table-row unstyled odd:bg-gray-100 hover:bg-primary-100 dark:odd:bg-gray-500/30 dark:hover:bg-primary-500/20 dark:hover:bg-opacity-30"
                    href="{{ $to($row) }}">
                    @if ($selectable)
                        <div
                            class="align-middle cursor-pointer table-cell text-right pl-6 pr-3 w-px"
                            @click.stop.prevent="rows[{{ $loop->index }}] = !rows[{{ $loop->index }}]">
                            <x-backend::checkbox x-model="rows[{{ $loop->index }}]" @click.stop />
                        </div>
                    @endif

                    @foreach ($columns as $column)
                        <div class="align-middle table-cell px-3 first:pl-6 last:pr-6">
                            <x-backend::renderable :content="$column" :data="$row" />
                        </div>
                    @endforeach
                </a>
            @endforeach
        </div>
    </div>
</div>
