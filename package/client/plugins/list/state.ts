import { createTableData, createTableConfig } from '@/utils'

/**
 * Plugin data
 */
export const state = ref({
  config: createTableConfig(),
  data: createTableData(),
})
