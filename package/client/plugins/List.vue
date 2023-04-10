<template>
  <div class="gap-y-6 grid py-6">
    <div class="flex flex-wrap gap-x-6 px-6">
      <Button
        v-for="action in options.actions"
        :href="action.href"
        :icon="action.icon"
        :theme="action.theme">
        {{ action.label }}
      </Button>
    </div>

    <div>
      <Table
        :data="data"
        :options="options" />
    </div>

    <pre class="text-sm">{{ { options } }}</pre>
  </div>
</template>

<script lang="ts" setup>
import { TableData, TableOptions } from '@/types'
import { Button, Table } from '@/components'

defineProps<{
  data: TableData
  options: TableOptions
}>()
</script>
