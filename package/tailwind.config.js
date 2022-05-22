module.exports = {
  content: [
    './resources/**/*.{js,jsx,ts,tsx}',
    './resources/**/*.blade.php',
  ],
  darkMode: 'class',
  plugins: [],
  theme: {
    extend: {},
    fontFamily: {
      mono: '"Source Code Pro", ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
      sans: 'Quicksand, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
    },
  },
}
