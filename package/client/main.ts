import '@/style.scss'
import { appElKey } from '@/utils'
import { createApp } from 'vue'
import App from '@/App.vue'

const appEl = document.getElementById('app')

if (appEl) {
  const app = createApp(App)

  app.provide(appElKey, appEl)
  
  app.mount(appEl)
}

console.log('Ready:', window.context)
