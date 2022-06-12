<div
    x-data="table({{ count($data['rows']) }})"
    x-modelable="modelable"
    x-model="checked"
    data-component="table">
    <div class="table text-sm w-full">
        <div
            class="font-bold table-header-group"
            data-table-group="header">
            <div class="h-12 table-row">
                @if ($selectable)
                    <div
                        class="align-middle border-y-2 border-gray-300 cursor-pointer pl-6 pr-3 relative table-cell text-right w-px dark:border-gray-800"
                        @click.stop.prevent="all = !all">
                        <div x-bind:class="all ? 'absolute bg-primary-400 left-0 top-0 h-full w-[3px] dark:bg-primary-600' : 'hidden'"></div>

                        <x-backend::checkbox x-model="all" />
                    </div>
                @endif

                @foreach ($columns as $column)
                    <div @class([
                        'align-middle border-y-2 border-gray-300 table-cell px-3 first:pl-6 last:pr-6 dark:border-gray-800' => true,
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
                            class="align-middle cursor-pointer table-cell text-right pl-6 pr-3 relative w-px"
                            @click.stop.prevent="rows[{{ $loop->index }}] = !rows[{{ $loop->index }}]">
                            <div x-bind:class="rows[{{ $loop->index }}] ? 'absolute bg-primary-400 left-0 top-0 h-full w-[3px] dark:bg-primary-600' : 'hidden'"></div>

                            <x-backend::checkbox x-model="rows[{{ $loop->index }}]" />
                        </div>
                    @endif

                    @foreach ($columns as $column)
                        <div @class([
                            'align-middle table-cell px-3 first:pl-6 last:pr-6' => true,
                            'text-left' => $column->align === 'left',
                            'text-center' => $column->align === 'center',
                            'text-right' => $column->align === 'right',
                        ])>
                            <x-backend::renderable :content="$column" :data="$row" />
                        </div>
                    @endforeach
                </a>
            @endforeach
        </div>
    </div>
</div>
