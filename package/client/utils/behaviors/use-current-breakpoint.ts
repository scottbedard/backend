import { computed, ComputedRef } from 'vue'
import { TailwindScreen } from '@/types'
import { entries } from '@bedard/utils'
import { tailwindScreens } from '../constants'
import { useBreakpoints } from '@vueuse/core'

export function useCurrentBreakpoint() {
  const { current } = useBreakpoints(tailwindScreens);

  const breakpoints = current() as ComputedRef<TailwindScreen[]>

  return computed(() => {
    const breakpoint = entries(tailwindScreens)
      .filter(([screen]) => breakpoints.value.includes(screen))
      .sort((a, b) => a[1] - b[1])
      .pop()

    return breakpoint?.[0] ?? 'xs'
  })
}
