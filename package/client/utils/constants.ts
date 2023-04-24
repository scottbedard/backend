import { InjectionKey } from 'vue'
import { TailwindScreen } from '@/types'

/**
 * Injection key for the app element
 */
export const appElKey = Symbol() as InjectionKey<HTMLElement>

/**
 * Tailwind breakpoints
 */
export const tailwindScreens: Record<TailwindScreen, number> = {
  'xs': 480,
  'sm': 640,
  'md': 768,
  'lg': 1024,
  'xl': 1280,
  '2xl': 1536,
}
