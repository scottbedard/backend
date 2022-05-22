import { post } from './utils'

const attr = 'data-toggle-dark-mode'

const selector = `[${attr}]`

const toggle = async (e: Event) => {
  const route = (e.target as HTMLElement).closest(selector)!.getAttribute(attr)!;

  await post(route, { key: 'dark-mode' })
}

document.querySelector(selector)?.addEventListener('click', toggle)
