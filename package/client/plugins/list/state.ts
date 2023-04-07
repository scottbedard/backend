import { createTableData, createTableOptions } from '@/utils'

/**
 * Plugin data
 */
export const state = ref({
  config: createTableOptions(),
  data: createTableData(),
})
