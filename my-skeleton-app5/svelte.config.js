import adapter from '@sveltejs/adapter-static';
import { vitePreprocess } from '@sveltejs/vite-plugin-svelte';

/** @type {import('@sveltejs/kit').Config} */
const config = {
    extensions: ['.svelte'],
    preprocess: [vitePreprocess()],
    
    kit: {
        // Replace adapter-auto with adapter-static
        adapter: adapter({
            // Static adapter options can be added here
        }),

        // ... other options
    }
};
export default config;
