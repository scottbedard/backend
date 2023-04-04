<template>
  <button
    :class="['be-btn', {
      'be-btn-danger': theme === 'danger',
      'be-btn-primary': theme === 'primary',
    }]">
    <Component v-if="icon" :is="icon" />

    <slot />
  </button>
</template>

<script lang="ts" setup>
import { defineComponent } from 'vue'

defineProps<{
  icon?: ReturnType<typeof defineComponent>
  theme?: 'default' | 'primary' | 'danger'
}>()
</script>

<style lang="scss">
.be-btn {
  @apply bg-gray-400 flex font-bold gap-x-2 h-12 items-center rounded-md text-sm text-white tracking-wide px-4 hover:bg-gray-400/80;

  > svg {
    @apply w-5;
  }
  
  &.be-btn-primary {
    @apply bg-primary-500 hover:bg-primary-500/80;
  }
}
</style>
