<template>
  <div>
    
    <!-- desktop -->
    <div class="table w-full">
      
      <div class="table-row">
        <div
          v-if="options.checkboxes"
          class="border border-[red] table-cell whitespace-nowrap"
          style="width: 0%">
          <div class="flex h-12 items-center justify-end pl-6 pr-3 w-full">
            <Checkbox />
          </div>
        </div>

        <div
          v-for="col in options.schema"
          class="border border-[blue] align-middle h-12 table-cell">
          <div class="px-3">
            <span v-text="col.label" class="font-bold" />
          </div>
        </div>
      </div>
    </div>

    <pre class="text-sm">{{ options }}</pre>
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
