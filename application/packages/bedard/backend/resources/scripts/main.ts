// styles
import '../styles/main.scss'

// components
import customAlert from './custom-alert'
import darkMode from './dark-mode'
import datefield from './date-field'
import selectField from './select-field'
import table from './table'

document.addEventListener('alpine:init', () => {
  const { Alpine }: any = window

  Alpine.data('customAlert', customAlert)
  Alpine.data('darkMode', darkMode)
  Alpine.data('dateField', datefield)
  Alpine.data('selectField', selectField)
  Alpine.data('table', table)
})
