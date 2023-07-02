import { entries } from '@bedard/utils'
import { TailwindScreen } from './types'

const screens: Record<TailwindScreen, number> = {
  xs: 480,
  sm: 640,
  md: 768,
  lg: 1024,
  xl: 1280,
  '2xl': 1536,
}

export const sortedScreens = entries(screens).sort((a, b) => a[1] - b[1])
