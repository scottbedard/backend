import { createRouter, createWebHistory } from 'vue-router'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      component: () => import('../pages/Index.vue'),
      name: 'index',
      path: '/backend',
    }
  ],
})
