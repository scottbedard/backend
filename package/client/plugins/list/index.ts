import { appElKey } from '@/utils'
import { createApp, h } from 'vue'
import { router } from '@/router'
import { state } from './state'
import Index from '@/plugins/list/Index.vue'

const appEl = document.getElementById('app')

const pluginEl = document.getElementById('list-plugin')

state.value = window.context.data

if (pluginEl) {
 createApp(Index)
    .use(router)
    .provide(appElKey, appEl)
    .mount(pluginEl)
}
