<template>
  <DefaultLayout>
    <div>Hello from the Vite application!</div>
    <button @click="counter++">count is: {{ counter }}</button>
  </DefaultLayout>
</template>

<script lang="ts" setup>
const counter = ref(0)
</script>