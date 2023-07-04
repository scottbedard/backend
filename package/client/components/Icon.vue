<template>
  <span v-html="html" />
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import { createElement, icons } from 'lucide'

const props = defineProps<{
  name: Parameters<typeof createElement>[0]
  size?: number | string
  strokeWidth?: number | string
}>()

const html = computed(() => {
  const svg = props.name ? createElement(props.name) : document.createElement('svg')

  if (props.size) {
    svg.setAttribute('height', props.size.toString())
    svg.setAttribute('width', props.size.toString())
  }

  if (props.strokeWidth) {
    svg.setAttribute('stroke-width', props.strokeWidth.toString())
  }

  return svg.outerHTML
})
</script>
