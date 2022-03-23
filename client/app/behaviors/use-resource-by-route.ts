import { computed, unref } from 'vue'
import { MaybeRef } from '@vueuse/core'

/**
 * Resource by route
 */
export function useResourceByRoute(route: MaybeRef<string | null>) {
  return computed(() => {
    const normalizedRoute = unref(route)?.trim().toLowerCase()

    return normalizedRoute
      ? (window.context.resources.find(obj => obj.route === normalizedRoute) ?? null)
      : null
  })
}
