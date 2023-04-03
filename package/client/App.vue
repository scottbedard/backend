<template>
  <Layout>
    <div ref="contentEl" />
  </Layout>
</template>

<script lang="ts" setup>
import { http } from '@/utils'
import { onMounted, ref } from 'vue'
import Layout from '@/components/Layout.vue'

const contentEl = ref<HTMLElement>()

onMounted(async () => {
  const view = await http.get('/backend/roles')
  
  if (contentEl.value) {
    contentEl.value.innerHTML = <any> view.data
  }
})
</script>