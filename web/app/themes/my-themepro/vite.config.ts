import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [tailwindcss()],
  build: {
    outDir: 'build',
    rollupOptions: {
      input: {
        main: 'src/ts/main.ts',
      },
      output: {
        entryFileNames: 'assets/js/[name].js',
        assetFileNames: ({ name }) => {
          if (/\.css$/.test(name ?? '')) return 'assets/css/[name][extname]'
          return 'assets/[name][extname]'
        },
      },
    },
  },
})
