const key = 'darkMode'

const dark = () => JSON.parse(localStorage.getItem(key) as any)

if (dark()) {
  document.documentElement.classList.add('dark')
}

document.querySelector('[data-toggle-dark-mode]')?.addEventListener('click', () => {
  const [addOrRemove, trueOrFalse] = dark()
    ? ['remove' as const, 'false']
    : ['add' as const, 'true']

  localStorage.setItem(key, trueOrFalse)

  document.documentElement.classList[addOrRemove]('dark')

  console.log({ addOrRemove, trueOrFalse });
})
