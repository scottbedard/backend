// styles
import '../styles/main.scss'

// raw js
import './dark-mode'

// components
import table from './table'

document.addEventListener('alpine:init', () => {
  const { Alpine }: any = window

  Alpine.data('table', table);
});
