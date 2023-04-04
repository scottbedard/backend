import type { Router } from 'vue-router'

declare global {
  interface Window {
    context: any
    createPlugin: () => void
    router: Router
  }
}

export {}
