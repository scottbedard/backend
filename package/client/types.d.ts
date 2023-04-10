export type ButtonTheme = 'primary' | 'danger' | 'default'

export type PluginConfig<T = Record<string, any>> = {
  options: T
  path: string
  plugin: string
}

export type TableCell = {
  id: string
  label: string
  type: string
}

type TableData<T = Record<string, any>> = {
  currentPage: number
  items: T[]
  lastPage: number
  perPage: number
  total: number
}

export type TableOptions = {
  actions: ToolbarAction[]
  checkboxes: boolean
  schema: TableCell[]
}

export type ToolbarAction = {
  href: string
  icon: string
  label: string
  theme: ButtonTheme
}