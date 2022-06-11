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
        @foreach ($data as $row)
            <div class="table-row">
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
            </div>
        @endforeach
    </div>
</div>