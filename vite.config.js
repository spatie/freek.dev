import fs from 'fs';
import laravel from 'laravel-vite-plugin'
import {defineConfig} from 'vite'
import {homedir} from 'os';
import {resolve} from 'path';

let host = 'freek.dev.test'

let homeDirectory = homedir()
let keyPath = resolve(homeDirectory, `.config/valet/Certificates/${host}.key`)
let certPath = resolve(homeDirectory, `.config/valet/Certificates/${host}.crt`)
let serverConfig = {}

if (fs.existsSync(keyPath) && fs.existsSync(certPath)) {
    serverConfig = {
        hmr: {host},
        host,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certPath),
        },
    }
}

export default defineConfig({
    plugins: [
        laravel([
            'resources/js/app.js',
        ]),
    ],
    server: serverConfig,
})
