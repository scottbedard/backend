import { defineCustomElement } from 'vue'
import Button from './Button.ce.vue'
import Card from './Card.ce.vue'
import Input from './Input.ce.vue'

const BackendButton = defineCustomElement(Button)
const BackendCard = defineCustomElement(Card)
const BackendInput = defineCustomElement(Input)

export {
  BackendButton,
  BackendCard,
  BackendInput,
}

export function register() {
  customElements.define('backend-button', BackendButton)
  customElements.define('backend-card', BackendCard)
  customElements.define('backend-input', BackendInput)
}

register()