<template>
  <div class="gap-y-6 grid py-6">
    <div class="border border-[red] px-6">
      Header
    </div>

    <div>
      <Table
        :data="data"
        :options="options" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { TableData, TableOptions } from '@/types'
import { Banner, Table } from '@/components'

defineProps<{
  data: TableData
  options: TableOptions
}>()
</script>
