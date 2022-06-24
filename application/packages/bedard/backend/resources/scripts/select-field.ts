import { debounce } from 'lodash-es'
import alpine from './alpine'
import axios from 'axios';

type Options = {
  data: Record<string, any>[]
  display: string
  handler: string
  key: string
  placeholder: string
  value: any
}

export default alpine((options: Options) => {
  return {
    data: options.data,

    display: options.display,

    expanded: false,

    key: options.key,

    placeholder: options.placeholder,

    search: '',

    value: options.value,

    close() {
      this.expanded = false
    },

    get displayValue() {
      const selected = this.data.find(obj => obj[this.key] === this.value) ?? null;

      return selected?.[this.display] ?? this.placeholder ?? ''
    },

    get empty() {
      return this.data.length === 0
    },

    init() {
      const component = this.$refs.selectField

      const onBodyClick = (e: MouseEvent) => {
        let el: HTMLElement | null = e.target as HTMLElement

        while (el) {
          if (el === component) return;
          el = el.parentElement
        }

        this.close()
      }

      const onKeydown = (e: KeyboardEvent) => {
        if (e.key === 'Escape') this.close()
      }

      this.$watch('expanded', (expanded) => {
        if (expanded) {
          document.body.addEventListener('click', onBodyClick)
          document.body.addEventListener('keydown', onKeydown)
        } else {
          document.body.removeEventListener('click', onBodyClick)
          document.body.removeEventListener('keydown', onKeydown)
        }
      })

      this.$watch('search', debounce(async (val) => {
        const { data } = await axios.get(options.handler, {
          params: {
            id: this.key,
            search: this.search,
          },
        })

        this.data = data
      }, 100))
    },

    open() {
      this.expanded = true
    },

    select(value: number) {
      this.value = value

      this.close();
    },
  }
})
