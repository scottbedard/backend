// styles
import '../styles/main.scss'

// raw js
import './dark-mode'

// components
import alert from './alert'
import datefield from './datefield'
import table from './table'

document.addEventListener('alpine:init', () => {
  const { Alpine }: any = window

  Alpine.data('alert', alert)
  Alpine.data('datefield', datefield)
  Alpine.data('table', table)
})
