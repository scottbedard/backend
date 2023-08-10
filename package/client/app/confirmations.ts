import { ButtonTheme } from '@/types'
import { createApp } from 'vue'
import Confirmation from '@/components/Confirmation.vue'

type Confirmation = {
  accept: string
  message: string
  theme: ButtonTheme
}

const mount = (data: Confirmation) => {
  const containerEl = document.body.appendChild(document.createElement('div'))

  const app = createApp(Confirmation, {
    ...data,
    onClose() {
      app.unmount()

      containerEl.remove()
    },
    onConfirm() {
      console.log('confirm')
    },
  })

  app.mount(containerEl)
}

document
  .querySelectorAll<HTMLElement>('[data-backend-confirmation]')
  .forEach(confirmationEl => {
    let data: Confirmation = {
      accept: '',
      message: '',
      theme: 'default',
    }
  
    try {
      data = JSON.parse(confirmationEl.dataset.backendConfirmation!)
    } catch {
      console.error('Failed to parse confirmation data', confirmationEl)
      return;
    }

    const eventName = confirmationEl.tagName.toLowerCase() === 'form' ? 'submit' : 'click'

    confirmationEl.addEventListener(eventName, e => {
      e.preventDefault()

      mount(data)
    })
  })
