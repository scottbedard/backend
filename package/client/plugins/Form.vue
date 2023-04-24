<template>
  <div class="gap-6 grid p-6">
    <div class="border border-[red] gap-6 grid grid-cols-12">
      <div
        v-for="field in options.fields"
        class="border border-[blue] col-span-6">
        {{ field.id }}
      </div>
    </div>

    <pre>{{ { bp, options } }}</pre>
  </div>
</template>

<script lang="ts" setup>
import { FormOptions } from '@/types'
import { useBreakpoint } from '@/utils'

const bp = useBreakpoint()

defineProps<{
  options: FormOptions
}>()
</script>