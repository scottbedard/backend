import { once } from 'lodash-es'

const messageEl = document.getElementById('backend-flash-message')

if (messageEl) {
  const dismiss = once(() => {
    messageEl.remove()
  })
  
  setTimeout(dismiss, 5000)
  
  messageEl.addEventListener('click', dismiss)
}
