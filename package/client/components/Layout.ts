import { defineCustomElement } from 'vue'
import Layout from './Layout.ce.vue'

const BackendLayout = defineCustomElement(Layout)

export { BackendLayout }

export function register() {
  customElements.define('backend-layout', BackendLayout)
}

register()
