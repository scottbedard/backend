import alpine from './alpine'

import {
  addDays,
  addMonths,
  differenceInDays,
  endOfMonth,
  endOfWeek, 
  format,
  getDay,
  isSameDay,
  parse, 
  startOfMonth, 
  startOfWeek,
  subMonths,
} from 'date-fns'

/**
 * Date field
 */
export default alpine((value: string, parseStr: string, formatStr) => {
  return {
    expanded: false,

    formatStr,

    parseStr,

    pendingValue: value,

    value,

    init() {
      const component = this.$refs.datefield

      const onBodyClick = (e: MouseEvent) => {
        let el: HTMLElement | null = e.target as HTMLElement

        while (el) {
          if (el === component) return;
          el = el.parentElement
        }

        this.expanded = false
      }

      const onKeydown = (e: KeyboardEvent) => {
        if (e.key === 'Escape') {
          this.expanded = false
        }
      }

      this.$watch('expanded', (expanded) => {
        if (expanded) {
          this.pendingValue = this.value
          
          document.body.addEventListener('click', onBodyClick)
          document.body.addEventListener('keydown', onKeydown)
        } else {
          document.body.removeEventListener('click', onBodyClick)
          document.body.removeEventListener('keydown', onKeydown)
        }
      })
    },

    next() {
      this.pendingValue = format(addMonths(this.pendingDate, 1), this.parseStr)
    },

    prev() {
      this.pendingValue = format(subMonths(this.pendingDate, 1), this.parseStr)
    },

    select(date: Date) {
      this.value = format(date, this.parseStr)
      
      this.pendingValue = format(date, this.parseStr)

      this.expanded = false
    },

    get currentDate() {
      return parse(this.value, this.parseStr, new Date)
    },

    get pendingDate() {
      return parse(this.pendingValue, this.parseStr, new Date)
    },

    get days() {
      const current = new Date(this.currentDate)

      const pending = new Date(this.pendingDate)

      const start = startOfWeek(startOfMonth(pending))

      const end = endOfWeek(endOfMonth(pending))

      const month = [startOfMonth(pending), endOfMonth(pending)]
     
      return new Array(differenceInDays(end, start) + 1).fill(null).map((x, i) => {
        const date = addDays(start, i)

        return {
          lastMonth: date < month[0],
          nextMonth: date > month[1],
          thisMonth: date >= month[0] && date <= month[1],
          selected: isSameDay(date, current),
          date: date.getDate(),
          instance: date,
        }
      })
    },

    get formatted() {
      return format(parse(this.value, this.parseStr, new Date), this.formatStr)
    },

    get headers() {
      const text = [
        'Su',
        'Mo',
        'Tu',
        'We',
        'Th',
        'Fr',
        'Sa',
      ]

      return this.days.slice(0, 7).map((day, i) => text[getDay(day.instance)])
    },

    get month() {
      return format(this.pendingDate, 'MMMM y')
    }
  }
})
