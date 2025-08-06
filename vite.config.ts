import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { defineConfig } from 'vite';
import crypto from 'crypto';

// Polyfill crypto.hash for Node.js 18 compatibility
if (!crypto.hash) {
    (crypto as any).hash = function(algorithm: string, data: string | Buffer, outputEncoding: string = 'hex') {
        return crypto.createHash(algorithm).update(data).digest(outputEncoding as any);
    };
}

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
