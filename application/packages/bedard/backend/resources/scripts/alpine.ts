import { Properties } from '@bedard/utils'

type AlpineData<T extends Record<string, any>> = {
  [P in keyof T]: P extends Properties<T>
    ? T[P]
    : ((this: AlpineContext<T> & T, ...args: any[]) => void)
}

type AlpineContext<T extends Record<string, any>> = {
  $refs: Record<string, HTMLElement>
  $nextTick: () => Promise<void>
  $watch: <U extends Properties<T>>(key: U, fn: (val: T[U], oldVal: T[U]) => void) => void
}

/**
 * Alpine wrapper
 */
export default <T extends Record<string, any>>(data: AlpineData<T> | ((...args: any[]) => AlpineData<T>)) => data
