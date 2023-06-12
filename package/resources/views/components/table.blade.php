<div class="border border-danger-500 table w-full">
  <div class="table-row">
    @foreach ($columns as $column)
      <div class="table-cell px-3 first:pl-6 last:pr-6">
        {{ $column['label'] }}
      </div>
    @endforeach
  </div>

  @foreach ($paginator->items as $item)
    <div class="table-row">
      @foreach ($columns as $column)
        <div class="h-12 p-3 table-cell first:pl-6 last:pr-6 border border-[blue]">
          {{ data_get($item, $column['id']) }}
        </div>
      @endforeach
    </div>
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
