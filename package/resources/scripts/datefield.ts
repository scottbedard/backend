import alpine from './alpine'

import {
  addDays,
  differenceInDays,
  endOfMonth,
  endOfWeek, 
  format,
  getDay,
  parse, 
  startOfMonth, 
  startOfWeek,
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

    get date() {
      return parse(this.value, this.parseFormat, new Date)
    },

    get days() {
      const startDate = startOfWeek(startOfMonth(this.date))

      const endDate = endOfWeek(endOfMonth(this.date))

      const month = [startOfMonth(this.date), endOfMonth(this.date)]
     
      const days = new Array(differenceInDays(endDate, startDate) + 1).fill(null).map((x, i) => {
        const date = addDays(startDate, i)

        return {
          lastMonth: date < month[0],
          nextMonth: date > month[1],
          thisMonth: date >= month[0] && date <= month[1],
          date: date.getDate(),
          instance: date,
        }
      })

      return days
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
      return format(this.date, 'MMMM')
    }
  }
})
