<template>
  <span v-html="svg?.outerHTML" />
</template>
<script lang="ts" setup>
import { computed, watchEffect } from 'vue'
import { createElement } from 'lucide'
import { IconName, icons } from '@/app/icons'

/**
 * Props
 */
const props = withDefaults(defineProps<{
  fill?: string
  inline?: boolean
  name: IconName
  size?: number | string
  stroke?: number | string
}>(), {
  size: 5,
  stroke: 2,
})

/**
 * SVG
 */
const svg = computed(() => {
  if (icons[props.name]) {
    return createElement(icons[props.name])
  }

  console.error(`Missing lucide icon "${props.name}"`)
})

/**
 * Size
 */
const sizePx = computed(() => String(Number(props.size) * 4))

/**
 * Sync svg attributes
 */
watchEffect(() => {
  if (props.inline) {
    svg.value?.classList.add('inline')
  }
  
  if (props.fill) {
    svg.value?.setAttribute('fill', props.fill)
  }
  
  svg.value?.setAttribute('height', sizePx.value)
  svg.value?.setAttribute('width', sizePx.value)
  svg.value?.setAttribute('stroke-width', String(props.stroke))
})
</script>