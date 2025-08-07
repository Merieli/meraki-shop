import { defineConfig } from 'vitepress';

const route = {
    requirements: '/requirements',
    designArch: '/design-arch',
    getStarted: '/get-started',
} as const;

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: 'Meraki Shop',
    description: 'Um e-commerce de produtos',
    srcDir: 'src',
    themeConfig: {
        logo: 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/meraki-shop-only-logo.png',

        search: {
            provider: 'local',
        },

        nav: [
            { text: 'Home', link: '/' },
            { text: 'Examples', link: '/markdown-examples' },
        ],

        sidebar: [
            {
                text: 'Getting started',
                collapsed: false,
                link: route.requirements + '/prd',
                items: [
                    { text: 'Introduction', link: route.getStarted + '/introduction' },
                    { text: 'Quick Start', link: route.getStarted + '/quick-start' },
                    { text: 'Composition', link: route.getStarted + '/composition' },
                    {
                        text: 'Preview',
                        link: route.getStarted + '/preview',
                    },
                ],
            },
            {
                text: '📄 Requisitos e Produto',
                collapsed: false,
                link: route.requirements + '/prd',
                items: [{ text: 'PRD', link: route.requirements + '/prd' }],
            },
            {
                text: '🎨 Design e Arq.',
                collapsed: false,
                items: [{ text: 'Diagrama ER', link: route.designArch + '/diagram-er' }],
            },
            {
                text: '⚙️ Decisões Técnicas',
                collapsed: false,
            },
        ],

        footer: {
            message: 'Released under the MIT License.',
            copyright: 'Copyright © 2025- Meriéli Manzano',
        },

        socialLinks: [{ icon: 'github', link: 'https://github.com/Merieli/meraki-shop' }],
    },

    markdown: {
        config(md) {
            const defaultRender = md.renderer.rules.fence;
            if (!defaultRender) return console.error('Não foi possível preparar o mermaid');

            md.renderer.rules.fence = (tokens, idx, options, env, self) => {
                const token = tokens[idx];
                if (token.info === 'mermaid') {
                    return `<Mermaid code="${token.content.replace(/"/g, '&quot;')}" />`;
                }
                return defaultRender(tokens, idx, options, env, self);
            };
        },
    },
});
