import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { local } from 'laravel-vite-plugin/fonts';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Self-hosted from resources/fonts (Latin subsets, woff2 only, originally
            // fetched from Bunny Fonts). No visitor request ever goes to a font CDN and
            // the build does not need the network. Preload only what paints above the fold.
            fonts: [
                local('Fraunces', {
                    variants: [
                        { src: 'resources/fonts/fraunces-600-normal.woff2', weight: 600 },
                        { src: 'resources/fonts/fraunces-700-normal.woff2', weight: 700 },
                    ],
                    fallbacks: ['Georgia', 'serif'],
                    preload: [{ weight: 600 }],
                }),
                local('Inter', {
                    variants: [
                        { src: 'resources/fonts/inter-400-normal.woff2', weight: 400 },
                        { src: 'resources/fonts/inter-500-normal.woff2', weight: 500 },
                        { src: 'resources/fonts/inter-600-normal.woff2', weight: 600 },
                    ],
                    fallbacks: ['system-ui', 'sans-serif'],
                    preload: [{ weight: 400 }],
                }),
            ],
        }),
    ],
});
