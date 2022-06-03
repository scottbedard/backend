import { identity } from 'lodash-es'
import alpine from './alpine'

/**
 * <x-backend::table>
 * 
 * @see package/resources/views/components/table.blade.php
 */
export default alpine((count: number = 0) => {
  const arr = (checked: boolean): boolean[] => new Array(count).fill(checked)
  
  return {
    all: false,

    rows: arr(false),

    paused: false,

    async check(fn: () => any) {
      if (!this.paused) {
        this.paused = true

        fn()

        await this.$nextTick()

        this.paused = false
      }
    },

    init() {
      this.$watch('all', async checked => {
        this.check(() => {
          this.rows.splice(0, count, ...arr(checked))
        })
      })

      this.$watch('rows', async rows => {
        this.check(() => {
          this.all = !rows.includes(false)
        })
      })
    },

    get modelable() {
      return this.rows.filter(identity).length
    },
  }
})
