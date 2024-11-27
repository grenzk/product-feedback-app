import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import symfonyPlugin from 'vite-plugin-symfony'
import vue from '@vitejs/plugin-vue'
import AutoImport from 'unplugin-auto-import/vite'

export default defineConfig({
  plugins: [
    vue({
      script: { globalTypeFiles: ['./assets/vue/global.d.ts'] }
    }),
    AutoImport({
      dts: './assets/vue/auto-imports.d.ts',
      imports: ['vue']
    }),
    symfonyPlugin()
  ],
  build: {
    rollupOptions: {
      input: {
        main: './assets/main.ts'
      }
    }
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./assets/vue', import.meta.url))
    }
  }
})
