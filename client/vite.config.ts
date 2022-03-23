import { defineConfig } from 'vite'
import path from 'path'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  base: '/vendor/backend/dist/',
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: './public/dist',
    rollupOptions: {
      input: '/main.ts'
    },
  },
  plugins: [
    vue(),
  ],
  resolve: {
    alias: [
      {
        find: '@',
        replacement: path.resolve(__dirname),
      },
    ],
  },
  server: {
    hmr: {
      host: 'localhost',
    },
  },
})