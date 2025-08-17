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
        host: '0.0.0.0',
        // https: true,
        // host: '0.0.0.0',
        // hmr: {
        //     host: '1331x.com',
        //     protocol: 'wss',
        // },
    },
});
