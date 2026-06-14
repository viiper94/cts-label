import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/admin.scss',
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/release_player.js',
                'resources/js/feedback_player.js',
            ],
            refresh: true,
        }),
    ],
    define: {
        global: 'window',
    },
    server: {
        host: '0.0.0.0',   // required in Docker
        port: 5173,
        strictPort: true,
        cors: true,
        hmr: {
            host: 'cts-label.local',  // what your browser connects to
            port: 5173,
        },
    },
});