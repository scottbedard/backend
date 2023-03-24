<template>
  <div class="flex flex-col min-h-screen">
    <header class="bg-gray-900 flex justify-between p-6 text-gray-100">
      <RouterLink class="flex gap-2 items-center" :to="{ name: 'index' }">
        <ShieldCheckIcon stroke-width="2.1" /> <span class="font-bold tracking-wider">bedard/backend</span>
      </RouterLink>

      <div>
        <a href="/logout">Log out</a>
      </div>
    </header>

    <div class="flex flex-1">
      <aside class="bg-gray-200 text-center w-20">
        ...
      </aside>

      <main
        :class="['flex-1', {
          'p-6': padded,
        }]">
        <slot />
      </main>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ShieldCheckIcon } from '@bedard/vue-lucide'

defineProps<{
  padded?: boolean
}>()
</script>