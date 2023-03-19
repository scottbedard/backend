import './style.scss'
import { createApp } from 'vue'
import { router } from '@/app/router'
import App from './App.vue'

createApp(App)
  .use(router)
  .mount('#app')
