import { post } from './utils'

const attr = 'data-toggle-dark-mode'

document.querySelector(`[${attr}]`)?.addEventListener('click', async (e: Event) => {
  const { setting } = await post((e.target as Element)
    .closest(`[${attr}]`)!
    .getAttribute(attr)!, { key: 'dark-mode' })

  document.documentElement.classList[setting.value ? 'add' : 'remove']('dark')
})
