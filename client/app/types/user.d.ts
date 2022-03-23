import { BackendPermission } from './backend-permissionrmission'

export type User = {
  email: string
  id: number
  backendPermissions?: BackendPermission[]
}