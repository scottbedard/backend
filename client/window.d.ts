import type {
	BackendPermission,
	Resource,
	User,
} from '@/app/types'

import { RequiredKeys } from '@bedard/utils'

export declare global {
	interface Window {
		context: {
			path: string
			resources: Resource[]
			user: RequiredKeys<User, 'backendPermissions'>
		}
	}
}
