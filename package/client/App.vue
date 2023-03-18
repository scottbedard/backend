<template>
  <div>
    <div>Hello from the Vite application!</div>

    <a href="#" @click.prevent="count++">The count is: {{ count }}</a>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'

const count = ref(0)
</script>