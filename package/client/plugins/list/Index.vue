<template>
  <section class="flex flex-col h-full">
    <header class="border-2 border-dashed border-gray-500 p-6">
      <Button :icon="PlusIcon" theme="primary">
        Create role
      </Button>
    </header>

    <div class="flex-1 p-6">
      <pre class="text-sm">{{ state }}</pre>
    </div>
  </section>
</template>

<script lang="ts" setup>
import { Button, Checkbox } from '@/components'
import { PlusIcon } from '@bedard/vue-lucide'
import { state } from '@/plugins/list/state'

const foo = ref(false)
</script>