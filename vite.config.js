import {defineConfig} from 'vite'
import laravel from 'laravel-vite-plugin'
import fs from 'fs';
import { resolve } from 'path';
import { homedir } from 'os';

let host = 'freek.dev.test'
let homeDirectory = homedir();
let key = fs.readFileSync(resolve(homeDirectory, `.config/valet/Certificates/${host}.key`))
let cert = fs.readFileSync(resolve(homeDirectory, `.config/valet/Certificates/${host}.crt`))

if (fs.existsSync(key) && fs.existsSync(cert)) {

    serverConfig = {
        https: {key, cert},
        hmr: {host},
        host: host,
    }
}

export default defineConfig({
    server: serverConfig,
    plugins: [
        laravel([
            'resources/js/app.js',
        ]),
    ],
})
