const colors = require('tailwindcss/colors')

module.exports = {
  content: [
    './resources/**/*.{js,jsx,ts,tsx}',
    './resources/**/*.blade.php',
  ],
  darkMode: 'class',
  plugins: [],
  theme: {
    colors: {
      black: '#000',
      current: 'currentColor',
      gray: colors.slate,
      primary: colors.blue,
      transparent: 'transparent',
      white: '#fff',
    },
    extend: {},
    fontFamily: {
      mono: '"Source Code Pro", ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
      sans: 'Quicksand, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
    },
  },
}
