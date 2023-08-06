<template>
  <i
    :data-lucide="name"
    :height="size"
    :width="size" />
</template>

<script lang="ts" setup>
import { createElement } from 'lucide'

const props = withDefaults(defineProps<{
  name: Parameters<typeof createElement>[0]
  size?: number | string
}>(), {
  size: 24,
})
</script>
