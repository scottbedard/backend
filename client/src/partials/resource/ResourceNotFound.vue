<template>
  <div>
    <h3 class="font-bold text-2xl">404: Resource not found</h3>

    <p>
      No resource was found with a route matching "{{ routeParam }}".
    </p>
  </div>
</template>

<script lang="ts" setup>
/**
 * Props
 */
defineProps<{
  routeParam: string | null
}>()
</script>
