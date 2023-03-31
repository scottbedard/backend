<template>
  <button class="border-4 border-danger-500 p-6 bg-primary-500 text-white hover:bg-primary-200" @click="count++">
    <u>holy shit <b v-text="count" /></u>
  </button>
</template>

<script lang="ts" setup>
import { ref } from 'vue'

const count = ref(0)
</script>

<style lang="scss">
@import './style';
</style>
