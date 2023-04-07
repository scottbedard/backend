import { createPluginConfig, createTableData, createTableOptions } from '@/utils'

/**
 * Plugin data
 */
export const state = ref({
  config: createPluginConfig(createTableOptions()),
  data: createTableData(),
})
