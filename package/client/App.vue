<template>
  <Layout>
    <div ref="containerEl" />
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