<template>
  <div>
    <div class="border border-danger-500 table w-full">
      <div class="table-row">
        <div
          v-for="column in options.columns"
          class="table-cell px-3 first:pl-6 last:pr-6">
          {{ column.label }}
        </div>
      </div>

      <div
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
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { format, formatDistanceToNow, parseISO } from 'date-fns'
import { TableData, TableOptions } from '@/types'

defineProps<{
  data: TableData
  options: TableOptions
}>()
</script>
