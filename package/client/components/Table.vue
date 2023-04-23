<template>
  <div
    v-if="!options.schema.length"
    class="px-6">
    <Banner
      header="Schema not found"
      icon="sheet">
      Define a <pre class="value">schema</pre> property for this table
      to express how it should render
    </Banner>
  </div>

  <div v-else>
    <!-- desktop -->
    <div class="table w-full">
      <div class="table-row">
        <div
          v-if="options.checkboxes"
          class="table-cell whitespace-nowrap"
          style="width: 0%">
          <div class="flex h-12 items-center justify-end pl-6 pr-3 w-full">
            <Checkbox
              :model-value="isAllChecked" 
              @update:model-value="onAllCheck"/>
          </div>
        </div>

        <div
          v-for="col in options.schema"
          class="align-middle h-12 px-3 table-cell whitespace-nowrap first:pl-6 last:pr-6">
          <span v-text="col.label" class="font-bold" />
        </div>
      </div>

      <Component
        v-for="row in items"
        class="table-row"
        :is="row.href ? 'a' : 'div'"
        :href="row.href">
        <div
          v-if="options.checkboxes"
          class="border-t border-gray-300 table-cell whitespace-nowrap"
          style="width: 0%">
          <div
            class="flex h-12 items-center justify-end pl-6 pr-3 w-full"
            @click.stop.prevent="onCheck(row)">
            <Checkbox
              :model-value="isChecked(row)"
              @update:model-value="onCheck(row)" />
          </div>
        </div>

        <div
          v-for="col in options.schema"
          class="align-middle border-t border-gray-300 h-12 px-3 table-cell first:pl-6 last:pr-6"
          :key="col.id">

          <span
            v-if="col.type === 'date'"
            v-text="format(parseISO(row[col.id]), col.format)" />

          <span
            v-else-if="col.type === 'timeago'"
            v-text="formatDistanceToNow(parseISO(row[col.id]), { addSuffix: true })" />
          
          <span
            v-else
            v-text="row[col.id]" />
        </div>
      </Component>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { format, formatDistanceToNow, parseISO, subDays } from 'date-fns'
import { stubArray } from 'lodash-es'
import { TableData, TableOptions } from '@/types'
import Banner from './Banner.vue'
import Checkbox from './Checkbox.vue'
import { replaceRouteParams } from '@/utils'

const d = subDays(new Date, 5)

const emit = defineEmits<{
  (e: 'update:modelValue', payload: any[]): void
}>()

const props = withDefaults(defineProps<{
  data: TableData
  modelValue?: any[]
  options: TableOptions
}>(), {
  modelValue: stubArray,
})

/**
 * Table items
 */
const items = computed(() => props.data.items.map((item: Record<string, any>) => {
  if (props.options.row_to) {
    item.href = replaceRouteParams(props.options.row_to, item)
  }

  return item
}))

/**
 * Test if all rows are checked
 */
const isAllChecked = computed(() => props.modelValue.length === props.data.items.length)

/**
 * Test if a single row is checked
 */
const isChecked = (row: any) => {
  return Boolean(props.modelValue.includes(row))
}

/**
 * Toggle all rows
 */
const onAllCheck = () => {
  if (isAllChecked.value) {
    emit('update:modelValue', [])
  } else {
    emit('update:modelValue', props.data.items.slice(0))
  }
}

/**
 * Toggle a single row
 */
const onCheck = (row: any) => {
  if (isChecked(row)) {
    props.modelValue.splice(props.modelValue.indexOf(row), 1)
  } else {
    props.modelValue.push(row)
  }
}
</script>

<style lang="scss" scoped>
a.table-row {
  @apply hover:bg-primary-100/50;
}
</style>
