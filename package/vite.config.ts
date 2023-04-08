import { defineConfig } from 'vite'
import autoImport from 'unplugin-auto-import/vite'
import fs from 'fs'
import path from 'path'
import vue from '@vitejs/plugin-vue'

const resolve = (p: string) => path.resolve(__dirname, '../sandbox', p)
const envPath = resolve('.env')
const envBackupPath = resolve('.env.backup')

// https://vitejs.dev/config/
export default defineConfig({
  base: '/',
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: resolve('../sandbox/public/vendor/backend'),
    rollupOptions: {
      input: {
        main: 'client/main.ts',
        list: 'client/plugins/list/index.ts',
      },
    },
  },
  plugins: [
    vue(),
    autoImport({
      cache: true,
      dts: true,
      include: [
        /\.[tj]sx?$/, // .ts, .tsx, .js, .jsx
        /\.vue$/, /\.vue\?vue/, // .vue
      ],
      imports: ['vue'],
      vueTemplate: true,
    }),
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
