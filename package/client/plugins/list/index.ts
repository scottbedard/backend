import { createApp } from 'vue'
import List from './List.vue'

export default function (el: HTMLElement) {
  const props = JSON.parse(el.getAttribute('data-backend-props') || '{}');

  createApp(List, props).mount(el)
}
