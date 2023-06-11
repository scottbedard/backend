<template>
  <div>
    <div class="p-6">
      Tables coming soon
    </div>

    <Table
      :data="data"
      :options="options" />
  </div>
</template>

<script lang="ts" setup>
import { Table } from '@/components'
import { TableData, TableOptions } from '@/types'

defineProps<{
  data: TableData
  options: TableOptions
}>()
</script>
