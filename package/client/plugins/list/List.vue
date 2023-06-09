<template>
  <div class="gap-y-6 grid py-6">
    <pre>{{ { columns, models } }}</pre>
  </div>
</template>

<script lang="ts" setup>
const props = defineProps<{
  columns: any
  models: any
}>()
</script>
