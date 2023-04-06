type PluginConfig<T = Record<string, any>> = {
  options: T
  path: string
  plugin: string
}

type TableCell = {
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
  checkboxes: boolean
  schema: TableCell[]
}