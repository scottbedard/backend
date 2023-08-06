import { Opaque } from '@bedard/utils'
import { createElement } from 'lucide'

export type LucideIcon = Parameters<typeof createElement>[0]

export type ButtonTheme = 'danger' | 'default' | 'primary' | 'text'

export type Datetime = Opaque<string, 'datetime'>

export type TailwindScreen = 'xs' | 'sm' | 'md' | 'lg' | 'xl' | '2xl'
