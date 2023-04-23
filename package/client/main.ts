import '@/style.scss'
import { Component, createApp } from 'vue'
import { createIcons, icons } from 'lucide'
import Form from './plugins/Form.vue'
import List from './plugins/List.vue'

// create any icons rendered by the server
createIcons({ icons })

// mount first-party plugin components
const plugins: Record<string, Component> = {
  form: Form,
  list: List,
}

document.querySelectorAll('[data-backend-plugin]').forEach(el => {
  const pluginName = el.getAttribute('data-backend-plugin');
  
  if (pluginName && pluginName in plugins) {
    const plugin = plugins[pluginName];
    const props = JSON.parse(el.getAttribute('data-backend-props') || '{}');

    createApp(plugin, props).mount(el)
  }
})

