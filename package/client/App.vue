<template>
  <Layout>
    <div class="h-full" ref="contentEl" />
  </Layout>
</template>

<script lang="ts" setup>
import { appElKey, setInnerHTML } from '@/utils'
import { Layout } from '@/components'
import { useRoute } from 'vue-router'
import axios from 'axios'

const appEl = inject(appElKey, null as any as HTMLElement)
const contentEl = ref<HTMLElement>()
const route = useRoute()

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
  }
})

/**
 * Watch for route changes
 */
watch(route, async (currentRoute) => {
  const res = await axios.get(currentRoute.path, {
    headers: {
      'X-Backend-Data': true,
    },
  })
  
  console.log(currentRoute.path, { res })
})
</script>