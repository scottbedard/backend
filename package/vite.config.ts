import { defineConfig } from 'vite'
import fs from 'fs'
import path from 'path'
import vue from '@vitejs/plugin-vue'

const envPath = path.resolve(__dirname, '../sandbox/.env')
const envBackupPath = path.resolve(__dirname, '../sandbox/.env.backup')

// https://vitejs.dev/config/
export default defineConfig({
  base: '/',
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: 'public/dist',
    rollupOptions: {
      input: [
        'client/main.ts',
      ],
    },
  },
  plugins: [
    vue(),
    {
      name: 'backend',
      buildStart() {
        fs.cpSync(envPath, envBackupPath)
        fs.writeFileSync(envPath, `BACKEND_DEV=true\n${fs.readFileSync(envPath, 'utf-8')}`)
      },
      buildEnd() {
        fs.cpSync(envBackupPath, envPath)
        fs.rmSync(envBackupPath)
      },
    },
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'client'),
    },
  },
  server: {
    host: 'localhost',
    port: 3000,
  },
})
