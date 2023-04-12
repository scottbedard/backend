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
        v-for="row in data.items"
        class="table-row"
        :is="rowHref(row) ? 'a' : 'div'"
        :href="rowHref(row)">
        <div
          v-if="options.checkboxes"
          class="border-t border-gray-300 table-cell whitespace-nowrap"
          style="width: 0%">
          <div class="flex h-12 items-center justify-end pl-6 pr-3 w-full">
            <Checkbox
              :model-value="isChecked(row)"
              @update:model-value="onCheck(row)" />
          </div>
        </div>

        <div
          v-for="col in options.schema"
          class="align-middle border-t border-gray-300 h-12 px-3 table-cell first:pl-6 last:pr-6"
          :key="col.id">
          {{ row[col.id] }}
        </div>
      </Component>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { noop, stubArray } from 'lodash-es'
import { TableData, TableOptions } from '@/types'
import Banner from './Banner.vue'
import Checkbox from './Checkbox.vue'

const emit = defineEmits<{
  (e: 'update:modelValue', payload: any[]): void
}>()

const props = withDefaults(defineProps<{
  data: TableData
  modelValue?: any[]
  options: TableOptions
  rowHref?: (row?: any) => any
}>(), {
  modelValue: stubArray,
  rowHref: noop,
})

const isAllChecked = computed(() => props.modelValue.length === props.data.items.length)

const onAllCheck = () => {
  if (isAllChecked.value) {
    emit('update:modelValue', [])
  } else {
    emit('update:modelValue', props.data.items.slice(0))
  }
}

const isChecked = (row: any) => {
  return Boolean(props.modelValue.includes(row))
}

const onCheck = (row: any) => {
  if (isChecked(row)) {
    props.modelValue.splice(props.modelValue.indexOf(row), 1)
  } else {
    props.modelValue.push(row)
  }
}
</script>
