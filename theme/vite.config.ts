import path from 'node:path';
import type { UserConfig } from 'vite';
import { defineConfig } from 'vite';
import { visualizer } from 'rollup-plugin-visualizer';

export default defineConfig(async ({ mode }) => {
	const isProduction = mode === 'production';
	const assetsPath = path.resolve(__dirname, 'assets');

	if (!isProduction) {
		const fs = await import('node:fs');

		// Delete the assets folder in development mode
		if (fs.existsSync(assetsPath)) {
			fs.rmSync(assetsPath, { recursive: true, force: true });
			console.log('Assets folder deleted during development mode.');
		}
	}

	return {
		root: 'src',
		base: isProduction ? '/wp-content/themes/una-moehrke-theme/assets/' : '/',
		build: {
			outDir: path.resolve(__dirname, 'assets'),
			emptyOutDir: true,
			sourcemap: false,
			minify: 'esbuild',
			rollupOptions: {
				input: {
					main: 'src/ts/main.ts',
				},
				output: {
					entryFileNames: 'js/[name].js',
					chunkFileNames: 'js/[name]-[hash].js',
					manualChunks: {
						vendor: ['fullpage.js', 'fullpage.js/vendors/scrolloverflow', 'photoswipe'],
					},
					assetFileNames: (assetInfo) => {
						const name = assetInfo.name ?? '';

						if (name.endsWith('.css')) {
							return 'css/[name][extname]';
						}

						if (['.ttf', '.woff', '.woff2'].some((ext) => name.endsWith(ext))) {
							return 'fonts/[name][extname]';
						}

						if (['.png', '.jpg', '.jpeg', '.svg'].some((ext) => name.endsWith(ext))) {
							return 'images/[name][extname]';
						}

						return '[name][extname]';
					},
				},
			},
		},
		css: {
			devSourcemap: true,
			preprocessorOptions: {
				scss: {
					silenceDeprecations: ['import'],
					quietDeps: true,
				},
			},
		},
		server: {
			host: '0.0.0.0',
			port: 5173,
			strictPort: true,
			origin: 'http://localhost:5173',
			hmr: {
				host: 'localhost',
				port: 5173,
			},
		},
		resolve: {
			alias: {
				'@': path.resolve(__dirname, 'src'),
			},
		},
		plugins: [
			!!process.env.ANALYZE &&
				visualizer({
					filename: path.resolve(__dirname, 'stats.html'),
					gzipSize: true,
				}),
		],
	} satisfies UserConfig;
});
