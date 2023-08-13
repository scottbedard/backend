import { ButtonTheme, LucideIcon } from '@/types'
import { createApp } from 'vue'
import { error } from '@/utils/logging'
import Confirmation from '@/components/Confirmation.vue'

type Confirmation = {
  confirm: string
  icon: LucideIcon | null
  message: string
  theme: ButtonTheme
}

document
  .querySelectorAll<HTMLElement>('[data-backend-confirmation]')
  .forEach(confirmationEl => {
    // parse confirmation data
    let data: Confirmation = {
      confirm: 'Confirm',
      icon: null,
      message: '',
      theme: 'default',
    }

    try {
      data = JSON.parse(confirmationEl.dataset.backendConfirmation!)
    } catch {
      error('Failed to parse confirmation data', confirmationEl)
      return;
    }

    // create a factory for confirmation apps
    const mount = (data: Confirmation, confirmationEl: HTMLElement) => {
      // find the confirmation form
      const formEl = confirmationEl instanceof HTMLFormElement ? confirmationEl : confirmationEl.closest('form')

      if (!formEl) {
        error('Confirmation dialogs may only be used on or within <form> elements.')
        return
      }

      // create and mount the confirmation dialog
      const containerEl = document.body.appendChild(document.createElement('div'))

      const app = createApp(Confirmation, {
        ...data,
        onClose() {
          app.unmount()
          containerEl.remove()
        },
        onConfirm() {
          const action = confirmationEl.dataset.backendAction

          if (action) {
            const actionEl = document.createElement('input')
            actionEl.setAttribute('name', 'action')
            actionEl.setAttribute('type', 'hidden')
            actionEl.setAttribute('value', action)
            formEl.appendChild(actionEl)
          }

          formEl.submit()
        },
      })

      app.mount(containerEl)
    }

    // listen for the relevant event and trigger confirmation
    const eventName = confirmationEl instanceof HTMLFormElement ? 'submit' : 'click'

    confirmationEl.addEventListener(eventName, e => {
      e.preventDefault()

      mount(data, confirmationEl)
    })
  })
