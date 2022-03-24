import { MaybeRef } from '@vueuse/core'
import { computed, unref } from 'vue'

/**
 * Use resource
 */
export function useResource(route: MaybeRef<string>) {
  return computed(() => {
    const normalizedRoute = unref(route).trim().toLowerCase()

    return window.context.resources.find(obj => obj.route === normalizedRoute)
  })
}
