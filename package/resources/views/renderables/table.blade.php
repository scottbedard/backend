<div class="border-4 border-primary-500 table text-sm w-full">
    <div class="font-bold table-header-group">
        <div class="table-row">
            @if ($selectable)
                <div class="table-cell">
                    <x-backend::checkbox />
                </div>
            @endif

            @foreach ($columns as $column)
                <div class="table-cell">
                    {{ $column->header }}
                </div>
            @endforeach
        </div>
    </div>

    <div class="table-row-group">
        @foreach ($data['rows'] as $row)
            <a
                class="table-row unstyled odd:bg-gray-100 hover:bg-primary-100 dark:odd:bg-gray-500/30 dark:hover:bg-primary-500/20 dark:hover:bg-opacity-30"
                href="{{ $to($row) }}">
                @if ($selectable)
                    <div class="table-cell">
                        <x-backend::checkbox />
                    </div>
                @endif

                @foreach ($columns as $column)
                    <div class="table-cell">
                        {{ $row->{$column->id} }}
                    </div>
                @endforeach
            </a>
        @endforeach
    </div>
</div>