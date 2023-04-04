import { appElKey } from '@/utils'
import { createApp } from 'vue'
import { state } from './state'
import List from '@/plugins/list/List.vue'

const appEl = document.getElementById('app')

const pluginEl = document.getElementById('list-plugin')

state.value = window.context.data

if (pluginEl) {
  const app = createApp(List)

  app.provide(appElKey, appEl)
  
  app.mount(pluginEl)
}
