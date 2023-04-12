<template>
  <div class="gap-y-6 grid py-6">
    <div class="flex flex-wrap gap-x-6 px-6">
      <Button
        v-for="action in options.actions"
        :disabled="disabled(action)"
        :href="action.href"
        :icon="action.icon"
        :theme="action.theme">
        {{ action.label }}
      </Button>
    </div>

    <div class="border-t border-gray-300">
      <Table
        v-model="checked"
        :data="data"
        :options="options"
        :row-href="rowHref" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { TableData, TableOptions, ToolbarAction } from '@/types'
import { Button, Table } from '@/components'

const props = defineProps<{
  data: TableData
  options: TableOptions
}>()

const checked = ref<any[]>([])

const disabled = (action: ToolbarAction) => {
  if (action.disabled === 'checked') {
    return checked.value.length > 0
  }

  if (action.disabled === 'not checked') {
    return checked.value.length === 0
  }

  return action.disabled
}

const rowHref = (row: any) => props.options.row_href.replace('{id}', row.id)
</script>
