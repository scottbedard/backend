import '@/style.scss'
import { createIcons, icons } from 'lucide'
import form from './plugins/form/index'
import grid from './scripts/grid'
import list from './plugins/list/index'

// create any icons rendered by the server
createIcons({ icons })

// execute first-party plugins
const plugins: Record<string, (el: HTMLElement) => void> = {
  form,
  list,
}

document.querySelectorAll('[data-backend]').forEach(async (el) => {
  const pluginName = el.getAttribute('data-backend');
  
  if (pluginName && pluginName in plugins && el instanceof HTMLElement) {
    const plugin = plugins[pluginName]
    
    plugin(el)
  }
})

// mount first-party components
const scripts: Record<string, (el: HTMLElement) => void> = {
  grid,
}

document.querySelectorAll('[data-backend-script]').forEach(async (el) => {
  const scriptName = el.getAttribute('data-backend-script');
  
  if (scriptName && scriptName in scripts && el instanceof HTMLElement) {
    const script = scripts[scriptName]
    
    script(el)
  }
})