import './index.css'

import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import { routes } from '@/app/routes'
import App from './App.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: routes.map(route => Object.assign(route, {
    path: `/${window.context.path}${route.path}`,
  })),
  scrollBehavior: (_to, _from, savedPosition) => savedPosition ?? { top: 0 },
})

createApp(App)
  .use(router)
  .mount('#backend')
