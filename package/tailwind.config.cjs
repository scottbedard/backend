const colors = require('tailwindcss/colors')

const screens = {
  'xs': '480px',
  'sm': '640px',
  'md': '768px',
  'lg': '1024px',
  'xl': '1280px',
  '2xl': '1536px',
}

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '../sandbox/**/*.blade.php',
    './client/**/*.{ts,vue}',
    './resources/**/*.blade.php',
  ],
  theme: {
    colors: {
      black: '#000',
      current: 'currentColor',
      danger: colors.rose,
      gray: colors.slate,
      primary: colors.blue,
      secondary: colors.blue,
      success: colors.emerald,
      transparent: 'transparent',
      warning: colors.yellow,
      white: '#fff',
    },
    extend: {
      fontFamily: {
        mono: '"Source Code Pro", ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
        sans: 'Quicksand, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
      },
    },
    screens: screens,
  },
  plugins: [
    require('@tailwindcss/container-queries'),
  ],
}
