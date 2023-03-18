import { defineConfig } from 'vite'
import fs from 'fs'
import path from 'path'
import vue from '@vitejs/plugin-vue'

const envPath = path.resolve(__dirname, '../sandbox/.env')
const envBackupPath = path.resolve(__dirname, '../sandbox/.env.backup')
const backendPath = path.resolve(__dirname, '../sandbox/public/vendor/backend')

// https://vitejs.dev/config/
export default defineConfig({
  base: '/',
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: path.resolve(__dirname, '../sandbox/public/vendor/backend'),
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
      buildEnd() {
        if (fs.existsSync(envBackupPath)) {
          fs.cpSync(envBackupPath, envPath)
          fs.rmSync(envBackupPath)
        }
      },
      buildStart() {
        fs.cpSync(envPath, envBackupPath)
        fs.writeFileSync(envPath, `BACKEND_DEV=true\n${fs.readFileSync(envPath, 'utf-8')}`)
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
