import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [tailwindcss()],
  esbuild: {
    jsx: 'automatic',
    jsxImportSource: 'react',
  },
  build: {
    outDir: 'build',
    rollupOptions: {
      input: {
        main: 'src/ts/main.ts',
        react: 'src/react/main.tsx',
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
