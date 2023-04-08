import { createPluginConfig, createTableData, createTableOptions } from '@/utils'

/**
 * Plugin data
 */
export const state = ref({
  config: createPluginConfig(createTableOptions()),
  data: createTableData(),
})

/**
 * Data
 */
export const data = computed(() => state.value.data)

/**
 * Options
 */
export const options = computed(() => state.value.config.options)