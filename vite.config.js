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
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certPath),
        },
        hmr: {host},
        host,
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
