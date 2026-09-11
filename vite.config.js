import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Self-hosted at build time so no visitor IP goes to a font CDN,
            // and the CSS is inlined instead of a render-blocking third-party request.
            fonts: [
                bunny('Fraunces', { weights: [600, 700], fallbacks: ['Georgia', 'serif'] }),
                bunny('Inter', { weights: [400, 500, 600], fallbacks: ['system-ui', 'sans-serif'] }),
            ],
        }),
    ],
});
