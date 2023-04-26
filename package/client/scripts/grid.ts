import { currentBreakpoint } from '@/app/store/state'
import { GridSpan, TailwindScreen } from '@/types';
import { Json, parse } from '@bedard/utils'
import { watch } from 'vue'

export default function (el: HTMLElement) {
  watch(currentBreakpoint, screen => {
    el.querySelectorAll(':scope > [data-backend-grid-cell]').forEach(cell => {
      try {
        const json = cell.getAttribute('data-backend-grid-cell') as Json<Record<TailwindScreen, GridSpan>>

        if (json && cell instanceof HTMLElement) {
          const span = parse(json)

          if (screen in span) {
            cell.style.gridColumn =  `span ${span[screen]} / span ${span[screen]}`
          }
        }
      } catch {}
    });
  }, {
    immediate: true,
  })
}
