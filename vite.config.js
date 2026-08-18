import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/portfolio.js'],
            refresh: true,
            // Self-hosted through Bunny rather than a Google Fonts link, so the
            // page makes no third-party request at runtime.
            fonts: [
                bunny('Bricolage Grotesque', { weights: [600, 700, 800] }),
                bunny('Instrument Sans', { weights: [400, 500, 600] }),
                bunny('IBM Plex Mono', { weights: [400, 500, 600] }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
