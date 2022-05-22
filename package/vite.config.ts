import { defineConfig } from 'vite'
import path from 'path'

export default defineConfig({
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: './public/dist',
    rollupOptions: {
      input: '/resources/scripts/main.ts',
    },
  },
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