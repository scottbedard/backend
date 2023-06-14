<div class="table w-full">
  <div class="table-row">
    @foreach ($columns as $column)
      <div @class([
        'font-semibold table-cell px-3 py-2 first:pl-6 last:pr-6',
        'text-center' => $column->align === 'center',
        'text-right' => $column->align === 'right',
      ])>{{--
    --}}{{ $column['label'] }}{{--
  --}}</div>
    @endforeach
  </div>

  @foreach ($paginator->items as $item)
    <a
      class="table-row hover:bg-gray-100/50">
      @foreach ($columns as $column)
        <div @class([
          'align-middle border-t border-gray-300 h-12 px-3 py-2 table-cell first:pl-6 last:pr-6',
          'text-center' => $column->align === 'center',
          'text-right' => $column->align === 'right',
        ])>{{--
      --}}{{ $column->type->render($item) }}{{--
    --}}</div>
      @endforeach
    </a>
  @endforeach

  {{-- <div
    v-for="row in data.items"
    class="table-row">
    <div
      v-for="column in options.columns"
      class="table-cell px-3 first:pl-6 last:pr-6">

      <span
        v-if="column.type === 'date'"
        v-text="format(parseISO(row[column.id]), column.format ?? 'LLLL Mo, yyyy')" />

      <span
        v-else-if="column.type === 'timeago'"
        v-text="formatDistanceToNow(parseISO(row[column.id]), { addSuffix: true })" />

      <span
        v-else
        v-text="row[column.id]" />
    </div>
  </div> --}}
</div>
