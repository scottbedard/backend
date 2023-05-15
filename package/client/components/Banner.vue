<template>
  <div class="backend-banner">
    <header v-if="header">
      <Icon
        v-if="icon"
        :name="icon" />

      <slot name="header">{{ header }}</slot>
    </header>

    <div>
      <slot />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { Icon } from '@/components'

const props = defineProps<{
  header?: string
  icon?: string
  message?: string
}>()
</script>
