import alpine from './alpine'

export default alpine(() => {
  return {
    dark: window.localStorage.getItem('dark') === '1',

    async toggle() {
      this.dark = !this.dark

      if (this.dark) {
        window.localStorage.setItem('dark', '1')

        document.documentElement.classList.add('dark')
      } else {
        window.localStorage.removeItem('dark')

        document.documentElement.classList.remove('dark')
      }
    }
  }
})
