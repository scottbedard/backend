import { computed } from 'vue'
import { useRoute } from 'vue-router'

/**
 * Route parameter
 */
export function useRouteParam(key: string) {
  const route = useRoute()
  
  return computed<string | null>(() => (route.params[key] as string) ?? null)
}
