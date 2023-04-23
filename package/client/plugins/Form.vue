<template>
  <div class="gap-6 grid p-6">
    <div>Hello from the form plugin!</div>

    <pre>{{ { options } }}</pre>
  </div>
</template>

<script lang="ts" setup>
import { FormOptions } from '@/types'

defineProps<{
  options: FormOptions
}>()
</script>