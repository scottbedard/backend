<template>
  <div>
    
    <!-- desktop -->
    <div class="table w-full">
      
      <div class="border-[blue] border-4 table-row">
        <div v-if="options.checkboxes">
          Check!
        </div>

        <div
          v-for="column in options.schema"
          class="border-4 border-danger-500 table-cell">
          {{ column.type }}
        </div>
      </div>
    </div>

    <pre class="text-sm">{{ options }}</pre>
  </div>
</template>

<script lang="ts" setup>
import { TableData, TableOptions } from '@/types'

defineProps<{
  data: TableData
  options: TableOptions
}>()
</script>
