document
  .querySelectorAll<HTMLElement>('[data-backend-click-filter]')
  .forEach(el => {
    el.addEventListener('click', e => {
      for (let pathEl of e.composedPath()) {
        if (pathEl === el || !(pathEl instanceof HTMLElement)) {
          return
        }

        if ('backendClickStop' in pathEl.dataset) {
          e.stopPropagation()
          return
        }

        if ('backendClickPrevent' in pathEl.dataset) {
          e.preventDefault()
        }
      }
    })
  })
