<template>
  <div>
    
    <!-- desktop -->
    <div class="table w-full">
      <div class="table-row">
        <div
          v-if="options.checkboxes"
          class="table-cell whitespace-nowrap"
          style="width: 0%">
          <div class="flex h-12 items-center justify-end pl-6 pr-3 w-full">
            <Checkbox />
          </div>
        </div>

        <div
          v-for="col in options.schema"
          class="align-middle h-12 table-cell">
          <div class="px-3">
            <span v-text="col.label" class="font-bold" />
          </div>
        </div>
      </div>

      <div
        v-for="item in data.items"
        class="table-row">
        <div
          v-if="options.checkboxes"
          class="border-t border-gray-300 table-cell whitespace-nowrap"
          style="width: 0%">
          <div class="flex h-12 items-center justify-end pl-6 pr-3 w-full">
            <Checkbox />
          </div>
        </div>

        <div
          v-for="col, id in options.schema"
          class="align-middle border-t border-gray-300 h-12 table-cell"
          :key="id">
          <div class="px-3">
            {{ item[id] }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Checkbox } from '@/components'
import { TableData, TableOptions } from '@/types'

defineProps<{
  data: TableData
  options: TableOptions
}>()
</script>
