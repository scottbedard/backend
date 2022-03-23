<template>
  <div>
    Hello from the home controller!

    <pre>{{ { context } }}</pre>
  </div>
</template>

<script lang="ts" setup>
const context = window.context
</script>
