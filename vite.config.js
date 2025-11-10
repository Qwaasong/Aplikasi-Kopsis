import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',   // ← ini kuncinya
        port: 5173,
        hmr: {
            host: '192.168.0.101' // IP laptop Anda (bukan 127.0.0.1)
        },

        cors: {
            origin: 'http://192.168.0.101:8000',
            credentials: true
        }
    },
});
