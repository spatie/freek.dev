import {defineConfig} from 'vite'
import laravel from 'laravel-vite-plugin'
import fs from 'fs';
import { resolve } from 'path';
import { homedir } from 'os';

let host = 'freek.dev.test'
let homeDirectory = homedir();

serverConfig = {
    https: {
        key: fs.readFileSync(resolve(homeDirectory, `.config/valet/Certificates/${host}.key`)),
        cert: fs.readFileSync(resolve(homeDirectory, `.config/valet/Certificates/${host}.crt`)),
    },
    hmr: {
        host: host,
    },
    host: host,
};

export default defineConfig({
    server: serverConfig,
    plugins: [
        laravel([
            'resources/js/app.js',
        ]),
    ],
})
