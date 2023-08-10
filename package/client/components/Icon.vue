<template>
  <i
    :data-lucide="name"
    :height="size"
    :width="size" />
</template>

<script lang="ts" setup>
import { createElement, createIcons, icons } from 'lucide'
import { onMounted } from 'vue'

const props = withDefaults(defineProps<{
  name: Parameters<typeof createElement>[0]
  size?: number | string
}>(), {
  size: 18,
})

onMounted(() => createIcons({ icons }))
</script>
