import { defineConfig } from 'vite'
import path from 'path'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: './public/dist',
    rollupOptions: {
      input: '/resources/scripts/main.ts',
    },
  },
  plugins: [
    vue(),
  ],
  resolve: {
    alias: [
      {
        find: '@',
        replacement: path.resolve(__dirname, 'resources/scripts'),
      },
    ],
  },
  server: {
    hmr: {
      host: 'localhost',
    },
  },
})