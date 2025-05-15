import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  title: "Meraki Shop",
  description: "Um e-commerce de produtos",
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config

    search: {
      provider: 'local'
    },

    nav: [
      { text: 'Home', link: '/' },
      { text: 'Examples', link: '/markdown-examples' }
    ],

    sidebar: [
      {
        text: 'Como Documentar',
        link: '/docs-how-prepare'
      },
      {
        text: '📄 Requisitos',
        collapsed: true,
        items: [
          { text: 'PRD', link: '/prd' },
        ]
      },
      {
        text: '📄 Decisões Técnicas',
        collapsed: true,
        items: [
          { text: '[ADR] Markdown Examples', link: '/markdown-examples' },          
        ]
      },
    ],

    footer: {
      message: 'Released under the MIT License.',
      copyright: 'Copyright © 2025- Meriéli Manzano'
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/Merieli/meraki-shop' }
    ],

  }
})
