import { defineConfig } from 'vite';
import { resolve } from 'path';

/*
 * Hover only where a pointer can hover (author, 29 Sep 2026). On a phone a tap leaves the tapped
 * button in its :hover look until the next tap elsewhere — "buttons turn to the hover state".
 * Every :hover rule in the build is wrapped in HOVER_QUERY, so phones never see it; tablets keep
 * it when a pencil or trackpad can hover. Rules already inside a hover query are normalised to the
 * same query, and a selector list that mixes :hover with :active / :focus is split, so the pressed
 * state still reaches phones. Tune the query here, in one place.
 */
const HOVER_QUERY = '(any-hover: hover)';

function hoverWhereItExists() {
  return {
    postcssPlugin: 'sweet-pepper-hover-guard',
    Once(root, { AtRule }) {
      const isHoverMedia = (node) => node.type === 'atrule' && node.name === 'media' && /hover\s*:\s*hover/.test(node.params);
      root.walkAtRules('media', (at) => {
        if (/\(\s*(any-)?hover\s*:\s*hover\s*\)/.test(at.params)) {
          at.params = at.params.replace(/\(\s*(any-)?hover\s*:\s*hover\s*\)/g, HOVER_QUERY);
        }
      });
      const rules = [];
      root.walkRules((rule) => {
        if (!rule.selector.includes(':hover')) return;
        for (let p = rule.parent; p; p = p.parent) {
          if (isHoverMedia(p) || (p.type === 'atrule' && /keyframes$/.test(p.name))) return;
        }
        rules.push(rule);
      });
      rules.forEach((rule) => {
        const hover = rule.selectors.filter((s) => s.includes(':hover'));
        const rest = rule.selectors.filter((s) => !s.includes(':hover'));
        const guard = new AtRule({ name: 'media', params: HOVER_QUERY });
        guard.append(rule.clone({ selectors: hover }));
        if (rest.length) {
          rule.selectors = rest;
          rule.after(guard);
        } else {
          rule.replaceWith(guard);
        }
      });
    },
  };
}
hoverWhereItExists.postcss = true;

export default defineConfig({
  // Relative base so built CSS/JS reference fonts and images next to
  // themselves in dist/assets, not at the site root (which 404s in WordPress).
  base: './',
  plugins: [],
  css: {
    postcss: {
      plugins: [hoverWhereItExists()],
    },
  },
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
