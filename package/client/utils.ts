import { Datetime } from '@/types'

/**
 * Validate datetime string as `yyyy-mm-dd hh:mm:ss`
 */
export function datetime(value?: string) {
  if (value?.match(/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/)) {
    return value as Datetime
  }

  const d = new Date()

  return `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()} ${d.getHours()}:${d.getMinutes()}:${d.getSeconds()}` as Datetime
}
