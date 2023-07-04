import { createApp } from 'vue'
import Datepicker from './Datepicker.vue'

const datepickerEls = document.querySelectorAll('[data-backend-datepicker]')

datepickerEls.forEach(el => {
  const inputEl = el.querySelector('input')

  if (inputEl?.disabled) {
    return
  }

  const containerEl = el.appendChild(document.createElement('div'))

  const app = createApp(Datepicker, {
    targetEl: el,
  })

  app.mount(containerEl)
})
