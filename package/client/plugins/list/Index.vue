<template>
  <section class="flex flex-col h-full">
    <header class="border-2 border-dashed border-gray-500 p-6">
      <Button :icon="PlusIcon" theme="primary">
        Create role
      </Button>
    </header>

    <Table
      :options="state.config.options"
      :data="state.data" />
  </section>
</template>

<script lang="ts" setup>
import { Button, Table } from '@/components'
import { PlusIcon } from '@bedard/vue-lucide'
import { state } from '@/plugins/list/state'
</script>