import alpine from './alpine'

export default alpine(() => {
  return {
    expanded: false,

    collapse() {
      this.expanded = false
    },

    expand() {
      this.expanded = true
    },

    init() {
      const component = this.$refs.selectField

      const onBodyClick = (e: MouseEvent) => {
        let el: HTMLElement | null = e.target as HTMLElement

        while (el) {
          if (el === component) return;
          el = el.parentElement
        }

        this.collapse()
      }

      const onKeydown = (e: KeyboardEvent) => {
        if (e.key === 'Escape') this.collapse()
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
    },

    select(i: number) {
      console.log('selecting', i);
    },
  }
})
