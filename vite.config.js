import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue'; 

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),              
        tailwindcss(),
    ],
    base: '/build/',
    server: {
        host: '127.0.0.1',
        // https: true,
        // host: '0.0.0.0',
        // hmr: {
        //     host: '1331x.com',
        //     protocol: 'wss',
        // },
    },
    build: {
        minify: 'esbuild', // Use esbuild for minification (built-in with Vite)
        // Alternative: minify: true, // Uses esbuild by default
        rollupOptions: {
            output: {
                // Create separate chunks for better caching
                manualChunks: {
                    vendor: ['vue', 'axios'],
                },
            },
        },
        // Additional optimization settings
        cssCodeSplit: true,           // Split CSS into separate files
        sourcemap: false,             // Disable sourcemaps in production for smaller files
        reportCompressedSize: false,  // Skip compressed size reporting for faster builds
        chunkSizeWarningLimit: 1000,  // Increase chunk size warning limit
    },
});