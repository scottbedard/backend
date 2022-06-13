import alpine from './alpine'

let id = 0;

/**
 * <x-backend::table>
 * 
 * @see package/resources/views/components/table.blade.php
 */
export default alpine(() => {
  const uid = id++

  return {
    expanded: false,

    id: id++,

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

      this.$watch('expanded', (expanded) => {
        if (expanded) {
          document.body.addEventListener('click', onBodyClick)
        } else {
          document.body.removeEventListener('click', onBodyClick)
        }
      })
    }
  }
})
