import { defineConfig } from 'vite'
import fs from 'fs'
import path from 'path'
import vue from '@vitejs/plugin-vue'

const resolve = (p: string) => {
  return process.env.GITHUB_ACTION
    ? path.resolve(__dirname, '..', p)
    : path.resolve(__dirname, '../sandbox', p)
}

const envPath = resolve('.env')
const envBackupPath = resolve('.env.backup')
const backendPath = resolve('public/vendor/backend')

// https://vitejs.dev/config/
export default defineConfig({
  base: '/',
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: resolve('public/vendor/backend'),
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
        if (fs.existsSync(envPath)) {
          fs.cpSync(envPath, envBackupPath)
          fs.writeFileSync(envPath, `BACKEND_DEV=true\n${fs.readFileSync(envPath, 'utf-8')}`)
        }
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
