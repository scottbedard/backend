import '@/style.scss'
import { appElKey } from '@/utils'
import { createApp } from 'vue'
import { router } from './router'
import App from '@/App.vue'

const appEl = document.getElementById('app')

if (appEl) {
  createApp(App)
    .use(router)
    .provide(appElKey, appEl)
    .mount(appEl)
}
