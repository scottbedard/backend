<template>
  <i
    :height="size"
    :icon-name="name"
    :width="size" />
</template>

<script lang="ts" setup>
import { createIcons, icons } from 'lucide'

onMounted(() => {
  createIcons({ icons })
})

withDefaults(defineProps<{
  name: string
  size?: number
}>(), {
  size: 24
})
</script>
