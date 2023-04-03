<template>
  <Layout>
    <div ref="contentEl" />
  </Layout>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import Layout from '@/components/Layout.vue'

const contentEl = ref<HTMLElement>()

onMounted(async () => {
  const view = document.getElementById('app')?.dataset.view
  
  if (contentEl.value && view) {
    contentEl.value.innerHTML = view
  }
})
</script>