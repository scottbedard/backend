<div class="@container">
  {{-- mobile table --}}
  <div class="grid text-sm md:hidden">
    @foreach ($paginator->items() as $index => $item)
      <a
        class="border-t border-gray-300 py-2 px-3 last:border-b hover:bg-primary-300/20"
        href="{{ $hrefs[$index] }}">
        <table class="border-separate border-spacing-y-1">
          @foreach ($columns as $column)
          <tr>
            <td class="pr-6 font-semibold">{{ $column->label }}</td>
            <td>{{ $column->type->render($item) }}</td>
          </tr>
          @endforeach
        </table>
      </a>
    @endforeach
  </div>

  {{-- full table --}}
  <div class="hidden w-full md:table">
    <div class="table-row">
      @if ($checkboxes)
        <div class="align-middle h-14 table-cell px-3 py-2 first:pl-6 last:pr-6">
          <x-backend::checkbox />
        </div>
      @endif

      @foreach ($columns as $column)
        <div
          @class([
            'align-middle font-semibold h-14 table-cell px-3 py-2 first:pl-6 last:pr-6',
            'text-center' => $column->align === 'center',
            'text-right' => $column->align === 'right',
          ])
          data-column="{{ $column->id }}">
          @if ($column->sortable)
            <a
              class="flex gap-x-1 items-center"
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

    @foreach ($paginator->items() as $index => $item)
      <a
        class="table-row group hover:bg-primary-300/20 last:border-b"
        data-backend-click-filter
        href="{{ $hrefs[$index] }}">
        @if ($checkboxes)
          <div
            class="align-middle border-t border-gray-300 h-14 px-3 py-2 table-cell group-last:border-b first:pl-6 last:pr-6 w-14"
            data-backend-click-prevent>
            <x-backend::checkbox data-backend-click-stop />
          </div>
        @endif
      
        @foreach ($columns as $column)
          <div @class([
            'align-middle border-t border-gray-300 h-14 px-3 py-2 table-cell group-last:border-b first:pl-6 last:pr-6',
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
  <div class="flex flex-wrap gap-x-6 gap-y-2 min-h-12 items-center justify-center px-6 py-3 text-center text-sm md:justify-end md:flex-nowrap">
    <div class="w-full md:w-auto">
      Displaying {{ number_format($paginator->firstItem()) }} - {{ number_format($paginator->lastItem()) }} of {{ number_format($paginator->total()) }}
    </div>

    <div class="flex gap-x-2 items-center">
      <a
        @class([
          'p-1 rounded hover:bg-gray-100',
          'text-gray-500' => $paginator->currentPage() > 1,
        ])
        data-paginate-first
        href="{{ $pageUrl(1) }}"
        title="First page">
        <x-backend::icon name="chevrons-left" size="16" />
      </a>

      <a
        @class([
          'p-1 rounded hover:bg-gray-100',
          'text-gray-500' => $paginator->currentPage() > 1,
        ])
        data-paginate-previous
        href="{{ $pageUrl(max(1, $paginator->currentPage() - 1)) }}"
        title="Previous page">
        <x-backend::icon name="chevron-left" size="16" />
      </a>

      <div class="flex items-center justify-between relative rounded hover:bg-gray-100">
        <select
          class="appearance-none bg-transparent cursor-pointer flex-1 h-6 outline-none pl-1.5 pr-6 text-center tracking-wide w-full"
          data-paginate-select
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
        data-paginate-next
        href="{{ $pageUrl(min($paginator->lastPage(), $paginator->currentPage() + 1)) }}"
        title="Next page">
        <x-backend::icon name="chevron-right" size="16" />
      </a>

      <a
        @class([
          'p-1 rounded hover:bg-gray-100',
          'text-gray-500' => $paginator->currentPage() > 1,
        ])
        data-paginate-last
        href="{{ $pageUrl($paginator->lastPage()) }}"
        title="Last page">
        <x-backend::icon name="chevrons-right" size="16" />
      </a>
    </div>
  </div>
</div>
