import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel(['resources/js/app.tsx']),
        react(),
    ],
    resolve: {
        alias: {
            '@pages': path.resolve(__dirname, 'resources/js/pages'),
            "@page-paths": path.resolve(__dirname, 'resources/js/routes/page-paths.ts'),
            "@hooks": path.resolve(__dirname, 'resources/js/hooks'),
            "@helpers": path.resolve(__dirname, 'resources/js/helpers'),
            "@interfaces-types": path.resolve(__dirname, 'resources/js/interfaces-types'),
            "@redux": path.resolve(__dirname, 'resources/js/redux'),
            "@responses": path.resolve(__dirname, 'resources/js/responses'),
            "@scss": path.resolve(__dirname, 'resources/scss'),
            "@components": path.resolve(__dirname, 'resources/js/components'),
            "@images": path.resolve(__dirname, 'resources/images')
        },
    },
});
