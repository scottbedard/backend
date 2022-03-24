import { RouteRecordRaw } from 'vue-router'

/**
 * Backend routes
 */
export const routes: RouteRecordRaw[] = [
  {
    component: () => import('@/controllers/Home.vue'),
    name: 'home',
    path: '/',
  },

  {
    component: () => import('@/controllers/Resource.vue'),
    name: 'resource',
    path: '/resource/:route',
  },
]
