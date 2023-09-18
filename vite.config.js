import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/Pages/Welcome.vue',
                'resources/js/Pages/Auth/Login.vue',
                'resources/js/Pages/Auth/Register.vue',
                'resources/js/Pages/MainTask/CreateMainTask.vue',
                'resources/js/Pages/MainTask/IndexMainTask.vue',
                'resources/js/Pages/MainTask/ShowMainTask.vue'
            ],
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
    ],
    server: {
        host: true,
        hmr: {
            host: 'localhost'
        },
    },
});
