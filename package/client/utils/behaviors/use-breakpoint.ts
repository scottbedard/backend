import { useWindowSize } from '@vueuse/core'

const screens = [
  ['xs', 480],
  ['sm', 640],
  ['md', 768],
  ['lg', 1024],
  ['xl', 1280],
  ['2xl', 1536],
] as const

export function useBreakpoint() {
  const { width } = useWindowSize()

  return computed(() => screens.find(([_, size]) => width.value < size)?.[0])
}
