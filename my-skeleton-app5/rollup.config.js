import svelte from 'rollup-plugin-svelte';
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import { terser } from 'rollup-plugin-terser';

export default {
    input: 'src/main.js', // Your main JavaScript file
    output: {
        file: 'public/build/bundle.js', // Output file
        format: 'iife', // Immediately-invoked function expression
        name: 'app'
    },
    plugins: [
        svelte({
            // tell the svelte plugin where our svelte files are located
            include: 'src/**/*.svelte',
            // Optionally, preprocess styles, etc.
        }),
        // resolve external modules from node_modules
        resolve({
            browser: true,
            dedupe: ['svelte']
        }),
        commonjs(), // Convert CommonJS modules to ES6
        terser() // Minify the bundle
    ]
};
