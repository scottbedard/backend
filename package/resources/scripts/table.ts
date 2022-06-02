export default function (rows: number = 0) {
  return {
    all: false,

    rows: new Array(rows).fill(false),

    paused: false,

    init() {
      // @ts-ignore
      this.$watch('all', this.check(checked => {
        for (let i = 0; i < this.rows.length; i++) {
          this.rows[i] = checked
        }
      }))

      // @ts-ignore
      this.$watch('rows', this.check(() => {
        this.all = !this.rows.includes(false)
      }))
    },

    check(fn: (...args: any[]) => void) {
      return async (...args: any[]) => {
        if (!this.paused) {
          this.paused = true
  
          fn(...args)
  
          // @ts-ignore
          await this.$nextTick()
  
          this.paused = false
        }
      }
    }
  }
}
