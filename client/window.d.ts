import type {
	BackendPermission,
	ResourceInfo,
	User,
} from '@/app/types'

import { RequiredKeys } from '@bedard/utils'

export declare global {
	interface Window {
		context: {
			config: any
			path: string
			resources: ResourceInfo[]
			user: RequiredKeys<User, 'backendPermissions'>
		}
	}
}
