import type { Icon } from '@/app/icons'

export type ResourceInfo = {
  className: string
  icon: Icon | null
  model: string
  order: number
  route: string
  title: string
}
