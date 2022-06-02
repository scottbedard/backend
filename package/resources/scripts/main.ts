// styles
import '../styles/base.scss'
import '../styles/checkbox.scss'

// raw js
import './dark-mode'

// components
import table from './table'

document.addEventListener('alpine:init', () => {
  const { Alpine }: any = window

  Alpine.data('table', table);
});
