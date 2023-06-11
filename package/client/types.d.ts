// export type ButtonTheme = 'primary' | 'danger' | 'default'

// export type FormField = {
//   disabled: boolean
//   id: string
//   label: null | string
//   order: number
//   placeholder?: string
//   span: Record<TailwindScreen, GridSpan>
//   type: string
// }

// export type FormOptions = {
//   fields: FormField[]
// }

// export type GridSpan = 1 | 2 | 3 | 4 | 5 | 6 | 7 | 8 | 9 | 10 | 11 | 12

// export type PluginConfig<T = Record<string, any>> = {
//   options: T
//   path: string
//   plugin: string
// }

export type TableCell = {
  [key: string]: any
  id: string
  label: string
  type:
    | 'date'
    | 'text'
    | 'timeago'
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
  columns: TableCell[]
}

// export type TailwindScreen = 'xs' | 'sm' | 'md' | 'lg' | 'xl' | '2xl'

// export type ToolbarAction = {
//   disabled: boolean | 'checked' | 'not checked'
//   href: string
//   icon: string
//   label: string
//   theme: ButtonTheme
// }