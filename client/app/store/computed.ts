import { computed } from 'vue'
import { user } from './state'

/**
 * Test if user is a super-admin
 */
console.log(user.value);
export const isSuper = computed(() => true /* user.value.backendPermissions.some(obj => obj.key === 'super') */)
