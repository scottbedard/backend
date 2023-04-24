<template>
  <div class="gap-6 grid p-6">
    <div class="gap-6 grid grid-cols-12">
      <div
        v-for="field in options.fields"
        class="col-span-6 flex flex-wrap gap-y-1 items-end"
        :style="{
          gridColumn: `span ${breakpoint ? field.span[breakpoint] : 1} / span ${field.span[breakpoint]}`
        }">
        <label
          v-text="field.label"
          class="be-label w-full"
          :for="field.id" />
          
        <div class="w-full">
          <input
            class="be-input"
            :id="field.id"
            :placeholder="field.placeholder"
            :type="field.type" />
        </div>
      </div>
    </div>

    <pre class="text-xs">{{ options }}</pre>
  </div>
</template>

<script lang="ts" setup>
import { FormOptions } from '@/types'
import { useCurrentBreakpoint } from '@/utils'

defineProps<{
  options: FormOptions
}>()

const breakpoint = useCurrentBreakpoint()
</script>