import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/Pages/Welcome.vue', 'resources/js/Pages/Auth/Login.vue'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        require('@vitejs/plugin-vue')()
    ],
    server: {
        host: true,
        hmr: {
            host: 'localhost'
        },
    },
});
