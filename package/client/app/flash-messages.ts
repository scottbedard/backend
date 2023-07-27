import { once } from 'lodash-es'

export function flashMessages() {
  const messageEl = document.getElementById('backend-flash-message')

  if (!messageEl) {
    return
  }

  const dismiss = once(() => {
    messageEl.remove()
  })

  setTimeout(dismiss, 5000)

  messageEl.addEventListener('click', dismiss)
}
