<template>
  <RouterLink
    :class="['flex h-14 relative transition-colors hover:bg-blue-100 dark:hover:bg-slate-700', {
      'bg-slate-100 text-blue-500 dark:bg-slate-800 hover:text-blue-600 dark:text-blue-400': active,
      'text-slate-700 hover:text-slate-800 dark:text-slate-200 dark:hover:text-slate-100': !active,
    }]"
    :to="to">
    <div
      :class="['absolute flex h-14 items-center justify-center left-0 top-0 w-16']">
      <Icon
        v-if="icon"
        :name="icon"
        :size="6"
        :stroke="2" />
    </div>

    <div
      v-text="text"
      class="absolute flex h-full items-center left-14 opacity-0 transition-opacity lg:opacity-100" />
  </RouterLink>
</template>

<script lang="ts" setup>
import { Icon } from '@/components'
import { IconName } from '@/app/icons';
import { RouterLink, RouteLocationRaw } from 'vue-router'

/**
 * Props
 */
defineProps<{
  active: boolean
  icon: IconName
  text: string
  to: RouteLocationRaw
}>()
</script>
