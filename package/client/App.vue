<template>
  <Layout>
    <div ref="contentEl" />
  </Layout>
</template>

<script lang="ts" setup>
import { appElKey, setInnerHTML } from '@/utils'
import { inject, ref } from 'vue'
import Layout from '@/components/Layout.vue'

const appEl = inject(appElKey, null as any as HTMLElement)

const contentEl = ref<HTMLElement>()

/**
 * Initialize
 */
onMounted(() => {
  if (!appEl) {
    return
  }

  const view = appEl.dataset.view

  if (contentEl.value && view) {
    setInnerHTML(contentEl.value, view)

    // delete appEl.dataset.view
  }
})
</script>