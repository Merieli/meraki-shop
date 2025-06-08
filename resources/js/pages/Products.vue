<script setup lang="ts">
import AppFooter from '@/components/AppFooter.vue';
import AppHeader from '@/components/AppHeader.vue';
import CustomerTestimonials from '@/components/CustomerTestimonials.vue';
import ProductCard from '@/components/ProductCard.vue';
import TopBanner from '@/components/TopBanner.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const products = ref([
    {
        id: 1,
        name: 'Pro Sports Sneakers',
        price: 299.9,
        category: 'Footwear',
        image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
        inStock: true,
    },
    {
        id: 2,
        name: 'Basic T-Shirt',
        price: 79.9,
        category: 'Clothing',
        image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab',
        inStock: true,
    },
    {
        id: 3,
        name: 'Smart Watch',
        price: 499.9,
        category: 'Accessories',
        image: 'https://images.unsplash.com/photo-1546868871-7041f2a55e12',
        inStock: false,
    },
    {
        id: 4,
        name: 'Durable Backpack',
        price: 159.9,
        category: 'Accessories',
        image: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62',
        inStock: true,
    },
    {
        id: 5,
        name: 'Sunglasses',
        price: 129.9,
        category: 'Accessories',
        image: 'https://images.unsplash.com/photo-1572635196237-14b3f281503f',
        inStock: true,
    },
    {
        id: 6,
        name: 'Headphones',
        price: 199.9,
        category: 'Electronics',
        image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e',
        inStock: true,
    },
]);
</script>

<template>
    <Head title="Collectibles & Rare Action Figures | Meraki Shop">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="fixed top-0 left-0 z-50 w-full">
        <TopBanner cardLastDigits="2345" addressSummary="P******** Ave, 1500 - Apt 42 - San Francisco, CA" />
    </div>

    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 pt-20 text-[#1b1b18] lg:justify-center lg:p-8 lg:pt-24 dark:bg-[#0a0a0a]">
        <AppHeader />
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-[1200px] flex-col overflow-hidden rounded-lg lg:max-w-6xl">
                <div class="mb-12 text-left">
                    <h2 class="mb-3 text-3xl font-bold text-[#1b1b18] dark:text-white">Rare Collectibles & Action Figures</h2>
                    <p class="max-w-2xl text-[#555] dark:text-gray-300">
                        Exclusive, limited-edition collectibles for serious enthusiasts. Each item is authenticated and available for one-per-customer
                        purchase only. Secure your rare piece today before they're gone forever.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <ProductCard v-for="product in products" :key="product.id" :product="product" />
                </div>

                <CustomerTestimonials />
            </main>
        </div>
    </div>

    <AppFooter />
</template>
