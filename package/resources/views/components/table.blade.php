<div>
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

    @foreach ($paginator->items() as $item)
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

  {{-- pagination controls --}}
  <div class="flex flex-wrap gap-x-6 gap-y-2 min-h-12 items-center justify-center px-6 py-2 text-center text-sm md:justify-end md:flex-nowrap">
    <div class="w-full md:w-auto">
      Displaying {{ number_format($paginator->firstItem()) }} - {{ number_format($paginator->lastItem()) }} of {{ number_format($paginator->total()) }}
    </div>

    <div class="flex gap-x-2 items-center">
      <a
        @class([
          'p-1 rounded hover:bg-gray-100',
          'text-gray-500' => $paginator->currentPage() > 1,
        ])
        href="{{ $pageUrl(1) }}"
        title="First page">
        <x-backend::icon name="chevrons-left" size="16" />
      </a>

      <a
        @class([
          'p-1 rounded hover:bg-gray-100',
          'text-gray-500' => $paginator->currentPage() > 1,
        ])
        href="{{ $pageUrl(max(1, $paginator->currentPage() - 1)) }}"
        title="Previous page">
        <x-backend::icon name="chevron-left" size="16" />
      </a>

      <div class="flex items-center justify-between relative rounded hover:bg-gray-100">
        <select
          class="appearance-none bg-transparent cursor-pointer flex-1 h-6 outline-none pl-1.5 pr-6 text-center tracking-wide w-full"
          title="Current page"
          onchange="window.location.href = window.location.href.replace(/page=\d/i, 'page=' + this.value)">
          @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <option
              @if ($i === $paginator->currentPage())
                selected
              @endif
              value="{{ $i }}">
              {{ number_format($i) }}
            </option>
          @endfor
        </select>

        <x-backend::icon
          class="absolute pointer-events-none top-1/2 right-[2px] -translate-y-1/2"
          name="chevron-down"
          size="16" />
      </div>
      
      <a
        @class([
          'p-1 rounded hover:bg-gray-100',
          'text-gray-500' => $paginator->currentPage() > 1,
        ])
        href="{{ $pageUrl(min($paginator->lastPage(), $paginator->currentPage() + 1)) }}"
        title="Next page">
        <x-backend::icon name="chevron-right" size="16" />
      </a>

      <a
        @class([
          'p-1 rounded hover:bg-gray-100',
          'text-gray-500' => $paginator->currentPage() > 1,
        ])
        href="{{ $pageUrl($paginator->lastPage()) }}"
        title="Last page">
        <x-backend::icon name="chevrons-right" size="16" />
      </a>
    </div>
  </div>
</div>
