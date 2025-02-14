import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/main.scss',
                'resources/js/oneui/app.js',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
