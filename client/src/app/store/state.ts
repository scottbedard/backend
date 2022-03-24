import { ref } from 'vue'
import { useDark } from '@vueuse/core'

/**
 * Dark
 */
export const isDark = useDark({ selector: 'html' })

/**
 * User
 */
export const user = ref(window.context.user)
