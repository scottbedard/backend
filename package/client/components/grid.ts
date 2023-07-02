import { Json, parse } from '@bedard/utils'
import { sortedScreens } from '@/constants'
import { TailwindScreen } from '@/types'

const gridCellEls = document.querySelectorAll<HTMLElement>('[data-backend-grid-cell]')

const resize = () => {
  const width = window.innerWidth

  let screen: TailwindScreen | null = null

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
        
        if (screen && screen in span) {
          el.style.gridColumn = `span ${span[screen]} / span ${span[screen]}`
        } else {
          el.style.gridColumn = '1 / -1'
        }
      }
    } catch {}
  })
}

window.addEventListener('resize', resize)

resize()
