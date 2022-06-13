import alpine from './alpine'

import {
  addDays,
  addMonths,
  differenceInDays,
  endOfMonth,
  endOfWeek, 
  format,
  getDay,
  parse, 
  startOfMonth, 
  startOfWeek,
  subMonths,
} from 'date-fns'

/**
 * Date field
 */
export default alpine((value: string, parseFormat: string) => {
  return {
    expanded: false,

    parseFormat: parseFormat,

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

        this.value = value
      }

      this.$watch('expanded', (expanded) => {
        if (expanded) {
          document.body.addEventListener('click', onBodyClick)
        } else {
          document.body.removeEventListener('click', onBodyClick)
        }
      })
    },

    next() {
      this.value = format(addMonths(this.date, 1), this.parseFormat)
    },

    prev() {
      this.value = format(subMonths(this.date, 1), this.parseFormat)
    },

    get date() {
      return parse(this.value, this.parseFormat, new Date)
    },

    get days() {
      const start = startOfWeek(startOfMonth(this.date))

      const end = endOfWeek(endOfMonth(this.date))

      const month = [startOfMonth(this.date), endOfMonth(this.date)]
     
      return new Array(differenceInDays(end, start) + 1).fill(null).map((x, i) => {
        const date = addDays(start, i)

        return {
          lastMonth: date < month[0],
          nextMonth: date > month[1],
          thisMonth: date >= month[0] && date <= month[1],
          date: date.getDate(),
          instance: date,
        }
      })
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
      return format(this.date, 'MMMM y')
    }
  }
})
