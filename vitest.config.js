import vue from '@vitejs/plugin-vue';
import path from 'path';
import { defineConfig } from 'vitest/config';

export default defineConfig({
    plugins: [vue()],
    test: {
        globals: true,
        environment: 'jsdom',
        include: ['resources/js/**/__tests__/**/*.{test,spec}.{js,ts,vue}', 'tests/unit/**/*.{test,spec}.{js,ts,vue}'],
        exclude: ['**/node_modules/**', '**/dist/**'],
        coverage: {
            provider: 'v8',
            reporter: ['text', 'lcov', 'html'],
            include: ['resources/js/components/**/*.{js,ts,vue}'],
        },
        setupFiles: ['./tests/__setup__/setup-vitest.ts'],
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
});
