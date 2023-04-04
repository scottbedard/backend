import { createRouter, createWebHistory } from 'vue-router'
import { noop } from 'lodash-es'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      component: { render: noop },
      path: '/:pathMatch(.*)*',
    },
  ],
})
