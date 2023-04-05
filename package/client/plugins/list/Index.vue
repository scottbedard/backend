<template>
  <section class="flex flex-col h-full">
    <header class="border-2 border-dashed border-gray-500 p-6">
      <Button :icon="PlusIcon" theme="primary">
        Create role
      </Button>
    </header>

    <div class="flex-1 p-6">
      Table

      <div class="border-4 border-dashed border-danger-500 p-6 block">
        <Checkbox v-model="foo">
          Want to do something?
        </Checkbox>
      </div>
      
      <pre class="text-sm">{{ { foo } }}</pre>
    </div>
  </section>
</template>

<script lang="ts" setup>
import { Button, Checkbox } from '@/components'
import { PlusIcon } from '@bedard/vue-lucide'
import { state } from '@/plugins/list/state'

const foo = ref(false)
</script>