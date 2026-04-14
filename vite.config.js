import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/public.css',
                'resources/css/builder.css',
                'resources/js/app.js',
                'resources/js/public/site.js',
                'resources/js/builder/index.js',
            ],
            refresh: true,
        }),
    ],
});
