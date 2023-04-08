<template>
  <Component
    :class="['be-btn', {
      'be-btn-danger': theme === 'danger',
      'be-btn-default': theme === 'default',
      'be-btn-primary': theme === 'primary',
    }]"
    :is="to ? RouterLink : 'button'"
    :to="to">
    <Component v-if="icon" :is="icon" :size="18" />

    <slot />
  </Component>
</template>

<script lang="ts" setup>
import { ButtonTheme } from '@/types'
import { RouterLink, RouteLocationRaw } from 'vue-router';

defineProps<{
  icon?: ReturnType<typeof defineComponent>
  theme?: ButtonTheme
  to?: RouteLocationRaw
}>()
</script>

<style lang="scss">
.be-btn {
  @apply inline-flex font-bold gap-x-2 h-11 items-center rounded-md text-sm text-gray-100 tracking-wide px-4;

  > svg {
    @apply w-5;
  }

  &.be-btn-default {
    @apply bg-gray-300 text-gray-900 hover:bg-gray-300/90 hover:text-black;
  }

  &.be-btn-danger {
    @apply bg-danger-600 hover:bg-danger-600/90 hover:text-white;
  }
  
  &.be-btn-primary {
    @apply bg-primary-600 hover:bg-primary-600/90 hover:text-white;
  }
}
</style>
