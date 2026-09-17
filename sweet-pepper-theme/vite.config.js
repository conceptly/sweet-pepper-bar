import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  // Relative base so built CSS/JS reference fonts and images next to
  // themselves in dist/assets, not at the site root (which 404s in WordPress).
  base: './',
  plugins: [],
  build: {
    // Generate manifest for PHP to read
    manifest: true,
    outDir: 'dist',
    assetsDir: 'assets',
    rollupOptions: {
      input: resolve(__dirname, 'src/main.js'),
    },
  },
  server: {
    // Required for Vite to work with local dev server
    cors: true,
    strictPort: true,
    port: 5173,
    hmr: {
      host: 'localhost',
    },
  },
});
