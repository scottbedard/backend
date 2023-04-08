import { kebabCase, trimEnd } from 'lodash-es'
import * as Lucide from '@bedard/vue-lucide'

export const Icon = Object.entries(Lucide).reduce<Record<string, any>>((acc, [name, i]) => {
  acc[trimEnd(kebabCase(name), '-icon')] = i
  return acc
}, {})

export { default as Button } from './Button.vue'
export { default as Checkbox } from './Checkbox.vue'
export { default as Layout } from './Layout.vue'
export { default as Table } from './Table.vue'
