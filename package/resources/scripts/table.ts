import { identity } from 'lodash-es'
import alpine from './alpine'

/**
 * <x-backend::table>
 * 
 * @see package/resources/views/components/table.blade.php
 */
export default alpine((rows: number = 0) => {
  return {
    all: false,

    rows: new Array(rows).fill(false) as boolean[],

    paused: false,

    check(fn: (...args: any[]) => void) {
      return async (...args: any[]) => {
        if (!this.paused) {
          this.paused = true
  
          fn(...args)
  
          await this.$nextTick()
  
          this.paused = false
        }
      }
    },

    init() {
      this.$watch('all', this.check(checked => {
        for (let i = 0; i < this.rows.length; i++) {
          this.rows[i] = checked
        }
      }))

      this.$watch('rows', this.check(() => {
        this.all = !this.rows.includes(false)
      }))
    },

    get modelable() {
      return this.rows.filter(identity).length
    },
  }
})
