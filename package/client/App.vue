<template>
  <Layout>
    <div class="border-4 border-danger-500 border-dashed m-6 p-6">
      <div ref="containerEl" />
    </div>
  </Layout>
</template>

<script lang="ts" setup>
import Layout from '@/components/Layout.vue'
import axios from 'axios'
import { onMounted, ref } from 'vue'

const containerEl = ref<HTMLElement>()

onMounted(async () => {
  const { data } = await axios.get('/foo')

  if (containerEl.value) {
    containerEl.value.innerHTML = data
  }
})
</script>