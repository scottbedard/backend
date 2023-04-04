<template>
  <div class="gap-6 grid p-6">
    <div>Hello from the list plugin</div>

    <pre class="text-sm">{{ state }}</pre>
  </div>
</template>

<script lang="ts" setup>
import { state } from '@/plugins/list/state'
</script>