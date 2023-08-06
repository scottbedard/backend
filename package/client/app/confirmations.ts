import { ButtonTheme } from '@/types'
import { createApp } from 'vue'
import Confirmation from '@/components/confirmation.vue'

type Confirmation = {
  accept: string
  message: string
  theme: ButtonTheme
}

document
  .querySelectorAll<HTMLElement>('[data-backend-confirmation]')
  .forEach(confirmationEl => {
    // parse confirmation data
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

    // mount the confirmation app with a teardown function
    const containerEl = document.createElement('div')

    const app = createApp(Confirmation, {
      ...data,
      onClose: () => {
        app.unmount()

        containerEl.remove()
      },
    })

    const eventName = confirmationEl.tagName.toLowerCase() === 'FORM' ? 'submit' : 'click'

    confirmationEl.addEventListener(eventName, e => {
      e.preventDefault()

      document.body.appendChild(containerEl)

      app.mount(containerEl)
    })
  })
