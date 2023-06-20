<div class="table w-full">
  <div class="table-row">
    @foreach ($columns as $column)
      <div
        @class([
          'font-semibold table-cell px-3 py-2 first:pl-6 last:pr-6',
          'text-center' => $column->align === 'center',
          'text-right' => $column->align === 'right',
        ])
        data-column="{{ $column->id }}">
        @if ($column->sortable)
          <a
            @class([
              'flex gap-x-1 items-center'
            ])
            href="{{ $column->sortHref }}">
            {{ $column->label }}

            @if ($column->sort->direction === 1)
              <x-backend::icon
                data-sort="asc"
                name="chevron-up"
                size="18" />
            @elseif ($column->sort->direction === -1)
              <x-backend::icon
                data-sort="desc"
                name="chevron-down"
                size="18" />
            @endif
          </a>
        @else
          {{ $column->label }}
        @endif
      </div>
    @endforeach
  </div>

  @foreach ($paginator->items as $item)
    <a
      class="table-row hover:bg-gray-100/50"
      href="javascript:;">
      @foreach ($columns as $column)
        <div @class([
          'align-middle border-t border-gray-300 h-12 px-3 py-2 table-cell first:pl-6 last:pr-6',
          'text-center' => $column->align === 'center',
          'text-right' => $column->align === 'right',
        ])>
          {{ $column->type->render($item) }}
        </div>
      @endforeach
    </a>
  @endforeach
</div>
