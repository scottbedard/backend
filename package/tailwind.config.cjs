const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './client/**/*.{ts,vue}',
  ],
  theme: {
    colors: {
      black: '#000',
      current: 'currentColor',
      danger: colors.rose,
      gray: colors.slate,
      primary: colors.blue,
      secondary: colors.blue,
      transparent: 'transparent',
      warning: colors.yellow,
      white: '#fff',
    },
    extend: {
      fontFamily: {
        sans: 'Quicksand, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
      },
    },
  },
  plugins: [],
}
