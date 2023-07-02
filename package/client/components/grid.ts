import { Json, parse } from '@bedard/utils'
import { sortedScreens } from '@/constants'
import { TailwindScreen } from '@/types'

const gridCellEls = document.querySelectorAll<HTMLElement>('[data-backend-grid-cell]')

const resize = () => {
  const width = window.innerWidth

  let screen: TailwindScreen = 'xs'

  sortedScreens.forEach(([key, value]) => {
    if (width >= value) {
      screen = key
    }
  })

  gridCellEls.forEach(el => {
    try {
      const json = el.getAttribute('data-backend-grid-cell') as Json<Record<TailwindScreen, number>>

      if (json) {
        const span = parse(json)
        
        if (screen in span) {
          el.style.gridColumnEnd = `span ${span[screen]}`
        }
      }
    } catch {}
  })
}

window.addEventListener('resize', resize)

resize()
