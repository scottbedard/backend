import alpine from './alpine'

/**
 * <x-backend::alert>
 * 
 * @see package/resources/views/components/layout/alerts.blade.php
 */
export default alpine(() => {
  return {
    acknowledged: false,

    timeout: 0,

    acknowledge() {
      this.acknowledged = true
    },

    init() {
      this.resume()
    },

    pause() {
      clearTimeout(this.timeout)
    },

    resume() {
      this.timeout = setTimeout(() => this.acknowledge(), 5000)
    },
  }
})
