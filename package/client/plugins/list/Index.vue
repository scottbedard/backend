<template>
  <section class="flex flex-col h-full">
    <header
      v-if="options.actions.length > 0"
      class="p-6">
      <Button
        v-for="action in options.actions"
        :icon="Icon[action.icon]"
        :theme="action.theme">
        {{ action.label }}
      </Button>
    </header>

    <div class="border-t border-gray-300">
      <Table
        :options="options"
        :data="data" />
    </div>

    <pre class="p-6 text-sm">{{ { options } }}</pre>
  </section>
</template>

<script lang="ts" setup>
import { data, options } from '@/plugins/list/state'
import { Icon, Button, Table } from '@/components'
</script>