import { createRouter, createWebHistory } from 'vue-router'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      component: () => import('../pages/Index.vue'),
      name: 'index',
      path: '/backend',
    },
    {
      component: () => import('../pages/Page.vue'),
      name: 'page',
      path: '/backend/:pathMatch(.*)*',
    },
    {
      component: () => import('../pages/404.vue'),
      name: '404',
      path: '/404',
    },
  ],
})
