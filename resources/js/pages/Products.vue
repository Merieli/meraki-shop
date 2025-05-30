<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

// Importando os componentes criados
import ProductCard from '@/components/ProductCard.vue';
import TopBanner from '@/components/TopBanner.vue';

// Dados mockados de produtos
const products = ref([
    {
        id: 1,
        name: 'Tênis Esportivo Pro',
        price: 299.9,
        category: 'Calçados',
        image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
        inStock: true,
    },
    {
        id: 2,
        name: 'Camiseta Básica',
        price: 79.9,
        category: 'Roupas',
        image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab',
        inStock: true,
    },
    {
        id: 3,
        name: 'Relógio Inteligente',
        price: 499.9,
        category: 'Acessórios',
        image: 'https://images.unsplash.com/photo-1546868871-7041f2a55e12',
        inStock: false,
    },
    {
        id: 4,
        name: 'Mochila Resistente',
        price: 159.9,
        category: 'Acessórios',
        image: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62',
        inStock: true,
    },
    {
        id: 5,
        name: 'Óculos de Sol',
        price: 129.9,
        category: 'Acessórios',
        image: 'https://images.unsplash.com/photo-1572635196237-14b3f281503f',
        inStock: true,
    },
    {
        id: 6,
        name: 'Fones de Ouvido',
        price: 199.9,
        category: 'Eletrônicos',
        image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e',
        inStock: true,
    },
]);
</script>

<template>
    <Head title="Products">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <!-- Banner de linha no topo usando o componente TopBanner -->
    <TopBanner
        promoMessage="🔥 FRETE GRÁTIS para compras acima de R$ 200"
        cardLastDigits="2345"
        addressSummary="Av. P********, 1500 - Apto 42 - São Paulo, SP"
    />

    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <header class="mb-6 w-full max-w-[1200px] text-sm not-has-[nav]:hidden lg:max-w-6xl">
            <nav class="flex items-center justify-between gap-4">
                <h1 class="text-2xl font-bold">Meraki Shop</h1>
                <div class="flex items-center gap-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="flex items-center justify-center gap-4 rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Olá {{ $page.props.auth.user.name }}

                        <Avatar>
                            <AvatarImage :src="$page.props.auth.user.avatar ?? ''" alt="@unovue" />
                            <AvatarFallback>CN</AvatarFallback>
                        </Avatar>
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                        >
                            Log in
                        </Link>
                    </template>
                </div>
            </nav>
        </header>
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-[1200px] flex-col overflow-hidden rounded-lg lg:max-w-6xl">
                <h2 class="mb-6 text-2xl font-semibold">Nossos Produtos</h2>

                <!-- Grid de produtos usando o componente ProductCard -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <ProductCard v-for="product in products" :key="product.id" :product="product" />
                </div>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
