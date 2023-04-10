<template>
  <div class="backend-banner">
    <div v-if="header">
      <Icon
        v-if="icon"
        :name="icon" />

      <slot name="header">{{ header }}</slot>
    </div>

    <p>
      <slot />
    </p>
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

<style lang="scss">
.backend-banner {
  @apply border-2 border-gray-300 p-3 rounded-md;

  > div {
    @apply flex font-bold gap-x-2 items-center tracking-wide;
  }

  > p {
    @apply mt-1 text-gray-800 sm:ml-[24px] sm:mt-0 sm:pl-2;
  }
}
</style>
