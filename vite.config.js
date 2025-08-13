import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',  // Permite acesso externo (fora do container)
        port: 5173,        // Porta padrão do Vite
        watch: {
            usePolling: true, // Para detectar mudanças em sistemas de arquivos compartilhados (ex: WSL, Docker volumes)
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ]
});
