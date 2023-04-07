import { PluginConfig, TableData, TableOptions } from '@/types'

/**
 * Create plugin config
 */
export function createPluginConfig<T>(options: T): PluginConfig<T> {
  return {
    options,
    path: '',
    plugin: '',
  }
}

/**
 * Create table config
 */
export function createTableOptions(): TableOptions {
  return {
    checkboxes: false,
    schema: [],
  }
}

/**
 * Create table data
 */
export function createTableData<T = any>(): TableData<T> {
  return {
    currentPage: 0,
    items: [],
    lastPage: 0,
    perPage: 0,
    total: 0
  }
}
