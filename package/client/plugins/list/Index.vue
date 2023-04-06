<template>
  <section class="flex flex-col h-full">
    <header class="p-6">
      <Button :icon="PlusIcon" theme="primary">
        Create role
      </Button>
    </header>

    <div class="border-t border-gray-300">
      <Table
        :options="state.config.options"
        :data="state.data" />
    </div>
  </section>
</template>

<script lang="ts" setup>
import { Button, Table } from '@/components'
import { PlusIcon } from '@bedard/vue-lucide'
import { state } from '@/plugins/list/state'
</script>