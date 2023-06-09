<template>
  <i
    :data-lucide="name"
    :height="size"
    :width="size" />
</template>

<script lang="ts" setup>
import { createIcons, icons } from 'lucide'
import { onMounted } from 'vue'

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
